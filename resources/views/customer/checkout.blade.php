
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Checkout - Computer Shop</title>

    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        body {
            font-family: Arial, sans-serif;
            background: #f1f5f9;
            padding: 30px 15px;
            color: #1e293b;
        }

        .container {
            max-width: 850px;
            margin: auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.08);
        }

        h1 {
            margin-bottom: 10px;
            color: #1e293b;
        }

        .subtitle {
            color: #64748b;
            margin-bottom: 25px;
        }

        h2 {
            margin: 25px 0 15px;
            font-size: 20px;
        }

        .order-item {
            display: flex;
            justify-content: space-between;
            gap: 15px;
            padding: 15px 0;
            border-bottom: 1px solid #e2e8f0;
        }

        .total {
            text-align: right;
            font-size: 22px;
            font-weight: bold;
            margin-top: 20px;
            color: #15803d;
        }

        label {
            display: block;
            margin: 18px 0 7px;
            font-weight: bold;
        }

        input, textarea {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
        }

        textarea {
            min-height: 100px;
            resize: vertical;
        }

        .place-btn {
            width: 100%;
            margin-top: 25px;
            padding: 14px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            font-size: 16px;
            cursor: pointer;
        }

        .place-btn:hover {
            background: #1d4ed8;
        }

        .back-link {
            display: inline-block;
            margin-top: 20px;
            color: #2563eb;
            text-decoration: none;
        }

        .error {
            color: #b91c1c;
            background: #fee2e2;
            padding: 12px;
            border-radius: 6px;
            margin: 10px 0;
        }

        @media (max-width: 600px) {
            .container {
                padding: 20px;
            }

            .order-item {
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

<div class="container">

    <h1>Customer Checkout</h1>

    <p class="subtitle">
        Enter your details to place your order.
    </p>

    @if ($errors->any())
        <div class="error">
            <strong>Please correct these errors:</strong>

            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <h2>Order Summary</h2>

    @php
        $total = 0;
    @endphp

    @foreach ($cart as $item)

        @php
            $subtotal = $item['price'] * $item['quantity'];
            $total += $subtotal;
        @endphp

        <div class="order-item">

            <div>
                <strong>{{ $item['product_name'] }}</strong>
                <br>
                {{ $item['brand'] }}
                <br>
                Quantity: {{ $item['quantity'] }}
            </div>

            <div>
                LKR {{ number_format($subtotal, 2) }}
            </div>

        </div>

    @endforeach

    <div class="total">
        Total: LKR {{ number_format($total, 2) }}
    </div>


    <h2>Customer Details</h2>

    <form action="{{ route('order.place') }}" method="POST">

        @csrf

        <label for="customer_name">Customer Name</label>

        <input
            type="text"
            id="customer_name"
            name="customer_name"
            value="{{ old('customer_name') }}"
            placeholder="Enter your full name"
            required
        >

        <label for="phone">Phone Number</label>

        <input
            type="tel"
            id="phone"
            name="phone"
            value="{{ old('phone') }}"
            placeholder="Enter your phone number"
            required
        >

        <label for="address">Delivery Address</label>

        <textarea
            id="address"
            name="address"
            placeholder="Enter your delivery address"
            required
        >{{ old('address') }}</textarea>

        <button type="submit" class="place-btn">
            Place Order
        </button>

    </form>

    <a href="{{ route('cart.index') }}" class="back-link">
        ← Back to Cart
    </a>

</div>

</body>
</html>
