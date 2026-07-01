<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Nuevo proyecto') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-6 border border-[#2a3a4e]">
                <form method="POST" action="{{ route('projects.store') }}">
                    @csrf

                    <div>
                        <x-input-label for="nombre" :value="__('Nombre')" class="text-gray-300" />
                        <x-text-input id="nombre" name="nombre" class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] text-white focus:border-blue-500 focus:ring-blue-500"
                            :value="old('nombre')" required />
                        <x-input-error :messages="$errors->get('nombre')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="descripcion" :value="__('Descripción')" class="text-gray-300" />
                        <textarea id="descripcion" name="descripcion"
                            class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500"
                            rows="4">{{ old('descripcion') }}</textarea>
                        <x-input-error :messages="$errors->get('descripcion')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mt-4">
                        <x-input-label for="estado" :value="__('Estado')" class="text-gray-300" />
                        <select id="estado" name="estado"
                            class="block mt-1 w-full bg-[#0f1623] border-[#2a3a4e] rounded-md shadow-sm text-white focus:border-blue-500 focus:ring-blue-500">
                            @foreach (['activo', 'pausado', 'finalizado'] as $e)
                                <option value="{{ $e }}" @selected(old('estado') === $e) class="bg-[#1a2332]">
                                    {{ ucfirst($e) }}
                                </option>
                            @endforeach
                        </select>
                        <x-input-error :messages="$errors->get('estado')" class="mt-2 text-red-400" />
                    </div>

                    <div class="mt-6 flex gap-3">
                        <x-primary-button class="bg-blue-600 hover:bg-blue-700 text-white font-medium px-6 py-2.5 rounded-lg transition-colors">
                            {{ __('Guardar') }}
                        </x-primary-button>
                        <a href="{{ route('projects.index') }}"
                            class="px-6 py-2.5 bg-[#2a3a4e] hover:bg-[#3a4a5e] text-gray-300 hover:text-white rounded-lg transition-colors border border-[#3a4a5e]">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>