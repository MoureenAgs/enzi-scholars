<x-app-layout>
    <x-slot name="header">
        <div class="d-flex justify-content-between align-items-center">
            <h2 class="fw-bold fs-4">Manage Scholarships</h2>
            <a href="{{ route('scholarships.create') }}" class="btn btn-primary btn-sm">
                + New Scholarship
            </a>
        </div>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">
                {{ session('success') }}
            </div>
        @endif

        <form method="GET" action="{{ route('scholarships.index') }}" class="row g-2 mb-3">
            <div class="col-md-6">
                <input type="text" name="search" value="{{ request('search') }}"
                       class="form-control" placeholder="Search by title...">
            </div>
            <div class="col-md-3">
                <select name="status" class="form-select">
                    <option value="">All Statuses</option>
                    <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="open" {{ request('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ request('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-secondary w-100">Filter</button>
            </div>
        </form>

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Title</th>
                    <th>Deadline</th>
                    <th>Status</th>
                    <th>Created By</th>
                    <th style="width: 260px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($scholarships as $scholarship)
                    <tr>
                        <td>{{ $scholarship->title }}</td>
                        <td>{{ $scholarship->application_deadline->format('d M Y') }}</td>
                        <td>
                            <span class="badge bg-{{ $scholarship->status === 'open' ? 'success' : ($scholarship->status === 'closed' ? 'secondary' : 'warning') }}">
                                {{ ucfirst($scholarship->status) }}
                            </span>
                        </td>
                        <td>{{ $scholarship->creator->name }}</td>
                        <td>
                            <a href="{{ route('scholarships.show', $scholarship) }}" class="btn btn-info btn-sm">View</a>
                            <a href="{{ route('scholarships.edit', $scholarship) }}" class="btn btn-warning btn-sm">Edit</a>
                            <a href="{{ route('criteria.index', $scholarship) }}" class="btn btn-primary btn-sm">Criteria</a>
                            <form action="{{ route('scholarships.destroy', $scholarship) }}" method="POST" class="d-inline"
                                  onsubmit="return confirm('Are you sure you want to delete this scholarship?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No scholarships found matching your criteria.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $scholarships->links() }}

    </div>
</x-app-layout>