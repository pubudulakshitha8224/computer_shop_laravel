
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers - Computer Shop</title>

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
            padding: 25px;
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
            color: white;
            background: #2563eb;
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

        .success {
            margin: 15px 0;
            padding: 12px;
            background: #dcfce7;
            color: #166534;
            border-radius: 8px;
            animation: fadeIn 0.5s ease;
        }

        .table-wrapper {
            overflow-x: auto;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 25px;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 13px;
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

        <h1>Customers</h1>

        <a href="{{ route('customers.create') }}" class="button">
            + Add Customer
        </a>

        @if (session('success'))
            <div class="success">
                {{ session('success') }}
            </div>
        @endif

        <div class="table-wrapper">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Customer Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Address</th>
                        <th>Actions</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($customers as $customer)
                        <tr>
                            <td>{{ $customer->id }}</td>
                            <td>{{ $customer->customer_name }}</td>
                            <td>{{ $customer->phone }}</td>
                            <td>{{ $customer->email ?? '-' }}</td>
                            <td>{{ $customer->address ?? '-' }}</td>

                            <td>
                                <div class="actions">

                                    <a href="{{ route('customers.edit', $customer) }}"
                                       class="button">
                                        Edit
                                    </a>

                                    <form action="{{ route('customers.destroy', $customer) }}"
                                          method="POST"
                                          onsubmit="return confirm('Are you sure you want to delete this customer?');">

                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="button delete">
                                            Delete
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>

                    @empty
                        <tr>
                            <td colspan="6">No customers found.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

    </div>

</body>
</html>
