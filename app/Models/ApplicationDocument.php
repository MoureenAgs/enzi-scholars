<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ApplicationDocument extends Model
{
    use HasFactory;

    protected $fillable = [
        'application_id',
        'document_type',
        'file_path',
        'original_filename',
    ];

    public function application()
    {
        return $this->belongsTo(ScholarshipApplication::class, 'application_id');
    }
}