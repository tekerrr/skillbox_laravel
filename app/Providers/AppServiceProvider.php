<?php

namespace App\Providers;


use Illuminate\Support\Collection;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Collection::macro('toUpper', function () {
            return $this->map(function ($item) {
                return \Illuminate\Support\Str::upper($item);
            });
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
//        view()->composer();
        \View::composer('layout.sidebar', function ($view) {
            $view->with('tagsCloud', \App\Tag::tagsCloud());
        });
    }
}
