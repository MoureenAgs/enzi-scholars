<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">My Assigned Applications</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Applicant</th>
                    <th>Scholarship</th>
                    <th>Status</th>
                    <th style="width: 150px;">Action</th>
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
                        <td>
                            <a href="{{ route('reviewer.scores.create', $assignment->application) }}" class="btn btn-primary btn-sm">
                                Score Application
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No applications assigned to you yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>