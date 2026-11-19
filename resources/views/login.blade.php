
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Computer Shop</title>

    <style>
        * {
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            background: #eef2f7;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            margin: 0;
        }

        .login-box {
            background: white;
            width: 380px;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2 {
            text-align: center;
            color: #1e293b;
            margin-bottom: 8px;
        }

        .subtitle {
            text-align: center;
            color: #64748b;
            margin-bottom: 25px;
        }

        label {
            display: block;
            margin: 15px 0 7px;
            font-weight: bold;
        }

        input {
            width: 100%;
            padding: 12px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        button {
            width: 100%;
            padding: 12px;
            margin-top: 22px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: 0.3s;
        }

        button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .error {
            color: #dc2626;
            font-size: 14px;
            margin-top: 5px;
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Computer Shop</h2>
    <p class="subtitle">Management System Login</p>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <label>Email Address</label>
        <input type="email" name="email"
               value="{{ old('email') }}"
               placeholder="Enter your email">

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label>Password</label>
        <input type="password" name="password"
               placeholder="Enter your password">

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit">Login</button>
    </form>

</div>

</body>
</html>
