<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        $products = [
            ['name' => 'Premium Cat Food 1kg', 'category' => 'makanan', 'price' => 120000, 'stock' => 15, 'description' => 'Makanan kucing kaya nutrisi untuk bulu sehat.'],
            ['name' => 'Dog Food Adult 2kg', 'category' => 'makanan', 'price' => 150000, 'stock' => 20, 'description' => 'Makanan anjing dewasa dengan protein tinggi.'],
            ['name' => 'Cat Litter Sand 5L', 'category' => 'aksesori', 'price' => 45000, 'stock' => 30, 'description' => 'Pasir kucing wangi, mudah menggumpal.'],
            ['name' => 'Pet Shampoo Anti Kutu', 'category' => 'aksesori', 'price' => 35000, 'stock' => 25, 'description' => 'Shampo herbal untuk membasmi kutu pada hewan.'],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(['name' => $product['name']], $product);
        }
    }
}
