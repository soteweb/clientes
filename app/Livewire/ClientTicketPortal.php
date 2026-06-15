<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\WithFileUploads;
use App\Models\Client;
use App\Models\Ticket;

class ClientTicketPortal extends Component
{
    use WithFileUploads;

    public $tab = 'new'; // 'new' o 'status'

    // Formulario de creación
    public $searchRuc = '';
    public $searchResults = [];
    public $selectedClient = null;
    
    // Datos del solicitante / técnico
    public $solicitante_nombre = '';
    public $solicitante_telefono = '';
    public $solicitante_email = '';

    public $asunto = '';
    public $prioridad = 'Media';
    public $mensaje = '';
    public $archivo = null;
    public $createdTicket = null;

    // Consulta de estado
    public $searchCode = '';
    public $statusTicket = null;
    public $statusError = '';

    public function updatedSearchRuc()
    {
        if (strlen($this->searchRuc) >= 2) {
            $this->searchResults = Client::where('ruc', 'like', '%' . $this->searchRuc . '%')
                ->orWhere('empresa', 'like', '%' . $this->searchRuc . '%')
                ->orWhere('titular', 'like', '%' . $this->searchRuc . '%')
                ->where('estado', 'Activo')
                ->take(5)
                ->get();
        } else {
            $this->searchResults = [];
        }
    }

    public function selectClient($id)
    {
        $this->selectedClient = Client::find($id);
        $this->searchResults = [];
    }

    public function resetSelection()
    {
        $this->selectedClient = null;
        $this->searchRuc = '';
        $this->searchResults = [];
    }

    public function storeTicket()
    {
        $this->validate([
            'selectedClient' => 'required',
            'solicitante_nombre' => 'required|min:3|max:100',
            'solicitante_telefono' => 'required|min:6|max:50',
            'solicitante_email' => 'nullable|email|max:100',
            'asunto' => 'required|min:5|max:255',
            'mensaje' => 'required|min:10',
            'prioridad' => 'required|in:Alta,Media,Baja',
            'archivo' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:10240' // máx 10MB
        ], [
            'selectedClient.required' => 'Por favor, busque y seleccione su empresa o nombre.',
            'solicitante_nombre.required' => 'Por favor, indícanos tu nombre completo.',
            'solicitante_telefono.required' => 'El número de teléfono o WhatsApp es obligatorio para contactarte.',
            'solicitante_email.email' => 'El correo electrónico no tiene un formato válido.',
            'asunto.required' => 'El asunto es obligatorio.',
            'asunto.min' => 'El asunto debe tener al menos 5 caracteres.',
            'mensaje.required' => 'Por favor, describa detalladamente su caso.',
            'mensaje.min' => 'El mensaje debe tener al menos 10 caracteres.',
            'archivo.mimes' => 'El archivo adjunto solo puede ser una imagen (JPG, PNG) o un documento PDF.',
            'archivo.max' => 'El archivo no debe pesar más de 10 MB.'
        ]);

        $path = null;
        $nombreOriginal = null;

        if ($this->archivo) {
            $nombreOriginal = $this->archivo->getClientOriginalName();
            $path = $this->archivo->store('tickets_adjuntos', 'public');
        }

        $ticket = Ticket::create([
            'codigo' => 'TEMP',
            'cliente_id' => $this->selectedClient->cliente_id,
            'solicitante_nombre' => $this->solicitante_nombre,
            'solicitante_telefono' => $this->solicitante_telefono,
            'solicitante_email' => $this->solicitante_email,
            'asunto' => $this->asunto,
            'mensaje' => $this->mensaje,
            'archivo_path' => $path,
            'archivo_nombre' => $nombreOriginal,
            'prioridad' => $this->prioridad,
            'estado' => 'Abierto',
            'fecha_creacion' => now(),
            'fecha_actualizacion' => now()
        ]);

        // Generar código único
        $codigo = 'TKT-' . str_pad($ticket->ticket_id, 4, '0', STR_PAD_LEFT);
        $ticket->codigo = $codigo;
        $ticket->save();

        $this->createdTicket = $ticket;
    }

    public function createAnother()
    {
        $this->reset(['solicitante_nombre', 'solicitante_telefono', 'solicitante_email', 'asunto', 'mensaje', 'prioridad', 'archivo', 'createdTicket']);
    }

    public function checkStatus()
    {
        $this->validate([
            'searchCode' => 'required'
        ], [
            'searchCode.required' => 'Por favor ingrese el código del ticket.'
        ]);

        $code = strtoupper(trim($this->searchCode));
        $this->statusTicket = Ticket::with('client')->where('codigo', $code)->first();

        if (!$this->statusTicket) {
            $this->statusError = 'No se encontró ningún ticket con el código ' . $code;
        } else {
            $this->statusError = '';
        }
    }

    public function render()
    {
        return view('livewire.client-ticket-portal')
            ->layout('layouts.guest', ['title' => 'Portal de Soporte Técnico']);
    }
}
