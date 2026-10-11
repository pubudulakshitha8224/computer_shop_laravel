<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            max-width: 600px;
            margin: 40px auto;
            padding: 20px;
        }

        label {
            display: block;
            margin-top: 15px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            box-sizing: border-box;
        }

        button {
            margin-top: 20px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            border: none;
            cursor: pointer;
        }

        .errors {
            color: #b91c1c;
        }
    </style>
</head>
<body>
    <h1>Edit Product</h1>

    @if ($errors->any())
        <div class="errors">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('products.update', $product) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="product_name">Product Name</label>
        <input
            id="product_name"
            name="product_name"
            type="text"
            value="{{ old('product_name', $product->product_name) }}"
            maxlength="255"
            required
        >

        <label for="brand">Brand</label>
        <input
            id="brand"
            name="brand"
            type="text"
            value="{{ old('brand', $product->brand) }}"
            maxlength="255"
            required
        >

        <label for="price">Price (LKR)</label>
        <input
            id="price"
            name="price"
            type="number"
            value="{{ old('price', $product->price) }}"
            min="0"
            max="99999999.99"
            step="0.01"
            required
        >

        <label for="quantity">Quantity</label>
        <input
            id="quantity"
            name="quantity"
            type="number"
            value="{{ old('quantity', $product->quantity) }}"
            min="0"
            max="2147483647"
            step="1"
            required
        >

        <label for="description">Description</label>
        <textarea id="description" name="description" rows="4">{{ old('description', $product->description) }}</textarea>

        <button type="submit">Update Product</button>
    </form>

    <p><a href="{{ route('products.index') }}">Back to Products</a></p>
</body>
</html>