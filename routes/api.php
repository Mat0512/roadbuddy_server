<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SPRatingController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ContactController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::prefix('/auth')->group(function () {
    Route::post('signup', [UserController::class, 'signup']);
    Route::post('login', [UserController::class, 'login']);
    Route::middleware('auth:sanctum')->group(function () {
        Route::get('user', [UserController::class, 'getUser']);
        Route::put('user/update', action: [UserController::class, 'updateUser']);
        Route::put("user/update-password", [UserController::class, 'updatePassword']);
        Route::post('user/update-photo', action: [UserController::class, 'uploadPhoto']);
        Route::post('user/sp-update-photo', action: [ServiceProviderController::class, 'uploadPhoto']);

    });
});

Route::put("/user/subscription", [UserController::class, 'updateSubscription']);



Route::prefix('/provider-services')->group(function () {
    // Store new provider service
    Route::get('', [ProviderServiceController::class, 'index']);

    Route::post('', [ProviderServiceController::class, 'store']);
    // Update provider service
    Route::post('{provider_service_id}', [ProviderServiceController::class, 'update']);
    // Delete provider service
    Route::delete('{provider_service_id}', [ProviderServiceController::class, 'destroy']);
});

Route::prefix('/service-providers')->group(function () {

    Route::get('/locations', [ServiceProviderController::class, 'getLocations']);
     // Update a service provider
     Route::put('{provider_id}', [ServiceProviderController::class, 'update']);
    // List all service providers
    Route::get('', [ServiceProviderController::class, 'index']);
    // Get a specific service provider by ID
    Route::get('{provider_id}', [ServiceProviderController::class, 'show']);
   

});


Route::prefix('/service-requests')->group(function () {
    // Get service request list
    Route::get('/counts/{providerId}', [ServiceRequestController::class, 'getRequestCounts']);

    Route::get('/', [ServiceRequestController::class, 'getList']);

    Route::post('/location', [ServiceRequestController::class, 'updateLocation']);
   
    Route::get('/purhchase-details/{id}', [ServiceRequestController::class, 'getServiceRequest']);

    // Get service request by id
    Route::get('/{request_id}', [ServiceRequestController::class, 'getById']);

    // Create a service request
    Route::post('/', [ServiceRequestController::class, 'store']);

    // Update a service request by ID
    Route::put('/{request_id}', [ServiceRequestController::class, 'update']);

    // Rate a    request by ID
    Route::patch('/{request_id}/rate', [ServiceRequestController::class, 'rate']);
    

});


Route::prefix('/rating')->group(function () {
    // Route to create a new rating
    Route::post('', [SPRatingController::class, 'create']);

    // Route to update an existing rating
    Route::patch('/{rating_id}', [SPRatingController::class, 'update']);
});

Route::prefix('/chat')->group(function() {
    // Route to send a message
    Route::middleware('auth:sanctum')->post('/send', [ChatController::class, 'sendMessage'])->name(name: 'chat.send');
                                                                                                                                                                            
    // Route to list all chat rooms for the authenticated user
    Route::middleware('auth:sanctum')->get('/rooms', [ChatController::class, 'listChatRooms'])->name('chat.rooms');

    // Route to get messages with a specific user
    Route::middleware('auth:sanctum')->get('/messages/{id}', [ChatController::class, 'getMessages'])->name('chat.messages');
});

Route::prefix('/analytics')->group(function() {
    // Route to send a message
    Route::middleware('auth:sanctum')->get('/revenue/{userId}', [ServiceRequestController::class, 'getTotalRevenuePerMonth']);
                                                                                                                                                                            
    // Route to list all chat rooms for the authenticated user
    Route::middleware('auth:sanctum')->get('/services/{userId}', [ServiceRequestController::class, 'getTotalAvailedServices']);

    // Route to get messages with a specific user

});

Route::post('/send-email', [ContactController::class, 'sendEmail']);


// PUSHER BEAMS Notification

// Route::middleware('auth:api')->get('/pusher/beams-auth', function (Request $request) {
//     $userID = $request->user()->id; // If you use a different auth system, do your checks here
//     $userIDInQueryParam = Input::get('user_id');

//     if ($userID != $userIDInQueryParam) {
//         return response('Inconsistent request', 401);
//     } else {
//         $beamsToken = $beamsClient->generateToken($userID);
//         return response()->json($beamsToken);
//     }
// }); 