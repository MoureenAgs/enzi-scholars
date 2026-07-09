<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use App\Models\ReviewerAssignment;
use App\Models\User;
use Illuminate\Http\Request;

class ReviewerAssignmentController extends Controller
{
    /**
     * List all applications for a scholarship, with assignment controls.
     */
    public function index()
    {
        $applications = ScholarshipApplication::with(['applicant', 'scholarship', 'reviewerAssignments.reviewer'])
            ->latest()
            ->get();

        $reviewers = User::where('role', 'reviewer')->get();

        return view('admin.assignments.index', compact('applications', 'reviewers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'application_id' => ['required', 'exists:scholarship_applications,id'],
            'reviewer_id' => ['required', 'exists:users,id'],
        ]);

        $exists = ReviewerAssignment::where('application_id', $validated['application_id'])
            ->where('reviewer_id', $validated['reviewer_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This reviewer is already assigned to this application.');
        }

        $assignment = ReviewerAssignment::create([
            'application_id' => $validated['application_id'],
            'reviewer_id' => $validated['reviewer_id'],
            'assigned_by' => auth()->id(),
            'assigned_at' => now(),
        ]);

        // Move application into "under_review" status once at least one reviewer is assigned
        $application = ScholarshipApplication::find($validated['application_id']);
        if ($application->status === 'submitted') {
            $application->update(['status' => 'under_review']);
        }

        activity_log('assigned reviewer', $assignment);

        return back()->with('success', 'Reviewer assigned successfully.');
    }

    public function destroy(ReviewerAssignment $assignment)
    {
        $assignment->delete();

        return back()->with('success', 'Reviewer assignment removed.');
    }
}