<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\RegisterUserRequest;
use App\Http\Requests\LoginUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request;
use App\Http\Resources\UserResource; // Import the UserResource

class AuthController extends Controller
{
    // Register a new user
    public function register(RegisterUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        // Create a new token for the user
        $token = $user->createToken('foodie-bites')->plainTextToken;

        return response()->json(['token' => $token], 201);
    }

    // Login user
    public function login(LoginUserRequest $request)
    {
        // Attempt to authenticate the user with the provided credentials
        if (Auth::attempt($request->only('email', 'password'))) {
            $user = Auth::user(); // Get the authenticated user
            $token = $user->createToken('foodie-bites')->plainTextToken; // Create the token

            // Return the token, userId, and userRole in the response
            return response()->json([
                'token' => $token,
                'userId' => $user->id,        // Assuming 'id' is the primary key for your User model
                'userRole' => $user->role,    // Assuming 'role' is an attribute in your User model
            ]);
        }

        // Return error response if authentication fails
        return response()->json(['error' => 'Unauthorized'], 401);
    }
    // Get authenticated user
    public function showUser(Request $request)
    {
        $user = Auth::user();

        return new UserResource($user); // Return a UserResource for the authenticated user
    }

    // Logout user
    public function logout(Request $request)
    {
        Auth::logout();

        return response()->json(['message' => 'Logged out successfully']);
    }
}
