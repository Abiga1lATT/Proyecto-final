<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Acceso denegado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-[#1a2332] shadow-lg sm:rounded-lg p-8 text-center border border-[#2a3a4e]">
                <div class="text-6xl mb-4">🔒</div>
                <h3 class="text-xl font-semibold text-gray-300 mb-2">
                    No tienes permiso para acceder a esta sección.
                </h3>
                <p class="text-gray-400 mb-6">
                    {{ $exception->getMessage() ?: 'Contacta al administrador si crees que esto es un error.' }}
                </p>
                <a href="{{ route('dashboard') }}" class="inline-block px-5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg transition-colors font-medium">
                    Volver al panel
                </a>
            </div>
        </div>
    </div>
</x-app-layout>