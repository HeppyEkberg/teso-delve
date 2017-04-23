<?php
    $routeName = Route::getCurrentRoute()->getName();
?>

<div class="row">

    <div class="col-md-6">
        <div class="row character-name">
            <div class="col-md-2">
                <img title="{{trans('alliance.'.$character->allianceId)}}" src="/gfx/alliance_{{$character->allianceId}}.png">
            </div>
            <div class="col-md-10">
                <h1>{{$character->name}}</h1>
                <h3>{{trans('eso.races.'.$character->raceId.'.name')}} {{trans('eso.classes.'.$character->classId.'.name')}}</h3>
            </div>
        </div>
    </div>
</div>

<ul class="nav nav-tabs">
    <li role="presentation" class="{{ $routeName == 'characters.show' ? 'active' : '' }}"><a href="{{route('characters.show', [$character->id])}}">Character</a></li>
    <li role="presentation" class="{{ $routeName == 'character.inventory' ? 'active' : '' }}"><a href="{{route('character.inventory', [$character->id])}}">Inventory</a></li>
    <li role="presentation" class="{{ $routeName == 'character.skills' ? 'active' : '' }}"><a href="{{route('character.skills', [$character])}}">Skills</a></li>
    <li role="presentation" class="disabled"><a>Champion points</a></li>
    <li role="presentation" class="dropdown {{ $routeName == 'character.crafting' ? 'active' : '' }}">
        <a class="dropdown-toggle" data-toggle="dropdown" href="javascript: void(0)" role="button" aria-haspopup="true" aria-expanded="false">
            Crafting <span class="caret"></span>
        </a>
        <ul class="dropdown-menu">
            <li><a href="{{route('character.itemstyles', [$character->id])}}">Motifs</a></li>
            <li><a href="{{route('character.crafting', [$character->id, \App\Enum\CraftingType::BLACKSMITHING])}}">Blacksmithing</a></li>
            <li><a href="{{route('character.crafting', [$character->id, \App\Enum\CraftingType::CLOTHIER])}}">Clothier</a></li>
            <li><a href="{{route('character.crafting', [$character->id, \App\Enum\CraftingType::WOODWORKING])}}">Woodworking</a></li>
        </ul>
    </li>
</ul>