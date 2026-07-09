<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreApplicationRequest extends FormRequest
{
    public function authorize(): bool
    {
        return $this->user()->isApplicant();
    }

    public function rules(): array
    {
        return [
            'scholarship_id' => ['required', 'exists:scholarships,id'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'], // 5MB max
        ];
    }

    public function messages(): array
    {
        return [
            'document.mimes' => 'The document must be a PDF, JPG, or PNG file.',
            'document.max' => 'The document must not exceed 5MB.',
        ];
    }
}