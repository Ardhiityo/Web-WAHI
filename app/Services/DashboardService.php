<?php

namespace App\Services;

use App\Models\Cart;
use App\Models\User;
use App\Models\Brand;
use App\Models\Product;
use App\Models\Voucher;
use App\Models\Transaction;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\RoleInterface;
use App\Services\Interfaces\VoucherInterface;
use Illuminate\Support\Facades\Auth;

class DashboardService
{
    public function __construct(
        private RoleInterface $roleRepository,
        private BrandInterface $brandRepository,
        private ProductInterface $productRepository,
        private CartInterface $cartRepository,
        private VoucherInterface $voucherRepository
    ) {}

    public function getDashboardData()
    {
        $customers = $this->roleRepository->getTotalCustomers();
        $cashiers = $this->roleRepository->getTotalCashiers();
        $brands = $this->brandRepository->getTotalBrands();
        $products = $this->productRepository->getTotalProducts();
        $carts = $this->cartRepository->getTotalCarts();
        $vouchers = $this->voucherRepository->getTotalVouchers();

        if (Auth::user()->hasRole('customer')) {
            $pendingTransactions = Transaction::where('user_id', Auth::user()->id)
                ->where('transaction_status', 'pending')->count();
            $paidTransactions = Transaction::where('user_id', Auth::user()->id)
                ->where('transaction_status', 'paid')->count();
        } else {
            $pendingTransactions = Transaction::where('transaction_status', 'pending')->count();
            $paidTransactions = Transaction::where('transaction_status', 'paid')->count();
        }

        return compact(
            'customers',
            'cashiers',
            'brands',
            'products',
            'carts',
            'vouchers',
            'pendingTransactions',
            'paidTransactions'
        );
    }
}
