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
    <body class="font-sans antialiased text-slate-800 bg-slate-50">
        <div class="min-h-screen flex flex-col sm:justify-center items-center p-4 sm:p-6 bg-gradient-to-br from-slate-50 via-blue-50/20 to-indigo-50/30">
            <div class="mb-6 flex items-center justify-center">
                <a href="{{ route('home') }}" class="transition-transform hover:scale-95 duration-200">
                    <img src="https://soteweb.com/wp-content/uploads/2021/11/logo_web.png" alt="Soteweb Logo" class="h-12 w-auto object-contain">
                </a>
            </div>

            <div class="w-full sm:max-w-2xl px-6 py-8 bg-white shadow-2xl shadow-slate-200/50 border border-slate-100 rounded-3xl">
                {{ $slot }}
            </div>
        </div>
    </body>
</html>
