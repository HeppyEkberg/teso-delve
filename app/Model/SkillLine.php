<?php namespace App\Model;

use Illuminate\Database\Eloquent\Model;

/**
 * @property int skilltypeEnum
 * @property string name
 * @property mixed id
 * @property null|integer classEnum
 */
class SkillLine extends Model
{

    public function abilities() {
        return $this->hasMany(Ability::class);
    }

}
