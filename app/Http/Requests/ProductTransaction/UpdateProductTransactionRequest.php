<?php

namespace App\Http\Requests\ProductTransaction;

use App\Rules\UpdateStatusTransactionRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'exists:transactions,id'],
            'product_id' => ['required', 'exists:products,id'],
            'quantity' => ['required', 'integer', 'min:1', new UpdateStatusTransactionRule($this->transaction_id)]
        ];
    }
}
