<?php

namespace App\Http\Controllers;

use App\Models\ServiceRequest;
use App\Events\ServiceRequestCreated;
use Illuminate\Http\Request;

class ServiceRequestController extends Controller
{
    /**
     * Create a new service request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


     public function getList(Request $request)
     {
         // Retrieve query parameters
         $providerId = $request->query('provider_id');
         $userId = $request->query('user_id');
         $status = $request->query('status');

         // Build the query with optional filtering
         $query = ServiceRequest::with('service'); // Eager load related service data

         // Filter by provider_id if provided
         if ($providerId) {
             $query->where('provider_id', $providerId);
         }

         if ($userId) {
            $query->where('user_id', $userId);
        }

         // Filter by status if provided
         if ($status) {
             $query->where('status', $status);
         }

         // Get the filtered list of service requests
         $serviceRequests = $query->get();

         // Map results to include the service_name directly
         $serviceRequests = $serviceRequests->map(function ($request) {
             return [
                 'request_id' => $request->request_id,
                 'user_id' => $request->user_id,
                 'provider_id' => $request->provider_id,
                 'status' => $request->status,
                 'location_lat' => $request->location_lat,
                 'location_lng' => $request->location_lng,
                 'service_id' => $request->service_id,
                 'service_name' => $request->service ? $request->service->service_name : null, // Include service name if available
             ];
         });

         return response()->json([
             'message' => 'Service requests retrieved successfully!',
             'service_requests' => $serviceRequests,
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
         $serviceRequest = ServiceRequest::findOrFail($request_id);

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

             // Create a new service request
             $serviceRequest = ServiceRequest::create($request->all());

             // Optionally, broadcast the event here if needed

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
        // Validate request data
        $request->validate([
            'status' => 'required|string',
            'location_lat' => 'nullable|numeric',
            'location_lng' => 'nullable|numeric',
            'completion_time' => 'nullable|date',
        ]);

        // Find the service request by ID
        $serviceRequest = ServiceRequest::findOrFail($request_id);

        // Update the service request
        $serviceRequest->update($request->all());

        // Check the status and dispatch corresponding event
        if ($request->status == "accepted") {
            // Notify the service provider that the request is accepted
            broadcast(new ServiceRequestAccepted($request_id, $serviceRequest->user_id, $serviceRequest->provider_id))->toOthers();
        } elseif ($request->status == "cancelled") {
            // Notify the service provider that the request is cancelled
            broadcast(new ServiceRequestCancelledForProvider($request_id, $serviceRequest->provider_id))->toOthers();

            // Notify the user that their request is cancelled
            broadcast(new ServiceRequestCancelledForUser($request_id, $serviceRequest->user_id))->toOthers();
        }

        return response()->json([
            'message' => 'Service request updated successfully!',
            'service_request' => $serviceRequest
        ], 200);
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
}
