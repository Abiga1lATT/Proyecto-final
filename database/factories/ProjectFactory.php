<?php

namespace Database\Factories;

use App\Models\Project;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Project>
 */
class ProjectFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'nombre' => fake()->sentence(3),
        'descripcion' => fake()->paragraph(),
        'estado' => fake()->randomElement(['activo', 'pausado', 'finalizado']),
        'owner_id' => \App\Models\User::factory(),
    ];
}

}
