<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\CategoryRequest;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use App\Http\Resources\CategoryResource; // Import the CategoryResource
use App\Http\Resources\CategoryCollection; // Optional for collections

class CategoryController extends Controller
{
    // Display a listing of the categories
    public function index()
    {
        $categories = Category::with('dishes')->get();

        return CategoryResource::collection($categories); // Use CategoryResource for the collection
    }

    // Store a newly created category in storage
    public function store(CategoryRequest $request)
    {
        // Create a new category from the request
        $category = Category::create([
            'name' => $request->name,
            'quantity' => $request->quantity,
            'user_id' => $request->user_id,
        ]);

        // Handle the image upload
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/categories', $originalName, 'public');
            $category->image = $path;
            $category->save();
        }

        return new CategoryResource($category); // Return a single CategoryResource
    }

    // Display the specified category
    public function show($id)
    {
        $category = Category::findOrFail($id);
        return new CategoryResource($category); // Return a single CategoryResource
    }

    // Update the specified category in storage
    public function update(CategoryRequest $request, $id)
    {
        $category = Category::findOrFail($id);

        // Update category properties
        $category->update($request->only(['name', 'quantity', 'user_id']));

        // Handle updating the image if provided
        if ($request->hasFile('image')) {
            $originalName = $request->file('image')->getClientOriginalName();
            $path = $request->file('image')->storeAs('images/categories', $originalName, 'public');
            $category->image = $path;
            $category->save();
        }

        return new CategoryResource($category); // Return a single CategoryResource
    }

    // Remove the specified category from storage (soft delete)
    public function destroy($id)
    {
        try {
            $category = Category::findOrFail($id);
            $category->delete();

            return response()->json(['message' => 'Category item deleted successfully.']);
        } catch (ModelNotFoundException $e) {
            return response()->json(['message' => 'Category item not found.'], 404);
        }
    }
}
