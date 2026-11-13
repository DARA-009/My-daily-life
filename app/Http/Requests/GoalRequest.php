<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GoalRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title'            => ['required', 'string', 'max:255'],
            'description'      => ['nullable', 'string'],
            'target_year'      => ['required', 'integer', 'between:2020,2100'],
            'target_month'     => ['required', 'integer', 'between:1,12'],
            'start_date'       => ['required', 'date'],
            'deadline'         => ['required', 'date', 'after_or_equal:start_date'],
            'priority'         => ['required', 'in:low,medium,high'],
            'progress_percent' => ['nullable', 'integer', 'between:0,100'],
            'status'           => ['nullable', 'in:pending,in_progress,completed,cancelled'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'target_year'      => (int) $this->input('target_year', now()->year),
            'target_month'     => (int) $this->input('target_month', now()->month),
            'start_date'       => $this->input('start_date', now()->toDateString()),
            'priority'         => $this->input('priority', 'medium'),
            'progress_percent' => (int) $this->input('progress_percent', 0),
            'status'           => $this->input('status', 'in_progress'),
        ]);
    }
}
