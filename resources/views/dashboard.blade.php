<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-slate-800 leading-tight">
            {{ __('Dashboard General') }}
        </h2>
    </x-slot>

    @php
        $totalClients = \App\Models\Client::count();
        $activeClients = \App\Models\Client::where('estado', 'Activo')->count();
        $totalPaymentsCount = \App\Models\Payment::count();
        $totalQuotes = \App\Models\Quote::count();

        // Últimos pagos recibidos
        $latestPayments = \App\Models\Payment::with('client')->orderBy('pago_id', 'desc')->take(5)->get();

        // Vencimientos (Próximos pagos o atrasados)
        $expirations = \App\Models\Payment::with('client')
            ->whereNotNull('fecha_proximo_pago')
            ->orderBy('fecha_proximo_pago', 'asc')
            ->take(5)
            ->get();
    @endphp

    <div class="py-6">
        <div class="max-w-7xl mx-auto space-y-6">
            
            <!-- Stat Cards -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                <!-- Stat Card 1 -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-blue-50 text-blue-600 rounded-lg">
                        <x-heroicon-s-users class="w-8 h-8"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Clientes Totales</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $totalClients }}</h3>
                    </div>
                </div>

                <!-- Stat Card 2 -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-green-50 text-green-600 rounded-lg">
                        <x-heroicon-s-check-circle class="w-8 h-8"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Clientes Activos</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $activeClients }}</h3>
                    </div>
                </div>

                <!-- Stat Card 3 -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-purple-50 text-purple-600 rounded-lg">
                        <x-heroicon-s-credit-card class="w-8 h-8"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Total Pagos Registrados</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $totalPaymentsCount }}</h3>
                    </div>
                </div>

                <!-- Stat Card 4 -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex items-center gap-4 hover:shadow-md transition-shadow">
                    <div class="p-3 bg-orange-50 text-orange-600 rounded-lg">
                        <x-heroicon-s-document-text class="w-8 h-8"/>
                    </div>
                    <div>
                        <p class="text-sm font-medium text-slate-500">Presupuestos Emitidos</p>
                        <h3 class="text-2xl font-bold text-slate-800">{{ $totalQuotes }}</h3>
                    </div>
                </div>
            </div>

            <!-- Vencimientos & Últimos Pagos -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                
                <!-- Últimos Pagos Recibidos -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-banknotes class="w-6 h-6 text-green-600"/>
                                <h3 class="text-lg font-bold text-slate-800">Últimos Pagos Recibidos</h3>
                            </div>
                            <a href="{{ route('payments.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Ver historial</a>
                        </div>
                        
                        <div class="divide-y divide-slate-100">
                            @forelse($latestPayments as $payment)
                            <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0 hover:bg-slate-50 rounded-lg px-2 transition-colors">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-lg bg-green-50 text-green-700 flex items-center justify-center font-bold text-sm">
                                        {{ \Carbon\Carbon::parse($payment->fecha)->format('d/m') }}
                                    </div>
                                    <div>
                                        <p class="font-bold text-sm text-slate-900">{{ $payment->client ? ($payment->client->empresa ?: $payment->client->titular) : 'Cliente Eliminado' }}</p>
                                        <p class="text-xs text-slate-500 truncate max-w-[200px] sm:max-w-xs">{{ $payment->servicio }}</p>
                                    </div>
                                </div>
                                <div class="text-right">
                                    <p class="font-bold text-sm text-slate-900">${{ \App\Models\Payment::formatMonto($payment->monto) }}</p>
                                    @if($payment->periodicidad)
                                        <span class="text-[10px] font-semibold bg-blue-50 text-blue-700 px-1.5 py-0.5 rounded">{{ $payment->periodicidad }}</span>
                                    @endif
                                </div>
                            </div>
                            @empty
                            <div class="text-center py-8 text-slate-400">No hay pagos registrados aún.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

                <!-- Próximos Vencimientos -->
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between">
                    <div>
                        <div class="flex justify-between items-center mb-6">
                            <div class="flex items-center gap-2">
                                <x-heroicon-o-clock class="w-6 h-6 text-amber-500"/>
                                <h3 class="text-lg font-bold text-slate-800">Próximos Vencimientos</h3>
                            </div>
                            <span class="text-xs font-medium text-slate-400">Fechas de próximo pago</span>
                        </div>
                        
                        <div class="divide-y divide-slate-100">
                            @forelse($expirations as $item)
                                @php
                                    $dueDate = \Carbon\Carbon::parse($item->fecha_proximo_pago);
                                    $diffDays = \Carbon\Carbon::now()->startOfDay()->diffInDays($dueDate, false);
                                @endphp
                                <div class="py-3 flex items-center justify-between first:pt-0 last:pb-0 hover:bg-slate-50 rounded-lg px-2 transition-colors">
                                    <div class="flex items-center gap-3">
                                        <div class="w-10 h-10 rounded-lg {{ $diffDays < 0 ? 'bg-red-50 text-red-700' : ($diffDays <= 7 ? 'bg-amber-50 text-amber-700' : 'bg-slate-100 text-slate-700') }} flex flex-col items-center justify-center font-bold text-xs leading-none">
                                            <span>{{ $dueDate->format('d') }}</span>
                                            <span class="text-[9px] uppercase font-normal">{{ $dueDate->format('M') }}</span>
                                        </div>
                                        <div>
                                            <p class="font-bold text-sm text-slate-900">{{ $item->client ? ($item->client->empresa ?: $item->client->titular) : 'Cliente Eliminado' }}</p>
                                            <p class="text-xs text-slate-500 truncate max-w-[180px] sm:max-w-xs">{{ $item->servicio }}</p>
                                        </div>
                                    </div>
                                    <div class="text-right">
                                        @if($diffDays < 0)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-red-100 text-red-800 block mb-0.5">Vencido hace {{ abs((int)$diffDays) }} días</span>
                                        @elseif($diffDays == 0)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 block mb-0.5">Vence hoy</span>
                                        @elseif($diffDays <= 7)
                                            <span class="px-2 py-0.5 rounded-full text-xs font-medium bg-amber-50 text-amber-700 block mb-0.5">En {{ (int)$diffDays }} días</span>
                                        @else
                                            <span class="text-xs text-slate-600 block mb-0.5 font-medium">Faltan {{ (int)$diffDays }} días</span>
                                        @endif
                                        <span class="text-xs font-bold text-slate-900">${{ \App\Models\Payment::formatMonto($item->monto) }}</span>
                                    </div>
                                </div>
                            @empty
                            <div class="text-center py-8 text-slate-400">No hay vencimientos programados.</div>
                            @endforelse
                        </div>
                    </div>
                </div>

            </div>

            <!-- Recent Clients and Quick Actions -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- Recent Clients -->
                <div class="lg:col-span-2 bg-white rounded-xl shadow-sm border border-slate-100 p-6">
                    <div class="flex justify-between items-center mb-6">
                        <h3 class="text-lg font-bold text-slate-800">Últimos Clientes Registrados</h3>
                        <a href="{{ route('clients.index') }}" class="text-sm font-medium text-blue-600 hover:text-blue-700">Ver todos</a>
                    </div>
                    
                    <div class="overflow-x-auto">
                        <table class="w-full text-left border-collapse">
                            <thead>
                                <tr class="text-xs font-semibold text-slate-500 uppercase border-b border-slate-100">
                                    <th class="pb-3">Empresa</th>
                                    <th class="pb-3">Teléfono</th>
                                    <th class="pb-3">Estado</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach(\App\Models\Client::orderBy('cliente_id', 'desc')->take(5)->get() as $client)
                                <tr class="border-b border-slate-50 last:border-0 hover:bg-slate-50 transition-colors">
                                    <td class="py-3 text-sm font-bold text-slate-800">{{ $client->empresa ?: $client->titular ?: 'Sin Nombre' }}</td>
                                    <td class="py-3 text-sm text-slate-500">{{ $client->telefono ?: '-' }}</td>
                                    <td class="py-3 text-sm">
                                        @if($client->estado == 'Activo')
                                            <span class="px-2 py-1 bg-green-100 text-green-700 rounded-md text-xs font-bold">Activo</span>
                                        @else
                                            <span class="px-2 py-1 bg-slate-100 text-slate-600 rounded-md text-xs font-medium">Inactivo</span>
                                        @endif
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- Quick Actions / Active Panel -->
                <div class="bg-gradient-to-br from-blue-600 to-indigo-700 rounded-xl shadow-md p-6 text-white flex flex-col justify-center items-center text-center relative overflow-hidden">
                    <div class="absolute top-0 right-0 -mt-4 -mr-4 w-24 h-24 bg-white opacity-10 rounded-full blur-xl"></div>
                    <div class="absolute bottom-0 left-0 -mb-4 -ml-4 w-32 h-32 bg-blue-400 opacity-20 rounded-full blur-xl"></div>
                    
                    <x-heroicon-o-users class="w-16 h-16 mb-4 opacity-90 relative z-10"/>
                    <h3 class="text-4xl font-extrabold mb-2 relative z-10">{{ $activeClients }}</h3>
                    <p class="text-blue-100 relative z-10 text-sm uppercase tracking-wider font-semibold">Clientes Activos</p>
                    
                    <a href="{{ route('clients.index') }}" class="mt-8 px-5 py-2.5 bg-white text-blue-700 rounded-xl font-bold shadow-sm hover:bg-blue-50 transition-colors relative z-10 inline-block">
                        Gestionar Clientes
                    </a>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>
