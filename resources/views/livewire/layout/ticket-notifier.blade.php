<div wire:poll.10s="checkTickets" class="relative inline-flex items-center">
    @if($playSound)
        <script>
            // Reproducir sonido de notificación suave al recibir un ticket nuevo
            let audio = new Audio('https://assets.mixkit.co/active_storage/sfx/2869/2869-preview.mp3');
            audio.play().catch(e => console.log('Audio autoplay prevented by browser policy'));
        </script>
    @endif

    <a href="{{ route('tickets.index') }}" title="Tickets Abiertos Pendientes" class="relative p-2.5 bg-white rounded-xl border border-slate-200 text-slate-600 hover:text-blue-600 hover:bg-blue-50 transition-all shadow-sm flex items-center justify-center group">
        <x-heroicon-o-bell class="w-5 h-5 transition-transform group-hover:rotate-12"/>
        
        @if($openCount > 0)
            <span class="absolute -top-1.5 -right-1.5 flex h-5 w-5 items-center justify-center">
                <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                <span class="relative inline-flex rounded-full h-5 w-5 bg-red-600 text-[10px] font-black text-white items-center justify-center shadow-sm">
                    {{ $openCount }}
                </span>
            </span>
        @endif
    </a>
</div>
