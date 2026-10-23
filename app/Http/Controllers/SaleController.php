<?php

namespace App\Http\Controllers;

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
}