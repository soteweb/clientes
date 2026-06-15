<div class="py-6 max-w-7xl mx-auto space-y-6">
    <!-- Header Subtitle with Stats Overview -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <p class="text-sm text-slate-500 font-medium">Bandeja de entrada y análisis de trabajos o proyectos solicitados pendientes de priorizar y presupuestar</p>
        </div>
        
        <!-- Summary Stats Banner -->
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-3 bg-white border border-slate-100 rounded-xl p-2.5 shadow-sm">
            <div class="px-3 py-1 border-r border-slate-100">
                <span class="text-[9px] text-slate-400 font-bold uppercase block">Total Pendientes</span>
                <span class="text-sm font-extrabold text-slate-800">{{ $requirements->whereIn('estado', ['Pendiente', 'Evaluando'])->count() }}</span>
            </div>
            <div class="px-3 py-1 border-r border-slate-100">
                <span class="text-[9px] text-red-500 font-bold uppercase block">🚨 Urgentes</span>
                <span class="text-sm font-extrabold text-red-600">{{ $requirements->where('prioridad', 'Urgente')->whereNotIn('estado', ['Completado', 'Cancelado'])->count() }}</span>
            </div>
            <div class="px-3 py-1 border-r border-slate-100">
                <span class="text-[9px] text-indigo-500 font-bold uppercase block">En Análisis</span>
                <span class="text-sm font-extrabold text-indigo-600">{{ $requirements->where('estado', 'Evaluando')->count() }}</span>
            </div>
            <div class="px-3 py-1">
                <span class="text-[9px] text-emerald-500 font-bold uppercase block">Aprobados</span>
                <span class="text-sm font-extrabold text-emerald-600">{{ $requirements->where('estado', 'Aprobado')->count() }}</span>
            </div>
        </div>
    </div>

    <!-- Interactive Filters & Search -->
    <div class="bg-white rounded-xl shadow-sm border border-slate-100 p-4 space-y-3">
        <div class="flex flex-col lg:flex-row gap-4 items-center justify-between">
            <div class="relative w-full lg:max-w-md">
                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                    <x-heroicon-o-magnifying-glass class="w-5 h-5 text-slate-400"/>
                </div>
                <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2.5 border border-slate-200 rounded-xl bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 text-sm font-semibold transition-all" placeholder="Buscar por título, descripción o cliente...">
            </div>
            
            <div class="flex flex-wrap sm:flex-nowrap gap-3 w-full lg:w-auto">
                <select wire:model.live="filterPriority" class="w-full sm:w-40 py-2.5 px-3 border border-slate-200 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 focus:outline-none focus:bg-white">
                    <option value="">Prioridades (Todas)</option>
                    <option value="Urgente">🚨 Urgente</option>
                    <option value="Alta">Alta</option>
                    <option value="Media">Media</option>
                    <option value="Baja">Baja</option>
                </select>

                <select wire:model.live="filterStatus" class="w-full sm:w-44 py-2.5 px-3 border border-slate-200 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 focus:outline-none focus:bg-white">
                    <option value="">Estados (Todos)</option>
                    <option value="Pendiente">Pendiente de Ver</option>
                    <option value="Evaluando">En Evaluación</option>
                    <option value="Presupuestado">Presupuestado</option>
                    <option value="Aprobado">Aprobado</option>
                    <option value="En Desarrollo">En Desarrollo</option>
                    <option value="Completado">Completado</option>
                    <option value="Cancelado">Cancelado</option>
                </select>

                <select wire:model.live="filterType" class="w-full sm:w-44 py-2.5 px-3 border border-slate-200 bg-slate-50 rounded-xl text-xs font-bold text-slate-600 focus:outline-none focus:bg-white">
                    <option value="">Solicitantes (Todos)</option>
                    <option value="clients">Clientes Registrados</option>
                    <option value="prospects">Prospectos Externos</option>
                </select>

                <button wire:click="create()" class="w-full sm:w-auto inline-flex items-center justify-center px-5 py-2.5 rounded-xl font-extrabold text-xs text-white bg-blue-600 hover:bg-blue-700 shadow-sm transition-colors whitespace-nowrap">
                    <x-heroicon-o-plus class="w-4 h-4 mr-1"/> Anotar Pendiente
                </button>
            </div>
        </div>
    </div>

    @if (session()->has('message'))
        <div class="bg-green-50 border-l-4 border-green-500 p-4 rounded-xl shadow-sm">
            <div class="flex items-center">
                <x-heroicon-o-check-circle class="h-5 w-5 text-green-500 mr-3"/>
                <p class="text-sm font-semibold text-green-800">{{ session('message') }}</p>
            </div>
        </div>
    @endif

    <!-- Pipeline / Grid of requirements -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($requirements as $req)
            @php
                $isUrgente = $req->prioridad === 'Urgente';
            @endphp
            <div class="bg-white rounded-2xl shadow-sm border {{ $isUrgente ? 'border-red-200 ring-2 ring-red-500/10' : 'border-slate-100' }} p-5 space-y-4 flex flex-col justify-between hover:shadow-md transition-shadow relative overflow-hidden">
                @if($isUrgente && !in_array($req->estado, ['Completado', 'Cancelado']))
                    <div class="absolute top-0 right-0 w-2.5 h-2.5 bg-red-500 rounded-full animate-ping mt-4 mr-4"></div>
                @endif
                
                <div class="space-y-3">
                    <!-- Heading: priority & state badges -->
                    <div class="flex items-center justify-between gap-2">
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border uppercase tracking-wider {{ $req->prioridad_badge_color }}">
                            {{ $req->prioridad }}
                        </span>
                        <span class="px-2.5 py-0.5 rounded-full text-[10px] font-extrabold border uppercase tracking-wider {{ $req->estado_badge_color }}">
                            {{ $req->estado }}
                        </span>
                    </div>

                    <!-- Client / Request source info -->
                    <div class="flex items-center gap-1.5 text-xs font-bold text-slate-400">
                        <x-heroicon-o-user class="w-3.5 h-3.5 shrink-0"/>
                        @if($req->client)
                            <span class="text-blue-600 font-extrabold truncate" title="{{ $req->client->empresa ?: $req->client->titular }}">
                                {{ $req->client->empresa ?: $req->client->titular }}
                            </span>
                        @else
                            <span class="text-slate-700 font-extrabold truncate" title="{{ $req->prospecto_nombre }} (Prospecto)">
                                {{ $req->prospecto_nombre }} <span class="text-[10px] text-amber-600 font-bold bg-amber-50 px-1.5 py-0.5 rounded-md border border-amber-100 ml-1">Prospecto</span>
                            </span>
                        @endif
                    </div>

                    <!-- Main Text content -->
                    <div class="space-y-1">
                        <h3 class="font-extrabold text-slate-900 text-base leading-snug cursor-pointer hover:text-blue-600 transition-colors truncate" wire:click="viewRequirement({{ $req->id }})">
                            {{ $req->titulo }}
                        </h3>
                        <p class="text-xs text-slate-500 line-clamp-3 leading-relaxed font-semibold">
                            {{ $req->descripcion }}
                        </p>
                    </div>
                </div>

                <!-- Footer area with indicators and action controls -->
                <div class="border-t border-slate-100 pt-3 mt-4 flex items-center justify-between">
                    <div class="flex items-center gap-3 text-[10px] font-bold text-slate-400">
                        @if($req->fecha_limite)
                            <div class="flex items-center gap-1">
                                <x-heroicon-o-calendar class="w-3.5 h-3.5 shrink-0"/>
                                <span>Límite: {{ \Carbon\Carbon::parse($req->fecha_limite)->format('d/m') }}</span>
                            </div>
                        @endif
                        @if($req->presupuesto_estimado)
                            <div class="flex items-center gap-1 text-emerald-600">
                                <x-heroicon-o-currency-dollar class="w-3.5 h-3.5 shrink-0"/>
                                <span class="font-extrabold">${{ number_format($req->presupuesto_estimado, 0, ',', '.') }}</span>
                            </div>
                        @endif
                    </div>

                    <div class="inline-flex items-center gap-1">
                        <button wire:click="viewRequirement({{ $req->id }})" title="Inspeccionar / Convertir" class="p-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition-colors font-bold">
                            <x-heroicon-o-eye class="w-4.5 h-4.5"/>
                        </button>
                        <button wire:click="edit({{ $req->id }})" title="Editar" class="p-1 text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition-colors font-bold">
                            <x-heroicon-o-pencil-square class="w-4.5 h-4.5"/>
                        </button>
                        <button wire:click="delete({{ $req->id }})" wire:confirm="¿Estás seguro de eliminar este pendiente de análisis?" title="Eliminar" class="p-1 text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition-colors font-bold">
                            <x-heroicon-o-trash class="w-4.5 h-4.5"/>
                        </button>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full bg-white rounded-2xl shadow-sm border border-slate-100 py-16 text-center text-slate-400 font-medium">
                <x-heroicon-o-clipboard-document-list class="w-16 h-16 mx-auto text-slate-300 mb-3"/>
                No se encontraron requerimientos ni proyectos pendientes registrados.
            </div>
        @endforelse
    </div>

    <!-- CREATE/EDIT MODAL -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-6 pt-6 pb-4 sm:p-6">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg font-extrabold text-slate-900 border-b pb-3.5 mb-5 flex items-center gap-2">
                                    <x-heroicon-o-clipboard-document-check class="w-6 h-6 text-blue-600"/>
                                    {{ $requirement_id ? 'Editar Pendiente / Proyecto' : 'Anotar Nuevo Proyecto o Trabajo Solicitado' }}
                                </h3>
                                
                                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                    
                                    <!-- Toggle Cliente vs Prospecto -->
                                    <div class="col-span-2 bg-slate-50 p-4 rounded-xl border border-slate-150/60 space-y-4">
                                        <span class="text-xs text-slate-500 font-bold uppercase tracking-wider block">¿Quién solicita el trabajo?</span>
                                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                                            <div>
                                                <label for="cliente_id" class="block text-xs font-bold text-slate-700 uppercase mb-1">Cliente Registrado (Opcional)</label>
                                                <select wire:model="cliente_id" id="cliente_id" class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold text-slate-700">
                                                    <option value="">-- No es cliente registrado / Es prospecto --</option>
                                                    @foreach($clients as $c)
                                                        <option value="{{ $c->cliente_id }}">{{ $c->empresa ?: $c->titular }}</option>
                                                    @endforeach
                                                </select>
                                                @error('cliente_id') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                            </div>
                                            
                                            <!-- Si no selecciona cliente, pide campos del prospecto -->
                                            <div x-show="!$wire.cliente_id" class="space-y-2">
                                                <div>
                                                    <label for="prospecto_nombre" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre del Solicitante / Empresa *</label>
                                                    <input type="text" wire:model="prospecto_nombre" id="prospecto_nombre" placeholder="Ej: Juan Pérez o Soteweb Services" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                                    @error('prospecto_nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div x-show="!$wire.cliente_id" class="grid grid-cols-1 sm:grid-cols-2 gap-4 pt-1">
                                            <div>
                                                <label for="prospecto_contacto" class="block text-xs font-bold text-slate-700 uppercase mb-1">WhatsApp / Contacto</label>
                                                <input type="text" wire:model="prospecto_contacto" id="prospecto_contacto" placeholder="Ej: 0981 123456" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                            </div>
                                            <div>
                                                <label for="prospecto_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">Email del Solicitante</label>
                                                <input type="email" wire:model="prospecto_email" id="prospecto_email" placeholder="Ej: info@prospecto.com" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Título & Descripción -->
                                    <div class="col-span-2">
                                        <label for="titulo" class="block text-xs font-bold text-slate-700 uppercase mb-1">Título del Proyecto / Trabajo *</label>
                                        <input type="text" wire:model="titulo" id="titulo" placeholder="Ej: Implementación de Módulo CRM o Maquetación Web" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                        @error('titulo') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div class="col-span-2">
                                        <label for="descripcion" class="block text-xs font-bold text-slate-700 uppercase mb-1">Descripción Detallada / Alcance Reclamado *</label>
                                        <textarea wire:model="descripcion" id="descripcion" rows="4" placeholder="Qué requiere el cliente, detalles técnicos acordados, requerimientos de bases de datos o funcionalidades..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800"></textarea>
                                        @error('descripcion') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Planificación y Costos -->
                                    <div>
                                        <label for="prioridad" class="block text-xs font-bold text-slate-700 uppercase mb-1">🚨 Nivel de Urgencia / Prioridad *</label>
                                        <select wire:model="prioridad" id="prioridad" class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold text-slate-700">
                                            <option value="Baja">Baja (Ideas futuras / No urgente)</option>
                                            <option value="Media">Media (Normal)</option>
                                            <option value="Alta">Alta (Proyecto prioritario)</option>
                                            <option value="Urgente">🚨 Urgente (Atención hoy)</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="estado" class="block text-xs font-bold text-slate-700 uppercase mb-1">Estado de Análisis *</label>
                                        <select wire:model="estado" id="estado" class="block w-full py-2 px-3 border border-slate-300 bg-white rounded-lg shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm font-semibold text-slate-700">
                                            <option value="Pendiente">Pendiente de Análisis</option>
                                            <option value="Evaluando">En Evaluación Técnica</option>
                                            <option value="Presupuestado">Presupuestado / Pasado al Cliente</option>
                                            <option value="Aprobado">Aprobado / Por Empezar</option>
                                            <option value="En Desarrollo">En Desarrollo / Ejecutando</option>
                                            <option value="Completado">Completado / Entregado</option>
                                            <option value="Cancelado">Cancelado / Descartado</option>
                                        </select>
                                    </div>

                                    <div>
                                        <label for="fecha_solicitud" class="block text-xs font-bold text-slate-700 uppercase mb-1">Fecha de Solicitud</label>
                                        <input type="date" wire:model="fecha_solicitud" id="fecha_solicitud" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                        @error('fecha_solicitud') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="fecha_limite" class="block text-xs font-bold text-slate-700 uppercase mb-1">Fecha Límite Estimada</label>
                                        <input type="date" wire:model="fecha_limite" id="fecha_limite" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                    </div>



                                    <div>
                                        <label for="presupuesto_estimado" class="block text-xs font-bold text-slate-700 uppercase mb-1">Presupuesto Estimado ($)</label>
                                        <input type="text" wire:model="presupuesto_estimado" id="presupuesto_estimado" placeholder="Ej: 350000" class="focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800">
                                        @error('presupuesto_estimado') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <!-- Observaciones Internas -->
                                    <div class="col-span-2">
                                        <label for="observaciones" class="block text-xs font-bold text-slate-700 uppercase mb-1">Notas Internas / Avances del Análisis</label>
                                        <textarea wire:model="observaciones" id="observaciones" rows="3" placeholder="Anotaciones sobre tecnologías a usar, integraciones necesarias o enlaces rápidos..." class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-slate-300 rounded-lg font-semibold text-slate-800"></textarea>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-6 py-4 flex flex-col-reverse sm:flex-row sm:justify-end gap-3 border-t border-slate-100 rounded-b-2xl">
                        <button type="button" wire:click="closeModal()" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-slate-300 shadow-sm px-5 py-2.5 bg-white text-sm font-semibold text-slate-700 hover:bg-slate-50 transition-colors">
                            Cancelar
                        </button>
                        <button type="submit" class="w-full sm:w-auto inline-flex justify-center rounded-xl border border-transparent shadow-sm px-5 py-2.5 bg-blue-600 text-sm font-bold text-white hover:bg-blue-700 transition-colors">
                            Guardar Pendiente
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    @endif

    <!-- REQUIREMENT DETAIL & CONVERSION MODAL -->
    @if($isViewOpen && $activeRequirement)
    <div class="fixed z-50 inset-0 overflow-y-auto" role="dialog" aria-modal="true">
        <div class="flex items-center justify-center min-h-screen p-4 text-center sm:p-0">
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" wire:click="closeViewModal()"></div>
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen">&#8203;</span>
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-2xl sm:w-full">
                <!-- Header of modal based on Urgency -->
                @php
                    $isUrg = $activeRequirement->prioridad === 'Urgente';
                    $gradient = $isUrg ? 'from-red-600 to-rose-700' : 'from-blue-700 to-indigo-900';
                @endphp
                <div class="bg-gradient-to-r {{ $gradient }} px-6 py-6 text-white flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-xl bg-white/20 flex items-center justify-center font-bold text-xl">
                            <x-heroicon-o-clipboard-document-list class="w-7 h-7"/>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold leading-tight truncate max-w-sm" title="{{ $activeRequirement->titulo }}">{{ $activeRequirement->titulo }}</h3>
                            <p class="text-xs text-blue-100 font-medium">Requerimiento #{{ $activeRequirement->id }}</p>
                        </div>
                    </div>
                    <button wire:click="closeViewModal()" class="text-white/80 hover:text-white bg-white/10 hover:bg-white/20 p-2 rounded-full transition-colors">
                        <x-heroicon-o-x-mark class="w-6 h-6"/>
                    </button>
                </div>

                <div class="p-6 space-y-6">
                    
                    <!-- Solicitante / Client card with WhatsApp -->
                    <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 flex items-center justify-between gap-4">
                        <div>
                            <span class="text-[10px] text-slate-400 font-bold uppercase block mb-1">Solicitante</span>
                            @if($activeRequirement->client)
                                <h4 class="font-extrabold text-slate-900 text-base leading-tight">{{ $activeRequirement->client->empresa ?: $activeRequirement->client->titular }}</h4>
                                <span class="text-xs text-blue-600 font-bold">Cliente Oficial Registrado</span>
                                @if($activeRequirement->client->telefono)
                                    <p class="text-xs text-slate-500 font-semibold mt-1">Tel: {{ $activeRequirement->client->telefono }}</p>
                                @endif
                            @else
                                <h4 class="font-extrabold text-slate-900 text-base leading-tight">{{ $activeRequirement->prospecto_nombre }}</h4>
                                <span class="px-2 py-0.5 rounded text-[10px] font-extrabold bg-amber-50 text-amber-700 border border-amber-200 uppercase tracking-wider block w-max mt-0.5">Prospecto Externo</span>
                                @if($activeRequirement->prospecto_contacto)
                                    <p class="text-xs text-slate-500 font-semibold mt-1">Tel: {{ $activeRequirement->prospecto_contacto }}</p>
                                @endif
                            @endif
                        </div>
                        
                        <div class="flex flex-col gap-2">
                            <!-- WhatsApp Quick Chat integration -->
                            @php
                                $tel = $activeRequirement->client ? $activeRequirement->client->telefono : $activeRequirement->prospecto_contacto;
                                $nombre = $activeRequirement->client ? ($activeRequirement->client->empresa ?: $activeRequirement->client->titular) : $activeRequirement->prospecto_nombre;
                                $telClean = preg_replace('/[^0-9]/', '', $tel);
                                
                                // Mensaje pre-formateado
                                $mensaje = urlencode("Hola {$nombre}, te escribo de Soteweb para comentarte que estuve analizando tu solicitud sobre \"{$activeRequirement->titulo}\"...");
                            @endphp
                            @if(!empty($telClean))
                                <a href="https://wa.me/{{ $telClean }}?text={{ $mensaje }}" target="_blank" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 bg-emerald-500 hover:bg-emerald-600 text-white rounded-xl text-xs font-bold transition-transform hover:scale-102 shadow-sm">
                                    <svg class="w-4.5 h-4.5 fill-current" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51a12.8 12.8 0 00-.57-.01c-.198 0-.52.074-.792.372s-1.04 1.016-1.04 2.479 1.065 2.876 1.213 3.074c.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                                    WhatsApp Chat
                                </a>
                            @endif
                            
                            <!-- Si es prospecto, permitir promover con un botón visual -->
                            @if(!$activeRequirement->cliente_id)
                                <button wire:click="promoteToClient({{ $activeRequirement->id }})" class="inline-flex items-center justify-center gap-1.5 px-3.5 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm">
                                    <x-heroicon-o-user-plus class="w-4.5 h-4.5"/> Convertir en Cliente
                                </button>
                            @endif
                        </div>
                    </div>

                    <!-- Metadata Grid: date, hours, budget, priority, state -->
                    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 text-center">
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[9px] text-slate-400 font-bold block uppercase mb-0.5">Fecha Solicitud</span>
                            <span class="text-xs font-bold text-slate-800">{{ \Carbon\Carbon::parse($activeRequirement->fecha_solicitud)->format('d/m/Y') }}</span>
                        </div>
                        <div class="bg-slate-50 p-3 rounded-xl border border-slate-100">
                            <span class="text-[9px] text-slate-400 font-bold block uppercase mb-0.5">Fecha Límite</span>
                            <span class="text-xs font-bold text-slate-800">
                                {{ $activeRequirement->fecha_limite ? \Carbon\Carbon::parse($activeRequirement->fecha_limite)->format('d/m/Y') : 'Sin definir' }}
                            </span>
                        </div>
                        <div class="bg-emerald-50 p-3 rounded-xl border border-emerald-100/60">
                            <span class="text-[9px] text-emerald-600 font-bold block uppercase mb-0.5">Presupuesto Estimado</span>
                            <span class="text-xs font-extrabold text-emerald-700">
                                {{ $activeRequirement->presupuesto_estimado ? '$' . number_format($activeRequirement->presupuesto_estimado, 0, ',', '.') : 'Sin cotizar' }}
                            </span>
                        </div>
                    </div>

                    <!-- Description and technical details -->
                    <div class="space-y-2">
                        <span class="text-xs text-slate-400 font-bold uppercase block tracking-wider border-b pb-1">Descripción del Trabajo</span>
                        <p class="text-sm text-slate-800 font-semibold bg-slate-50/50 p-4 rounded-xl border border-slate-100/80 leading-relaxed whitespace-pre-line">{{ $activeRequirement->descripcion }}</p>
                    </div>

                    <!-- Internal Notes -->
                    @if($activeRequirement->observaciones)
                        <div class="space-y-2">
                            <span class="text-xs text-slate-400 font-bold uppercase block tracking-wider border-b pb-1">Notas de Análisis Interno</span>
                            <p class="text-xs text-slate-600 font-semibold bg-indigo-50/20 p-4 rounded-xl border border-indigo-100/30 leading-relaxed italic">{{ $activeRequirement->observaciones }}</p>
                        </div>
                    @endif

                    <!-- Conversion Area to Quote -->
                    @if($activeRequirement->estado !== 'Presupuestado' && $activeRequirement->estado !== 'Completado')
                        <div class="bg-indigo-50/40 p-4 rounded-xl border border-indigo-100/40 flex items-center justify-between gap-4">
                            <div>
                                <h5 class="text-xs font-extrabold text-indigo-950">¿Listo para cotizar formalmente?</h5>
                                <p class="text-[10px] text-indigo-700 font-semibold">Crea un presupuesto en borrador a partir de esta estimación y envíaselo al cliente.</p>
                            </div>
                            <button wire:click="convertToQuote({{ $activeRequirement->id }})" class="inline-flex items-center gap-1.5 px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-xl text-xs font-bold transition-all shadow-sm shrink-0">
                                <x-heroicon-o-document-plus class="w-4 h-4"/> Generar Presupuesto
                            </button>
                        </div>
                    @endif
                </div>

                <div class="bg-slate-50 px-6 py-4 flex justify-end border-t border-slate-100 rounded-b-2xl">
                    <button type="button" wire:click="closeViewModal()" class="px-5 py-2.5 bg-white border border-slate-300 text-slate-700 rounded-xl font-bold text-sm hover:bg-slate-50 transition-colors">
                        Cerrar Ficha
                    </button>
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
