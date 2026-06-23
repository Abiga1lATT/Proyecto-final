<?php

namespace Database\Seeders;

use App\Models\Project;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolePermissionSeeder extends Seeder
{
    public function run(): void
    {
        app(PermissionRegistrar::class)->forgetCachedPermissions();

        // 1) Permisos
        $permisos = [
            'ver proyecto', 'crear proyecto', 'editar proyecto',
            'eliminar proyecto', 'gestionar miembros',
            'crear tarea', 'asignar tarea', 'comentar',
            'gestionar usuarios',
        ];

        foreach ($permisos as $permiso) {
            Permission::firstOrCreate(['name' => $permiso]);
        }

        // 2) Roles con sus permisos
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $admin->syncPermissions(Permission::all());

        $lider = Role::firstOrCreate(['name' => 'lider']);
        $lider->syncPermissions([
            'ver proyecto', 'crear proyecto', 'editar proyecto',
            'gestionar miembros', 'crear tarea', 'asignar tarea', 'comentar',
        ]);

        $colaborador = Role::firstOrCreate(['name' => 'colaborador']);
        $colaborador->syncPermissions([
            'ver proyecto', 'crear tarea', 'comentar',
        ]);

        $invitado = Role::firstOrCreate(['name' => 'invitado']);
        $invitado->syncPermissions([
            'ver proyecto', 'comentar',
        ]);

        // 3) Usuarios de prueba con cada rol
        $admin_user = User::firstOrCreate(
            ['email' => 'admin@gestorpro.com'],
            ['name' => 'Administrador', 'password' => bcrypt('password')]
        );
        $admin_user->assignRole('admin');

        $lider_user = User::firstOrCreate(
            ['email' => 'lider@gestorpro.com'],
            ['name' => 'Lider Proyecto', 'password' => bcrypt('password')]
        );
        $lider_user->assignRole('lider');

        $colaborador_user = User::firstOrCreate(
            ['email' => 'colaborador@gestorpro.com'],
            ['name' => 'Colaborador Uno', 'password' => bcrypt('password')]
        );
        $colaborador_user->assignRole('colaborador');

        $invitado_user = User::firstOrCreate(
            ['email' => 'invitado@gestorpro.com'],
            ['name' => 'Invitado Cliente', 'password' => bcrypt('password')]
        );
        $invitado_user->assignRole('invitado');
    }
}