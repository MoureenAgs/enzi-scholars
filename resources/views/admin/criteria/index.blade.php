<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Evaluation Criteria — {{ $scholarship->title }}</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="alert {{ $totalWeight === 100 ? 'alert-success' : 'alert-warning' }}">
            Total weight assigned: <strong>{{ $totalWeight }}%</strong>
            @if ($totalWeight !== 100)
                — weights should sum to 100% for accurate scoring.
            @else
                — weights are correctly balanced.
            @endif
        </div>

        <table class="table table-bordered mb-4">
            <thead class="table-dark">
                <tr>
                    <th>Criterion Name</th>
                    <th>Weight (%)</th>
                    <th style="width: 100px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($criteria as $criterion)
                    <tr>
                        <td>{{ $criterion->name }}</td>
                        <td>{{ $criterion->weight }}%</td>
                        <td>
                            <form action="{{ route('criteria.destroy', [$scholarship, $criterion]) }}" method="POST"
                                  onsubmit="return confirm('Remove this criterion?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No criteria defined yet. Add one below.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <h5>Add New Criterion</h5>
        <form action="{{ route('criteria.store', $scholarship) }}" method="POST" class="row g-2 align-items-end">
            @csrf
            <div class="col-md-6">
                <label class="form-label">Criterion Name</label>
                <input type="text" name="name" class="form-control" placeholder="e.g. Academic Merit" required>
            </div>
            <div class="col-md-3">
                <label class="form-label">Weight (%)</label>
                <input type="number" name="weight" class="form-control" min="1" max="100" required>
            </div>
            <div class="col-md-3">
                <button type="submit" class="btn btn-primary">Add Criterion</button>
            </div>
        </form>

        <a href="{{ route('scholarships.index') }}" class="btn btn-secondary mt-4">Back to Scholarships</a>

    </div>
</x-app-layout>