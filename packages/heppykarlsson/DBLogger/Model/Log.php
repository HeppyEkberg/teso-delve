<?php namespace HeppyKarlsson\DBLogger\Model;

use App\User;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{

    public function user() {
        return $this->belongsTo(User::class);
    }

    public function getTraceAttribute() {
        return json_decode($this->attributes['trace']);
    }

}

