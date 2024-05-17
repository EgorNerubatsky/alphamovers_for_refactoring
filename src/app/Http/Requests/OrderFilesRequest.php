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
class OrderFilesRequest extends FormRequest
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

            'deed_file' => 'file|mimes:pdf,doc,docx|max:15360',
            'invoice_file' => 'file|mimes:pdf,doc,docx|max:15360',
            'act_file' => 'file|mimes:pdf,doc,docx|max:15360',

        ];

    }
}
