<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Http\FormRequest;

class StoreVoucherRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return Gate::allows('discount.store');
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'discount' => ['required', 'numeric', 'min:1', 'max:100'],
            'product_id' => ['required', 'exists:products,id', 'unique:discounts,product_id'],
            'untill_date' => ['required', 'after:yesterday']
        ];
    }
}
