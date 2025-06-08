<?php

namespace App\Services\Repositories;

use App\Models\User;
use App\Services\Interfaces\RoleInterface;

class RoleRepository implements RoleInterface
{
    public function getTotalCustomers()
    {
        return User::role('customer')->count();
    }

    public function getTotalCashiers()
    {
        return User::role('cashier')->count();
    }
}
