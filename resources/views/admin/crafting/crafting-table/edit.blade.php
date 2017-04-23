@extends('layouts.app')

@section('content')
    <div class="row-fluid text-right">
        <br>
        <a class="btn btn-primary" href="{{route('admin.crafting-table.update', [$craftingTypeEnum])}}">Populate crafting table</a>
    </div>
    <div class="row-fluid">
        <div class="col-md-12 m-t-3">
            <ul class="nav nav-tabs">
                @foreach(\App\Enum\CraftingType::smithing() as $smithing)
                    <li role="presentation" class="{{ $smithing == $craftingTypeEnum ? 'active' : '' }}"><a href="{{route('admin.crafting-table.edit', [$smithing])}}">{{trans('enums.CraftingType.'.$smithing)}}</a></li>
                @endforeach
            </ul>
        </div>

        <div class="col-md-12">
            <form method="post" action="{{route('admin.crafting-table.update', [$craftingTypeEnum])}}"
                  class="form-inline">
                {!! csrf_field() !!}
                <h3>{{trans('enums.CraftingType.' . $craftingTypeEnum)}}</h3>
                <table class="table table-condensed table-hover">
                    <thead>
                    <tr>
                        <th>Level</th>
                        @foreach($researchLineIndexes as $researchLine)
                            <th class="text-center min-width">
                                <img title="{{$researchLine->name}} - {{$researchLine->researchLineIndex}}" class="item-icon size-40" src="{{$researchLine->image}}">
                            </th>
                        @endforeach
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($levels as $level => $levelCraftingItems)
                        @include('admin.crafting.crafting-table.partials.crafting-row', ['level' => $level, 'championLevel' => null, 'levelCraftingItems' => $levelCraftingItems])
                    @endforeach

                    @foreach($cLevels as $champLevel => $levelCraftingItems)
                        @if(empty($champLevel))
                            @continue
                        @endif

                        @include('admin.crafting.crafting-table.partials.crafting-row', ['level' => 50, 'championLevel' => $champLevel, 'levelCraftingItems' => $levelCraftingItems])
                    @endforeach
                    </tbody>
                </table>
                <input type="submit" class="pull-right btn btn-primary" value="Save crafting table">
            </form>
        </div>
    </div>
@endsection

