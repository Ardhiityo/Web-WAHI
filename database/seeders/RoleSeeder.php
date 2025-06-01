<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
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
