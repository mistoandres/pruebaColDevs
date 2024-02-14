<?php

namespace Database\Factories;

use App\Models\Reservas;
use App\Models\Tours;
use Illuminate\Database\Eloquent\Factories\Factory;

class ReservasFactory extends Factory
{
    protected $model = Reservas::class;

    public function definition()
    {
        return [
            'id_tour' => Tours::factory(),
            'usuario' => $this->faker->name(),
            'fecha_reserva' => $this->faker->date(),
            'cantidad_personas' => $this->faker->numberBetween(1, 10),
        ];
    }
}

