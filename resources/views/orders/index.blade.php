<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Orders List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Orders List</h1>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="mb-3">
        <form action="{{ route('orders.index') }}" method="GET" class="d-flex align-items-end gap-2">
            <div class="form-group">
                <label for="status_id" class="form-label">Filter by Status</label>
                <select class="form-control" id="status_id" name="status_id">
                    <option value="">All Statuses</option>
                    @foreach ($statuses as $status)
                        <option value="{{ $status->getId() }}" {{ $statusId == $status->getId() ? 'selected' : '' }}>
                            {{ $status->getName() }}
                        </option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="btn btn-primary">Filter</button>
            <a href="{{ route('orders.index') }}" class="btn btn-secondary">Reset</a>
        </form>
    </div>

    <a href="{{ route('orders.create') }}" class="btn btn-primary mb-3">Add New Order</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>Unique Identifier</th>
            <th>Customer Email</th>
            <th>Status</th>
            <th>Total Amount</th>
            <th>Total Products</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($orders as $order)
            <tr>
                <td>{{ $order->id }}</td>
                <td>{{ $order->uniqueIdentifier }}</td>
                <td>{{ $order->customerEmail }}</td>
                <td>{{ $order->statusName }}</td>
                <td>{{ $order->totalAmount }}</td>
                <td>{{ $order->totalProducts }}</td>
                <td>
                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-info btn-sm">View</a>
                    <a href="{{ route('orders.edit', $order->id) }}" class="btn btn-warning btn-sm">Edit</a>
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="7">No orders found.</td>
            </tr>
        @endforelse
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
