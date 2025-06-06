<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $customers = User::role('customer')->count();
        $cashiers = User::role('cashier')->count();
        $brands = Brand::count();
        $products = Product::count();
        $carts = Cart::where('user_id', Auth::user()->id)->count();
        $vouchers = Voucher::count();

        if (Auth::user()->hasRole('customer')) {
            $pendingTransactions = Transaction::where('user_id', Auth::user()->id)
                ->where('transaction_status', 'pending')->count();
            $paidTransactions = Transaction::where('user_id', Auth::user()->id)
                ->where('transaction_status', 'paid')->count();
        } else {
            $pendingTransactions = Transaction::where('transaction_status', 'pending')->count();
            $paidTransactions = Transaction::where('transaction_status', 'paid')->count();
        }

        return view(
            'dashboard',
            compact(
                'customers',
                'cashiers',
                'brands',
                'products',
                'carts',
                'vouchers',
                'pendingTransactions',
                'paidTransactions'
            )
        );
    }
}
