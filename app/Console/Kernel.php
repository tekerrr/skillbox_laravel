<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        //
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')
        //          ->hourly();

        if (app()->environment() == 'local') {
            return;
        }

        $schedule->command('app:say_hello', [
            '--subject' => 'Привет из расписания',
        ])
            ->environments(['local'])
            ->everyMinute()
            ->when(function () {
                return true;
            })
            ->withoutOverlapping('60')
            ->runInBackground()
            ->sendOutputTo($path ?? '/')
            ->emailOutputTo('test@test.ro')
            ->before(function () {})
            ->after(function () {})
        ;
    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
