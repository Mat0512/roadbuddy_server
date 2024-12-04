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
        // Validate request data
        $request->validate([
            'name' => 'required|string',
            'contact_info' => 'required|string',
            'location_lat' => 'required|numeric',
            'location_lng' => 'required|numeric',
        ]);

        // Find the service provider by ID
        $provider = ServiceProvider::findOrFail($provider_id);

        // Update provider details
        $provider->update($request->all());

        return response()->json([
            'message' => 'Service provider updated successfully!',
            'provider' => $provider
        ], 200);
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
