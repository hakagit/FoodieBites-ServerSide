<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\Auth\RegisterController as AuthRegisterController;
use App\Http\Controllerspjp\RegisterController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\DishController;
use App\Http\Controllers\DriverController;
use App\Http\Controllers\InventoryController;
use App\Http\Controllers\InventorySupplierController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\OrderItemController;
use App\Http\Controllers\PaymentController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserController;
use App\Models\Inventory;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/


Route::prefix('user')->middleware('auth:sanctum')->group(function () {
    // return $request->user();
});
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/user', [AuthController::class, 'showUser']);
Route::post('/logout', [AuthController::class, 'logout']);

Route::middleware('auth:sanctum')->group(function () {
    Route::prefix('user')->group(function () {
        Route::get('/get', [UserController::class, 'index']);
        Route::post('/store', [UserController::class, 'store']);
        Route::get('/show/{id}', [UserController::class, 'show']);
        Route::Put('/update/{id}', [UserController::class, 'update']);
        Route::delete('/destroy/{id}', [UserController::class, 'destroy']);
    });

    Route::prefix('category')->group(function () {
        Route::get('/get', [CategoryController::class, 'index']);
        Route::post('/store', [CategoryController::class, 'store']);
        Route::get('show/{id}', [CategoryController::class, 'show']);
        Route::post('/update/{id}', [CategoryController::class, 'update']);
        Route::delete('/destroy/{id}', [CategoryController::class, 'destroy']);
    });
});

Route::prefix('inventory')->middleware('auth:sanctum', 'admin')->group(function () {
    Route::get('/get', [InventoryController::class, 'index']);
    Route::post('/store', [InventoryController::class, 'store']);
    Route::get('show/{id}', [InventoryController::class, 'show']);
    Route::post('/update/{id}', [InventoryController::class, 'update']);
    Route::delete('/destroy/{id}', [InventoryController::class, 'destroy']);
});
Route::get('category/{categoryId}/dish', [DishController::class, 'dishesById']);

Route::prefix('dish')->middleware('auth:sanctum', 'admin')->group(function () {
    Route::get('/get', [DishController::class, 'index']);
    Route::post('/store', [DishController::class, 'store']);
    Route::get('show/{id}', [DishController::class, 'show']);
    Route::post('/update/{id}', [DishController::class, 'update']);
    Route::delete('/destroy/{id}', [DishController::class, 'destroy']);
});

Route::prefix('supplier')->middleware('auth:sanctum', 'admin')->group(function () {
    Route::get('/get', [SupplierController::class, 'index']);
    Route::post('/store', [SupplierController::class, 'store']);
    Route::get('show/{id}', [SupplierController::class, 'show']);
    Route::post('/update/{id}', [SupplierController::class, 'update']);
    Route::delete('/destroy/{id}', [SupplierController::class, 'destroy']);
});

Route::prefix('inventory_supplier')->middleware('auth:sanctum', 'admin')->group(function () {
    Route::post('inventories/{inventoryId}/suppliers', [InventorySupplierController::class, 'attachSuppliers']);
    Route::delete('inventories/{inventoryId}/suppliers', [InventorySupplierController::class, 'detachSuppliers']);
    Route::get('inventories/{inventoryId}/suppliers', [InventorySupplierController::class, 'showSuppliers']);
    Route::get('suppliers/{supplierId}/inventories', [InventorySupplierController::class, 'showInventories']);
});

Route::prefix('address')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [AddressController::class, 'index']);
    Route::post('/store', [AddressController::class, 'store']);
    Route::get('show/{id}', [AddressController::class, 'show']);
    Route::post('/update/{id}', [AddressController::class, 'update']);
    Route::delete('/destroy/{id}', [AddressController::class, 'destroy']);
});

Route::prefix('order')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [OrderController::class, 'index']);
    Route::post('/store', [OrderController::class, 'store']);
    Route::get('/show/{id}', [OrderController::class, 'show']);
    Route::post('/update/{id}', [OrderController::class, 'update']);
    Route::delete('/destroy/{id}', [OrderController::class, 'destroy']);
    Route::post('/orders', [OrderController::class, 'customerOrder']);
});

Route::prefix('driver')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [DriverController::class, 'index']);
    Route::post('/store', [DriverController::class, 'store']);
    Route::get('show/{id}', [DriverController::class, 'show']);
    Route::post('/update/{id}', [DriverController::class, 'update']);
    Route::delete('/destroy/{id}', [DriverController::class, 'destroy']);
});

Route::prefix('order_item')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [OrderItemController::class, 'index']);
    Route::post('/store', [OrderItemController::class, 'store']);
    Route::get('/show/{id}', [OrderItemController::class, 'show']);
    Route::post('/update/{id}', [OrderItemController::class, 'update']);
    Route::delete('/destroy/{id}', [OrderItemController::class, 'destroy']);
});

Route::prefix('payment')->middleware('auth:sanctum')->group(function () {
    Route::get('/get', [PaymentController::class, 'index']);
    Route::post('/store', [PaymentController::class, 'store']);
    Route::get('show/{id}', [PaymentController::class, 'show']);
    Route::post('/update/{id}', [PaymentController::class, 'update']);
    Route::delete('/destroy/{id}', [PaymentController::class, 'destroy']);
});
