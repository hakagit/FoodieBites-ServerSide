<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Http\Requests\InventoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\InventoryResource; // Import the InventoryResource
use App\Http\Resources\InventoryCollection; // Optional for collections

class InventoryController extends Controller
{
    // Display a listing of the inventories
    public function index()
    {
        \Log::info('Fetching all inventory items');

        // Eager load both user and suppliers relationships
        $inventories = Inventory::with(['user', 'suppliers'])->get();
        return InventoryResource::collection($inventories); // Return the resource collection
    }

    // Store a newly created inventory in storage
    public function store(InventoryRequest $request)
    {
        $inventory = Inventory::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'expiry' => $request->expiry,
            'user_id' => $request->user_id,
        ]);

        return new InventoryResource($inventory); // Return a single InventoryResource
    }

    // Display the specified inventory
    public function show($id)
    {
        $inventory = Inventory::with('user')->findOrFail($id);
        return new InventoryResource($inventory); // Return a single InventoryResource
    }

    // Update the specified inventory in storage
    public function update(InventoryRequest $request, $id)
    {
        $inventory = Inventory::findOrFail($id);

        $inventory->update($request->only(['name', 'quantity', 'expiry', 'user_id'])); // Use mass assignment

        return new InventoryResource($inventory); // Return a single InventoryResource
    }

    // Remove the specified inventory from storage (soft delete)
    public function destroy($id)
    {
        try {
            $inventory = Inventory::findOrFail($id);
            $inventory->delete();

            return response()->json(['message' => 'Inventory item deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Inventory item not found.'], 404);
        }
    }
}
