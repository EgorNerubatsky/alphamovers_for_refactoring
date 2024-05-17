<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $execution_date_date
 * @property mixed $execution_date_time
 * @property mixed $min_order_hrs
 * @property mixed $price_to_customer
 * @property mixed $client
 */
class OrderFormRequest extends FormRequest
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

            'client' => 'required|integer',
            'execution_date_date' => 'required|date_format:Y-m-d',
            'execution_date_time' => 'required|date_format:H:i',

            'order_source' => ['required', 'max:30', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],

//            'status' => 'required|string',
            'status' => ['required', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'payment_form' => ['nullable', 'max:150', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'service_type' => ['required', 'max:150', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'city' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'street' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'house' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \']+$/u'],
            'number_of_workers' => 'nullable|integer',
            'transport' => ['nullable', 'max:20', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'task_description' => ['nullable', 'max:400', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-()@. \'"]+$/u'],
            'straps' => 'nullable|boolean',
            'tools' => 'nullable|boolean',
            'respirators' => 'nullable|boolean',
            'min_order_hrs' => 'nullable|numeric|between:0,9999.99',
            'order_hrs' => 'nullable|numeric|between:0,9999.99',
            'price_to_customer' => 'nullable|numeric|between:0,999999.99',
            'price_to_workers' => 'nullable|numeric|between:0,999999.99',
            'min_order_amount' => 'required|numeric|between:0,999999.99',
            'payment_note' => ['nullable', 'max:400', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'review' => ['nullable', 'max:400', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'logist' => 'integer|nullable',

        ];


    }
}
