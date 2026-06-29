<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle -->
    <div class="mb-2">
        <p class="text-sm text-slate-500 font-medium">Registro de ingresos y egresos</p>
    </div>

    <!-- Search & New Button -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full max-w-xl">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 text-sm font-medium transition-colors" placeholder="Buscar en este listado...">
        </div>
        <div>
            <button wire:click="create()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Pago
            </button>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-lg shadow-sm">
            <div class="flex items-center">
                <x-heroicon-o-check-circle class="h-5 w-5 text-green-500 mr-3"/>
                <p class="text-sm font-semibold text-green-800">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Table Card -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Fecha</th>
                        <th class="py-3 px-6">Empresa</th>
                        <th class="py-3 px-6">Servicio</th>
                        <th class="py-3 px-6 text-right">Monto</th>
                        <th class="py-3 px-6 text-center">Periodicidad</th>
                        <th class="py-3 px-6">Próximo Pago</th>
                        <th class="py-3 px-6 text-center">Estado</th>
                        <th class="py-3 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($payments as $payment)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 text-slate-600 font-semibold whitespace-nowrap">
                                {{ \Carbon\Carbon::parse($payment->fecha)->format('d/m/Y') }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $payment->client ? ($payment->client->empresa ?: $payment->client->titular ?: 'Sin nombre') : 'Cliente Eliminado' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium max-w-md truncate" title="{{ $payment->servicio }}">
                                {{ $payment->servicio }}
                            </td>
                            <td class="py-4 px-6 font-extrabold text-slate-900 text-right whitespace-nowrap">
                                {{ \App\Models\Payment::formatMonto($payment->monto) }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($payment->periodicidad)
                                    <span class="px-3 py-1 inline-flex text-xs font-bold uppercase rounded-full bg-amber-100 text-amber-800 border border-amber-200/60">
                                        {{ $payment->periodicidad }}
                                    </span>
                                @else
                                    <span class="text-slate-300">-</span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-semibold whitespace-nowrap">
                                {{ $payment->fecha_proximo_pago ? \Carbon\Carbon::parse($payment->fecha_proximo_pago)->format('d/m/Y') : '-' }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if(($payment->estado ?? 'Pagado') == 'Pagado')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Pagado
                                    </span>
                                @elseif($payment->estado == 'Pendiente')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-red-100 text-red-800 border border-red-200 animate-pulse">
                                        Deudor / Moroso
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-slate-100 text-slate-700 border border-slate-200">
                                        No Continúa
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button wire:click="viewPayment({{ $payment->pago_id }})" title="Ver Detalle" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-eye class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="edit({{ $payment->pago_id }})" title="Editar Pago" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                    </button>
                                    @if(auth()->user()->rol === 'administrador')
                                    <button wire:click="delete({{ $payment->pago_id }})" wire:confirm="¿Estás seguro de eliminar este registro?" title="Eliminar" class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 font-medium">
                                <x-heroicon-o-banknotes class="w-12 h-12 mx-auto text-slate-300 mb-3"/>
                                No se encontraron pagos registrados.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 mb-4" id="modal-title">
                                    {{ $pago_id ? 'Editar Pago' : 'Registrar Nuevo Pago' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="fecha" class="block text-sm font-semibold text-slate-700">Fecha de Pago *</label>
                                        <input type="date" wire:model="fecha" id="fecha" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('fecha') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="cliente_id" class="block text-sm font-semibold text-slate-700">Cliente *</label>
                                        <select wire:model="cliente_id" id="cliente_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="">Seleccione un cliente</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->cliente_id }}">{{ $client->empresa ?: $client->titular }}</option>
                                            @endforeach
                                        </select>
                                        @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="servicio" class="block text-sm font-semibold text-slate-700">Servicio o Detalle *</label>
                                        <input type="text" wire:model="servicio" id="servicio" placeholder="Ej: Hosting anual + Dominio" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('servicio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="monto" class="block text-sm font-semibold text-slate-700">Monto *</label>
                                        <input type="text" wire:model="monto" id="monto" placeholder="Ej: 1500000" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('monto') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="periodicidad" class="block text-sm font-semibold text-slate-700">Periodicidad</label>
                                        <input type="text" wire:model="periodicidad" id="periodicidad" placeholder="Ej: Anual, Mensual" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="fecha_proximo_pago" class="block text-sm font-semibold text-slate-700">Próximo Vencimiento</label>
                                        <input type="date" wire:model="fecha_proximo_pago" id="fecha_proximo_pago" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="estado" class="block text-sm font-semibold text-slate-700">Estado del Cobro *</label>
                                        <select wire:model="estado" id="estado" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Pagado">Pagado (Todo al día)</option>
                                            <option value="Pendiente">Pendiente (Deudor / Moroso)</option>
                                            <option value="No Continua">No Continúa (Cancelado / Archivado)</option>
                                        </select>
                                        @error('estado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Vincular a Pool de Recursos (Reseller) -->
                                    <div class="col-span-2 border-t border-slate-150 pt-4 mt-2">
                                        <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-3">Vincular a Compra de Proveedor (Reseller)</h4>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="pool_id" class="block text-sm font-semibold text-slate-700">Pool / Servidor</label>
                                                <select wire:model="pool_id" id="pool_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                                    <option value="">No vincular a ningún pool (Venta directa)</option>
                                                    @foreach($pools as $pl)
                                                        <option value="{{ $pl->pool_id }}">{{ $pl->nombre }} ({{ $pl->recurso_tipo }})</option>
                                                    @endforeach
                                                </select>
                                                @error('pool_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            <div>
                                                <label for="porcion_recurso" class="block text-sm font-semibold text-slate-700">Porción de Recurso Asignada</label>
                                                <input type="text" wire:model="porcion_recurso" id="porcion_recurso" placeholder="Ej: 15.00 (GB o Licencias)" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                                @error('porcion_recurso') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-span-2">
                                        <label for="observacion" class="block text-sm font-semibold text-slate-700">Notas u Observaciones</label>
                                        <textarea wire:model="observacion" id="observacion" rows="3" placeholder="Anotaciones internas del pago..." class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md font-medium"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">
                            Guardar Pago
                        </button>
                        <button type="button" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal Ficha de Pago -->
    @if($isViewOpen && $activePayment)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-gradient-to-r from-emerald-600 to-teal-700 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-s-banknotes class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">Detalle del Registro de Pago</h3>
                            <p class="text-sm text-emerald-100 font-medium">ID #{{ $activePayment->pago_id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeViewModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Cliente Info -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Cliente Asociado</span>
                            <h4 class="font-bold text-slate-900 text-lg">{{ $activePayment->client ? ($activePayment->client->empresa ?: $activePayment->client->titular) : 'Cliente Eliminado' }}</h4>
                            @if($activePayment->client && $activePayment->client->telefono)
                                <p class="text-xs text-slate-500 font-medium mt-0.5">Tel: {{ $activePayment->client->telefono }}</p>
                            @endif
                        </div>
                        @if($activePayment->client && $activePayment->client->telefono)
                            @php
                                $telClean = preg_replace('/[^0-9]/', '', $activePayment->client->telefono);
                            @endphp
                            @if(!empty($telClean))
                                <a href="https://wa.me/{{ $telClean }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold transition-transform hover:scale-105 shadow-sm">
                                    <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> Contactar
                                </a>
                            @endif
                        @endif
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Servicio Contratado</span>
                            <span class="font-bold text-slate-800 text-base">{{ $activePayment->servicio }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Monto Cobrado</span>
                            <span class="font-extrabold text-emerald-600 text-xl">${{ \App\Models\Payment::formatMonto($activePayment->monto) }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Fecha de Pago</span>
                            <span class="font-bold text-slate-800">{{ \Carbon\Carbon::parse($activePayment->fecha)->format('d/m/Y') }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Periodicidad</span>
                            <span class="font-bold text-slate-800">{{ $activePayment->periodicidad ?: 'Único / No especificado' }}</span>
                        </div>
                        <div class="col-span-2">
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Próximo Vencimiento</span>
                            <span class="font-bold {{ $activePayment->fecha_proximo_pago ? (\Carbon\Carbon::now()->startOfDay()->gt(\Carbon\Carbon::parse($activePayment->fecha_proximo_pago)) ? 'text-red-600' : 'text-amber-600') : 'text-slate-800' }}">
                                {{ $activePayment->fecha_proximo_pago ? \Carbon\Carbon::parse($activePayment->fecha_proximo_pago)->format('d/m/Y') : 'No aplica / Sin próximo pago' }}
                            </span>
                        </div>
                        @if($activePayment->pool)
                        <div class="col-span-2 border-t pt-3 bg-blue-50/50 p-3 rounded-lg border border-blue-100">
                            <span class="text-xs text-blue-500 font-bold uppercase block mb-1">Vínculo Reseller (Proveedor)</span>
                            <div class="flex justify-between text-xs font-semibold text-slate-700">
                                <span>Pool / Servidor:</span>
                                <span class="font-extrabold text-blue-700">{{ $activePayment->pool->nombre }}</span>
                            </div>
                            <div class="flex justify-between text-xs font-semibold text-slate-700 mt-1">
                                <span>Proveedor:</span>
                                <span class="font-bold text-slate-600">{{ $activePayment->pool->supplier ? $activePayment->pool->supplier->nombre : 'Sin proveedor' }}</span>
                            </div>
                            <div class="flex justify-between text-xs font-semibold text-slate-700 mt-1">
                                <span>Porción Asignada:</span>
                                <span class="font-extrabold text-indigo-700">
                                    {{ number_format($activePayment->porcion_recurso, 1, ',', '.') }} {{ $activePayment->pool->recurso_tipo }}
                                </span>
                            </div>
                        </div>
                        @endif
                        @if($activePayment->observacion)
                        <div class="col-span-2 border-t pt-3">
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Notas Adicionales</span>
                            <p class="text-sm text-slate-700 italic mt-1">{{ $activePayment->observacion }}</p>
                        </div>
                        @endif
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100">
                    <button type="button" wire:click="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg font-bold text-sm hover:bg-slate-50 transition-colors">
                        Cerrar Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
