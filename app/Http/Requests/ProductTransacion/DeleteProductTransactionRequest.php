<?php

namespace App\Http\Requests\ProductTransacion;

use App\Rules\DeleteProductTransactionRule;
use Illuminate\Foundation\Http\FormRequest;

class DeleteProductTransactionRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_id' => ['required', 'exists:transactions,id', new DeleteProductTransactionRule],
            'product_id' => ['required', 'exists:products,id']
        ];
    }
}
