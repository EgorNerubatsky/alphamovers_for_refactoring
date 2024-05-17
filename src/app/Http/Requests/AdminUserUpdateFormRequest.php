<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $position
 */
class AdminUserUpdateFormRequest extends FormRequest
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
            'name' => 'nullable|regex:/^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$/u',
            'lastname' => 'string|nullable',
            'birth_date' => 'date|nullable',
            'gender' => 'string|nullable',
            'address' => 'string|nullable',
            'phone' => 'string|nullable',
            'email' => 'email|nullable',
            'is_manager'=>'boolean|nullable',
            'is_executive'=>'boolean|nullable',
            'is_brigadier'=>'boolean|nullable',
            'is_hr'=>'boolean|nullable',
            'is_accountant'=>'boolean|nullable',
            'is_logist'=>'boolean|nullable',
            'bank_card' => 'nullable|string|size:16',
            'passport_number' => 'nullable|string|size:6',
            'passport_series' => 'nullable|string|size:2',
        ];
    }
}
