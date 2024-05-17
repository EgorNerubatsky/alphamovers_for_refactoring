<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;


/**
 * @property mixed $search
 */
class ArticleStoreRequest extends FormRequest
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
            'title' => 'required|string|max:500',
            'content' => 'required|max:50000',
            'article_file' => 'nullable|file|mimes:pdf,doc,docx,png,jpeg,jpg,rar,zip|max:10240',
        ];

    }
}
