<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Client;
use Livewire\Attributes\Rule;

class ClientManager extends Component
{
    public $clients, $empresa, $titular, $ruc, $telefono, $email, $direccion, $ciudad, $estado = 'Activo', $observacion, $cliente_id;
    public $isOpen = false;
    public $isViewOpen = false;
    public $isPaymentsOpen = false;
    public $activeClient = null;
    public $search = '';

    public function render()
    {
        $this->clients = Client::where('empresa', 'like', '%'.$this->search.'%')
                               ->orWhere('titular', 'like', '%'.$this->search.'%')
                               ->orWhere('ruc', 'like', '%'.$this->search.'%')
                               ->orWhere('email', 'like', '%'.$this->search.'%')
                               ->orderBy('cliente_id', 'desc')
                               ->get();
                               
        return view('livewire.client-manager')
            ->layout('layouts.app', ['header' => 'Gestión de Clientes']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->openModal();
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    private function resetInputFields(){
        $this->cliente_id = null;
        $this->empresa = '';
        $this->titular = '';
        $this->ruc = '';
        $this->telefono = '';
        $this->email = '';
        $this->direccion = '';
        $this->ciudad = '';
        $this->estado = 'Activo';
        $this->observacion = '';
    }

    public function store()
    {
        $this->validate([
            'empresa' => 'required',
            'titular' => 'nullable',
            'estado' => 'required'
        ]);

        Client::updateOrCreate(['cliente_id' => $this->cliente_id], [
            'empresa' => $this->empresa,
            'titular' => $this->titular,
            'ruc' => $this->ruc,
            'telefono' => $this->telefono,
            'email' => $this->email,
            'direccion' => $this->direccion,
            'ciudad' => $this->ciudad,
            'estado' => $this->estado,
            'observacion' => $this->observacion
        ]);

        session()->flash('message', 
            $this->cliente_id ? 'Cliente actualizado.' : 'Cliente creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $client = Client::findOrFail($id);
        $this->cliente_id = $id;
        $this->empresa = $client->empresa;
        $this->titular = $client->titular;
        $this->ruc = $client->ruc;
        $this->telefono = $client->telefono;
        $this->email = $client->email;
        $this->direccion = $client->direccion;
        $this->ciudad = $client->ciudad;
        $this->estado = $client->estado;
        $this->observacion = $client->observacion;
    
        $this->openModal();
    }

    public function delete($id)
    {
        if (auth()->user()->rol !== 'administrador') {
            session()->flash('error', 'No tienes autorización para eliminar clientes.');
            return;
        }

        Client::find($id)->delete();
        session()->flash('message', 'Cliente eliminado exitosamente.');
    }

    public function viewClient($id)
    {
        $this->activeClient = Client::with(['quotes' => function($q) { $q->orderBy('id', 'desc'); }])->findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->activeClient = null;
    }

    public function viewPayments($id)
    {
        $this->activeClient = Client::with(['payments' => function($q) { $q->orderBy('pago_id', 'desc'); }])->findOrFail($id);
        $this->isPaymentsOpen = true;
    }

    public function closePaymentsModal()
    {
        $this->isPaymentsOpen = false;
        $this->activeClient = null;
    }
}
