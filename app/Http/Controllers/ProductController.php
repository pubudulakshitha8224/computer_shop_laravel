<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    public function create()
    {
        return view('products.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'quantity' => 'required|integer|min:0|max:2147483647',
            'description' => 'nullable|string',
        ]);

        Product::create($data);

        return redirect()->route('products.index')
            ->with('success', 'Product added successfully.');
    }
}