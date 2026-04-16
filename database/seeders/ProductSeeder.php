<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            'id' => 'Product 1',
            'name' => 'Product 1',
            'description' => 'Product 1 Description',
            'price' => 10000,
            'category_id' => 'FOOD',
        ]);
    }
}
