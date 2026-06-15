<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Supplier;
use App\Models\Pool;

class ResellerManager extends Component
{
    public $activeTab = 'pools'; // pools, suppliers
    public $search = '';

    // Modals visibility
    public $isSupplierOpen = false;
    public $isPoolOpen = false;
    public $isPoolDetailOpen = false;

    // Supplier Form Fields
    public $supplier_id;
    public $supplier_nombre;
    public $supplier_contacto;
    public $supplier_telefono;
    public $supplier_email;
    public $supplier_sitio_web;
    public $supplier_observacion;

    // Pool Form Fields
    public $pool_id;
    public $pool_proveedor_id;
    public $pool_nombre;
    public $pool_costo;
    public $pool_periodicidad = 'Mensual';
    public $pool_fecha_compra;
    public $pool_fecha_vencimiento;
    public $pool_recurso_tipo = 'Almacenamiento (GB)';
    public $pool_recurso_capacidad;
    public $pool_estado = 'Activo';
    public $pool_observacion;

    // Active inspection pool
    public $activePool = null;

    protected $rules = [];

    public function render()
    {
        // Consultar Proveedores
        $suppliers = Supplier::where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('proveedor_id', 'desc')
            ->get();

        // Consultar Pools
        $pools = Pool::with('supplier', 'payments.client')
            ->where('nombre', 'like', '%' . $this->search . '%')
            ->orderBy('pool_id', 'desc')
            ->get();

        return view('livewire.reseller-manager', [
            'suppliers' => $suppliers,
            'pools' => $pools
        ])->layout('layouts.app', ['header' => 'Gestión de Reseller y Servidores']);
    }

    // --- TAB SWITCHER ---
    public function setTab($tab)
    {
        $this->activeTab = $tab;
        $this->search = '';
    }

    // --- SUPPLIER ACTIONS ---
    public function createSupplier()
    {
        $this->resetSupplierFields();
        $this->isSupplierOpen = true;
    }

    public function editSupplier($id)
    {
        $supplier = Supplier::findOrFail($id);
        $this->supplier_id = $supplier->proveedor_id;
        $this->supplier_nombre = $supplier->nombre;
        $this->supplier_contacto = $supplier->contacto;
        $this->supplier_telefono = $supplier->telefono;
        $this->supplier_email = $supplier->email;
        $this->supplier_sitio_web = $supplier->sitio_web;
        $this->supplier_observacion = $supplier->observacion;

        $this->isSupplierOpen = true;
    }

    public function closeSupplierModal()
    {
        $this->isSupplierOpen = false;
        $this->resetSupplierFields();
    }

    private function resetSupplierFields()
    {
        $this->supplier_id = null;
        $this->supplier_nombre = '';
        $this->supplier_contacto = '';
        $this->supplier_telefono = '';
        $this->supplier_email = '';
        $this->supplier_sitio_web = '';
        $this->supplier_observacion = '';
    }

    public function storeSupplier()
    {
        $this->validate([
            'supplier_nombre' => 'required|min:3|max:100',
            'supplier_email' => 'nullable|email|max:100',
            'supplier_sitio_web' => 'nullable|url|max:255',
        ], [
            'supplier_nombre.required' => 'El nombre del proveedor es obligatorio.',
            'supplier_email.email' => 'El correo electrónico debe ser una dirección válida.',
            'supplier_sitio_web.url' => 'El sitio web debe ser una URL válida (con http:// o https://).'
        ]);

        Supplier::updateOrCreate(['proveedor_id' => $this->supplier_id], [
            'nombre' => $this->supplier_nombre,
            'contacto' => $this->supplier_contacto ?: null,
            'telefono' => $this->supplier_telefono ?: null,
            'email' => $this->supplier_email ?: null,
            'sitio_web' => $this->supplier_sitio_web ?: null,
            'observacion' => $this->supplier_observacion ?: null
        ]);

        session()->flash('message', $this->supplier_id ? 'Proveedor actualizado con éxito.' : 'Proveedor registrado con éxito.');
        $this->closeSupplierModal();
    }

    public function deleteSupplier($id)
    {
        Supplier::find($id)->delete();
        session()->flash('message', 'Proveedor eliminado con éxito.');
    }

    // --- POOL ACTIONS ---
    public function createPool()
    {
        $this->resetPoolFields();
        $this->pool_fecha_compra = date('Y-m-d');
        $this->isPoolOpen = true;
    }

    public function editPool($id)
    {
        $pool = Pool::findOrFail($id);
        $this->pool_id = $pool->pool_id;
        $this->pool_proveedor_id = $pool->proveedor_id;
        $this->pool_nombre = $pool->nombre;
        $this->pool_costo = $pool->costo;
        $this->pool_periodicidad = $pool->periodicidad;
        $this->pool_fecha_compra = $pool->fecha_compra;
        $this->pool_fecha_vencimiento = $pool->fecha_vencimiento;
        $this->pool_recurso_tipo = $pool->recurso_tipo;
        $this->pool_recurso_capacidad = $pool->recurso_capacidad;
        $this->pool_estado = $pool->estado;
        $this->pool_observacion = $pool->observacion;

        $this->isPoolOpen = true;
    }

    public function closePoolModal()
    {
        $this->isPoolOpen = false;
        $this->resetPoolFields();
    }

    private function resetPoolFields()
    {
        $this->pool_id = null;
        $this->pool_proveedor_id = '';
        $this->pool_nombre = '';
        $this->pool_costo = '';
        $this->pool_periodicidad = 'Mensual';
        $this->pool_fecha_compra = '';
        $this->pool_fecha_vencimiento = '';
        $this->pool_recurso_tipo = 'Almacenamiento (GB)';
        $this->pool_recurso_capacidad = '';
        $this->pool_estado = 'Activo';
        $this->pool_observacion = '';
    }

    public function storePool()
    {
        $this->validate([
            'pool_proveedor_id' => 'required|exists:proveedores,proveedor_id',
            'pool_nombre' => 'required|min:3|max:100',
            'pool_costo' => 'required|numeric|min:0',
            'pool_recurso_capacidad' => 'required|numeric|min:0',
            'pool_recurso_tipo' => 'required',
            'pool_estado' => 'required|in:Activo,Suspendido,Cancelado',
            'pool_fecha_compra' => 'nullable|date',
            'pool_fecha_vencimiento' => 'nullable|date'
        ], [
            'pool_proveedor_id.required' => 'Debe seleccionar un proveedor.',
            'pool_nombre.required' => 'El nombre del pool/servidor es obligatorio.',
            'pool_costo.required' => 'El costo de compra es obligatorio.',
            'pool_costo.numeric' => 'El costo debe ser un valor numérico.',
            'pool_recurso_capacidad.required' => 'La capacidad del recurso es obligatoria.',
            'pool_recurso_capacidad.numeric' => 'La capacidad debe ser un valor numérico.'
        ]);

        Pool::updateOrCreate(['pool_id' => $this->pool_id], [
            'proveedor_id' => $this->pool_proveedor_id,
            'nombre' => $this->pool_nombre,
            'costo' => $this->pool_costo,
            'periodicidad' => $this->pool_periodicidad ?: null,
            'fecha_compra' => $this->pool_fecha_compra ?: null,
            'fecha_vencimiento' => $this->pool_fecha_vencimiento ?: null,
            'recurso_tipo' => $this->pool_recurso_tipo ?: 'Almacenamiento (GB)',
            'recurso_capacidad' => $this->pool_recurso_capacidad,
            'estado' => $this->pool_estado ?: 'Activo',
            'observacion' => $this->pool_observacion ?: null
        ]);

        session()->flash('message', $this->pool_id ? 'Pool de recursos actualizado.' : 'Pool de recursos registrado con éxito.');
        $this->closePoolModal();
    }

    public function deletePool($id)
    {
        Pool::find($id)->delete();
        session()->flash('message', 'Pool de recursos eliminado con éxito.');
    }

    // --- VIEW POOL DETAIL ---
    public function viewPoolDetail($id)
    {
        $this->activePool = Pool::with('supplier', 'payments.client')->findOrFail($id);
        $this->isPoolDetailOpen = true;
    }

    public function closePoolDetailModal()
    {
        $this->isPoolDetailOpen = false;
        $this->activePool = null;
    }
}
