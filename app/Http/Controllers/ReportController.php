<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    // Daily Sales Report
    public function dailySales(Request $request)
    {
        $date = $request->input('date', now()->toDateString());

        $sales = Sale::with('customer')
            ->whereDate('sale_date', $date)
            ->latest()
            ->get();

        $totalSales = $sales->count();
        $totalQuantity = $sales->sum('quantity');
        $totalIncome = $sales->sum('total_price');

        return view('reports.daily-sales', compact(
            'sales',
            'date',
            'totalSales',
            'totalQuantity',
            'totalIncome'
        ));
    }

    // Monthly Sales Report
    public function monthlySales(Request $request)
    {
        $month = $request->input('month', now()->format('Y-m'));

        $sales = Sale::with('customer')
            ->whereYear('sale_date', substr($month, 0, 4))
            ->whereMonth('sale_date', substr($month, 5, 2))
            ->latest()
            ->get();

        $totalSales = $sales->count();
        $totalQuantity = $sales->sum('quantity');
        $totalIncome = $sales->sum('total_price');

        return view('reports.monthly-sales', compact(
            'sales',
            'month',
            'totalSales',
            'totalQuantity',
            'totalIncome'
        ));
    }

    // Total Income Report
    public function totalIncome()
    {
        $sales = Sale::with('customer')
            ->orderBy('sale_date', 'desc')
            ->get();

        $totalSales = $sales->count();
        $totalQuantity = $sales->sum('quantity');
        $totalIncome = $sales->sum('total_price');

        return view('reports.total-income', compact(
            'sales',
            'totalSales',
            'totalQuantity',
            'totalIncome'
        ));
    }
}
