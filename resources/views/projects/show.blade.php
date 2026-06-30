<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $project->nombre }}
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                    {{ $project->estado === 'activo' ? 'bg-green-100 text-green-700' : '' }}
                    {{ $project->estado === 'pausado' ? 'bg-yellow-100 text-yellow-700' : '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-gray-100 text-gray-700' : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
            </h2>
            <div class="flex gap-2">
                @can('update', $project)
                    <a href="{{ route('projects.edit', $project) }}"
                        class="px-4 py-2 bg-amber-500 text-white rounded">Editar</a>
                @endcan
                @can('delete', $project)
                    <form action="{{ route('projects.destroy', $project) }}"
                        method="POST"
                        onsubmit="return confirm('¿Eliminar este proyecto?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-600 text-white rounded">Eliminar</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Descripción --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-2">Descripción</h3>
                <p class="text-gray-600">{{ $project->descripcion ?? 'Sin descripción.' }}</p>
                <p class="mt-2 text-sm text-gray-500">Dueño: {{ $project->owner->name }}</p>
            </div>

            {{-- Miembros --}}
            @can('manageMembers', $project)
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">Miembros</h3>
                <table class="w-full text-left mb-4">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-2 px-3">Usuario</th>
                            <th class="py-2 px-3">Rol en proyecto</th>
                            <th class="py-2 px-3">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->members as $member)
                            <tr class="border-b">
                                <td class="py-2 px-3">{{ $member->name }}</td>
                                <td class="py-2 px-3">{{ $member->pivot->project_role }}</td>
                                <td class="py-2 px-3">
                                    <form action="{{ route('projects.members.destroy', [$project, $member]) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Quitar este miembro?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-600 text-sm underline">Quitar</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('projects.members.store', $project) }}" method="POST"
                    class="flex gap-2 flex-wrap">
                    @csrf
                    <select name="user_id" class="border-gray-300 rounded-md shadow-sm">
                        <option value="">Selecciona usuario</option>
                        @foreach (\App\Models\User::all() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <select name="project_role" class="border-gray-300 rounded-md shadow-sm">
                        <option value="colaborador">Colaborador</option>
                        <option value="lider">Líder</option>
                        <option value="invitado">Invitado</option>
                    </select>
                    <button type="submit"
                        class="px-4 py-2 bg-indigo-600 text-white rounded">Agregar</button>
                </form>
            </div>
            @endcan

            {{-- Tareas --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-700">Tareas</h3>
                    @can('create', [App\Models\Task::class, $project])
                        <a href="{{ route('projects.tasks.create', $project) }}"
                            class="px-4 py-2 bg-indigo-600 text-white rounded text-sm">
                            + Nueva tarea
                        </a>
                    @endcan
                </div>

                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-2 px-3">Título</th>
                            <th class="py-2 px-3">Estado</th>
                            <th class="py-2 px-3">Prioridad</th>
                            <th class="py-2 px-3">Responsable</th>
                            <th class="py-2 px-3">Vence</th>
                            <th class="py-2 px-3">Etiquetas</th>
                            <th class="py-2 px-3">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($project->tasks as $task)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-2 px-3">
                                    <a href="{{ route('tasks.show', $task) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $task->titulo }}
                                    </a>
                                </td>
                                <td class="py-2 px-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full
                                        {{ $task->estado === 'pendiente' ? 'bg-gray-100 text-gray-600' : '' }}
                                        {{ $task->estado === 'en_progreso' ? 'bg-blue-100 text-blue-600' : '' }}
                                        {{ $task->estado === 'completada' ? 'bg-green-100 text-green-600' : '' }}">
                                        {{ str_replace('_', ' ', ucfirst($task->estado)) }}
                                    </span>
                                </td>
                                <td class="py-2 px-3">
                                    <span class="px-2 py-0.5 text-xs rounded-full
                                        {{ $task->prioridad === 'alta' ? 'bg-red-100 text-red-600' : '' }}
                                        {{ $task->prioridad === 'media' ? 'bg-yellow-100 text-yellow-600' : '' }}
                                        {{ $task->prioridad === 'baja' ? 'bg-green-100 text-green-600' : '' }}">
                                        {{ ucfirst($task->prioridad) }}
                                    </span>
                                </td>
                                <td class="py-2 px-3">{{ $task->assignee?->name ?? '—' }}</td>
                                <td class="py-2 px-3">{{ $task->due_date?->format('d/m/Y') ?? '—' }}</td>
                                <td class="py-2 px-3">
                                    @foreach ($task->labels as $label)
                                        <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                            style="background-color: {{ $label->color }}">
                                            {{ $label->nombre }}
                                        </span>
                                    @endforeach
                                </td>
                                <td class="py-2 px-3 flex gap-2">
                                    <a href="{{ route('tasks.show', $task) }}"
                                        class="text-indigo-600 underline text-sm">Ver</a>
                                    @can('update', $task)
                                        <a href="{{ route('tasks.edit', $task) }}"
                                            class="text-amber-600 underline text-sm">Editar</a>
                                    @endcan
                                    @can('delete', $task)
                                        <form action="{{ route('tasks.destroy', $task) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar esta tarea?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 underline text-sm">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="py-4 text-center text-gray-500">
                                    No hay tareas aún.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</x-app-layout>