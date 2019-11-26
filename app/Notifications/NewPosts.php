<?php

namespace App\Notifications;

use App\Post;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class NewPosts extends Notification
{
    use Queueable;

    protected $posts;
    protected $period;

    public function __construct($posts, $period)
    {
        $this->posts = $posts;
        $this->period = $period;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Новые статьи за ' . $this->period . 'дней')
            ->markdown('mail.post.new_posts', [
                'posts' => $this->posts,
                'period' => $this->period,
            ])
        ;
    }
}
