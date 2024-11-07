<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class ServiceRequestResponse implements ShouldBroadcastNow
{
    use SerializesModels;

    public $requestId;
    public $status;
    public $providerId;

    public function __construct($requestId, $status, $providerId)
    {
        $this->requestId = $requestId;
        $this->status = $status;
        $this->providerId = $providerId;
    }

    public function broadcastOn()
    {
        return new Channel('user.' . $this->providerId);
    }

    public function broadcastAs()
    {
        return 'service.request.response';
    }
}
