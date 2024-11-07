<?php

namespace App\Listeners;

use App\Events\ServiceRequest;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class NewRequestListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\ServiceRequest  $event
     * @return void
     */
    public function handle(ServiceRequest $event)
    {
        $receiverId = $event->receiverId;
        $message = $event->message;

        broadcast(new NewPrivateMessageNotification($message))->toOthers();
    }
}
