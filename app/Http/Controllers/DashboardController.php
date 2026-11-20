<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;
use App\Models\Order;

class DashboardController extends Controller
{
    public function index()
    {
        // Product Summary
        $totalProducts = Product::count();

        // Customer Summary
        $totalCustomers = Customer::count();

        // Sales Summary
        $totalSales = Sale::count();

        $totalIncome = Sale::sum('total_price');

        // Order Summary
        $totalOrders = Order::count();

        $pendingOrders = Order::where('status', 'Pending')->count();

        $confirmedOrders = Order::where('status', 'Confirmed')->count();

        $completedOrders = Order::where('status', 'Completed')->count();

        $cancelledOrders = Order::where('status', 'Cancelled')->count();

        // Recent Sales
        $recentSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        // Low Stock Products
        $lowStockProducts = Product::where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalSales',
            'totalIncome',
            'totalOrders',
            'pendingOrders',
            'confirmedOrders',
            'completedOrders',
            'cancelledOrders',
            'recentSales',
            'lowStockProducts'
        ));
    }
}
