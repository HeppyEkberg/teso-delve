<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int morph
 * @property mixed name
 * @property mixed baseName
 * @property bool isUltimate
 * @property bool isPassive
 * @property mixed skill_line_id
 * @property string image
 * @property int index
 */
class Ability extends Model
{

    public function morphs() {
        return $this->hasMany(self::class, 'parent_id', 'id');
    }

    public function checkParent() {
        if($this->morph == 0) {
            return true;
        }

        if(!is_null($this->parent_id)) {
            return true;
        }

        $parent = Ability::where('skill_line_id', $this->skill_line_id)->where('index', $this->index)->where('morph', 0)->first();
        if(!is_null($parent)) {
            $this->parent_id = $parent->id;
            $this->save();
        }
    }

}
