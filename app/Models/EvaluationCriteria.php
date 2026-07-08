<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EvaluationCriteria extends Model
{
    use HasFactory;

    protected $table = 'evaluation_criteria'; // already plural, prevents Laravel guessing "evaluation_criterias"

    protected $fillable = [
        'scholarship_id',
        'name',
        'weight',
    ];

    public function scholarship()
    {
        return $this->belongsTo(Scholarship::class);
    }

    public function scores()
    {
        return $this->hasMany(Score::class, 'criteria_id');
    }
}