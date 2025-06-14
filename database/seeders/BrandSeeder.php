<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Brand::insert([
            [
                'name' => 'Fiesta',
            ],
            [
                'name' => 'So-Good',
            ],
            [
                'name' => 'Belfoods',
            ],
            [
                'name' => 'SunnyGold',
            ],
            [
                'name' => 'Cedea',
            ],
            [
                'name' => 'Minaku',
            ],
            [
                'name' => 'Sakana',
            ],
            [
                'name' => 'Ayoma',
            ],
            [
                'name' => 'Champ',
            ],
        ]);
    }
}
