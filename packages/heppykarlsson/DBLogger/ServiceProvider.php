<?php namespace HeppyKarlsson\DBLogger;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider AS Default_ServiceProvider;

class ServiceProvider extends Default_ServiceProvider
{

    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadViewsFrom(__DIR__.'/views', 'DBLogger');
    }

    public function register() {

        App::bind('DBLogger', function()
        {
            return new DBLogger();
        });

    }
}