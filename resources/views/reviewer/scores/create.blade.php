<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Score Application — {{ $application->applicant->name }}</h2>
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

        <div class="card mb-4">
            <div class="card-body">
                <p><strong>Scholarship:</strong> {{ $application->scholarship->title }}</p>
                <p><strong>Applicant:</strong> {{ $application->applicant->name }} ({{ $application->applicant->email }})</p>
            </div>
        </div>

        <form action="{{ route('reviewer.scores.store', $application) }}" method="POST">
            @csrf

            @foreach ($application->scholarship->evaluationCriteria as $criterion)
                <div class="mb-3">
                    <label class="form-label">
                        {{ $criterion->name }} <span class="text-muted">(Weight: {{ $criterion->weight }}%)</span>
                    </label>
                    <input type="number" name="scores[{{ $criterion->id }}]"
                           value="{{ old('scores.' . $criterion->id, $existingScores[$criterion->id] ?? '') }}"
                           class="form-control" min="0" max="100" step="0.01" required>
                    <small class="text-muted">Enter a score from 0 to 100 for this criterion.</small>
                </div>
            @endforeach

            <div class="mb-3">
                <label class="form-label">Comments (optional)</label>
                <textarea name="comment" class="form-control" rows="3">{{ old('comment') }}</textarea>
            </div>

            <button type="submit" class="btn btn-primary">Submit Scores</button>
            <a href="{{ route('reviewer.scores.index') }}" class="btn btn-secondary">Cancel</a>
        </form>

    </div>
</x-app-layout>