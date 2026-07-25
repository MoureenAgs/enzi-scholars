<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ScholarshipController extends Controller
{
    public function index(Request $request)
    {
        $scholarships = Scholarship::with('creator')
            ->when($request->search, function ($query, $search) {
                $query->where('title', 'like', "%{$search}%");
            })
            ->when($request->status, function ($query, $status) {
                $query->where('status', $status);
            })
            ->latest()
            ->paginate(10)
            ->withQueryString();

        return view('admin.scholarships.index', compact('scholarships'));
    }

    public function create()
    {
        return view('admin.scholarships.create');
    }

    public function store(StoreScholarshipRequest $request)
    {
        $validated = $request->validated();
        $validated['created_by'] = auth()->id();

        if ($request->hasFile('application_form')) {
            $validated['application_form_path'] = $request->file('application_form')->store('scholarship_forms', 'local');
        }

        $scholarship = Scholarship::create($validated);

        activity_log('created scholarship', $scholarship);

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship created successfully.');
    }

    public function show(Scholarship $scholarship)
    {
        $scholarship->load('creator', 'evaluationCriteria');

        return view('admin.scholarships.show', compact('scholarship'));
    }

    public function edit(Scholarship $scholarship)
    {
        return view('admin.scholarships.edit', compact('scholarship'));
    }

    public function update(UpdateScholarshipRequest $request, Scholarship $scholarship)
    {
        $validated = $request->validated();

        if ($request->hasFile('application_form')) {
            // Remove the old file if one existed, to avoid orphaned files piling up
            if ($scholarship->application_form_path) {
                Storage::disk('local')->delete($scholarship->application_form_path);
            }
            $validated['application_form_path'] = $request->file('application_form')->store('scholarship_forms', 'local');
        }

        $scholarship->update($validated);

        activity_log('updated scholarship', $scholarship);

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship updated successfully.');
    }

    public function destroy(Scholarship $scholarship)
    {
        activity_log('deleted scholarship', $scholarship);

        $scholarship->delete();

        return redirect()
            ->route('scholarships.index')
            ->with('success', 'Scholarship deleted successfully.');
    }

    /**
     * Let an authenticated user (admin or applicant) download the scholarship's application form template.
     */
    public function downloadForm(Scholarship $scholarship)
    {
        if (!$scholarship->application_form_path) {
            abort(404, 'No application form has been uploaded for this scholarship.');
        }

        return Storage::disk('local')->download(
            $scholarship->application_form_path,
            str($scholarship->title)->slug() . '-application-form.' . pathinfo($scholarship->application_form_path, PATHINFO_EXTENSION)
        );
    }
}