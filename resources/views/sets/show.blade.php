@extends('layouts.app')

@section('meta-title')
{{$set->name}} {{ $set->setTypeEnum == \App\Enum\SetType::MONSTER ? "monster " : '' }}set - @parent @endsection

@section('meta-description')
{{ trans('description.set.' . $set->setTypeEnum, [
    'name' => $set->name,
    'dungeons' => implode(', ', $set->dungeons->pluck('name')->toArray()),
    'traits' => $set->getMeta('crafting_traits_needed'),
    'zones' => rtrim(implode(', ', $set->zones->pluck('name')->toArray())),
    'dungeon' => $set->dungeons->count() > 0 ? $set->dungeons->first()->name : '',
    'pledgeChest' => trans('eso.pledgeChest.'.trim($set->getMeta('monster_chest')))
])}}@endsection

@section('content')
    <div class="container">
        <div class="row-fluid">

            <div class="col-md-12">
                <div class="">
                    <div class="">
                        <div class="btn-group pull-right" role="group">
                            @if($user)
                                @role('admin')
                                    <a href="{{route('set.edit', [$set->slug])}}" class="btn btn-default btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                                @endrole
                                @if($isFavourite)
                                    <a href="{{route('set.favourite', [$set])}}" class="btn btn-default btn-xs setFavourite"><i class="fa fa-star text-legendary favouriteIcon" aria-hidden="true"></i></a>
                                @else
                                    <a href="{{route('set.favourite', [$set])}}" class="btn btn-default btn-xs setFavourite"><i class="fa fa-star-o favouriteIcon" aria-hidden="true"></i></a>
                                @endif
                            @endif
                        </div>


                        <div class="row">
                            <div class="col-md-8">
                                <h1>{{$set->name}}</h1>

                                {!! nl2br($set->description) !!}

                                <h4>Where to find</h4>
                                <ul>
                                    @if($set->setTypeEnum == \App\Enum\SetType::DUNGEON or $set->setTypeEnum == \App\Enum\SetType::MONSTER)
                                        @foreach($set->dungeons as $dungeon)
                                            <li><a href="{{route('dungeon.show', [$dungeon])}}">{{$dungeon->name}}</a></li>
                                        @endforeach
                                    @elseif($set->setTypeEnum == \App\Enum\SetType::CRAFTED)
                                        <li>Craftable: {{$set->getMeta('crafting_traits_needed')}} traits
                                            <ul>
                                                @foreach($set->zones as $zone)
                                                    <li><a href="{{route('zone.show', [$zone->getZoneInfo()['slug']])}}">{{$zone->getZoneInfo()['name']}}</a> - {{$set->getMeta('crafting_bench_' . $zone->zoneId)}}</li>
                                                @endforeach
                                            </ul>
                                        </li>

                                    @else
                                        @foreach($set->zones as $zoneId => $zone)
                                            <li><a href="{{route('zone.show', [$zone->getZoneInfo()['slug']])}}">{{$zone->getZoneInfo()['name']}}</a></li>
                                        @endforeach
                                    @endif

                                    @include('sets.settype_drop')
                                </ul>


                                @if($set->bonuses->count() > 0)
                                    <h4>Bonuses</h4>
                                    <ul class="setbonus-list">
                                        @foreach($set->bonuses as $bonus)
                                            <li class="{{$items and $items->count() >= $bonus->bonusNumber ? 'text-bold' : ''}}">({{$bonus->bonusNumber}} items) @include('sets.setbonus', ['description' => $bonus->description])</li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="col-md-4">
                                <br>
                                @include('sets/setbox')
                            </div>

                            @if(Auth::check())
                                <div class="col-md-12">
                                    <h4>Items you have</h4>
                                    <table class="table table-condensed set-table table-hover">
                                        <thead>
                                        </thead>
                                        <tbody>
                                        @foreach($items as $item)
                                            @include('item.item_row', ['hidden' => false])
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
