<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    // Customer Checkout Page
    public function checkout()
    {
        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        return view('customer.checkout', compact('cart'));
    }

    // Place Customer Order
    public function placeOrder(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'address' => 'required|string|max:1000',
        ]);

        $cart = session()->get('cart', []);

        if (empty($cart)) {
            return redirect()->route('cart.index')
                ->with('error', 'Your cart is empty.');
        }

        try {
            $order = DB::transaction(function () use ($request, $cart) {

                $totalAmount = 0;

                foreach ($cart as $item) {
                    $totalAmount += $item['price'] * $item['quantity'];
                }

                $order = Order::create([
                    'customer_name' => $request->customer_name,
                    'phone' => $request->phone,
                    'address' => $request->address,
                    'total_amount' => $totalAmount,
                    'status' => 'Pending',
                    'stock_deducted' => false,
                ]);

                foreach ($cart as $productId => $item) {

                    $product = Product::where('id', $productId)
                        ->lockForUpdate()
                        ->first();

                    if (!$product) {
                        throw new \Exception('A product in your cart no longer exists.');
                    }

                    if ($product->quantity < $item['quantity']) {
                        throw new \Exception(
                            'Insufficient stock for ' . $product->product_name
                        );
                    }

                    $order->items()->create([
                        'product_id' => $product->id,
                        'product_name' => $product->product_name,
                        'brand' => $product->brand,
                        'quantity' => $item['quantity'],
                        'price' => $item['price'],
                        'subtotal' => $item['price'] * $item['quantity'],
                    ]);
                }

                return $order;
            });

            session()->forget('cart');

            return redirect()->route('shop.home')
                ->with('success', 'Your order was placed successfully! Order ID: #' . $order->id);

        } catch (\Exception $e) {

            return redirect()->route('cart.index')
                ->with('error', $e->getMessage());
        }
    }

    // Admin / Staff - View All Orders with Search and Filter
    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');

        $query = Order::query();

        if (!empty($search)) {

            // Remove # symbol before searching Order ID
            $cleanSearch = ltrim(trim($search), '#');

            $query->where(function ($q) use ($search, $cleanSearch) {

                $q->where('id', 'like', '%' . $cleanSearch . '%')
                    ->orWhere('customer_name', 'like', '%' . $search . '%')
                    ->orWhere('phone', 'like', '%' . $search . '%');

            });
        }

        // Filter Orders by Status
        if (in_array($status, ['Pending', 'Confirmed', 'Completed', 'Cancelled'])) {
            $query->where('status', $status);
        } else {
            $status = '';
        }

        $orders = $query->latest()->get();

        return view('orders.index', compact('orders', 'search', 'status'));
    }

    // Admin / Staff - View Order Details
    public function show($id)
    {
        $order = Order::with('items')->findOrFail($id);

        return view('orders.show', compact('order'));
    }

    // Admin / Staff - Update Order Status
    public function updateStatus(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:Pending,Confirmed,Completed,Cancelled',
        ]);

        try {

            DB::transaction(function () use ($request, $id) {

                $order = Order::where('id', $id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $oldStatus = $order->status;
                $newStatus = $request->status;

                if ($oldStatus === $newStatus) {
                    return;
                }

                // Completed and Cancelled orders are final
                if (in_array($oldStatus, ['Completed', 'Cancelled'])) {
                    throw new \Exception(
                        'Completed or Cancelled orders cannot be changed.'
                    );
                }

                // Completed orders must first be Confirmed
                if ($newStatus === 'Completed' && $oldStatus !== 'Confirmed') {
                    throw new \Exception(
                        'Please confirm the order before completing it.'
                    );
                }

                // Deduct product stock when order is Confirmed
                if ($newStatus === 'Confirmed' && !$order->stock_deducted) {

                    $items = $order->items;

                    foreach ($items as $item) {

                        if (!$item->product_id) {
                            throw new \Exception(
                                'A product in this order is no longer available.'
                            );
                        }

                        $product = Product::where('id', $item->product_id)
                            ->lockForUpdate()
                            ->first();

                        if (!$product) {
                            throw new \Exception(
                                'A product in this order could not be found.'
                            );
                        }

                        if ($product->quantity < $item->quantity) {
                            throw new \Exception(
                                'Not enough stock for ' . $product->product_name
                            );
                        }
                    }

                    foreach ($items as $item) {

                        $product = Product::where('id', $item->product_id)
                            ->lockForUpdate()
                            ->firstOrFail();

                        $product->quantity -= $item->quantity;
                        $product->save();
                    }

                    $order->stock_deducted = true;
                }

                // Restore stock when a confirmed order is Cancelled
                if ($newStatus === 'Cancelled' && $order->stock_deducted) {

                    foreach ($order->items as $item) {

                        if ($item->product_id) {

                            $product = Product::where('id', $item->product_id)
                                ->lockForUpdate()
                                ->first();

                            if ($product) {
                                $product->quantity += $item->quantity;
                                $product->save();
                            }
                        }
                    }

                    $order->stock_deducted = false;
                }

                $order->status = $newStatus;
                $order->save();
            });

            return redirect()->route('orders.index')
                ->with('success', 'Order status updated successfully.');

        } catch (\Exception $e) {

            return redirect()->back()
                ->with('error', $e->getMessage());
        }
    }
}
