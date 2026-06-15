<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle -->
    <div class="mb-2">
        <p class="text-sm text-slate-500 font-medium">Administra tu inventario y servicios</p>
    </div>

    <!-- Search & New Button -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 flex flex-col sm:flex-row items-center justify-between gap-4">
        <div class="relative w-full max-w-xl">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
            </div>
            <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 text-sm font-medium transition-colors" placeholder="Buscar por nombre o descripción...">
        </div>
        <div>
            <button wire:click="create()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Item
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
                        <th class="py-3 px-6">Nombre</th>
                        <th class="py-3 px-6 text-center">Tipo</th>
                        <th class="py-3 px-6">Proveedor</th>
                        <th class="py-3 px-6">Periodicidad</th>
                        <th class="py-3 px-6 text-right">Costo</th>
                        <th class="py-3 px-6 text-right">Precio</th>
                        <th class="py-3 px-6 text-right">Margen</th>
                        <th class="py-3 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($products as $product)
                        @php
                            $costoVal = is_numeric($product->costo) ? (float)$product->costo : 0;
                            $precioVal = is_numeric($product->precio) ? (float)$product->precio : 0;
                            $margenVal = $precioVal - $costoVal;
                        @endphp
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 max-w-md">
                                <div class="font-bold text-slate-900">{{ $product->nombre }}</div>
                                @if($product->descripcion)
                                    <div class="text-xs text-slate-400 line-clamp-1 mt-0.5" title="{{ $product->descripcion }}">{{ $product->descripcion }}</div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if(strtolower($product->tipo) == 'servicio')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        Servicio
                                    </span>
                                @elseif(strtolower($product->tipo) == 'producto')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-emerald-100 text-emerald-800 border border-emerald-200">
                                        Producto
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        {{ $product->tipo ?: 'Servicio' }}
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium whitespace-nowrap">
                                {{ $product->proveedor ?: '-' }}
                            </td>
                            <td class="py-4 px-6 text-slate-600 font-medium whitespace-nowrap">
                                {{ $product->periodicidad ?: 'Único' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-700 text-right whitespace-nowrap">
                                {{ $costoVal > 0 ? number_format($costoVal, 0, ',', '.') : '0' }}
                            </td>
                            <td class="py-4 px-6 font-bold text-slate-900 text-right whitespace-nowrap">
                                {{ $precioVal > 0 ? number_format($precioVal, 0, ',', '.') : '0' }}
                            </td>
                            <td class="py-4 px-6 font-extrabold text-emerald-600 text-right whitespace-nowrap">
                                {{ $margenVal > 0 ? number_format($margenVal, 0, ',', '.') : '0' }}
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button wire:click="viewProduct({{ $product->id }})" title="Ver Ficha" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-eye class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="edit({{ $product->id }})" title="Editar Item" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                    </button>
                                    <button wire:click="delete({{ $product->id }})" wire:confirm="¿Estás seguro de eliminar este ítem?" title="Eliminar" class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-trash class="w-5 h-5"/>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="py-12 text-center text-slate-400 font-medium">
                                <x-heroicon-o-cube class="w-12 h-12 mx-auto text-slate-300 mb-3"/>
                                No se encontraron productos o servicios registrados.
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
                                    {{ $product_id ? 'Editar Ítem' : 'Nuevo Producto / Servicio' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="nombre" class="block text-sm font-semibold text-slate-700">Nombre *</label>
                                        <input type="text" wire:model="nombre" id="nombre" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="tipo" class="block text-sm font-semibold text-slate-700">Tipo *</label>
                                        <select wire:model="tipo" id="tipo" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Servicio">Servicio</option>
                                            <option value="Producto">Producto</option>
                                            <option value="Licencia">Licencia</option>
                                            <option value="Otro">Otro</option>
                                        </select>
                                    </div>

                                    <div class="col-span-2">
                                        <label for="descripcion" class="block text-sm font-semibold text-slate-700">Descripción o Características</label>
                                        <input type="text" wire:model="descripcion" id="descripcion" placeholder="Detalles técnicos, capacidad, etc." class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="precio" class="block text-sm font-semibold text-slate-700">Precio de Venta *</label>
                                        <input type="number" step="0.01" wire:model="precio" id="precio" placeholder="Ej: 500000" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('precio') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="costo" class="block text-sm font-semibold text-slate-700">Costo de Adquisición / Proveedor</label>
                                        <input type="number" step="0.01" wire:model="costo" id="costo" placeholder="Ej: 25000" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="periodicidad" class="block text-sm font-semibold text-slate-700">Periodicidad de Cobro</label>
                                        <input type="text" wire:model="periodicidad" id="periodicidad" placeholder="Ej: Anual, Único, Mensual" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="proveedor" class="block text-sm font-semibold text-slate-700">Empresa Proveedora</label>
                                        <input type="text" wire:model="proveedor" id="proveedor" placeholder="Ej: Asura, Soteweb, DonDominio" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">
                            Guardar Item
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

    <!-- Modal Ficha de Producto / Servicio -->
    @if($isViewOpen && $activeProduct)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <div class="bg-gradient-to-r from-blue-600 to-indigo-700 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-s-cube class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">{{ $activeProduct->nombre }}</h3>
                            <p class="text-sm text-blue-100 font-medium">Categoría: {{ $activeProduct->tipo ?: 'Servicio' }}</p>
                        </div>
                    </div>
                    <button wire:click="closeViewModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100">
                        <span class="text-xs text-slate-400 font-semibold uppercase block mb-1">Descripción y Detalles</span>
                        <p class="text-slate-800 text-sm font-medium">{{ $activeProduct->descripcion ?: 'No se especificaron detalles adicionales.' }}</p>
                    </div>

                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Proveedor</span>
                            <span class="font-bold text-slate-800 text-base">{{ $activeProduct->proveedor ?: 'Propio / No registrado' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Periodicidad</span>
                            <span class="font-bold text-slate-800 text-base">{{ $activeProduct->periodicidad ?: 'Único / Sin recurrencia' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Costo de Compra</span>
                            <span class="font-bold text-slate-700 text-lg">${{ is_numeric($activeProduct->costo) && $activeProduct->costo > 0 ? number_format((float)$activeProduct->costo, 0, ',', '.') : '0' }}</span>
                        </div>
                        <div>
                            <span class="text-xs text-slate-400 font-semibold uppercase block">Precio de Venta al Público</span>
                            <span class="font-bold text-slate-900 text-lg">${{ is_numeric($activeProduct->precio) ? number_format((float)$activeProduct->precio, 0, ',', '.') : '0' }}</span>
                        </div>
                        <div class="col-span-2 bg-emerald-50 p-4 rounded-xl border border-emerald-100 flex items-center justify-between">
                            <div>
                                <span class="text-xs text-emerald-700 font-bold uppercase block">Margen de Ganancia Bruta</span>
                                <p class="text-xs text-emerald-600 mt-0.5">Diferencia neta entre precio de venta y costo</p>
                            </div>
                            <span class="text-2xl font-black text-emerald-600">
                                ${{ number_format(((float)$activeProduct->precio) - (is_numeric($activeProduct->costo) ? (float)$activeProduct->costo : 0), 0, ',', '.') }}
                            </span>
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
</div>
