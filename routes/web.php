
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;

// Public Customer Routes

Route::get('/shop', function () {
    return view('customer.home');
})->name('shop.home');

Route::get('/shop/products', [ProductController::class, 'customerProducts'])
    ->name('customer.products');

// Cart Routes (No Login Required)

Route::get('/shop/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/shop/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/shop/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/shop/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');


// Home
Route::get('/', function () {
    return redirect('/dashboard');
});

// Guest Routes
Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

});

// Protected Routes
Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');

    // Products - Admin and Staff can view
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');

    // Customers - Admin and Staff can view
    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');

    // Sales - Admin and Staff can view and add
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');

    // Admin Only Routes
    Route::middleware('role:admin')->group(function () {

        // Product Management
        Route::resource('products', ProductController::class)
            ->except(['index', 'show']);

        // Customer Management
        Route::resource('customers', CustomerController::class)
            ->except(['index', 'show']);

        // Sales Management
        Route::resource('sales', SaleController::class)
            ->except(['index', 'create', 'store', 'show']);

    });

});
