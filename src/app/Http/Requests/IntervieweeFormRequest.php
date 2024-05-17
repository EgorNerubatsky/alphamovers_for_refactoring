<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class IntervieweeFormRequest extends FormRequest
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
            'call_date' => 'nullable|date',
            'interview_date' => 'nullable|date',
            'fullname_surname' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'fullname_name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'fullname_patronymic' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
//            'age' => 'integer|nullable',
            'birth_date' => 'nullable|date',
            'gender' => ['nullable', 'max:10', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'address' => ['nullable', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'email' => 'nullable|email',
            'position' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'comment' => ['nullable', 'max:300', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'interviewee_file' => 'nullable|file|mimes:pdf,doc,docx|max:15360',
            'interviewee_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:15360',
        ];
    }
}
