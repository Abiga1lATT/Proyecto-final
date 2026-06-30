<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTaskRequest;
use App\Http\Requests\UpdateTaskRequest;
use App\Models\Label;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TaskController extends Controller
{
    public function create(Project $project): View
    {
        $this->authorize('create', [Task::class, $project]);
        $members = $project->members;
        $labels = Label::all();
        return view('tasks.create', compact('project', 'members', 'labels'));
    }

    public function store(StoreTaskRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('create', [Task::class, $project]);

        $task = $project->tasks()->create($request->safe()->except('labels'));

        if ($request->filled('labels')) {
            $task->labels()->sync($request->labels);
        }

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tarea creada correctamente.');
    }

    public function show(Task $task): View
    {
        $this->authorize('view', $task);
        $task->load(['assignee', 'labels', 'comments.user', 'project']);
        return view('tasks.show', compact('task'));
    }

    public function edit(Task $task): View
    {
        $this->authorize('update', $task);
        $members = $task->project->members;
        $labels = Label::all();
        return view('tasks.edit', compact('task', 'members', 'labels'));
    }

    public function update(UpdateTaskRequest $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);
        $task->update($request->safe()->except('labels'));

        if ($request->has('labels')) {
            $task->labels()->sync($request->labels ?? []);
        }

        return redirect()->route('tasks.show', $task)
            ->with('success', 'Tarea actualizada correctamente.');
    }

    public function destroy(Task $task): RedirectResponse
    {
        $this->authorize('delete', $task);
        $project = $task->project;
        $task->delete();

        return redirect()->route('projects.show', $project)
            ->with('success', 'Tarea eliminada correctamente.');
    }

    public function status(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('update', $task);
        $request->validate([
            'estado' => ['required', 'in:pendiente,en_progreso,completada'],
        ]);
        $task->update(['estado' => $request->estado]);

        return back()->with('success', 'Estado actualizado.');
    }

    public function assign(Request $request, Task $task): RedirectResponse
    {
        $this->authorize('assign', $task);
        $request->validate([
            'assignee_id' => ['nullable', 'exists:users,id'],
        ]);
        $task->update(['assignee_id' => $request->assignee_id]);

        return back()->with('success', 'Responsable asignado.');
    }
}