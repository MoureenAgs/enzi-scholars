<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Applicant Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-success">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Applicant</strong>.
        </div>
        <p>This is a placeholder. Your scholarship applications and status will appear here in later modules.</p>

        <a href="{{ route('applicant.profile.edit') }}" class="btn btn-primary mt-2">Edit My Profile</a>
    </div>
</x-app-layout>