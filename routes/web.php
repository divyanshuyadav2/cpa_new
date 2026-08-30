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
use App\Http\Controllers\Admin\ProductImportController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Pwa\PwaAuthController;
use App\Http\Controllers\Pwa\PwaRetailerController;
use App\Http\Controllers\Pwa\PwaSalesmanController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');
Route::post('/about', [HomeController::class, 'submitAbout'])->name('about.submit');
Route::get('/images/{path}', function($path) {
    $storageFile = storage_path('app/public/' . $path);
    if (file_exists($storageFile)) {
        return response()->file($storageFile);
    }
    $legacyFile = base_path('../cpa_uploads/' . $path);
    if (file_exists($legacyFile)) {
        return response()->file($legacyFile);
    }
    abort(404);
})->where('path', '.*')->name('images.serve');

Route::get('/storage/{path}', function($path) {
    $storageFile = storage_path('app/public/' . $path);
    if (file_exists($storageFile)) {
        return response()->file($storageFile);
    }
    $legacyFile = base_path('../cpa_uploads/' . $path);
    if (file_exists($legacyFile)) {
        return response()->file($legacyFile);
    }
    abort(404);
})->where('path', '.*')->name('storage.serve');
Route::get('/products', [ProductController::class, 'index'])->name('public.products.index');
Route::get('/products/{product}', [ProductController::class, 'show'])->name('public.products.show');

// Cart operations
Route::post('/cart/add', [CartController::class, 'add'])->name('cart.add');
Route::post('/cart/remove', [CartController::class, 'remove'])->name('cart.remove');
Route::post('/cart/update', [CartController::class, 'update'])->name('cart.update');
Route::get('/cart', [CartController::class, 'view'])->name('cart.view');
Route::post('/cart/whatsapp', [CartController::class, 'whatsapp'])->name('cart.whatsapp');
Route::get('/cart/whatsapp', [CartController::class, 'whatsapp']); // Fallback support

/*
|--------------------------------------------------------------------------
| PWA Routes (Retailer Counter & Salesman App)
|--------------------------------------------------------------------------
*/
Route::prefix('pwa')->group(function () {
    Route::get('/login', [PwaAuthController::class, 'showLoginForm'])->name('pwa.login');
    Route::post('/login', [PwaAuthController::class, 'login'])->name('pwa.login.post');
    Route::get('/register', [PwaAuthController::class, 'showRegisterForm'])->name('pwa.register');
    Route::post('/register', [PwaAuthController::class, 'register'])->name('pwa.register.post');
    Route::post('/logout', [PwaAuthController::class, 'logout'])->name('pwa.logout');

    // Protected PWA Routes
    Route::middleware('auth')->group(function () {
        // Retailer Catalog & Ordering (No stock restrictions)
        Route::get('/catalog', [PwaRetailerController::class, 'catalog'])->name('pwa.retailer.catalog');
        Route::post('/checkout', [PwaRetailerController::class, 'checkout'])->name('pwa.retailer.checkout');
        Route::get('/orders', [PwaRetailerController::class, 'orders'])->name('pwa.retailer.orders');

        // Salesman Dashboard & Delivery Status Update
        Route::get('/salesman', [PwaSalesmanController::class, 'dashboard'])->name('pwa.salesman.dashboard');
        Route::match(['post', 'patch'], '/salesman/orders/{order}/status', [PwaSalesmanController::class, 'updateStatus'])->name('pwa.salesman.order.status');
    });
});

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
    Route::get('products/import', [ProductImportController::class, 'index'])->name('products.import.index');
    Route::get('products/import/sample', [ProductImportController::class, 'sampleCsv'])->name('products.import.sample');
    Route::post('products/import/upload', [ProductImportController::class, 'upload'])->name('products.import.upload');
    Route::post('products/import/process', [ProductImportController::class, 'process'])->name('products.import.process');
    Route::get('products/export', [AdminProductController::class, 'export'])->name('products.export');
    Route::resource('products', AdminProductController::class);
    
    // Orders resource with status updates & WhatsApp confirmation
    Route::get('orders/{order}/confirm', [OrderController::class, 'sendConfirmation'])->name('orders.confirm');
    Route::patch('orders/{order}/status', [OrderController::class, 'updateStatus'])->name('orders.update-status');
    Route::resource('orders', OrderController::class)->only(['index', 'show']);

    // Stockist Applications
    Route::patch('applications/{application}/status', [ApplicationController::class, 'updateStatus'])->name('applications.update-status');
    Route::resource('applications', ApplicationController::class)->only(['index', 'show', 'destroy']);

    // Users & Counters Management
    Route::patch('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('admin.users.toggle-status');
    Route::resource('users', UserController::class)->names('admin.users');

    // General Settings
    Route::get('/settings', [SettingController::class, 'index'])->name('admin.settings');
    Route::post('/settings', [SettingController::class, 'update'])->name('admin.settings.update');
});
