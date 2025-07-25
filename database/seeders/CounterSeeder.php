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
        // Create initial counter with value 0
        Counter::firstOrCreate(
            [],
            ['count' => 0]
        );
    }
}