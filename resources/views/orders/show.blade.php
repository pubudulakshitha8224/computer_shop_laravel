
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Computer Shop</title>

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
            max-width: 1000px;
            margin: auto;
            background: white;
            padding: 25px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        h1, h2 {
            color: #1e293b;
            margin-bottom: 20px;
        }

        nav {
            margin-bottom: 25px;
        }

        nav a {
            margin-right: 15px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .section {
            margin-bottom: 30px;
        }

        .details {
            background: #f8fafc;
            padding: 18px;
            border-radius: 8px;
            line-height: 2;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 550px;
        }

        th, td {
            padding: 12px;
            border-bottom: 1px solid #e2e8f0;
            text-align: left;
        }

        th {
            background: #1e293b;
            color: white;
        }

        .total {
            text-align: right;
            font-size: 20px;
            font-weight: bold;
            margin-top: 20px;
        }

        .status-form {
            background: #f8fafc;
            padding: 20px;
            border-radius: 8px;
        }

        select {
            padding: 10px;
            width: 220px;
            max-width: 100%;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            margin-right: 10px;
        }

        button {
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        button:hover {
            background: #1d4ed8;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 10px 15px;
            background: #64748b;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }

        .error {
            color: #b91c1c;
            margin-bottom: 15px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
            padding: 12px;
            border-radius: 6px;
            margin-bottom: 20px;
        }

        @media (max-width: 600px) {
            body {
                padding: 12px;
            }

            .container {
                padding: 15px;
            }

            select {
                display: block;
                width: 100%;
                margin-bottom: 12px;
            }

            button {
                width: 100%;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <nav>
        <a href="{{ route('dashboard') }}">Dashboard</a>
        <a href="{{ route('orders.index') }}">All Orders</a>
    </nav>

    <h1>Order Details #{{ $order->id }}</h1>

    @if(session('success'))
        <div class="success">
            {{ session('success') }}
        </div>
    @endif

    @if($errors->any())
        <div class="error">
            @foreach($errors->all() as $error)
                <p>{{ $error }}</p>
            @endforeach
        </div>
    @endif

    <!-- Customer Details -->

    <div class="section">

        <h2>Customer Information</h2>

        <div class="details">
            <p>
                <strong>Customer Name:</strong>
                {{ $order->customer_name }}
            </p>

            <p>
                <strong>Phone Number:</strong>
                {{ $order->phone }}
            </p>

            <p>
                <strong>Delivery Address:</strong>
                {{ $order->address }}
            </p>

            <p>
                <strong>Order Date:</strong>
                {{ $order->created_at->format('Y-m-d H:i') }}
            </p>

            <p>
                <strong>Current Status:</strong>
                {{ $order->status }}
            </p>
        </div>

    </div>


    <!-- Ordered Products -->

    <div class="section">

        <h2>Ordered Products</h2>

        <div class="table-wrapper">
            <table>

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                    </tr>
                </thead>

                <tbody>

                    @foreach($order->items as $item)

                        <tr>
                            <td>{{ $item->product_name }}</td>

                            <td>{{ $item->brand ?? '-' }}</td>

                            <td>
                                LKR {{ number_format($item->price, 2) }}
                            </td>

                            <td>{{ $item->quantity }}</td>

                            <td>
                                LKR {{ number_format($item->subtotal, 2) }}
                            </td>
                        </tr>

                    @endforeach

                </tbody>

            </table>
        </div>

        <div class="total">
            Total Amount:
            LKR {{ number_format($order->total_amount, 2) }}
        </div>

    </div>


    <!-- Update Order Status -->

    <div class="section">

        <h2>Update Order Status</h2>

        <div class="status-form">

            <form action="{{ route('orders.updateStatus', $order->id) }}"
                  method="POST">

                @csrf
                @method('PUT')

                <select name="status" required>

                    <option value="Pending"
                        {{ $order->status == 'Pending' ? 'selected' : '' }}>
                        Pending
                    </option>

                    <option value="Confirmed"
                        {{ $order->status == 'Confirmed' ? 'selected' : '' }}>
                        Confirmed
                    </option>

                    <option value="Completed"
                        {{ $order->status == 'Completed' ? 'selected' : '' }}>
                        Completed
                    </option>

                    <option value="Cancelled"
                        {{ $order->status == 'Cancelled' ? 'selected' : '' }}>
                        Cancelled
                    </option>

                </select>

                <button type="submit">
                    Update Status
                </button>

            </form>

        </div>

    </div>

    <a href="{{ route('orders.index') }}" class="back-btn">
        Back to Orders
    </a>

</div>

</body>
</html>
