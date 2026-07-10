<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use Barryvdh\DomPDF\Facade\Pdf;

class ReportController extends Controller
{
    /**
     * Generate a PDF ranking report for a specific scholarship.
     */
    public function rankingReport(Scholarship $scholarship)
    {
        $applications = ScholarshipApplication::where('scholarship_id', $scholarship->id)
            ->with(['applicant', 'decision'])
            ->orderByRaw('rank IS NULL, rank ASC')
            ->get();

        $pdf = Pdf::loadView('admin.reports.ranking', compact('scholarship', 'applications'));

        return $pdf->download('ranking-report-' . str($scholarship->title)->slug() . '.pdf');
    }
}