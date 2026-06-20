<?php

namespace Database\Factories;

use App\Models\Task;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Task>
 */
class TaskFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
{
    return [
        'project_id' => \App\Models\Project::factory(),
        'assignee_id' => null,
        'titulo' => fake()->sentence(4),
        'descripcion' => fake()->paragraph(),
        'estado' => fake()->randomElement(['pendiente', 'en_progreso', 'completada']),
        'prioridad' => fake()->randomElement(['baja', 'media', 'alta']),
        'due_date' => fake()->dateTimeBetween('now', '+1 month'),
    ];
}

}
