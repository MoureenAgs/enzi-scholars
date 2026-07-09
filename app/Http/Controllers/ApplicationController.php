<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\ScholarshipApplication;
use App\Models\ApplicationDocument;
use App\Http\Requests\StoreApplicationRequest;

class ApplicationController extends Controller
{
    /**
     * Show all currently open scholarships available to apply to.
     */
    public function index()
    {
        $openScholarships = Scholarship::where('status', 'open')
            ->orderBy('application_deadline')
            ->get();

        // IDs of scholarships this applicant has already applied to, so we can disable the button
        $appliedScholarshipIds = auth()->user()
            ->applications()
            ->pluck('scholarship_id')
            ->toArray();

        return view('applicant.applications.index', compact('openScholarships', 'appliedScholarshipIds'));
    }

    /**
     * Show the applicant's own submitted applications and their statuses.
     */
    public function myApplications()
    {
        $applications = auth()->user()
            ->applications()
            ->with('scholarship')
            ->latest()
            ->get();

        return view('applicant.applications.my', compact('applications'));
    }

    public function store(StoreApplicationRequest $request)
    {
        $validated = $request->validated();

        // Guard against duplicate applications (DB unique constraint also protects this)
        $alreadyApplied = ScholarshipApplication::where('applicant_id', auth()->id())
            ->where('scholarship_id', $validated['scholarship_id'])
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'You have already applied to this scholarship.');
        }

        $application = ScholarshipApplication::create([
            'applicant_id' => auth()->id(),
            'scholarship_id' => $validated['scholarship_id'],
            'status' => 'submitted',
            'submitted_at' => now(),
        ]);

        // Store the uploaded file
        $file = $request->file('document');
        $path = $file->store('application_documents', 'local');

        ApplicationDocument::create([
            'application_id' => $application->id,
            'document_type' => 'supporting_document',
            'file_path' => $path,
            'original_filename' => $file->getClientOriginalName(),
        ]);

        activity_log('submitted application', $application);

        return redirect()
            ->route('applicant.applications.my')
            ->with('success', 'Application submitted successfully.');
    }
}