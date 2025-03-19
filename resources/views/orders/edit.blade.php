<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Edit Order</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.update', $order->getId()) }}" method="POST">
        @csrf
        @method('PUT')
        <div class="mb-3">
            <label for="username" class="form-label">Customer Username</label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                <option value="{{ $customer->getId() }}">
                    {{ $customer->getEmail() }} ({{ $customer->getFirstName() }} {{ $customer->getLastName() }})
                </option>
            </select>
        </div>
        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select class="form-control" id="status_id" name="status_id" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status->getId() }}" {{$order->getStatusId() == $status->getId() ? "selected": ""}}>
                        {{ $status->getName() }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="total_amount" class="form-label">Total Amount</label>
            <input type="number" step="0.01" class="form-control" id="total_amount" name="total_amount" value="{{ old('total_amount', $order->getTotalAmount()) }}" required>
        </div>
        <div class="mb-3">
            <label for="total_products" class="form-label">Total Products</label>
            <input type="number" class="form-control" id="total_products" name="total_products" value="{{ old('total_products', $order->getTotalProducts()) }}" required>
        </div>
        <button type="submit" class="btn btn-primary">Update Order</button>
        <a href="{{ route('orders.show', $order->getId()) }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
