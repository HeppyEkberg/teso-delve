<div class="item_image">
    @if($equippedItem)
        <a href="{{route('item.show', [$equippedItem])}}">
            @if(isset($qualityBackground) and $qualityBackground == false)
                <img class="item-icon" src="{{$equippedItem->icon}}">
            @else
                <span class="item-hover quality-square quality-opacity-{{$equippedItem->quality}}" itemId="{{$equippedItem->slug}}">
                <img class="item-icon" src="{{$equippedItem->icon}}">
            </span>
            @endif
        </a>
    @endif
</div>
