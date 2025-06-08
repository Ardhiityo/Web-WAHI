<?php

namespace App\Services\Repositories;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\CartInterface;

class CartRepository implements CartInterface
{
    public function getAllCarts()
    {
        return Cart::with('product:id,name,image,price,stock')->select('id', 'product_id', 'quantity')
            ->where('user_id', Auth::user()->id)
            ->paginate(10);
    }

    public function createCart(array $data)
    {
        try {
            $cart = Cart::where('user_id', Auth::user()->id)
                ->where('product_id', $data['product_id'])
                ->firstOrFail();

            return $cart->update([
                'quantity' => $cart->quantity + $data['quantity']
            ]);
        } catch (\Throwable $th) {
            return Cart::create($data);
        }
    }
}
