<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
            [
                'id' => 'SMARTPHONE',
                'name' => 'Smartphone',
                'description' => null,
                'created_at' => '2020-10-10 10:10:10'
            ],
            [
                'id' => 'LAPTOP',
                'name' => 'Laptop',
                'description' => null,
                'created_at' => '2020-10-10 10:10:10'
            ],
            [
                'id' => 'ACCESSORIES',
                'name' => 'Accessories',
                'description' => null,
                'created_at' => '2020-10-10 10:10:10'
            ],
            [
                'id' => 'OTHER',
                'name' => 'Other',
                'description' => null,
                'created_at' => '2020-10-10 10:10:10'
            ],
        ]);
    }
}
