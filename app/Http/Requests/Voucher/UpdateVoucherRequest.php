<?php

namespace App\Http\Requests\Voucher;

use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Http\FormRequest;

class UpdateVoucherRequest extends FormRequest
{
    protected function prepareForValidation()
    {
        Log::info($this->discount);
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
            'product_id' => ['required', 'exists:products,id', Rule::unique('discounts', 'product_id')->ignore($this->route('discount'))],
            'untill_date' => ['required', 'after:yesterday']
        ];
    }
}
