<?php

namespace App\Livewire;

use Livewire\Component;

use App\Models\Client;
use App\Models\Payment;
use Carbon\Carbon;

class Dashboard extends Component
{
    public $desde;
    public $hasta;
    public $selected_client = '';

    public function mount()
    {
        $this->desde = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->hasta = Carbon::now()->endOfYear()->format('Y-m-d');
    }

    public function limpiar()
    {
        $this->desde = Carbon::now()->startOfYear()->format('Y-m-d');
        $this->hasta = Carbon::now()->endOfYear()->format('Y-m-d');
        $this->selected_client = '';
    }

    private function parseAmount($value)
    {
        if (empty($value)) return 0;
        // Si contiene letras como u$ o usd, solo extraer digitos
        // En Guaraníes los puntos son separadores de miles
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        return (float) $cleaned;
    }

    public function render()
    {
        $query = Payment::query();

        if ($this->desde) {
            $query->where('fecha', '>=', $this->desde);
        }
        if ($this->hasta) {
            $query->where('fecha', '<=', $this->hasta);
        }
        if ($this->selected_client) {
            $query->where('cliente_id', $this->selected_client);
        }

        $paymentsInRange = $query->get();
        $ingresosTotales = 0;
        foreach ($paymentsInRange as $p) {
            $ingresosTotales += $this->parseAmount($p->monto);
        }

        // Ingreso del Mes actual
        $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
        $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');
        $mesQuery = Payment::whereBetween('fecha', [$startOfMonth, $endOfMonth]);
        if ($this->selected_client) {
            $mesQuery->where('cliente_id', $this->selected_client);
        }
        $paymentsMonth = $mesQuery->get();
        $ingresoMes = 0;
        foreach ($paymentsMonth as $p) {
            $ingresoMes += $this->parseAmount($p->monto);
        }

        // Ingreso de Hoy
        $hoy = Carbon::now()->format('Y-m-d');
        $hoyQuery = Payment::where('fecha', $hoy);
        if ($this->selected_client) {
            $hoyQuery->where('cliente_id', $this->selected_client);
        }
        $paymentsHoy = $hoyQuery->get();
        $ingresoHoy = 0;
        foreach ($paymentsHoy as $p) {
            $ingresoHoy += $this->parseAmount($p->monto);
        }

        $clientesActivos = Client::where('estado', 'Activo')->count();

        // Próximos Vencimientos
        $vencimientosQuery = Payment::with('client')
            ->whereNotNull('fecha_proximo_pago')
            ->where('fecha_proximo_pago', '>=', Carbon::now()->subDays(30)->format('Y-m-d'))
            ->orderBy('fecha_proximo_pago', 'asc');

        if ($this->selected_client) {
            $vencimientosQuery->where('cliente_id', $this->selected_client);
        }

        $vencimientos = $vencimientosQuery->take(15)->get();
        $clientes = Client::orderBy('empresa')->get();

        return view('livewire.dashboard', [
            'ingresosTotales' => $ingresosTotales,
            'ingresoMes' => $ingresoMes,
            'ingresoHoy' => $ingresoHoy,
            'clientesActivos' => $clientesActivos,
            'vencimientos' => $vencimientos,
            'clientes' => $clientes,
        ])->layout('layouts.app', ['header' => 'Dashboard']);
    }
}
