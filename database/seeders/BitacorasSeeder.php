<?php

namespace Database\Seeders;

use App\Models\Bitacoras;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BitacorasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Bitacoras::factory()->create();
    }
}
