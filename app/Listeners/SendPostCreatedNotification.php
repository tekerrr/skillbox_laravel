<?php

namespace App\Listeners;

use App\Events\PostCreated;

class SendPostCreatedNotification
{
    /**
     * Handle the event.
     *
     * @param  PostCreated  $event
     * @return void
     */
    public function handle(PostCreated $event)
    {
        \Mail::to(config('admin.email'))->send(new \App\Mail\PostCreated($event->post));
    }
}
