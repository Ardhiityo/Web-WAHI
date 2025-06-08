<?php

namespace App\Rules;

use App\Models\ProductTransaction;
use App\Models\Transaction;
use Closure;
use Illuminate\Contracts\Validation\ValidationRule;

class DeleteProductTransactionRule implements ValidationRule
{
    /**
     * Run the validation rule.
     *
     * @param  \Closure(string, ?string=): \Illuminate\Translation\PotentiallyTranslatedString  $fail
     */
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        $transaction = Transaction::find($value);
        if ($transaction->products()->count() < 2) {
            $fail('Produk yang dibeli tidak boleh kurang dari 1');
        }
    }
}
