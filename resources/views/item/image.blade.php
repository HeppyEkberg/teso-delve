<div class="item-hover quality-square quality-opacity-{{$item->quality}}" itemId="{{$item->slug}}">
    @if(isset($item->pivot) and $item->pivot->isLocked)
        <i class="fa fa-lock"></i>
    @endif

    @if(isset($item->pivot) and $item->pivot->count > 1)
        <span class="slot-count text-white" title="You have {{$item->pivot->count}} on your account">{{$item->pivot->count}}</span>
    @endif

    <img class="item-icon size-40" src="{{$item->icon}}">
</div>
