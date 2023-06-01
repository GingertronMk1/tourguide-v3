<?php

namespace Database\Seeders;

use App\Models\AccessEquipment;
use Illuminate\Database\Seeder;

class AccessEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AccessEquipment::factory()->count(5)->create();
    }
}
