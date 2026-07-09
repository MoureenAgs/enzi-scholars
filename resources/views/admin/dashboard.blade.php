<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Administrator Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-primary">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Administrator</strong>.
        </div>
        <p>This is a placeholder. Scholarship management, applicant lists, and reports will appear here in later modules.</p>

        <a href="{{ route('scholarships.index') }}" class="btn btn-primary mt-2">Manage Scholarships</a>
        <a href="{{ route('assignments.index') }}" class="btn btn-success mt-2">Reviewer Assignments</a>
    </div>
</x-app-layout>