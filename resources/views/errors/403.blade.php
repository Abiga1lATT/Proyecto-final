<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Acceso denegado') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white shadow sm:rounded-lg p-8 text-center">
                <div class="text-6xl mb-4">🔒</div>
                <h3 class="text-xl font-semibold text-gray-800 mb-2">
                    No tienes permiso para acceder a esta sección.
                </h3>
                <p class="text-gray-500 mb-6">
                    {{ $exception->getMessage() ?: 'Contacta al administrador si crees que esto es un error.' }}
                </p>
                <a href="{{ route('dashboard') }}" class="inline-block px-5 py-2 bg-indigo-600 text-white rounded-lg">
                    Volver al panel
                </a>
            </div>
        </div>
    </div>
</x-app-layout>
