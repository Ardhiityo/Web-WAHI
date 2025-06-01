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
            'price' => ['required', 'numeric'],
            'stock' => ['required', 'integer', 'min:0'],
            'brand' => ['required', 'exists:brands,id'],
        ];
    }
}
