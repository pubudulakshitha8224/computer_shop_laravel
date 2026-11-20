
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Computer Shop</title>
</head>
<body>

    <h1>Welcome to Our Computer Shop</h1>

    <p>Find the best computers and accessories at affordable prices.</p>

    @if(session('success'))
        <div style="color: green; margin: 15px 0;">
            <strong>{{ session('success') }}</strong>
        </div>
    @endif

    @if(session('error'))
        <div style="color: red; margin: 15px 0;">
            <strong>{{ session('error') }}</strong>
        </div>
    @endif

    <a href="{{ route('customer.products') }}">
        View Products
    </a>

</body>
</html>
