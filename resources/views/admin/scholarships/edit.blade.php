<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Edit Scholarship</h2>
    </x-slot>

    <div class="container py-4">

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('scholarships.update', $scholarship) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title', $scholarship->title) }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description', $scholarship->description) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Eligibility Criteria</label>
                <textarea name="eligibility_criteria" class="form-control" rows="3">{{ old('eligibility_criteria', $scholarship->eligibility_criteria) }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Deadline</label>
                <input type="date" name="application_deadline"
                       value="{{ old('application_deadline', $scholarship->application_deadline->format('Y-m-d')) }}"
                       class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status', $scholarship->status) === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="open" {{ old('status', $scholarship->status) === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status', $scholarship->status) === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Form Template</label>

                @if ($scholarship->application_form_path)
                    <div class="mb-2">
                        <a href="{{ route('scholarships.downloadForm', $scholarship) }}" class="btn btn-outline-secondary btn-sm">
                            📄 Download Current Form
                        </a>
                    </div>
                @else
                    <div class="text-muted small mb-2">No application form uploaded yet.</div>
                @endif

                <input type="file" name="application_form" class="form-control" accept=".pdf,.doc,.docx">
                <small class="text-muted">Upload a new file to replace the current one. Leave blank to keep the existing form. Max 5MB.</small>
            </div>

            <button type="submit" class="btn btn-primary">Update Scholarship</button>
            <a href="{{ route('scholarships.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
</x-app-layout>