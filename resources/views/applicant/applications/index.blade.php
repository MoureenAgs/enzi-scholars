<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Available Scholarships</h2>
    </x-slot>

    <div class="container py-4">

        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if (session('error'))
            <div class="alert alert-danger">{{ session('error') }}</div>
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

        @forelse ($openScholarships as $scholarship)
            <div class="card mb-3">
                <div class="card-body">
                    <h5 class="card-title">{{ $scholarship->title }}</h5>
                    <p class="card-text">{{ Str::limit($scholarship->description, 150) }}</p>
                    <p class="text-muted mb-2">
                        <strong>Deadline:</strong> {{ $scholarship->application_deadline->format('d M Y') }}
                    </p>

                    @if (in_array($scholarship->id, $appliedScholarshipIds))
                        <span class="badge bg-secondary">Already Applied</span>
                    @else
                        <form action="{{ route('applicant.applications.store') }}" method="POST" enctype="multipart/form-data" class="row g-2 align-items-center">
                            @csrf
                            <input type="hidden" name="scholarship_id" value="{{ $scholarship->id }}">

                            <div class="col-auto">
                                <input type="file" name="document" class="form-control form-control-sm" required>
                            </div>
                            <div class="col-auto">
                                <button type="submit" class="btn btn-primary btn-sm">Apply Now</button>
                            </div>
                        </form>
                        <small class="text-muted">Upload a supporting document (PDF, JPG, or PNG — max 5MB)</small>
                    @endif
                </div>
            </div>
        @empty
            <p class="text-muted">No open scholarships available at this time. Check back later.</p>
        @endforelse

    </div>
</x-app-layout>