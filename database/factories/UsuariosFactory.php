<?php

namespace Database\Factories;

use App\Models\Persona;
use App\Models\Roles;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Usuarios>
 */
class UsuariosFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $rol = Roles::inRandomOrder()->first() ?? Roles::factory()->create();
        return [
            'primerNombre' => 'admin1',
            'segundoNombre' => 'admin2',
            'primerApellido' => 'administrador1',
            'segundoApellido' => 'administrador2',
            'usuario' => 'admin@admin',
            'password' => Hash::make('123'),
            'estado' => true,
            'idRol' => $rol->id,
        ];
    }
}
