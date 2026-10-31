<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\SaleController;

Route::get('/', function () {
    return 'Computer Shop Management System';
});

Route::resource('products', ProductController::class)
    ->except(['show']);

Route::resource('customers', CustomerController::class)
    ->only(['index', 'create', 'store', 'edit', 'update', 'destroy']);

Route::resource('sales', SaleController::class)
    ->only(['index','create','store']);