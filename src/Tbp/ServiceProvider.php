<?php
namespace Nolanpro\Tbp;

use Illuminate\Support\ServiceProvider as LaravelServiceProvider;

class ServiceProvider extends LaravelServiceProvider {
    public function register()
    {
        $this->app->singleton(Debugger::class, function ($app) {
            return new Debugger($app);
        });
    }
}