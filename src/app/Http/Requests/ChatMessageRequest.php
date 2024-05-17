<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property mixed $eventId
 * @property mixed $eventStart
 * @property mixed $eventEnd
 * @property mixed $recipient_user_id
 * @property mixed $message
 * @property mixed $sender_user_id
 */
class ChatMessageRequest extends FormRequest
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
//            'message' => ['required', 'max:600', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\/\-()№@. \'"]+$/u'],
            'message' => 'required|string',

            'message_file' => 'file|mimes:png,jpg,jpeg,doc,docx,pdf|max:15000',
        ];
    }
}
