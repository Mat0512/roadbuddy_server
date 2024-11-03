<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Models\ServiceProviderRating;

class SPRatingController extends Controller
{
    /**
     * Create a new rating.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function create(Request $request)
    {
        // Validate the request data
        $validator = Validator::make($request->all(), [
            'driver_id' => 'required|exists:drivers,driver_id',
            'service_provider_id' => 'required|exists:service_providers,provider_id',
            'rating' => 'required|numeric|min:1|max:5', // Assuming ratings are between 1 and 5
        ]);
        
        // Check if validation fails
        if ($validator->fails()) {
            // Return the error messages as a JSON response
            return response()->json([
                'message' => 'Validation failed',
                'errors' => $validator->errors(),
            ], 422); // 422 Unprocessable Entity
        }

        // Use validated data to create a new rating
        $rating = ServiceProviderRating::create($validator->validated());

        return response()->json([
            'message' => 'Rating created successfully.',
            'data' => $rating,
        ], 200);
    }



    /**
     * Update an existing rating.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $rating_id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $rating_id)
    {
        $validated = $request->validate([
            'rating' => 'required|numeric|min:1|max:5', // Assuming ratings are between 1 and 5
        ]);

        $rating = ServiceProviderRating::findOrFail($rating_id);
        $rating->update($validated);

        return response()->json([
            'message' => 'Rating updated successfully.',
            'data' => $rating,
        ], 200);
    }
}
