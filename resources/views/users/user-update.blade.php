<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css">
</head>
<body>
<div class="container mt-4">
    <h1>Edit User</h1>
    <a href="{{ route('users.index') }}">Back</a>
    <form method="POST" action="{{ route('update.user', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="mobile">Mobile:</label>
            <input type="text" name="mobile" id="mobile" value="{{ $user->mobile }}" class="form-control">
        </div>

        <div class="form-group">
            <label for="password">Password:</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="form-group">
            <label for="gender">Gender:</label>
            <select name="gender" id="gender" class="form-control">
                <option value="Male" {{ $user->gender === 'Male' ? 'selected' : '' }}>Male</option>
                <option value="Female" {{ $user->gender === 'Female' ? 'selected' : '' }}>Female</option>
            </select>
        </div>

        <div class="form-group">
            <label for="status">Status:</label>
            <select name="status" id="status" class="form-control">
                <option value="{{\App\Constants\AppConstants::USER_ACTIVE}}" {{ $user->status === \App\Constants\AppConstants::USER_ACTIVE ? 'selected' : '' }}>Active</option>
                <option value="{{\App\Constants\AppConstants::USER_INACTIVE}}" {{ $user->status === \App\Constants\AppConstants::USER_INACTIVE ? 'selected' : '' }}>Inactive</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Update</button>
    </form>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js"></script>
</body>
</html>
