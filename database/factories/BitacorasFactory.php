<?php

namespace Database\Factories;

use App\Models\Usuarios;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Bitacoras>
 */
class BitacorasFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'bitacora' => $this->faker->word,
            'fecha' => now()->toDateString(),
            'hora' => now()->toTimeString(),
        ];
    }
}
