<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class CartController extends Controller
{
    // View Cart
    public function index()
    {
        $cart = session()->get('cart', []);

        return view('customer.cart', compact('cart'));
    }

    // Add Product to Cart
    public function add(Request $request, Product $product)
    {
        if ($product->quantity < 1) {
            return redirect()->back()
                ->with('error', 'This product is out of stock.');
        }

        $cart = session()->get('cart', []);

        $currentQuantity = $cart[$product->id]['quantity'] ?? 0;

        if ($currentQuantity >= $product->quantity) {
            return redirect()->back()
                ->with('error', 'Available stock limit reached.');
        }

        if (isset($cart[$product->id])) {
            $cart[$product->id]['quantity']++;
        } else {
            $cart[$product->id] = [
                'product_id' => $product->id,
                'product_name' => $product->product_name,
                'brand' => $product->brand,
                'price' => $product->price,
                'quantity' => 1,
            ];
        }

        session()->put('cart', $cart);

        return redirect()->back()
            ->with('success', 'Product added to cart successfully.');
    }

    // Update Cart Quantity
    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        $cart = session()->get('cart', []);

        if (!isset($cart[$id])) {
            return redirect()->route('cart.index');
        }

        $product = Product::find($id);

        if (!$product || $request->quantity > $product->quantity) {
            return redirect()->back()
                ->with('error', 'Requested quantity is not available.');
        }

        $cart[$id]['quantity'] = $request->quantity;

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Cart updated successfully.');
    }

    // Remove Product from Cart
    public function remove($id)
    {
        $cart = session()->get('cart', []);

        unset($cart[$id]);

        session()->put('cart', $cart);

        return redirect()->route('cart.index')
            ->with('success', 'Product removed from cart.');
    }
}
