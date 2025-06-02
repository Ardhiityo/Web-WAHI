<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Checkout\StoreCheckoutRequest;

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
        return view('pages.checkout.index');
    }

    public function checkoutDetail(StoreCheckoutRequest $request)
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();

        $data = $request->validated();

        $subtotal = 0;
        $discount = null;
        $totalDiscount = 0;
        $discountPercentage = null;

        foreach ($carts as $key => $cart) {
            $subtotal +=  (int)$cart->product->price * (int)$cart->quantity;
        }
        $totalAmount = $subtotal;

        if (!is_null($data['voucher'])) {
            $voucher = Voucher::where('code', $data['voucher'])->first();
            $data['voucher'] = $voucher->id;
            $discount = (int)$voucher->discount / 100;
            $discountPercentage = $voucher->discount;
            $totalDiscount = $subtotal * $discount;
            $totalAmount = $subtotal - $totalDiscount;
        }

        $transaction = Transaction::create(
            [
                'discount' => $totalDiscount,
                'discount_percentage' => $discountPercentage,
                'subtotal_amount' => $subtotal,
                'transaction_code' => $data['transaction_code'],
                'transaction_type' => $data['transaction_type'],
                'voucher_id' => $data['voucher'],
                'total_amount' => $totalAmount,
                'transaction_status' => 'pending',
                'user_id' => Auth::user()->id,
            ]
        );

        if ($transaction->transaction_type == 'cash') {
            DB::beginTransaction();
            try {
                foreach ($carts as $key => $cart) {
                    $product = ProductTransaction::where('product_id', $cart->product_id)
                        ->where('transaction_id', $transaction->id)->first();
                    if ($product) {
                        $product->update(['quantity' => $product->quantity]);
                    } else {
                        ProductTransaction::create([
                            'product_id' => $cart->product_id,
                            'transaction_id' => $transaction->id,
                            'price' => $cart->product->price,
                            'quantity' => $cart->quantity
                        ]);
                    }
                    $product = Product::findOrFail($cart->product_id);
                    if ($product) {
                        $product->stock -= $cart->quantity;
                        $product->save();
                    }
                };
                Cart::where('user_id', Auth::user()->id)->delete();
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollBack();
                return view('pages.checkout-detail.index', compact(
                    'transaction',
                ))->with('error', $th->getMessage());
            }
        } else {
            Session::put('transaction', $transaction);
        }
        Log::info('Masuk');
        Log::info(json_encode($transaction, JSON_PRETTY_PRINT));
        return view('pages.checkout-detail.index', compact(
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
