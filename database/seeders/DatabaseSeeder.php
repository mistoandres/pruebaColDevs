<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Tours;
use App\Models\Reservas;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        // Genera datos de prueba para tours
        Tours::factory(10)->create();

        // Genera datos de prueba para reservas
        Reservas::factory(20)->create();
    }
}
