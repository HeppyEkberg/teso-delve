<span class="item-hover" itemId="{{$item->slug}}"><a href="{{route('item.show', [$item])}}" class="quality-text-{{$item->quality}}">{{ucfirst($item->name)}}</a></span>
@if(isset($item->pivot) and $item->pivot->count > 1)
    <span title="Amount: {{$item->pivot->count}}">Amount: {{ $item->pivot->count > 1 ? $item->pivot->count : '' }}</span>
@elseif(isset($userItem) and $item->count > 1)
    <span title="Amount: {{$item->count}}">Amount: {{ $userItem->count > 1 ? $userItem->count : '' }}</span>
@endif
@if($item->level < 50 and $item->level != 1)
    <span title="Level {{$item->level}}">Lvl: {{$item->level}}</span>
@endif
@if($item->level == 50 and $item->championLevel < 160 and $item->championLevel != 0)
    <span title="Champion level {{$item->championLevel}}">CP: {{$item->championLevel}}</span>
@endif
&nbsp;