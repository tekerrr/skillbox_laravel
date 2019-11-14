<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Model' => 'App\Policies\ModelPolicy',
        \App\Post::class => \App\Policies\PostPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @param \Illuminate\Contracts\Auth\Access\Gate $gate
     * @return void
     */
    public function boot(\Illuminate\Contracts\Auth\Access\Gate $gate)
    {
        $this->registerPolicies();

        $gate->before(function ($user) {
            if ($user->id == config('admin.id')) {
                return true;
            }
        });

        \Illuminate\Auth\Notifications\ResetPassword::$toMailCallback = function ($notifiable, $token) {
            return (new \Illuminate\Notifications\Messages\MailMessage)
                ->subject('Уведомление о запросе на смену пароля')
                ->greeting('Приветствую!')
                ->line('Вы получили это письмо, потому что мы получили запрос на смену пароля для вашей учетной записи.')
                ->action('Сменить пароль', url(config('app.url').route('password.reset',  ['token' => $token, 'email' => $notifiable->getEmailForPasswordReset()], false)))
                ->line('Срок действия ссылки для смены пароля истекает через ' . config('auth.passwords.'.config('auth.defaults.passwords').'.expire') . ' минут.')
                ->line('Если вы не запрашивали сброс пароля, никаких дальнейших действий не требуется.')
            ;
        };
    }
}
