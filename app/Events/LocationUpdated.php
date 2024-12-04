<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Support\Facades\Log;

class LocationUpdated implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $latitude;
    public $longitude;
    public $userId;

    public function __construct($latitude, $longitude, $requestId)
    {
        $this->latitude = $latitude;
        $this->longitude = $longitude;
        $this->requestId = $requestId;
    }

    public function broadcastOn()
    {
        Log::info('LocationUpdated Event broadcast on', [
            'latitude' => $this->latitude,
            'requestId' => $this->requestId,
            'longitude' => $this->longitude,
        ]);
        return new Channel('location.' . $this->requestId);
    }

    public function broadcastAs()
    {
        return 'location.updated';
    }

    public function broadcastWith() 
    {   
        return [
            'lat' => $this->latitude,
            'long' => $this->longitude,
        ];
    }
}
