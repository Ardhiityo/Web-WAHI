<?php

namespace App\Services\Repositories;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Services\Interfaces\RoleInterface;

class RoleRepository implements RoleInterface
{
    public function getAllRoles()
    {
        return User::with('roles:id,name')->select('id', 'name', 'email')->paginate(10);
    }

    public function getTotalCustomers()
    {
        return User::role('customer')->count();
    }

    public function getTotalCashiers()
    {
        return User::role('cashier')->count();
    }

    public function updateRole($role, $data)
    {
        $role->update([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => is_null($data['password']) ? $role->password : Hash::make($data['password']),
        ]);

        $role->removeRole($role->roles->first()->name);
        $role->assignRole($data['role']);
    }
}
