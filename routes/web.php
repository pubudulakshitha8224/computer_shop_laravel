
<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ReportController;


// ========================================
// PUBLIC CUSTOMER ROUTES
// ========================================

Route::get('/shop', function () {
    return view('customer.home');
})->name('shop.home');

Route::get('/shop/products', [ProductController::class, 'customerProducts'])
    ->name('customer.products');


// ========================================
// CART ROUTES
// ========================================

Route::get('/shop/cart', [CartController::class, 'index'])
    ->name('cart.index');

Route::post('/shop/cart/add/{product}', [CartController::class, 'add'])
    ->name('cart.add');

Route::post('/shop/cart/update/{id}', [CartController::class, 'update'])
    ->name('cart.update');

Route::post('/shop/cart/remove/{id}', [CartController::class, 'remove'])
    ->name('cart.remove');


// ========================================
// CUSTOMER ORDER / CHECKOUT ROUTES
// ========================================

Route::get('/shop/checkout', [OrderController::class, 'checkout'])
    ->name('order.checkout');

Route::post('/shop/order/place', [OrderController::class, 'placeOrder'])
    ->name('order.place');


// ========================================
// HOME
// ========================================

Route::get('/', function () {
    return redirect('/dashboard');
});


// ========================================
// GUEST ROUTES
// ========================================

Route::middleware('guest')->group(function () {

    Route::get('/login', [AuthController::class, 'showLogin'])
        ->name('login');

    Route::post('/login', [AuthController::class, 'login']);

});


// ========================================
// PROTECTED ROUTES
// ========================================

Route::middleware('auth')->group(function () {

    // Logout
    Route::post('/logout', [AuthController::class, 'logout'])
        ->name('logout');


    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])
        ->name('dashboard');


    // PRODUCTS
    Route::get('/products', [ProductController::class, 'index'])
        ->name('products.index');


    // CUSTOMERS
    Route::get('/customers', [CustomerController::class, 'index'])
        ->name('customers.index');


    // SALES
    Route::get('/sales', [SaleController::class, 'index'])
        ->name('sales.index');

    Route::get('/sales/create', [SaleController::class, 'create'])
        ->name('sales.create');

    Route::post('/sales', [SaleController::class, 'store'])
        ->name('sales.store');


    // ORDER MANAGEMENT
    Route::get('/orders', [OrderController::class, 'index'])
        ->name('orders.index');

    Route::get('/orders/{id}', [OrderController::class, 'show'])
        ->name('orders.show');

    Route::put('/orders/{id}/status', [OrderController::class, 'updateStatus'])
        ->name('orders.updateStatus');


    // ====================================
    // REPORTS
    // ====================================

    // Daily Sales Report
    Route::get('/reports/daily-sales', [ReportController::class, 'dailySales'])
        ->name('reports.dailySales');

    // Monthly Sales Report
    Route::get('/reports/monthly-sales', [ReportController::class, 'monthlySales'])
        ->name('reports.monthlySales');

    // Total Income Report
    Route::get('/reports/total-income', [ReportController::class, 'totalIncome'])
        ->name('reports.totalIncome');


    // ====================================
    // ADMIN ONLY ROUTES
    // ====================================

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
