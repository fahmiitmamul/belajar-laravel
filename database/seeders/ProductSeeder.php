<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $product = new Product;
        $product->id = 'Product 1';
        $product->name = 'Product 1';
        $product->description = 'Product 1 Description';
        $product->price = 10000;
        $product->category_id = 'FOOD';
        $product->save();
    }
}
