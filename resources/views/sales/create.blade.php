<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Sale</title>
</head>
<body>
    <h1>Add Sale</h1>

    <a href="{{ route('sales.index') }}">Back to Sales</a>

    @if ($errors->any())
        <ul style="color: red;">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    <form action="{{ route('sales.store') }}" method="POST">
        @csrf

        <p>
            <label for="customer_id">Customer</label><br>
            <select id="customer_id" name="customer_id" required>
                <option value="">Select Customer</option>

                @foreach ($customers as $customer)
                    <option
                        value="{{ $customer->id }}"
                        @selected(old('customer_id') == $customer->id)
                    >
                        {{ $customer->customer_name }}
                    </option>
                @endforeach
            </select>
        </p>

        <p>
            <label for="product_id">Product</label><br>
            <select id="product_id" name="product_id" required>
                <option value="">Select Product</option>

                @foreach ($products as $product)
                    <option
                        value="{{ $product->id }}"
                        data-price="{{ $product->price }}"
                        data-stock="{{ $product->quantity }}"
                        @selected(old('product_id') == $product->id)
                        @disabled($product->quantity < 1)
                    >
                        {{ $product->product_name }}
                        — {{ $product->brand }}
                        (Stock: {{ $product->quantity }})
                    </option>
                @endforeach
            </select>
        </p>

        <p id="stock_info"></p>

        <p>
            <label for="quantity">Quantity</label><br>
            <input
                type="number"
                id="quantity"
                name="quantity"
                value="{{ old('quantity', 1) }}"
                min="1"
                step="1"
                required
            >
        </p>

        <p>
            <label for="total_price">Total Price (LKR)</label><br>
            <input
                type="text"
                id="total_price"
                value=""
                readonly
            >
        </p>

        <p>
            <label for="sale_date">Sale Date</label><br>
            <input
                type="date"
                id="sale_date"
                name="sale_date"
                value="{{ old('sale_date', date('Y-m-d')) }}"
                required
            >
        </p>

        <button type="submit">Save Sale</button>
    </form>

    <script>
        const productSelect = document.getElementById('product_id');
        const quantityInput = document.getElementById('quantity');
        const totalInput = document.getElementById('total_price');
        const stockInfo = document.getElementById('stock_info');

        function updateTotal() {
            const selected = productSelect.selectedOptions[0];

            if (!productSelect.value) {
                totalInput.value = '';
                stockInfo.textContent = '';
                quantityInput.removeAttribute('max');
                return;
            }

            const price = Number(selected.dataset.price);
            const stock = Number(selected.dataset.stock);
            const quantity = Number(quantityInput.value);

            quantityInput.max = stock;
            stockInfo.textContent = 'Available stock: ' + stock;

            totalInput.value =
                Number.isInteger(quantity) && quantity > 0
                    ? (price * quantity).toFixed(2)
                    : '';
        }

        productSelect.addEventListener('change', updateTotal);
        quantityInput.addEventListener('input', updateTotal);

        updateTotal();
    </script>
</body>
</html>