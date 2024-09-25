<?php

namespace App\Http\Controllers;

use App\Models\Dish;
use App\Http\Requests\DishRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\DishResource; // Import the DishResource
use App\Http\Resources\DishCollection; // Optional for collections

class DishController extends Controller
{
    // Display a listing of the dishes
    public function index()
    {
        $dishes = Dish::with('category')->get(); // Eager load the category relationship
        return DishResource::collection($dishes); // Use DishResource for the collection
    }

    public function dishesById($categoryId)
    {
        // Retrieve dishes by category ID
        $dishes = Dish::where('category_id', $categoryId)->get();

        // Return the dishes as a JSON response
        return response()->json($dishes);
    }

    // Store a newly created dish in storage
    public function store(DishRequest $request)
    {
        // Create a new dish instance
        $dish = Dish::create([
            'name' => $request->name,
            'price' => $request->price,
            'category_id' => $request->category_id,
        ]);

        // Handle the image upload if provided
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/dishes', $originalName, 'public');
            $dish->image = $path;
            $dish->save();
        }

        return new DishResource($dish); // Return a single DishResource
    }

    // Display the specified dish
    public function show($id)
    {
        $dish = Dish::with('category')->findOrFail($id);
        return new DishResource($dish); // Return a single DishResource
    }

    // Update the specified dish in storage
    public function update(DishRequest $request, $id)
    {
        $dish = Dish::findOrFail($id);

        // Update dish details
        $dish->update($request->only(['name', 'price', 'category_id']));

        // Handle the image upload if provided
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/dishes', $originalName, 'public');
            $dish->image = $path;
            $dish->save();
        }

        return new DishResource($dish); // Return a single DishResource
    }

    // Remove the specified dish from storage (soft delete)
    public function destroy($id)
    {
        try {
            $dish = Dish::findOrFail($id);
            $dish->delete();

            return response()->json(['message' => 'Dish item deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Dish item not found.'], 404);
        }
    }
}
