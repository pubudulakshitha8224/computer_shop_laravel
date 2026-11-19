<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    // Admin - View Products
    public function index()
    {
        $products = Product::latest()->get();

        return view('products.index', compact('products'));
    }

    // Customer - View Products with Search
    public function customerProducts(Request $request)
    {
        $search = $request->input('search');

        $products = Product::query()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                      ->orWhere('brand', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->get();

        return view('customer.products', compact('products', 'search'));
    }

    // Admin - Create Product
    public function create()
    {
        return view('products.create');
    }

    // Admin - Store Product
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

    // Admin - Edit Product
    public function edit(Product $product)
    {
        return view('products.edit', compact('product'));
    }

    // Admin - Update Product
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'product_name' => 'required|string|max:255',
            'brand' => 'required|string|max:255',
            'price' => 'required|numeric|min:0|max:99999999.99',
            'quantity' => 'required|integer|min:0|max:2147483647',
            'description' => 'nullable|string',
        ]);

        $product->update($data);

        return redirect()->route('products.index')
            ->with('success', 'Product updated successfully.');
    }

    // Admin - Delete Product
    public function destroy(Product $product)
    {
        $product->delete();

        return redirect()->route('products.index')
            ->with('success', 'Product deleted successfully.');
    }
}
