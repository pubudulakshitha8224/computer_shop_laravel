
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Computer Shop</title>

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 30px;
            background: #f4f6f8;
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

        .container {
            max-width: 1100px;
            margin: auto;
            padding: 24px;
            background: white;
            border-radius: 12px;
            overflow-x: auto;
            box-shadow: 0 5px 20px rgba(0,0,0,0.08);
        }

        h1 {
            color: #1e293b;
            margin-bottom: 22px;
        }

        .button {
            display: inline-block;
            padding: 10px 18px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 8px;
            border: none;
            font: inherit;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .button:hover {
            background: #7c3aed;
            transform: translateY(-4px);
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
        }

        .delete {
            background: #dc2626;
        }

        .delete:hover {
            background: #991b1b;
            transform: translateY(-4px);
        }

        .actions {
            display: flex;
            gap: 8px;
            align-items: center;
        }

        .actions form {
            margin: 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            padding: 13px;
            border: 1px solid #ddd;
            text-align: left;
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

        .success {
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            margin-bottom: 15px;
            border-radius: 8px;
            animation: fadeIn 0.5s ease;
        }

        .back-button {
            display: inline-block;
            margin-bottom: 20px;
            color: #2563eb;
            text-decoration: none;
            font-weight: bold;
        }

        .back-button:hover {
            color: #7c3aed;
        }

        .stock {
            font-weight: bold;
            color: #15803d;
        }

        @media (max-width: 600px) {
            body {
                margin: 10px;
            }

            .container {
                padding: 15px;
            }
        }
    </style>
</head>

<body>

    <div class="container">

        <a href="{{ route('dashboard') }}" class="back-button">
            ← Back to Dashboard
        </a>

        <h1>Products</h1>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        {{-- Admin Only: Add Product Button --}}
        @if (auth()->user()->role === 'admin')
            <a href="{{ route('products.create') }}" class="button">
                + Add Product
            </a>
        @endif

        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Product Name</th>
                    <th>Brand</th>
                    <th>Price (LKR)</th>
                    <th>Quantity</th>
                    <th>Description</th>

                    @if (auth()->user()->role === 'admin')
                        <th>Actions</th>
                    @endif
                </tr>
            </thead>

            <tbody>
                @forelse ($products as $product)
                    <tr>
                        <td>{{ $product->id }}</td>

                        <td>{{ $product->product_name }}</td>

                        <td>{{ $product->brand }}</td>

                        <td>{{ number_format($product->price, 2) }}</td>

                        <td class="stock">
                            {{ $product->quantity }}
                        </td>

                        <td>{{ $product->description ?? '-' }}</td>

                        {{-- Admin Only: Edit and Delete --}}
                        @if (auth()->user()->role === 'admin')
                            <td>
                                <div class="actions">

                                    <a href="{{ route('products.edit', $product) }}"
                                       class="button">
                                        Edit
                                    </a>

                                    <form
                                        action="{{ route('products.destroy', $product) }}"
                                        method="POST"
                                        onsubmit="return confirm('Delete this product?');"
                                    >
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        @endif

                    </tr>

                @empty
                    <tr>
                        <td colspan="{{ auth()->user()->role === 'admin' ? 7 : 6 }}">
                            No products added yet.
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>

</body>
</html>
