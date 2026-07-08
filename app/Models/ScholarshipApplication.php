<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ScholarshipApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'applicant_id',
        'scholarship_id',
        'status',
        'total_score',
        'rank',
        'submitted_at',
    ];

    protected function casts(): array
    {
        return [
            'submitted_at' => 'datetime',
            'total_score' => 'decimal:2',
        ];
    }

    public function applicant()
    {
        return $this->belongsTo(User::class, 'applicant_id');
    }

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function documents()
    {
        return $this->hasMany(ApplicationDocument::class, 'application_id');
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'application_id');
    }

    public function reviewerAssignments()
    {
        return $this->hasMany(ReviewerAssignment::class, 'application_id');
    }

    public function decision()
    {
        return $this->hasOne(ApplicationDecision::class, 'application_id');
    }
}