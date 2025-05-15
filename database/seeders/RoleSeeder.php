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
            'name' => 'admin',
        ]);
        Role::create([
            'name' => 'cashier',
        ]);
        Role::create([
            'name' => 'visitor',
        ]);

        User::create([
            'name' => 'Johnson',
            'email' => 'admin@test',
            'password' => 12345678
        ])->assignRole('admin');

        User::create([
            'name' => 'Liana',
            'email' => 'cashier@test',
            'password' => 12345678
        ])->assignRole('cashier');
    }
}
