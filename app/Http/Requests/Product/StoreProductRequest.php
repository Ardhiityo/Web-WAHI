<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'unique:products,name', 'min:3'],
            'image' => ['required', 'mimes:jpg,png,jpeg', 'max:2048'],
            'purchase_price' => ['required', 'numeric', 'lt:price'],
            'price' => ['required', 'numeric', 'gt:purchase_price'],
            'stock' => ['required', 'integer', 'min:0'],
            'brand_id' => ['required', 'exists:brands,id'],
        ];
    }
}
