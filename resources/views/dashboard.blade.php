<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-white leading-tight">
            {{ __('Panel') }} — Bienvenido, {{ auth()->user()->name }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            {{-- Tarjetas de resumen --}}
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6 mb-8">

                <div class="bg-gradient-to-br from-indigo-500 to-purple-600 shadow-lg rounded-2xl p-6 text-center text-white">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold">{{ $totalProyectos }}</p>
                    <p class="text-indigo-100 mt-1 text-sm">Proyectos</p>
                </div>

                <div class="bg-gradient-to-br from-pink-500 to-rose-600 shadow-lg rounded-2xl p-6 text-center text-white">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold">{{ $totalTareas }}</p>
                    <p class="text-pink-100 mt-1 text-sm">Tareas asignadas</p>
                </div>

                <div class="bg-gradient-to-br from-emerald-500 to-teal-600 shadow-lg rounded-2xl p-6 text-center text-white">
                    <div class="flex justify-center mb-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 opacity-80" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                        </svg>
                    </div>
                    <p class="text-5xl font-bold">{{ $tareasCompletadas }}</p>
                    <p class="text-emerald-100 mt-1 text-sm">Tareas completadas</p>
                </div>

            </div>

            {{-- Accesos rápidos --}}
            <div class="bg-gray-900 shadow-lg rounded-2xl p-6 border border-white/10">
                <h3 class="font-semibold text-white mb-4 flex items-center gap-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-indigo-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                    </svg>
                    Accesos rápidos
                </h3>
                <div class="flex gap-3 flex-wrap">
                    <a href="{{ route('projects.index') }}"
                        class="px-4 py-2 bg-gradient-to-r from-indigo-500 to-purple-600 text-white rounded-xl shadow hover:shadow-md transition-all duration-200 text-sm font-medium">
                        Ver proyectos
                    </a>
                    @can('create', App\Models\Project::class)
                        <a href="{{ route('projects.create') }}"
                            class="px-4 py-2 bg-gradient-to-r from-emerald-500 to-teal-600 text-white rounded-xl shadow hover:shadow-md transition-all duration-200 text-sm font-medium">
                            Nuevo proyecto
                        </a>
                    @endcan
                    @role('admin')
                        <a href="{{ route('admin.users.index') }}"
                            class="px-4 py-2 bg-gradient-to-r from-pink-500 to-rose-600 text-white rounded-xl shadow hover:shadow-md transition-all duration-200 text-sm font-medium">
                            Gestionar usuarios
                        </a>
                    @endrole
                </div>
            </div>

        </div>
    </div>
</x-app-layout>