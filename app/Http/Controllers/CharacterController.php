<?php namespace App\Http\Controllers;


use App\Enum\BagType;
use App\Enum\SetType;
use App\Model\Character;
use App\Model\ItemStyle;
use App\Model\Set;
use App\Model\SkillLine;
use App\Repository\CraftingRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;

class CharacterController
{

    public function show(Character $character) {
        $user = Auth::user();

        $equippedItems = $character->items()
            ->where('user_items.bagEnum', BagType::WORN)
            ->with('set.bonuses')
            ->get();

        return view('character.show', compact('character', 'equippedItems', 'user'));
    }

    public function delete(Character $character) {
        if(Auth::id() != $character->userId) {
            abort(403);
        }

        $character->delete();
        return redirect()->back();
    }

    public function restore($character_id) {
        $character = Character::onlyTrashed()->find($character_id);
        if(Auth::id() != $character->userId) {
            abort(403);
        }

        $character->restore();
        return redirect()->back();
    }

    public function skills(Character $character, SkillLine $skillLine) {
        $skilltypes = SkillLine::where('lang', App::getLocale())
            ->get()
            ->groupBy('skilltypeEnum');

        $showSkillLine = $skillLine;

        $abilities = $showSkillLine->abilities()
            ->whereNull('parent_id')
            ->where('lang', App::getLocale())
            ->with('morphs')
            ->orderBy('index')
            ->orderBy('morph')
            ->get();

        $characterAbilities = $character->abilities->keyBy('id');
        $spentSkillpoints = $characterAbilities->pluck('pivot')->sum('skillpoints');

        return view('character.skills', compact('character', 'skilltypes', 'showSkillLine', 'abilities', 'characterAbilities', 'spentSkillpoints'));
    }

    public function index() {
        $user = Auth::user();
        $characters = $user->characters()
            ->with('craftingTraits', 'userItems', 'meta')
            ->orderByRaw('level DESC, name')
            ->get();

        $removedCharacters = $user->characters()
            ->with('craftingTraits', 'userItems', 'meta')
            ->onlyTrashed()
            ->orderByRaw('level DESC, name')
            ->get();

        return view('character.index', compact('characters', 'removedCharacters'));
    }

    public function indexDeleted() {
        $user = Auth::user();

        $removedCharacters = $user->characters()
            ->with('craftingTraits', 'userItems', 'meta')
            ->onlyTrashed()
            ->orderByRaw('level DESC, name')
            ->get();

        $characters = $removedCharacters;

        return view('character.index', compact('characters', 'removedCharacters'));
    }

    public function itemStyles(Character $character) {
        $knownItemStyles = $character->itemStyles;
        $itemStyles = ItemStyle::where('craftable', 1)->get();

        return view('character.itemStyles', compact('character', 'knownItemStyles', 'itemStyles'));
    }

    public function craftingResearch(Character $character, $craftingTypeEnum, CraftingRepository $craftingRepository) {
        $user = Auth::user();
        $characters = new Collection([$character]);
        if($user and Auth::id() == $character->userId) {
            $user = Auth::user();
            $characters = $user->characters;
        }

        $researchGrid = $craftingRepository->researchGrid($user, $craftingTypeEnum, $character);

        $craftingTraits = $character->craftingTraits()
            ->where('craftingTypeEnum', $craftingTypeEnum)
            ->get();

        $traitsGrouped = $craftingTraits->groupBy('researchLineIndex');

        $craftableSets = Set::where('setTypeEnum', SetType::CRAFTED)
            ->with('meta')
            ->get();

        return view('character.crafting', compact('character', 'researchGrid', 'craftableSets', 'craftingTypeEnum', 'craftingTraits', 'traitsGrouped', 'characters'));
    }

    public function inventory(Character $character, $bagEnum = null) {
        $items = $character->items->where('pivot.bagEnum', is_null($bagEnum) ? BagType::BACKPACK : $bagEnum);
        $gold = $character->currency;
        $bagSize = $character->getMeta('bag_' . BagType::BACKPACK);

        return view('inventory.index', compact('character', 'bagEnum', 'items', 'gold', 'bagSize'));
    }

}
