<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Requirement;
use App\Models\Client;
use App\Models\Quote;

class RequirementManager extends Component
{
    public $search = '';
    public $filterPriority = '';
    public $filterStatus = '';
    public $filterType = ''; // all, clients, prospects

    // Modals visibility
    public $isOpen = false;
    public $isViewOpen = false;

    // Form fields
    public $requirement_id;
    public $cliente_id;
    public $prospecto_nombre;
    public $prospecto_contacto;
    public $prospecto_email;
    public $titulo;
    public $descripcion;
    public $prioridad = 'Media';
    public $estado = 'Pendiente';
    public $fecha_solicitud;
    public $fecha_limite;
    public $presupuesto_estimado;
    public $observaciones;

    // Active inspection requirement
    public $activeRequirement = null;

    public $clients = [];

    public function mount()
    {
        $this->clients = Client::where('estado', 'Activo')->orderBy('empresa')->get();
    }

    public function render()
    {
        $query = Requirement::with('client')
            ->where(function($q) {
                $q->where('titulo', 'like', '%' . $this->search . '%')
                  ->orWhere('descripcion', 'like', '%' . $this->search . '%')
                  ->orWhere('prospecto_nombre', 'like', '%' . $this->search . '%')
                  ->orWhereHas('client', function($cq) {
                      $cq->where('empresa', 'like', '%' . $this->search . '%')
                        ->orWhere('titular', 'like', '%' . $this->search . '%');
                  });
            });

        if ($this->filterPriority) {
            $query->where('prioridad', $this->filterPriority);
        }

        if ($this->filterStatus) {
            $query->where('estado', $this->filterStatus);
        }

        if ($this->filterType === 'clients') {
            $query->whereNotNull('cliente_id');
        } elseif ($this->filterType === 'prospects') {
            $query->whereNull('cliente_id');
        }

        // Ordenar por prioridad (Urgente primero, luego Alta, Media, Baja) y fecha de solicitud desc
        $requirements = $query->orderByRaw("FIELD(prioridad, 'Urgente', 'Alta', 'Media', 'Baja')")
            ->orderBy('id', 'desc')
            ->get();

        return view('livewire.requirement-manager', [
            'requirements' => $requirements
        ])->layout('layouts.app', ['header' => 'Requerimientos y Proyectos']);
    }

    // --- CRUD ACTIONS ---
    public function create()
    {
        $this->resetFields();
        $this->fecha_solicitud = date('Y-m-d');
        $this->isOpen = true;
    }

    public function edit($id)
    {
        $requirement = Requirement::findOrFail($id);
        $this->requirement_id = $requirement->id;
        $this->cliente_id = $requirement->cliente_id;
        $this->prospecto_nombre = $requirement->prospecto_nombre;
        $this->prospecto_contacto = $requirement->prospecto_contacto;
        $this->prospecto_email = $requirement->prospecto_email;
        $this->titulo = $requirement->titulo;
        $this->descripcion = $requirement->descripcion;
        $this->prioridad = $requirement->prioridad;
        $this->estado = $requirement->estado;
        $this->fecha_solicitud = $requirement->fecha_solicitud;
        $this->fecha_limite = $requirement->fecha_limite;
        $this->presupuesto_estimado = $requirement->presupuesto_estimado;
        $this->observaciones = $requirement->observaciones;

        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
        $this->resetFields();
    }

    private function resetFields()
    {
        $this->requirement_id = null;
        $this->cliente_id = null;
        $this->prospecto_nombre = '';
        $this->prospecto_contacto = '';
        $this->prospecto_email = '';
        $this->titulo = '';
        $this->descripcion = '';
        $this->prioridad = 'Media';
        $this->estado = 'Pendiente';
        $this->fecha_solicitud = '';
        $this->fecha_limite = '';
        $this->presupuesto_estimado = '';
        $this->observaciones = '';
    }

    public function store()
    {
        $this->validate([
            'titulo' => 'required|min:3|max:200',
            'descripcion' => 'required|min:5',
            'prioridad' => 'required|in:Baja,Media,Alta,Urgente',
            'estado' => 'required',
            'fecha_solicitud' => 'required|date',
            'fecha_limite' => 'nullable|date',
            'presupuesto_estimado' => 'nullable|numeric|min:0',
            'cliente_id' => 'nullable|exists:clientes,cliente_id',
            'prospecto_nombre' => 'required_without:cliente_id|nullable|max:150',
        ], [
            'titulo.required' => 'El título es obligatorio.',
            'descripcion.required' => 'La descripción del requerimiento es obligatoria.',
            'prospecto_nombre.required_without' => 'Debe elegir un cliente registrado o especificar el nombre de un prospecto.'
        ]);

        Requirement::updateOrCreate(['id' => $this->requirement_id], [
            'cliente_id' => $this->cliente_id ?: null,
            'prospecto_nombre' => $this->cliente_id ? null : $this->prospecto_nombre,
            'prospecto_contacto' => $this->cliente_id ? null : $this->prospecto_contacto,
            'prospecto_email' => $this->cliente_id ? null : $this->prospecto_email,
            'titulo' => $this->titulo,
            'descripcion' => $this->descripcion,
            'prioridad' => $this->prioridad ?: 'Media',
            'estado' => $this->estado ?: 'Pendiente',
            'fecha_solicitud' => $this->fecha_solicitud,
            'fecha_limite' => $this->fecha_limite ?: null,
            'presupuesto_estimado' => $this->presupuesto_estimado ?: null,
            'observaciones' => $this->observaciones ?: null
        ]);

        session()->flash('message', $this->requirement_id ? 'Requerimiento actualizado con éxito.' : 'Requerimiento registrado con éxito.');
        $this->closeModal();
    }

    public function delete($id)
    {
        Requirement::findOrFail($id)->delete();
        session()->flash('message', 'Requerimiento eliminado con éxito.');
    }

    // --- VIEW / INSPECTION ---
    public function viewRequirement($id)
    {
        $this->activeRequirement = Requirement::with('client')->findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->activeRequirement = null;
    }

    // --- SPECIAL TRANSITIONS ---
    
    // Promover Prospecto a Cliente oficial
    public function promoteToClient($id)
    {
        $requirement = Requirement::findOrFail($id);
        
        if ($requirement->cliente_id) {
            session()->flash('message', 'Este requerimiento ya está vinculado a un cliente registrado.');
            return;
        }

        // Crear Cliente
        $client = Client::create([
            'empresa' => $requirement->prospecto_nombre,
            'titular' => $requirement->prospecto_nombre,
            'telefono' => $requirement->prospecto_contacto ?: null,
            'email' => $requirement->prospecto_email ?: null,
            'estado' => 'Activo',
            'observacion' => 'Registrado automáticamente desde Requerimiento #' . $requirement->id
        ]);

        // Actualizar requerimiento
        $requirement->update([
            'cliente_id' => $client->cliente_id,
            'prospecto_nombre' => null,
            'prospecto_contacto' => null,
            'prospecto_email' => null
        ]);

        // Recargar clientes para el modal select
        $this->clients = Client::where('estado', 'Activo')->orderBy('empresa')->get();

        session()->flash('message', '¡Prospecto promovido a Cliente registrado con éxito!');
        
        if ($this->isViewOpen && $this->activeRequirement && $this->activeRequirement->id == $id) {
            $this->viewRequirement($id);
        }
    }

    // Convertir requerimiento en Presupuesto formal
    public function convertToQuote($id)
    {
        $requirement = Requirement::findOrFail($id);

        // Crear Presupuesto
        $quote = Quote::create([
            'cliente_id' => $requirement->cliente_id ?: null,
            'cliente_prospecto' => $requirement->cliente_id ? null : $requirement->prospecto_nombre,
            'fecha' => date('Y-m-d'),
            'moneda' => 'USD', // Moneda por defecto
            'total' => $requirement->presupuesto_estimado ?: 0,
            'estado' => 'Pendiente',
            'observacion' => 'Generado desde Requerimiento #' . $requirement->id . ': ' . $requirement->titulo,
            'detalles' => $requirement->descripcion
        ]);

        // Cambiar estado del requerimiento
        $requirement->update([
            'estado' => 'Presupuestado'
        ]);

        session()->flash('message', '¡Presupuesto borrador #' . $quote->id . ' generado correctamente!');
        
        if ($this->isViewOpen && $this->activeRequirement && $this->activeRequirement->id == $id) {
            $this->viewRequirement($id);
        }
    }
}
