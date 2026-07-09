<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Rankings — {{ $scholarship->title }}</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Rank</th>
                    <th>Applicant</th>
                    <th>Total Score</th>
                    <th>Current Status</th>
                    <th style="width: 320px;">Decision</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $application->rank ?? '—' }}</td>
                        <td>{{ $application->applicant->name }}</td>
                        <td>{{ $application->total_score ?? 'Not yet scored' }}</td>
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
                        <td>
                            <form action="{{ route('decisions.store', $application) }}" method="POST" class="d-flex gap-2">
                                @csrf
                                <select name="decision" class="form-select form-select-sm" required>
                                    <option value="">-- Select --</option>
                                    <option value="approved" {{ optional($application->decision)->decision === 'approved' ? 'selected' : '' }}>Approve</option>
                                    <option value="rejected" {{ optional($application->decision)->decision === 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Submit</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No applications for this scholarship yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        <a href="{{ route('decisions.select') }}" class="btn btn-secondary">Back to Scholarships</a>

    </div>
</x-app-layout>