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
    public function index(Request $request)
    {
        $search = $request->search;
        $saleDate = $request->sale_date;

        $sales = Sale::with('customer')
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('product_name', 'like', "%{$search}%")
                        ->orWhereHas('customer', function ($customerQuery) use ($search) {
                            $customerQuery->where(
                                'customer_name',
                                'like',
                                "%{$search}%"
                            );
                        });
                });
            })
            ->when($saleDate, function ($query, $saleDate) {
                $query->whereDate('sale_date', $saleDate);
            })
            ->orderBy('id', 'desc')
           ->get();

$totalSalesCount = $sales->count();
$totalQuantity = $sales->sum('quantity');
$totalSalesAmount = $sales->sum('total_price');

return view('sales.index', compact(
    'sales',
    'search',
    'saleDate',
    'totalSalesCount',
    'totalQuantity',
    'totalSalesAmount'
));
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

            $totalPrice = $this->calculateTotal(
                $product->price,
                $quantity
            );

            Sale::create([
                'customer_id' => $validated['customer_id'],
                'product_id' => $product->id,
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

    public function edit(Sale $sale)
    {
        if (!$sale->product_id) {
            return redirect()
                ->route('sales.index')
                ->with('error', 'This old sale cannot be edited because its product is not linked.');
        }

        $customers = Customer::orderBy('customer_name')->get();
        $products = Product::orderBy('product_name')->get();

        return view('sales.edit', compact('sale', 'customers', 'products'));
    }

    public function update(Request $request, Sale $sale)
    {
        $validated = $request->validate([
            'customer_id' => ['required', 'exists:customers,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1'],
            'sale_date' => ['required', 'date'],
        ]);

        if (!$sale->product_id) {
            return redirect()
                ->route('sales.index')
                ->with('error', 'This old sale cannot be updated because its product is not linked.');
        }

        DB::transaction(function () use ($validated, $sale) {
            $sale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            $oldProductId = $sale->product_id;
            $newProductId = (int) $validated['product_id'];

            $productIds = array_unique([
                (int) $oldProductId,
                $newProductId,
            ]);

            $products = Product::whereIn('id', $productIds)
                ->orderBy('id')
                ->lockForUpdate()
                ->get()
                ->keyBy('id');

            $oldProduct = $products->get($oldProductId);
            $newProduct = $products->get($newProductId);

            if (!$oldProduct || !$newProduct) {
                throw ValidationException::withMessages([
                    'product_id' => 'The selected product is no longer available.',
                ]);
            }

            $quantity = (int) $validated['quantity'];

            $availableStock = $newProduct->quantity;

            if ($oldProductId == $newProductId) {
                $availableStock += $sale->quantity;
            }

            if ($quantity > $availableStock) {
                throw ValidationException::withMessages([
                    'quantity' => 'Not enough stock. Available quantity: '
                        . $availableStock,
                ]);
            }

            $totalPrice = $this->calculateTotal(
                $newProduct->price,
                $quantity
            );

            if ($oldProductId == $newProductId) {
                $newProduct->quantity = $availableStock - $quantity;
                $newProduct->save();
            } else {
                $oldProduct->increment('quantity', $sale->quantity);
                $newProduct->decrement('quantity', $quantity);
            }

            $sale->update([
                'customer_id' => $validated['customer_id'],
                'product_id' => $newProduct->id,
                'product_name' => $newProduct->product_name,
                'quantity' => $quantity,
                'total_price' => $totalPrice,
                'sale_date' => $validated['sale_date'],
            ]);
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale updated successfully. Stock updated.');
    }

    public function destroy(Sale $sale)
    {
        if (!$sale->product_id) {
            return redirect()
                ->route('sales.index')
                ->with('error', 'This old sale cannot be deleted because its product is not linked.');
        }

        DB::transaction(function () use ($sale) {
            $sale = Sale::whereKey($sale->id)
                ->lockForUpdate()
                ->firstOrFail();

            $product = Product::whereKey($sale->product_id)
                ->lockForUpdate()
                ->first();

            if (!$product) {
                throw ValidationException::withMessages([
                    'product_id' => 'The related product could not be found.',
                ]);
            }

            $product->increment('quantity', $sale->quantity);

            $sale->delete();
        });

        return redirect()
            ->route('sales.index')
            ->with('success', 'Sale deleted successfully. Stock restored.');
    }

    private function calculateTotal($price, int $quantity): string
    {
        $priceParts = explode('.', (string) $price);

        $priceCents = ((int) $priceParts[0] * 100)
            + (int) str_pad($priceParts[1] ?? '', 2, '0');

        $totalCents = $priceCents * $quantity;

        if ($totalCents > 9999999999) {
            throw ValidationException::withMessages([
                'quantity' => 'The sale total is too large.',
            ]);
        }

        return intdiv($totalCents, 100) . '.'
            . str_pad(
                (string) ($totalCents % 100),
                2,
                '0',
                STR_PAD_LEFT
            );
    }
}
