<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDecision extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'decided_by',
        'decision',
        'remarks',
        'decided_at',
    ];

    protected function casts(): array
    {
        return [
            'decided_at' => 'datetime',
        ];
    }

    public function application()
    {
        return $this->belongsTo(ScholarshipApplication::class, 'application_id');
    }

    public function decidedBy()
    {
        return $this->belongsTo(User::class, 'decided_by');
    }
}