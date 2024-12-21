            <?php

            use Illuminate\Support\Facades\Broadcast;
            use App\Models\User;
            use Illuminate\Support\Facades\Log;
            /*
            |--------------------------------------------------------------------------
            | Broadcast Channels
            |--------------------------------------------------------------------------
            |
            | Here you may register all of the event broadcasting channels that your
            | application supports. The given channel authorization callbacks are
            | used to check if an authenticated user can listen to the channel.
            |
            */

            Broadcast::channel('user.{userId}', function ($user, $userId) {
                Log::info('Broadcast::channel user.{userId} data: ' . json_encode([
                    'user' => $user,
                    'userId' => $userId
                ]));
                return (int) $user->id === (int) $userId;
            });

            Broadcast::channel('service-provider.{providerId}', function ($user, $providerId) {
                return (int) $user->id === (int) $providerId && $user->is_service_provider;
            });

            // routes/channels.php
            Broadcast::channel('chat.{chatId}', function ($chat, $chatId) {
                return (int) $chat->id === (int) $chatId;
            });

            // routes/channels.php
            Broadcast::channel('location.{serviceId}', function ($service, $serviceId) {
                return (int) $service->id === (int) $serviceId;
            });
