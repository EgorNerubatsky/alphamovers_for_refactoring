<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $search
 */
class MailSendRequest extends FormRequest
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
            'recipient_name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-@. \'"]+$/u'],
            'message' => ['required', 'max:500', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-@. \'"]+$/u'],
            'sender_name' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-@. \'"]+$/u'],
            'recipient_email' => 'required|email',
            'subject' => ['required', 'max:50', 'regex:/^[\p{Cyrillic}a-zA-Z0-9_\-@. \'"]+$/u'],
            'attachment.*' => 'file|mimes:pdf,doc,docx,png,jpeg,jpg,rar,zip|max:10240',
        ];



    }
}
