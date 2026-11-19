
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
            max-width: 92%;
            padding: 35px;
            border-radius: 12px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
        }

        h2, p {
            text-align: center;
        }

        h2 {
            color: #1e293b;
        }

        p {
            color: #64748b;
            margin-bottom: 25px;
        }

        .role-title {
            font-weight: bold;
            margin-bottom: 10px;
            display: block;
        }

        .role-options {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
        }

        .role-options input {
            display: none;
        }

        .role-options label {
            flex: 1;
            text-align: center;
            padding: 11px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            cursor: pointer;
            color: #475569;
            transition: all 0.3s ease;
        }

        .role-options label:hover {
            border-color: #2563eb;
            transform: translateY(-2px);
        }

        .role-options input:checked + label {
            background: #2563eb;
            color: white;
            border-color: #2563eb;
        }

        .role-options input:checked + label.staff {
            background: #16a34a;
            border-color: #16a34a;
        }

        .field-label {
            display: block;
            margin-bottom: 7px;
            font-weight: bold;
        }

        .login-box input[type="email"],
        .login-box input[type="password"] {
            width: 100%;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
        }

        .login-button {
            width: 100%;
            padding: 12px;
            background: #2563eb;
            color: white;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
            transition: all 0.3s ease;
        }

        .login-button:hover {
            background: #1d4ed8;
            transform: translateY(-2px);
        }

        .error {
            color: red;
            font-size: 13px;
            margin-top: -10px;
            margin-bottom: 12px;
        }

        @media (max-width: 400px) {
            .login-box {
                padding: 25px;
            }
        }
    </style>
</head>

<body>

<div class="login-box">

    <h2>Computer Shop</h2>
    <p>Management System Login</p>

    <form action="{{ route('login') }}" method="POST">
        @csrf

        <span class="role-title">Login As</span>

        <div class="role-options">

            <input
                type="radio"
                name="role"
                id="admin"
                value="admin"
                {{ old('role', 'admin') === 'admin' ? 'checked' : '' }}
                required
            >

            <label for="admin">
                Admin
            </label>

            <input
                type="radio"
                name="role"
                id="staff"
                value="staff"
                {{ old('role') === 'staff' ? 'checked' : '' }}
                required
            >

            <label for="staff" class="staff">
                Staff
            </label>

        </div>

        <label class="field-label">Email Address</label>

        <input
            type="email"
            name="email"
            placeholder="Enter your email"
            value="{{ old('email') }}"
            required
        >

        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <label class="field-label">Password</label>

        <input
            type="password"
            name="password"
            placeholder="Enter your password"
            required
        >

        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <button type="submit" class="login-button">
            Login
        </button>

    </form>

</div>

</body>
</html>
