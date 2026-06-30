<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class MemberController extends Controller
{
    public function store(Request $request, Project $project): RedirectResponse
    {
        $this->authorize('manageMembers', $project);

        $request->validate([
            'user_id'      => ['required', 'exists:users,id'],
            'project_role' => ['required', 'in:lider,colaborador,invitado'],
        ]);

        $project->members()->syncWithoutDetaching([
            $request->user_id => ['project_role' => $request->project_role],
        ]);

        return back()->with('success', 'Miembro agregado al proyecto.');
    }

    public function destroy(Project $project, User $user): RedirectResponse
    {
        $this->authorize('manageMembers', $project);
        $project->members()->detach($user->id);

        return back()->with('success', 'Miembro eliminado del proyecto.');
    }
}