<?php

namespace App\Http\Controllers;

use Midtrans\Snap;
use App\Models\Cart;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Models\ProductTransaction;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\Cart\StoreCartRequest;
use App\Http\Requests\Cart\UpdateCartRequest;
use App\Http\Requests\Checkout\StoreCheckoutRequest;
use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Http\Request;

class CartController extends Controller
{

    public function __construct()
    {
        // Set your Merchant Server Key
        \Midtrans\Config::$serverKey = config('midtrans.server_key');
        // Set to Development/Sandbox Environment (default). Set to true for Production Environment (accept real transaction).
        \Midtrans\Config::$isProduction = config('midtrans.is_production');
        // Set sanitization on (default)
        \Midtrans\Config::$isSanitized = config('midtrans.is_sanitized');
        // Set 3DS transaction for credit card to true
        \Midtrans\Config::$is3ds = config('midtrans.is_3ds');
    }

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

        return redirect()->route('products.index')->withSuccess('Berhasil ditambahkan');
    }

    public function checkout()
    {
        $carts = Cart::where('user_id', Auth::user()->id)->get();

        foreach ($carts as $key => $cart) {
            if ($cart->quantity > $cart->product->stock) {
                return redirect()->route('carts.index')->with('error', 'Produk yang dibeli melebihi stok produk');
            }
        }

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

        try {
            DB::beginTransaction();

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
            };
            if ($transaction->transaction_type == 'cash') {
                Cart::where('user_id', Auth::user()->id)->delete();
            }
            DB::commit();
            return view('pages.checkout-detail.index', compact(
                'transaction',
            ));
        } catch (\Throwable $th) {
            DB::rollBack();

            return redirect()->route('carts.index')->with('error', $th->getMessage());
        }
    }

    public function getSnapToken(Request $request)
    {
        $transaction = Transaction::where('transaction_code', $request->transaction_code)->first();

        $params = [
            'transaction_details' => [
                'order_id' => $transaction->transaction_code,
                'gross_amount' => $transaction->total_amount
            ]
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'token' => $snapToken
        ]);
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
        return view('pages.cart.edit', compact('cart'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        return redirect()->route('carts.index')->withSuccess('Berhasil diubah');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Cart $cart)
    {
        $cart->delete();

        return redirect()->route('carts.index')->withSuccess('Berhasil dihapus');
    }
}
