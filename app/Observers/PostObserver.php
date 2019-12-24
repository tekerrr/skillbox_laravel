<?php

namespace App\Observers;

use App\Post;

class PostObserver
{
    public function created(Post $post)
    {
        \Mail::to(config('admin.email'))->send(new \App\Mail\PostCreated($post));
    }

    public function updated(Post $post)
    {
        \Mail::to(config('admin.email'))->send(new \App\Mail\PostUpdated($post));

        push_all_to_admin('Статья изменена', 'Изменена статья ' . $post->title);

        broadcast(new \App\Events\UpdatedPost($post));
    }

    public function deleted(Post $post)
    {
        \Mail::to(config('admin.email'))->send(new \App\Mail\PostDeleted($post));
    }
}
