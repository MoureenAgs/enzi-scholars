<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Administrator Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-primary">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Administrator</strong>.
        </div>
        <p>This is a placeholder. Scholarship management, applicant lists, and reports will appear here in later modules.</p>
    </div>
</x-app-layout>