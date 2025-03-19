<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Order Details</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card mb-4">
        <div class="card-body">
            <p><strong>ID:</strong> {{ $orderDetails->id }}</p>
            <p><strong>Unique Identifier:</strong> {{ $orderDetails->uniqueIdentifier }}</p>
            <p><strong>Customer Email:</strong> {{ $orderDetails->customerEmail }}</p>
            <p><strong>Status:</strong> {{ $orderDetails->statusName }}</p>
            <p><strong>Total Amount:</strong> {{ $orderDetails->totalAmount }}</p>
            <p><strong>Total Products:</strong> {{ $orderDetails->totalProducts }}</p>
        </div>
    </div>

    <h2>Products</h2>
    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($orderDetails->products as $product)
            <tr>
                <td>{{ $product->getId() }}</td>
                <td>{{ $product->getName() }}</td>
                <td>{{ $product->getPrice() }}</td>
                <td>{{ $product->getQuantity() }}</td>
                <td>{{ $product->getPrice() * $product->getQuantity() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">No products found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>

    <a href="{{ route('orders.edit', $orderDetails->id) }}" class="btn btn-warning mt-3">Edit</a>
    <a href="{{ route('orders.index') }}" class="btn btn-secondary mt-3">Back to List</a>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
