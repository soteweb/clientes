<?php

use App\Livewire\Actions\Logout;
use Livewire\Volt\Component;

new class extends Component
{
    /**
     * Log the current user out of the application.
     */
    public function logout(Logout $logout): void
    {
        $logout();

        $this->redirect('/', navigate: true);
    }
}; ?>

<div :class="sidebarOpen ? 'p-3 bg-slate-50 justify-between border' : 'p-1 justify-center border-none'" class="flex items-center w-full rounded-xl border-slate-100 transition-all">
    <div class="flex items-center gap-3 overflow-hidden" x-show="sidebarOpen" x-transition>
        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-xs uppercase shrink-0 shadow-sm">
            {{ substr(auth()->user()->nombre ?? auth()->user()->username ?? 'U', 0, 2) }}
        </div>
        <div class="overflow-hidden leading-tight">
            <div class="font-bold text-sm text-slate-900 truncate">{{ auth()->user()->nombre ?? auth()->user()->username }}</div>
            <div class="text-xs text-blue-600 font-medium capitalize">{{ auth()->user()->rol ?? 'Gestor' }}</div>
        </div>
    </div>
    
    <button wire:click="logout" title="Cerrar Sesión" class="text-slate-400 hover:text-red-600 p-2 rounded-lg hover:bg-red-50 transition-colors shrink-0">
        <x-heroicon-o-arrow-right-on-rectangle class="w-5 h-5"/>
    </button>
</div>
