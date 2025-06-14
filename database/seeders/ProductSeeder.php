<?php

namespace Database\Seeders;

use App\Models\Brand;
use App\Models\Product;
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

    public function getBrandId($brandName): int
    {
        return Brand::where('name', $brandName)->first()->id;
    }

    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Crispy Chicken',
                'image' => $this->generateImagePath('dist/img/belfoods.png'),
                'purchase_price' => 23000,
                'price' => 40000,
                'stock' => 39,
                'brand_id' => $this->getBrandId('Belfoods')
            ],
            [
                'name' => 'Naget Ayam',
                'image' => $this->generateImagePath('dist/img/fiesta.jpeg'),
                'purchase_price' => 20000,
                'price' => 32000,
                'stock' => 36,
                'brand_id' => $this->getBrandId('Fiesta')
            ],
            [
                'name' => 'Chicken Meatball',
                'image' => $this->generateImagePath('dist/img/so-good.jpeg'),
                'purchase_price' => 35000,
                'price' => 37000,
                'stock' => 25,
                'brand_id' => $this->getBrandId('So-Good')
            ],
            [
                'name' => 'Bola Lobster',
                'image' => $this->generateImagePath('dist/img/minaku.jpeg'),
                'purchase_price' => 22000,
                'price' => 37000,
                'stock' => 27,
                'brand_id' => $this->getBrandId('Minaku')
            ],
            [
                'name' => 'Otak-otak Ikan',
                'image' => $this->generateImagePath('dist/img/sakana1.png'),
                'purchase_price' => 21000,
                'price' => 45000,
                'stock' => 28,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Empek-empek Ikan',
                'image' => $this->generateImagePath('dist/img/sakana2.png'),
                'purchase_price' => 23000,
                'price' => 44000,
                'stock' => 29,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Bakso Ikan Super',
                'image' => $this->generateImagePath('dist/img/sakana3.png'),
                'purchase_price' => 21000,
                'price' => 47500,
                'stock' => 42,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Siomay Ikan',
                'image' => $this->generateImagePath('dist/img/sakana4.png'),
                'purchase_price' => 21500,
                'price' => 45000,
                'stock' => 38,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Bakso Sapi Premium',
                'image' => $this->generateImagePath('dist/img/belfoods2.png'),
                'purchase_price' => 21500,
                'price' => 45000,
                'stock' => 21,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Kulit Ayam Pedas',
                'image' => $this->generateImagePath('dist/img/champ.jpg'),
                'purchase_price' => 18000,
                'price' => 33000,
                'stock' => 40,
                'brand_id' => $this->getBrandId('Champ')
            ],
            [
                'name' => 'Nugget Pedas Level 5',
                'image' => $this->generateImagePath('dist/img/champ2.jpg'),
                'purchase_price' => 18000,
                'price' => 33000,
                'stock' => 40,
                'brand_id' => $this->getBrandId('Champ')
            ]
        ]);
    }
}
