<?php

namespace Database\Factories;

use App\Models\Label;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Label>
 */
class LabelFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'nombre' => fake()->randomElement(['Bug', 'Mejora', 'Urgente', 'Documentación', 'Diseño']),
        'color' => fake()->hexColor(),
    ];
}


}
