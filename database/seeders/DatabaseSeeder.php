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
        $usuarios = \App\Models\User::factory(6)->create();

        $labels = \App\Models\Label::factory(5)->create();

        \App\Models\Project::factory(4)
            ->recycle($usuarios)
            ->create()
            ->each(function ($project) use ($usuarios, $labels) {
                $project->members()->attach(
                    $usuarios->random(3)->pluck('id'),
                    ['project_role' => 'colaborador']
                );

                \App\Models\Task::factory(5)
                    ->recycle($usuarios)
                    ->create(['project_id' => $project->id])
                    ->each(function ($task) use ($usuarios, $labels) {
                        \App\Models\Comment::factory(2)
                            ->recycle($usuarios)
                            ->create(['task_id' => $task->id]);

                        $task->labels()->attach(
                            $labels->random(rand(1, 2))->pluck('id')
                        );
                    });
            });
    }
}
