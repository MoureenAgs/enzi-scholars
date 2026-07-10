<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Activity / Audit Log</h2>
    </x-slot>

    <div class="container py-4">

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>User</th>
                    <th>Action</th>
                    <th>Subject</th>
                    <th>Date/Time</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($logs as $log)
                    <tr>
                        <td>{{ $log->user->name ?? 'System' }}</td>
                        <td>{{ ucfirst($log->action) }}</td>
                        <td>{{ $log->subject_type ? class_basename($log->subject_type) . ' #' . $log->subject_id : '—' }}</td>
                        <td>{{ $log->created_at->format('d M Y, h:i A') }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="text-center">No activity recorded yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

        {{ $logs->links() }}

    </div>
</x-app-layout>