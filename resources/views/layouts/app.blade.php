<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans antialiased bg-gray-950">
    <div class="min-h-screen flex bg-gray-950">

        {{-- SIDEBAR --}}
        <aside class="w-64 min-h-screen bg-gradient-to-b from-blue-950 to-indigo-900 flex flex-col shadow-xl fixed top-0 left-0 z-50">

            {{-- Logo --}}
            <div class="flex items-center gap-3 px-6 py-5 border-b border-white/10">
                <div class="w-9 h-9 bg-gradient-to-br from-purple-500 to-pink-500 rounded-xl flex items-center justify-center shadow">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L4 7v10l8 5 8-5V7l-8-5z" />
                        <path d="M12 2v20" stroke-opacity="0.4" />
                    </svg>
                </div>
                <span class="text-white font-bold text-lg">JIRA</span>
            </div>

            {{-- Navegación --}}
            <nav class="flex-1 px-4 py-6 space-y-1">

                <a href="{{ route('dashboard') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                    {{ request()->routeIs('dashboard') ? 'bg-white/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Panel
                </a>

                <a href="{{ route('projects.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                    {{ request()->routeIs('projects.*') ? 'bg-white/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    Proyectos
                </a>

                @role('admin')
                <a href="{{ route('admin.users.index') }}"
                    class="flex items-center gap-3 px-4 py-2.5 rounded-xl text-sm font-medium transition-all duration-200
                    {{ request()->routeIs('admin.*') ? 'bg-white/20 text-white' : 'text-gray-300 hover:bg-white/10 hover:text-white' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                    Usuarios
                </a>
                @endrole

            </nav>

            {{-- Usuario y logout --}}
            <div class="px-4 py-4 border-t border-white/10">
                <div class="flex items-center gap-3 px-4 py-2 mb-2">
                    <div class="w-8 h-8 bg-purple-500 rounded-full flex items-center justify-center text-white font-bold text-sm">
                        {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <p class="text-white text-sm font-medium truncate">{{ Auth::user()->name }}</p>
                        <p class="text-gray-400 text-xs truncate">{{ Auth::user()->email }}</p>
                    </div>
                </div>

                <a href="{{ route('profile.edit') }}"
                    class="flex items-center gap-3 px-4 py-2 rounded-xl text-sm text-gray-300 hover:bg-white/10 hover:text-white transition-all duration-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                    </svg>
                    Perfil
                </a>

                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit"
                        class="w-full flex items-center gap-3 px-4 py-2 rounded-xl text-sm text-gray-300 hover:bg-red-500/20 hover:text-red-300 transition-all duration-200">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                        </svg>
                        Cerrar sesión
                    </button>
                </form>
            </div>
        </aside>

        {{-- CONTENIDO PRINCIPAL --}}
        <div class="flex-1 ml-64 bg-gray-950 text-gray-100">

            {{-- Header --}}
            @isset($header)
            <header class="bg-gray-900 border-b border-white/10 shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8 text-white">
                    {{ $header }}
                </div>
            </header>
            @endisset

            {{-- Mensajes flash --}}
            @if (session('success'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 bg-green-500/20 text-green-300 border border-green-500/30 rounded-lg shadow-sm">
                    {{ session('success') }}
                </div>
            </div>
            @endif

            @if (session('error'))
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 mt-4">
                <div class="p-4 bg-red-500/20 text-red-300 border border-red-500/30 rounded-lg shadow-sm">
                    {{ session('error') }}
                </div>
            </div>
            @endif

            {{-- Contenido --}}
            <main>
                {{ $slot }}
            </main>
        </div>

    </div>
</body>

</html>