
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Our Products - Computer Shop</title>

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

        header h1 {
            margin-bottom: 8px;
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

        .container h2 {
            font-size: 28px;
            margin-bottom: 10px;
        }

        .search-form {
            display: flex;
            gap: 10px;
            margin-top: 25px;
            margin-bottom: 20px;
            flex-wrap: wrap;
        }

        .search-form input {
            flex: 1;
            min-width: 200px;
            padding: 13px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            font-size: 15px;
            outline: none;
        }

        .search-form input:focus {
            border-color: #2563eb;
        }

        .search-form button {
            padding: 13px 22px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 15px;
        }

        .search-form button:hover {
            background: #1d4ed8;
        }

        .clear-btn {
            padding: 13px 18px;
            background: #64748b;
            color: white;
            text-decoration: none;
            border-radius: 6px;
        }

        .clear-btn:hover {
            background: #475569;
        }

        .products {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(230px, 1fr));
            gap: 22px;
            margin-top: 25px;
        }

        .product-card {
            background: white;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.07);
            transition: 0.3s;
        }

        .product-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 22px rgba(0,0,0,0.12);
        }

        .product-card h3 {
            margin-bottom: 12px;
            color: #0f172a;
            font-size: 21px;
        }

        .brand {
            color: #64748b;
            margin-bottom: 12px;
        }

        .price {
            color: #2563eb;
            font-size: 21px;
            font-weight: bold;
            margin: 15px 0;
        }

        .stock-badge {
            display: inline-block;
            padding: 7px 13px;
            border-radius: 20px;
            font-size: 13px;
            font-weight: bold;
            margin: 10px 0;
        }

        .in-stock {
            background: #dcfce7;
            color: #166534;
        }

        .out-of-stock {
            background: #fee2e2;
            color: #991b1b;
        }

        .description {
            color: #475569;
            margin-top: 12px;
            line-height: 1.5;
        }

        .empty-message {
            background: white;
            padding: 25px;
            border-radius: 10px;
            color: #64748b;
            margin-top: 20px;
        }

        .back-btn {
            display: inline-block;
            margin-top: 30px;
            padding: 11px 20px;
            background: #2563eb;
            color: white;
            text-decoration: none;
            border-radius: 6px;
            transition: 0.3s;
        }

        .back-btn:hover {
            background: #1d4ed8;
        }

        footer {
            margin-top: 50px;
            background: #0f172a;
            color: white;
            text-align: center;
            padding: 22px;
        }

        @media (max-width: 600px) {
            .container {
                width: 90%;
            }

            header {
                padding: 22px 5%;
            }

            nav {
                padding: 15px 5%;
            }

            .search-form {
                flex-direction: column;
            }

            .search-form input,
            .search-form button,
            .search-form a {
                width: 100%;
                text-align: center;
            }
        }
    </style>
</head>

<body>

    <header>
        <h1>Computer Shop</h1>
        <p>Quality Computers & Accessories</p>
    </header>

    <nav>
        <a href="{{ route('shop.home') }}">Home</a>
        <a href="{{ route('customer.products') }}">Products</a>
    </nav>

    <div class="container">

        <h2>Our Products</h2>

        <p>Explore our available computers and accessories.</p>

        <!-- Product Search -->
        <form action="{{ route('customer.products') }}" method="GET" class="search-form">

            <input
                type="text"
                name="search"
                placeholder="Search product name or brand..."
                value="{{ request('search') }}"
            >

            <button type="submit">Search</button>

            <a href="{{ route('customer.products') }}" class="clear-btn">
                Clear
            </a>

        </form>

        @if(request('search'))
            <p>
                Search results for:
                <strong>{{ request('search') }}</strong>
            </p>
        @endif

        <!-- Product List -->
        <div class="products">

            @forelse($products as $product)

                <div class="product-card">

                    <h3>{{ $product->product_name }}</h3>

                    <p class="brand">
                        Brand: {{ $product->brand }}
                    </p>

                    <p class="price">
                        LKR {{ number_format($product->price, 2) }}
                    </p>

                    @if($product->quantity > 0)

                        <span class="stock-badge in-stock">
                            In Stock ({{ $product->quantity }})
                        </span>

                    @else

                        <span class="stock-badge out-of-stock">
                            Out of Stock
                        </span>

                    @endif

                    @if($product->description)

                        <p class="description">
                            {{ $product->description }}
                        </p>

                    @endif

                </div>

            @empty

                <p class="empty-message">
                    No products found. Please try another search.
                </p>

            @endforelse

        </div>

        <a href="{{ route('shop.home') }}" class="back-btn">
            Back to Home
        </a>

    </div>

    <footer>
        <p>&copy; 2026 Computer Shop. All Rights Reserved.</p>
    </footer>

</body>
</html>
