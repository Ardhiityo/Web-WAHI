<?php

namespace Database\Seeders;

use App\Models\Voucher;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VoucherSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Voucher::insert(
            [
                [
                    'code' => 'SALE50',
                    'discount' => 50,
                ],
                [
                    'code' => 'SALE20',
                    'discount' => 20,
                ],
                [
                    'code' => 'SALE15',
                    'discount' => 15,
                ],
                [
                    'code' => 'SALE10',
                    'discount' => 10,
                ],
                [
                    'code' => 'SALE5',
                    'discount' => 5,
                ],
            ]
        );
    }
}
