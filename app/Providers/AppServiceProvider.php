<?php

namespace App\Providers;


use Illuminate\Database\Eloquent\Relations\Relation;
use Illuminate\Pagination\Paginator;
use Illuminate\Queue\Events\JobProcessed;
use Illuminate\Queue\Events\JobProcessing;
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

        \DB::listen(function ($query) {
//            dd($query);
        });

//        \Queue::failing(function (\Illuminate\Queue\Events\JobFailed $event) {
//            //
//        });

//        \Queue::before(function (JobProcessing $event) {});
//        \Queue::after(function (JobProcessed $event) {});

//        \Queue::looping(function () {});
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

        \Blade::component('components.alert', 'alert');

        // Объявление новой директивый
        \Blade::directive('datetime', function ($value) {
            return "<?php echo ($value)->toFormattedDateString() ?>";
        });

        \Blade::if('env', function ($env) {
            return app()->environment($env);
        });

        Paginator::defaultSimpleView('pagination::simple-default');
//        Paginator::defaultView('pagination::simple-default');

//        Relation::morphMap([
//            'tasks' => \App\Task::class,
//            'steps' => \App\Step::class,
//        ]);
    }
}
