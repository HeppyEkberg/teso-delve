<?php

namespace App\Model;

use App\Enum\EquipType;
use App\Enum\ItemType;
use HeppyKarlsson\Sluggify\Traits\Sluggify;
use Illuminate\Database\Eloquent\Model;

/**
 * @property string uniqueId
 * @property string icon
 * @property string enchant
 * @property int locked
 * @property int armorType
 * @property int quality
 * @property int|null setId
 * @property int equipType
 * @property int trait
 * @property string name
 * @property int|null type
 * @property int userId
 * @property int|null weaponType
 * @property int|null championLevel
 * @property int|null level
 * @property int|null characterId
 * @property string itemLink
 * @property string traitDescription
 * @property string enchantDescription
 * @property int itemValue
 * @property int itemStyleId
 * @property mixed lang
 * @property string external_id
 */
class Item extends Model
{
    use Sluggify;

    protected $fillable = [
        'uniqueId',
        'name',
        'trait',
        'equipType',
        'setId',
        'count',
        'quality',
        'armorType',
        'locked',
        'enchant',
        'icon',
        'type',
    ];

    protected $sluggify = [
        'slugs' => [
            'slug' => ['id', 'name']
        ],
        'routeKey' => 'slug',
    ];

    public function setNameAttribute($value) {
        $value = str_ireplace('^n', '', $value);
        $value = str_ireplace('^p', '', $value);
        $this->attributes['name'] = $value;
    }

    public function set() {
        return $this->belongsTo(Set::class, 'setId');
    }

    public function character() {
        return $this->belongsTo(Character::class, 'characterId');
    }

    public function sales() {
        return $this->hasMany(ItemSale::class);
    }

    public function setItemSet($setName) {
        $setName = trim($setName);
        $external_id = $setName;
        if(stripos($setName, '^') !== false) {
            $setName = substr($setName, 0, stripos($setName, '^'));
        }

        $set = Set::where('external_id', $external_id)->where('lang', $this->lang)->first();
        if (!$set) {
            $set = new Set();
            $set->name = $setName;
            $set->external_id = $external_id;
            $set->lang = $this->lang;
            $set->save();
        }

        $this->setId = $set->id;
    }

    public function materialStyle() {
        return $this->hasOne(ItemStyle::class, 'material_id');
    }

    public function itemStyleChapter() {
        return $this->belongsToMany(ItemStyle::class, 'itemStyle_chapter', 'itemId', 'itemStyleId');
    }

    public function traitCategory() {

        if($this->type == ItemType::WEAPON and $this->equipType == EquipType::OFF_HAND) {
            return 2;
        }

        if($this->type == ItemType::WEAPON) {
            return 1;
        }

        if($this->type == ItemType::ARMOR and in_array($this->equipType, [EquipType::RING, EquipType::NECK])) {
            return 3;
        }

        if($this->type == ItemType::ARMOR) {
            return 2;
        }

        return false;
    }

}
