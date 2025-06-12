<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\CartInterface;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;

class CartController extends Controller
{
    public function __construct(private CartInterface $cartRepository) {}

    public function index()
    {
        if (Auth::user()->hasRole('owner')) {
            return abort(403, message: 'Unauthorized action.');
        }

        $carts = $this->cartRepository->getAllCarts();

        return view('pages.cart.index', compact('carts'));
    }

    public function store(StoreCartRequest $request)
    {
        $data = $request->validated();

        $this->cartRepository->createCart($data);

        return redirect()->route('products.index')->withSuccess('Berhasil ditambahkan');
    }

    public function edit(Cart $cart)
    {
        if (Auth::user()->hasRole('owner')) {
            return abort(403, 'Unauthorized action.');
        }

        return view('pages.cart.edit', compact('cart'));
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        return redirect()->route('carts.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index')->withSuccess('Berhasil dihapus');
    }
}
