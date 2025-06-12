<?php

namespace App\Rules;

use Closure;
use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\ValidationRule;

class CheckoutRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $carts = Cart::with('product:id,stock')
            ->select('id', 'product_id', 'quantity')
            ->where('user_id', Auth::user()->id)
            ->get();

        foreach ($carts as $key => $cart) {
            if ($cart->product->stock === 0) {
                $fail('Produk yang dibeli sudah habis');
            } else if ($cart->quantity === 0) {
                $fail('Produk yang dibeli minimal 1');
            } else if ($cart->quantity > $cart->product->stock) {
                $fail('Produk yang dibeli melebihi stok produk');
            }
        }
    }
}
