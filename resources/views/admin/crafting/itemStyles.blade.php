@extends('layouts.admin')

@section('content')
    <div class="container-fluid">
        <div class="row-fluid">

            <div class="col-md-12">
                <div>
                    <div>
                        <h1>Item styles</h1>

                            <table class="table table-hover m-t-3">
                                <thead>
                                <tr>
                                    <th></th>
                                    <th>Name</th>
                                    <th>Material</th>
                                    <th>Craftable</th>
                                    <th>Hidden</th>
                                </tr>
                                </thead>
                                <tbody>
                                @foreach($itemStyles as $itemStyle)
                                    <tr class="input-group-sm">
                                        <td class="min-width"><a href="{{route('admin.crafting.item-style.edit', [$itemStyle])}}">{{$itemStyle->id}}</a></td>
                                        <td><a href="{{route('admin.crafting.item-style.edit', [$itemStyle])}}">{{$itemStyle->name}}</a></td>
                                        <td class="min-width nowrap"><img class="icon-size" src="{{$itemStyle->image}}" title="{{$itemStyle->material}}"> {{$itemStyle->material}}</td>
                                        <td class="min-width text-center">{!! $itemStyle->craftable ? '<i class="fa fa-check"></i>' : '' !!}</td>
                                        <td class="min-width text-center">{!! $itemStyle->isHidden ? '<i class="fa fa-check"></i>' : '' !!}</td>
                                    </tr>
                                @endforeach
                                </tbody>
                            </table>

                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
