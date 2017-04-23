@extends('layouts.app')

@section('meta-title')
    {{$character->name}} skills and abilities - @parent
@endsection


@section('content')
    <div class="container">
        <div class="row-fluid">
            <div class="col-md-12 m-b-3">
                @include('character.tabs')
            </div>
        </div>
        <div class="row-fluid">

            <div class="col-md-3">
                <div class="panel panel-default bg-gray-dark b-a-0">
                    <div class="panel-body">
                        <div class="row">

                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <p class="m-b-0 m-t-0 text-gray-lighter">Skillpoints available:</p>
                                <h4 class="display-3 m-t-0">{{$character->skillpoints}} / {{$spentSkillpoints + $character->skillpoints}}</h4>
                            </div>

                            <div class="col-lg-12 col-md-3 col-sm-3 col-xs-6">
                                <p class="m-b-0 m-t-0 text-gray-lighter">Skyshards:</p>
                                <h1 class="f-w-300 m-t-0">{{$character->skyshards}} / 3</h1>
                            </div>

                        </div>
                    </div>
                </div>

                @foreach(trans('enums.Skilltypes') as $skilltypeEnum => $name)
                    <?php
                    $skillLines = $skilltypes->get($skilltypeEnum);
                    ?>
                    <div class="panel panel-default bg-gray-dark b-a-0">
                        <div class="panel-heading">
                            <div class="panel-title">
                                <h6 class="text-white m-b-0 m-t-0"><strong>{{$name}}</strong></h6>
                            </div>
                        </div>
                        <div class="panel-body">

                            <ul class="list-unstyled">
                                @if(isset($skillLines))
                                    @foreach($skillLines as $skillLine)
                                        @if($skilltypeEnum == \App\Enum\SkilltypeEnum::CLASS_SKILL and $skillLine->classEnum != $character->classId)
                                            @continue
                                        @endif
                                        @if($skilltypeEnum == \App\Enum\SkilltypeEnum::RACIAL and $skillLine->raceEnum != $character->raceId)
                                            @continue
                                        @endif
                                        <li><a href="{{route('character.skills', [$character, $skillLine])}}">{{$skillLine->name}}</a></li>
                                    @endforeach
                                @endif
                            </ul>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-md-9">
                <div class="row">
                    <div class="col-md-12">
                        <h3>{{$showSkillLine->name}}</h3>
                    </div>
                    <div class="col-md-12">


                        @foreach($abilities->where('isUltimate', 1) as $ability)
                            @if($loop->first)
                                <div class="panel panel-default no-bg b-gray-dark">
                                    <div class="panel-body">
                                        <h4>Ultimate abilities</h4>
                                        @endif
                                        @include('character.partials.skill-row')
                                        @if($loop->last)
                                    </div>
                                </div>
                            @endif
                        @endforeach


                        @foreach($abilities->where('isUltimate', 0)->where('isPassive', 0) as $ability)
                            @if($loop->first)
                                <div class="panel panel-default no-bg b-gray-dark">
                                    <div class="panel-body">
                                        <h4>Active abilities</h4>
                                        @endif
                                        @include('character.partials.skill-row')
                                        @if($loop->last)
                                    </div>
                                </div>
                            @endif
                        @endforeach


                        @foreach($abilities->where('isPassive', 1) as $ability)
                            @if($loop->first)
                                <div class="panel panel-default no-bg b-gray-dark">
                                    <div class="panel-body">
                                        <h4>Passive abilities</h4>
                                        @endif
                                        @include('character.partials.skill-row')
                                        @if($loop->last)
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection

