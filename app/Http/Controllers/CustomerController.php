<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;

class CustomerController extends Controller
{
    public function index()
    {
        $customers = Customer::orderBy('id', 'desc')->get();

        return view('customers.index', compact('customers'));
    }

    public function create()
    {
        return view('customers.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'customer_name' => 'required|string|max:255',
            'phone' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'address' => 'nullable|string',
        ]);

        $customer = new Customer();
        $customer->customer_name = $validated['customer_name'];
        $customer->phone = $validated['phone'];
        $customer->email = $validated['email'] ?? null;
        $customer->address = $validated['address'] ?? null;
        $customer->save();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer added successfully.');
    }
    public function edit(Customer $customer)
{
    return view('customers.edit', compact('customer'));
}

public function update(Request $request, Customer $customer)
{
    $validated = $request->validate([
        'customer_name' => 'required|string|max:255',
        'phone' => 'required|string|max:20',
        'email' => 'nullable|email|max:255',
        'address' => 'nullable|string',
    ]);

    $customer->customer_name = $validated['customer_name'];
    $customer->phone = $validated['phone'];
    $customer->email = $validated['email'] ?? null;
    $customer->address = $validated['address'] ?? null;
    $customer->save();

    return redirect()
        ->route('customers.index')
        ->with('success', 'Customer updated successfully.');
}
    public function destroy(Customer $customer)
    {
        $customer->delete();

        return redirect()
            ->route('customers.index')
            ->with('success', 'Customer deleted successfully.');
    }
}