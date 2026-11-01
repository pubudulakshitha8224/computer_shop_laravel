<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use App\Models\Product;
use App\Models\Sale;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

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
        $products = Product::orderBy('product_name')->get();

        return view('sales.create', compact('customers', 'products'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'sale_date' => ['required', 'date'],
        ]);

        DB::transaction(function () use ($validated) {
            $product = Product::whereKey($validated['product_id'])
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'This product is no longer available.',
                ]);
            }

            $quantity = (int) $validated['quantity'];

            if ($quantity > $product->quantity) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough stock. Available quantity: '
                        . $product->quantity,
                ]);
            }

            // Calculate the total using whole cents.
            $priceParts = explode('.', (string) $product->price);
            $priceCents = ((int) $priceParts[0] * 100)
                + (int) str_pad($priceParts[1] ?? '', 2, '0');

            $totalCents = $priceCents * $quantity;

            if ($totalCents > 9999999999) {
                throw ValidationException::withMessages([
                    'quantity' => 'The sale total is too large.',
                ]);
            }

            $totalPrice = intdiv($totalCents, 100) . '.'
                . str_pad((string) ($totalCents % 100), 2, '0', STR_PAD_LEFT);

            Sale::create([
                'customer_id' => $validated['customer_id'],
                'product_name' => $product->product_name,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'sale_date' => $validated['sale_date'],
            ]);

            $product->decrement('quantity', $quantity);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale added successfully. Stock updated.');
    }
}