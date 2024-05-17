<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $execution_date_date
 * @property mixed $execution_date_time
 * @property mixed $client
 * @property mixed $phone
 * @property mixed $fullname
 * @property mixed $email
 */
class OrderDetailFormRequest extends FormRequest
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

//            'fullname' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-@. ]+$/u'],
//            'phone' => 'required|string|nullable|regex:/^[\d\+\-\(\)]{10,15}$/',
//            'email' => 'required|email',
//            'comment' => 'string|max:255',


            'execution_date' => 'nullable|date',

            'order_source' => ['nullable', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'status' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'payment_form' => ['nullable', 'max:150', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'fullname' => ['nullable', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'phone' => ['nullable', 'regex:/^[\d\+\-\(\)]{10,15}$/'],
            'email' => 'nullable|email',
            'service_type' => ['nullable', 'max:150', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'city' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'street' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'house' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'number_of_workers' => 'nullable|integer',
            'transport' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'task_description' => ['nullable', 'max:400', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'straps' => 'nullable|boolean',
            'tools' => 'nullable|boolean',
            'respirators' => 'nullable|boolean',
            'payment_note' => ['nullable', 'max:400', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'user_logist_id' => 'nullable|integer',
            'min_order_amount' => 'required|numeric|between:0,999999.99',
            'min_order_hrs' => 'nullable|numeric|between:0,9999.99',
            'order_hrs' => 'nullable|numeric|between:0,9999.99',
            'price_to_customer' => 'nullable|numeric|between:0,999999.99',
            'price_to_workers' => 'nullable|numeric|between:0,999999.99',
        ];


    }
}
