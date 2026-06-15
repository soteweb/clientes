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
    <body class="font-sans antialiased text-slate-800 bg-slate-50 overflow-hidden h-screen flex" x-data="{ sidebarOpen: true }">
        <!-- Sidebar -->
        <aside :class="sidebarOpen ? 'w-56' : 'w-20'" class="bg-white border-r border-slate-200 flex-col justify-between hidden md:flex h-full shadow-sm z-20 relative transition-all duration-300">
            <div>
                <div class="h-16 flex items-center px-5 border-b border-slate-100" :class="sidebarOpen ? 'justify-start' : 'justify-center px-2'">
                    <a href="{{ route('home') }}" class="flex items-center transition-all duration-200">
                        <img src="https://soteweb.com/wp-content/uploads/2021/11/logo_web.png" alt="Soteweb Logo" class="h-8 max-w-full object-contain shrink-0" :class="sidebarOpen ? 'max-h-8' : 'max-h-6'">
                    </a>
                </div>
                <nav class="p-3 space-y-1.5">
                    <div class="px-3 py-2 text-[11px] font-black text-slate-400 uppercase tracking-wider" x-show="sidebarOpen" x-transition>
                        Menú Principal
                    </div>
                    <a href="{{ route('dashboard') }}" title="Dashboard" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('dashboard') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-home class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Dashboard</span>
                    </a>
                    <a href="{{ route('clients.index') }}" title="Clientes" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('clients.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-users class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Clientes</span>
                    </a>
                    <a href="{{ route('products.index') }}" title="Productos/Servicios" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('products.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-cube class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Productos/Servicios</span>
                    </a>
                    <a href="{{ route('payments.index') }}" title="Pagos" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('payments.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-credit-card class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Pagos</span>
                    </a>
                    <a href="{{ route('quotes.index') }}" title="Presupuestos" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('quotes.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-document-text class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Presupuestos</span>
                    </a>
                    <a href="{{ route('users.index') }}" title="Usuarios" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('users.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-user-group class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Usuarios</span>
                    </a>
                    <a href="{{ route('tickets.index') }}" title="Tickets de Soporte" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('tickets.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-lifebuoy class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Soporte / Tickets</span>
                    </a>
                    <a href="{{ route('reseller.index') }}" title="Reseller / Compras" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('reseller.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-server-stack class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Reseller / Compras</span>
                    </a>
                    <a href="{{ route('requirements.index') }}" title="Requerimientos / Proyectos" class="flex items-center gap-3.5 px-3.5 py-2.5 rounded-xl font-bold text-sm transition-all {{ request()->routeIs('requirements.*') ? 'bg-blue-600 text-white shadow-sm shadow-blue-500/30' : 'text-slate-600 hover:bg-slate-50 hover:text-slate-900' }}">
                        <x-heroicon-o-clipboard-document-list class="w-5 h-5 shrink-0"/>
                        <span x-show="sidebarOpen" x-transition>Requerimientos / Proyectos</span>
                    </a>
                </nav>
            </div>
            
            <div class="p-3 border-t border-slate-100 flex flex-col gap-2">
                <livewire:layout.navigation />
                <div class="text-center py-1 text-[10px] font-bold text-slate-400" x-show="sidebarOpen" x-transition>
                    Soteweb V1.0.0
                </div>
            </div>
        </aside>

        <!-- Main Content -->
        <div class="flex-1 flex flex-col h-full overflow-hidden relative">
            <!-- Topbar -->
            <header class="h-16 bg-white border-b border-slate-200 flex items-center justify-between px-4 md:px-8 z-10 shadow-sm">
                <div class="md:hidden flex items-center justify-between w-full">
                    <a href="{{ route('home') }}" class="flex items-center gap-2 transition-transform hover:scale-95 duration-200">
                        <img src="https://soteweb.com/wp-content/uploads/2021/11/logo_web.png" alt="Soteweb Logo" class="h-6 w-auto object-contain">
                    </a>
                    <div class="flex items-center gap-2">
                        <livewire:layout.ticket-notifier />
                        <div class="md:hidden">
                            <livewire:layout.navigation />
                        </div>
                    </div>
                </div>
                <div class="hidden md:flex items-center w-full justify-between">
                    <div class="flex items-center gap-4">
                        <button @click="sidebarOpen = !sidebarOpen" title="Minimizar/Expandir Menú" class="p-2 bg-white rounded-xl border border-slate-200 text-slate-500 hover:text-blue-600 hover:bg-blue-50 transition-colors shadow-sm font-bold flex items-center justify-center">
                            <x-heroicon-o-bars-3 class="w-5 h-5"/>
                        </button>
                        @if (isset($header))
                            <h2 class="font-extrabold text-xl text-slate-800 leading-tight">
                                {{ $header }}
                            </h2>
                        @endif
                    </div>
                    <div class="flex items-center gap-3">
                        <livewire:layout.ticket-notifier />
                    </div>
                </div>
            </header>

            <!-- Main scrollable area -->
            <main class="flex-1 overflow-y-auto p-4 md:p-8 bg-slate-50/50">
                {{ $slot }}
            </main>
        </div>
    </body>
</html>
