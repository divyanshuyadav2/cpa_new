<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\Admin\LoginController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\CompanyController;
use App\Http\Controllers\Admin\DivisionController;
use App\Http\Controllers\Admin\SaltController;
use App\Http\Controllers\Admin\ProductController as AdminProductController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\ApplicationController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::post('/about', [HomeController::class, 'submitAbout'])->name('about.submit');
Route::get('/products', [ProductController::class, 'index'])->name('products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');

// Cart operations
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/whatsapp', [CartController::class, 'whatsapp'])->name('cart.whatsapp');
Route::get('/cart/whatsapp', [CartController::class, 'whatsapp']); // Fallback support

/*
|--------------------------------------------------------------------------
| Admin Auth Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin/login', [LoginController::class, 'showLoginForm'])->name('admin.login');
Route::post('/admin/login', [LoginController::class, 'login']);
Route::post('/admin/logout', [LoginController::class, 'logout'])->name('admin.logout');

/*
|--------------------------------------------------------------------------
| Admin Panel Protected Routes (Auth + Admin Middleware)
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->group(function () {
    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
    
    // Company Divisions AJAX route (used in product create/edit forms)
    Route::get('/divisions/by-company', [DivisionController::class, 'byCompany'])->name('divisions.by-company');

    // Resources
    Route::resource('companies', CompanyController::class);
    Route::resource('divisions', DivisionController::class);
    Route::resource('salts', SaltController::class);
    
    // Products resource with bulk import
    Route::post('products/import', [AdminProductController::class, 'import'])->name('products.import');
    Route::resource('products', AdminProductController::class);
    
    // Orders resource with status updates & WhatsApp confirmation
    Route::get('orders/{order}/confirm', [OrderController::class, 'sendConfirmation'])->name('orders.confirm');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('orders', OrderController::class)->only(['index', 'show']);

    // Stockist Applications
    Route::patch('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    Route::resource('applications', ApplicationController::class)->only(['index', 'show', 'destroy']);

    // General Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
