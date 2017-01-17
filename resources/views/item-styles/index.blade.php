@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row-fluid">

            <div class="col-md-12">
                <div>
                    <div>
                        <h1>Item styles</h1>
                        <table class="table table-hover table-striped m-t-3">
                            <thead>
                            <tr>
                                <th>Name</th>
                                <th></th>
                                <th>Description</th>
                                <th>Material</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($itemStyles as $itemStyle)
                                <tr class="input-group-sm">
                                    <td class="valign-middle"><h3 class="no-margin"><a href="{{route('item-styles.show', [$itemStyle])}}">{{$itemStyle->name}}</a></h3></td>
                                    <td class="valign-middle nowrap">
                                        @if($helmets->has($itemStyle->id))
                                            <ul class="list-inline">
                                                @foreach($helmets->get($itemStyle->id) as $helmet)
                                                    <li><img class="icon-size-40" src="{{$helmet->icon}}"></li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </td>
                                    <td class="valign-middle">{!! nl2br($itemStyle->location)!!}</td>
                                    <td class="min-width nowrap text-center"><img src="{{$itemStyle->image}}" class="icon-size-40" title="{{$itemStyle->material}}">
                                        <p>{{$itemStyle->material}}</p>
                                    </td>
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
