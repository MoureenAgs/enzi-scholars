<?php

namespace App\Http\Controllers;

use App\Models\ScholarshipApplication;
use App\Models\Score;
use Illuminate\Http\Request;

class ScoreController extends Controller
{
    /**
     * Show all applications assigned to the currently logged-in reviewer.
     */
    public function index()
    {
        $assignments = auth()->user()
            ->reviewerAssignments()
            ->with(['application.scholarship.evaluationCriteria', 'application.applicant'])
            ->get();

        return view('reviewer.scores.index', compact('assignments'));
    }

    /**
     * Show the scoring form for one specific application.
     */
    public function create(ScholarshipApplication $application)
    {
        // Security: make sure this reviewer is actually assigned to this application
        $isAssigned = $application->reviewerAssignments()
            ->where('reviewer_id', auth()->id())
            ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not assigned to review this application.');
        }

        $application->load('scholarship.evaluationCriteria', 'applicant');

        // Load this reviewer's existing scores for this application, if any (so the form pre-fills on re-visit)
        $existingScores = Score::where('application_id', $application->id)
            ->where('reviewer_id', auth()->id())
            ->pluck('score_value', 'criteria_id');

        return view('reviewer.scores.create', compact('application', 'existingScores'));
    }

    public function store(Request $request, ScholarshipApplication $application)
    {
        $isAssigned = $application->reviewerAssignments()
            ->where('reviewer_id', auth()->id())
            ->exists();

        if (!$isAssigned) {
            abort(403, 'You are not assigned to review this application.');
        }

        $validated = $request->validate([
            'scores' => ['required', 'array'],
            'scores.*' => ['required', 'numeric', 'min:0', 'max:100'],
            'comment' => ['nullable', 'string'],
        ]);

        // Save/update a score row for each criterion submitted
        foreach ($validated['scores'] as $criteriaId => $scoreValue) {
            Score::updateOrCreate(
                [
                    'application_id' => $application->id,
                    'reviewer_id' => auth()->id(),
                    'criteria_id' => $criteriaId,
                ],
                [
                    'score_value' => $scoreValue,
                    'comment' => $validated['comment'] ?? null,
                ]
            );
        }

        activity_log('scored application', $application);

        // Recalculate the application's overall weighted total score
        $this->recalculateTotalScore($application);

        return redirect()
            ->route('reviewer.scores.index')
            ->with('success', 'Scores submitted successfully.');
    }

    /**
     * Core scoring engine logic: compute the weighted total score for an application,
     * averaged across all reviewers who have scored it.
     */
    protected function recalculateTotalScore(ScholarshipApplication $application): void
    {
        $criteria = $application->scholarship->evaluationCriteria;
        $scores = $application->scores()->get()->groupBy('reviewer_id');

        if ($scores->isEmpty()) {
            return;
        }

        $reviewerTotals = [];

        foreach ($scores as $reviewerId => $reviewerScores) {
            $weightedSum = 0;

            foreach ($criteria as $criterion) {
                $scoreForCriterion = $reviewerScores->firstWhere('criteria_id', $criterion->id);

                if ($scoreForCriterion) {
                    $weightedSum += ($scoreForCriterion->score_value * $criterion->weight / 100);
                }
            }

            $reviewerTotals[] = $weightedSum;
        }

        // Average the weighted totals across all reviewers who have scored so far
        $finalScore = array_sum($reviewerTotals) / count($reviewerTotals);

        $application->update(['total_score' => round($finalScore, 2)]);
    }
}