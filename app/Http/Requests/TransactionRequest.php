<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TransactionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'category_id'      => ['required', 'exists:categories,id'],
            'type'             => ['required', 'in:income,expense'],
            'amount'           => ['required', 'numeric', 'min:0.01'],
            'currency'         => ['required', 'in:USD,KHR'],
            'transaction_date' => ['required', 'date'],
            'payment_method'   => ['nullable', 'in:cash,bank,card,mobile_wallet,other'],
            'description'      => ['required', 'string', 'max:255'],
            'notes'            => ['nullable', 'string'],
        ];
    }

    protected function prepareForValidation(): void
    {
        $this->merge([
            'payment_method' => $this->input('payment_method', 'cash'),
            'currency'       => $this->input('currency', 'USD'),
        ]);
    }
}
