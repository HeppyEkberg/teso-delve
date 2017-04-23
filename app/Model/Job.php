<?php namespace App\Model;

use HeppyKarlsson\Meta\Traits\Meta;
use HeppyKarlsson\Sluggify\Traits\Sluggify;
use Illuminate\Database\Eloquent\Model;


class Job extends Model
{

    public $dates = [
        'reserved_at'
    ];

    public function className() {
        $commandName = explode('"command"', $this->payload);
        $commandName = explode('"commandName":"', $commandName[0]);

        return str_ireplace(['\\\\', '",'], ['\\', ''], $commandName[1]);
    }

}
