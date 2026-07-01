<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            Nueva tarea en {{ $project->nombre }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <form method="POST" action="{{ route('projects.tasks.store', $project) }}">
                    @csrf

                    <div>
                        <x-input-label for="titulo" :value="__('Título')" class="text-gray-300" />
                        <x-text-input id="titulo" name="titulo" class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] text-white focus:border-blue-500 focus:ring-blue-500"
                            :value="old('titulo')" required />
                        <x-input-error :messages="$errors->get('titulo')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" class="text-gray-300" />
                        <textarea id="descripcion" name="descripcion"
                            class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500"
                            rows="3">{{ old('descripcion') }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="estado" :value="__('Estado')" class="text-gray-300" />
                            <select id="estado" name="estado"
                                class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500">
                                @foreach (['pendiente', 'en_progreso', 'completada'] as $e)
                                    <option value="{{ $e }}" @selected(old('estado') === $e) class="bg-[#1a2332]">
                                        {{ str_replace('_', ' ', ucfirst($e)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <x-input-label for="prioridad" :value="__('Prioridad')" class="text-gray-300" />
                            <select id="prioridad" name="prioridad"
                                class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500">
                                @foreach (['baja', 'media', 'alta'] as $p)
                                    <option value="{{ $p }}" @selected(old('prioridad', 'media') === $p) class="bg-[#1a2332]">
                                        {{ ucfirst($p) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4 grid grid-cols-2 gap-4">
                        <div>
                            <x-input-label for="due_date" :value="__('Fecha límite')" class="text-gray-300" />
                            <x-text-input id="due_date" name="due_date" type="date"
                                class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] text-white focus:border-blue-500 focus:ring-blue-500" 
                                :value="old('due_date')" />
                            <x-input-error :messages="$errors->get('due_date')" class="mt-2 text-red-400" />
                        </div>
                        <div>
                            <x-input-label for="assignee_id" :value="__('Responsable')" class="text-gray-300" />
                            <select id="assignee_id" name="assignee_id"
                                class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500">
                                <option value="" class="bg-[#1a2332]">Sin asignar</option>
                                @foreach ($members as $m)
                                    <option value="{{ $m->id }}"
                                        @selected(old('assignee_id') == $m->id) class="bg-[#1a2332]">
                                        {{ $m->name }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>

                    <div class="mt-4">
                        <x-input-label :value="__('Etiquetas')" class="text-gray-300" />
                        <div class="flex flex-wrap gap-2 mt-1">
                            @foreach ($labels as $label)
                                <label class="flex items-center gap-1 text-gray-300">
                                    <input type="checkbox" name="labels[]"
                                        value="{{ $label->id }}"
                                        @checked(in_array($label->id, old('labels', [])))
                                        class="bg-[#0f1623] border-[#2a3a4e] text-blue-600 focus:ring-blue-500">
                                    <span class="px-2 py-0.5 text-xs rounded-full text-white"
                                        style="background-color: {{ $label->color }}">
                                        {{ $label->nombre }}
                                    </span>
                                </label>
                            @endforeach
                        </div>
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors">
                            {{ __('Guardar') }}
                        </x-primary-button>
                        <a href="{{ route('projects.show', $project) }}"
                            class="px-6 py-2.5 bg-[#2a3a4e] hover:bg-[#3a4a5e] text-gray-300 hover:text-white rounded-lg transition-colors border border-[#3a4a5e]">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>