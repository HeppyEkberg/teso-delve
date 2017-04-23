<tr class="{{ isset($set) ? 'set-member-'.$set->id : '' }} {{(isset($hidden) && $hidden) == true ? 'hidden' : ''}}">
    <td class="min-width"><span class="circle quality-{{$item->quality}}"></span></td>
    <td class="min-width hidden-xs"><img class="item-row-icon" src="{{$item->icon}}"></td>
    <td>@include('item.name')</td>
    <td class="hidden-xs">{{$item->equipType !== 0 ? trans('enums.EquipType.' . $item->equipType) : ''}}</td>
    <td class="hidden-xs">
        {{$item->armorType != null ? trans('enums.ArmorType.' . $item->armorType) : ''}}
        {{$item->weaponType != null ? trans('enums.WeaponType.' . $item->weaponType) : ''}}
    </td>
    <td class="hidden-xs">
        @if($item->traitCategory() !== false)
            {{trans('enums.Trait.'. $item->traitCategory() . "." . $item->trait)}}
        @endif
    </td>
    <td>
        @if($item->pivot and !is_null($item->pivot->characterId))
            <?php $character = $user->characters->where('id', $item->pivot->characterId)->first(); ?>
            @if($character)
                <img class="characterClassImage" src="/gfx/class_{{$character->classId}}.png"> {{$character->name}}
            @endif
        @endif
    </td>
    <td class="text-right item-icons nowrap">
        @if($item->pivot)
            <i class="fa fa-male {{$item->pivot->bagEnum == \App\Enum\BagType::WORN ? '' : 'color-inactive'}}" aria-hidden="true" data-toggle="tooltip" title="Item is worn"></i>
            <i class="fa fa-link {{$item->pivot->isBound ? '' : 'color-inactive'}}" aria-hidden="true" data-toggle="tooltip" title="Item is bound"></i>
            <i class="fa fa-bank {{$item->pivot->bagEnum == \App\Enum\BagType::BANK ? '' : 'color-inactive'}}" aria-hidden="true" data-toggle="tooltip" title="Item in bank"></i>
            <i class="fa fa-lock {{$item->pivot->isLocked ? '' : 'color-inactive'}}" aria-hidden="true" data-toggle="tooltip" title="Item is locked"></i>
            <i class="fa fa-trash-o {{$item->pivot->isJunk ? '' : 'color-inactive'}}" aria-hidden="true" data-toggle="tooltip" title="Item is marked as junk"></i>
        @endif
    </td>
</tr>
