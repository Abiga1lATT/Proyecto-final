<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            Editar tarea: {{ $task->titulo }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('tasks.update', $task) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="titulo" :value="__('Título')" />
                        <x-text-input id="titulo" name="titulo" class="block mt-1 w-full"
                            :value="old('titulo', $task->titulo)" required />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" />
                        <textarea id="descripcion" name="descripcion"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            rows="3">{{ old('descripcion', $task->descripcion) }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="estado" :value="__('Estado')" />
                            <select id="estado" name="estado"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                    <option value="{{ $e }}"
                                        @selected(old('estado', $task->estado) === $e)>
                                        {{ str_replace('_', ' ', ucfirst($e)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="prioridad" :value="__('Prioridad')" />
                            <select id="prioridad" name="prioridad"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                @foreach (['baja', 'media', 'alta'] as $p)
                                    <option value="{{ $p }}"
                                        @selected(old('prioridad', $task->prioridad) === $p)>
                                        {{ ucfirst($p) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="due_date" :value="__('Fecha límite')" />
                            <x-text-input id="due_date" name="due_date" type="date"
                                class="block mt-1 w-full"
                                :value="old('due_date', $task->due_date?->format('Y-m-d'))" />
                        </div>
                        <div>
                            <x-input-label for="assignee_id" :value="__('Responsable')" />
                            <select id="assignee_id" name="assignee_id"
                                class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                                <option value="">Sin asignar</option>
                                @foreach ($members as $m)
                                    <option value="{{ $m->id }}"
                                        @selected(old('assignee_id', $task->assignee_id) == $m->id)>
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label :value="__('Etiquetas')" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($labels as $label)
                                <label class="flex items-center gap-1">
                                    <input type="checkbox" name="labels[]"
                                        value="{{ $label->id }}"
                                        @checked(in_array($label->id, old('labels', $task->labels->pluck('id')->toArray())))>
                                    <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->nombre }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                        <a href="{{ route('tasks.show', $task) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>