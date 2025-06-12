<?php

namespace App\Http\Requests\Product;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'min:3', Rule::unique('products', 'name')->ignore($this->product->id)],
            'purchase_price' => ['required', 'numeric', 'lt:price'],
            'price' => ['required', 'numeric', 'gt:purchase_price'],
            'stock' => ['required', 'integer', 'min:0'],
            'brand_id' => ['required', 'exists:brands,id'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ];
    }
}
