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
                        <input wire:model.live="search" type="text" class="block w-full pl-10 pr-3 py-2 border border-slate-200 rounded-lg leading-5 bg-slate-50 placeholder-slate-400 focus:outline-none focus:bg-white focus:ring-2 focus:ring-blue-500 focus:border-blue-500 sm:text-sm transition-colors" placeholder="Buscar por nombre o usuario...">
                    </div>
                </div>
                <div>
                    <button wire:click="create()" class="inline-flex items-center justify-center px-4 py-2 border border-transparent text-sm font-medium rounded-lg text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 shadow-sm transition-colors">
                        <x-heroicon-o-user-plus class="w-5 h-5 mr-2 -ml-1"/> Nuevo Usuario
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
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Nombre</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Usuario (Username)</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-semibold text-slate-500 uppercase tracking-wider">Rol</th>
                            <th scope="col" class="px-6 py-3 text-right text-xs font-semibold text-slate-500 uppercase tracking-wider">Acciones</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-slate-100">
                        @forelse($users as $user)
                        <tr class="hover:bg-slate-50 transition-colors">
                            <td class="px-6 py-4 whitespace-nowrap font-medium text-slate-900">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-700 flex items-center justify-center font-bold text-xs uppercase">
                                        {{ substr($user->nombre, 0, 2) }}
                                    </div>
                                    <span>{{ $user->nombre }}</span>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-slate-600">
                                @{{ $user->username }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                @if($user->rol == 'administrador')
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-purple-100 text-purple-800">Administrador</span>
                                @else
                                    <span class="px-2.5 py-1 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">Gestor</span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <button wire:click="edit({{ $user->id }})" class="text-blue-600 hover:text-blue-900 bg-blue-50 p-2 rounded-lg transition-colors mr-2">
                                    <x-heroicon-o-pencil-square class="w-5 h-5"/>
                                </button>
                                <button wire:click="delete({{ $user->id }})" wire:confirm="¿Estás seguro de que deseas eliminar este usuario?" class="text-red-600 hover:text-red-900 bg-red-50 p-2 rounded-lg transition-colors">
                                    <x-heroicon-o-trash class="w-5 h-5"/>
                                </button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="4" class="px-6 py-10 text-center text-slate-500">
                                <x-heroicon-o-users class="mx-auto h-12 w-12 text-slate-300"/>
                                <h3 class="mt-2 text-sm font-medium text-slate-900">No hay usuarios</h3>
                                <p class="mt-1 text-sm text-slate-500">No se encontraron usuarios con esos criterios.</p>
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Modal -->
    @if($isOpen)
    <div class="fixed z-50 inset-0 overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            
            <div class="fixed inset-0 bg-slate-900 bg-opacity-75 transition-opacity" aria-hidden="true" wire:click="closeModal()"></div>

            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <form wire:submit.prevent="store">
                    <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                        <div class="sm:flex sm:items-start">
                            <div class="mt-3 text-center sm:mt-0 sm:text-left w-full">
                                <h3 class="text-lg leading-6 font-bold text-slate-900 mb-4 pb-3 border-b" id="modal-title">
                                    {{ $user_id ? 'Editar Usuario' : 'Nuevo Usuario' }}
                                </h3>
                                
                                <div class="space-y-4 pt-2">
                                    <div>
                                        <label for="nombre" class="block text-sm font-medium text-slate-700">Nombre Completo *</label>
                                        <input type="text" wire:model="nombre" id="nombre" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                        @error('nombre') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="username" class="block text-sm font-medium text-slate-700">Usuario (Login) *</label>
                                        <input type="text" wire:model="username" id="username" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                        @error('username') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="password" class="block text-sm font-medium text-slate-700">
                                            Contraseña {{ $user_id ? '(Dejar en blanco para no cambiar)' : '*' }}
                                        </label>
                                        <input type="password" wire:model="password" id="password" class="mt-1 focus:ring-blue-500 focus:border-blue-500 block w-full shadow-sm sm:text-sm border-slate-300 rounded-md">
                                        @error('password') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>

                                    <div>
                                        <label for="rol" class="block text-sm font-medium text-slate-700">Rol en el Sistema *</label>
                                        <select wire:model="rol" id="rol" class="mt-1 block w-full py-2 px-3 border border-slate-300 bg-white rounded-md shadow-sm focus:outline-none focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                            <option value="gestor">Gestor</option>
                                            <option value="administrador">Administrador</option>
                                        </select>
                                        @error('rol') <span class="text-red-500 text-xs">{{ $message }}</span> @enderror
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="bg-slate-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse border-t border-slate-100">
                        <button type="submit" class="w-full inline-flex justify-center rounded-lg border border-transparent shadow-sm px-4 py-2 bg-blue-600 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Guardar
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
</div>
