<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $last_name
 * @property mixed $full_name
 * @property mixed $client_phone
 * @property mixed $position
 * @property mixed $email
 */
class ClientCreateFormRequest extends FormRequest
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

            'company' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'type' => ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'debt_ceiling' => 'nullable|numeric|between:0,999999.99',
            'identification_number' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'code_of_the_reason_for_registration' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'main_state_registration_number' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'director_name' => ['nullable', 'max:90', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@,. \'"]+$/u'],
            'contact_person_position' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@,. \'"]+$/u'],
            'acting_on_the_basis_of' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@,. \'"]+$/u'],
            'registered_address' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@,. \'"]+$/u'],
            'zip_code' => ['nullable', 'max:10', 'regex:/^[\0-9_\/\-()№@. \'"]+$/u'],
            'postal_address' => ['required', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'payment_account' => ['required', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'bank_name' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'bank_identification_code' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'name' => ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'last_name' =>  ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'full_name' =>  ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'client_phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'position' => ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'email' => 'nullable|email',



        ];
    }
}
