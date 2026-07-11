<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Administrator Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-primary">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Administrator</strong>.
        </div>

        <div class="row mb-4">
            <div class="col-md-3 mb-3">
                <div class="card text-center border-primary">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $stats['total_scholarships'] }}</h3>
                        <small class="text-muted">Total Scholarships</small>
                        <div class="text-success small">{{ $stats['open_scholarships'] }} open</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center border-info">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $stats['total_applications'] }}</h3>
                        <small class="text-muted">Total Applications</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center border-warning">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $stats['pending_review'] + $stats['under_review'] }}</h3>
                        <small class="text-muted">Awaiting Decision</small>
                        <div class="text-muted small">{{ $stats['pending_review'] }} unassigned, {{ $stats['under_review'] }} in review</div>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-3">
                <div class="card text-center border-success">
                    <div class="card-body">
                        <h3 class="mb-0">{{ $stats['approved'] }} / {{ $stats['rejected'] }}</h3>
                        <small class="text-muted">Approved / Rejected</small>
                    </div>
                </div>
            </div>
        </div>

        <h5>Recent Applications</h5>
        <table class="table table-bordered table-striped mb-4">
            <thead class="table-dark">
                <tr>
                    <th>Applicant</th>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($recentApplications as $application)
                    <tr>
                        <td>{{ $application->applicant->name }}</td>
                        <td>{{ $application->scholarship->title }}</td>
                        <td>
                            <span class="badge bg-{{ match($application->status) {
                                'submitted' => 'primary',
                                'under_review' => 'warning',
                                'approved' => 'success',
                                'rejected' => 'danger',
                            } }}">
                                {{ ucfirst(str_replace('_', ' ', $application->status)) }}
                            </span>
                        </td>
                        <td>{{ $application->submitted_at->diffForHumans() }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>