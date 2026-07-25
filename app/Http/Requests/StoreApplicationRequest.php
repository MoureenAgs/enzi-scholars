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
            'application_form' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'birth_certificate' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'acceptance_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'recommendation_letter' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:5120'],
            'passport_photo' => ['required', 'file', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }

    public function messages(): array
    {
        return [
            '*.mimes' => 'Please upload a valid file type (PDF, JPG, or PNG).',
            'passport_photo.mimes' => 'The passport photo must be a JPG or PNG image.',
            '*.max' => 'The file must not exceed the maximum allowed size.',
            '*.required' => 'This document is required to submit your application.',
        ];
    }
}