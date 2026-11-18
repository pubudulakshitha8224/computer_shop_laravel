
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
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        nav a {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        nav a:hover {
            background: #7c3aed;
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.2);
        }

        .add-button {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 10px 16px;
            text-decoration: none;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error-message {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 5px;
            margin-bottom: 20px;
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

        .edit-button {
            display: inline-block;
            background: #16a34a;
            color: white;
            padding: 7px 12px;
            text-decoration: none;
            border-radius: 5px;
            margin-right: 5px;
        }

        .delete-button {
            background: #dc2626;
            color: white;
            padding: 7px 12px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .edit-button:hover {
            background: #15803d;
        }

        .delete-button:hover {
            background: #b91c1c;
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

    <a href="{{ route('sales.create') }}" class="add-button">Add Sale</a>

    @if (session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="error-message">
            {{ session('error') }}
        </div>
    @endif

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Customer</th>
                <th>Product</th>
                <th>Quantity</th>
                <th>Total Price (LKR)</th>
                <th>Sale Date</th>
                <th>Actions</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($sales as $sale)
                <tr>
                    <td>{{ $sale->id }}</td>

                    <td>
                        {{ $sale->customer?->customer_name ?? 'Customer unavailable' }}
                    </td>

                    <td>{{ $sale->product_name }}</td>

                    <td>{{ $sale->quantity }}</td>

                    <td>{{ number_format($sale->total_price, 2) }}</td>

                    <td>{{ $sale->sale_date }}</td>

                    <td>
                        @if ($sale->product_id)

                            <a href="{{ route('sales.edit', $sale->id) }}"
                               class="edit-button">
                                Edit
                            </a>

                            <form action="{{ route('sales.destroy', $sale->id) }}"
                                  method="POST"
                                  style="display: inline;"
                                  onsubmit="return confirm('Are you sure you want to delete this sale?');">

                                @csrf
                                @method('DELETE')

                                <button type="submit" class="delete-button">
                                    Delete
                                </button>
                            </form>

                        @else
                            <span>Not available</span>
                        @endif
                    </td>
                </tr>

            @empty
                <tr>
                    <td colspan="7" class="empty">
                        No sales found.
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

</body>
</html>
