<?php namespace App\Http\Controllers\Admin;

use App\Enum\CraftingItemsLevels;
use App\Enum\CraftingType;
use App\Enum\ItemStyleChapter;
use App\Enum\ItemType;
use App\Http\Controllers\Controller;
use App\Model\CraftingItem;
use App\Model\CraftingTrait;
use App\Model\Item;
use App\Model\ItemStyle;
use App\Model\ItemStyleChapter as ItemStyleChapterModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Symfony\Component\HttpFoundation\File\UploadedFile;

class CraftingController extends Controller
{

    public function itemStyles() {
        $itemStyles = ItemStyle::all();
        $chapters = ItemStyleChapter::order();
        $motifs = Item::where('type', 8)->where('lang', config('constants.default-language'))->orderBy('name')->get();

        return view('admin.crafting.itemStyles', compact('itemStyles', 'chapters', 'motifs'));
    }

    public function itemStyle(ItemStyle $itemStyle) {
        $assignedMotifs = ItemStyleChapterModel::all()->pluck('itemId')->toArray();

        $motifs = Item::where('type', 8)
            ->where('lang', config('constants.default-language'))
            ->orderBy('name')
            ->get();

        $chapters = $itemStyle->chapters;

        $items = Item::where('itemStyleId', $itemStyle->id)
            ->take(50)
            ->get();

        $materials = Item::where('type', 44)
            ->orderBy('name')
            ->where('lang', App::getLocale())
            ->get();

        return view('admin.crafting.itemStyle', compact('itemStyle', 'motifs', 'chapters', 'assignedMotifs', 'items', 'materials'));
    }

    public function uploadImages(Request $request, ItemStyle $itemStyle) {
        $files = $request->files->all();

        foreach($files as $file) {
            /** @var $file UploadedFile */
            $dir = public_path('gfx/item-style/' . $itemStyle->id . "");
            if(!is_dir($dir)) {
                mkdir($dir);
            }

            move_uploaded_file($file->getRealPath(), $dir ."/". $file->getClientOriginalName());
        }

        return '';
    }

    public function updateItemStyle(Request $request, ItemStyle $itemStyle) {
        $data = $request->get('itemStyle');
        $itemStyle->name = $data['name'];
        $itemStyle->location = $data['location'];
        $itemStyle->isHidden = isset($data['isHidden']);
        $itemStyle->craftable = isset($data['craftable']);
        $itemStyle->material_id = !empty($data['material_id']) ? $data['material_id'] : null;

        foreach($data['chapter'] as $chapterEnum => $itemId) {
            if(intval($itemId) === 0) {
                $itemStyle->chapters()->where('itemStyleChapterEnum', $chapterEnum)->where('itemStyleId', $itemStyle->id)->delete();
                continue;
            }

            $itemStyleChapter = $itemStyle->chapters->where('itemStyleChapterEnum', $chapterEnum)->first();
            if(is_null($itemStyleChapter)) {
                $itemStyleChapter = new ItemStyleChapterModel();
            }

            $itemStyleChapter->itemStyleChapterEnum = $chapterEnum;
            $itemStyleChapter->itemId = $itemId;
            $itemStyleChapter->itemStyleId = $itemStyle->id;
            $itemStyleChapter->save();
        }

        $itemStyle->save();


        return redirect()->route('admin.crafting.item-style.edit', [$itemStyle]);
    }

    public function updateStyles(Request $request) {
        $itemStyles = ItemStyle::all();
        foreach($request->get('itemStyle') as $id => $data) {
            /** @var ItemStyle $itemStyle */
            $itemStyle = $itemStyles->where('id', $id)->first();
            $itemStyle->name = $data['name'];
            $itemStyle->craftable = isset($data['craftable']);
            $itemStyle->save();
        }

        return redirect()->back();
    }

    public function craftingTable($smithingTypeEnum) {
        $craftingItems = CraftingItem::where('smithingTypeEnum', $smithingTypeEnum)
            ->orderBy('level')
            ->orderBy('championLevel')
            ->get();

        $craftingTrait = CraftingTrait::where('craftingTypeEnum', $smithingTypeEnum)
            ->where('characterId', 1)
            ->select('researchLineIndex', 'image', 'name')
            ->distinct()
            ->get();

        $researchLineIndexes = $craftingTrait->keyBy('researchLineIndex');

        $craftingTypeEnum = $smithingTypeEnum;

        $materials = Item::where('type', ItemType::material($smithingTypeEnum))
            ->where('lang', config('constants.default-language'))
            ->orderBy('name')
            ->get();

        $levels = $craftingItems->groupBy('level');
        $cLevels = $craftingItems->groupBy('championLevel');

        return view('admin.crafting.crafting-table.edit', compact('craftingItems', 'researchLineIndexes', 'craftingTypeEnum', 'levels', 'cLevels', 'materials'));
    }

    public function updateCraftingTable(Request $request, $smithingTypeEnum) {

        $formdata = $request->get('crafting-items');

        $craftingItems = CraftingItem::where('smithingTypeEnum', $smithingTypeEnum)
            ->get();


        foreach($formdata as $level => $ci) {
            if(empty($ci['material'])) {
                continue;
            }

            foreach($ci as $researchLineIndex => $data) {

                if(intval($data['amount']) != 0) {
                    $champLevel = stripos($level, 'champ-') === false ? null : intval(str_ireplace('champ-', '', $level));
                    $level = stripos($level, 'champ-') === false ? $level : 50;

                    $craftingItem = $craftingItems->where('researchLineIndex', $researchLineIndex)
                        ->where('level', $level)
                        ->where('championLevel', $champLevel)
                        ->first();

                    if($craftingItem) {
                        $craftingItem->materialCount = intval($data['amount']);
                        $craftingItem->material_id = $ci['material'];
                        $craftingItem->save();
                    }
                }
            }
        }

        return redirect()->back();
    }

    public function populateCraftingItems() {
        CraftingItem::where('id', '>', 0)->delete();

        $smithingTypes = CraftingType::smithing();
        $craftingItemsLevel = new CraftingItemsLevels();
        $levels = $craftingItemsLevel->levels();

        $craftingTrait = CraftingTrait::select('craftingTypeEnum', 'researchLineIndex', 'image', 'name')
            ->distinct()
            ->get();

        $researchLineIndexes = $craftingTrait->groupBy('craftingTypeEnum');

        foreach($smithingTypes as $smithingType) {

            foreach($researchLineIndexes->get($smithingType) as $researchLineIndex) {

                foreach($levels as $level) {
                    $craftingItem = new CraftingItem();
                    $craftingItem->researchLineIndex = $researchLineIndex->researchLineIndex;
                    $craftingItem->level = $level[0];
                    $craftingItem->championLevel = $level[1];
                    $craftingItem->smithingTypeEnum = $smithingType;
                    $craftingItem->save();
                }
            }
        }
    }
}
