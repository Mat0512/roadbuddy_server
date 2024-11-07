<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Support\Facades\Log;


class ServiceRequestCreated implements ShouldBroadcast
{
    use SerializesModels;

    public $requestId;
    public $userId;
    public $serviceProviderId;

    public function __construct($requestId, $userId, $serviceProviderId)
    {
        $this->requestId = $requestId;
        $this->userId = $userId;
        $this->serviceProviderId = $serviceProviderId;
    }


    public function broadcastOn()
    {
        Log::info('ServiceRequestCreated Event broadcast on', [
            'requestId' => $this->requestId,
            'userId' => $this->userId,
            'serviceProviderId' => $this->serviceProviderId,
        ]);
        return new Channel('service-provider.' . $this->serviceProviderId);

    }

    public function broadcastAs()
    {
        return 'service.request.created';
    }

    public function broadcastWith()
    {

        Log::info('ServiceRequestCreated Event broadcastWith', [
            'requestId' => $this->requestId,
            'userId' => $this->userId,
            'serviceProviderId' => $this->serviceProviderId,
        ]);
        return [
            'requestId' => $this->requestId,
            'userId' => $this->userId,
            'serviceProviderId' => $this->serviceProviderId,
        ];
    }
}
