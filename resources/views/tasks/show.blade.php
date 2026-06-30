<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center justify-between">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ $task->titulo }}
            </h2>
            <div class="flex gap-2">
                @can('update', $task)
                    <a href="{{ route('tasks.edit', $task) }}"
                        class="px-4 py-2 bg-amber-500 text-white rounded">Editar</a>
                @endcan
                @can('delete', $task)
                    <form action="{{ route('tasks.destroy', $task) }}" method="POST"
                        onsubmit="return confirm('¿Eliminar esta tarea?')">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 bg-red-600 text-white rounded">Eliminar</button>
                    </form>
                @endcan
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8 space-y-6">

            {{-- Detalle de la tarea --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <span class="text-sm text-gray-500">Proyecto</span>
                        <p>
                            <a href="{{ route('projects.show', $task->project) }}"
                                class="text-indigo-600 underline">
                                {{ $task->project->nombre }}
                            </a>
                        </p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Responsable</span>
                        <p>{{ $task->assignee?->name ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Estado</span>
                        <p>{{ str_replace('_', ' ', ucfirst($task->estado)) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Prioridad</span>
                        <p>{{ ucfirst($task->prioridad) }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Fecha límite</span>
                        <p>{{ $task->due_date?->format('d/m/Y') ?? '—' }}</p>
                    </div>
                    <div>
                        <span class="text-sm text-gray-500">Etiquetas</span>
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
                    <span class="text-sm text-gray-500">Descripción</span>
                    <p class="mt-1 text-gray-700">{{ $task->descripcion ?? 'Sin descripción.' }}</p>
                </div>

                {{-- Cambio de estado rápido --}}
                @can('update', $task)
                    <form action="{{ route('tasks.status', $task) }}" method="POST"
                        class="mt-4 flex gap-2 items-center">
                        @csrf
                        @method('PATCH')
                        <select name="estado" class="border-gray-300 rounded-md shadow-sm text-sm">
                            @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                <option value="{{ $e }}" @selected($task->estado === $e)>
                                    {{ str_replace('_', ' ', ucfirst($e)) }}
                                </option>
                            @endforeach
                        </select>
                        <button type="submit"
                            class="px-3 py-1 bg-indigo-600 text-white rounded text-sm">
                            Cambiar estado
                        </button>
                    </form>
                @endcan
            </div>

            {{-- Comentarios --}}
            <div class="bg-white shadow sm:rounded-lg p-6">
                <h3 class="font-semibold text-gray-700 mb-4">
                    Comentarios ({{ $task->comments->count() }})
                </h3>

                @foreach ($task->comments as $comment)
                    <div class="border-b py-3">
                        <div class="flex items-center justify-between">
                            <span class="font-medium text-sm">{{ $comment->user->name }}</span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">
                                    {{ $comment->created_at->diffForHumans() }}
                                </span>
                                @can('delete', $comment)
                                    <form action="{{ route('comments.destroy', $comment) }}"
                                        method="POST"
                                        onsubmit="return confirm('¿Eliminar comentario?')">
                                        @csrf
                                        @method('DELETE')
                                        <button class="text-red-500 text-xs underline">Eliminar</button>
                                    </form>
                                @endcan
                            </div>
                        </div>
                        <p class="mt-1 text-gray-600 text-sm">{{ $comment->cuerpo }}</p>
                    </div>
                @endforeach

                {{-- Formulario de comentario --}}
                @can('create', [App\Models\Comment::class, $task])
                    <form action="{{ route('comments.store', $task) }}" method="POST" class="mt-4">
                        @csrf
                        <textarea name="cuerpo"
                            class="w-full border-gray-300 rounded-md shadow-sm"
                            rows="3"
                            placeholder="Escribe un comentario...">{{ old('cuerpo') }}</textarea>
                        <x-input-error :messages="$errors->get('cuerpo')" class="mt-1" />
                        <button type="submit"
                            class="mt-2 px-4 py-2 bg-indigo-600 text-white rounded">
                            Comentar
                        </button>
                    </form>
                @endcan
            </div>

        </div>
    </div>
</x-app-layout>