<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\User; // Corrected capitalization for User model
use App\Http\Requests\AddressRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use App\Http\Resources\AddressResource;
use App\Http\Resources\AddressCollection; // If you create a collection resource

class AddressController extends Controller
{
    // Display a listing of the addresses
    public function index()
    {
        $addresses = Address::with('user')->get(); // Eager load the user relationship
        return AddressResource::collection($addresses); // Use AddressResource for the collection
    }

    // Store a newly created address in storage
    public function store(AddressRequest $request)
    {
        $address = Address::create([
            'street' => $request->street,
            'apartment' => $request->apartment,
            'user_id' => $request->user_id,
        ]);

        return new AddressResource($address); // Return a single AddressResource
    }

    // Display the specified address
    public function show($id)
    {
        $address = Address::with('user')->findOrFail($id);
        return new AddressResource($address); // Return a single AddressResource
    }

    // Update the specified address in storage
    public function update(AddressRequest $request, $id)
    {
        $address = Address::findOrFail($id);

        $address->update($request->only(['street', 'apartment', 'user_id'])); // Use mass assignment

        return new AddressResource($address); // Return a single AddressResource
    }

    // Remove the specified address from storage (soft delete)
    public function destroy($id)
    {
        try {
            $address = Address::findOrFail($id);
            $address->delete();

            return response()->json(['message' => 'Address deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Address not found.'], 404);
        }
    }
}
