<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
</head>
<body>
    <h1>Add Sale</h1>

    <a href="{{ route('sales.index') }}">Back to Sales</a>

    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <p>
            <label for="customer_id">Customer</label><br>
            <select id="customer_id" name="customer_id" required>
                <option value="">Select Customer</option>
                @foreach ($customers as $customer)
                    <option
                        value="{{ $customer->id }}"
                        @selected(old('customer_id') == $customer->id)
                    >
                        {{ $customer->customer_name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="product_name">Product Name</label><br>
            <input type="text" id="product_name" name="product_name"
                   value="{{ old('product_name') }}"
                   maxlength="255" required>
        </p>

        <p>
            <label for="quantity">Quantity</label><br>
            <input type="number" id="quantity" name="quantity"
                   value="{{ old('quantity', 1) }}" min="1" required>
        </p>

        <p>
            <label for="total_price">Total Price (LKR)</label><br>
            <input type="number" id="total_price" name="total_price"
                   value="{{ old('total_price') }}"
                   min="0" step="0.01" required>
        </p>

        <p>
            <label for="sale_date">Sale Date</label><br>
            <input type="date" id="sale_date" name="sale_date"
                   value="{{ old('sale_date', date('Y-m-d')) }}" required>
        </p>

        <button type="submit">Save Sale</button>
    </form>
</body>
</html>