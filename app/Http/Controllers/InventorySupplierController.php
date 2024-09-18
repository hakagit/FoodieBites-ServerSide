<?php

namespace App\Http\Controllers;

use App\Models\Inventory;
use App\Models\Supplier;
use App\Http\Requests\AttachSuppliersRequest;
use App\Http\Requests\DetachSuppliersRequest;
use App\Http\Resources\SupplierResource; // Import the SupplierResource
use App\Http\Resources\InventoryResource; // Import the InventoryResource

class InventorySupplierController extends Controller
{
    // Attach suppliers to an inventory
    public function attachSuppliers(AttachSuppliersRequest $request, $inventoryId)
    {
        $inventory = Inventory::findOrFail($inventoryId);
        $inventory->suppliers()->attach($request->supplier_ids); // Attach suppliers

        return response()->json(['message' => 'Suppliers attached successfully.']);
    }

    // Detach suppliers from an inventory
    public function detachSuppliers(DetachSuppliersRequest $request, $inventoryId)
    {
        $inventory = Inventory::findOrFail($inventoryId);
        $inventory->suppliers()->detach($request->supplier_ids); // Detach suppliers

        return response()->json(['message' => 'Suppliers detached successfully.']);
    }

    // List all suppliers for a specific inventory
    public function showSuppliers($inventoryId)
    {
        $inventory = Inventory::with('suppliers')->findOrFail($inventoryId);
        return SupplierResource::collection($inventory->suppliers); // Use SupplierResource
    }

    // List all inventories for a specific supplier
    public function showInventories($supplierId)
    {
        $supplier = Supplier::with('inventories')->findOrFail($supplierId);
        return InventoryResource::collection($supplier->inventories); // Use InventoryResource
    }
}
