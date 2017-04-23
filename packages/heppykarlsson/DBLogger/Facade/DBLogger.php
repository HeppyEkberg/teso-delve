<?php namespace HeppyKarlsson\DBLogger\Facade;

use Illuminate\Support\Facades\Facade;

class DBLogger extends Facade
{

    protected static function getFacadeAccessor()
    {
        return 'DBLogger';
    }


}