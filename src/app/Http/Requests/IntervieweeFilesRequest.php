<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $eventId
 * @property mixed $eventStart
 * @property mixed $eventEnd
 */
class IntervieweeFilesRequest extends FormRequest
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

            'interviewee_file' => 'file|mimes:pdf,doc,docx|max:15360',

        ];

    }
}
