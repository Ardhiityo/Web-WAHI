<?php

namespace App\Http\Requests\Transaction;

use App\Models\Transaction;
use Ulid\Ulid;
use App\Rules\CheckoutRule;
use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('create', Transaction::class);
    }

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
