<?php

namespace App\Providers;

use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Support\ServiceProvider;
use Lang;

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
        \Illuminate\Auth\Notifications\ResetPassword::$toMailCallback = function ($notifiable, $token) {
            return (new MailMessage)
                ->subject('Уведомление о запросе на смену пароля')
                ->greeting('Приветствую!')
                ->line('Вы получили это письмо, потому что мы получили запрос на смену пароля для вашей учетной записи.')
                ->action('Сменить пароль', url(config('app.url').route('password.reset', ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                ->line(Lang::get('Срок действия ссылки для смены пароля истекает через :count минут.', ['count' => config('auth.passwords.'.config('auth.defaults.passwords').'.expire')]))
                ->line(Lang::get('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.'));
        };

        \View::composer('layout.sidebar', function ($view) {
            $view->with('tagsCloud', \App\Tag::tagsCloud());
        });


    }
}
