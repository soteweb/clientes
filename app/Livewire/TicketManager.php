<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Ticket;
use App\Models\Client;

class TicketManager extends Component
{
    public $search = '';
    public $statusFilter = '';
    public $priorityFilter = '';

    // Gestión de tickets (Modificar / Resolver)
    public $activeTicket = null;
    public $observaciones_admin = '';
    public $newStatus = 'Abierto';
    public $isManageOpen = false;

    // Creación manual de tickets por Admin
    public $isCreateOpen = false;
    public $cliente_id = '';
    public $solicitante_nombre = '';
    public $solicitante_telefono = '';
    public $solicitante_email = '';
    public $asunto = '';
    public $mensaje = '';
    public $prioridad = 'Media';
    public $estado = 'Abierto';
    
    public $clients = [];

    public function mount()
    {
        $this->clients = Client::where('estado', 'Activo')->orderBy('empresa')->get();
    }

    public function render()
    {
        $query = Ticket::with('client')
            ->where(function($q) {
                $q->where('codigo', 'like', '%' . $this->search . '%')
                  ->orWhere('asunto', 'like', '%' . $this->search . '%')
                  ->orWhereHas('client', function($clientQ) {
                      $clientQ->where('empresa', 'like', '%' . $this->search . '%')
                              ->orWhere('titular', 'like', '%' . $this->search . '%');
                  });
            });

        if ($this->statusFilter !== '') {
            $query->where('estado', $this->statusFilter);
        }

        if ($this->priorityFilter !== '') {
            $query->where('prioridad', $this->priorityFilter);
        }

        $tickets = $query->orderBy('ticket_id', 'desc')->get();

        return view('livewire.ticket-manager', ['tickets' => $tickets])
            ->layout('layouts.app', ['header' => 'Gestión de Tickets de Soporte']);
    }

    // Modal de Creación
    public function openCreateModal()
    {
        $this->resetInputFields();
        $this->isCreateOpen = true;
    }

    public function closeCreateModal()
    {
        $this->isCreateOpen = false;
        $this->resetInputFields();
    }

    private function resetInputFields()
    {
        $this->cliente_id = '';
        $this->solicitante_nombre = '';
        $this->solicitante_telefono = '';
        $this->solicitante_email = '';
        $this->asunto = '';
        $this->mensaje = '';
        $this->prioridad = 'Media';
        $this->estado = 'Abierto';
    }

    public function storeTicketAdmin()
    {
        $this->validate([
            'cliente_id' => 'required|exists:clientes,cliente_id',
            'solicitante_nombre' => 'required|min:3|max:100',
            'solicitante_telefono' => 'required|min:6|max:50',
            'solicitante_email' => 'nullable|email|max:100',
            'asunto' => 'required|min:5|max:255',
            'mensaje' => 'required|min:10',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'estado' => 'required|in:Abierto,En Proceso,Resuelto'
        ], [
            'cliente_id.required' => 'Debe seleccionar un cliente de la lista.',
            'solicitante_nombre.required' => 'El nombre del solicitante/técnico es obligatorio.',
            'solicitante_telefono.required' => 'El número de teléfono es obligatorio.',
            'asunto.required' => 'El asunto es obligatorio.',
            'mensaje.required' => 'La descripción es obligatoria.'
        ]);

        $ticket = Ticket::create([
            'codigo' => 'TEMP',
            'cliente_id' => $this->cliente_id,
            'solicitante_nombre' => $this->solicitante_nombre,
            'solicitante_telefono' => $this->solicitante_telefono,
            'solicitante_email' => $this->solicitante_email,
            'asunto' => $this->asunto,
            'mensaje' => $this->mensaje,
            'prioridad' => $this->prioridad,
            'estado' => $this->estado,
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now()
        ]);

        // Generar código único
        $codigo = 'TKT-' . str_pad($ticket->ticket_id, 4, '0', STR_PAD_LEFT);
        $ticket->codigo = $codigo;
        $ticket->save();

        session()->flash('message', 'Ticket de Soporte #' . $codigo . ' creado manualmente con éxito.');

        $this->closeCreateModal();
    }

    // Modal de Gestión
    public function manage($id)
    {
        $this->activeTicket = Ticket::with('client')->findOrFail($id);
        $this->observaciones_admin = $this->activeTicket->observaciones_admin ?? '';
        $this->newStatus = $this->activeTicket->estado;
        $this->isManageOpen = true;
    }

    public function updateTicket()
    {
        $this->validate([
            'newStatus' => 'required|in:Abierto,En Proceso,Resuelto'
        ]);

        if ($this->activeTicket) {
            $this->activeTicket->estado = $this->newStatus;
            $this->activeTicket->observaciones_admin = $this->observaciones_admin;
            $this->activeTicket->save();

            session()->flash('message', 'Ticket #' . $this->activeTicket->codigo . ' actualizado con éxito.');
        }

        $this->closeManageModal();
    }

    public function closeManageModal()
    {
        $this->isManageOpen = false;
        $this->activeTicket = null;
    }

    public function deleteTicket($id)
    {
        Ticket::find($id)->delete();
        session()->flash('message', 'Ticket eliminado correctamente.');
    }
}
