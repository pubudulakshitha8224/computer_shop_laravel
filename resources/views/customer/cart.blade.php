
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Cart - Computer Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            color: #1e293b;
        }

        header {
            background: #0f172a;
            color: white;
            padding: 25px 7%;
        }

        nav {
            background: #1e293b;
            padding: 15px 7%;
        }

        nav a {
            color: white;
            text-decoration: none;
            margin-right: 25px;
            font-weight: bold;
        }

        nav a:hover {
            color: #60a5fa;
        }

        .container {
            width: 86%;
            margin: 35px auto;
        }

        h2 {
            margin-bottom: 20px;
        }

        .message {
            padding: 14px;
            border-radius: 7px;
            margin-bottom: 18px;
        }

        .success {
            background: #dcfce7;
            color: #166534;
        }

        .error {
            background: #fee2e2;
            color: #991b1b;
        }

        .cart-table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .cart-table th,
        .cart-table td {
            padding: 16px;
            text-align: left;
            border-bottom: 1px solid #e2e8f0;
        }

        .cart-table th {
            background: #0f172a;
            color: white;
        }

        .quantity-input {
            width: 75px;
            padding: 9px;
            border: 1px solid #cbd5e1;
            border-radius: 5px;
        }

        button {
            border: none;
            cursor: pointer;
            border-radius: 5px;
            padding: 9px 13px;
            color: white;
        }

        .update-btn {
            background: #2563eb;
        }

        .remove-btn {
            background: #dc2626;
        }

        .total-section {
            background: white;
            padding: 22px;
            margin-top: 20px;
            border-radius: 10px;
            text-align: right;
            box-shadow: 0 4px 15px rgba(0,0,0,0.06);
        }

        .total-section h3 {
            color: #2563eb;
            font-size: 23px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 25px;
            padding: 12px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .empty-cart {
            background: white;
            padding: 35px;
            text-align: center;
            border-radius: 10px;
        }

        footer {
            margin-top: 50px;
            background: #0f172a;
            color: white;
            text-align: center;
            padding: 22px;
        }

        @media (max-width: 700px) {
            .container {
                width: 94%;
            }

            .cart-table {
                font-size: 13px;
            }

            .cart-table th,
            .cart-table td {
                padding: 9px 5px;
            }

            .quantity-input {
                width: 55px;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Computer Shop</h1>
        <p>My Shopping Cart</p>
    </header>

    <nav>
        <a href="{{ route('shop.home') }}">Home</a>
        <a href="{{ route('customer.products') }}">Products</a>
        <a href="{{ route('cart.index') }}">My Cart</a>
    </nav>

    <div class="container">

        <h2>My Shopping Cart</h2>

        @if(session('success'))
            <div class="message success">
                {{ session('success') }}
            </div>
        @endif

        @if(session('error'))
            <div class="message error">
                {{ session('error') }}
            </div>
        @endif

        @if(count($cart) > 0)

            <table class="cart-table">

                <thead>
                    <tr>
                        <th>Product</th>
                        <th>Brand</th>
                        <th>Price</th>
                        <th>Quantity</th>
                        <th>Subtotal</th>
                        <th>Action</th>
                    </tr>
                </thead>

                <tbody>

                    @php
                        $total = 0;
                    @endphp

                    @foreach($cart as $id => $item)

                        @php
                            $subtotal = $item['price'] * $item['quantity'];
                            $total += $subtotal;
                        @endphp

                        <tr>

                            <td>{{ $item['product_name'] }}</td>

                            <td>{{ $item['brand'] }}</td>

                            <td>
                                LKR {{ number_format($item['price'], 2) }}
                            </td>

                            <td>

                                <form action="{{ route('cart.update', $id) }}"
                                      method="POST">

                                    @csrf

                                    <input
                                        type="number"
                                        name="quantity"
                                        value="{{ $item['quantity'] }}"
                                        min="1"
                                        class="quantity-input"
                                        required
                                    >

                                    <button type="submit" class="update-btn">
                                        Update
                                    </button>

                                </form>

                            </td>

                            <td>
                                LKR {{ number_format($subtotal, 2) }}
                            </td>

                            <td>

                                <form action="{{ route('cart.remove', $id) }}"
                                      method="POST">

                                    @csrf

                                    <button type="submit" class="remove-btn">
                                        Remove
                                    </button>

                                </form>

                            </td>

                        </tr>

                    @endforeach

                </tbody>

            </table>

            <div class="total-section">

                <h3>
                    Total: LKR {{ number_format($total, 2) }}
                </h3>

            </div>

        @else

            <div class="empty-cart">

                <h3>Your Cart is Empty</h3>

                <p style="margin-top: 12px;">
                    You haven't added any products to your cart yet.
                </p>

                <a href="{{ route('customer.products') }}"
                   class="back-btn">
                    Browse Products
                </a>

            </div>

        @endif

        <a href="{{ route('customer.products') }}" class="back-btn">
            Continue Shopping
        </a>

    </div>

    <footer>
        <p>&copy; 2026 Computer Shop. All Rights Reserved.</p>
    </footer>

</body>
</html>
