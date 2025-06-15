<?php

namespace App\Http\Requests\Transaction;

use App\Models\Transaction;
use Illuminate\Support\Facades\Gate;
use App\Rules\UpdateStatusTransactionRule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateTransactionRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('update', Transaction::class);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'transaction_type' => ['required', 'in:cashless,cash'],
            'transaction_status' => ['required', 'in:paid,pending,cancel', new UpdateStatusTransactionRule(request('transaction'))]
        ];
    }
}
