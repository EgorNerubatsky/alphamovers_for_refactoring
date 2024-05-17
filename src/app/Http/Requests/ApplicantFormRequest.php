<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $fullname_surname
 * @property mixed $fullname_name
 * @property mixed $fullname_patronymic
 * @property mixed $phone
 * @property mixed $desired_position
 * @property mixed $comment
 */
class ApplicantFormRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [

            'fullname_surname' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'fullname_name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'fullname_patronymic' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'desired_position' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'comment' => ['nullable', 'max:300', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'applicant_file' => 'nullable|file|mimes:pdf,doc,docx|max:15360',
            'applicant_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:15360',
        ];
    }
}
