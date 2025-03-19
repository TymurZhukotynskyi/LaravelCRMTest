<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
<div class="container mt-5">
    <h1>Customers List</h1>

    @if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
    @endif

    <a href="{{ route('customers.create') }}" class="btn btn-primary mb-3">Add New Customer</a>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>ID</th>
            <th>First Name</th>
            <th>Last Name</th>
            <th>Email</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        @forelse ($customers as $customer)
        <tr>
            <td>{{ $customer->getId() }}</td>
            <td>{{ $customer->getFirstName() }}</td>
            <td>{{ $customer->getLastName() }}</td>
            <td>{{ $customer->getEmail() }}</td>
            <td>
                <a href="{{ route('customers.show', $customer->getId()) }}" class="btn btn-info btn-sm">View</a>
                <a href="{{ route('customers.edit', $customer->getId()) }}" class="btn btn-warning btn-sm">Edit</a>
                <form action="{{ route('customers.destroy', $customer->getId()) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm('Are you sure?')">Delete</button>
                </form>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="5">No customers found.</td>
        </tr>
        @endforelse
        </tbody>
    </table>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
