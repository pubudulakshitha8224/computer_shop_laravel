<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales - Computer Shop</title>

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
        }

        nav {
            margin-bottom: 25px;
        }

        nav a {
            margin-right: 15px;
            color: #2563eb;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 12px;
            text-align: left;
        }

        th {
            background: #2563eb;
            color: white;
        }

        .empty {
            text-align: center;
            color: #666;
        }
    </style>
</head>
<body>
    <nav>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('sales.index') }}">Sales</a>
    </nav>

    <h1>Sales</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price (LKR)</th>
                <th>Sale Date</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>
                    <td>{{ $sale->customer?->customer_name ?? 'Customer unavailable' }}</td>
                    <td>{{ $sale->product_name }}</td>
                    <td>{{ $sale->quantity }}</td>
                    <td>{{ number_format($sale->total_price, 2) }}</td>
                    <td>{{ $sale->sale_date }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="empty">No sales found.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>
</html>