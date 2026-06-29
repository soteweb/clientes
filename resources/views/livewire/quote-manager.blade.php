<div class="py-6">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <!-- Header & Actions -->
            <div class="p-6 border-b border-slate-100 flex flex-col sm:flex-row sm:items-center justify-between gap-4">
                <div class="flex items-center gap-4 w-full sm:w-1/2">
                    <div class="relative w-full max-w-md">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
                        </div>
                        <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors" placeholder="Buscar por cliente prospecto o empresa...">
                    </div>
                </div>
                <div>
                    <button wire:click="create()" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors">
                        <x-heroicon-o-plus class="w-5 h-5 mr-2 -ml-1"/> Nuevo Presupuesto
                    </button>
                </div>
            </div>

            @if (session()->has('message'))
                <div class="bg-green-50 border-l-4 border-green-500 p-4 m-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-check-circle class="h-5 w-5 text-green-400"/>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-green-700">
                                {{ session('message') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif
            @if (session()->has('error'))
                <div class="bg-red-50 border-l-4 border-red-500 p-4 m-6 rounded-r-lg">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-o-x-circle class="h-5 w-5 text-red-400"/>
                        </div>
                        <div class="ml-3">
                            <p class="text-sm text-red-700">
                                {{ session('error') }}
                            </p>
                        </div>
                    </div>
                </div>
            @endif

            <!-- Table -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-200">
                    <thead class="bg-slate-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Fecha / Cliente</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Moneda / Total</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Estado</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($quotes as $quote)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500 mb-1">{{ \Carbon\Carbon::parse($quote->fecha)->format('d/m/Y') }}</div>
                                <div class="text-sm font-bold text-slate-900">
                                    {{ $quote->client ? ($quote->client->empresa ?: $quote->client->titular) : ($quote->cliente_prospecto ?: 'Sin Cliente') }}
                                </div>
                                @if(!$quote->client && $quote->cliente_prospecto)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-purple-100 text-purple-800">Prospecto</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm text-slate-500">{{ $quote->moneda }}</div>
                                <div class="text-sm font-bold text-slate-900">${{ number_format((float)$quote->total, 2) }}</div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap">
                                @if($quote->estado == 'Aprobado')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-green-100 text-green-800">Aprobado</span>
                                @elseif($quote->estado == 'Rechazado')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-red-100 text-red-800">Rechazado</span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-amber-100 text-amber-800">Pendiente</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="openViewModal({{ $quote->id }})" class="text-purple-600 hover:text-purple-900 bg-purple-50 p-2 rounded-lg transition-colors mr-2" title="Ver Detalles">
                                    <x-heroicon-o-eye class="w-5 h-5"/>
                                </button>
                                <button wire:click="edit({{ $quote->id }})" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg transition-colors mr-2" title="Editar">
                                    <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                </button>
                                @if(auth()->user()->rol === 'administrador')
                                <button wire:click="delete({{ $quote->id }})" wire:confirm="¿Estás seguro de que deseas eliminar este presupuesto?" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition-colors" title="Eliminar">
                                    <x-heroicon-o-trash class="w-5 h-5"/>
                                </button>
                                @endif
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                <x-heroicon-o-document-text class="mx-auto h-12 w-12 text-slate-300"/>
                                <h3 class="mt-2 text-sm font-medium text-slate-900">No hay presupuestos</h3>
                                <p class="mt-1 text-sm text-slate-500">No se encontraron presupuestos registrados.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Create / Edit Modal -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-4xl sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-slate-900 mb-6 border-b pb-4" id="modal-title">
                                    {{ $quote_id ? 'Editar Presupuesto #' . $quote_id : 'Nuevo Presupuesto' }}
                                </h3>
                                
                                <!-- General Quote Fields -->
                                <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8 bg-slate-50 p-4 rounded-xl border border-slate-200">
                                    <div>
                                        <label for="cliente_id" class="block text-sm font-medium text-slate-700">Cliente Existente</label>
                                        <select wire:model="cliente_id" id="cliente_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="">-- Seleccionar o dejar en blanco --</option>
                                            @foreach($clients as $client)
                                                <option value="{{ $client->cliente_id }}">{{ $client->empresa ?: $client->titular }}</option>
                                            @endforeach
                                        </select>
                                    </div>

                                    <div>
                                        <label for="cliente_prospecto" class="block text-sm font-medium text-slate-700">Cliente Prospecto (Si no existe)</label>
                                        <input type="text" wire:model="cliente_prospecto" id="cliente_prospecto" placeholder="Nombre de empresa/contacto" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                    </div>

                                    <div>
                                        <label for="fecha" class="block text-sm font-medium text-slate-700">Fecha *</label>
                                        <input type="date" wire:model="fecha" id="fecha" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                        @error('fecha') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="moneda" class="block text-sm font-medium text-slate-700">Moneda *</label>
                                        <select wire:model="moneda" id="moneda" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="PYG">Guaraníes (PYG)</option>
                                            <option value="USD">Dólares (USD)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="estado" class="block text-sm font-medium text-slate-700">Estado *</label>
                                        <select wire:model="estado" id="estado" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="Pendiente">Pendiente</option>
                                            <option value="Aprobado">Aprobado</option>
                                            <option value="Rechazado">Rechazado</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="observacion" class="block text-sm font-medium text-slate-700">Observación General</label>
                                        <input type="text" wire:model="observacion" id="observacion" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                    </div>
                                </div>

                                <!-- Dynamic Items Section -->
                                <div class="mb-6">
                                    <div class="flex justify-between items-center mb-4 border-b pb-2">
                                        <h4 class="font-bold text-slate-800 text-base">Ítems del Presupuesto</h4>
                                        <button type="button" wire:click="addItem" class="inline-flex items-center px-3 py-1.5 border border-transparent text-xs font-medium rounded-lg text-blue-700 bg-blue-100 hover:bg-blue-200 focus:outline-none transition-colors">
                                            <x-heroicon-o-plus class="w-4 h-4 mr-1"/> Agregar Ítem
                                        </button>
                                    </div>

                                    <div class="overflow-x-auto">
                                        <table class="min-w-full divide-y divide-slate-200 text-left">
                                            <thead>
                                                <tr class="text-xs font-semibold text-slate-500 uppercase bg-slate-50">
                                                    <th class="p-3 w-1/4">Producto / Servicio</th>
                                                    <th class="p-3 w-1/3">Descripción Detallada</th>
                                                    <th class="p-3 w-1/12">Cantidad</th>
                                                    <th class="p-3 w-1/6">Precio Unit.</th>
                                                    <th class="p-3 w-1/6">Subtotal</th>
                                                    <th class="p-3 w-12 text-center"></th>
                                                </tr>
                                            </thead>
                                            <tbody class="divide-y divide-slate-100">
                                                @foreach($items as $index => $item)
                                                <tr>
                                                    <td class="p-2">
                                                        <select wire:model.live="items.{{ $index }}.producto_id" class="block w-full py-1.5 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 text-xs">
                                                            <option value="">-- Personalizado --</option>
                                                            @foreach($products as $prod)
                                                                <option value="{{ $prod->id }}">{{ $prod->nombre }}</option>
                                                            @endforeach
                                                        </select>
                                                    </td>
                                                    <td class="p-2">
                                                        <input type="text" wire:model.live="items.{{ $index }}.descripcion" placeholder="Descripción del ítem..." class="block w-full py-1.5 px-3 border border-slate-300 rounded-md shadow-sm text-xs focus:ring-blue-500 focus:border-blue-500">
                                                        @error('items.'.$index.'.descripcion') <span class="text-red-500 text-[10px]">{{ $message }}</span> @enderror
                                                    </td>
                                                    <td class="p-2">
                                                        <input type="number" min="1" wire:model.live="items.{{ $index }}.cantidad" class="block w-full py-1.5 px-2 border border-slate-300 rounded-md shadow-sm text-xs focus:ring-blue-500 focus:border-blue-500 text-center">
                                                    </td>
                                                    <td class="p-2">
                                                        <input type="number" step="0.01" wire:model.live="items.{{ $index }}.precio_unitario" class="block w-full py-1.5 px-3 border border-slate-300 rounded-md shadow-sm text-xs focus:ring-blue-500 focus:border-blue-500 text-right">
                                                    </td>
                                                    <td class="p-2 text-right font-medium text-xs text-slate-800">
                                                        ${{ number_format((float)($items[$index]['subtotal'] ?? 0), 2) }}
                                                    </td>
                                                    <td class="p-2 text-center">
                                                        @if(count($items) > 1)
                                                        <button type="button" wire:click="removeItem({{ $index }})" class="text-red-500 hover:text-red-700 p-1 rounded hover:bg-red-50 transition-colors">
                                                            <x-heroicon-o-trash class="w-4 h-4"/>
                                                        </button>
                                                        @endif
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="flex justify-end items-center mt-6 p-4 bg-blue-50 rounded-xl border border-blue-100">
                                        <div class="text-right">
                                            <span class="text-xs uppercase font-semibold text-blue-800 tracking-wider">Total Estimado</span>
                                            <div class="text-2xl font-bold text-blue-900">${{ number_format((float)$total, 2) }} {{ $moneda }}</div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Detalles / Notas adicionales -->
                                <div class="mt-4">
                                    <label for="detalles" class="block text-sm font-medium text-slate-700">Términos y Condiciones / Notas Adicionales</label>
                                    <textarea wire:model="detalles" id="detalles" rows="3" placeholder="Forma de pago, validez de la oferta, plazos de entrega..." class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar Presupuesto
                        </button>
                        <button type="button" wire:click="closeModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-slate-700 hover:bg-slate-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- View Modal -->
    @if($isViewOpen && $selectedQuote)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeViewModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-3xl sm:w-full border border-slate-100">
                <div class="bg-white px-6 pt-6 pb-8">
                    <!-- Header -->
                    <div class="flex justify-between items-start border-b pb-6 mb-6">
                        <div>
                            <div class="flex items-center gap-3 mb-1">
                                <h3 class="text-2xl font-bold text-slate-900">Presupuesto #{{ $selectedQuote->id }}</h3>
                                @if($selectedQuote->estado == 'Aprobado')
                                    <span class="px-3 py-1 bg-green-100 text-green-800 font-semibold rounded-full text-xs">Aprobado</span>
                                @elseif($selectedQuote->estado == 'Rechazado')
                                    <span class="px-3 py-1 bg-red-100 text-red-800 font-semibold rounded-full text-xs">Rechazado</span>
                                @else
                                    <span class="px-3 py-1 bg-amber-100 text-amber-800 font-semibold rounded-full text-xs">Pendiente</span>
                                @endif
                            </div>
                            <p class="text-sm text-slate-500">Fecha de emisión: {{ \Carbon\Carbon::parse($selectedQuote->fecha)->format('d de F, Y') }}</p>
                        </div>
                        <button wire:click="closeViewModal()" class="text-slate-400 hover:text-slate-600 p-1 rounded-lg bg-slate-50 transition-colors">
                            <x-heroicon-o-x-mark class="w-6 h-6"/>
                        </button>
                    </div>

                    <!-- Client info -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 mb-6 grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs uppercase font-semibold text-slate-500 block mb-1">Cliente / Prospecto</span>
                            <div class="text-base font-bold text-slate-800">
                                {{ $selectedQuote->client ? ($selectedQuote->client->empresa ?: $selectedQuote->client->titular) : ($selectedQuote->cliente_prospecto ?: 'Sin Cliente') }}
                            </div>
                            @if($selectedQuote->client && $selectedQuote->client->ruc)
                                <div class="text-xs text-slate-600 mt-0.5">RUC: {{ $selectedQuote->client->ruc }}</div>
                            @endif
                        </div>
                        <div>
                            <span class="text-xs uppercase font-semibold text-slate-500 block mb-1">Observaciones Generales</span>
                            <div class="text-sm text-slate-700">{{ $selectedQuote->observacion ?: 'Ninguna' }}</div>
                        </div>
                    </div>

                    <!-- Items Table -->
                    <h4 class="font-bold text-slate-800 text-base mb-3 border-b pb-2">Desglose de Ítems</h4>
                    <table class="w-full text-left mb-6 border-collapse">
                        <thead>
                            <tr class="border-b border-slate-200 text-xs text-slate-500 uppercase font-semibold">
                                <th class="pb-3">Descripción</th>
                                <th class="pb-3 text-center">Cant.</th>
                                <th class="pb-3 text-right">Precio Unit.</th>
                                <th class="pb-3 text-right">Total</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 text-sm">
                            @foreach($selectedQuote->items as $item)
                            <tr>
                                <td class="py-3 font-medium text-slate-800">{{ $item->descripcion }}</td>
                                <td class="py-3 text-center text-slate-600">{{ $item->cantidad }}</td>
                                <td class="py-3 text-right text-slate-600">${{ number_format((float)$item->precio_unitario, 2) }}</td>
                                <td class="py-3 text-right font-bold text-slate-900">${{ number_format((float)$item->subtotal, 2) }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>

                    <!-- Summary box -->
                    <div class="flex justify-end border-t border-slate-200 pt-6 mb-6">
                        <div class="w-full md:w-1/2 bg-blue-50 p-4 rounded-xl border border-blue-100 flex justify-between items-center">
                            <span class="text-sm font-bold text-blue-900 uppercase">Total Presupuestado</span>
                            <span class="text-2xl font-black text-blue-950">${{ number_format((float)$selectedQuote->total, 2) }} {{ $selectedQuote->moneda }}</span>
                        </div>
                    </div>

                    @if($selectedQuote->detalles)
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 text-xs text-slate-600">
                        <span class="font-bold uppercase block mb-1 text-slate-700">Términos y Condiciones</span>
                        {!! nl2br(e($selectedQuote->detalles)) !!}
                    </div>
                    @endif
                </div>
                <div class="bg-slate-50 px-6 py-4 flex justify-between items-center border-t border-slate-100">
                    <button onclick="window.print()" class="inline-flex items-center px-4 py-2 bg-slate-800 text-white rounded-lg text-sm font-medium hover:bg-slate-900 transition-colors shadow-sm">
                        <x-heroicon-o-printer class="w-4 h-4 mr-2"/> Imprimir
                    </button>
                    <button wire:click="closeViewModal()" class="px-4 py-2 bg-white border border-slate-300 text-slate-700 rounded-lg text-sm font-medium hover:bg-slate-50 transition-colors shadow-sm">
                        Cerrar
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
