<div class="itemBox {{ isset($itemBoxClass) ? $itemBoxClass : '' }}">
    <img class="item-icon" src="{{$item->icon}}">

    <div class="row">
        @if($item->armorType != 0)
            <div class="col-sm-6 text-left">{{trans('enums.EquipType.'. $item->equipType) }}</div>
        @elseif($item->weaponType != 0)
            <div class="col-sm-6 text-left">{{trans('enums.WeaponType.'. $item->weaponType) }}</div>
        @elseif($item->equipType != 0)
            <div class="col-sm-6 text-left">{{trans('enums.EquipType.'. $item->equipType) }}</div>
        @else
            <div class="col-sm-6 text-left"></div>
        @endif
        <div class="col-sm-6 text-right">
            @if($item->pivot)
                {{number_format($item->pivot->count == 0 ? 1 : $item->pivot->count)}} <i aria-hidden="true" class="fa fa-suitcase"></i>
            @endif

            @if($item->pivot and $item->pivot->isLocked)
                <i class="fa fa-lock" aria-hidden="true" data-toggle="tooltip" title="Item is locked"></i>
            @endif

            @if($item->pivot and $item->pivot->isBound)
                <i aria-hidden="true" data-toggle="tooltip" title="" class="fa fa-link " data-original-title="Item is bound"></i>
            @endif
        </div>
    </div>

    <div class="row">
        @if($item->armorType != 0)
            <div class="col-sm-6 text-left">({{ trans('enums.ArmorType.'. $item->armorType) }} Armor)</div>
        @elseif($item->weaponType != 0)
            <div class="col-sm-6 text-left">({{ trans('enums.EquipType.'. $item->equipType) }})</div>
        @else
            <div class="col-sm-6 text-left"></div>
        @endif
        <div class="col-md-6 text-right">
            @if(isset($priceComparison) and $priceComparison->isValid())
                <span title="{{number_format($priceComparison->comparison(), 2)}}% compared to last week">
                    <i class="fa fa-fw fa-caret-{{$priceComparison->comparison() < 0 ? 'down' : 'up'}} text-{{$priceComparison->comparison() < 0 ? 'danger' : 'success'}}"></i>
                    {{number_format($priceComparison->average(), 0)}} <img src="/gfx/gold.png" class="icon-size">
                </span>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <h2 class="text-center quality-text-{{$item->quality}}">{{ucfirst($item->name)}}</h2>
            <hr>
        </div>

        @if($item->weaponType !== 0 or $item->armorType !== 0)
            <div class="col-sm-4 text-left"><h4>{{$item->weaponType !== 0 ? 'Damage' : ''}}{{$item->armorType !== 0 ? 'Armor' : ''}} {{$item->itemValue}}</h4></div>
            <div class="col-sm-4 text-center"><h4>Level {{$item->level}}</h4></div>
            <div class="col-sm-4 text-right"><h4><img class="champion-icon" src="/gfx/champion_icon.png"> {{$item->championLevel}}</h4></div>
        @elseif($item->championLevel < 0)
            <div class="col-sm-6 text-right"><h4>Level {{$item->level}}</h4></div>
            <div class="col-sm-6 text-left"><h4><img class="champion-icon" src="/gfx/champion_icon.png"> {{$item->championLevel}}</h4></div>
        @else
            <div class="col-sm-12 text-center"><h4>Level {{$item->level}}</h4></div>
        @endif

        @if($item->enchant)
            <div class="col-md-12 enchantInfo">
                <strong class="text-white">{{$item->enchant}}</strong>
                <p>@include('sets.setbonus', ['description' => $item->enchantDescription])</p>
            </div>
        @endif

        @if($item->trait != 0)
            <div class="col-md-12 traitInfo">
                <strong class="text-white">{{trans('enums.Trait.' . $item->traitCategory() . "." . $item->trait)}}</strong>
                <p>@include('sets.setbonus', ['description' => $item->traitDescription])</p>
            </div>
        @endif

        @if(isset($characters) and $item->type == 8 and isset($itemStyleChapter))
            <div class="col-md-12 motif-known-by">
                <h3>Known by</h3>
                @foreach($characters as $character)
                    {{$character->itemStyles->where('itemStyleChapterEnum', $itemStyleChapter->itemStyleChapterEnum)->where('itemStyleId', $itemStyleChapter->itemStyleId)->count() == 1 ? $character->name .',' : '' }}
                @endforeach
            </div>
        @endif

        @if($item->set)
            <div class="col-md-12 text-center text-white">Part of the {{$set->name}} set (<strong>{{$items->where('setId', $set->id)->groupBy('equipType')->count()}}/{{$set->bonuses->sortBy('bonusNumber')->last()->bonusNumber or ''}}</strong> items)</div>

            <div class="col-md-12 setBonuses">
                <ul class="list-unstyled setbonus-list">
                    @foreach($set->bonuses as $bonus)
                        <li>({{$bonus->bonusNumber}} items) @include('sets.setbonus', ['description' => $bonus->description])</li>
                    @endforeach
                </ul>
            </div>
        @endif

    </div>

</div>