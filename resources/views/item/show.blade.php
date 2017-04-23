@extends('layouts.app')

@section('meta-title')
    {{ucfirst($item->name)}} - @parent
@endsection

@section('meta-description')
    {{ ucfirst($item->name) }}{{ $item->set ? trans('title.item.set', ['name' => $item->set->name]) : '' }}{{(isset($priceComparison) and $priceComparison->isValid()) ? trans('title.item.price_ea', ['price' => number_format($priceComparison->average())]) : '' }}
@endsection

@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-12">

                <div class="pull-right">
                    @include('item.itembox', ['itemBoxClass' => 'panel'])
                </div>

                <h1>{{ucfirst($item->name)}}</h1>
                <p>
                    @if($item->materialStyle)
                        This item is used when crafting items of the <a href="{{route('item-styles.show', $item->materialStyle)}}">{{$item->materialStyle->name}}</a> style.
                    @endif

                    @if($item->set)
                        {{$item->name}} is apart of the <a href="{{route('set.show', [$item->set])}}">{{$item->set->name}}</a> {{strtolower(trans('enums.SetType.'.$item->set->setTypeEnum))}}.
                    @endif

                    @if($item->type == \App\Enum\ItemType::RACIAL_STYLE_MOTIF)
                        {{$item->name}} is a chapter motif for the <a href="{{route('item-styles.show', [$item->itemStyleChapter->first()])}}">{{$item->itemStyleChapter->first()->name}}</a> style.
                    @elseif(Lang::has('item.type.'.$item->type))
                        {{trans('item.type.'.$item->type, ['name' => $item->name])}}
                    @endif

                </p>
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <div class="row">
                    <div class="col-md-8">
                        @if(isset($sales) and $sales->count() > 0)
                            <div class="panel panel-default b-a-2 b-gray-dark no-bg">
                                <div class="panel-heading">Sales</div>
                                <div class="scroll-600">
                                    <table class="table table-responsive table-bordered table-condensed">
                                        <thead>
                                        <tr class="bg-gray-darker">
                                            <th>Guild</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Quantity</th>
                                            <th>Unit price</th>
                                        </tr>
                                        </thead>
                                        <tbody>
                                        @foreach($sales as $sale)
                                            <tr>
                                                <td class="text-white">{{isset($sale->guild) ? $sale->guild->name : ''}}</td>
                                                <td class="text-right">{{!is_null($sale->sold_at) ? $sale->sold_at->format('Y-m-d H:i') : '?'}}</td>
                                                <td class="text-right">{{number_format($sale->price, 0)}}</td>
                                                <td class="text-right">{{$sale->quantity}}</td>
                                                <td class="text-right quality-text-5">{{number_format($sale->price_ea, 0)}} <img src="/gfx/gold.png" class="icon-size"></td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        @endif
                    </div>

                    <div class="col-md-4">
                        <div class="row">
                            <div class="col-lg-12 col-md-12  col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Inventory worth</div>
                                    <div class="panel-body">
                                        <h2 class="m-t-0 f-w-300">
                                            @if($item->pivot and $priceComparison->isValid())
                                                {{number_format(($item->pivot->count == 0 ? 1 : $item->pivot->count) * $priceComparison->average())}}
                                            @else
                                                -
                                            @endif
                                        </h2>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-12 col-md-12  col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Average price <small class="pull-right text-gray-lighter">This week</small></div>
                                    <div class="panel-body">
                                        @if($priceComparison->isValid())
                                            <h2 class="m-t-0 f-w-300">{{number_format($priceComparison->average())}} <small title="Average price last week">{{number_format($priceComparison->prevAverage())}}</small></h2>
                                            @if($priceComparison->comparison() < 0)
                                                <i class="fa fa-fw fa-caret-down text-danger"></i>
                                                <span class="text-danger m-r-1">{{number_format($priceComparison->comparison(), 2)}}%</span>
                                            @else
                                                <i class="fa fa-fw fa-caret-up text-success"></i>
                                                <span class="text-success m-r-1">{{number_format($priceComparison->comparison(), 2)}}%</span>
                                            @endif
                                            <small>from last week</small>
                                        @else
                                            <h2 class="m-t-0 f-w-300">-</h2>
                                        @endif
                                    </div>
                                </div>
                            </div>


                            <div class="col-lg-12 col-md-12  col-sm-12">
                                <div class="panel panel-default">
                                    <div class="panel-heading">Sales registered <small class="pull-right text-gray-lighter">This week</small></div>
                                    <div class="panel-body">
                                        @if($priceComparison->isValid())

                                            <h2 class="m-t-0 f-w-300">{{number_format($priceComparison->hits())}} <small title="Average price last week">{{number_format($priceComparison->prevHits())}}</small></h2>
                                            &nbsp;
                                        @else
                                            <h2 class="m-t-0 f-w-300">-</h2>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            @if(isset($userItems))
                                <div class="col-lg-12 col-md-12  col-sm-12">
                                    <div class="panel panel-default">
                                        <table class="table table-striped table-bordered table-condensed">
                                            <thead>
                                            <tr>
                                                <th>Character / Bag</th>
                                                <th>Quantity</th>
                                            </tr>
                                            </thead>
                                            <tbody>
                                            @foreach($userItems as $item)
                                                <tr>
                                                    @if(is_null($item->pivot->characterId))
                                                        <td>{{trans('enums.bags.'.$item->pivot->bagEnum)}}</td>
                                                    @else
                                                        <?php $character = $characters->get($item->pivot->characterId); ?>
                                                        <td><a href="{{route('characters.show', [$character])}}">{{$character->name}}</a></td>
                                                    @endif
                                                    <td class="text-right text-white">{{number_format($item->pivot->count)}}</td>
                                                </tr>
                                            @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

