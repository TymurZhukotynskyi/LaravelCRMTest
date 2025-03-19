<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Customer Details</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $customer->getId() }}</p>
            <p><strong>First Name:</strong> {{ $customer->getFirstName() }}</p>
            <p><strong>Last Name:</strong> {{ $customer->getLastName() }}</p>
            <p><strong>Username:</strong> {{ $customer->getUsername() ?: 'N/A' }}</p>
            <p><strong>Email:</strong> {{ $customer->getEmail() }}</p>
            <p><strong>Age:</strong> {{ $customer->getAge() ?? 'N/A' }}</p>
            <p><strong>Phone:</strong> {{ $customer->getPhone() ?? 'N/A' }}</p>
            <p><strong>Birth Date:</strong> {{ $customer->getBirthDate() ?? 'N/A' }}</p>
        </div>
    </div>
    <hr>
    <h2>Orders</h2>
    <div class="card">
        <div class="card-body">
            <a href="{{ route('orders.create', ['customer_id' => $customer->getId()]) }}" class="btn btn-primary mb-3">Add New Order</a>
            <table class="table table-striped">
                <thead>
                <tr>
                    <th>ID</th>
                    <th>Unique Identifier</th>
                    <th>Status ID</th>
                    <th>Total Amount</th>
                    <th>Total Products</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                @forelse ($orders as $order)
                    <tr>
                        <td>{{ $order->getId() }}</td>
                        <td>{{ $order->getUniqueIdentifier() }}</td>
                        <td>{{ $order->getStatusId() }}</td>
                        <td>{{ $order->getTotalAmount() }}</td>
                        <td>{{ $order->getTotalProducts() }}</td>
                        <td>
                            <a href="{{ route('orders.show', $order->getId()) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('orders.edit', $order->getId()) }}" class="btn btn-warning btn-sm">Edit</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6">No orders found for this customer.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <a href="{{ route('customers.edit', $customer->getId()) }}" class="btn btn-warning mt-3">Edit</a>
    <a href="{{ route('customers.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
