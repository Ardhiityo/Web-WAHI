<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::create([
            'name' => 'owner',
        ]);
        Role::create([
            'name' => 'cashier',
        ]);
        Role::create([
            'name' => 'customer',
        ]);

        Permission::create([
            'name' => 'brand.index'
        ])->assignRole(['owner', 'customer', 'cashier']);
        Permission::create([
            'name' => 'brand.create'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'brand.store'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'brand.edit'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'brand.update'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'brand.delete'
        ])->assignRole('owner');

        Permission::create([
            'name' => 'cart.index'
        ])->assignRole(['cashier', 'customer']);
        Permission::create([
            'name' => 'cart.store'
        ])->assignRole(['cashier', 'customer']);
        Permission::create([
            'name' => 'cart.edit'
        ])->assignRole(['cashier', 'customer']);
        Permission::create([
            'name' => 'cart.update'
        ])->assignRole(['cashier', 'customer']);
        Permission::create([
            'name' => 'cart.destroy'
        ])->assignRole(['cashier', 'customer']);

        User::create([
            'name' => 'Johnson',
            'email' => 'owner@test',
            'password' => 11111111
        ])->assignRole('owner');

        User::create([
            'name' => 'Liana',
            'email' => 'cashier@test',
            'password' => 11111111
        ])->assignRole('cashier');

        User::create([
            'name' => 'Diana',
            'email' => 'customer@test',
            'password' => 11111111
        ])->assignRole('customer');
    }
}
