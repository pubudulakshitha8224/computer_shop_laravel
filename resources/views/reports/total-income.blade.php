
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Total Income Report</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 25px;
            color: #333;
        }

        .container {
            max-width: 1200px;
            margin: auto;
        }

        h1 {
            color: #222;
        }

        .nav {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin: 20px 0;
        }

        .nav a {
            background: #263b59;
            color: white;
            padding: 10px 15px;
            text-decoration: none;
            border-radius: 5px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin: 20px 0;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 8px;
            box-shadow: 0 2px 6px #ddd;
        }

        .card h3 {
            margin-top: 0;
            color: #666;
        }

        .card p {
            font-size: 25px;
            font-weight: bold;
            margin-bottom: 0;
            color: #2563eb;
        }

        .table-box {
            background: white;
            padding: 20px;
            border-radius: 8px;
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 700px;
        }

        th, td {
            padding: 13px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #263b59;
            color: white;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Total Income Report</h1>

    <p>View all sales and total income of the Computer Shop.</p>

    <div class="nav">
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('products.index') }}">Products</a>
        <a href="{{ route('customers.index') }}">Customers</a>
        <a href="{{ route('sales.index') }}">Sales</a>
        <a href="{{ route('orders.index') }}">All Orders</a>
        <a href="{{ route('reports.dailySales') }}">Daily Report</a>
        <a href="{{ route('reports.monthlySales') }}">Monthly Report</a>
    </div>

    <div class="cards">

        <div class="card">
            <h3>Total Sales</h3>
            <p>{{ $totalSales }}</p>
        </div>

        <div class="card">
            <h3>Total Quantity Sold</h3>
            <p>{{ $totalQuantity }}</p>
        </div>

        <div class="card">
            <h3>Total Income</h3>
            <p>LKR {{ number_format($totalIncome, 2) }}</p>
        </div>

    </div>

    <div class="table-box">

        <h2>All Sales Details</h2>

        <table>
            <thead>
                <tr>
                    <th>Sale ID</th>
                    <th>Customer Name</th>
                    <th>Product Name</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                    <th>Sale Date</th>
                </tr>
            </thead>

            <tbody>
                @forelse($sales as $sale)

                    <tr>
                        <td>#{{ $sale->id }}</td>

                        <td>
                            {{ $sale->customer->customer_name ?? 'N/A' }}
                        </td>

                        <td>{{ $sale->product_name }}</td>

                        <td>{{ $sale->quantity }}</td>

                        <td>
                            LKR {{ number_format($sale->total_price, 2) }}
                        </td>

                        <td>
                            {{ \Carbon\Carbon::parse($sale->sale_date)->format('Y-m-d') }}
                        </td>
                    </tr>

                @empty

                    <tr>
                        <td colspan="6" class="empty">
                            No sales records found.
                        </td>
                    </tr>

                @endforelse
            </tbody>
        </table>

    </div>

</div>

</body>
</html>
