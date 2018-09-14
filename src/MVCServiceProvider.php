<?php

namespace Luxodev\Mvc;

use Illuminate\Support\ServiceProvider;

class MVCServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                ViewCommand::class
            ]);
        }
        $this->publishes([
            __DIR__.'/public' => public_path('/'),
        ], 'init');
        $this->publishes([
            __DIR__.'/view' => resource_path('views/'),
        ], 'init');
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
