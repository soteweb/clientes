<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle with manual creation button -->
    <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 font-medium">Atención y resolución de casos e incidencias de clientes</p>
        </div>
        <div>
            <button wire:click="openCreateModal()" class="inline-flex items-center justify-center px-5 py-2.5 rounded-lg font-bold text-sm text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors">
                <x-heroicon-o-plus class="w-5 h-5 mr-1.5 -ml-1"/> Nuevo Ticket Manual
            </button>
        </div>
    </div>

    <!-- Filtros y Búsqueda -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div class="relative sm:col-span-2">
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
            </div>
            <input wire:model.live="search" type="text" placeholder="Buscar por código, cliente o asunto..." class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-slate-50">
        </div>

        <div>
            <select wire:model.live="statusFilter" class="block w-full py-2 px-3 border border-slate-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-slate-50">
                <option value="">Todos los Estados</option>
                <option value="Abierto">Abierto</option>
                <option value="En Proceso">En Proceso</option>
                <option value="Resuelto">Resuelto</option>
            </select>
        </div>

        <div>
            <select wire:model.live="priorityFilter" class="block w-full py-2 px-3 border border-slate-200 rounded-lg text-sm font-medium focus:ring-2 focus:ring-blue-600 focus:outline-none bg-slate-50">
                <option value="">Todas las Prioridades</option>
                <option value="Alta">Prioridad Alta</option>
                <option value="Media">Prioridad Media</option>
                <option value="Baja">Prioridad Baja</option>
            </select>
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

    <!-- Tabla de Tickets -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-slate-100 text-left">
                <thead class="bg-slate-50 text-slate-400 text-xs font-semibold uppercase tracking-wider">
                    <tr>
                        <th class="py-3 px-6">Código / Fecha</th>
                        <th class="py-3 px-6">Cliente</th>
                        <th class="py-3 px-6">Asunto</th>
                        <th class="py-3 px-6 text-center">Prioridad</th>
                        <th class="py-3 px-6 text-center">Estado</th>
                        <th class="py-3 px-6 text-right">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-50 text-sm">
                    @forelse($tickets as $ticket)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-extrabold text-slate-900">{{ $ticket->codigo }}</div>
                                <div class="text-xs text-slate-400 mt-0.5">{{ \Carbon\Carbon::parse($ticket->fecha_creacion)->format('d/m/Y H:i') }}</div>
                            </td>
                            <td class="py-4 px-6 whitespace-nowrap">
                                <div class="font-bold text-slate-900">{{ $ticket->client ? ($ticket->client->empresa ?: $ticket->client->titular) : 'Cliente Eliminado' }}</div>
                                @if($ticket->solicitante_nombre)
                                    <div class="text-xs text-blue-600 font-semibold mt-0.5 flex items-center gap-1">
                                        <x-heroicon-o-user class="w-3 h-3"/> {{ $ticket->solicitante_nombre }}
                                    </div>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-slate-700 font-medium max-w-sm truncate" title="{{ $ticket->asunto }}">
                                {{ $ticket->asunto }}
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($ticket->prioridad == 'Alta')
                                    <span class="px-3 py-1 inline-flex text-xs font-black uppercase tracking-wider rounded-full bg-red-100 text-red-800 border border-red-200">
                                        Alta
                                    </span>
                                @elseif($ticket->prioridad == 'Media')
                                    <span class="px-3 py-1 inline-flex text-xs font-black uppercase tracking-wider rounded-full bg-amber-100 text-amber-800 border border-amber-200">
                                        Media
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-black uppercase tracking-wider rounded-full bg-blue-100 text-blue-800 border border-blue-200">
                                        Baja
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-center whitespace-nowrap">
                                @if($ticket->estado == 'Abierto')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-blue-50 text-blue-700 border border-blue-200">
                                        Abierto
                                    </span>
                                @elseif($ticket->estado == 'En Proceso')
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-amber-50 text-amber-700 border border-amber-200">
                                        En Proceso
                                    </span>
                                @else
                                    <span class="px-3 py-1 inline-flex text-xs font-bold rounded-full bg-emerald-50 text-emerald-700 border border-emerald-200">
                                        Resuelto
                                    </span>
                                @endif
                            </td>
                            <td class="py-4 px-6 text-right whitespace-nowrap">
                                <div class="inline-flex items-center gap-1.5">
                                    <button wire:click="manage({{ $ticket->ticket_id }})" title="Gestionar / Resolver" class="p-2 text-blue-600 hover:text-blue-900 bg-blue-50 hover:bg-blue-100 rounded-lg transition-colors font-bold flex items-center gap-1 text-xs">
                                        <x-heroicon-o-cog-6-tooth class="w-4 h-4"/> Gestionar
                                    </button>
                                    <button wire:click="deleteTicket({{ $ticket->ticket_id }})" wire:confirm="¿Estás seguro de eliminar este ticket?" title="Eliminar" class="p-2 text-red-600 hover:text-red-900 hover:bg-red-50 rounded-lg transition-colors font-bold">
                                        <x-heroicon-o-trash class="w-4 h-4"/>
                                    </button>
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="py-12 text-center text-slate-400 font-medium">
                                <x-heroicon-o-inbox class="w-12 h-12 mx-auto text-slate-300 mb-3"/>
                                No se encontraron tickets que coincidan con la búsqueda.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- Modal de Gestión y Atención del Ticket -->
    @if($isManageOpen && $activeTicket)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeManageModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-r from-slate-800 to-slate-900 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/10 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-o-ticket class="w-7 h-7 text-blue-400"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">Gestión del Caso #{{ $activeTicket->codigo }}</h3>
                            <p class="text-sm text-slate-400 font-medium">Creado el {{ \Carbon\Carbon::parse($activeTicket->fecha_creacion)->format('d/m/Y H:i') }}</p>
                        </div>
                    </div>
                    <button wire:click="closeManageModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <form wire:submit.prevent="updateTicket">
                    <div class="p-6 space-y-6">
                        <!-- Cliente y WhatsApp -->
                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 grid grid-cols-1 sm:grid-cols-2 gap-4 items-start">
                            <div>
                                <span class="text-xs text-slate-400 font-semibold uppercase block">Empresa Ficha</span>
                                <h4 class="font-bold text-slate-900 text-lg">{{ $activeTicket->client ? ($activeTicket->client->empresa ?: $activeTicket->client->titular) : 'Cliente Eliminado' }}</h4>
                                @if($activeTicket->client && $activeTicket->client->telefono)
                                    <p class="text-xs text-slate-500 font-medium mt-0.5">Tel Ficha: {{ $activeTicket->client->telefono }}</p>
                                @endif
                            </div>
                            <div class="sm:text-right">
                                <span class="text-xs text-slate-400 font-semibold uppercase block">Quién Solicita / Técnico</span>
                                <h5 class="font-extrabold text-blue-600 text-base">{{ $activeTicket->solicitante_nombre ?: 'No especificado' }}</h5>
                                @if($activeTicket->solicitante_telefono)
                                    <p class="text-xs text-slate-500 font-semibold mt-0.5">Móvil / WA: {{ $activeTicket->solicitante_telefono }}</p>
                                @endif
                                @if($activeTicket->solicitante_email)
                                    <p class="text-xs text-slate-500">Email: {{ $activeTicket->solicitante_email }}</p>
                                @endif
                                
                                @php
                                    $targetPhone = $activeTicket->solicitante_telefono ?: ($activeTicket->client->telefono ?? '');
                                    $telClean = preg_replace('/[^0-9]/', '', $targetPhone);
                                    $waMsg = urlencode("Hola " . ($activeTicket->solicitante_nombre ?: '') . "! Nos contactamos de Soteweb en relación a su ticket #" . $activeTicket->codigo . " (" . $activeTicket->asunto . ").");
                                @endphp
                                @if(!empty($telClean))
                                    <a href="https://wa.me/{{ $telClean }}?text={{ $waMsg }}" target="_blank" class="inline-flex items-center gap-1.5 px-3 py-1.5 bg-emerald-500 hover:bg-emerald-600 text-white rounded-lg text-xs font-bold transition-transform hover:scale-105 shadow-sm mt-2">
                                        <svg class="w-4 h-4 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg> WhatsApp al Solicitante
                                    </a>
                                @endif
                            </div>
                        </div>

                        <!-- Asunto y Mensaje -->
                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold block mb-1">Asunto del Problema</span>
                            <div class="font-bold text-slate-900 text-base">{{ $activeTicket->asunto }}</div>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-200 space-y-4">
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold block mb-1">Mensaje o Detalle del Cliente</span>
                                <p class="text-slate-800 text-sm whitespace-pre-line leading-relaxed font-medium">{{ $activeTicket->mensaje }}</p>
                            </div>
                            @if($activeTicket->archivo_path)
                                <div class="pt-3 border-t border-slate-200">
                                    <span class="text-xs text-slate-400 uppercase font-semibold block mb-1.5">Archivo Adjunto por el Cliente</span>
                                    <a href="{{ asset('storage/' . $activeTicket->archivo_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-blue-50 border border-slate-300 hover:border-blue-400 text-blue-700 rounded-xl font-bold text-xs shadow-sm transition-all">
                                        <x-heroicon-o-arrow-down-tray class="w-4 h-4"/> Descargar / Ver {{ $activeTicket->archivo_nombre }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-2 border-t border-slate-100">
                            <div>
                                <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Estado de Resolución *</label>
                                <select wire:model="newStatus" class="w-full py-2.5 px-3 bg-white border border-slate-300 rounded-xl font-bold text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none shadow-sm">
                                    <option value="Abierto">Abierto</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Resuelto">Resuelto</option>
                                </select>
                            </div>
                        </div>

                        <div>
                            <label class="block text-xs font-bold text-slate-700 uppercase mb-1">Notas de Respuesta o Solución (Interno / Cliente)</label>
                            <textarea wire:model="observaciones_admin" rows="4" placeholder="Escribe aquí las medidas tomadas o la solución al problema..." class="w-full px-4 py-3 border border-slate-300 rounded-xl font-medium text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none shadow-sm"></textarea>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" wire:click="closeManageModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md shadow-blue-500/20 text-sm transition-transform hover:scale-105">
                            Guardar Cambios
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- Modal de Creación Manual de Ticket (Admin) -->
    @if($isCreateOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeCreateModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <div class="bg-gradient-to-r from-blue-700 to-indigo-800 px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-o-plus-circle class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight">Registrar Ticket de Soporte</h3>
                            <p class="text-sm text-blue-100 font-medium">Creación manual de ticket en nombre del cliente</p>
                        </div>
                    </div>
                    <button wire:click="closeCreateModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <form wire:submit.prevent="storeTicketAdmin">
                    <div class="p-6 space-y-5">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <!-- Cliente -->
                            <div class="sm:col-span-2">
                                <label for="cliente_id" class="block text-sm font-semibold text-slate-700">Ficha del Cliente *</label>
                                <select wire:model="cliente_id" id="cliente_id" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                    <option value="">Seleccione el cliente o empresa...</option>
                                    @foreach($clients as $client)
                                        <option value="{{ $client->cliente_id }}">{{ $client->empresa ?: $client->titular }}</option>
                                    @endforeach
                                </select>
                                @error('cliente_id') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Solicitante Nombre -->
                            <div>
                                <label for="solicitante_nombre" class="block text-sm font-semibold text-slate-700">Nombre del Solicitante / Técnico *</label>
                                <input type="text" wire:model="solicitante_nombre" id="solicitante_nombre" placeholder="Ej: Ing. Carlos Mendoza" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-xl font-medium">
                                @error('solicitante_nombre') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Solicitante Teléfono -->
                            <div>
                                <label for="solicitante_telefono" class="block text-sm font-semibold text-slate-700">Teléfono / WhatsApp *</label>
                                <input type="text" wire:model="solicitante_telefono" id="solicitante_telefono" placeholder="Ej: 0981 123 456" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-xl font-medium">
                                @error('solicitante_telefono') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Solicitante Email -->
                            <div class="sm:col-span-2">
                                <label for="solicitante_email" class="block text-sm font-semibold text-slate-700">Email de Contacto (Opcional)</label>
                                <input type="email" wire:model="solicitante_email" id="solicitante_email" placeholder="Ej: cmendoza@empresa.com" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-xl font-medium">
                                @error('solicitante_email') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Asunto -->
                            <div class="sm:col-span-2">
                                <label for="asunto" class="block text-sm font-semibold text-slate-700">Asunto del Soporte *</label>
                                <input type="text" wire:model="asunto" id="asunto" placeholder="Ej: Error de sincronización de correo corporativo" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-xl font-medium">
                                @error('asunto') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Descripción / Mensaje -->
                            <div class="sm:col-span-2">
                                <label for="mensaje" class="block text-sm font-semibold text-slate-700">Detalles de la Solicitud *</label>
                                <textarea wire:model="mensaje" id="mensaje" rows="4" placeholder="Explique las especificaciones o requerimientos reportados por el cliente..." class="mt-1 shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-xl font-medium"></textarea>
                                @error('mensaje') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Prioridad -->
                            <div>
                                <label for="prioridad" class="block text-sm font-semibold text-slate-700">Prioridad *</label>
                                <select wire:model="prioridad" id="prioridad" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                    <option value="Baja">Baja</option>
                                    <option value="Media">Media</option>
                                    <option value="Alta">Alta</option>
                                </select>
                                @error('prioridad') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>

                            <!-- Estado Inicial -->
                            <div>
                                <label for="estado" class="block text-sm font-semibold text-slate-700">Estado Inicial *</label>
                                <select wire:model="estado" id="estado" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-xl shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-medium">
                                    <option value="Abierto">Abierto (Pendiente)</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Resuelto">Resuelto</option>
                                </select>
                                @error('estado') <span class="text-red-500 text-xs font-bold block mt-1">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    </div>

                    <div class="bg-slate-50 px-6 py-4 flex items-center justify-end gap-3 border-t border-slate-100">
                        <button type="button" wire:click="closeCreateModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-100 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="px-6 py-2.5 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md shadow-blue-500/20 text-sm transition-transform hover:scale-105">
                            Crear Ticket
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif
</div>
