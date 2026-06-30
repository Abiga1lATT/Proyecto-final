<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use App\Models\Project;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $user = auth()->user();

        $projects = $user->hasRole('admin')
            ? Project::with('owner')->latest()->paginate(10)
            : Project::with('owner')
                ->where(function ($q) use ($user) {
                    $q->where('owner_id', $user->id)
                      ->orWhereHas('members', fn($q) => $q->where('users.id', $user->id));
                })
                ->latest()
                ->paginate(10);

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

    public function show(Project $project): View
    {
        $this->authorize('view', $project);

        $project->load(['owner', 'members', 'tasks.assignee', 'tasks.labels']);

        return view('projects.show', compact('project'));
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