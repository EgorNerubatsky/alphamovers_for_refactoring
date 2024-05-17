<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $search
 */
class PasswordUpdateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'old_password' => ['max:18', 'regex:/^[a-zA-Z0-9]+$/u'],
            'new_password' => ['max:18', 'regex:/^[a-zA-Z0-9]+$/u'],
            'new_password_confirm' => ['max:18', 'regex:/^[a-zA-Z0-9]+$/u'],
        ];
    }
}
