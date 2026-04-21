<?php

// database/factories/ClienteFactory.php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class ClienteFactory extends Factory
{
    public function definition(): array
    {
        return [
            'nombre'    => fake()->firstName(),
            'apellidos' => fake()->lastName() . ' ' . fake()->lastName(),
            'email'     => fake()->unique()->safeEmail(),
            'telefono'  => fake()->numerify('6## ### ###'), // formato móvil español
        ];
    }
}
