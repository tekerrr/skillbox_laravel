<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class UpdatedPost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $post;

    public function __construct(\App\Post $post)
    {
        $this->post = $post;
    }

    public function broadcastOn()
    {
        return new PresenceChannel('admin');
    }

    public function broadcastWith()
    {
        $after = json_decode($this->post->history()->first()->pivot->after, true);
        $fields = implode(', ', array_keys($after));

        return [
            'title' => $this->post->title,
            'changes' => $fields,
            'href'  => route('posts.show', $this->post),
        ];
    }
}
