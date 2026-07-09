<?php

namespace App\Http\Controllers;

use App\Models\ApplicantProfile;
use App\Http\Requests\UpdateApplicantProfileRequest;
use Illuminate\Http\Request;

class ApplicantProfileController extends Controller
{
    /**
     * Show the applicant's profile edit form.
     * Auto-creates an empty profile on first visit so the form always has something to bind to.
     */
    public function edit(Request $request)
    {
        $profile = ApplicantProfile::firstOrCreate(
            ['user_id' => $request->user()->id]
        );

        return view('applicant.profile.edit', compact('profile'));
    }

    public function update(UpdateApplicantProfileRequest $request)
    {
        $profile = ApplicantProfile::where('user_id', $request->user()->id)->firstOrFail();

        $profile->update($request->validated());

        activity_log('updated applicant profile', $profile);

        return redirect()
            ->route('applicant.profile.edit')
            ->with('success', 'Profile updated successfully.');
    }
}