<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>404 - Página no encontrada</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex items-center justify-center bg-gradient-to-b from-blue-950 to-indigo-900">
    <div class="text-center p-8 bg-white/10 backdrop-blur-sm border border-white/20 rounded-2xl shadow-xl max-w-md">
        <div class="text-6xl mb-4">🔍</div>
        <h3 class="text-xl font-semibold text-white mb-2">
            Página no encontrada
        </h3>
        <p class="text-gray-300 mb-6">
            Puede que haya sido eliminada o que la URL sea incorrecta.
        </p>
        <a href="{{ url('/') }}"
            class="inline-block px-5 py-2 bg-gradient-to-r from-purple-500 to-pink-500 text-white rounded-lg font-semibold">
            Volver al inicio
        </a>
    </div>
</body>
</html>