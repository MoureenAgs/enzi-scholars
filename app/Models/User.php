<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    // ── Role helper methods ─────────────────────────────

    public function isAdmin(): bool
    {
        return $this->role === 'admin';
    }

    public function isReviewer(): bool
    {
        return $this->role === 'reviewer';
    }

    public function isApplicant(): bool
    {
        return $this->role === 'applicant';
    }

    // ── Relationships ───────────────────────────────────

    public function applicantProfile()
    {
        return $this->hasOne(ApplicantProfile::class);
    }

    // Scholarships created by this user (if admin)
    public function createdScholarships()
    {
        return $this->hasMany(Scholarship::class, 'created_by');
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    // Applications submitted by this user (if applicant)
    public function applications()
    {
        return $this->hasMany(ScholarshipApplication::class, 'applicant_id');
    }

    // Applications this user has been assigned to review (if reviewer)
    public function reviewerAssignments()
    {
        return $this->hasMany(ReviewerAssignment::class, 'reviewer_id');
    }

    // Scores this user has given (if reviewer)
    public function scoresGiven()
    {
        return $this->hasMany(Score::class, 'reviewer_id');
    }

    // Decisions this user has made (if admin)
    public function decisionsMade()
    {
        return $this->hasMany(ApplicationDecision::class, 'decided_by');
    }

    public function activityLogs()
    {
        return $this->hasMany(ActivityLog::class);
    }
}