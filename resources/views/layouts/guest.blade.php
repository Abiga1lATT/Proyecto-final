<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Laravel') }}</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans text-gray-900 antialiased">
        <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 bg-gradient-to-b from-blue-950 to-indigo-900">

            <div class="flex flex-col items-center mb-2">
                {{-- Logo JIRA --}}
                <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-pink-500 rounded-2xl flex items-center justify-center shadow-lg mb-3">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-9 w-9 text-white" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M12 2L4 7v10l8 5 8-5V7l-8-5z" />
                        <path d="M12 2v20" stroke-opacity="0.4" />
                    </svg>
                </div>
                <h1 class="text-white font-bold text-2xl">JIRA</h1>
                <p class="text-gray-300 text-sm mt-1">Gestión de proyectos ágil</p>
            </div>

            <div class="w-full sm:max-w-md mt-4 px-6 py-6 bg-white/10 backdrop-blur-sm border border-white/20 shadow-xl overflow-hidden sm:rounded-2xl">
                {{ $slot }}
            </div>

            <p class="mt-4 text-gray-500 text-xs">{{ config('app.version', '1.0.0') }}</p>
        </div>
    </body>
</html>