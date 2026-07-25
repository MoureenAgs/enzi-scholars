<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Create Staff Account</h2>
    </x-slot>

    <div class="container py-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('users.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Full Name</label>
                <input type="text" name="name" value="{{ old('name') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Email Address</label>
                <input type="email" name="email" value="{{ old('email') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Role</label>
                <select name="role" class="form-select" required>
                    <option value="">-- Select Role --</option>
                    <option value="admin" {{ old('role') === 'admin' ? 'selected' : '' }}>Administrator</option>
                    <option value="reviewer" {{ old('role') === 'reviewer' ? 'selected' : '' }}>Reviewer</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Temporary Password</label>
                <input type="password" name="password" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Confirm Password</label>
                <input type="password" name="password_confirmation" class="form-control" required>
            </div>

            <button type="submit" class="btn btn-primary">Create Account</button>
            <a href="{{ route('users.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
</x-app-layout>