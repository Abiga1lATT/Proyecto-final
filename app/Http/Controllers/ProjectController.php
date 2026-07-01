<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function index(Request $request): View
    {
        $user = auth()->user();

        $query = $user->hasRole('admin')
            ? Project::with('owner')
            : Project::with('owner')->where(function ($q) use ($user) {
                $q->where('owner_id', $user->id)
                    ->orWhereHas('members', fn($q) => $q->where('users.id', $user->id));
            });

        if ($request->filled('estado')) {
            $query->where('estado', $request->estado);
        }

        if ($request->filled('buscar')) {
            $query->where('nombre', 'ilike', '%' . $request->buscar . '%');
        }

        $projects = $query->latest()->paginate(10)->withQueryString();

        return view('projects.index', compact('projects'));
    }
    public function create(): View
    {
        $this->authorize('create', Project::class);
        return view('projects.create');
    }

    public function store(StoreProjectRequest $request): RedirectResponse
    {
        $this->authorize('create', Project::class);

        $project = Project::create([
            ...$request->validated(),
            'owner_id' => auth()->id(),
        ]);

        $project->members()->attach(auth()->id(), ['project_role' => 'lider']);

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto creado correctamente.');
    }

    public function show(Project $project, Request $request): View
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members']);

        $tasksQuery = $project->tasks()->with(['assignee', 'labels']);

        if ($request->filled('estado')) {
            $tasksQuery->where('estado', $request->estado);
        }

        if ($request->filled('prioridad')) {
            $tasksQuery->where('prioridad', $request->prioridad);
        }

        $tasks = $tasksQuery->latest()->paginate(10, ['*'], 'tasks_page')
            ->withQueryString();

        return view('projects.show', compact('project', 'tasks'));
    }

    public function edit(Project $project): View
    {
        $this->authorize('update', $project);
        return view('projects.edit', compact('project'));
    }

    public function update(UpdateProjectRequest $request, Project $project): RedirectResponse
    {
        $this->authorize('update', $project);
        $project->update($request->validated());

        return redirect()->route('projects.show', $project)
            ->with('success', 'Proyecto actualizado correctamente.');
    }

    public function destroy(Project $project): RedirectResponse
    {
        $this->authorize('delete', $project);
        $project->delete();

        return redirect()->route('projects.index')
            ->with('success', 'Proyecto eliminado correctamente.');
    }
}
