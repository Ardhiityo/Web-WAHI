<?php

namespace App\Http\Controllers;

use App\Http\Requests\Cart\StoreCartRequest;
use App\Models\Cart;
use Illuminate\Http\Request;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::paginate(perPage: 10);

        return view('pages.cart.index', compact('carts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCartRequest $request)
    {
        $data = $request->validated();

        try {
            $cart = Cart::where('product_id', $data['product_id'])->firstOrFail();
            $cart->update([
                'quantity' => $cart->quantity + $data['quantity'],
            ]);
        } catch (\Throwable $th) {
            Cart::create($data);
        }

        return redirect()->route('products.index');
    }

    /**
     * Display the specified resource.
     */
    public function show(Cart $cart)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Cart $cart)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Cart $cart)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index');
    }
}
