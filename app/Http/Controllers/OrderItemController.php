<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Models\Driver; // Import the Driver model
use App\Http\Requests\OrderItemRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\OrderItemResource; // Import the OrderItemResource
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class OrderItemController extends Controller
{
    // Display a listing of the order items
    public function index()
    {
        $orderItems = OrderItem::with('order')->get(); // Eager load the order relationship
        return OrderItemResource::collection($orderItems); // Use OrderItemResource for the collection
    }

    // Store a newly created order item in storage
    public function store(OrderItemRequest $request)
    {
        $drivers = Driver::all();

        if ($drivers->isEmpty()) {
            return response()->json(['message' => 'No drivers available'], 400);
        }

        // Select a random driver
        $randomDriver = $drivers->random();
        Log::info('Selected Driver:', ['driver_id' => $randomDriver->id]);

        // Create the order item
        $orderItem = OrderItem::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'price' => $request->price,
            'order_id' => $request->order_id,
            'driver_id' => $randomDriver->id, // Ensure this is set
        ]);

        Log::info('Created Order Item:', $orderItem->toArray());

        return new OrderItemResource($orderItem);
    }

    // Display the specified order item
    public function show($id)
    {
        // Retrieve order items associated with the given order ID
        $orderItems = OrderItem::with(['order', 'driver']) // Eager load order and driver relationships
            ->where('order_id', $id)
            ->get();

        // Get the authenticated user's name
        $userName = Auth::user()->name;

        // Return a collection of OrderItemResource along with the user's name
        return response()->json([
            'user_name' => $userName,
            'data' => OrderItemResource::collection($orderItems),
        ]);
    }

    // Update the specified order item in storage
    public function update(OrderItemRequest $request, $id)
    {
        $orderItem = OrderItem::findOrFail($id);

        $orderItem->update($request->only(['name', 'quantity', 'price', 'order_id'])); // Use mass assignment

        return new OrderItemResource($orderItem); // Return a single OrderItemResource
    }

    // Remove the specified order item from storage (soft delete)
    public function destroy($id)
    {
        try {
            $orderItem = OrderItem::findOrFail($id);
            $orderItem->delete();

            return response()->json(['message' => 'Order item deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order item not found.'], 404);
        }
    }
}
