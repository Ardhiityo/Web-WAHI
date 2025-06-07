<?php

namespace Database\Seeders;

use App\Models\Brand;
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
                'price' => 23000,
                'stock' => 28,
                'brand_id' => $this->getBrandId('Belfoods')
            ],
            [
                'name' => 'Naget Ayam',
                'image' => $this->generateImagePath('dist/img/fiesta.jpeg'),
                'price' => 23000,
                'stock' => 28,
                'brand_id' => $this->getBrandId('Fiesta')
            ],
            [
                'name' => 'Chicken Meatball',
                'image' => $this->generateImagePath('dist/img/so-good.jpeg'),
                'price' => 35000,
                'stock' => 27,
                'brand_id' => $this->getBrandId('So-Good')
            ],
            [
                'name' => 'Bola Lobster',
                'image' => $this->generateImagePath('dist/img/minaku.jpeg'),
                'price' => 33000,
                'stock' => 26,
                'brand_id' => $this->getBrandId('Minaku')
            ],
            [
                'name' => 'Otak-otak Ikan',
                'image' => $this->generateImagePath('dist/img/sakana1.png'),
                'price' => 35000,
                'stock' => 25,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Empek-empek Ikan',
                'image' => $this->generateImagePath('dist/img/sakana2.png'),
                'price' => 25000,
                'stock' => 22,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Bakso Ikan Super',
                'image' => $this->generateImagePath('dist/img/sakana3.png'),
                'price' => 25000,
                'stock' => 22,
                'brand_id' => $this->getBrandId('Sakana')
            ],
            [
                'name' => 'Siomay Ikan',
                'image' => $this->generateImagePath('dist/img/sakana4.png'),
                'price' => 25000,
                'stock' => 22,
                'brand_id' => $this->getBrandId('Sakana')
            ]
        ]);
    }
}
