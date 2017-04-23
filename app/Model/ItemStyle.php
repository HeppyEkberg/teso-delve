<?php namespace App\Model;

use HeppyKarlsson\Sluggify\Traits\Sluggify;
use Illuminate\Database\Eloquent\Model;

/**
 * @property mixed id
 * @property bool craftable
 * @property mixed chapters
 * @property bool isHidden
 * @property string location
 * @property string description
 * @property string name
 * @property string material
 * @property string image
 * @property int externalId
 */
class ItemStyle extends Model
{
    use Sluggify;

    protected $sluggify = [
        'slugs' => ['slug' => 'name'],
        'routeKey' => 'slug',
    ];

    public $table = 'itemStyles';

    public function chapters() {
        return $this->hasMany(ItemStyleChapter::class, 'itemStyleId');
    }

    public function materialItem() {
        return $this->hasOne(Item::class, 'id', 'material_id');
    }

}
