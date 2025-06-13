<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use App\Services\Interfaces\CartInterface;
use App\Services\Interfaces\RoleInterface;
use App\Services\Interfaces\BrandInterface;
use App\Services\Interfaces\DiscountInterface;
use App\Services\Interfaces\ProductInterface;
use App\Services\Interfaces\TransactionInterface;

class DashboardService
{
    public function __construct(
        private RoleInterface $roleRepository,
        private BrandInterface $brandRepository,
        private ProductInterface $productRepository,
        private CartInterface $cartRepository,
        private DiscountInterface $discountRepository,
        private TransactionInterface $transactionRepository
    ) {}

    public function getDashboardData()
    {
        $customers = $this->roleRepository->getTotalCustomers();
        $cashiers = $this->roleRepository->getTotalCashiers();
        $brands = $this->brandRepository->getTotalBrands();
        $products = $this->productRepository->getTotalProducts();
        $carts = $this->cartRepository->getTotalCarts();
        $discounts = $this->discountRepository->getTotalDiscount();

        if (Auth::user()->hasRole('customer')) {
            $pendingTransactions = $this->transactionRepository->getTotalTransactionsByUser('pending');
            $paidTransactions = $this->transactionRepository->getTotalTransactionsByUser('paid');
        } else {
            $pendingTransactions = $this->transactionRepository->getTotalTransactionsByStatus('pending');
            $paidTransactions = $this->transactionRepository->getTotalTransactionsByStatus('paid');
        }

        return compact(
            'customers',
            'cashiers',
            'brands',
            'products',
            'carts',
            'discounts',
            'pendingTransactions',
            'paidTransactions'
        );
    }
}
