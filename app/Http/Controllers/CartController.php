<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use App\Services\Interfaces\CartInterface;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;

class CartController extends Controller
{
    use AuthorizesRequests;

    public function __construct(private CartInterface $cartRepository) {}

    public function index()
    {
        $this->authorize('cart.index');

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
        $this->authorize('cart.index');

        return view('pages.cart.edit', compact('cart'));
    }

    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        return redirect()->route('carts.index')->withSuccess('Berhasil diubah');
    }

    public function destroy(Cart $cart)
    {
        $this->authorize('cart.destroy');

        $cart->delete();

        return redirect()->route('carts.index')->withSuccess('Berhasil dihapus');
    }
}
