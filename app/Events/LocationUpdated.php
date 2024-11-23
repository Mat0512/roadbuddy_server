<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class LocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $latitude;
    public $longitude;
    public $userId;

    public function __construct($latitude, $longitude, $userId)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->userId = $userId;
    }

    public function broadcastOn()
    {
        return new Channel('location.' . $this->userId);
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }

    public function broadcastWith()
    {
        return [
            'latitude' => $this->latitude,
            'longitude' => $this->longitude,
        ];
    }
}
