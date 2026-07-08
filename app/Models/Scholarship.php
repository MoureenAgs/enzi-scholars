<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholarship extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'eligibility_criteria',
        'application_deadline',
        'status',
        'created_by',
    ];

    protected function casts(): array
    {
        return [
            'application_deadline' => 'date',
        ];
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function applications()
    {
        return $this->hasMany(ScholarshipApplication::class);
    }

    public function evaluationCriteria()
    {
        return $this->hasMany(EvaluationCriteria::class);
    }
}