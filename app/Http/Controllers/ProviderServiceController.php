<?php

namespace App\Http\Controllers;

use App\Models\ProviderService;
use Illuminate\Http\Request;
use App\Utils\FileUploader;
use Illuminate\Support\Facades\Log;

class ProviderServiceController extends Controller
{

   /**
 * Get a list of services filtered by provider_id.
 *
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
    public function index(Request $request)
    {
        try {
            // Get the provider_id from the request (query parameter)
            $providerId = $request->query('provider_id');

            // Query the services with optional filtering by provider_id
            $query = ProviderService::with('serviceProvider');
            
            if ($providerId) {
                $query->where('provider_id', $providerId);
            }

            $services = $query->get();

            return response()->json([
                'success' => true,
                'data' => $services,
            ], 200);
        } catch (\Exception $e) {
            Log::error('Provider Service Index Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString()
            ]);
            
            return response()->json([
                'success' => false,
                'message' => 'Failed to fetch services.',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
    }

    /**
     * Store a new provider service.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            // Validate request data
            $request->validate([
                'provider_id' => 'required|exists:service_providers,provider_id',
                'service_name' => 'required|string',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
        ]);

        // Create a new ProviderService
        $providerService = ProviderService::create([
            'provider_id' => $request->provider_id,
            'service_name' => $request->service_name,
            'price' => $request->price,
            'description' => $request->description,
        ]);

        if ($request->hasFile('image')) {
            $image = FileUploader::uploadImageToCloudinary($request->file('image'));
            $providerService->image = $image;
            $providerService->save();
        }

        return response()->json([
            'message' => 'Provider service created successfully!',
            'provider_service' => $providerService
        ], 201); 
    } catch (\Exception $e) {
        Log::error('Provider Service Store Error: ' . $e->getMessage(), [
            'exception' => $e,
            'trace' => $e->getTraceAsString(),
            'request_data' => $request->all()
        ]);

        return response()->json([
            'success' => false,
            'message' => 'Failed to create provider service.',
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ], 500);
    }
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
         try {
            // Validate request data
            $validated = $request->validate([
                'provider_id' => 'nullable|exists:service_providers,provider_id',
                'service_name' => 'required|string',
                'price' => 'required|numeric',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
            ]);

            // Find the provider service by ID
            $providerService = ProviderService::findOrFail($provider_service_id);

            // Update provider service with new data
            $providerService->update([
                'provider_id' => $request->provider_id,
                'service_name' => $request->service_name,
                'price' => $request->price,
                'description' => $request->description,
            ]);

            // Handle image upload
            
            if ($request->hasFile('image')) {
                $image = FileUploader::uploadImageToCloudinary($request->file('image'));
                $providerService->image = $image;
                $providerService->save();
            }

            return response()->json([
                'message' => 'Provider service updated successfully!',
                'provider_service' => $providerService,
                'request_data' => $request->all()
            ], 200);

        } catch (ValidationException $e) {
            // Handle validation errors
            return response()->json([
                'message' => 'Validation Error',
                'errors' => $e->errors()
            ], 422);

        } catch (ModelNotFoundException $e) {
            // Handle case when provider service is not found
            return response()->json([
                'message' => 'Provider Service Not Found',
                'error' => $e->getMessage()
            ], 404);

        } catch (\Exception $e) {
            Log::error('Provider Service Update Error: ' . $e->getMessage(), [
                'exception' => $e,
                'trace' => $e->getTraceAsString(),
                'provider_service_id' => $provider_service_id,
                'request_data' => $request->all()
            ]);
            
            return response()->json([
                'message' => 'An error occurred while updating the provider service',
                'error' => $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine(),
                'trace' => $e->getTraceAsString()
            ], 500);
        }
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
