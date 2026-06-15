<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Payment;
use App\Models\Client;
use App\Models\Pool;

class PaymentManager extends Component
{
    public $payments, $pago_id, $fecha, $cliente_id, $servicio, $monto, $periodicidad, $fecha_proximo_pago, $observacion, $estado;
    
    // Atributos para Reseller Pools
    public $pool_id;
    public $porcion_recurso;
    
    public $clients = [];
    public $pools = []; // Pools de recursos activos
    
    public $isOpen = false;
    public $isViewOpen = false;
    public $activePayment = null;
    public $search = '';

    public function mount()
    {
        $this->clients = Client::where('estado', 'Activo')->orderBy('empresa')->get();
        $this->pools = Pool::where('estado', 'Activo')->orderBy('nombre')->get();
    }

    public function render()
    {
        $this->payments = Payment::with(['client', 'pool.supplier'])
            ->where(function($query) {
                $query->whereHas('client', function($q) {
                    $q->where('empresa', 'like', '%'.$this->search.'%')
                      ->orWhere('titular', 'like', '%'.$this->search.'%');
                })
                ->orWhere('servicio', 'like', '%'.$this->search.'%');
            })
            ->orderBy('pago_id', 'desc')
            ->get();
                               
        return view('livewire.payment-manager')
            ->layout('layouts.app', ['header' => 'Gestión de Pagos']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->fecha = date('Y-m-d');
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
        $this->pago_id = null;
        $this->fecha = '';
        $this->cliente_id = '';
        $this->servicio = '';
        $this->monto = '';
        $this->periodicidad = '';
        $this->fecha_proximo_pago = '';
        $this->observacion = '';
        $this->estado = 'Pagado';
        $this->pool_id = null;
        $this->porcion_recurso = '';
    }

    public function store()
    {
        $this->validate([
            'fecha' => 'required|date',
            'cliente_id' => 'required|exists:clientes,cliente_id',
            'servicio' => 'required',
            'monto' => 'required',
            'pool_id' => 'nullable|exists:pools,pool_id',
            'porcion_recurso' => 'nullable|numeric|min:0'
        ], [
            'pool_id.exists' => 'El pool de recursos seleccionado no existe.',
            'porcion_recurso.numeric' => 'La porción asignada debe ser un valor numérico.'
        ]);

        Payment::updateOrCreate(['pago_id' => $this->pago_id], [
            'fecha' => $this->fecha,
            'cliente_id' => $this->cliente_id,
            'servicio' => $this->servicio,
            'monto' => $this->monto,
            'periodicidad' => $this->periodicidad ?: null,
            'fecha_proximo_pago' => $this->fecha_proximo_pago ?: null,
            'observacion' => $this->observacion,
            'estado' => $this->estado ?: 'Pagado',
            'pool_id' => $this->pool_id ?: null,
            'porcion_recurso' => $this->porcion_recurso ?: null
        ]);

        session()->flash('message', 
            $this->pago_id ? 'Pago actualizado.' : 'Pago registrado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
        
        // Recargar pools activos por si cambió alguna asignación
        $this->pools = Pool::where('estado', 'Activo')->orderBy('nombre')->get();
    }

    public function edit($id)
    {
        $payment = Payment::findOrFail($id);
        $this->pago_id = $id;
        $this->fecha = $payment->fecha;
        $this->cliente_id = $payment->cliente_id;
        $this->servicio = $payment->servicio;
        $this->monto = $payment->monto;
        $this->periodicidad = $payment->periodicidad;
        $this->fecha_proximo_pago = $payment->fecha_proximo_pago;
        $this->observacion = $payment->observacion;
        $this->estado = $payment->estado;
        $this->pool_id = $payment->pool_id;
        $this->porcion_recurso = $payment->porcion_recurso;
    
        $this->openModal();
    }

    public function delete($id)
    {
        Payment::find($id)->delete();
        session()->flash('message', 'Pago eliminado exitosamente.');
    }

    public function viewPayment($id)
    {
        $this->activePayment = Payment::with(['client', 'pool.supplier'])->findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->activePayment = null;
    }
}
