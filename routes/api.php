<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CatalogController;
use App\Http\Controllers\Api\OrderController;
use App\Http\Controllers\Api\SalesmanController;

// Authentication
Route::post('/login', [AuthController::class, 'login']);

// Protected Routes
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', [AuthController::class, 'user']);

    // Catalog APIs
    Route::get('/companies', [CatalogController::class, 'companies']);
    Route::get('/products', [CatalogController::class, 'products']);
    Route::get('/products/{id}', [CatalogController::class, 'product']);

    // Retailer Order APIs
    Route::get('/orders', [OrderController::class, 'index']);
    Route::post('/orders/checkout', [OrderController::class, 'store']);
    Route::get('/orders/{id}', [OrderController::class, 'show']);

    // Salesman APIs
    Route::get('/salesman/retailers', [SalesmanController::class, 'retailers']);
    Route::get('/salesman/orders', [SalesmanController::class, 'orders']);
});
