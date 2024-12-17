<?php

namespace App\Http\Controllers;

use App\Models\ServiceProvider;
use Illuminate\Http\Request;

class ServiceProviderController extends Controller
{
    /**
     * List all service providers.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // Get all service providers
        $providers = ServiceProvider::all();

        return response()->json([
            'message' => 'Service providers retrieved successfully!',
            'providers' => $providers
        ], 200);
    }

    /**
     * Get a specific service provider by ID.
     *
     * @param  int  $provider_id
     * @return \Illuminate\Http\Response
     */ 
    public function show($provider_id)
    {
        // Find the service provider by ID with its services
        $provider = ServiceProvider::with('services')->findOrFail($provider_id);

        return response()->json([
            'message' => 'Service provider retrieved successfully!',
            'provider' => $provider
        ], 200);
    }


    /**
     * Update the specified service provider.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $provider_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $provider_id)
    {
        try {
            // Validate request data
            $request->validate([
                'service_names' => 'nullable|string',
                'contact_info' => 'nullable|string',
                'address' => 'nullable|string',
                'location_lat' => 'nullable|numeric',
                'location_lng' => 'nullable|numeric',
                // 'business_permit_no' => 'nullable|string|unique:service_providers,business_permit_no,' . $provider_id,
                'business_hours_monday' => 'nullable|string',
                'business_hours_tuesday' => 'nullable|string',
                'business_hours_wednesday' => 'nullable|string',
                'business_hours_thursday' => 'nullable|string',
                'business_hours_friday' => 'nullable|string',
                'business_hours_saturday' => 'nullable|string',
                'business_hours_sunday' => 'nullable|string',
                'address' => 'nullable|string',         
            ]);

            // Find the service provider by ID
            $provider = ServiceProvider::where('provider_id', $provider_id)->firstOrFail();

            // Update provider details
            foreach ($request->all() as $key => $value) {
                $provider->$key = $value;
            }

            $provider->save();

            return response()->json([
                'message' => 'Service provider updated successfully!',
                'provider' => $provider,
                // 'request' => $request->all()
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $e->errors()
            ], 422);
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            return response()->json([
                'message' => 'Service provider not found'
            ], 404);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'An error occurred while updating the service provider',
                'error' => $e->getMessage()
            ], 500);
        }
    }
    
    
    public function getLocations()
    {
        // Get all service providers with their location details (latitude and longitude)
        $locations = ServiceProvider::select('name', 'location_lat', 'location_lng')->get();

        return response()->json([
            'message' => 'Service provider locations retrieved successfully!',
            'locations' => $locations
        ], 200);
    }
}
