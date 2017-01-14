
<?php

$setCount = null;
$isFavourite = false;
$setItems = null;
if($user) {
    $setItems = $items->where('setId', $set->id);
    $setCount = $setItems->count();
    $isFavourite = in_array($set->id, $favourites);
}

?>

<tr class="{{ $isFavourite ? 'bg-gray-darker' : ''}} set-row-{{$set->id}}">
    <td class="min-width">
        <a href="#" class="open-set-row" setId="{{$set->id}}" ><i class="fa fa-chevron-{{$isFavourite ? 'up' : 'down'}}" aria-hidden="true"></i></a>
    </td>
    <td colspan="2">
        <span class="set-hover" setId="{{$set->id}}">
            <a href="{{route('set.show', [$set])}}"><strong>{{$set->name}}</strong></a>
            @if($user and $setCount > 0)
                <span class="badge">{{$setCount}}</span>
            @endif
        </span>
    </td>
    <td colspan="2">
        @if($set->dungeons->first())
            {{$set->dungeons->first()->name}}
        @endif
    </td>
    <td colspan="2">
      @if($set->meta->where('key', 'monster_chest')->first())
          {{ trans('eso.pledgeChest.' . $set->meta->where('key', 'monster_chest')->first()->value) }}
      @endif

    <td>
        <div class="btn-group pull-right" role="group" aria-label="...">
            @if($user)
                @if(Gate::allows('update', $set))
                    <a href="{{route('set.edit', [$set])}}" class="btn btn-default btn-xs"><i class="fa fa-pencil" aria-hidden="true"></i></a>
                @endif
                @if($isFavourite)
                    <a href="{{route('set.favourite', [$set])}}" class="btn btn-default btn-xs setFavourite" data-toggle="tooltip" title="Toggle as favourite set"><i class="fa fa-star text-legendary favouriteIcon" aria-hidden="true"></i></a>
                @else
                    <a href="{{route('set.favourite', [$set])}}" class="btn btn-default btn-xs setFavourite" data-toggle="tooltip" title="Toggle as favourite set"><i class="fa fa-star-o favouriteIcon" aria-hidden="true"></i></a>
                @endif
            @endif
        </div>
    </td>
</tr>


@if($user and $setItems->count() > 0)
    @foreach($setItems->sortBy('equipType') as $item)
        @include('item.item_row', ['hidden' => !$isFavourite])
    @endforeach
@else
    <tr class="set-member-{{$set->id}} {{$isFavourite == false ? 'hidden' : ''}}">
        <td></td>
        <td colspan="7">{{$user ? 'None' : 'Register and login to view your items!'}}</td>
    </tr>
@endif
