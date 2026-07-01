<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ __('Proyectos') }}
            </h2>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                    + Nuevo proyecto
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Filtros --}}
            <form method="GET" action="{{ route('projects.index') }}"
                class="mb-4 flex gap-2 flex-wrap">
                <input type="text" name="buscar" value="{{ request('buscar') }}"
                    placeholder="Buscar por nombre..."
                    class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm w-64 focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400" />

                <select name="estado" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="" class="bg-[#1a2332]">Todos los estados</option>
                    @foreach (['activo', 'pausado', 'finalizado'] as $e)
                        <option value="{{ $e }}" @selected(request('estado') === $e) class="bg-[#1a2332]">
                            {{ ucfirst($e) }}
                        </option>
                    @endforeach
                </select>

                <button type="submit"
                    class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                    Filtrar
                </button>
                <a href="{{ route('projects.index') }}"
                    class="px-4 py-2 bg-[#2a3a4e] hover:bg-[#3a4a5e] text-gray-300 hover:text-white rounded-lg transition-colors border border-[#3a4a5e]">
                    Limpiar
                </a>
            </form>

            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg overflow-hidden border border-[#2a3a4e]">
                <table class="w-full text-left">
                    <thead class="bg-[#0f1623] border-b border-[#2a3a4e]">
                        <tr>
                            <th class="py-3 px-4 text-gray-300 font-medium">Nombre</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Estado</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Dueño</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Tareas</th>
                            <th class="py-3 px-4 text-gray-300 font-medium">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class="border-b border-[#2a3a4e] hover:bg-[#1f2a3e] transition-colors">
                                <td class="py-3 px-4 font-medium">
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-blue-400 hover:text-blue-300 hover:underline">
                                        {{ $project->nombre }}
                                    </a>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $project->estado === 'activo' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}
                                        {{ $project->estado === 'pausado' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-700' : '' }}
                                        {{ $project->estado === 'finalizado' ? 'bg-gray-700/30 text-gray-400 border border-gray-600' : '' }}">
                                        {{ ucfirst($project->estado) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4 text-gray-300">{{ $project->owner->name }}</td>
                                <td class="py-3 px-4 text-gray-300">{{ $project->tasks->count() }}</td>
                                <td class="py-3 px-4 flex gap-3">
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-blue-400 hover:text-blue-300 text-sm font-medium">Ver</a>
                                    @can('update', $project)
                                        <a href="{{ route('projects.edit', $project) }}"
                                            class="text-amber-400 hover:text-amber-300 text-sm font-medium">Editar</a>
                                    @endcan
                                    @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar este proyecto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-400 hover:text-red-300 text-sm font-medium">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-400">
                                    No hay proyectos disponibles.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4 bg-[#0f1623] border-t border-[#2a3a4e]">
                    {{ $projects->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>