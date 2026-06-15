<?php

namespace App\Livewire\Layout;

use Livewire\Component;
use App\Models\Ticket;

class TicketNotifier extends Component
{
    public $openCount = 0;
    public $lastCount = 0;
    public $playSound = false;

    public function mount()
    {
        $this->openCount = Ticket::where('estado', 'Abierto')->count();
        $this->lastCount = $this->openCount;
    }

    public function checkTickets()
    {
        $current = Ticket::where('estado', 'Abierto')->count();
        
        if ($current > $this->lastCount) {
            $this->playSound = true;
        } else {
            $this->playSound = false;
        }

        $this->openCount = $current;
        $this->lastCount = $current;
    }

    public function render()
    {
        return view('livewire.layout.ticket-notifier');
    }
}
