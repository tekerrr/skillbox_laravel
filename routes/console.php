<?php

use Illuminate\Foundation\Inspiring;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
*/

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->describe('Display an inspiring quote');

Artisan::command('test', function () {
    /** @var $this \Illuminate\Console\Command */

//    $this->line('Some text');
//    $this->info('Some text', 'vvv');
//    $this->comment('Some text');
//    $this->question('Some text');
//    $this->error('Some text');

//    $name = $this->ask('Как Вас зовут');
//    $password = $this->secret('А какой у вас пароль');
//
//    $this->line($name);
//    $this->line($password);

//    if ($this->confirm('Вам есть 18?')) {
//        $this->info('А зачем нас обманывать');
//    }

//    $name = $this->anticipate('Какая Ваша любимая еда', ['Картошка', 'Мясо', 'Галушки']);
//    $this->info($name);

//    $name = $this->choice('Какая Ваша любимая еда', ['Картошка', 'Мясо', 'Галушки']);
//    $this->info($name);

    $subject = $this->ask('Введите тему письма');

    $this->callSilent('app:say_hello', [
        'users' => [1, 2],
        '--subject' => $subject,
        '--class' => true,
    ]);

    //Artisan::call // == callSilent
    //Artisan::output
});
