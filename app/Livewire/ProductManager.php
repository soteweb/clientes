<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Product;
use Livewire\Attributes\Rule;

class ProductManager extends Component
{
    public $products, $product_id, $nombre, $descripcion, $periodicidad, $tipo, $costo, $precio, $proveedor;
    public $isOpen = false;
    public $isViewOpen = false;
    public $activeProduct = null;
    public $search = '';

    public function render()
    {
        $this->products = Product::where('nombre', 'like', '%'.$this->search.'%')
            ->orWhere('descripcion', 'like', '%'.$this->search.'%')
            ->orWhere('tipo', 'like', '%'.$this->search.'%')
            ->orderBy('id', 'desc')
            ->get();
                               
        return view('livewire.product-manager')
            ->layout('layouts.app', ['header' => 'Gestión de Productos']);
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
        $this->product_id = null;
        $this->nombre = '';
        $this->descripcion = '';
        $this->periodicidad = '';
        $this->tipo = 'Servicio';
        $this->costo = '';
        $this->precio = '';
        $this->proveedor = '';
    }

    public function store()
    {
        $this->validate([
            'nombre' => 'required',
            'precio' => 'required|numeric',
        ]);

        Product::updateOrCreate(['id' => $this->product_id], [
            'nombre' => $this->nombre,
            'descripcion' => $this->descripcion,
            'periodicidad' => $this->periodicidad ?: null,
            'tipo' => $this->tipo ?: 'Servicio',
            'costo' => $this->costo ?: null,
            'precio' => $this->precio,
            'proveedor' => $this->proveedor ?: null,
        ]);

        session()->flash('message', 
            $this->product_id ? 'Producto actualizado.' : 'Producto creado exitosamente.');

        $this->closeModal();
        $this->resetInputFields();
    }

    public function edit($id)
    {
        $product = Product::findOrFail($id);
        $this->product_id = $id;
        $this->nombre = $product->nombre;
        $this->descripcion = $product->descripcion;
        $this->periodicidad = $product->periodicidad;
        $this->tipo = $product->tipo ?: 'Servicio';
        $this->costo = $product->costo;
        $this->precio = $product->precio;
        $this->proveedor = $product->proveedor;
    
        $this->openModal();
    }

    public function delete($id)
    {
        if (auth()->user()->rol !== 'administrador') {
            session()->flash('error', 'No tienes autorización para eliminar productos.');
            return;
        }

        Product::find($id)->delete();
        session()->flash('message', 'Producto eliminado exitosamente.');
    }

    public function viewProduct($id)
    {
        $this->activeProduct = Product::findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->activeProduct = null;
    }
}
