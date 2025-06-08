<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateCartRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $productStock = request('cart')->product->stock;

        if ($value > $productStock) {
            $fail('Tidak bisa ubah quantity melebihi stock produk');
        }

        if ($value < 1) {
            $fail('Quantity harus lebih dari 0');
        }
    }
}
