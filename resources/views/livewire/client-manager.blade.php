<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle -->
    <div class="mb-2">
        <p class="text-sm text-slate-500 font-medium">Gestiona tu cartera de clientes</p>
    </div>

    <!-- Search & New Button -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full max-w-xl">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 text-sm font-medium transition-colors" placeholder="Buscar por titular, empresa, ruc o email...">
        </div>
        <div>
            <button wire:click="create()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Cliente
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
            <table class="min-w-full divide-y divide-slate-100">
                <thead class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider text-left">
                    <tr>
                        <th class="py-3 px-6">Titular</th>
                        <th class="py-3 px-6">Empresa</th>
                        <th class="py-3 px-6">Contacto</th>
                        <th class="py-3 px-6 text-center">Estado</th>
                        <th class="py-3 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($clients as $client)
                        @php
                            $telClean = $client->telefono ? preg_replace('/[^0-9]/', '', $client->telefono) : '';
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 font-bold text-slate-900">
                                {{ $client->titular ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium">
                                <div class="font-bold text-slate-900">{{ $client->empresa ?: 'Sin Empresa' }}</div>
                                @if($client->ciudad || $client->direccion)
                                    <div class="text-xs text-slate-400">{{ $client->ciudad ?: '' }} {{ $client->direccion ? '('.$client->direccion.')' : '' }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6">
                                <div class="flex items-center gap-2 font-semibold text-slate-800">
                                    <span>{{ $client->telefono ?: '-' }}</span>
                                    @if(!empty($telClean))
                                        <a href="https://wa.me/{{ $telClean }}" target="_blank" title="WhatsApp" class="text-emerald-500 hover:text-emerald-600 transition-transform hover:scale-110">
                                            <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24">
                                                <path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/>
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                                <div class="text-xs text-slate-400">{{ $client->email ?: 'Sin email' }}</div>
                            </td>
                            <td class="py-4 px-6 text-center">
                                @if($client->estado == 'Activo')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-emerald-100 text-emerald-800">
                                        Activo
                                    </span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-bold rounded-full bg-amber-100 text-amber-800">
                                        Inactivo
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button wire:click="viewPayments({{ $client->cliente_id }})" title="Ver Pagos" class="p-1.5 text-emerald-600 hover:text-emerald-900 hover:bg-emerald-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-banknotes class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="viewClient({{ $client->cliente_id }})" title="Ver Ficha de Cliente" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors">
                                        <x-heroicon-o-eye class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="edit({{ $client->cliente_id }})" title="Editar Cliente" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors">
                                        <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="delete({{ $client->cliente_id }})" wire:confirm="¿Estás seguro de eliminar este cliente?" title="Eliminar" class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors">
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-12 text-center text-slate-400 font-medium">
                                <x-heroicon-o-user-group class="w-12 h-12 mx-auto text-slate-300 mb-3"/>
                                No se encontraron clientes con esos términos.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Create/Edit Modal -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 mb-4" id="modal-title">
                                    {{ $cliente_id ? 'Editar Cliente' : 'Nuevo Cliente' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="empresa" class="block text-sm font-semibold text-slate-700">Empresa *</label>
                                        <input type="text" wire:model="empresa" id="empresa" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('empresa') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="titular" class="block text-sm font-semibold text-slate-700">Titular</label>
                                        <input type="text" wire:model="titular" id="titular" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="ruc" class="block text-sm font-semibold text-slate-700">RUC</label>
                                        <input type="text" wire:model="ruc" id="ruc" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="telefono" class="block text-sm font-semibold text-slate-700">Teléfono</label>
                                        <input type="text" wire:model="telefono" id="telefono" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium" placeholder="Ej. +595981... o 0981...">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="email" class="block text-sm font-semibold text-slate-700">Email</label>
                                        <input type="email" wire:model="email" id="email" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="estado" class="block text-sm font-semibold text-slate-700">Estado *</label>
                                        <select wire:model="estado" id="estado" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Activo">Activo</option>
                                            <option value="Inactivo">Inactivo</option>
                                        </select>
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="direccion" class="block text-sm font-semibold text-slate-700">Dirección</label>
                                        <input type="text" wire:model="direccion" id="direccion" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="ciudad" class="block text-sm font-semibold text-slate-700">Ciudad</label>
                                        <input type="text" wire:model="ciudad" id="ciudad" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2">
                                        <label for="observacion" class="block text-sm font-semibold text-slate-700">Observación</label>
                                        <textarea wire:model="observacion" id="observacion" rows="3" class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md font-medium"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">
                            Guardar
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

    <!-- Modal Ver Ficha de Cliente -->
    @if($isViewOpen && $activeClient)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl uppercase">
                            {{ substr($activeClient->empresa ?: $activeClient->titular ?: 'C', 0, 1) }}
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">{{ $activeClient->empresa ?: 'Sin Empresa' }}</h3>
                            <p class="text-sm text-blue-100 font-medium">{{ $activeClient->titular ?: 'Titular no especificado' }}</p>
                        </div>
                    </div>
                    <button wire:click="closeViewModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <div>
                            <span class="text-xs text-slate-400 font-semibold block uppercase">RUC</span>
                            <span class="font-bold text-slate-800">{{ $activeClient->ruc ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold block uppercase">Estado</span>
                            <span class="font-bold {{ $activeClient->estado == 'Activo' ? 'text-emerald-600' : 'text-amber-600' }}">{{ $activeClient->estado }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold block uppercase">Teléfono / WhatsApp</span>
                            <span class="font-bold text-slate-800">{{ $activeClient->telefono ?: '-' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold block uppercase">Correo Electrónico</span>
                            <span class="font-bold text-slate-800">{{ $activeClient->email ?: '-' }}</span>
                        </div>
                        <div class="sm:col-span-2">
                            <span class="text-xs text-slate-400 font-semibold block uppercase">Ubicación</span>
                            <span class="font-bold text-slate-800">{{ $activeClient->direccion ?: 'Sin dirección' }} {{ $activeClient->ciudad ? ' - '.$activeClient->ciudad : '' }}</span>
                        </div>
                        @if($activeClient->observacion)
                        <div class="sm:col-span-2 border-t pt-3">
                            <span class="text-xs text-slate-400 font-semibold block uppercase">Observaciones</span>
                            <p class="text-sm text-slate-700 italic mt-1">{{ $activeClient->observacion }}</p>
                        </div>
                        @endif
                    </div>

                    <!-- Lista de Presupuestos Emitidos -->
                    <div>
                        <h4 class="font-bold text-slate-900 mb-3 flex items-center gap-2">
                            <x-heroicon-o-document-text class="w-5 h-5 text-blue-600"/> Presupuestos de este Cliente ({{ $activeClient->quotes->count() }})
                        </h4>
                        <div class="divide-y divide-slate-100 max-h-48 overflow-y-auto bg-white border border-slate-200 rounded-xl">
                            @forelse($activeClient->quotes as $qt)
                                <div class="p-3 flex items-center justify-between hover:bg-slate-50 transition-colors">
                                    <div>
                                        <span class="font-bold text-sm text-slate-800">Presupuesto #{{ $qt->id }}</span>
                                        <span class="text-xs text-slate-500 block">{{ \Carbon\Carbon::parse($qt->fecha)->format('d/m/Y') }}</span>
                                    </div>
                                    <div class="text-right">
                                        <span class="font-bold text-sm text-blue-600">{{ $qt->moneda == 'USD' ? 'u$' : '$' }} {{ number_format((float)$qt->total, 0, ',', '.') }}</span>
                                    </div>
                                </div>
                            @empty
                                <div class="p-4 text-center text-slate-400 text-sm font-medium">No hay presupuestos registrados para este cliente.</div>
                            @endforelse
                        </div>
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

    <!-- Modal Ver Pagos de Cliente -->
    @if($isPaymentsOpen && $activeClient)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closePaymentsModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-emerald-600 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-s-banknotes class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">Historial de Pagos</h3>
                            <p class="text-sm text-emerald-100 font-medium">{{ $activeClient->empresa ?: $activeClient->titular }}</p>
                        </div>
                    </div>
                    <button wire:click="closePaymentsModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <h4 class="font-bold text-slate-900 text-base">Pagos Recibidos ({{ $activeClient->payments->count() }})</h4>
                        <a href="{{ route('payments.index') }}" class="inline-flex items-center gap-1.5 text-xs font-bold bg-emerald-50 text-emerald-700 px-3 py-1.5 rounded-lg hover:bg-emerald-100 transition-colors">
                            <x-heroicon-o-plus class="w-4 h-4"/> Registrar Nuevo Pago
                        </a>
                    </div>

                    <div class="divide-y divide-slate-100 max-h-72 overflow-y-auto border border-slate-200 rounded-xl bg-white">
                        @forelse($activeClient->payments as $pm)
                            <div class="p-4 flex flex-col sm:flex-row sm:items-center justify-between gap-2 hover:bg-slate-50 transition-colors">
                                <div>
                                    <div class="flex items-center gap-2 font-bold text-sm text-slate-900">
                                        <span>{{ $pm->servicio ?: 'Servicio General' }}</span>
                                        @if($pm->periodicidad)
                                            <span class="bg-slate-100 text-slate-700 px-2 py-0.5 rounded text-[10px] font-semibold uppercase">{{ $pm->periodicidad }}</span>
                                        @endif
                                    </div>
                                    <div class="text-xs text-slate-500 mt-1 flex items-center gap-4">
                                        <span>Fecha: {{ \Carbon\Carbon::parse($pm->fecha)->format('d/m/Y') }}</span>
                                        @if($pm->fecha_proximo_pago)
                                            <span class="text-amber-600 font-semibold">Próx. vencimiento: {{ \Carbon\Carbon::parse($pm->fecha_proximo_pago)->format('d/m/Y') }}</span>
                                        @endif
                                    </div>
                                    @if($pm->observacion)
                                        <p class="text-xs text-slate-500 italic mt-1">{{ $pm->observacion }}</p>
                                    @endif
                                </div>
                                <div class="text-right sm:self-center">
                                    <span class="font-extrabold text-base text-emerald-600">${{ \App\Models\Payment::formatMonto($pm->monto) }}</span>
                                </div>
                            </div>
                        @empty
                            <div class="p-8 text-center text-slate-400 font-medium text-sm">
                                No se encontraron pagos registrados para este cliente.
                            </div>
                        @endforelse
                    </div>
                </div>

                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100">
                    <button type="button" wire:click="closePaymentsModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-lg font-bold text-sm hover:bg-slate-50 transition-colors">
                        Cerrar Ventana
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
