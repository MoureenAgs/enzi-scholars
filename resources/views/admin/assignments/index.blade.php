<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Reviewer Assignments</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Applicant</th>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th>Assigned Reviewers</th>
                    <th style="width: 280px;">Assign New Reviewer</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
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
                        <td>
                            @forelse ($application->reviewerAssignments as $assignment)
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span>{{ $assignment->reviewer->name }}</span>
                                    <form action="{{ route('assignments.destroy', $assignment) }}" method="POST"
                                          onsubmit="return confirm('Remove this reviewer from this application?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-danger btn-sm">Remove</button>
                                    </form>
                                </div>
                            @empty
                                <span class="text-muted">None assigned yet</span>
                            @endforelse
                        </td>
                        <td>
                            <form action="{{ route('assignments.store') }}" method="POST" class="d-flex gap-1">
                                @csrf
                                <input type="hidden" name="application_id" value="{{ $application->id }}">
                                <select name="reviewer_id" class="form-select form-select-sm" required>
                                    <option value="">-- Select Reviewer --</option>
                                    @foreach ($reviewers as $reviewer)
                                        <option value="{{ $reviewer->id }}">{{ $reviewer->name }}</option>
                                    @endforeach
                                </select>
                                <button type="submit" class="btn btn-primary btn-sm">Assign</button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="text-center">No applications submitted yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>