<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\Driver;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

use App\Utils\FileUploader; 



class UserController extends Controller
{

public function signup(Request $request)
{
    try {
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'phone' => 'required|string|max:15',
        'password' => 'required|string|min:8|confirmed',
        'username' => 'required|string|max:255|unique:users',
        'type' => 'required|string|in:user,service_provider,driver', // Ensure type is valid
        'license_number' => 'nullable|string|max:255', // Optional for drivers
        'vehicle' => 'nullable|string|max:255', // Optional for drivers
        'profile_picture' => 'nullable|image|max:2048', // Optional for service providers and drivers
        'contact_info' => 'nullable|string|max:255', // Optional for service providers
        'business_permit_no' => 'nullable|string|max:255|unique:service_providers', // Optional for service providers
        'logo' => 'nullable|image|max:2048', // Logo image for service provider
        'business_permit_image' => 'nullable|image|max:2048', // Business permit image
        'address' => 'nullable|string|max:255', // Add this to validator
        'business_hours_monday' => 'nullable|string|max:50',
        'business_hours_tuesday' => 'nullable|string|max:50',
        'business_hours_wednesday' => 'nullable|string|max:50',
        'business_hours_thursday' => 'nullable|string|max:50',
        'business_hours_friday' => 'nullable|string|max:50',
        'business_hours_saturday' => 'nullable|string|max:50',
        'business_hours_sunday' => 'nullable|string|max:50',
        'category' => 'nullable|string|max:255',
        'service_provider_name' => 'nullable|string|max:255',


    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Create the user
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'password' => Hash::make($request->password),
        'username' => $request->username,
        'type' => $request->type,   
        // 'profile_picture' => FileUploader::handleFileUpload($request, 'profile_picture'), // Handle file upload

    ]);

    // If user type is 'service_provider', create a ServiceProvider record
    if ($user->type === 'service_provider') {
        $serviceProviderData = [
            'provider_id' => $user->user_id,
            'service_provider_name' => $request->service_provider_name,
            'contact_info' => $request->contact_info,
            'address' => $request->address,
            'business_permit_no' => $request->business_permit_no,
            'business_hours_monday' => $request->business_hours_monday,
            'business_hours_tuesday' => $request->business_hours_tuesday,
            'business_hours_wednesday' => $request->business_hours_wednesday,
            'business_hours_thursday' => $request->business_hours_thursday,
            'business_hours_friday' => $request->business_hours_friday,
            'business_hours_saturday' => $request->business_hours_saturday,
            'business_hours_sunday' => $request->business_hours_sunday,
            'location_lat' => $request->location_lat,
            'location_lng' => $request->location_lng,
            'category' => $request->category,


        ];

        // Handle file uploads
        if ($request->hasFile('logo')) {
            $logo = FileUploader::uploadImageToCloudinary($request->file('logo'));
            $serviceProviderData['logo'] = $logo;
        }

        if ($request->hasFile('business_permit_image')) {
            $permitImage = FileUploader::uploadImageToCloudinary($request->file('business_permit_image'));
            $serviceProviderData['business_permit_image'] = $permitImage;
        }   

        // Create the service provider record
        $serviceProvider = ServiceProvider::create($serviceProviderData);
        
    }

    // If user type is 'driver', create a Driver record
    if ($user->type === 'driver') {
        $driver = Driver::create([
            'license_number' => $request->license_number,
            'vehicle' => $request->vehicle,
            'driver_id' => $user->user_id   , // Link driver to user
        ]);
    }

    return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
   } catch (\Exception $e) {
    return response()->json(['error' => $e->getMessage()], 500);

   }
}

/**

 * Handle file uploads for profile picture.
 *
 * @param  \Illuminate\Http\Request  $request
 * @param  string  $fieldName
 * @return string|null
 */



    // User login method
    public function login(Request $request)
{
    // Validate the request data
    $validator = Validator::make($request->all(), [
        'username' => 'required|string',
        'password' => 'required|string',
    ]);

    if ($validator->fails()) {
        return response()->json($validator->errors(), 422);
    }

    // Attempt to log the user in using username instead of email
    if (Auth::attempt($request->only('username', 'password'))) {
        $user = Auth::user();

        $user->load('serviceProviders');

        $token = $user->createToken('authToken')->plainTextToken;

        return response()->json([
            'message' => 'Login successful!',
            'user' => $user,
            'token' => $token
        ], 200);
    }

    return response()->json(['message' => 'Invalid credentials!'], 401);
}


    // Get user details method
    public function getUser(Request $request)
    {
        $user = Auth::user()->load('serviceProviders'); // Get the authenticated user
        return response()->json($user, 200);
    }

    // Update user details method
    public function updateUser(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'name' => 'sometimes|string|max:255',
            'email' => 'sometimes|string|email|max:255|unique:users,email,' . $user->user_id,
            'phone' => 'sometimes|string|max:15',
            'isSubscribed' => 'sometimes|boolean|max:15',
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->user_id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update user details
        $user->update($request->only('name', 'email', 'phone', 'username', 'isSubscribed'));

        return response()->json(['message' => 'User updated successfully!', 'user' => $user], 200);
    }

    // Update user password method
    public function updatePassword(Request $request)
    {
        $user = Auth::user(); // Get the authenticated user

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return response()->json(['message' => 'Current password is incorrect!'], 401);
        }

        // Update the password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return response()->json(['message' => 'Password updated successfully!'], 200);
    }

    
    public function uploadPhoto (Request $request ) {
        try {

            $user = Auth::user();
            $found_user = User::find($user->user_id);

            $request->validate([
                'photo' => 'required|image|max:2048',
            ]);


            $uploaded_picture = "";

            if ($request->hasFile('photo')) {
                $uploaded_picture = FileUploader::uploadImageToCloudinary($request->file('photo'));
                $found_user->profile_picture = $uploaded_picture;
                $found_user->save();

                return response()->json( ["message" => "Profile picture uploaded"], 200);
            } 

            return response()->json(["error" =>$request->file('photo')], 400);
            
            // return response()->json(["message" => "api route workinh"], 201);



        } catch (\Exception $error) {
            return response()->json(['error' => $error->getMessage()], 500);
        }
    }

    public function updateSubscription(Request $request)
    {

        // Validate the request data
        $validator = Validator::make($request->all(), [
            'userId' => 'required|string|max:255',
            'isSubscribed' => 'required|boolean',

        ]);


        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        $user = User::find($request->userId);

        // Update user details
        $user->isSubscribed = $request->isSubscribed;
        $user->save();


        return response()->json(['message' => 'User updated successfully!', 'user' => $user], 200);
    }
}
