<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Create New Scholarship</h2>
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

        <form action="{{ route('scholarships.store') }}" method="POST">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title</label>
                <input type="text" name="title" value="{{ old('title') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4" required>{{ old('description') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Eligibility Criteria</label>
                <textarea name="eligibility_criteria" class="form-control" rows="3">{{ old('eligibility_criteria') }}</textarea>
            </div>

            <div class="mb-3">
                <label class="form-label">Application Deadline</label>
                <input type="date" name="application_deadline" value="{{ old('application_deadline') }}" class="form-control" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Status</label>
                <select name="status" class="form-select" required>
                    <option value="draft" {{ old('status') === 'draft' ? 'selected' : '' }}>Draft</option>
                    <option value="open" {{ old('status') === 'open' ? 'selected' : '' }}>Open</option>
                    <option value="closed" {{ old('status') === 'closed' ? 'selected' : '' }}>Closed</option>
                </select>
            </div>

            <button type="submit" class="btn btn-primary">Create Scholarship</button>
            <a href="{{ route('scholarships.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
</x-app-layout>