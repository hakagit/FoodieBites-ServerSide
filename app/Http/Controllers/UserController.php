<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreUserRequest;
use App\Http\Requests\UpdateUserRequest;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\UserResource; // Import the UserResource

class UserController extends Controller
{
    // Display a listing of users (admin only)
    public function index()
    {
        $users = User::all();
        return UserResource::collection($users); // Use UserResource for the collection
    }

    // Store a newly created user
    public function store(StoreUserRequest $request)
    {
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
        ]);

        return new UserResource($user); // Return a single UserResource
    }

    // Display the specified user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return new UserResource($user); // Return a single UserResource
    }

    // Remove the specified user (soft delete)
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete(); // Soft delete the user

        return response()->json(null, 204); // No content response for deletion
    }
}
