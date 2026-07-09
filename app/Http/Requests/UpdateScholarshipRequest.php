<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateScholarshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'eligibility_criteria' => ['nullable', 'string'],
            'application_deadline' => ['required', 'date'],
            'status' => ['required', 'in:draft,open,closed'],
        ];
    }
}