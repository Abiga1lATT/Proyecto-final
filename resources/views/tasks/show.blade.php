<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-white leading-tight">
                {{ $task->titulo }}
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                    {{ $task->estado === 'pendiente' ? 'bg-gray-700/30 text-gray-400 border border-gray-600' : '' }}
                    {{ $task->estado === 'en_progreso' ? 'bg-blue-900/30 text-blue-400 border border-blue-700' : '' }}
                    {{ $task->estado === 'completada' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}">
                    {{ str_replace('_', ' ', ucfirst($task->estado)) }}
                </span>
                <span class="ml-2 px-2 py-0.5 text-xs rounded-full
                    {{ $task->prioridad === 'alta' ? 'bg-red-900/30 text-red-400 border border-red-700' : '' }}
                    {{ $task->prioridad === 'media' ? 'bg-yellow-900/30 text-yellow-400 border border-yellow-700' : '' }}
                    {{ $task->prioridad === 'baja' ? 'bg-green-900/30 text-green-400 border border-green-700' : '' }}">
                    {{ ucfirst($task->prioridad) }}
                </span>
            </h2>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="px-4 py-2 bg-amber-500 hover:bg-amber-600 text-white rounded-lg transition-colors font-medium">Editar</a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar esta tarea?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-600 hover:bg-red-700 text-white rounded-lg transition-colors font-medium">Eliminar</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Detalle de la tarea --}}
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="text-sm text-gray-400">Proyecto</span>
                        <p>
                            <a href="{{ route('projects.show', $task->project) }}"
                                class="text-blue-400 hover:text-blue-300 hover:underline">
                                {{ $task->project->nombre }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-400">Responsable</span>
                        <p class="text-gray-300">{{ $task->assignee?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-400">Estado</span>
                        <p class="text-gray-300">{{ str_replace('_', ' ', ucfirst($task->estado)) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-400">Prioridad</span>
                        <p class="text-gray-300">{{ ucfirst($task->prioridad) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-400">Fecha límite</span>
                        <p class="text-gray-300">{{ $task->due_date?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-400">Etiquetas</span>
                        <div class="flex gap-1 flex-wrap mt-1">
                            @foreach ($task->labels as $label)
                                <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                    style="background-color: {{ $label->color }}">
                                    {{ $label->nombre }}
                                </span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div>
                    <span class="text-sm text-gray-400">Descripción</span>
                    <p class="mt-1 text-gray-300">{{ $task->descripcion ?? 'Sin descripción.' }}</p>
                </div>

                {{-- Cambio de estado rápido --}}
                @can('update', $task)
                    <form action="{{ route('tasks.status', $task) }}" method="POST"
                        class="mt-4 flex gap-2 items-center">
                        @csrf
                        @method('PATCH')
                        <select name="estado" class="bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm text-sm focus:border-blue-500 focus:ring-blue-500">
                            @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                <option value="{{ $e }}" @selected($task->estado === $e) class="bg-[#1a2332]">
                                    {{ str_replace('_', ' ', ucfirst($e)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-3 py-1 bg-blue-600 hover:bg-blue-700 text-white rounded-lg text-sm font-medium transition-colors">
                            Cambiar estado
                        </button>
                    </form>
                @endcan
            </div>

            {{-- Comentarios --}}
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <h3 class="font-semibold text-gray-300 mb-4">
                    Comentarios ({{ $task->comments->count() }})
                </h3>

                @foreach ($task->comments as $comment)
                    <div class="border-b border-[#2a3a4e] py-3">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-sm text-gray-300">{{ $comment->user->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-500">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar comentario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-400 hover:text-red-300 text-xs font-medium">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="mt-1 text-gray-400 text-sm">{{ $comment->cuerpo }}</p>
                    </div>
                @endforeach

                {{-- Formulario de comentario --}}
                @can('create', [App\Models\Comment::class, $task])
                    <form action="{{ route('comments.store', $task) }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="cuerpo"
                            class="w-full bg-[#0f1623] border-[#2a3a4e] text-white rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 placeholder-gray-400"
                            rows="3"
                            placeholder="Escribe un comentario...">{{ old('cuerpo') }}</textarea>
                        <x-input-error :messages="$errors->get('cuerpo')" class="mt-1 text-red-400" />
                        <button type="submit"
                            class="mt-2 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                            Comentar
                        </button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>