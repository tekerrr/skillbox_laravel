<?php

namespace App\Providers;

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
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \View::composer('layout.sidebar', function ($view) {
            $tags = \App\Service\TaggedCache::tags()->remember('tagsCloud', function () {
                return \App\Tag::tagsCloud();
            });

            $view->with('tagsCloud', $tags);
        });

        \App\Post::observe(\App\Observers\PostObserver::class);

        \Blade::if('admin', function () {
            return auth()->user() && auth()->user()->isAdmin();
        });
    }
}
