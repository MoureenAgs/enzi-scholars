<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\ApplicationDecision;
use Illuminate\Http\Request;

class ApplicationDecisionController extends Controller
{
    /**
     * Show all scholarships so the admin can pick one to review rankings for.
     */
    public function selectScholarship()
    {
        $scholarships = Scholarship::withCount('applications')->get();

        return view('admin.decisions.select', compact('scholarships'));
    }

    /**
     * Show the ranked list of applicants for a specific scholarship.
     */
    public function index(Scholarship $scholarship)
    {
        $applications = ScholarshipApplication::where('scholarship_id', $scholarship->id)
            ->with(['applicant', 'decision'])
            ->orderByRaw('rank IS NULL, rank ASC') // ranked applications first, unranked last
            ->get();

        return view('admin.decisions.index', compact('scholarship', 'applications'));
    }

    public function store(Request $request, ScholarshipApplication $application)
    {
        $validated = $request->validate([
            'decision' => ['required', 'in:approved,rejected'],
            'remarks' => ['nullable', 'string'],
        ]);

        // updateOrCreate lets the admin change their mind and re-decide without creating duplicate rows
        ApplicationDecision::updateOrCreate(
            ['application_id' => $application->id],
            [
                'decided_by' => auth()->id(),
                'decision' => $validated['decision'],
                'remarks' => $validated['remarks'] ?? null,
                'decided_at' => now(),
            ]
        );

        $application->update(['status' => $validated['decision']]);

        activity_log($validated['decision'] . ' application', $application);

        return back()->with('success', 'Decision recorded successfully.');
    }
}