<?php

namespace App\Http\Controllers;

use App\Models\Driver;
use App\Http\Requests\DriverRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\DriverResource; // Import the DriverResource
use App\Http\Resources\DriverCollection; // Optional for collections

class DriverController extends Controller
{
    // Display a listing of the drivers
    public function index()
    {
        $drivers = Driver::with('order')->get(); // Eager load the order relationship
        return DriverResource::collection($drivers); // Use DriverResource for the collection
    }

    // Store a newly created driver in storage
    public function store(DriverRequest $request)
    {
        $driver = Driver::create([
            'name' => $request->name,
            'driver_license' => $request->driver_license,
            'order_id' => $request->order_id,
        ]);

        return new DriverResource($driver); // Return a single DriverResource
    }

    // Display the specified driver
    public function show($id)
    {
        $driver = Driver::with('order')->findOrFail($id);
        return new DriverResource($driver); // Return a single DriverResource
    }

    // Update the specified driver in storage
    public function update(DriverRequest $request, $id)
    {
        $driver = Driver::findOrFail($id);

        $driver->update($request->only(['name', 'driver_license', 'order_id'])); // Use mass assignment

        return new DriverResource($driver); // Return a single DriverResource
    }

    // Remove the specified driver from storage (soft delete)
    public function destroy($id)
    {
        try {
            $driver = Driver::findOrFail($id);
            $driver->delete();

            return response()->json(['message' => 'Driver deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Driver not found.'], 404);
        }
    }
}
