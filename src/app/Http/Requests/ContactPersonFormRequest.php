<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class ContactPersonFormRequest extends FormRequest
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
            'name'=>'string|nullable',
            'last_name'=>'string|nullable',
            'full_name'=>'string|nullable',
            'position'=>'string|nullable',
            'phone'=>'string|nullable',
            'email'=>'string|nullable',
        ];
    }
}
