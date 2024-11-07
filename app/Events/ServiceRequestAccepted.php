<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class ServiceRequestAccepted implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $requestId;
    public $providerId;
    public $userId;

    public function __construct($requestId, $userId, $providerId)
    {
        $this->requestId = $requestId;
        $this->userId = $userId;
        $this->providerId = $providerId;
    }

    public function broadcastOn()
    {
        return new Channel('service-provider.' . $this->providerId);
    }

    public function broadcastAs()
    {
        return 'service.request.accepted';
    }

    public function broadcastWith()
    {
        return [
            "request_id" =>  $this->requestId
        ];
    }
}
