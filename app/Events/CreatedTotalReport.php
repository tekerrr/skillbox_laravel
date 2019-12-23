<?php

namespace App\Events;

use App\Service\TotalReport;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class CreatedTotalReport implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $report;
    private $userId;

    public function __construct($report, $userId)
    {
        $this->report = $report;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('report-total.' . $this->userId);
    }
}
