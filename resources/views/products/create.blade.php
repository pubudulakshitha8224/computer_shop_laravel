<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f4f6f8;
            padding: 20px;
        }

        .container {
            max-width: 550px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 5px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .errors {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Add Product</h1>

        <a href="{{ route('products.index') }}">← Back to Products</a>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('products.store') }}" method="POST">
            @csrf

            <label for="product_name">Product Name</label>
            <input
                id="product_name"
                type="text"
                name="product_name"
                value="{{ old('product_name') }}"
                maxlength="255"
                required
            >

            <label for="brand">Brand</label>
            <input
                id="brand"
                type="text"
                name="brand"
                value="{{ old('brand') }}"
                maxlength="255"
                required
            >

            <label for="price">Price (LKR)</label>
            <input
                id="price"
                type="number"
                name="price"
                value="{{ old('price') }}"
                min="0"
                max="99999999.99"
                step="0.01"
                required
            >

            <label for="quantity">Quantity</label>
            <input
                id="quantity"
                type="number"
                name="quantity"
                value="{{ old('quantity') }}"
                min="0"
                max="2147483647"
                step="1"
                required
            >

            <label for="description">Description (Optional)</label>
            <textarea
                id="description"
                name="description"
                rows="4"
            >{{ old('description') }}</textarea>

            <button type="submit">Save Product</button>
        </form>
    </div>
</body>
</html>