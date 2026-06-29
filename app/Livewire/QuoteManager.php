<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Quote;
use App\Models\QuoteItem;
use App\Models\Client;
use App\Models\Product;
use Livewire\Attributes\Rule;
use Illuminate\Support\Facades\DB;

class QuoteManager extends Component
{
    public $quotes, $quote_id, $cliente_id, $cliente_prospecto, $fecha, $moneda = 'PYG', $total = 0, $estado = 'Pendiente', $observacion, $detalles;
    public $items = [];
    public $clients = [];
    public $products = [];
    public $isOpen = false;
    public $isViewOpen = false;
    public $selectedQuote = null;
    public $search = '';

    public function mount()
    {
        $this->clients = Client::where('estado', 'Activo')->orderBy('empresa')->get();
        $this->products = Product::orderBy('nombre')->get();
    }

    public function render()
    {
        $this->quotes = Quote::with('client')
            ->where('cliente_prospecto', 'like', '%'.$this->search.'%')
            ->orWhereHas('client', function($q) {
                $q->where('empresa', 'like', '%'.$this->search.'%')
                  ->orWhere('titular', 'like', '%'.$this->search.'%');
            })
            ->orderBy('id', 'desc')
            ->get();
                               
        return view('livewire.quote-manager')
            ->layout('layouts.app', ['header' => 'Gestión de Presupuestos']);
    }

    public function create()
    {
        $this->resetInputFields();
        $this->fecha = date('Y-m-d');
        $this->addItem(); // Start with one empty item
        $this->openModal();
    }

    public function addItem()
    {
        $this->items[] = [
            'producto_id' => '',
            'descripcion' => '',
            'cantidad' => 1,
            'precio_unitario' => 0,
            'subtotal' => 0
        ];
        $this->calculateTotal();
    }

    public function removeItem($index)
    {
        unset($this->items[$index]);
        $this->items = array_values($this->items);
        $this->calculateTotal();
    }

    public function updatedItems($value, $key)
    {
        $parts = explode('.', $key);
        $index = $parts[0];
        $field = $parts[1];

        if ($field === 'producto_id' && !empty($this->items[$index]['producto_id'])) {
            $prod = Product::find($this->items[$index]['producto_id']);
            if ($prod) {
                $this->items[$index]['descripcion'] = $prod->nombre . ($prod->descripcion ? ' - ' . $prod->descripcion : '');
                $this->items[$index]['precio_unitario'] = $prod->precio;
            }
        }

        if (in_array($field, ['cantidad', 'precio_unitario', 'producto_id'])) {
            $qty = (float)($this->items[$index]['cantidad'] ?? 0);
            $price = (float)($this->items[$index]['precio_unitario'] ?? 0);
            $this->items[$index]['subtotal'] = $qty * $price;
            $this->calculateTotal();
        }
    }

    public function calculateTotal()
    {
        $this->total = array_sum(array_column($this->items, 'subtotal'));
    }

    public function openModal()
    {
        $this->isOpen = true;
    }

    public function closeModal()
    {
        $this->isOpen = false;
    }

    public function openViewModal($id)
    {
        $this->selectedQuote = Quote::with(['client', 'items.product'])->findOrFail($id);
        $this->isViewOpen = true;
    }

    public function closeViewModal()
    {
        $this->isViewOpen = false;
        $this->selectedQuote = null;
    }

    private function resetInputFields()
    {
        $this->quote_id = null;
        $this->cliente_id = '';
        $this->cliente_prospecto = '';
        $this->fecha = '';
        $this->moneda = 'PYG';
        $this->total = 0;
        $this->estado = 'Pendiente';
        $this->observacion = '';
        $this->detalles = '';
        $this->items = [];
    }

    public function store()
    {
        $this->validate([
            'fecha' => 'required|date',
            'moneda' => 'required',
            'estado' => 'required',
            'items.*.descripcion' => 'required',
            'items.*.cantidad' => 'required|numeric|min:1',
            'items.*.precio_unitario' => 'required|numeric',
        ]);

        DB::beginTransaction();
        try {
            $quote = Quote::updateOrCreate(['id' => $this->quote_id], [
                'cliente_id' => !empty($this->cliente_id) ? $this->cliente_id : null,
                'cliente_prospecto' => $this->cliente_prospecto,
                'fecha' => $this->fecha,
                'moneda' => $this->moneda,
                'total' => $this->total,
                'estado' => $this->estado,
                'observacion' => $this->observacion,
                'detalles' => $this->detalles
            ]);

            // Delete old items if updating
            if ($this->quote_id) {
                QuoteItem::where('presupuesto_id', $this->quote_id)->delete();
            }

            foreach ($this->items as $item) {
                QuoteItem::create([
                    'presupuesto_id' => $quote->id,
                    'producto_id' => !empty($item['producto_id']) ? $item['producto_id'] : null,
                    'descripcion' => $item['descripcion'],
                    'cantidad' => $item['cantidad'],
                    'precio_unitario' => $item['precio_unitario'],
                    'subtotal' => $item['subtotal']
                ]);
            }

            DB::commit();
            session()->flash('message', $this->quote_id ? 'Presupuesto actualizado.' : 'Presupuesto creado exitosamente.');
            $this->closeModal();
            $this->resetInputFields();
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al guardar el presupuesto: ' . $e->getMessage());
        }
    }

    public function edit($id)
    {
        $quote = Quote::with('items')->findOrFail($id);
        $this->quote_id = $id;
        $this->cliente_id = $quote->cliente_id;
        $this->cliente_prospecto = $quote->cliente_prospecto;
        $this->fecha = $quote->fecha;
        $this->moneda = $quote->moneda ?: 'PYG';
        $this->total = $quote->total;
        $this->estado = $quote->estado ?: 'Pendiente';
        $this->observacion = $quote->observacion;
        $this->detalles = $quote->detalles;
    
        $this->items = [];
        foreach ($quote->items as $item) {
            $this->items[] = [
                'producto_id' => $item->producto_id ?: '',
                'descripcion' => $item->descripcion,
                'cantidad' => $item->cantidad,
                'precio_unitario' => $item->precio_unitario,
                'subtotal' => $item->subtotal
            ];
        }
        if(count($this->items) === 0) {
            $this->addItem();
        }

        $this->openModal();
    }

    public function delete($id)
    {
        if (auth()->user()->rol !== 'administrador') {
            session()->flash('error', 'No tienes autorización para eliminar presupuestos.');
            return;
        }

        DB::beginTransaction();
        try {
            QuoteItem::where('presupuesto_id', $id)->delete();
            Quote::find($id)->delete();
            DB::commit();
            session()->flash('message', 'Presupuesto eliminado exitosamente.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Error al eliminar el presupuesto: ' . $e->getMessage());
        }
    }
}
