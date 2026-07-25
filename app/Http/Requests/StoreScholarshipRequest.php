<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreScholarshipRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Only admins can create scholarships
        return $this->user()->isAdmin();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'eligibility_criteria' => ['nullable', 'string'],
            'application_deadline' => ['required', 'date', 'after:today'],
            'status' => ['required', 'in:draft,open,closed'],
            'application_form' => ['nullable', 'file', 'mimes:pdf,doc,docx', 'max:5120'],
        ];
    }

    public function messages(): array
    {
        return [
            'application_deadline.after' => 'The application deadline must be a future date.',
            'application_form.mimes' => 'The application form must be a PDF or Word document.',
        ];
    }
}