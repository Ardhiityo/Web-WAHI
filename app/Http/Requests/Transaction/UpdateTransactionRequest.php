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
            'subtotal_amount' => ['required', 'integer', 'min:0'],
            'transaction_type' => ['required', 'in:cashless,cash'],
            'total_amount' => ['required', 'integer', 'min:0'],
            'transaction_status' => ['required', 'in:paid,pending']
        ];
    }
}
