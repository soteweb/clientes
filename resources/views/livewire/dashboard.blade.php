<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle -->
    <div class="mb-2">
        <p class="text-sm text-slate-500 font-medium">Resumen financiero y actividad reciente</p>
    </div>

    <!-- Filter Bar & Quick Actions -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col lg:flex-row items-center justify-between gap-4">
        <div class="flex flex-wrap items-end gap-4 w-full lg:w-auto">
            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Desde</label>
                <input wire:model="desde" type="date" class="px-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-700 font-medium">
            </div>

            <div>
                <label class="block text-xs font-semibold text-slate-500 mb-1">Hasta</label>
                <input wire:model="hasta" type="date" class="px-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-700 font-medium">
            </div>

            <div class="w-full sm:w-64">
                <label class="block text-xs font-semibold text-slate-500 mb-1">Cliente</label>
                <select wire:model="selected_client" class="w-full px-3 py-2 text-sm border border-slate-200 rounded-lg bg-slate-50 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:bg-white text-slate-700 font-medium">
                    <option value="">Seleccionar...</option>
                    @foreach($clientes as $cli)
                        <option value="{{ $cli->cliente_id }}">{{ $cli->empresa ?: $cli->titular ?: 'Sin nombre' }}</option>
                    @endforeach
                </select>
            </div>

            <div class="flex items-center gap-2">
                <button wire:click="$refresh" class="inline-flex items-center gap-1.5 px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white font-semibold text-sm rounded-lg shadow-sm transition-colors">
                    <x-heroicon-s-funnel class="w-4 h-4"/> Filtrar
                </button>
                <button wire:click="limpiar" class="px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-lg transition-colors bg-white shadow-sm">
                    Limpiar
                </button>
            </div>
        </div>

        <div class="flex items-center gap-3 w-full lg:w-auto justify-end border-t lg:border-t-0 pt-4 lg:pt-0 border-slate-100">
            <a href="{{ route('payments.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-lg bg-white shadow-sm transition-colors">
                <x-heroicon-o-credit-card class="w-4 h-4 text-blue-600"/> Pagos
            </a>
            <a href="{{ route('clients.index') }}" class="inline-flex items-center gap-2 px-4 py-2 border border-slate-200 hover:bg-slate-50 text-slate-700 font-semibold text-sm rounded-lg bg-white shadow-sm transition-colors">
                <x-heroicon-o-users class="w-4 h-4 text-blue-600"/> Clientes
            </a>
        </div>
    </div>

    <!-- Stat Cards Grid -->
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
        <!-- Card 1 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ingresos totales</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                    {{ number_format($ingresosTotales, 0, ',', '.') }}
                </h3>
            </div>
            <p class="text-xs text-slate-500 mt-4 font-medium">Acumulado {{ \Carbon\Carbon::parse($desde)->format('Y') }}</p>
        </div>

        <!-- Card 2 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ingreso del Mes</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                    {{ number_format($ingresoMes, 0, ',', '.') }}
                </h3>
            </div>
            <p class="text-xs text-slate-500 mt-4 font-medium capitalize">{{ \Carbon\Carbon::now()->translatedFormat('F Y') }}</p>
        </div>

        <!-- Card 3 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Ingreso de Hoy</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                    {{ number_format($ingresoHoy, 0, ',', '.') }}
                </h3>
            </div>
            <p class="text-xs text-slate-500 mt-4 font-medium">{{ \Carbon\Carbon::now()->format('d/m/Y') }}</p>
        </div>

        <!-- Card 4 -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-6 flex flex-col justify-between hover:shadow-md transition-shadow">
            <div>
                <p class="text-xs font-semibold text-slate-400 uppercase tracking-wider">Clientes Activos</p>
                <h3 class="text-3xl font-extrabold text-slate-900 mt-2">
                    {{ $clientesActivos }}
                </h3>
            </div>
            <p class="text-xs text-slate-500 mt-4 font-medium">Total en cartera</p>
        </div>
    </div>

    <!-- Próximos Vencimientos Panel -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 border-l-4 border-l-amber-500 overflow-hidden">
        <div class="p-6 border-b border-slate-100 flex items-center justify-between">
            <div class="flex items-center gap-2 text-amber-600 font-bold text-lg">
                <x-heroicon-o-clock class="w-6 h-6"/> Próximos Vencimientos
            </div>
            <a href="{{ route('payments.index') }}" class="text-xs font-semibold text-slate-400 hover:text-blue-600 transition-colors">
                Ver Historial
            </a>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="text-xs font-semibold text-slate-400 uppercase bg-slate-50 border-b border-slate-100">
                        <th class="py-3 px-6">Fecha Vencimiento</th>
                        <th class="py-3 px-6">Cliente</th>
                        <th class="py-3 px-6">Servicio</th>
                        <th class="py-3 px-6">Contacto</th>
                        <th class="py-3 px-6 text-right">Monto Esperado</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 text-sm">
                    @forelse($vencimientos as $item)
                        @php
                            $fecha = \Carbon\Carbon::parse($item->fecha_proximo_pago);
                            $diff = \Carbon\Carbon::now()->startOfDay()->diffInDays($fecha, false);
                            $client = $item->client;
                            $telClean = $client ? preg_replace('/[^0-9]/', '', $client->telefono) : '';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 font-bold {{ $diff < 0 ? 'text-red-600' : ($diff <= 7 ? 'text-amber-600' : 'text-slate-800') }}">
                                {{ $fecha->format('d/m/Y') }}
                                @if($diff < 0)
                                    <span class="text-[10px] bg-red-100 text-red-700 font-semibold px-1.5 py-0.5 rounded ml-2">Vencido</span>
                                @elseif($diff == 0)
                                    <span class="text-[10px] bg-amber-100 text-amber-800 font-semibold px-1.5 py-0.5 rounded ml-2">Hoy</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $client ? ($client->empresa ?: $client->titular ?: 'Sin Nombre') : 'Cliente Eliminado' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium max-w-md truncate">
                                {{ $item->servicio }}
                            </td>
                            <td class="py-4 px-6 text-slate-600">
                                @if($client && $client->telefono)
                                    <div class="flex items-center gap-2">
                                        <span>{{ $client->telefono }}</span>
                                        @if(!empty($telClean))
                                            <a href="https://wa.me/{{ $telClean }}" target="_blank" title="Enviar WhatsApp" class="text-emerald-500 hover:text-emerald-600 transition-transform hover:scale-110 inline-block">
                                                <svg class="w-5 h-5 fill-current" viewBox="0 0 24 24">
                                                    <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                                </svg>
                                            </a>
                                        @endif
                                    </div>
                                @else
                                    <span class="text-slate-400">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900 text-right">
                                {{ is_numeric($item->monto) ? number_format((float)$item->monto, 0, ',', '.') : $item->monto }}
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-10 text-center text-slate-400 font-medium">
                                No se encontraron próximos vencimientos en este rango.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
