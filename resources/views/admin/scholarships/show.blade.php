<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">{{ $scholarship->title }}</h2>
    </x-slot>

    <div class="container py-4">

        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Description</h5>
                <p>{{ $scholarship->description }}</p>

                <h5 class="card-title mt-4">Eligibility Criteria</h5>
                <p>{{ $scholarship->eligibility_criteria ?? 'Not specified.' }}</p>

                <hr>

                <p><strong>Deadline:</strong> {{ $scholarship->application_deadline->format('d M Y') }}</p>
                <p><strong>Status:</strong>
                    <span class="badge bg-{{ $scholarship->status === 'open' ? 'success' : ($scholarship->status === 'closed' ? 'secondary' : 'warning') }}">
                        {{ ucfirst($scholarship->status) }}
                    </span>
                </p>
                <p><strong>Created by:</strong> {{ $scholarship->creator->name }}</p>

                <h5 class="card-title mt-4">Evaluation Criteria</h5>
                @forelse ($scholarship->evaluationCriteria as $criteria)
                    <p>{{ $criteria->name }} — {{ $criteria->weight }}%</p>
                @empty
                    <p class="text-muted">No evaluation criteria set yet (this will be added in a later module).</p>
                @endforelse

                <a href="{{ route('scholarships.index') }}" class="btn btn-secondary mt-3">Back to List</a>
            </div>
        </div>

    </div>
</x-app-layout>