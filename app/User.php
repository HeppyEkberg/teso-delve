<?php

namespace App;

use App\Model\Character;
use App\Model\Guild;
use App\Model\Item;
use App\Model\UserItem;
use App\Model\UserSetFavourite;
use HeppyKarlsson\Meta\Traits\Meta;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laratrust\Traits\LaratrustUserTrait;

/**
 * @property string lang
 */
class User extends Authenticatable
{
    use LaratrustUserTrait;
    use Notifiable,
        Meta;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $dates = [
        'seen_at',
        'dumpUploaded_at'
    ];

    public function items() {
        return $this->belongsToMany(Item::class, 'user_items', 'userId', 'itemId')
            ->withPivot('characterId', 'uniqueId', 'bagEnum', 'slotId', 'traitEnum', 'traitDescription', 'enchant', 'enchantDescription', 'equipTypeEnum', 'armorTypeEnum', 'weaponTypeEnum', 'isLocked', 'isBound', 'isJunk', 'count');
    }

    public function userItems() {
        return $this->hasMany(UserItem::class, 'userId');
    }

    public function guilds() {
        return $this->belongsToMany(Guild::class, 'guild_members')
          ->withPivot('rank', 'note', 'accountName');
    }

    public function favouriteSets() {
        return $this->hasMany(UserSetFavourite::class, 'userId');
    }

    public function characters() {
        return $this->hasMany(Character::class, 'userId');
    }

}
