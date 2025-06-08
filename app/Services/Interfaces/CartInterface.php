<?php

namespace App\Services\Interfaces;

interface CartInterface
{
    public function getAllCarts();
    public function createCart(array $data);
    public function getTotalCarts();
    public function getCartsByUserId(int $userId);
    public function deleteCartsByUserId(int $userId);
}
