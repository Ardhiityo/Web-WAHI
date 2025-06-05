<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class UpdateStatusTransactionRule implements ValidationRule
{
    public function __construct(private $transaction) {}

    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        foreach ($this->transaction->products as $key => $product) {
            if ($product->pivot->quantity > $product->stock) {
                $fail('Produk yang dibeli melebihi stock product');
            }
        }
    }
}
