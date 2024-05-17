<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UserStoreFormRequest extends FormRequest
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
            'name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'lastname' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'middle_name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],

            'birth_date' => 'nullable|date',
            'gender' => ['nullable', 'max:10', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'address' => ['nullable', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'email' => 'nullable|email',
            'password' => ['required', 'string', 'min:8', 'regex:/^(?=.*[A-Z])(?=.*[a-z])(?=.*\d).+$/'],
            'is_manager' => 'nullable|boolean',
            'is_executive' => 'nullable|boolean',
            'is_brigadier' => 'nullable|boolean',
            'is_hr' => 'nullable|boolean',
            'is_accountant' => 'nullable|boolean',
            'is_logist' => 'nullable|boolean',
            'bank_card' => 'nullable|string|digits:16',
            'passport_number' => 'nullable|string|digits:6',
            'passport_series' => 'nullable|string|size:2',
            'employee_photo' => 'nullable|file|mimes:jpeg,jpg,png|max:15360',

        ];
    }
}
