<?php

namespace App\Events;


use Illuminate\Broadcasting\Channel;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class MessageSent implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $id;
    public $senderId;
    public $receiverId;
    public $message;
    public $createdAt;
    public $updatedAt;

    public function __construct($id, $senderId, $receiverId, $message, $createdAt, $updatedAt)
    {
        $this->id = $id;
        $this->message = $message;
        $this->senderId = $senderId;
        $this->receiverId = $receiverId;
        $this->createdAt = $createdAt;
        $this->updatedAt = $updatedAt;
    }

    public function broadcastOn()
    {
        return new Channel('chat.' . $this->receiverId);
    }

    public function broadcastAs()
    {
        return 'message.sent';
    }

    public function broadcastWith() 
    {   
        \Log::info(' asda Broadcasting message:', [
            'id' => $this->id,
            'sender_id' => $this->senderId,
            'receiver_id' => $this->receiverId,
            'message' => $this->message,
            'created_at' => $this->createdAt,
            'updated_at' => $this->updatedAt,
        ]);
        return [
            "id" => $this->id,
            "message" => $this->message,
            "sender_id" => $this->senderId,
            "receiver_id" => $this->receiverId,
            "created_at" => $this->createdAt,
            "update_at" => $this->updatedAt
        ];
    }
}
