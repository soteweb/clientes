<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>Centro de Atención a Clientes - Soteweb</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.googleapis.com">
        <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
        <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

        <!-- Styles / Tailwind -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])

        <style>
            body {
                font-family: 'Outfit', sans-serif;
            }
            .glass {
                background: rgba(255, 255, 255, 0.7);
                backdrop-filter: blur(16px);
                -webkit-backdrop-filter: blur(16px);
                border: 1px solid rgba(255, 255, 255, 0.4);
            }
            .gradient-bg {
                background: radial-gradient(circle at 10% 20%, rgba(243, 246, 255, 1) 0%, rgba(228, 235, 255, 1) 90%);
            }
            .animated-shape {
                animation: float 8s ease-in-out infinite;
            }
            .animated-shape-delayed {
                animation: float 12s ease-in-out infinite;
                animation-delay: 2s;
            }
            @keyframes float {
                0%, 100% { transform: translateY(0px) rotate(0deg); }
                50% { transform: translateY(-20px) rotate(5deg); }
            }
        </style>
    </head>
    <body class="h-full antialiased text-slate-800 gradient-bg flex flex-col justify-between overflow-x-hidden relative min-h-screen">
        
        <!-- Animated Background Accent Shapes -->
        <div class="absolute top-[-10%] left-[-10%] w-[40vw] h-[40vw] rounded-full bg-blue-400/10 blur-[80px] pointer-events-none animated-shape"></div>
        <div class="absolute bottom-[-10%] right-[-10%] w-[50vw] h-[50vw] rounded-full bg-indigo-400/10 blur-[100px] pointer-events-none animated-shape-delayed"></div>

        <!-- Header -->
        <header class="w-full max-w-7xl mx-auto px-6 py-6 flex items-center justify-between z-10">
            <div class="flex items-center gap-3">
                <a href="{{ route('home') }}" class="flex items-center gap-2.5 transition-transform hover:scale-95 duration-200">
                    <img src="https://soteweb.com/wp-content/uploads/2021/11/logo_web.png" alt="Soteweb Logo" class="h-10 w-auto object-contain">
                </a>
            </div>
            <div>
                @if (Route::has('login'))
                    <div class="flex items-center gap-4">
                        @auth
                            <a href="{{ url('/dashboard') }}" class="px-5 py-2.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-xl shadow-lg shadow-blue-500/25 transition-all duration-200 hover:shadow-xl hover:shadow-blue-500/35">
                                Panel de Control
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="px-5 py-2.5 text-sm font-semibold text-blue-600 hover:text-blue-700 bg-white/80 hover:bg-white rounded-xl shadow-sm border border-slate-100 transition-all duration-200">
                                Iniciar Sesión
                            </a>
                        @endauth
                    </div>
                @endif
            </div>
        </header>

        <!-- Main Content -->
        <main class="flex-1 flex items-center justify-center px-4 py-8 sm:px-6 lg:px-8 z-10 w-full">
            <div class="max-w-5xl w-full flex flex-col items-center gap-12 sm:gap-16">
                
                <!-- Hero Text -->
                <div class="text-center max-w-3xl space-y-4">
                    <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full bg-blue-50 text-blue-600 font-semibold text-xs uppercase tracking-wider shadow-sm border border-blue-100/50 mb-3">
                        <span class="w-2 h-2 rounded-full bg-blue-600 animate-pulse"></span>
                        Portal Oficial de Clientes
                    </div>
                    <h1 class="text-4xl sm:text-5xl lg:text-6xl font-extrabold tracking-tight text-slate-900 leading-none">
                        Centro de Atención a Clientes <br class="hidden sm:inline">
                        <span class="bg-gradient-to-r from-blue-600 via-indigo-600 to-blue-600 bg-clip-text text-transparent bg-[length:200%_auto] animate-pulse">Soteweb</span>
                    </h1>
                    <p class="text-base sm:text-lg text-slate-600 max-w-2xl mx-auto leading-relaxed pt-2">
                        Te damos la bienvenida a nuestra plataforma de soporte y administración. Desde aquí podrás gestionar tus servicios o solicitar asistencia técnica especializada de manera rápida y sencilla.
                    </p>
                </div>

                <!-- Two Option Cards Grid -->
                <div class="grid md:grid-cols-2 gap-8 w-full max-w-4xl px-2">
                    
                    <!-- Card 1: Administrators -->
                    <div class="glass rounded-3xl p-8 sm:p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-white/60 flex flex-col justify-between group relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 w-36 h-36 bg-blue-500/5 rounded-full group-hover:bg-blue-500/10 transition-colors duration-300"></div>
                        
                        <div class="space-y-6 relative">
                            <!-- Icon Wrapper -->
                            <div class="w-14 h-14 rounded-2xl bg-blue-50 border border-blue-100 flex items-center justify-center text-blue-600 shadow-sm transition-transform group-hover:scale-110 group-hover:rotate-3 duration-300">
                                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 6a3.75 3.75 0 1 1-7.5 0 3.75 3.75 0 0 1 7.5 0ZM4.501 20.118a7.5 7.5 0 0 1 14.998 0A17.933 17.933 0 0 1 12 21.75c-2.676 0-5.216-.584-7.499-1.632Z" />
                                </svg>
                            </div>
                            
                            <div class="space-y-3">
                                <h3 class="text-2xl font-bold text-slate-900 group-hover:text-blue-600 transition-colors duration-200">Administradores</h3>
                                <p class="text-slate-600 text-sm/relaxed">
                                    Acceso al panel administrativo para gestionar cuentas de clientes, facturación, productos, presupuestos y dar resolución a los requerimientos de soporte.
                                </p>
                            </div>
                        </div>

                        <div class="pt-8">
                            <a href="{{ route('login') }}" class="w-full flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-semibold text-white bg-blue-600 hover:bg-blue-700 rounded-2xl shadow-md shadow-blue-500/20 hover:shadow-lg hover:shadow-blue-500/30 transition-all duration-200">
                                Acceso al Sistema
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1 duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                    <!-- Card 2: Support Ticket -->
                    <div class="glass rounded-3xl p-8 sm:p-10 shadow-xl hover:shadow-2xl transition-all duration-300 hover:-translate-y-2 border border-white/60 flex flex-col justify-between group relative overflow-hidden">
                        <div class="absolute -right-16 -top-16 w-36 h-36 bg-indigo-500/5 rounded-full group-hover:bg-indigo-500/10 transition-colors duration-300"></div>
                        
                        <div class="space-y-6 relative">
                            <!-- Icon Wrapper -->
                            <div class="w-14 h-14 rounded-2xl bg-indigo-50 border border-indigo-100 flex items-center justify-center text-indigo-600 shadow-sm transition-transform group-hover:scale-110 group-hover:-rotate-3 duration-300">
                                <svg class="w-7 h-7" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9.813 15.904 9 21l8.982-2.139M15 15.003L13.5 12m-6 3H12m1.5-12H5.625c-.621 0-1.125.504-1.125 1.125v17.25c0 .621.504 1.125 1.125 1.125h12.75c.621 0 1.125-.504 1.125-1.125V11.25a9 9 0 0 0-9-9Z" />
                                </svg>
                            </div>
                            
                            <div class="space-y-3">
                                <h3 class="text-2xl font-bold text-slate-900 group-hover:text-indigo-600 transition-colors duration-200">Soporte Técnico</h3>
                                <p class="text-slate-600 text-sm/relaxed">
                                    ¿Tienes algún problema técnico o requieres asistencia? Registra un ticket de soporte para que nuestro equipo lo resuelva de inmediato.
                                </p>
                            </div>
                        </div>

                        <div class="pt-8">
                            <a href="{{ route('soporte') }}" class="w-full flex items-center justify-center gap-2 px-5 py-3.5 text-sm font-semibold text-white bg-indigo-600 hover:bg-indigo-700 rounded-2xl shadow-md shadow-indigo-500/20 hover:shadow-lg hover:shadow-indigo-500/30 transition-all duration-200">
                                Pedir un Ticket
                                <svg class="w-4 h-4 transition-transform group-hover:translate-x-1 duration-200" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.5 4.5 21 12m0 0-7.5 7.5M21 12H3" />
                                </svg>
                            </a>
                        </div>
                    </div>

                </div>

            </div>
        </main>

        <!-- Footer -->
        <footer class="w-full py-8 text-center text-xs text-slate-500 z-10 border-t border-slate-200/50 glass">
            <div class="max-w-7xl mx-auto px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
                <p>&copy; {{ date('Y') }} Soteweb. Todos los derechos reservados.</p>
                <div class="flex items-center gap-4 text-slate-400">
                    <span>Centro de Atención v1.2.0</span>
                    <span>&bull;</span>
                    <a href="https://soteweb.com" target="_blank" class="hover:text-blue-600 transition-colors">soteweb.com</a>
                </div>
            </div>
        </footer>

    </body>
</html>
