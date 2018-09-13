<?php

namespace Mileon\Generator;

use Illuminate\Support\ServiceProvider;

class GeneratorServiceProvider extends ServiceProvider
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
        include __DIR__.'/routes.php';
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
