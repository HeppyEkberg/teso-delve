@extends('layouts.app')

@section('meta-title')
    {{$itemStyle->name}} style - @parent
@endsection

@section('meta-description')
    {{$itemStyle->location}}
@endsection

@section('content')
    <div class="container">
        <div class="row-fluid">

            <div>
                <div>
                    <div class="panel-body">
                        <div class="row">
                            @if(Auth::id() == 1)
                                <div class="col-md-12">
                                    <div role="group" aria-label="" class="btn-group pull-right">
                                        <a href="{{route('admin.crafting.item-style.edit', [$itemStyle])}}" class="btn btn-default btn-xs"><i aria-hidden="true" class="fa fa-pencil"></i></a>
                                    </div>
                                </div>
                            @endif

                            <div class="col-md-8">
                                <h1>{{$itemStyle->name}}</h1>
                                <div class="itemstyle-content">
                                    {!! nl2br($itemStyle->location) !!}
                                </div>

                                <hr>

                                @foreach($armors as $armorType => $armorsList)
                                    <h4>{{trans('enums.ArmorType.' . $armorType)}}</h4>
                                    <ul class="list-inline">
                                        @foreach($armorsList->sortBy('equipType')->groupBy('equipType') as $key => $armorsListByEquipType)
                                            <li>@include('item.worn_image', ['equippedItem' => $armorsListByEquipType->first(), 'qualityBackground' => false])</li>
                                        @endforeach
                                    </ul>
                                @endforeach

                                @if($weapons->count() > 0)
                                    <h4>Weapons</h4>
                                    <ul class="list-inline">
                                        @foreach($weapons as $weaponType => $weaponList)
                                            <li>@include('item.worn_image', ['equippedItem' => $weaponList->first(), 'qualityBackground' => false])</li>
                                        @endforeach
                                    </ul>
                                @endif

                            </div>

                            <div class="motifs-list col-md-4">
                                <div class="row">
                                    @if($itemStyle->chapters->count() > 0)
                                        <div class="col-md-12">
                                            <h4>Motifs</h4>
                                            @foreach($itemStyle->chapters as $chapter)
                                                @include('item.worn_image', ['equippedItem' => $chapter->item])
                                            @endforeach
                                        </div>
                                    @endif

                                    @if(!empty($itemStyle->material))
                                        <div class="col-md-12">
                                            <h4>Material</h4>
                                            @if(!is_null($itemStyle->material_id))
                                                <a href="{{route('item.show', [$itemStyle->materialItem])}}">
                                                    @include('item.image', ['item' => isset($userMaterial) ? $userMaterial : $itemStyle->materialItem])
                                                </a>
                                            @else
                                                <img src="{{$itemStyle->image}}" title="{{$itemStyle->material}}" class="icon-size-40">
                                                <p>{{$itemStyle->material}}</p>
                                            @endif
                                        </div>
                                    @endif
                                </div>
                            </div>


                        </div>

                        @foreach($images as $weight => $genders)
                            <div class="itemstyle-armor row">
                                <h2 class="col-md-12">{{ucfirst($weight)}}</h2>
                                @foreach($genders as $genderName => $gender)
                                    <h4 class="col-md-12">{{ucfirst($genderName)}}</h4>
                                    @foreach($gender as $group => $images)
                                        <div class="armor-group col-md-12">
                                            @foreach($images as $image)
                                                <a target="_blank" href="/gfx/item-style/{{$itemStyle->id}}/{{$image}}" class="thumbnail no-bg"><img class="pull-left" src="/gfx/item-style/{{$itemStyle->id}}/{{$image}}"></a>
                                            @endforeach
                                        </div>
                                    @endforeach
                                @endforeach
                            </div>
                        @endforeach

                        @if(isset($characters))
                            <div class="row">
                                <div class="col-md-12 m-t-3">
                                    <div class="panel panel-default no-bg b-gray-dark">
                                        <div class="panel-heading">
                                           <h2 class="panel-title">Known by</h2>
                                        </div>
                                        <div>
                                            <table class="table table-condensed table-bordered m-b-0">
                                                <thead>
                                                <tr>
                                                    <th>Character</th>
                                                    @foreach(\App\Enum\ItemStyleChapter::order() as $chapter)
                                                        <th>{{trans('enums.styleItemChapter.'.$chapter.'.self')}}</th>
                                                    @endforeach
                                                </tr>
                                                </thead>
                                                <tbody>
                                                @foreach($characters as $character)
                                                    <tr>
                                                        <td><a href="{{route('characters.show', [$character])}}">{{$character->name}}</a></td>
                                                        @foreach(\App\Enum\ItemStyleChapter::order() as $chapter)
                                                            @if($character->itemStyles->where('itemStyleChapterEnum', $chapter)->first())
                                                                <td class="text-center text-white"><i class="fa fa-check"></i></td>
                                                            @else
                                                                <td></td>
                                                            @endif
                                                        @endforeach
                                                    </tr>
                                                @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif


                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
