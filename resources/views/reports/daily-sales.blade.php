
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daily Sales Report</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background: #f4f6f9;
            color: #333;
        }

        .navbar {
            background: #1e293b;
            padding: 18px 30px;
            color: white;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
        }

        .navbar h2 {
            margin: 0;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin-left: 18px;
            font-size: 14px;
        }

        .container {
            max-width: 1200px;
            margin: 30px auto;
            padding: 0 20px;
        }

        .page-title {
            margin-bottom: 25px;
        }

        .page-title h1 {
            margin-bottom: 8px;
        }

        .filter-box {
            background: white;
            padding: 20px;
            border-radius: 10px;
            margin-bottom: 25px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .filter-box form {
            display: flex;
            align-items: end;
            gap: 12px;
            flex-wrap: wrap;
        }

        .filter-box label {
            display: block;
            margin-bottom: 8px;
            font-weight: bold;
        }

        .filter-box input {
            padding: 11px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }

        button {
            padding: 11px 20px;
            border: none;
            border-radius: 6px;
            background: #2563eb;
            color: white;
            cursor: pointer;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 20px;
            margin-bottom: 25px;
        }

        .card {
            background: white;
            padding: 22px;
            border-radius: 10px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        .card h3 {
            color: #64748b;
            font-size: 15px;
            margin-top: 0;
        }

        .card h2 {
            font-size: 27px;
            margin-bottom: 0;
            color: #1e293b;
        }

        .table-box {
            background: white;
            padding: 22px;
            border-radius: 10px;
            overflow-x: auto;
            box-shadow: 0 2px 8px rgba(0,0,0,0.05);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 650px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #eee;
        }

        th {
            background: #f1f5f9;
        }

        .empty {
            text-align: center;
            padding: 25px;
            color: #777;
        }

        .back-btn {
            display: inline-block;
            margin-top: 20px;
            padding: 11px 18px;
            background: #475569;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        @media (max-width: 700px) {
            .cards {
                grid-template-columns: 1fr;
            }

            .navbar {
                padding: 18px;
            }

            .navbar a {
                margin-left: 0;
                margin-right: 12px;
            }
        }
    </style>
</head>

<body>

    <div class="navbar">
        <h2>Computer Shop Management System</h2>

        <div>
            <a href="{{ route('dashboard') }}">Dashboard</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('customers.index') }}">Customers</a>
            <a href="{{ route('sales.index') }}">Sales</a>
            <a href="{{ route('orders.index') }}">Orders</a>
        </div>
    </div>

    <div class="container">

        <div class="page-title">
            <h1>Daily Sales Report</h1>
            <p>View sales details for a selected date.</p>
        </div>

        <div class="filter-box">
            <form method="GET" action="{{ route('reports.dailySales') }}">

                <div>
                    <label for="date">Select Date</label>

                    <input
                        type="date"
                        id="date"
                        name="date"
                        value="{{ $date }}"
                        required
                    >
                </div>

                <button type="submit">Generate Report</button>

            </form>
        </div>

        <div class="cards">

            <div class="card">
                <h3>Total Sales</h3>
                <h2>{{ $totalSales }}</h2>
            </div>

            <div class="card">
                <h3>Total Quantity Sold</h3>
                <h2>{{ $totalQuantity }}</h2>
            </div>

            <div class="card">
                <h3>Total Income</h3>
                <h2>LKR {{ number_format($totalIncome, 2) }}</h2>
            </div>

        </div>

        <div class="table-box">

            <h2>Sales Details</h2>

            <p>
                Report Date:
                <strong>{{ \Carbon\Carbon::parse($date)->format('d M Y') }}</strong>
            </p>

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
                                No sales found for this date.
                            </td>
                        </tr>

                    @endforelse

                </tbody>

            </table>

        </div>

        <a href="{{ route('dashboard') }}" class="back-btn">
            Back to Dashboard
        </a>

    </div>

</body>
</html>
