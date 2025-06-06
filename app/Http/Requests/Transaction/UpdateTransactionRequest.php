<?php

namespace App\Http\Requests\Transaction;

use App\Rules\UpdateStatusTransactionRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_type' => ['required', 'in:cashless,cash'],
            'transaction_status' => ['required', 'in:paid,pending', new UpdateStatusTransactionRule(request('transaction'))]
        ];
    }
}
