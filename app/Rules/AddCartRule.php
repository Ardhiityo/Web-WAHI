<?php

namespace App\Rules;

use Closure;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Contracts\Validation\ValidationRule;

class AddCartRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productId = request('product_id');
        $product = Product::find($productId);
        $cartProduct = Cart::where('product_id', $productId)->first();
        if ($cartProduct) {
            if ($cartProduct->quantity >= $product->stock) {
                $fail('Tidak bisa menambahkan product melebihi stock produk');
            }
        }
    }
}
