<?php namespace App\Http\Controllers;


use App\Model\Dungeon;
use App\Model\Item;
use App\Model\ItemSale;
use App\Model\ItemStyleChapter;
use App\Model\Set;
use App\Model\ZoneSet;
use App\Objects\PriceCompareWeek;
use App\Objects\Zones;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\DB;

class ItemController
{

    public function index() {

    }

    public function showItemById($id) {
        $item = Item::find($id);
        if(empty($item->slug)) {
            return $this->show($item);
        }

        return redirect()->route('item.show', [$item], 301);
    }

    public function show(Item $item) {
        $user = Auth::user();
        $items = new Collection();
        $userItems = null;

        if($user) {
            $userItems = $user->items()->where('itemId', $item->id)->get();
            if ($userItems->count() > 0) {
                $item = $userItems->first();
                $item->pivot->count = $userItems->pluck('pivot')->sum('count');
            }

            $favourites = $user->favouriteSets
                ->pluck('setId')
                ->toArray();

            $items = $user->items
                ->where('setId', $item->setId);

            $characters = $user->characters->keyBy('id');

            $userItems = $user->items()->where('itemId', $item->id)->get();
        }

        $item->load('set.bonuses');
        $set = $item->set;

        $priceComparison = new PriceCompareWeek($item);

        $sales = Cache::remember('item_sales_'.$item->id, 60, function() use($item) {
            return $item->sales()
                ->with('guild')
                ->take(250)
                ->orderBy('sold_at', 'DESC')
                ->get();
        });

        return view('item.show', compact('item', 'favourites', 'items', 'set', 'priceComparison', 'sales', 'userItems', 'characters'));
    }

    public function ajaxShow(Item $item) {
        $set = $item->set;
        $items = new Collection();
        $itemStyleChapter = ItemStyleChapter::where('itemId', $item->id)->first();

        $user = Auth::user();
        if($user) {
            $userItems = $user->items()->where('itemId', $item->id)->get();
            if ($userItems->count() > 0) {
                $item = $userItems->first();

                $item->pivot->count = $userItems->pluck('pivot')->sum('count');
            }

            $characters = $user->characters()
                ->with('itemStyles')
                ->get();

            $items = $user->items;
        }

        $priceComparison = new PriceCompareWeek($item);

        return view('item.itembox', compact('item', 'set', 'items', 'characters', 'itemStyleChapter', 'priceComparison'));
    }

}
