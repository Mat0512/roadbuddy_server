<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\ServiceProvider;
use App\Models\Driver;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;



class UserController extends Controller
{
    // User signup method
    public function signup(Request $request)
    {
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
            // 'profile_picture' => 'nullable|image|max:2048', // Optional for service providers and drivers
            'contact_info' => 'nullable|string|max:255', // Optional for service providers
            'location_lat' => 'nullable|numeric', // Optional for service providers
            'location_lng' => 'nullable|numeric', // Optional for service providers
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }
        Log::info('hello');

        // Create the user
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'password' => Hash::make($request->password),
            'username' => $request->username,
            'type' => $request->type,
        ]);

        Log::info('Your user value:', ['user' => $user]);


        // If user type is 'service_provider', create a ServiceProvider record
        if ($user->type === 'service_provider') {
            $serviceProvider = ServiceProvider::create([
                'name' => $request->name,
                'contact_info' => $request->contact_info,
                'location_lat' => $request->location_lat,
                'location_lng' => $request->location_lng,
                'profile_picture' => $request->profile_picture, // Ensure you handle file upload separately
                'provider_id' => $user->user_id, // Link service provider to user
            ]);
        }

        // If user type is 'driver', create a Driver record
        if ($user->type === 'driver') { // line 63
            $driver = Driver::create([
                'license_number' => $request->license_number,
                'vehicle' => $request->vehicle,
                'profile_picture' => $request->profile_picture, // Ensure you handle file upload separately
                'driver_id' => $user->user_id, // Link driver to user
            ]);
        }

        return response()->json(['message' => 'User created successfully!', 'user' => $user], 201);
    }

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
        $user = Auth::user(); // Get the authenticated user
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
            'username' => 'sometimes|string|max:255|unique:users,username,' . $user->user_id,
        ]);

        if ($validator->fails()) {
            return response()->json($validator->errors(), 422);
        }

        // Update user details
        $user->update($request->only('name', 'email', 'phone', 'username'));

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
}
