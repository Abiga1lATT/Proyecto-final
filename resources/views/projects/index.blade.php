<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Proyectos') }}
            </h2>
            @can('create', App\Models\Project::class)
                <a href="{{ route('projects.create') }}"
                    class="px-4 py-2 bg-indigo-600 text-white rounded-lg">
                    + Nuevo proyecto
                </a>
            @endcan
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg overflow-hidden">
                <table class="w-full text-left">
                    <thead class="bg-gray-50 border-b">
                        <tr>
                            <th class="py-3 px-4">Nombre</th>
                            <th class="py-3 px-4">Estado</th>
                            <th class="py-3 px-4">Dueño</th>
                            <th class="py-3 px-4">Tareas</th>
                            <th class="py-3 px-4">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($projects as $project)
                            <tr class="border-b hover:bg-gray-50">
                                <td class="py-3 px-4 font-medium">
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-indigo-600 hover:underline">
                                        {{ $project->nombre }}
                                    </a>
                                </td>
                                <td class="py-3 px-4">
                                    <span class="px-2 py-1 text-xs rounded-full
                                        {{ $project->estado === 'activo' ? 'bg-green-100 text-green-700' : '' }}
                                        {{ $project->estado === 'pausado' ? 'bg-yellow-100 text-yellow-700' : '' }}
                                        {{ $project->estado === 'finalizado' ? 'bg-gray-100 text-gray-700' : '' }}">
                                        {{ ucfirst($project->estado) }}
                                    </span>
                                </td>
                                <td class="py-3 px-4">{{ $project->owner->name }}</td>
                                <td class="py-3 px-4">{{ $project->tasks->count() }}</td>
                                <td class="py-3 px-4 flex gap-2">
                                    <a href="{{ route('projects.show', $project) }}"
                                        class="text-indigo-600 underline text-sm">Ver</a>
                                    @can('update', $project)
                                        <a href="{{ route('projects.edit', $project) }}"
                                            class="text-amber-600 underline text-sm">Editar</a>
                                    @endcan
                                    @can('delete', $project)
                                        <form action="{{ route('projects.destroy', $project) }}"
                                            method="POST"
                                            onsubmit="return confirm('¿Eliminar este proyecto?')">
                                            @csrf
                                            @method('DELETE')
                                            <button class="text-red-600 underline text-sm">Eliminar</button>
                                        </form>
                                    @endcan
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="py-8 text-center text-gray-500">
                                    No hay proyectos disponibles.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
                <div class="p-4">{{ $projects->links() }}</div>
            </div>
        </div>
    </div>
</x-app-layout>