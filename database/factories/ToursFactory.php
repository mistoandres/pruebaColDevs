<?php

namespace Database\Factories;

use App\Models\Tours;
use Illuminate\Database\Eloquent\Factories\Factory;

class ToursFactory extends Factory
{
    protected $model = Tours::class;

    public function definition()
    {
        return [
            'nombre' => $this->faker->sentence(3),
            'descripcion' => $this->faker->paragraph(3),
            'fecha' => $this->faker->date(),
            'precio' => $this->faker->randomFloat(2, 50, 500),
        ];
    }
}

