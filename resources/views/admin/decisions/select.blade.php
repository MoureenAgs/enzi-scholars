<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Applicant Rankings & Decisions</h2>
    </x-slot>

    <div class="container py-4">

        <table class="table table-bordered table-striped">
            <thead class="table-dark">
                <tr>
                    <th>Scholarship</th>
                    <th>Total Applications</th>
                    <th style="width: 150px;">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($scholarships as $scholarship)
                    <tr>
                        <td>{{ $scholarship->title }}</td>
                        <td>{{ $scholarship->applications_count }}</td>
                        <td>
                            <a href="{{ route('decisions.index', $scholarship) }}" class="btn btn-primary btn-sm">
                                View Rankings
                            </a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-center">No scholarships found.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>

    </div>
</x-app-layout>