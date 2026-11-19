
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
            transition: all 0.3s ease;
        }

        .add-button:hover {
            background: #1d4ed8;
            transform: translateY(-3px);
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

        /* Sales Summary Cards */

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
            box-shadow: 0 7px 15px rgba(0, 0, 0, 0.15);
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

        /* Search and Filter */

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
            transition: all 0.3s ease;
        }

        .search-button {
            background: #2563eb;
        }

        .search-button:hover {
            background: #1d4ed8;
            transform: translateY(-3px);
        }

        .clear-button {
            background: #64748b;
        }

        .clear-button:hover {
            background: #475569;
            transform: translateY(-3px);
        }

        /* Sales Table */

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

        /* Edit and Delete Buttons */

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

        .edit-button,
        .delete-button {
            transition: all 0.3s ease;
        }

        .edit-button:hover {
            background: #15803d;
            transform: translateY(-4px);
            box-shadow: 0 5px 12px rgba(22, 163, 74, 0.3);
        }

        .delete-button:hover {
            background: #b91c1c;
            transform: translateY(-4px);
            box-shadow: 0 5px 12px rgba(220, 38, 38, 0.3);
        }

        .edit-button:active,
        .delete-button:active {
            transform: scale(0.95);
        }

        /* Responsive Design */

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
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('sales.index') }}">Sales</a>
    </nav>

    <h1>Sales</h1>

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

    <!-- Sales Summary Cards -->

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

    </div>

</body>
</html>
