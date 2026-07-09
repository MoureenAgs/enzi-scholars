<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">My Applications</h2>
    </x-slot>

    <div class="container py-4">

        <table class="table table-striped table-bordered">
            <thead class="table-dark">
                <tr>
                    <th>Scholarship</th>
                    <th>Submitted On</th>
                    <th>Status</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($applications as $application)
                    <tr>
                        <td>{{ $application->scholarship->title }}</td>
                        <td>{{ $application->submitted_at->format('d M Y, h:i A') }}</td>
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
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">You haven't submitted any applications yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>