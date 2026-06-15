<div class="space-y-6">
    <!-- Header & Tabs -->
    <div class="text-center pb-4 border-b border-slate-100">
        <h1 class="text-2xl font-black text-slate-900 tracking-tight">Portal de Soporte Técnico y Ayuda</h1>
        <p class="text-sm text-slate-500 mt-1">Estamos aquí para resolver tus inconvenientes o atender tus consultas</p>

        <div class="flex justify-center gap-2 mt-6">
            <button wire:click="$set('tab', 'new')" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 {{ $tab == 'new' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <x-heroicon-o-plus-circle class="w-5 h-5"/> Abrir Nuevo Caso
            </button>
            <button wire:click="$set('tab', 'status')" class="px-5 py-2.5 rounded-xl font-bold text-sm transition-all flex items-center gap-2 {{ $tab == 'status' ? 'bg-blue-600 text-white shadow-md shadow-blue-500/20' : 'bg-slate-100 text-slate-600 hover:bg-slate-200' }}">
                <x-heroicon-o-magnifying-glass-circle class="w-5 h-5"/> Consultar Estado de Ticket
            </button>
        </div>
    </div>

    @if ($tab == 'new')
        @if ($createdTicket)
            <!-- Ticket Created Success Card -->
            <div class="bg-gradient-to-br from-emerald-500 to-teal-600 text-white rounded-3xl p-8 text-center space-y-6 shadow-xl">
                <div class="w-20 h-20 bg-white/20 rounded-full flex items-center justify-center mx-auto backdrop-blur-sm">
                    <x-heroicon-o-check-circle class="w-12 h-12 text-white"/>
                </div>
                <div>
                    <h2 class="text-3xl font-black">¡Ticket Creado Exitosamente!</h2>
                    <p class="text-emerald-100 font-medium mt-2">Hemos registrado tu caso y nuestro equipo lo atenderá a la brevedad.</p>
                </div>
                
                <div class="bg-white/10 rounded-2xl p-6 backdrop-blur-md max-w-md mx-auto border border-white/20 space-y-3">
                    <span class="text-xs text-emerald-200 uppercase tracking-widest font-bold block">Código de Seguimiento</span>
                    <div class="text-4xl font-black tracking-wider text-white">{{ $createdTicket->codigo }}</div>
                    <div class="pt-2 border-t border-white/10 text-xs text-emerald-100">
                        <span class="font-bold">Solicitante:</span> {{ $createdTicket->solicitante_nombre }} (Tel: {{ $createdTicket->solicitante_telefono }})
                    </div>
                    @if($createdTicket->archivo_nombre)
                        <div class="pt-1 text-xs text-emerald-200 flex items-center justify-center gap-1">
                            <x-heroicon-o-paper-clip class="w-4 h-4"/> Archivo adjunto: {{ $createdTicket->archivo_nombre }}
                        </div>
                    @endif
                </div>

                <div class="pt-4">
                    <button wire:click="createAnother" class="px-6 py-3 bg-white text-emerald-700 hover:bg-emerald-50 font-bold rounded-xl shadow-md transition-transform hover:scale-105 text-sm">
                        Abrir otro caso
                    </button>
                </div>
            </div>
        @else
            <!-- Formulario de Creación -->
            <form wire:submit.prevent="storeTicket" class="space-y-6">
                <!-- Paso 1: Buscar Cliente -->
                <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 space-y-4">
                    <div class="flex items-center justify-between">
                        <label class="block text-sm font-bold text-slate-900">
                            1. Identifica tu Empresa o Nombre *
                        </label>
                        @if($selectedClient)
                            <button type="button" wire:click="resetSelection" class="text-xs text-blue-600 hover:text-blue-800 font-bold flex items-center gap-1">
                                <x-heroicon-o-arrow-path class="w-3.5 h-3.5"/> Cambiar Empresa
                            </button>
                        @endif
                    </div>

                    @if(!$selectedClient)
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                <x-heroicon-o-building-office class="w-5 h-5 text-slate-400"/>
                            </div>
                            <input wire:model.live.debounce.300ms="searchRuc" type="text" placeholder="Ingresa tu RUC o Nombre para buscar tu ficha..." class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none font-medium text-sm transition-shadow shadow-sm">
                        </div>

                        @if(!empty($searchResults))
                            <div class="bg-white border border-slate-200 rounded-xl shadow-lg divide-y divide-slate-100 overflow-hidden mt-2">
                                @foreach($searchResults as $client)
                                    <div wire:click="selectClient({{ $client->cliente_id }})" class="p-3.5 hover:bg-blue-50 cursor-pointer flex items-center justify-between transition-colors group">
                                        <div>
                                            <div class="font-bold text-slate-900 group-hover:text-blue-700">{{ $client->empresa ?: $client->titular }}</div>
                                            @if($client->ruc)
                                                <div class="text-xs text-slate-500 font-medium mt-0.5">RUC / Doc: {{ $client->ruc }}</div>
                                            @endif
                                        </div>
                                        <x-heroicon-o-chevron-right class="w-5 h-5 text-slate-400 group-hover:text-blue-600"/>
                                    </div>
                                @endforeach
                            </div>
                        @elseif(strlen($searchRuc) >= 2)
                            <p class="text-xs text-amber-600 font-semibold mt-2 flex items-center gap-1">
                                <x-heroicon-o-exclamation-triangle class="w-4 h-4"/> No se encontraron empresas activas que coincidan con tu búsqueda.
                            </p>
                        @endif
                        @error('selectedClient') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                    @else
                        <!-- Empresa Seleccionada -->
                        <div class="bg-white border border-blue-200 p-4 rounded-xl flex items-center justify-between shadow-sm">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-lg bg-blue-100 text-blue-700 flex items-center justify-center font-bold">
                                    <x-heroicon-o-check class="w-6 h-6"/>
                                </div>
                                <div>
                                    <span class="text-xs text-slate-400 uppercase font-semibold block">Empresa Seleccionada</span>
                                    <span class="font-bold text-slate-900 text-base">{{ $selectedClient->empresa ?: $selectedClient->titular }}</span>
                                    @if($selectedClient->ruc)
                                        <span class="text-xs text-slate-500 ml-2 font-medium">RUC: {{ $selectedClient->ruc }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

                @if($selectedClient)
                <!-- Paso 2: Datos de Quien Solicita -->
                <div class="space-y-4 bg-blue-50/50 p-6 rounded-2xl border border-blue-100 animate-fadeIn">
                    <div class="border-b border-blue-200 pb-2">
                        <label class="block text-sm font-extrabold text-blue-900 flex items-center gap-2">
                            <x-heroicon-o-user-circle class="w-5 h-5 text-blue-600"/> 
                            2. ¿Quién está solicitando el soporte? (Técnico / Encargado)
                        </label>
                        <p class="text-xs text-blue-700 mt-0.5">Indícanos tus datos para ponernos en contacto directo contigo durante la resolución.</p>
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="solicitante_nombre" class="block text-xs font-bold text-slate-700 uppercase mb-1">Nombre Completo del Técnico / Contacto *</label>
                            <input wire:model="solicitante_nombre" id="solicitante_nombre" type="text" placeholder="Ej: Ing. Carlos Mendoza" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-medium text-sm bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            @error('solicitante_nombre') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>

                        <div>
                            <label for="solicitante_telefono" class="block text-xs font-bold text-slate-700 uppercase mb-1">Número de Teléfono / WhatsApp *</label>
                            <input wire:model="solicitante_telefono" id="solicitante_telefono" type="text" placeholder="Ej: 0981 123 456" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-medium text-sm bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none">
                            @error('solicitante_telefono') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <div>
                        <label for="solicitante_email" class="block text-xs font-bold text-slate-700 uppercase mb-1">Correo Electrónico (Opcional)</label>
                        <input wire:model="solicitante_email" id="solicitante_email" type="email" placeholder="Ej: cmendoza@empresa.com" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-medium text-sm bg-white focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        @error('solicitante_email') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Paso 3: Detalles del Ticket y Archivo Adjunto -->
                <div class="space-y-6 bg-slate-50 p-6 rounded-2xl border border-slate-100 animate-fadeIn">
                    <label class="block text-sm font-bold text-slate-900 border-b pb-2">
                        3. Describe tu Caso y Adjunta Archivos (Si aplica)
                    </label>

                    <div>
                        <label for="asunto" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Asunto / Resumen del Problema *</label>
                        <input wire:model="asunto" id="asunto" type="text" placeholder="Ej: Subir nuevos banners de promoción al sitio web" class="w-full px-4 py-3 border border-slate-200 rounded-xl font-medium text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                        @error('asunto') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-2">Nivel de Prioridad *</label>
                        <div class="grid grid-cols-3 gap-3">
                            <label class="flex items-center justify-center gap-2 p-3 bg-white border rounded-xl cursor-pointer transition-all {{ $prioridad == 'Baja' ? 'border-blue-600 ring-2 ring-blue-600/20 bg-blue-50/50' : 'border-slate-200 hover:border-slate-300' }}">
                                <input wire:model="prioridad" type="radio" value="Baja" class="sr-only">
                                <span class="w-3 h-3 rounded-full bg-blue-500"></span>
                                <span class="text-sm font-bold text-slate-800">Baja</span>
                            </label>

                            <label class="flex items-center justify-center gap-2 p-3 bg-white border rounded-xl cursor-pointer transition-all {{ $prioridad == 'Media' ? 'border-amber-600 ring-2 ring-amber-600/20 bg-amber-50/50' : 'border-slate-200 hover:border-slate-300' }}">
                                <input wire:model="prioridad" type="radio" value="Media" class="sr-only">
                                <span class="w-3 h-3 rounded-full bg-amber-500"></span>
                                <span class="text-sm font-bold text-slate-800">Media</span>
                            </label>

                            <label class="flex items-center justify-center gap-2 p-3 bg-white border rounded-xl cursor-pointer transition-all {{ $prioridad == 'Alta' ? 'border-red-600 ring-2 ring-red-600/20 bg-red-50/50' : 'border-slate-200 hover:border-slate-300' }}">
                                <input wire:model="prioridad" type="radio" value="Alta" class="sr-only">
                                <span class="w-3 h-3 rounded-full bg-red-500"></span>
                                <span class="text-sm font-bold text-slate-800">Alta</span>
                            </label>
                        </div>
                    </div>

                    <div>
                        <label for="mensaje" class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1">Descripción Detallada o Instrucciones *</label>
                        <textarea wire:model="mensaje" id="mensaje" rows="5" placeholder="Explica qué cambios necesitas, en qué sección de la web y las instrucciones sobre los archivos adjuntos..." class="w-full px-4 py-3 border border-slate-200 rounded-xl font-medium text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none leading-relaxed"></textarea>
                        @error('mensaje') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <!-- Archivo Adjunto -->
                    <div class="bg-white p-4 rounded-xl border border-slate-200">
                        <label class="block text-xs font-bold text-slate-700 uppercase tracking-wider mb-1 flex items-center gap-1.5">
                            <x-heroicon-o-paper-clip class="w-4 h-4 text-blue-600"/> Adjuntar Archivo (Imagen JPG/PNG o Documento PDF)
                        </label>
                        <p class="text-xs text-slate-500 mb-2">Sube la imagen, foto o documento PDF que deseas que nuestro equipo procese (Máx 10 MB).</p>
                        
                        <input wire:model="archivo" type="file" accept=".jpg,.jpeg,.png,.pdf" class="block w-full text-sm text-slate-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-xl file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100 file:cursor-pointer cursor-pointer transition-colors">
                        
                        <div wire:loading wire:target="archivo" class="text-xs text-blue-600 font-bold mt-2 flex items-center gap-2">
                            <svg class="animate-spin h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                            Subiendo archivo adjunto, por favor espera...
                        </div>

                        @error('archivo') <span class="text-red-500 text-xs font-semibold mt-1 block">{{ $message }}</span> @enderror
                        @if($archivo && !$errors->has('archivo'))
                            <span class="text-xs font-bold text-emerald-600 block mt-2">✔️ Archivo cargado correctamente: {{ $archivo->getClientOriginalName() }}</span>
                        @endif
                    </div>

                    <div class="pt-2">
                        <button type="submit" wire:loading.attr="disabled" class="w-full py-4 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-lg shadow-blue-500/30 transition-transform hover:scale-[1.01] flex items-center justify-center gap-2 text-base disabled:opacity-50 disabled:hover:scale-100">
                            <x-heroicon-o-paper-airplane class="w-5 h-5"/> Enviar Ticket de Soporte con Archivos
                        </button>
                    </div>
                </div>
                @endif
            </form>
        @endif
    @endif

    @if ($tab == 'status')
        <div class="space-y-6">
            <div class="bg-slate-50 p-6 rounded-2xl border border-slate-100 space-y-4">
                <label for="searchCode" class="block text-sm font-bold text-slate-900">
                    Ingresa tu Código de Ticket (Ej: TKT-1001)
                </label>
                <div class="flex gap-3">
                    <div class="relative flex-1">
                        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                            <x-heroicon-o-ticket class="w-5 h-5 text-slate-400"/>
                        </div>
                        <input wire:model="searchCode" id="searchCode" wire:keydown.enter="checkStatus" type="text" placeholder="TKT-XXXX" class="w-full pl-11 pr-4 py-3 border border-slate-200 rounded-xl font-bold uppercase tracking-wider text-sm focus:ring-2 focus:ring-blue-600 focus:outline-none">
                    </div>
                    <button wire:click="checkStatus" class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md flex items-center gap-2 transition-transform hover:scale-105">
                        <x-heroicon-o-magnifying-glass class="w-5 h-5"/> Consultar
                    </button>
                </div>
                @error('searchCode') <span class="text-red-500 text-xs font-semibold">{{ $message }}</span> @enderror
                @if($statusError)
                    <p class="text-sm font-semibold text-red-600 bg-red-50 p-3 rounded-xl border border-red-100 flex items-center gap-2">
                        <x-heroicon-o-x-circle class="w-5 h-5 shrink-0"/> {{ $statusError }}
                    </p>
                @endif
            </div>

            @if($statusTicket)
                <!-- Tarjeta de Estado del Ticket -->
                <div class="bg-white border border-slate-200 rounded-2xl shadow-xl overflow-hidden animate-fadeIn">
                    <div class="bg-slate-900 p-6 text-white flex items-center justify-between">
                        <div>
                            <span class="text-xs text-slate-400 uppercase tracking-widest font-bold">Código del Ticket</span>
                            <h3 class="text-2xl font-black text-white mt-0.5">{{ $statusTicket->codigo }}</h3>
                        </div>
                        <div>
                            @if($statusTicket->estado == 'Abierto')
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-blue-500 text-white shadow-sm">
                                    Abierto
                                </span>
                            @elseif($statusTicket->estado == 'En Proceso')
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-amber-500 text-white shadow-sm">
                                    En Proceso
                                </span>
                            @else
                                <span class="px-4 py-1.5 rounded-full text-xs font-black uppercase tracking-wider bg-emerald-500 text-white shadow-sm">
                                    Resuelto
                                </span>
                            @endif
                        </div>
                    </div>

                    <div class="p-6 space-y-6">
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 pb-4 border-b border-slate-100">
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold block">Empresa Solicitante</span>
                                <span class="font-bold text-slate-900 text-base">{{ $statusTicket->client ? ($statusTicket->client->empresa ?: $statusTicket->client->titular) : 'Cliente Eliminado' }}</span>
                            </div>
                            <div class="sm:text-right">
                                <span class="text-xs text-slate-400 uppercase font-semibold block">Persona de Contacto / Técnico</span>
                                <span class="font-bold text-blue-600 text-sm block">{{ $statusTicket->solicitante_nombre ?: 'No especificado' }}</span>
                                <span class="text-xs text-slate-500">Tel: {{ $statusTicket->solicitante_telefono ?: 'N/D' }}</span>
                            </div>
                        </div>

                        <div>
                            <span class="text-xs text-slate-400 uppercase font-semibold block mb-1">Asunto</span>
                            <h4 class="font-black text-slate-900 text-lg">{{ $statusTicket->asunto }}</h4>
                        </div>

                        <div class="bg-slate-50 p-4 rounded-xl border border-slate-100 space-y-4">
                            <div>
                                <span class="text-xs text-slate-400 uppercase font-semibold block mb-1">Mensaje Original</span>
                                <p class="text-slate-700 text-sm leading-relaxed whitespace-pre-line">{{ $statusTicket->mensaje }}</p>
                            </div>
                            @if($statusTicket->archivo_path)
                                <div class="pt-3 border-t border-slate-200">
                                    <span class="text-xs text-slate-400 uppercase font-semibold block mb-1.5">Archivo Adjunto</span>
                                    <a href="{{ asset('storage/' . $statusTicket->archivo_path) }}" target="_blank" class="inline-flex items-center gap-2 px-4 py-2 bg-white hover:bg-blue-50 border border-slate-200 hover:border-blue-300 text-blue-700 rounded-xl font-bold text-xs shadow-sm transition-all">
                                        <x-heroicon-o-arrow-down-tray class="w-4 h-4"/> Descargar {{ $statusTicket->archivo_nombre }}
                                    </a>
                                </div>
                            @endif
                        </div>

                        @if($statusTicket->observaciones_admin)
                            <div class="bg-emerald-50 border border-emerald-200 rounded-xl p-5 shadow-sm">
                                <div class="flex items-center gap-2 text-emerald-800 font-extrabold text-sm mb-2">
                                    <x-heroicon-s-check-badge class="w-5 h-5 text-emerald-600"/> Respuesta / Solución del Equipo de Soteweb:
                                </div>
                                <p class="text-emerald-900 text-sm whitespace-pre-line leading-relaxed font-medium">{{ $statusTicket->observaciones_admin }}</p>
                            </div>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    @endif
</div>
