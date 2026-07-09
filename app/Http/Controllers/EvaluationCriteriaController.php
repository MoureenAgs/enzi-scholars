<?php

namespace App\Http\Controllers;

use App\Models\Scholarship;
use App\Models\EvaluationCriteria;
use Illuminate\Http\Request;

class EvaluationCriteriaController extends Controller
{
    /**
     * Show the criteria management page for a specific scholarship.
     */
    public function index(Scholarship $scholarship)
    {
        $criteria = $scholarship->evaluationCriteria;
        $totalWeight = $criteria->sum('weight');

        return view('admin.criteria.index', compact('scholarship', 'criteria', 'totalWeight'));
    }

    public function store(Request $request, Scholarship $scholarship)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'weight' => ['required', 'integer', 'min:1', 'max:100'],
        ]);

        $scholarship->evaluationCriteria()->create($validated);

        activity_log('added evaluation criterion', $scholarship, $validated['name']);

        return back()->with('success', 'Criterion added successfully.');
    }

    public function destroy(Scholarship $scholarship, EvaluationCriteria $criteria)
    {
        $criteria->delete();

        return back()->with('success', 'Criterion removed.');
    }
}