<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Reviewer Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-info">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Reviewer</strong>.
        </div>

        <div class="row mb-4">
            <div class="col-md-4 mb-3">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $totalAssigned }}</h3>
                        <small class="text-muted">Total Assigned</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $totalScored }}</h3>
                        <small class="text-muted">Scored</small>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-3">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $pending }}</h3>
                        <small class="text-muted">Pending</small>
                    </div>
                </div>
            </div>
        </div>

        <h5>My Assigned Applications</h5>
        <table class="table table-bordered table-striped mb-4">
            <thead class="table-dark">
                <tr>
                    <th>Applicant</th>
                    <th>Scholarship</th>
                    <th>Application Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($assignments as $assignment)
                    <tr>
                        <td>{{ $assignment->application->applicant->name }}</td>
                        <td>{{ $assignment->application->scholarship->title }}</td>
                        <td>
                            <span class="badge bg-{{ match($assignment->application->status) {
                                'submitted' => 'primary',
                                'under_review' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            } }}">
                                {{ ucfirst(str_replace('_', ' ', $assignment->application->status)) }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No applications assigned to you yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('reviewer.scores.index') }}" class="btn btn-primary mt-2">Go to Scoring Page</a>
    </div>
</x-app-layout>