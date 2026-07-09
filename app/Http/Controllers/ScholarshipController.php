<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Http\Requests\StoreScholarshipRequest;
use App\Http\Requests\UpdateScholarshipRequest;

class ScholarshipController extends Controller
{
    public function index()
    {
        $scholarships = Scholarship::with('creator')
            ->latest()
            ->paginate(10);

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
        $scholarship->update($request->validated());

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
}
