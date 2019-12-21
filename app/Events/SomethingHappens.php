<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class SomethingHappens implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $whatHappens;

    public function __construct($whatHappens)
    {
        $this->whatHappens = $whatHappens;
    }

    public function broadcastOn()
    {
        return new Channel('hello');
    }

    public function broadcastWith()
    {
        return ['what' => $this->whatHappens];
    }
}
