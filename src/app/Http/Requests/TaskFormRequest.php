<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $start_task
 * @property mixed $end_task
 * @property mixed $task_to_user_id
 */
class TaskFormRequest extends FormRequest
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
            'task_to_user_id' => 'required|integer|',
            'company' => ['nullable', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
            'task' => ['required', 'max:120', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'start_task' => 'required|date',
            'end_task' => 'required|date',
            'status' => ['nullable', 'max:10', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()@. \'"]+$/u'],
        ];
    }
}
