
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Shop Dashboard</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #333;
            animation: fadeIn 0.7s ease;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .header {
            background: linear-gradient(135deg, #0f172a, #312e81);
            color: white;
            padding: 28px 35px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.15);
        }

        .header h1 {
            font-size: 27px;
            margin-bottom: 8px;
        }

        .header p {
            color: #cbd5e1;
        }

        .container {
            max-width: 1400px;
            margin: auto;
            padding: 30px;
        }

        .navigation {
            display: flex;
            flex-wrap: wrap;
            gap: 12px;
            margin-bottom: 30px;
        }

        .navigation a {
            display: inline-block;
            background: #2563eb;
            color: white;
            text-decoration: none;
            padding: 12px 22px;
            border-radius: 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }

        .navigation a:hover {
            background: #7c3aed;
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .navigation a.active {
            background: #7c3aed;
        }

        .dashboard-title {
            margin-bottom: 22px;
            color: #1e293b;
            font-size: 23px;
        }

        .cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(210px, 1fr));
            gap: 22px;
            margin-bottom: 35px;
        }

        .card {
            background: white;
            padding: 25px;
            border-radius: 13px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            border-left: 5px solid #2563eb;
            transition: all 0.3s ease;
            animation: fadeIn 0.8s ease;
        }

        .card:hover {
            transform: translateY(-7px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.12);
        }

        .card h3 {
            color: #64748b;
            margin-bottom: 17px;
            font-size: 15px;
        }

        .card p {
            font-size: 28px;
            font-weight: bold;
            color: #2563eb;
            overflow-wrap: anywhere;
        }

        .card:nth-child(2) {
            border-left-color: #7c3aed;
        }

        .card:nth-child(2) p {
            color: #7c3aed;
        }

        .card:nth-child(3) {
            border-left-color: #0891b2;
        }

        .card:nth-child(3) p {
            color: #0891b2;
        }

        .card:nth-child(4) {
            border-left-color: #16a34a;
        }

        .card:nth-child(4) p {
            color: #16a34a;
        }

        .section {
            background: white;
            padding: 25px;
            border-radius: 13px;
            margin-bottom: 28px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.06);
            overflow-x: auto;
            transition: box-shadow 0.3s ease;
        }

        .section:hover {
            box-shadow: 0 7px 20px rgba(0,0,0,0.1);
        }

        h2 {
            color: #1e293b;
            margin-bottom: 20px;
            font-size: 21px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th, td {
            padding: 14px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        th {
            background: #1e293b;
            color: white;
        }

        tbody tr {
            transition: background 0.3s ease;
        }

        tbody tr:hover {
            background: #eff6ff;
        }

        .footer {
            text-align: center;
            padding: 22px;
            color: #64748b;
            background: #e2e8f0;
            margin-top: 20px;
        }

        @media (max-width: 600px) {
            .header {
                padding: 22px 18px;
            }

            .header h1 {
                font-size: 21px;
            }

            .container {
                padding: 18px 12px;
            }

            .cards {
                grid-template-columns: 1fr;
            }

            .navigation a {
                padding: 10px 15px;
            }

            .section {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="header">
        <h1>Computer Shop Management System</h1>
        <p>Dashboard Overview</p>
    </div>

    <div class="container">

        <div class="navigation">
            <a href="{{ route('dashboard') }}" class="active">Dashboard</a>
            <a href="{{ route('products.index') }}">Products</a>
            <a href="{{ route('customers.index') }}">Customers</a>
            <a href="{{ route('sales.index') }}">Sales</a>
        </div>

        <h2 class="dashboard-title">Dashboard Summary</h2>

        <div class="cards">

            <div class="card">
                <h3>Total Products</h3>
                <p>{{ $totalProducts }}</p>
            </div>

            <div class="card">
                <h3>Total Customers</h3>
                <p>{{ $totalCustomers }}</p>
            </div>

            <div class="card">
                <h3>Total Sales</h3>
                <p>{{ $totalSales }}</p>
            </div>

            <div class="card">
                <h3>Total Income</h3>
                <p>LKR {{ number_format($totalIncome, 2) }}</p>
            </div>

        </div>

        <div class="section">
            <h2>Recent Sales</h2>

            <table>
                <thead>
                    <tr>
                        <th>Customer</th>
                        <th>Product</th>
                        <th>Quantity</th>
                        <th>Total Price</th>
                        <th>Date</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($recentSales as $sale)
                        <tr>
                            <td>{{ $sale->customer->customer_name ?? 'N/A' }}</td>
                            <td>{{ $sale->product_name }}</td>
                            <td>{{ $sale->quantity }}</td>
                            <td>LKR {{ number_format($sale->total_price, 2) }}</td>
                            <td>{{ $sale->sale_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">No sales found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <div class="section">
            <h2>Low Stock Products</h2>

            <table>
                <thead>
                    <tr>
                        <th>Product Name</th>
                        <th>Brand</th>
                        <th>Available Quantity</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse($lowStockProducts as $product)
                        <tr>
                            <td>{{ $product->product_name }}</td>
                            <td>{{ $product->brand }}</td>
                            <td>{{ $product->quantity }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="3">No low stock products.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

    <div class="footer">
        Computer Shop Management System
    </div>

</body>
</html>
