<?php

namespace App\Http\Requests\Transaction;

use App\Rules\CheckoutRule;
use Illuminate\Foundation\Http\FormRequest;
use Ulid\Ulid;

class StoreTransactionRequest extends FormRequest
{
    public function prepareForValidation()
    {
        $this->merge([
            'transaction_code' => 'WAHI-' . Ulid::generate()
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_code' => ['required', new CheckoutRule, 'unique:transactions,transaction_code'],
            'transaction_type' => ['required', 'in:cashless,cash'],
        ];
    }
}
