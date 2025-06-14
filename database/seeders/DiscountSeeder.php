<?php

namespace Database\Seeders;

use App\Models\Discount;
use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DiscountSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $productId1 = Product::where('name', 'Siomay Ikan')->first()->id;
        $productId2 = Product::where('name', 'Bakso Ikan Super')->first()->id;
        $productId3 = Product::where('name', 'Otak-otak Ikan')->first()->id;

        Discount::insert([
            [
                'product_id' => $productId1,
                'untill_date' => now()->addDays(5),
                'discount' => 8
            ],
            [
                'product_id' => $productId2,
                'untill_date' => now()->addDays(5),
                'discount' => 5
            ],
            [
                'product_id' => $productId3,
                'untill_date' => now()->addDays(5),
                'discount' => 3
            ],
        ]);
    }
}
