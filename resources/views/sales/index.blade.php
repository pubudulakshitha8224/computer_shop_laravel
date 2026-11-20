
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Sales - Computer Shop</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
        }

        nav {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
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

        .add-button:hover {
            background: #1d4ed8;
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

        .summary-cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 16px;
            margin-bottom: 22px;
        }

        .summary-card {
            padding: 22px;
            border-radius: 10px;
            color: white;
            box-shadow: 0 3px 10px rgba(0, 0, 0, 0.08);
            transition: all 0.3s ease;
        }

        .summary-card:hover {
            transform: translateY(-5px);
        }

        .summary-card h3 {
            font-size: 15px;
            margin: 0 0 12px;
        }

        .summary-card p {
            font-size: 26px;
            font-weight: bold;
            margin: 0;
        }

        .summary-card.sales {
            background: #2563eb;
        }

        .summary-card.quantity {
            background: #16a34a;
        }

        .summary-card.income {
            background: #7c3aed;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 20px;
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
        }

        .filter-box input {
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        .search-input {
            flex: 1;
            min-width: 180px;
        }

        .search-button,
        .clear-button {
            padding: 11px 18px;
            border: none;
            border-radius: 6px;
            color: white;
            text-decoration: none;
            cursor: pointer;
            font-size: 14px;
        }

        .search-button {
            background: #2563eb;
        }

        .search-button:hover {
            background: #1d4ed8;
        }

        .clear-button {
            background: #64748b;
        }

        .clear-button:hover {
            background: #475569;
        }

        .table-container {
            width: 100%;
            overflow-x: auto;
            background: white;
            border-radius: 8px;
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

        @media (max-width: 700px) {
            body {
                margin: 15px;
            }

            .summary-cards {
                grid-template-columns: 1fr;
            }

            .filter-box {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-box input,
            .filter-box button,
            .filter-box a {
                width: 100%;
            }

            table {
                font-size: 12px;
            }

            th, td {
                padding: 7px;
            }
        }
    </style>
</head>

<body>

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('sales.index') }}">Sales</a>
        <a href="{{ route('orders.index') }}">All Orders</a>
    </nav>

    <h1>Sales Management</h1>

    <a href="{{ route('sales.create') }}" class="add-button">
        + Add Sale
    </a>

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

    @if ($errors->any())
        <div class="error-message">
            @foreach ($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Sales Summary -->

    <div class="summary-cards">

        <div class="summary-card sales">
            <h3>Total Sales</h3>
            <p>{{ $totalSalesCount }}</p>
        </div>

        <div class="summary-card quantity">
            <h3>Total Quantity Sold</h3>
            <p>{{ $totalQuantity }}</p>
        </div>

        <div class="summary-card income">
            <h3>Total Income</h3>
            <p>LKR {{ number_format($totalSalesAmount, 2) }}</p>
        </div>

    </div>

    <!-- Search and Date Filter -->

    <form action="{{ route('sales.index') }}" method="GET" class="filter-box">

        <input
            type="text"
            name="search"
            class="search-input"
            placeholder="Search customer or product..."
            value="{{ $search ?? '' }}"
        >

        <input
            type="date"
            name="sale_date"
            value="{{ $saleDate ?? '' }}"
        >

        <button type="submit" class="search-button">
            Search
        </button>

        <a href="{{ route('sales.index') }}" class="clear-button">
            Clear
        </a>

    </form>

    <!-- Sales Table -->

    <div class="table-container">

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer</th>
                    <th>Product</th>
                    <th>Quantity</th>
                    <th>Total Price (LKR)</th>
                    <th>Sale Date</th>

                    @if (auth()->user()->role === 'admin')
                        <th>Actions</th>
                    @endif
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

                        @if (auth()->user()->role === 'admin')
                            <td>

                                @if ($sale->product_id)

                                    <a
                                        href="{{ route('sales.edit', $sale->id) }}"
                                        class="edit-button">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('sales.destroy', $sale->id) }}"
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
                        @endif

                    </tr>

                @empty

                    <tr>
                        <td
                            colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}"
                            class="empty">
                            No sales found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

</body>
</html>
