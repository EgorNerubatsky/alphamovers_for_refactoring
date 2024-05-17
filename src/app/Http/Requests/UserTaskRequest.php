<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $comment
 * @property mixed $eventId
 * @property mixed $eventStart
 * @property mixed $eventEnd
 */
class UserTaskRequest extends FormRequest
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
            'eventId' => 'required|integer',
            'eventStart' => 'nullable|date',
            'eventEnd' => 'nullable|date',
            'eventTitle' => ['required', 'max:120', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'status' => ['nullable', 'max:10', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
        ];

    }
}
