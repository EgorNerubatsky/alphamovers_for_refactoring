<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $client_contacts
 * @property mixed $add_client_contacts
 */
class ClientUpdateFormRequest extends FormRequest
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
            'client_contacts.*.complete_name'=> ['required', 'max:80', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'client_contacts.*.client_phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'client_contacts.*.position' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'client_contacts.*.email' => 'nullable|email',
            'add_client_contacts.*.name'=> ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'add_client_contacts.*.last_name'=> ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'add_client_contacts.*.position'=> ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'add_client_contacts.*.client_phone'=> 'nullable|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
            'add_client_contacts.*.email'=> 'nullable|email',
        ];
    }
}
