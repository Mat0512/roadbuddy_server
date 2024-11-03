<?php

namespace App\Http\Controllers;

use App\Models\ProviderService;
use Illuminate\Http\Request;

class ProviderServiceController extends Controller
{
    /**
     * Store a new provider service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Validate request data
        $request->validate([
            'provider_id' => 'required|exists:service_providers,provider_id',
            'service_name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Create a new ProviderService
        $providerService = ProviderService::create($request->all());

        return response()->json([
            'message' => 'Provider service created successfully!',
            'provider_service' => $providerService
        ], 201);
    }

    /**
     * Update the specified provider service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $provider_service_id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $provider_service_id)
    {
        // Validate request data
        $request->validate([
            'provider_id' => 'nullable|exists:service_providers,provider_id',
            'service_name' => 'required|string',
            'price' => 'required|numeric',
            'description' => 'nullable|string',
        ]);

        // Find the provider service by ID
        $providerService = ProviderService::findOrFail($provider_service_id);

        // Update provider service with new data
        $providerService->update($request->all());

        return response()->json([
            'message' => 'Provider service updated successfully!',
            'provider_service' => $providerService
        ], 200);
    }

    /**
     * Remove the specified provider service.
     *
     * @param  int  $provider_service_id
     * @return \Illuminate\Http\Response
     */
    public function destroy($provider_service_id)
    {
        // Find the provider service by ID and delete it
        $providerService = ProviderService::findOrFail($provider_service_id);
        $providerService->delete();

        return response()->json([
            'message' => 'Provider service deleted successfully!'
        ], 200);
    }
}
