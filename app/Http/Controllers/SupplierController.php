<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use App\Http\Requests\SupplierRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\SupplierResource; // Import the SupplierResource

class SupplierController extends Controller
{
    // Display a listing of the suppliers
    public function index()
    {
        $suppliers = Supplier::all(); // Get all suppliers
        return SupplierResource::collection($suppliers); // Use SupplierResource for the collection
    }

    // Store a newly created supplier in storage
    public function store(SupplierRequest $request)
    {
        $supplier = Supplier::create([
            'name' => $request->name,
        ]);

        return new SupplierResource($supplier); // Return a single SupplierResource
    }

    // Display the specified supplier
    public function show($id)
    {
        $supplier = Supplier::findOrFail($id);
        return new SupplierResource($supplier); // Return a single SupplierResource
    }

    // Update the specified supplier in storage
    public function update(SupplierRequest $request, $id)
    {
        $supplier = Supplier::findOrFail($id);

        $supplier->update([
            'name' => $request->name,
        ]);

        return new SupplierResource($supplier); // Return a single SupplierResource
    }

    // Remove the specified supplier from storage (soft delete)
    public function destroy($id)
    {
        try {
            $supplier = Supplier::findOrFail($id);
            $supplier->delete();

            return response()->json(['message' => 'Supplier deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Supplier not found.'], 404);
        }
    }
}
