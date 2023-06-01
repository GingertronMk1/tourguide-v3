<?php

namespace Database\Seeders;

use App\Models\DealType;
use Illuminate\Database\Seeder;

class DealTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DealType::factory()->count(5)->create();
    }
}
