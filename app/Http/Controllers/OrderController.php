<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest;
use App\Models\Order;
use App\Http\Requests\StoreOrderRequest; // Use the new form request
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\OrderResource; // Import the OrderResource
use App\Models\Dish;
use App\Models\OrderItem;
use Illuminate\Support\Facades\Auth;

class OrderController extends Controller
{
    // Display a listing of the orders
    public function index()
    {
        $orders = Order::with(['user', 'driver'])->get(); // Eager load the relationships
        return OrderResource::collection($orders); // Use OrderResource for the collection
    }

    // Store a newly created order in storage
    public function store(OrderRequest $request) // Use StoreOrderRequest for validation
    {
        $user = Auth::user();

        $order = Order::create([
            'name' => $request->name,
            'date' => $request->date,
            'user_id' => $user->id,
            'driver_id' => $request->driver_id, // Include driver_id from request
        ]);

        return new OrderResource($order); // Return a single OrderResource
    }

    // Display the specified order
    public function show($id)
    {
        $order = Order::with(['user', 'driver'])->findOrFail($id);

        return new OrderResource($order); // Return a single OrderResource
    }

    // Update the specified order in storage
    public function update(OrderRequest $request, $id) // Use StoreOrderRequest for validation
    {
        $order = Order::findOrFail($id);

        $order->update([
            'name' => $request->name,
            'date' => $request->date,
            'user_id' => $request->user_id,
            'driver_id' => $request->driver_id,
        ]);

        return new OrderResource($order); // Return a single OrderResource
    }

    // Remove the specified order from storage (soft delete)
    public function destroy($id)
    {
        try {
            $order = Order::findOrFail($id);
            $order->delete();

            return response()->json(['message' => 'Order deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Order not found.'], 404);
        }
    }

    public function customerOrder(StoreOrderRequest $request)
    {
        // Create the order using authenticated user's name and ID
        $order = Order::create([
            'name' => Auth::user()->name,
            'date' => now(),
            'user_id' => Auth::id(),
            'driver_id' => $request->driver_id, // Include driver_id from request if provided
        ]);

        // Retrieve dishes based on IDs from the request
        $dishes = $request->input('dishIds');

        // Check for empty or invalid dish IDs
        if (empty($dishes) || !is_array($dishes)) {
            return response()->json(['message' => 'Invalid dish IDs provided.'], 400);
        }

        // Get dishes based on IDs
        $dishesArray = Dish::query()->whereIn('id', $dishes)->get();

        // Prepare order items
        $orderItems = [];
        foreach ($dishesArray as $dish) {
            if ($dish) {
                $orderItems[] = [
                    'name' => $dish->name,
                    'quantity' => 1,
                    'price' => $dish->price,
                    'order_id' => $order->id,
                    'driver_id' => $order->driver_id, // Assign the driver_id from the order
                ];
            }
        }

        // Insert order items
        if (!empty($orderItems)) {
            OrderItem::insert($orderItems);
        }

        return response()->json(['message' => 'success', 'order_id' => $order->id]);
    }
}
