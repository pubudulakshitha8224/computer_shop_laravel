
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Sale - Computer Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 30px;
        }

        .container {
            max-width: 600px;
            margin: 30px auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        input, select {
            width: 100%;
            padding: 11px;
            margin-bottom: 18px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 15px;
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: -12px;
            margin-bottom: 15px;
        }

        button, .back {
            display: inline-block;
            padding: 11px 20px;
            border: none;
            border-radius: 5px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 15px;
        }

        button {
            background: #007bff;
        }

        .back {
            background: #6c757d;
            margin-left: 8px;
        }
    </style>
</head>
<body>

<div class="container">

    <h2>Edit Sale</h2>

    <form action="{{ route('sales.update', $sale->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label>Customer</label>
        <select name="customer_id" required>
            @foreach($customers as $customer)
                <option value="{{ $customer->id }}"
                    {{ old('customer_id', $sale->customer_id) == $customer->id ? 'selected' : '' }}>
                    {{ $customer->customer_name }}
                </option>
            @endforeach
        </select>
        @error('customer_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Product</label>
        <select name="product_id" required>
            @foreach($products as $product)
                <option value="{{ $product->id }}"
                    {{ old('product_id', $sale->product_id) == $product->id ? 'selected' : '' }}>
                    {{ $product->product_name }} - LKR {{ number_format($product->price, 2) }}
                    (Stock: {{ $product->quantity }})
                </option>
            @endforeach
        </select>
        @error('product_id')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Quantity</label>
        <input
            type="number"
            name="quantity"
            min="1"
            value="{{ old('quantity', $sale->quantity) }}"
            required
        >
        @error('quantity')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Sale Date</label>
        <input
            type="date"
            name="sale_date"
            value="{{ old('sale_date', $sale->sale_date) }}"
            required
        >
        @error('sale_date')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Update Sale</button>

        <a href="{{ route('sales.index') }}" class="back">Back</a>

    </form>

</div>

</body>
</html>
