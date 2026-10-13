<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Customer</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
        }

        .container {
            max-width: 600px;
            margin: auto;
            padding: 25px;
            background: white;
            border-radius: 10px;
        }

        label {
            display: block;
            margin-top: 15px;
            margin-bottom: 6px;
        }

        input, textarea {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
            font: inherit;
        }

        button {
            margin-top: 20px;
            padding: 10px 15px;
            border: none;
            border-radius: 5px;
            background: #007bff;
            color: white;
            cursor: pointer;
        }

        .errors {
            padding: 12px;
            background: #f8d7da;
            color: #721c24;
            margin-bottom: 15px;
        }

        .back {
            display: inline-block;
            margin-top: 15px;
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Edit Customer</h1>

        @if ($errors->any())
            <div class="errors">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('customers.update', $customer) }}" method="POST">
            @csrf
            @method('PUT')

            <label for="customer_name">Customer Name</label>
            <input
                type="text"
                id="customer_name"
                name="customer_name"
                value="{{ old('customer_name', $customer->customer_name) }}"
                maxlength="255"
                required
            >

            <label for="phone">Phone</label>
            <input
                type="tel"
                id="phone"
                name="phone"
                value="{{ old('phone', $customer->phone) }}"
                maxlength="20"
                required
            >

            <label for="email">Email (Optional)</label>
            <input
                type="email"
                id="email"
                name="email"
                value="{{ old('email', $customer->email) }}"
                maxlength="255"
            >

            <label for="address">Address (Optional)</label>
            <textarea
                id="address"
                name="address"
                rows="3"
            >{{ old('address', $customer->address) }}</textarea>

            <button type="submit">Update Customer</button>
        </form>

        <a href="{{ route('customers.index') }}" class="back">
            Back to Customers
        </a>
    </div>
</body>
</html>