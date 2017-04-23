<?php namespace App\Repository;

use App\Enum\ItemStyleChapter;
use App\Enum\ItemTrait;
use App\Model\CraftingTrait;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;

class CraftingRepository
{

    public function researchGrid($user, $craftingEnumType, $character) {
        $traits = ItemTrait::matris();

        $researchLines = CraftingTrait::where('craftingTypeEnum', $craftingEnumType)
            ->get()
            ->groupBy('researchLineIndex')
            ->sort();

        $characters = Auth::id() == $character->userId ? $user->characters : new Collection([$character]);

        /*
         * Update the characters crafting traits that has finished researching.
         */
        CraftingTrait::whereIn('characterId', $characters->pluck('id'))
            ->where('researchDone_at', '<=', Carbon::now())
            ->where('isKnown', 0)
            ->update(['isKnown' => 1]);

        $characters->load(['craftingTraits' => function($query) use($craftingEnumType) {
            $query->where('craftingTypeEnum', $craftingEnumType);
        }, 'craftingTraits.character']);

        $craftingTraits = $characters->pluck('craftingTraits')->collapse();
        $crafting = new Collection();

        foreach($researchLines as $researchLineIndex => $researchLine) {
            $researchLineFirst = $researchLine->first();
            $typeData = [
                'researchLine' => $researchLineFirst,
                'traits' => [],
            ];

            foreach($traits as  $trait) {
                $cTraits = $craftingTraits->where('researchLineIndex', $researchLineFirst->researchLineIndex)->where('traitId', $trait);
                $data = [];
                $data['trait'] = $trait;
                $data['known'] = $cTraits->where('isKnown', 1);
                $data['characterKnown'] = $data['known']->where('characterId', $character->id);
                $data['researching'] = $cTraits->where('researchDone_at', '!=', null);
                $data['characterResearching'] = $data['researching']->where('characterId', $character->id);

                $typeData['traits'][$trait] = $data;
            }

            $crafting->put($researchLineIndex, $typeData);
        }

        $crafting = $crafting->toArray();
        ksort($crafting);

        return $crafting;
    }

}