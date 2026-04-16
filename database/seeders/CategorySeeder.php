<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('categories')->insert([
            'id' => 'SMARTPHONE',
            'name' => 'Smartphone',
            'description' => 'Smartphone',
            'created_at' => '2020-10-10 10:10:10',
        ]);
        DB::table('categories')->insert([
            'id' => 'FOOD',
            'name' => 'Food',
            'description' => 'Food',
            'created_at' => '2020-10-10 10:10:10',
        ]);
        DB::table('categories')->insert([
            'id' => 'LAPTOP',
            'name' => 'Laptop',
            'description' => 'Laptop',
            'created_at' => '2020-10-10 10:10:10',
        ]);
        DB::table('categories')->insert([
            'id' => 'FASHION',
            'name' => 'Fashion',
            'description' => 'Fashion',
            'created_at' => '2020-10-10 10:10:10',
        ]);
    }
}
