<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Events\ServiceRequestCreated;
use App\Events\ServiceRequestAccepted;
use App\Events\ServiceRequestCancelled; 
use App\Events\ServiceRequestCancelledForUser;
use App\Events\LocationUpdated;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ServiceRequestController extends Controller
{

    public function getRequestCounts($providerId)
    {
        $counts = ServiceRequest::where('provider_id', $providerId)
            ->selectRaw("
                COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_count,
                COUNT(CASE WHEN status = 'accepted' THEN 1 END) as in_progress_count,
                COUNT(CASE WHEN status = 'completed' THEN 1 END) as completed_count,
                COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_count
            ")
            ->first();

        return response()->json([
            'status' => 'success',
            'data' => [
                'pending' => $counts->pending_count,
                'in_progress' => $counts->in_progress_count,
                'completed' => $counts->completed_count + $counts->cancelled_count,
            ],
        ], 200);
    }

    public function getList(Request $request)
    {
        $providerId = $request->query('provider_id');
        $userId = $request->query('user_id');
        $status = $request->query('status');

        $query = ServiceRequest::select('requests.*', 'spr.rating_id', 'spr.rating', 'spr.comment')
            ->leftJoin('service_provider_ratings as spr', 'requests.request_id', '=', 'spr.request_id')
            ->with('service');

        if ($providerId) {
            $query->where('requests.provider_id', $providerId);
        }

        if ($userId) {
            $query->where('requests.user_id', $userId);
        }

        if ($status) {
            $query->where('requests.status', $status);
        }

        $serviceRequests = $query->get();

        $mappedServiceRequests = $serviceRequests->map(function ($request) {
            return [
                'request_id' => $request->request_id,
                'user_id' => $request->user_id,
                'provider_id' => $request->provider_id,
                'status' => $request->status,
                'location_lat' => $request->location_lat,
                'location_lng' => $request->location_lng,
                'service_id' => $request->service_id,
                'service_name' => $request->service ? $request->service->service_name : null,
                'rating' => $request->rating_id ? [
                    'rating_id' => $request->rating_id,
                    'rating' => $request->rating,
                    'comment' => $request->comment
                ] : null
            ];
        });

        return response()->json([
            'message' => 'Service requests retrieved successfully!',
            'service_requests' => $mappedServiceRequests,
            'user_id' => $userId,
            'status' => $status
        ], 200);
    }
        

     /**
      * Get a specific service request by ID.
      *
      * @param int $request_id
      * @return \Illuminate\Http\Response
      */
     public function getById($request_id)
     {
         // Find the service request by ID
         $serviceRequest = ServiceRequest::with(relations: ['user', 'provider','service'])->findOrFail($request_id);

         return response()->json([
             'message' => 'Service request retrieved successfully!',
             'service_request' => $serviceRequest
         ], 200);
     }



     public function store(Request $request)
     {
         try {
             // Validate request data
             $request->validate([
                 'user_id' => 'required|exists:users,user_id',
                 'provider_id' => 'required|exists:service_providers,provider_id',
                 'service_id' => 'required|exists:service_provider_services,provider_service_id',
                 'status' => 'required|string',
                 'location_lat' => 'required|numeric',
                 'location_lng' => 'required|numeric',
             ]);

             Log::info('Request data: ' . json_encode($request->all()));

             // Create a new service request
             $serviceRequest = ServiceRequest::create($request->all());

            //  // Optionally, broadcast the event here if needed
             broadcast(new ServiceRequestCreated($serviceRequest->request_id, $request->user_id, $request->provider_id))->toOthers();
            //  broadcast(new ServiceRequestCreated(1, 2, 3))->toOthers();

             return response()->json([
                 'message' => 'Service request created successfully!',
                 
                 'service_request' => $serviceRequest,
                 'serviceRequest.id' => $serviceRequest->request_id,
                 'user.id' => $serviceRequest->user_id,
                 'providerId.id' => $serviceRequest->provider_id
             ], 201);

         } catch (\Illuminate\Validation\ValidationException $e) {
             // Handle validation errors
             return response()->json([
                 'message' => 'Validation failed',
                 'errors' => $e->errors(),
             ], 422);
         } catch (\Exception $e) {
             // Handle general errors
             return response()->json([
                 'message' => 'An error occurred while creating the service request',
                 'error' => $e->getMessage(),
             ], 500);
         }
     }


    /**
     * Update the specified service request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $request_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $request_id)
    {
        try {
            $request->validate([
                'status' => 'required|string',
                'location_lat' => 'nullable|numeric',
                'location_lng' => 'nullable|numeric',
                'completion_time' => 'nullable|date',
            ]);
    
            // Find the service request by ID
            $serviceRequest = ServiceRequest::find($request_id);
            
            if (!$serviceRequest) {
                return response()->json([
                    'message' => 'Service request not found',
                ], 404);        
            }
    
            // Update the service request
            $serviceRequest->update($request->all());
    
            // Check the status and dispatch corresponding event
            if ($request->status == "accepted") {
                // Notify the service provider that the request is accepted
                Log::info('ServiceRequestAccepted event triggered');
                broadcast(new ServiceRequestAccepted($request_id, $serviceRequest->user_id, $serviceRequest->provider_id))->toOthers();
            } elseif ($request->status == "cancelled") {
                // Notify the user that the request is cancelled
                Log::info('ServiceRequestCancelled event triggered');
                broadcast(new ServiceRequestCancelled($request_id, $serviceRequest->user_id))->toOthers();
    
                // Notify the user that their request is cancelled
                // broadcast(new ServiceRequestCancelledForUser($request_id, $serviceRequest->user_id))->toOthers();
            }
    
            return response()->json([
                'message' => 'Service request updated successfully!',
                // 'service_request' => $serviceRequest
            ], 200);

        } catch (\Exception $e) {
            \Log::error('Error occurred: ' . $e->getMessage());
            return response()->json([
                'message' => 'Internal server error',
                'error' => $e->getMessage(),
            ], 500);
        }
      
    }

    /**
     * Rate a service request (this assumes rating is part of the request status).
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $request_id
     * @return \Illuminate\Http\Response
     */
    public function rate(Request $request, $request_id)
    {
        // Validate request data
        $request->validate([
            'rating' => 'required|numeric|min:1|max:5',
        ]);

        // Find the service request by ID
        $serviceRequest = ServiceRequest::findOrFail($request_id);

        // Update the status to "completed" and add the rating
        $serviceRequest->update([
            'status' => 'completed',
            'rating' => $request->rating,
            'completion_time' => now(),
        ]);

        return response()->json([
            'message' => 'Service request rated successfully!',
            'service_request' => $serviceRequest,
            'request_id' => $request_id
        ], 200);
    }

    public function updateLocation(Request $request)
    {
        $latitude = $request->input('latitude');
        $longitude = $request->input('longitude');
        $requestId = $request->input('requestId');  // Make sure the request contains a unique ID

        // Fire the event to broadcast the location update
        broadcast(new LocationUpdated($latitude, $longitude, $requestId))->toOthers();

        return response()->json(['message' => 'Location updated', 'latitude' =>  $latitude, 'longitude' => $longitude]);
    }
}
