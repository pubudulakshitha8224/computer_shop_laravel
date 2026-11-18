<?php
namespace App\Http\Controllers;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Sale;

class DashboardController extends Controller
{
    public function index()
    {
        $totalProducts = Product::count();

        $totalCustomers = Customer::count();

        $totalSales = Sale::count();

        $totalIncome = Sale::sum('total_price');

        $recentSales = Sale::with('customer')
            ->latest()
            ->take(5)
            ->get();

        $lowStockProducts = Product::where('quantity', '<=', 5)
            ->orderBy('quantity')
            ->get();

        return view('dashboard', compact(
            'totalProducts',
            'totalCustomers',
            'totalSales',
            'totalIncome',
            'recentSales',
            'lowStockProducts'
        ));
    }
}
