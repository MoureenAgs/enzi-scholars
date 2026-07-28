<?php

namespace App\Http\Controllers;

use App\Models\ApplicationDocument;
use Illuminate\Support\Facades\Storage;

class ApplicationDocumentController extends Controller
{
    /**
     * Securely serve/download an application document.
     * Authorization: admin (any), assigned reviewer, or the owning applicant.
     */
    public function download(ApplicationDocument $document)
    {
        $application = $document->application;
        $user = auth()->user();

        $isAuthorized = $user->isAdmin()
            || ($user->isReviewer() && $application->reviewerAssignments()->where('reviewer_id', $user->id)->exists())
            || ($user->isApplicant() && $application->applicant_id === $user->id);

        if (!$isAuthorized) {
            abort(403, 'You are not authorized to view this document.');
        }

        if (!Storage::disk('local')->exists($document->file_path)) {
            abort(404, 'File not found.');
        }

        return Storage::disk('local')->response(
            $document->file_path,
            $document->original_filename
        );
    }
}