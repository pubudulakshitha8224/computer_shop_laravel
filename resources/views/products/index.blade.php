<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
        }

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 24px;
            background: white;
            border-radius: 10px;
            overflow-x: auto;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #eff6ff;
        }

        .success {
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            margin-bottom: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Products</h1>

        @if (session('success'))
            <div class="success">{{ session('success') }}</div>
        @endif

        <a href="{{ route('products.create') }}" class="button">
            + Add Product
        </a>

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Price (LKR)</th>
                    <th>Quantity</th>
                    <th>Description</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>
                        <td>{{ $product->product_name }}</td>
                        <td>{{ $product->brand }}</td>
                        <td>{{ number_format($product->price, 2) }}</td>
                        <td>{{ $product->quantity }}</td>
                        <td>{{ $product->description ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No products added yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</body>
</html>