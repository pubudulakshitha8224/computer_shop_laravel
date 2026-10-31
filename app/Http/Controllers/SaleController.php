<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Sale;
use Illuminate\Http\Request;

class SaleController extends Controller
{
    public function index()
    {
        $sales = Sale::with('customer')
            ->orderBy('id', 'desc')
            ->get();

        return view('sales.index', compact('sales'));
    }

    public function create()
    {
        $customers = Customer::orderBy('customer_name')->get();

        return view('sales.create', compact('customers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_name' => ['required', 'string', 'max:255'],
            'quantity' => ['required', 'integer', 'min:1'],
            'total_price' => ['required', 'numeric', 'min:0'],
            'sale_date' => ['required', 'date'],
        ]);

        Sale::create($validated);

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale added successfully.');
    }
}