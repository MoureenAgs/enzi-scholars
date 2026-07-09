<x-app-layout>
    <x-slot name="header">
        <h2 class="fw-bold fs-4">Reviewer Dashboard</h2>
    </x-slot>

    <div class="container py-4">
        <div class="alert alert-info">
            Welcome, {{ auth()->user()->name }} — you are logged in as <strong>Reviewer</strong>.
        </div>
        <p>This is a placeholder. Your assigned applications and scoring forms will appear here in later modules.</p>
    </div>
</x-app-layout>