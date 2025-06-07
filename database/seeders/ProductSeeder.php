<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Storage;

class ProductSeeder extends Seeder
{
    public function generateImagePath($imagePath): string
    {
        $sourcePath = public_path($imagePath);
        $destinationPath = 'products/' . uniqid() . '.jpg';

        // Copy the image to the storage disk
        Storage::disk('public')->put($destinationPath, file_get_contents($sourcePath));

        return $destinationPath; // This will be accessible via the public URL
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Sosis Ayam',
                'image' => $this->generateImagePath('dist/img/prod-1.jpg'),
                'price' => 23000,
                'stock' => 28,
                'brand_id' => 1,
            ],
            [
                'name' => 'Chicken Nugget',
                'image' => $this->generateImagePath('dist/img/prod-2.jpg'),
                'price' => 35000,
                'stock' => 27,
                'brand_id' => 2,
            ],
            [
                'name' => 'Kornet Ayam',
                'image' => $this->generateImagePath('dist/img/prod-3.jpg'),
                'price' => 33000,
                'stock' => 26,
                'brand_id' => 3,
            ],
            [
                'name' => 'Kornet Sapi',
                'image' => $this->generateImagePath('dist/img/prod-4.jpg'),
                'price' => 35000,
                'stock' => 25,
                'brand_id' => 4,
            ],
            [
                'name' => 'Sosis Sapi',
                'image' => $this->generateImagePath('dist/img/prod-5.jpg'),
                'price' => 25000,
                'stock' => 22,
                'brand_id' => 5,
            ]
        ]);
    }
}
