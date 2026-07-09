<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\AdminDashboardController;
use App\Http\Controllers\ReviewerDashboardController;
use App\Http\Controllers\ApplicantDashboardController;
use App\Http\Controllers\ScholarshipController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// Generic /dashboard route: redirects each user to their role-specific dashboard
Route::get('/dashboard', function () {
    $user = auth()->user();

    return match ($user->role) {
        'admin' => redirect()->route('admin.dashboard'),
        'reviewer' => redirect()->route('reviewer.dashboard'),
        'applicant' => redirect()->route('applicant.dashboard'),
        default => abort(403, 'Unrecognized role.'),
    };
})->middleware(['auth', 'verified'])->name('dashboard');

// Role-specific dashboard routes, each protected by both auth and role middleware
Route::middleware(['auth', 'verified', 'role:admin'])->group(function () {
    Route::get('/admin/dashboard', [AdminDashboardController::class, 'index'])->name('admin.dashboard');
    Route::resource('scholarships', ScholarshipController::class);
});

Route::middleware(['auth', 'verified', 'role:reviewer'])->group(function () {
    Route::get('/reviewer/dashboard', [ReviewerDashboardController::class, 'index'])->name('reviewer.dashboard');
});

Route::middleware(['auth', 'verified', 'role:applicant'])->group(function () {
    Route::get('/applicant/dashboard', [ApplicantDashboardController::class, 'index'])->name('applicant.dashboard');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
