<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\StoreStaffUserRequest;
use Illuminate\Support\Facades\Hash;

class UserManagementController extends Controller
{
    /**
     * List all admin and reviewer accounts (staff), not applicants.
     */
    public function index()
    {
        $staff = User::whereIn('role', ['admin', 'reviewer'])
            ->latest()
            ->get();

        return view('admin.users.index', compact('staff'));
    }

    public function create()
    {
        return view('admin.users.create');
    }

    public function store(StoreStaffUserRequest $request)
    {
        $validated = $request->validated();

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role' => $validated['role'],
            'password' => Hash::make($validated['password']),
            'email_verified_at' => now(),
        ]);

        activity_log('created ' . $validated['role'] . ' account', $user);

        return redirect()
            ->route('users.index')
            ->with('success', ucfirst($validated['role']) . ' account created successfully.');
    }

    public function destroy(User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        if ($user->isApplicant()) {
            return back()->with('error', 'Applicant accounts cannot be managed here.');
        }

        activity_log('deleted ' . $user->role . ' account', $user);

        $user->delete();

        return back()->with('success', 'Account deleted successfully.');
    }
}