@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-fluid">
            <div class="col-md-12">
                <div class="">
                    <div class="">
                        @if(isset($character) and $character)
                            @include('character.tabs')
                        @endif


                        <div class="row col-md-6">
                            <h1>Inventory</h1>
                            <div class="inventory col-md-12">
                                @foreach($items as $item)
                                    <div class="item_image">
                                        @if($item)
                                            <span class="item-hover quality-square quality-opacity-{{$item->quality}}" itemId="{{$item->id}}">
                                            {!! $item->pivot->isLocked ? '<i class="fa fa-lock"></i>' : '' !!}
                                                <img class="item-icon size-40" src="http://esoicons.uesp.net/{{str_ireplace('.dds', '.png', $item->icon)}}">
                                            </span>
                                            @if($item->pivot->count > 1)
                                                <span class="slot-count">{{$item->pivot->count}}</span>
                                            @endif
                                        @endif
                                    </div>

                                @endforeach
                                <hr>
                            </div>
                            <div class="col-md-6">
                                Inventory space: <span class="text-white">{{$items->count()}} / {{$bagSize}}</span>
                            </div>
                            <div class="col-md-6 text-right text-white">
                                {{number_format($gold)}} <img src="/gfx/gold.png">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

