<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Checkout\StoreCheckoutRequest;
use Illuminate\Support\Facades\Session;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->paginate(perPage: 10);

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

    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->paginate(perPage: 10);

        return view('pages.checkout.index', compact('carts'));
    }

    public function checkoutDetail(StoreCheckoutRequest $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->paginate(perPage: 10);

        $data = $request->validated();

        $subtotal = 0;
        $totalAmount = $subtotal;
        $discount = null;
        $totalDiscount = 0;
        $discountPercentage = null;

        foreach ($carts as $key => $cart) {
            $subtotal +=  (int)$cart->product->price * (int)$cart->quantity;
        }

        if (!is_null($data['voucher'])) {
            $voucher = Voucher::where('code', $data['voucher'])->first();
            $data['voucher'] = $voucher->id;
            $discount = (int)$voucher->discount / 100;
            $discountPercentage = $voucher->discount;
            $totalDiscount = $subtotal * $discount;
            $totalAmount = $subtotal - $totalDiscount;
        }

        $transaction = Transaction::make(
            [
                'discount' => $totalDiscount,
                'discount_percentage' => $discountPercentage,
                'subtotal_amount' => $subtotal,
                'transaction_code' => $data['transaction_code'],
                'transaction_type' => $data['transaction_type'],
                'voucher' => $data['voucher'],
                'total_amount' => $totalAmount,
                'transaction_status' => 'pending',
                'user_id' => Auth::user()->id,
            ]
        );

        if ($transaction->transaction_type == 'cash') {
            // $transaction->save();
        } else {
            Session::put('transaction', $transaction);
        }

        return view('pages.checkout-detail.index', compact(
            'carts',
            'transaction',
        ));
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
