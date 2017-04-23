<?php
$isKnown = $characterAbilities->has($ability->id);
foreach($ability->morphs as $morph) {
    if($isKnown == false and $characterAbilities->has($morph->id)) {
        $isKnown = true;
        break;
    }
}
?>

<div class="b-t-1 b-t-gray-light p-t-2">
    <div class="row">
        <div class="col-md-12">
            <a class="thumbnail no-bg pull-left m-r-2 text-center ability-icon {{ $isKnown ? 'ability-known' : 'ability-locked' }}">
                <img src="{{$ability->image}}">
                <i class="fa fa-lock fa-2x fa-stack"></i>
            </a>
            <h4 class="m-t-0">
                {{$ability->name}}
                @if($ability->isPassive)
                    ({{$characterAbilities->has($ability->id) ? $characterAbilities->get($ability->id)->pivot->skillpoints : 0}}/{{$ability->maxSkillpoints}})
                @endif
            </h4>
            <p>@include('character.partials.skill-description', ['description' => $ability->description])</p>
        </div>
        @foreach($ability->morphs as $morph)
            <div class="col-md-11 col-md-offset-1">
                <a class="thumbnail no-bg pull-left m-r-2 text-center ability-icon {{ $characterAbilities->has($morph->id) ? 'ability-known' : 'ability-locked' }}">
                    <img src="{{$morph->image}}">
                    <i class="fa fa-lock fa-2x fa-stack"></i>
                </a>
                <h4 class="m-t-0">
                    {{$morph->name}}
                    @if($morph->isPassive)
                        ({{$characterAbilities->has($morph->id) ? $characterAbilities->get($morph->id)->pivot->skillpoints : 0}}/{{$morph->maxSkillpoints}})
                    @endif
                </h4>
                <p>@include('character.partials.skill-description', ['description' => $morph->description])</p>
            </div>
        @endforeach
    </div>
</div>