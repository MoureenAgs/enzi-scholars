<?php

namespace App\Http\Controllers;

class ApplicantDashboardController extends Controller
{
    public function index()
    {
        $applications = auth()->user()
            ->applications()
            ->with('scholarship')
            ->latest()
            ->get();

        $hasProfile = auth()->user()->applicantProfile()->exists();

        return view('applicant.dashboard', compact('applications', 'hasProfile'));
    }
}