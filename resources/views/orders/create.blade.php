<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Order</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Create New Order</h1>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="username" class="form-label">Customer Username</label>
            <select class="form-control" id="customer_id" name="customer_id" required>
                <option value="">Select Username</option>
                @foreach ($customers as $customer)
                    <option value="{{ $customer->getId() }}" {{ (!is_null($preselectedCustomerId) && $preselectedCustomerId == $customer->getId()) ? 'selected' : '' }}>
                        {{ $customer->getEmail() }} ({{ $customer->getFirstName() }} {{ $customer->getLastName() }})
                    </option>
                @endforeach
            </select>
        </div>
        <div class="mb-3">
            <label for="status_id" class="form-label">Status</label>
            <select class="form-control" id="status_id" name="status_id" required>
                @foreach ($statuses as $status)
                    <option value="{{ $status->getId() }}">
                        {{ $status->getName() }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Create Order</button>
        <a href="{{ route('orders.index') }}" class="btn btn-secondary">Cancel</a>
    </form>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
