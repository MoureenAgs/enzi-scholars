<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Applicant Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-success">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Applicant</strong>.
        </div>

        @unless ($hasProfile)
            <div class="alert alert-warning">
                You haven't completed your profile yet.
                <a href="{{ route('applicant.profile.edit') }}">Complete it now</a> to strengthen your applications.
            </div>
        @endunless

        <h5>My Applications</h5>
        <table class="table table-bordered table-striped mb-4">
            <thead class="table-dark">
                <tr>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th>Submitted</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
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
                        <td colspan="3" class="text-center">You haven't applied to any scholarships yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</x-app-layout>