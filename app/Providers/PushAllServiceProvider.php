<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class PushAllServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->singleton(\App\Service\Pushall::class, function () {
            return new \App\Service\Pushall(
                config('skillbox.pushall.id'),
                config('skillbox.pushall.key'),
            );
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
