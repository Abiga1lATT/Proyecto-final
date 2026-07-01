<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $project->nombre }}
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                    {{ $project->estado === 'activo' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}
                    {{ $project->estado === 'pausado' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-700' : '' }}
                    {{ $project->estado === 'finalizado' ? 'bg-gray-700/30 text-gray-400 border border-gray-600' : '' }}">
                    {{ ucfirst($project->estado) }}
                </span>
            </h2>
            <div class="flex gap-2">
                @can('update', $project)
                <a href="{{ route('projects.edit', $project) }}"
                    class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors font-medium">Editar</a>
                @endcan
                @can('delete', $project)
                <form action="{{ route('projects.destroy', $project) }}" method="POST"
                    onsubmit="return confirm('¿Eliminar este proyecto?')">
                    @csrf
                    @method('DELETE')
                    <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">Eliminar</button>
                </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Descripción --}}
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <h3 class="font-semibold text-gray-300 mb-2">Descripción</h3>
                <p class="text-gray-400">{{ $project->descripcion ?? 'Sin descripción.' }}</p>
                <p class="mt-2 text-sm text-gray-500">Dueño: {{ $project->owner->name }}</p>
            </div>

            {{-- Miembros --}}
            @can('manageMembers', $project)
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <h3 class="font-semibold text-gray-300 mb-4">Miembros</h3>
                <table class="w-full text-left mb-4">
                    <thead class="bg-[#0f1623] border-b border-[#2a3a4e]">
                        <tr>
                            <th class="py-2 px-3 text-gray-300 font-medium">Usuario</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Rol en proyecto</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Acción</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($project->members as $member)
                        <tr class="border-b border-[#2a3a4e]">
                            <td class="py-2 px-3 text-gray-300">{{ $member->name }}</td>
                            <td class="py-2 px-3 text-gray-300">{{ $member->pivot->project_role }}</td>
                            <td class="py-2 px-3">
                                <form action="{{ route('projects.members.destroy', [$project, $member]) }}"
                                    method="POST" onsubmit="return confirm('¿Quitar este miembro?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 text-sm font-medium">Quitar</button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>

                <form action="{{ route('projects.members.store', $project) }}" method="POST"
                    class="flex gap-2 flex-wrap">
                    @csrf
                    <select name="user_id" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" class="bg-[#1a2332]">Selecciona usuario</option>
                        @foreach (\App\Models\User::all() as $u)
                        <option value="{{ $u->id }}" class="bg-[#1a2332]">{{ $u->name }}</option>
                        @endforeach
                    </select>
                    <select name="project_role" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="colaborador" class="bg-[#1a2332]">Colaborador</option>
                        <option value="lider" class="bg-[#1a2332]">Líder</option>
                        <option value="invitado" class="bg-[#1a2332]">Invitado</option>
                    </select>
                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">Agregar</button>
                </form>
            </div>
            @endcan

            {{-- Tareas --}}
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <div class="flex items-center justify-between mb-4">
                    <h3 class="font-semibold text-gray-300">Tareas</h3>
                    @can('create', [App\Models\Task::class, $project])
                    <a href="{{ route('projects.tasks.create', $project) }}"
                        class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                        + Nueva tarea
                    </a>
                    @endcan
                </div>

                {{-- Filtros de tareas --}}
                <form method="GET" action="{{ route('projects.show', $project) }}" class="flex gap-2 flex-wrap mb-4">
                    <select name="estado" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" class="bg-[#1a2332]">Todos los estados</option>
                        @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                        <option value="{{ $e }}" @selected(request('estado')===$e) class="bg-[#1a2332]">
                            {{ str_replace('_', ' ', ucfirst($e)) }}
                        </option>
                        @endforeach
                    </select>

                    <select name="prioridad" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                        <option value="" class="bg-[#1a2332]">Todas las prioridades</option>
                        @foreach (['baja', 'media', 'alta'] as $p)
                        <option value="{{ $p }}" @selected(request('prioridad')===$p) class="bg-[#1a2332]">
                            {{ ucfirst($p) }}
                        </option>
                        @endforeach
                    </select>

                    <button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors text-sm font-medium">
                        Filtrar
                    </button>
                    <a href="{{ route('projects.show', $project) }}"
                        class="px-4 py-2 bg-[#2a3a4e] hover:bg-[#3a4a5e] text-gray-300 hover:text-white rounded-lg transition-colors text-sm border border-[#3a4a5e]">
                        Limpiar
                    </a>
                </form>

                <table class="w-full text-left">
                    <thead class="bg-[#0f1623] border-b border-[#2a3a4e]">
                        <tr>
                            <th class="py-2 px-3 text-gray-300 font-medium">Título</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Estado</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Prioridad</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Responsable</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Vence</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Etiquetas</th>
                            <th class="py-2 px-3 text-gray-300 font-medium">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($tasks as $task)
                        <tr class="border-b border-[#2a3a4e] hover:bg-[#1f2a3e] transition-colors">
                            <td class="py-2 px-3">
                                <a href="{{ route('tasks.show', $task) }}" class="text-blue-400 hover:text-blue-300 hover:underline">
                                    {{ $task->titulo }}
                                </a>
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-0.5 text-xs rounded-full
                            {{ $task->estado === 'pendiente' ? 'bg-gray-700/30 text-gray-400 border border-gray-600' : '' }}
                            {{ $task->estado === 'en_progreso' ? 'bg-blue-900/30 text-blue-400 border border-blue-700' : '' }}
                            {{ $task->estado === 'completada' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}">
                                    {{ str_replace('_', ' ', ucfirst($task->estado)) }}
                                </span>
                            </td>
                            <td class="py-2 px-3">
                                <span class="px-2 py-0.5 text-xs rounded-full
                            {{ $task->prioridad === 'alta' ? 'bg-red-900/30 text-red-400 border border-red-700' : '' }}
                            {{ $task->prioridad === 'media' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-700' : '' }}
                            {{ $task->prioridad === 'baja' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}">
                                    {{ ucfirst($task->prioridad) }}
                                </span>
                            </td>
                            <td class="py-2 px-3 text-gray-300">{{ $task->assignee?->name ?? '—' }}</td>
                            <td class="py-2 px-3 text-gray-300">{{ $task->due_date?->format('d/m/Y') ?? '—' }}</td>
                            <td class="py-2 px-3">
                                @foreach ($task->labels as $label)
                                <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                    style="background-color: {{ $label->color }}">
                                    {{ $label->nombre }}
                                </span>
                                @endforeach
                            </td>
                            <td class="py-2 px-3 flex gap-3">
                                <a href="{{ route('tasks.show', $task) }}"
                                    class="text-blue-400 hover:text-blue-300 text-sm font-medium">Ver</a>
                                @can('update', $task)
                                <a href="{{ route('tasks.edit', $task) }}"
                                    class="text-amber-400 hover:text-amber-300 text-sm font-medium">Editar</a>
                                @endcan
                                @can('delete', $task)
                                <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                                    onsubmit="return confirm('¿Eliminar esta tarea?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="text-red-400 hover:text-red-300 text-sm font-medium">Eliminar</button>
                                </form>
                                @endcan
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="7" class="py-4 text-center text-gray-400">
                                No hay tareas con esos filtros.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

                <div class="mt-4 bg-[#0f1623] rounded-lg p-2 border border-[#2a3a4e]">
                    {{ $tasks->links() }}
                </div>
            </div>

        </div>
    </div>
</x-app-layout>