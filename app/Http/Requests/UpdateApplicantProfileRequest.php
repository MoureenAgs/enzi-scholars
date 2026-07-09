<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateApplicantProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isApplicant();
    }

    public function rules(): array
    {
        return [
            'phone' => ['nullable', 'string', 'max:20'],
            'date_of_birth' => ['nullable', 'date', 'before:today'],
            'gender' => ['nullable', 'in:male,female,other'],
            'national_id' => ['nullable', 'string', 'max:50'],
            'institution' => ['nullable', 'string', 'max:255'],
            'course_of_study' => ['nullable', 'string', 'max:255'],
            'education_level' => ['nullable', 'in:high_school,undergraduate,postgraduate'],
            'address' => ['nullable', 'string'],
        ];
    }
}