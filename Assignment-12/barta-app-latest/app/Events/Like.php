<?php

namespace App\Events;

use App\Models\Post;
use App\Models\React;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;

class Like implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public React $react;

    /**
     * Create a new event instance.
     */
    public function __construct($react)
    {
        $this->react = $react;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        return [
            new Channel('live-event'),
        ];
    }
}
