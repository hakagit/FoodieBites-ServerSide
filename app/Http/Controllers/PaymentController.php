<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Order; // Import the Order model
use App\Http\Requests\PaymentRequest;
use App\Http\Resources\OrderResource;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\PaymentResource; // Import the PaymentResource

class PaymentController extends Controller
{
    // Display a listing of the payments
    public function index()
    {
        $payments = Payment::with('order')->get(); // Eager load the order relationship
        return PaymentResource::collection($payments); // Use PaymentResource for the collection
    }

    // Store a newly created payment in storage
    public function store(PaymentRequest $request)
    {
        // Fetch the order along with its order items
        $order = Order::with('orderItems')->where('id', '=', $request->order_id)->first();

        // Check if the order exists
        if (!$order) {
            return response()->json(['message' => 'Order not found'], 404);
        }

        // Calculate the total amount from the order items
        // Calculate the total amount from the order items
        $total = 0;
        foreach ($order->orderItems as $item) {
            // Ensure price and quantity are handled as strings but converted for calculation
            $price = (string)$item->price; // Keep as string
            $quantity = (string)$item->quantity; // Keep as string

            // Convert to numeric for calculation
            $numericPrice = is_numeric($price) ? (float)$price : 0;
            $numericQuantity = is_numeric($quantity) ? (int)$quantity : 0;

            $total += $numericPrice * $numericQuantity; // Perform the calculation
        }

        // Create the payment record
        $payment = Payment::create([
            'name' => $request->name,
            'card_number' => $request->card_number,
            'total' => $total, // This should now be set correctly
            'order_id' => $order->id,
        ]);

        // update order with random driver id

        return new OrderResource($order); // Return a single PaymentResource
    }

    // Display the specified payment
    public function show($id)
    {
        $payment = Payment::with('order')->findOrFail($id);
        return new PaymentResource($payment); // Return a single PaymentResource
    }

    // Update the specified payment in storage
    public function update(PaymentRequest $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $payment->update([
            'name' => $request->name,
            'card_number' => $request->card_number,
            'total' => $request->total,
            'order_id' => $request->order_id,
        ]);

        return new PaymentResource($payment); // Return a single PaymentResource
    }

    // Remove the specified payment from storage (soft delete)
    public function destroy($id)
    {
        try {
            $payment = Payment::findOrFail($id);
            $payment->delete();

            return response()->json(['message' => 'Payment deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Payment not found.'], 404);
        }
    }
}
