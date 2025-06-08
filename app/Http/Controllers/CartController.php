<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Services\Interfaces\CartInterface;

class CartController extends Controller
{
    public function __construct(private CartInterface $cartRepository) {}

    public function index()
    {
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
