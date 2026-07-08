<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Score extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'reviewer_id',
        'criteria_id',
        'score_value',
        'comment',
    ];

    protected function casts(): array
    {
        return [
            'score_value' => 'decimal:2',
        ];
    }

    public function application()
    {
        return $this->belongsTo(ScholarshipApplication::class, 'application_id');
    }

    public function reviewer()
    {
        return $this->belongsTo(User::class, 'reviewer_id');
    }

    public function criteria()
    {
        return $this->belongsTo(EvaluationCriteria::class, 'criteria_id');
    }
}