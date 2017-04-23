<tr class="{{ isset($set) ? 'set-member-'.$set->id : '' }} {{(isset($hidden) && $hidden) == true ? 'hidden' : ''}}">
    <td class="min-width"><span class="circle quality-{{$item->quality}}"></span></td>
    <td class="min-width"><img class="item-icon" src="{{$item->icon}}"></td>
    <td><span class="item-hover" itemId="{{$item->slug}}"><a href="{{route('item.show', [$item->id])}}">{{$item->name}}</a></span>{{ $item->pivot->count > 1 ? "(".$item->pivot->count.")" : '' }}</td>
    <td>
        {{$item->armorType != null ? trans('enums.ArmorType.' . $item->armorType) : ''}}
        {{$item->weaponType != null ? trans('enums.WeaponType.' . $item->weaponType) : ''}}
    </td>
    <td>
        @if($item->traitCategory() !== false)
            {{trans('enums.Trait.'. $item->traitCategory() . "." . $item->trait)}}
        @endif
    </td>
    <td>
       @if($item->set)
            {{$item->set->name}}
       @endif
    </td>
    <td>
        @if($item->pivot)
            {{$item->pivot->enchant}}
        @endif
    </td>
    <td class="text-right item-icons">
        @if($item->pivot->bagEnum == \App\Enum\BagType::WORN)
            <i class="fa fa-male" aria-hidden="true" data-toggle="tooltip" title="Item is worn"></i>
        @endif
        @if($item->pivot->isBound)
            <i class="fa fa-link" aria-hidden="true" data-toggle="tooltip" title="Item is bound"></i>
        @endif
        @if($item->pivot->bagEnum == \App\Enum\BagType::BANK)
            <i class="fa fa-bank" aria-hidden="true" data-toggle="tooltip" title="Item in bank"></i>
        @endif
        @if($item->pivot->isLocked)
            <i class="fa fa-lock" aria-hidden="true" data-toggle="tooltip" title="Item is locked"></i>
        @endif
    </td>
</tr>
