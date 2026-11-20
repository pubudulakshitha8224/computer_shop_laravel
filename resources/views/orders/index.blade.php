
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Orders - Computer Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px;
        }

        .container {
            max-width: 1200px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
        }

        h1 {
            color: #1e293b;
            margin-bottom: 20px;
        }

        nav {
            margin-bottom: 25px;
        }

        nav a {
            display: inline-block;
            margin-right: 15px;
            margin-bottom: 8px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        nav a:hover {
            color: #7c3aed;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        .filter-box {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 25px;
            border: 1px solid #e2e8f0;
        }

        .filter-box form {
            display: flex;
            gap: 12px;
            flex-wrap: wrap;
            align-items: center;
        }

        .filter-box input,
        .filter-box select {
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 14px;
            outline: none;
        }

        .filter-box input {
            flex: 1;
            min-width: 200px;
        }

        .filter-box select {
            min-width: 160px;
            background: white;
        }

        .search-btn {
            background: #2563eb;
            color: white;
            border: none;
            padding: 12px 20px;
            border-radius: 6px;
            cursor: pointer;
            font-weight: bold;
        }

        .search-btn:hover {
            background: #1d4ed8;
        }

        .clear-btn {
            display: inline-block;
            background: #64748b;
            color: white;
            padding: 12px 20px;
            border-radius: 6px;
            text-decoration: none;
            font-weight: bold;
        }

        .clear-btn:hover {
            background: #475569;
        }

        .result-info {
            margin-bottom: 15px;
            color: #475569;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 750px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #1e293b;
            color: white;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        .status {
            padding: 6px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: bold;
        }

        .pending {
            background: #fef3c7;
            color: #92400e;
        }

        .confirmed {
            background: #dbeafe;
            color: #1e40af;
        }

        .completed {
            background: #dcfce7;
            color: #166534;
        }

        .cancelled {
            background: #fee2e2;
            color: #991b1b;
        }

        .view-btn {
            display: inline-block;
            background: #2563eb;
            color: white;
            padding: 8px 12px;
            border-radius: 5px;
            text-decoration: none;
        }

        .view-btn:hover {
            background: #1d4ed8;
        }

        .empty {
            text-align: center;
            padding: 30px;
            color: #64748b;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 15px;
            }

            .filter-box form {
                flex-direction: column;
                align-items: stretch;
            }

            .filter-box input,
            .filter-box select,
            .search-btn,
            .clear-btn {
                width: 100%;
            }

            nav a {
                margin-bottom: 10px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('sales.index') }}">Sales</a>
        <a href="{{ route('orders.index') }}">All Orders</a>
    </nav>

    <h1>Customer Orders</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div class="error">
            {{ session('error') }}
        </div>
    @endif

    <!-- Search and Filter -->
    <div class="filter-box">

        <form action="{{ route('orders.index') }}" method="GET">

            <input
                type="text"
                name="search"
                placeholder="Search Order ID, Customer Name or Phone..."
                value="{{ $search ?? '' }}"
            >

            <select name="status">
                <option value="">All Orders</option>

                <option value="Pending"
                    {{ ($status ?? '') === 'Pending' ? 'selected' : '' }}>
                    Pending
                </option>

                <option value="Confirmed"
                    {{ ($status ?? '') === 'Confirmed' ? 'selected' : '' }}>
                    Confirmed
                </option>

                <option value="Completed"
                    {{ ($status ?? '') === 'Completed' ? 'selected' : '' }}>
                    Completed
                </option>

                <option value="Cancelled"
                    {{ ($status ?? '') === 'Cancelled' ? 'selected' : '' }}>
                    Cancelled
                </option>
            </select>

            <button type="submit" class="search-btn">
                Search
            </button>

            <a href="{{ route('orders.index') }}" class="clear-btn">
                Clear
            </a>

        </form>

    </div>

    <p class="result-info">
        Showing {{ $orders->count() }} order(s)
    </p>

    <!-- Orders Table -->
    <div class="table-wrapper">

        <table>
            <thead>
                <tr>
                    <th>Order ID</th>
                    <th>Customer Name</th>
                    <th>Phone</th>
                    <th>Total Amount</th>
                    <th>Status</th>
                    <th>Order Date</th>
                    <th>Action</th>
                </tr>
            </thead>

            <tbody>

                @forelse($orders as $order)

                    <tr>
                        <td>#{{ $order->id }}</td>

                        <td>{{ $order->customer_name }}</td>

                        <td>{{ $order->phone }}</td>

                        <td>
                            LKR {{ number_format($order->total_amount, 2) }}
                        </td>

                        <td>
                            <span class="status {{ strtolower($order->status) }}">
                                {{ $order->status }}
                            </span>
                        </td>

                        <td>
                            {{ $order->created_at->format('Y-m-d') }}
                        </td>

                        <td>
                            <a href="{{ route('orders.show', $order->id) }}"
                               class="view-btn">
                                View Details
                            </a>
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="7" class="empty">
                            No customer orders found.
                        </td>
                    </tr>

                @endforelse

            </tbody>
        </table>

    </div>

</div>

</body>
</html>
