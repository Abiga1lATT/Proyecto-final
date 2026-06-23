<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(RolePermissionSeeder::class);

        $usuarios = \App\Models\User::factory(4)->create();

        $todos = \App\Models\User::all();

        $labels = \App\Models\Label::factory(5)->create();

        \App\Models\Project::factory(4)
            ->recycle($todos)
            ->create()
            ->each(function ($project) use ($todos, $labels) {
                $project->members()->attach(
                    $todos->random(3)->pluck('id'),
                    ['project_role' => 'colaborador']
                );

                \App\Models\Task::factory(5)
                    ->recycle($todos)
                    ->create(['project_id' => $project->id])
                    ->each(function ($task) use ($todos, $labels) {
                        \App\Models\Comment::factory(2)
                            ->recycle($todos)
                            ->create(['task_id' => $task->id]);

                        $task->labels()->attach(
                            $labels->random(rand(1, 2))->pluck('id')
                        );
                    });
            });
    }   
}
