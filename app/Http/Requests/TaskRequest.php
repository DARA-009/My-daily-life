<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TaskRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => ['nullable', 'exists:categories,id'],
            'kind'             => ['nullable', 'in:personal,work,study'],
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'priority'         => ['nullable', 'in:low,medium,high'],
            'due_date'         => ['nullable', 'date'],
            'status'           => ['nullable', 'in:pending,in_progress,completed'],
            'progress_percent' => ['nullable', 'integer', 'between:0,100'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'kind'             => $this->input('kind', 'personal'),
            'priority'         => $this->input('priority', 'medium'),
            'status'           => $this->input('status', 'pending'),
            'progress_percent' => (int) $this->input('progress_percent', 0),
        ]);
    }
}
