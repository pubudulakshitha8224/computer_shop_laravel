<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController;

Route::get('/', function () {
    return 'Computer Shop Management System';
});

Route::get('/products', [ProductController::class, 'index']);

Route::get('/customers', function () {
    return 'Customers Page';
});

Route::get('/sales', function () {
    return 'Sales Page';
});