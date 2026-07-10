<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\ReviewerAssignment;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_scholarships' => Scholarship::count(),
            'open_scholarships' => Scholarship::where('status', 'open')->count(),
            'total_applications' => ScholarshipApplication::count(),
            'pending_review' => ScholarshipApplication::where('status', 'submitted')->count(),
            'under_review' => ScholarshipApplication::where('status', 'under_review')->count(),
            'approved' => ScholarshipApplication::where('status', 'approved')->count(),
            'rejected' => ScholarshipApplication::where('status', 'rejected')->count(),
        ];

        $recentApplications = ScholarshipApplication::with(['applicant', 'scholarship'])
            ->latest()
            ->take(5)
            ->get();

        return view('admin.dashboard', compact('stats', 'recentApplications'));
    }
}