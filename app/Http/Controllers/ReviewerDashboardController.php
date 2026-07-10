<?php

namespace App\Http\Controllers;

class ReviewerDashboardController extends Controller
{
    public function index()
    {
        $assignments = auth()->user()
            ->reviewerAssignments()
            ->with(['application.scholarship', 'application.applicant'])
            ->get();

        $totalAssigned = $assignments->count();

        $scoredApplicationIds = auth()->user()
            ->scoresGiven()
            ->pluck('application_id')
            ->unique();

        $totalScored = $assignments->filter(function ($assignment) use ($scoredApplicationIds) {
            return $scoredApplicationIds->contains($assignment->application_id);
        })->count();

        $pending = $totalAssigned - $totalScored;

        return view('reviewer.dashboard', compact('assignments', 'totalAssigned', 'totalScored', 'pending'));
    }
}