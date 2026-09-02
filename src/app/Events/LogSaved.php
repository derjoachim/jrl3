<?php

namespace App\Events;

use App\Models\Log as LogModel;
use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class LogSaved
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $oLog;
    /**
     * Create a new event instance.
     *
     * @return void
     */
    public function __construct(LogModel $oLog)
    {
        
        $this->oLog = $oLog;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return Channel|array
     */
    public function broadcastOn()
    {
        return new PrivateChannel('channel-name');
    }
}
