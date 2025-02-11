<?php

namespace App\Services;

use Pusher\PushNotifications\PushNotifications;

class PushNotificationService
{
    protected $beamsClient;

    public function __construct()
    {
        $this->beamsClient =new \Pusher\PushNotifications\PushNotifications(
            array(
              "instanceId" => env('PUSHER_BEAMS_INSTANCE_ID'),
              "secretKey" => env('PUSHER_BEAMS_SECRET_KEY'),
            )
          );
    }

    public function sendNotification($userId, $title, $body)
    {
        $userIdString = (string) $userId;
        $interest = "user-".$userIdString;
        return $this->beamsClient->publishToInterests(
            array($interest),
            array("web" => array("notification" => array(
              "title" => $title,
              "body" => $body,
              "deep_link" => "https://www.pusher.com",
            )),
          ));
    }
}
