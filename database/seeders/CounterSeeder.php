<?php

namespace Database\Seeders;

use App\Models\Counter;
use Illuminate\Database\Seeder;

class CounterSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $counter = new Counter;
        $counter->id = 'sample';
        $counter->counter = 0;
        $counter->save();
    }
}
