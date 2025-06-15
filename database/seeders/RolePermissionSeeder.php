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
            'name' => 'brand.destroy'
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

        Permission::create([
            'name' => 'checkout.index'
        ])->assignRole(['cashier', 'customer']);

        Permission::create([
            'name' => 'discount.create'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'discount.store'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'discount.edit'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'discount.update'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'discount.destroy'
        ])->assignRole('owner');

        Permission::create([
            'name' => 'product.create'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'product.store'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'product.edit'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'product.update'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'product.destroy'
        ])->assignRole('owner');

        Permission::create([
            'name' => 'product.transaction.update'
        ])->assignRole('cashier');
        Permission::create([
            'name' => 'product.transaction.destroy'
        ])->assignRole('cashier');

        Permission::create([
            'name' => 'profit.index'
        ])->assignRole('owner');

        Permission::create([
            'name' => 'report.index'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'report.export'
        ])->assignRole('owner');

        Permission::create([
            'name' => 'role.index'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'role.create'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'role.edit'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'role.update'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'role.store'
        ])->assignRole('owner');
        Permission::create([
            'name' => 'role.destroy'
        ])->assignRole('owner');


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
