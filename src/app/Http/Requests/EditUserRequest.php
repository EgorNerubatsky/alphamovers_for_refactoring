<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $name
 * @property mixed $lastname
 * @property mixed $phone
 * @property mixed $address
 * @property mixed $password
 * @property mixed $is_admin
 * @property mixed $is_manager
 * @property mixed $is_executive
 * @property mixed $is_hr
 * @property mixed $is_accountant
 * @property mixed $is_logist
 * @property mixed $is_mover
 */
class EditUserRequest extends FormRequest
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
            'name' => 'required|regex:/^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$/u',
            'lastname' => 'required|regex:/^[a-zA-Zа-яА-Яіїєґ\s]{1,20}$/u',
            'email' => 'required|email',
            'phone' => 'string|nullable',
            'address' => 'string|nullable',
            'is_admin' => 'boolean|nullable',
            'is_manager' => 'boolean|nullable',
            'is_executive' => 'boolean|nullable',
            'is_hr' => 'boolean|nullable',
            'is_accountant' => 'boolean|nullable',
            'is_logist' => 'boolean|nullable',
            'is_mover' =>'boolean|nullable',


        ];

    }
}
