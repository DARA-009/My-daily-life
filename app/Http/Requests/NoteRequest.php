<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class NoteRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id' => ['nullable', 'exists:categories,id'],
            'title'       => ['required', 'string', 'max:255'],
            'body'        => ['nullable', 'string'],
            'is_pinned'   => ['nullable', 'boolean'],
        ];
    }
}
