<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\DB;

use App\Http\Controllers\ServiceProviderController;
use App\Http\Controllers\ProviderServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ServiceRequestController;
use App\Http\Controllers\SPRatingController;


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
        Route::put('user/update', [UserController::class, 'updateUser']);
        Route::put("user/update-password", [UserController::class, 'updatePassword']);
    });
});


Route::prefix('/provider-services')->group(function () {
    // Store new provider service
    Route::post('', [ProviderServiceController::class, 'store']);
    // Update provider service
    Route::put('{provider_service_id}', [ProviderServiceController::class, 'update']);
    // Delete provider service
    Route::delete('{provider_service_id}', [ProviderServiceController::class, 'destroy']);
});

Route::prefix('/service-providers')->group(function () {
    // List all service providers
    Route::get('', [ServiceProviderController::class, 'index']);
    // Get a specific service provider by ID
    Route::get('{provider_id}', [ServiceProviderController::class, 'show']);
    // Update a service provider
    Route::put('{provider_id}', [ServiceProviderController::class, 'update']);
});


Route::prefix('/service-requests')->group(function () {
    // Get service request list
    Route::get('/', [ServiceRequestController::class, 'getList']);

    // Get service request by id
    Route::get('/{request_id}', [ServiceRequestController::class, 'getById']);

    // Create a service request
    Route::post('/', [ServiceRequestController::class, 'store']);

    // Update a service request by ID
    Route::put('/{request_id}', [ServiceRequestController::class, 'update']);

    // Rate a service request by ID
    Route::patch('/{request_id}/rate', [ServiceRequestController::class, 'rate']);
});


Route::prefix('/rating')->group(function () {
    // Route to create a new rating
    Route::post('', [SPRatingController::class, 'create']);

    // Route to update an existing rating
    Route::patch('/{rating_id}', [SPRatingController::class, 'update']);
});


