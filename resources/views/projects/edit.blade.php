<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Editar proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-6">
                <form method="POST" action="{{ route('projects.update', $project) }}">
                    @csrf
                    @method('PUT')

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre')" />
                        <x-text-input id="nombre" name="nombre" class="block mt-1 w-full"
                            :value="old('nombre', $project->nombre)" required />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" />
                        <textarea id="descripcion" name="descripcion"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm"
                            rows="4">{{ old('descripcion', $project->descripcion) }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="estado" :value="__('Estado')" />
                        <select id="estado" name="estado"
                            class="block mt-1 w-full border-gray-300 rounded-md shadow-sm">
                            @foreach (['activo', 'pausado', 'finalizado'] as $e)
                                <option value="{{ $e }}"
                                    @selected(old('estado', $project->estado) === $e)>
                                    {{ ucfirst($e) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2" />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button>{{ __('Actualizar') }}</x-primary-button>
                        <a href="{{ route('projects.show', $project) }}"
                            class="px-4 py-2 bg-gray-200 text-gray-700 rounded">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>