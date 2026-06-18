<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle with Tab switcher -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 font-medium">Gestión de compras a proveedores de hosting y fraccionamiento de recursos vendidos a clientes</p>
        </div>
        <div class="inline-flex rounded-lg bg-slate-100 p-1">
            <button wire:click="setTab('pools')" class="px-4 py-2 rounded-md font-bold text-xs transition-colors {{ $activeTab === 'pools' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Pools de Recursos
            </button>
            <button wire:click="setTab('suppliers')" class="px-4 py-2 rounded-md font-bold text-xs transition-colors {{ $activeTab === 'suppliers' ? 'bg-white text-slate-900 shadow-sm' : 'text-slate-500 hover:text-slate-800' }}">
                Proveedores
            </button>
        </div>
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
            @if($activeTab === 'pools')
                <button wire:click="createPool()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                    <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Pool / Servidor
                </button>
            @else
                <button wire:click="createSupplier()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                    <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Proveedor
                </button>
            @endif
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

    <!-- Content Sections based on Tabs -->
    @if($activeTab === 'pools')
        <!-- Pools Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            @forelse($pools as $pool)
                @php
                    $percentage = $pool->porcentaje_ocupado;
                    $barColor = 'bg-blue-600';
                    if($percentage >= 90) {
                        $barColor = 'bg-red-500';
                    } elseif ($percentage >= 75) {
                        $barColor = 'bg-amber-500';
                    }
                @endphp
                <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-5 space-y-4 hover:shadow-md transition-shadow">
                    <div class="flex justify-between items-start">
                        <div>
                            <span class="text-xs font-bold text-slate-400 uppercase tracking-wider block mb-1">
                                {{ $pool->supplier ? $pool->supplier->nombre : 'Sin Proveedor' }}
                            </span>
                            <h3 class="font-extrabold text-slate-900 text-lg leading-tight hover:text-blue-600 transition-colors cursor-pointer" wire:click="viewPoolDetail({{ $pool->pool_id }})">
                                {{ $pool->nombre }}
                            </h3>
                        </div>
                        <div class="flex flex-col items-end gap-1.5">
                            @if($pool->estado == 'Activo')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-emerald-100 text-emerald-800 border border-emerald-200">Activo</span>
                            @elseif($pool->estado == 'Suspendido')
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-amber-100 text-amber-800 border border-amber-200">Suspendido</span>
                            @else
                                <span class="px-2.5 py-0.5 rounded-full text-xs font-bold bg-slate-100 text-slate-800 border border-slate-200">Cancelado</span>
                            @endif

                            @if($pool->es_rentable)
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-50 text-emerald-700 border border-emerald-200">Rentable</span>
                            @else
                                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-50 text-amber-700 border border-amber-200">En Desarrollo</span>
                            @endif
                        </div>
                    </div>

                    <!-- Recursos Allocated Progress Bar -->
                    <div class="space-y-1.5 pt-2">
                        <div class="flex justify-between text-xs font-bold text-slate-600">
                            <span>Distribución del Recurso ({{ $pool->recurso_tipo }})</span>
                            <span>{{ $percentage }}% Ocupado</span>
                        </div>
                        <div class="w-full bg-slate-100 rounded-full h-3.5 overflow-hidden border border-slate-200/50">
                            <div class="h-full rounded-full {{ $barColor }} transition-all" style="width: {{ $percentage }}%"></div>
                        </div>
                        <div class="flex justify-between text-[11px] font-semibold text-slate-400">
                            <span>Asignado: {{ number_format($pool->recurso_asignado, 1, ',', '.') }} {{ $pool->recurso_tipo }}</span>
                            <span>Capacidad: {{ number_format($pool->recurso_capacidad, 1, ',', '.') }} {{ $pool->recurso_tipo }}</span>
                        </div>
                    </div>

                    <!-- Financial Summary -->
                    <div class="grid grid-cols-3 gap-2 bg-slate-50 rounded-xl p-3 text-center border border-slate-100">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Costo</span>
                            <span class="text-sm font-extrabold text-red-600">${{ number_format($pool->costo, 0, ',', '.') }}</span>
                            <span class="text-[9px] text-slate-400 font-medium uppercase block">{{ $pool->periodicidad }}</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Ingresos</span>
                            <span class="text-sm font-extrabold text-emerald-600">${{ number_format($pool->ingresos_totales, 0, ',', '.') }}</span>
                            <span class="text-[9px] text-slate-400 font-medium uppercase block">Activos</span>
                        </div>
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block">Ganancia</span>
                            @php $net = $pool->ingresos_totales - $pool->costo; @endphp
                            <span class="text-sm font-extrabold {{ $net >= 0 ? 'text-emerald-700' : 'text-amber-700' }}">
                                ${{ number_format($net, 0, ',', '.') }}
                            </span>
                            <span class="text-[9px] text-slate-400 font-medium uppercase block">Neta</span>
                        </div>
                    </div>

                    <!-- Footer Info and actions -->
                    <div class="flex justify-between items-center text-xs font-semibold text-slate-500 pt-2 border-t border-slate-100">
                        <div>
                            @if($pool->fecha_vencimiento)
                                <span>Vence: {{ \Carbon\Carbon::parse($pool->fecha_vencimiento)->format('d/m/Y') }}</span>
                            @else
                                <span class="text-slate-300">Sin vencimiento</span>
                            @endif
                        </div>
                        <div class="inline-flex items-center gap-1">
                            <button wire:click="viewPoolDetail({{ $pool->pool_id }})" title="Inspeccionar" class="p-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition-colors font-bold">
                                <x-heroicon-o-eye class="w-4 h-4"/>
                            </button>
                            <button wire:click="editPool({{ $pool->pool_id }})" title="Editar" class="p-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition-colors font-bold">
                                <x-heroicon-o-pencil-square class="w-4 h-4"/>
                            </button>
                            <button wire:click="deletePool({{ $pool->pool_id }})" wire:confirm="¿Estás seguro de eliminar este pool de recursos? Esto desvinculará todos los pagos asociados." title="Eliminar" class="p-1 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition-colors font-bold">
                                <x-heroicon-o-trash class="w-4 h-4"/>
                            </button>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-span-full bg-white rounded-xl shadow-sm border border-slate-100 py-16 text-center text-slate-400 font-medium">
                    <x-heroicon-o-server-stack class="w-16 h-16 mx-auto text-slate-300 mb-3"/>
                    No se encontraron pools de recursos contratados a proveedores.
                </div>
            @endforelse
        </div>
    @else
        <!-- Suppliers Table -->
        <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-slate-100 text-left">
                    <thead class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                        <tr>
                            <th class="py-3 px-6">Nombre Proveedor</th>
                            <th class="py-3 px-6">Contacto</th>
                            <th class="py-3 px-6">Teléfono</th>
                            <th class="py-3 px-6">Email</th>
                            <th class="py-3 px-6">Sitio Web</th>
                            <th class="py-3 px-6 text-right">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-50 text-sm">
                        @forelse($suppliers as $supplier)
                            <tr class="hover:bg-slate-50 transition-colors">
                                <td class="py-4 px-6 font-bold text-slate-900">
                                    {{ $supplier->nombre }}
                                </td>
                                <td class="py-4 px-6 text-slate-600 font-medium">
                                    {{ $supplier->contacto ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-slate-600 font-semibold whitespace-nowrap">
                                    {{ $supplier->telefono ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-slate-600 font-medium">
                                    {{ $supplier->email ?: '-' }}
                                </td>
                                <td class="py-4 px-6 text-blue-600 font-semibold truncate max-w-xs">
                                    @if($supplier->sitio_web)
                                        <a href="{{ $supplier->sitio_web }}" target="_blank" class="hover:underline flex items-center gap-1">
                                            {{ $supplier->sitio_web }} <x-heroicon-o-arrow-top-right-on-square class="w-3.5 h-3.5"/>
                                        </a>
                                    @else
                                        <span class="text-slate-300">-</span>
                                    @endif
                                </td>
                                <td class="py-4 px-6 text-right whitespace-nowrap">
                                    <div class="inline-flex items-center gap-1.5">
                                        <button wire:click="editSupplier({{ $supplier->proveedor_id }})" title="Editar Proveedor" class="p-1.5 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded-lg transition-colors font-bold">
                                            <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                        </button>
                                        <button wire:click="deleteSupplier({{ $supplier->proveedor_id }})" wire:confirm="¿Estás seguro de eliminar este proveedor? Se eliminarán también todos sus pools de recursos." title="Eliminar" class="p-1.5 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors font-bold">
                                            <x-heroicon-o-trash class="w-5 h-5"/>
                                        </button>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                    <x-heroicon-o-building-office-2 class="w-12 h-12 mx-auto text-slate-300 mb-3"/>
                                    No se encontraron proveedores registrados.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- CREATE/EDIT SUPPLIER MODAL -->
    @if($isSupplierOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeSupplierModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-xl sm:w-full">
                <form wire:submit.prevent="storeSupplier">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 mb-4" id="modal-title">
                                    {{ $supplier_id ? 'Editar Proveedor' : 'Registrar Nuevo Proveedor' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="col-span-2">
                                        <label for="supplier_nombre" class="block text-sm font-semibold text-slate-700">Nombre de la Empresa / Partner *</label>
                                        <input type="text" wire:model="supplier_nombre" id="supplier_nombre" placeholder="Ej: Hostinger S.A." class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('supplier_nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="supplier_contacto" class="block text-sm font-semibold text-slate-700">Persona de Contacto</label>
                                        <input type="text" wire:model="supplier_contacto" id="supplier_contacto" placeholder="Ej: Ing. Pedro Duarte" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div>
                                        <label for="supplier_telefono" class="block text-sm font-semibold text-slate-700">Teléfono / WhatsApp</label>
                                        <input type="text" wire:model="supplier_telefono" id="supplier_telefono" placeholder="Ej: 0981 445566" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2">
                                        <label for="supplier_email" class="block text-sm font-semibold text-slate-700">Email del Proveedor</label>
                                        <input type="email" wire:model="supplier_email" id="supplier_email" placeholder="Ej: soporte@proveedor.com" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('supplier_email') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="supplier_sitio_web" class="block text-sm font-semibold text-slate-700">Sitio Web (URL completa)</label>
                                        <input type="text" wire:model="supplier_sitio_web" id="supplier_sitio_web" placeholder="Ej: https://www.proveedor.com" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('supplier_sitio_web') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="supplier_observacion" class="block text-sm font-semibold text-slate-700">Notas sobre el Proveedor</label>
                                        <textarea wire:model="supplier_observacion" id="supplier_observacion" rows="3" placeholder="Información contractual o técnica..." class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md font-medium"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">
                            Guardar Proveedor
                        </button>
                        <button type="button" wire:click="closeSupplierModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- CREATE/EDIT POOL MODAL -->
    @if($isPoolOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closePoolModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit.prevent="storePool">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-bold text-slate-900 border-b pb-3 mb-4" id="modal-title">
                                    {{ $pool_id ? 'Editar Pool de Recursos' : 'Registrar Nuevo Pool de Recursos' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    <div class="col-span-2 sm:col-span-1">
                                        <div class="flex justify-between items-center">
                                            <label for="pool_proveedor_id" class="block text-sm font-semibold text-slate-700">Proveedor *</label>
                                            <button type="button" wire:click="createSupplier()" class="text-xs font-extrabold text-blue-600 hover:text-blue-800 hover:underline">Crear Nuevo</button>
                                        </div>
                                        <select wire:model="pool_proveedor_id" id="pool_proveedor_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="">Seleccione proveedor...</option>
                                            @foreach($suppliers as $supplier)
                                                <option value="{{ $supplier->proveedor_id }}">{{ $supplier->nombre }}</option>
                                            @endforeach
                                        </select>
                                        @error('pool_proveedor_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_nombre" class="block text-sm font-semibold text-slate-700">Nombre del Pool / Servidor *</label>
                                        <input type="text" wire:model="pool_nombre" id="pool_nombre" placeholder="Ej: VPS Alpha Server" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('pool_nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_costo" class="block text-sm font-semibold text-slate-700">Costo de Compra (Proveedor) *</label>
                                        <input type="text" wire:model="pool_costo" id="pool_costo" placeholder="Ej: 250000" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('pool_costo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_periodicidad" class="block text-sm font-semibold text-slate-700">Periodicidad de Compra</label>
                                        <select wire:model="pool_periodicidad" id="pool_periodicidad" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Mensual">Mensual</option>
                                            <option value="Anual">Anual</option>
                                            <option value="Unico">Único / Semestral</option>
                                        </select>
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_recurso_tipo" class="block text-sm font-semibold text-slate-700">Tipo de Recurso *</label>
                                        <select wire:model="pool_recurso_tipo" id="pool_recurso_tipo" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Almacenamiento (GB)">Almacenamiento (GB)</option>
                                            <option value="Cuentas / Licencias">Cuentas / Licencias</option>
                                            <option value="Memoria (GB)">Memoria RAM (GB)</option>
                                            <option value="Otros">Otros Recursos</option>
                                        </select>
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_recurso_capacidad" class="block text-sm font-semibold text-slate-700">Capacidad Total *</label>
                                        <input type="text" wire:model="pool_recurso_capacidad" id="pool_recurso_capacidad" placeholder="Ej: 200" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                        @error('pool_recurso_capacidad') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_fecha_compra" class="block text-sm font-semibold text-slate-700">Fecha de Contratación</label>
                                        <input type="date" wire:model="pool_fecha_compra" id="pool_fecha_compra" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_fecha_vencimiento" class="block text-sm font-semibold text-slate-700">Fecha de Renovación</label>
                                        <input type="date" wire:model="pool_fecha_vencimiento" id="pool_fecha_vencimiento" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md font-medium">
                                    </div>

                                    <div class="col-span-2 sm:col-span-1">
                                        <label for="pool_estado" class="block text-sm font-semibold text-slate-700">Estado del Pool *</label>
                                        <select wire:model="pool_estado" id="pool_estado" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                            <option value="Activo">Activo</option>
                                            <option value="Suspendido">Suspendido</option>
                                            <option value="Cancelado">Cancelado</option>
                                        </select>
                                    </div>

                                    <div class="col-span-2">
                                        <label for="pool_observacion" class="block text-sm font-semibold text-slate-700">Notas Adicionales</label>
                                        <textarea wire:model="pool_observacion" id="pool_observacion" rows="3" placeholder="Información técnica, accesos rápidos o enlaces importantes..." class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-md font-medium"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 sm:ml-3 sm:w-auto transition-colors">
                            Guardar Pool
                        </button>
                        <button type="button" wire:click="closePoolModal()" class="mt-3 w-full inline-flex justify-center rounded-lg border border-slate-300 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 sm:mt-0 sm:ml-3 sm:w-auto transition-colors">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- POOL DETAIL INSPECTION MODAL -->
    @if($isPoolDetailOpen && $activePool)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closePoolDetailModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-r from-blue-800 to-indigo-900 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-o-server-stack class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">{{ $activePool->nombre }}</h3>
                            <p class="text-xs text-indigo-100 font-medium">Proveedor: {{ $activePool->supplier ? $activePool->supplier->nombre : 'Sin proveedor' }}</p>
                        </div>
                    </div>
                    <button wire:click="closePoolDetailModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    <!-- Progress and resources details -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-3">
                        <span class="text-xs text-slate-400 font-bold uppercase tracking-wider block">Distribución de Recursos</span>
                        <div class="space-y-1.5">
                            <div class="flex justify-between text-xs font-bold text-slate-700">
                                <span>Capacidad Utilizada</span>
                                <span>{{ $activePool->porcentaje_ocupado }}%</span>
                            </div>
                            <div class="w-full bg-slate-200 rounded-full h-3 overflow-hidden">
                                @php
                                    $p = $activePool->porcentaje_ocupado;
                                    $c = $p >= 90 ? 'bg-red-500' : ($p >= 75 ? 'bg-amber-500' : 'bg-blue-600');
                                @endphp
                                <div class="h-full rounded-full {{ $c }}" style="width: {{ $p }}%"></div>
                            </div>
                            <div class="grid grid-cols-3 text-center text-xs font-bold text-slate-500 pt-1">
                                <div>
                                    <span class="text-[9px] text-slate-400 block uppercase">Total Comprado</span>
                                    <span>{{ number_format($activePool->recurso_capacidad, 1, ',', '.') }} {{ $activePool->recurso_tipo }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] text-slate-400 block uppercase font-bold text-blue-600">Asignado a Clientes</span>
                                    <span class="text-blue-700">{{ number_format($activePool->recurso_asignado, 1, ',', '.') }} {{ $activePool->recurso_tipo }}</span>
                                </div>
                                <div>
                                    <span class="text-[9px] text-slate-400 block uppercase font-bold text-emerald-600">Espacio Disponible</span>
                                    <span class="text-emerald-700">{{ number_format($activePool->recurso_disponible, 1, ',', '.') }} {{ $activePool->recurso_tipo }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Metrics and metadata -->
                    <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
                        <div class="p-3 bg-red-50 rounded-xl border border-red-100/60 text-center">
                            <span class="text-[9px] text-red-500 font-bold uppercase block">Costo Proveedor</span>
                            <span class="text-base font-extrabold text-red-600">${{ number_format($activePool->costo, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-xl border border-emerald-100/60 text-center">
                            <span class="text-[9px] text-emerald-500 font-bold uppercase block">Total Cobrado</span>
                            <span class="text-base font-extrabold text-emerald-600">${{ number_format($activePool->ingresos_totales, 0, ',', '.') }}</span>
                        </div>
                        <div class="p-3 bg-blue-50 rounded-xl border border-blue-100/60 text-center">
                            <span class="text-[9px] text-blue-500 font-bold uppercase block">Margen Neto</span>
                            @php $n = $activePool->ingresos_totales - $activePool->costo; @endphp
                            <span class="text-base font-extrabold {{ $n >= 0 ? 'text-emerald-700' : 'text-red-700' }}">
                                ${{ number_format($n, 0, ',', '.') }}
                            </span>
                        </div>
                        <div class="p-3 bg-slate-50 rounded-xl border border-slate-100 text-center">
                            <span class="text-[9px] text-slate-400 font-bold uppercase block">Periodicidad</span>
                            <span class="text-sm font-bold text-slate-800">{{ $activePool->periodicidad }}</span>
                        </div>
                    </div>

                    <!-- Linked Clients Sub-Services List -->
                    <div class="space-y-3">
                        <h4 class="text-xs font-bold text-slate-700 uppercase tracking-wider block border-b pb-1.5">Clientes y Sub-Servicios Vinculados</h4>
                        <div class="max-h-60 overflow-y-auto rounded-xl border border-slate-100">
                            <table class="min-w-full divide-y divide-slate-100 text-left text-xs">
                                <thead class="bg-slate-50 text-slate-400 uppercase font-semibold">
                                    <tr>
                                        <th class="py-2.5 px-4">Cliente / Empresa</th>
                                        <th class="py-2.5 px-4">Servicio</th>
                                        <th class="py-2.5 px-4 text-center">Porción</th>
                                        <th class="py-2.5 px-4 text-right">Cobro</th>
                                        <th class="py-2.5 px-4 text-center">Estado</th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-slate-50 font-medium">
                                    @forelse($activePool->payments as $subPay)
                                        <tr class="hover:bg-slate-50">
                                            <td class="py-3 px-4 font-bold text-slate-900">
                                                {{ $subPay->client ? ($subPay->client->empresa ?: $subPay->client->titular) : 'Cliente Eliminado' }}
                                            </td>
                                            <td class="py-3 px-4 text-slate-500 font-semibold max-w-[120px] truncate" title="{{ $subPay->servicio }}">
                                                {{ $subPay->servicio }}
                                            </td>
                                            <td class="py-3 px-4 text-center font-extrabold text-blue-700">
                                                {{ number_format($subPay->porcion_recurso, 1, ',', '.') }}
                                            </td>
                                            <td class="py-3 px-4 text-right font-extrabold text-slate-900">
                                                ${{ \App\Models\Payment::formatMonto($subPay->monto) }}
                                            </td>
                                            <td class="py-3 px-4 text-center">
                                                @if(($subPay->estado ?? 'Pagado') == 'Pagado')
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-emerald-100 text-emerald-800">Pagado</span>
                                                @elseif($subPay->estado == 'Pendiente')
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-red-100 text-red-800">Moro.</span>
                                                @else
                                                    <span class="px-2 py-0.5 rounded-full text-[9px] font-bold bg-slate-100 text-slate-700">Baja</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="py-8 text-center text-slate-400 font-medium italic">
                                                No hay sub-servicios de clientes vinculados a este pool.
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <!-- Notes Section -->
                    @if($activePool->observacion)
                        <div class="border-t pt-3">
                            <span class="text-xs text-slate-400 font-bold uppercase block mb-1">Notas Adicionales del Servidor</span>
                            <p class="text-xs text-slate-600 bg-slate-50 p-3 rounded-lg border border-slate-150 leading-relaxed font-semibold italic">{{ $activePool->observacion }}</p>
                        </div>
                    @endif
                </div>

                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100 rounded-b-2xl">
                    <button type="button" wire:click="closePoolDetailModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
                        Cerrar Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
