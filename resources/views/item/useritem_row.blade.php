<?php
$item = $userItem->item;
?>
<tr class="{{ isset($set) ? 'set-member-'.$set->id : '' }} {{(isset($hidden) && $hidden) == true ? 'hidden' : ''}}">
    <td class="min-width"><span class="circle quality-{{$item->quality}}"></span></td>
    <td class="min-width hidden-xs"><img class="item-row-icon" src="http://esoicons.uesp.net/{{str_ireplace('.dds', '.png', $item->icon)}}"></td>
    <td><span class="item-hover" itemId="{{$item->id}}"><a href="{{route('item.show', [$item->id])}}">{{$item->name}}</a></span> {{ $userItem->count > 1 ? "(".$userItem->count.")" : '' }}</td>
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
        @if(!is_null($userItem->characterId))
            <?php $character = $user->characters->where('id', $userItem->characterId)->first(); ?>
            @if($character)
                <img class="characterClassImage" src="/gfx/class_{{$character->classId}}.png"> {{$character->name}}
            @endif
        @endif
    </td>
    <td class="text-right item-icons nowrap">
        <i class="fa fa-male {{ $userItem->bagEnum == \App\Enum\BagType::WORN ? '' : 'color-inactive' }}" aria-hidden="true" data-toggle="tooltip" title="Item is worn"></i>
        <i class="fa fa-link {{ $userItem->isBound ? '' : 'color-inactive' }}" aria-hidden="true" data-toggle="tooltip" title="Item is bound"></i>
        <i class="fa fa-bank {{ $userItem->bagEnum == \App\Enum\BagType::BANK ? '' : 'color-inactive' }}" aria-hidden="true" data-toggle="tooltip" title="Item in bank"></i>
        <i class="fa fa-lock {{ $userItem->isLocked ? '' : 'color-inactive' }}" aria-hidden="true" data-toggle="tooltip" title="Item is locked"></i>
        <i class="fa fa-trash-o {{ $userItem->isJunk ? '' : 'color-inactive' }}" aria-hidden="true" data-toggle="tooltip" title="Item is marked as junk"></i>
    </td>
</tr>