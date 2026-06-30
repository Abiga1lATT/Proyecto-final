<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Spatie\Permission\Models\Role;

class AdminUserController extends Controller
{
    public function index(): View
    {
        $users = User::with('roles')->paginate(10);
        $roles = Role::all();
        return view('admin.users', compact('users', 'roles'));
    }

    public function assignRole(Request $request, User $user): RedirectResponse
    {
        $request->validate([
            'role' => ['required', 'exists:roles,name'],
        ]);

        $user->syncRoles([$request->role]);

        return back()->with('success', 'Rol asignado correctamente.');
    }
}