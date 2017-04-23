<?php

namespace App\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int|mixed smithing
 * @property int|mixed itemStyles
 * @property int|mixed items
 * @property int|mixed characters
 * @property string file
 * @property int user_id
 * @property string guid
 */
class ImportGroup extends Model
{
    use SoftDeletes;

    protected $primaryKey = 'guid';
    protected $table = 'import_group';

    public $incrementing = false;


    public function rows() {
        return $this->hasMany(ImportRow::class, 'import_group_guid');
    }

    public function rowCount() {
        return $this->rows()->count();
    }

}
