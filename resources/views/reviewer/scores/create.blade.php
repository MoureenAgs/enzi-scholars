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

        <div class="card mb-4">
            <div class="card-body">
                <h6 class="fw-bold mb-3" style="color: #2C7A78;">Submitted Documents</h6>

                @php
                    $docLabels = [
                        'application_form' => 'Application Form',
                        'birth_certificate' => 'Birth Certificate',
                        'acceptance_letter' => 'Letter of Acceptance',
                        'recommendation_letter' => 'Recommendation Letter',
                        'passport_photo' => 'Passport Photo',
                    ];
                @endphp

                @if ($application->documents->isEmpty())
                    <p class="text-muted mb-0">No documents were uploaded with this application.</p>
                @else
                    <div class="row g-2">
                        @foreach ($application->documents as $document)
                            <div class="col-md-6">
                                <div class="d-flex justify-content-between align-items-center border rounded p-2">
                                    <div>
                                        <div class="fw-semibold small">{{ $docLabels[$document->document_type] ?? ucfirst(str_replace('_', ' ', $document->document_type)) }}</div>
                                        <div class="text-muted" style="font-size: 0.75rem;">{{ $document->original_filename }}</div>
                                    </div>
                                    <a href="{{ route('documents.download', $document) }}" target="_blank" class="btn btn-outline-dark btn-sm">
                                        View
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
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