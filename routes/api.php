<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalesmanController;
use App\Http\Controllers\Api\AdminOrderController;
use App\Http\Controllers\Api\BillerController;

// Authentication
Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Catalog APIs
    Route::get('/companies', [CatalogController::class, 'companies']);
    Route::get('/products/frequent', [CatalogController::class, 'frequentProducts']);
    Route::get('/products', [CatalogController::class, 'products']);
    Route::get('/products/{id}', [CatalogController::class, 'product']);

    // Retailer Order APIs
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders/checkout', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // Salesman APIs
    Route::get('/salesman/retailers', [SalesmanController::class, 'retailers']);
    Route::get('/salesman/orders', [SalesmanController::class, 'orders']);
    Route::patch('/salesman/orders/{id}/status', [SalesmanController::class, 'updateStatus']);

    // Admin Order & Assignment APIs
    Route::get('/admin/orders', [AdminOrderController::class, 'orders']);
    Route::patch('/admin/orders/{id}/assign', [AdminOrderController::class, 'assignBiller']);
    Route::patch('/admin/orders/{id}/status', [AdminOrderController::class, 'updateStatus']);
    Route::get('/admin/billers', [AdminOrderController::class, 'billers']);
    Route::post('/admin/billers', [AdminOrderController::class, 'createBiller']);

    // Biller APIs
    Route::get('/biller/orders', [BillerController::class, 'orders']);
    Route::patch('/biller/orders/{id}/status', [BillerController::class, 'updateBilling']);
});
