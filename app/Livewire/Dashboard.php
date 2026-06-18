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
    public $monthlyData = [];
    public $periodicitySums = [];

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

    public function exportCSV()
    {
        $query = Payment::query()->with('client');

        if ($this->desde) {
            $query->where('fecha', '>=', $this->desde);
        }
        if ($this->hasta) {
            $query->where('fecha', '<=', $this->hasta);
        }
        if ($this->selected_client) {
            $query->where('cliente_id', $this->selected_client);
        }

        $payments = $query->get();

        $headers = [
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=reporte_cobros_" . date('Ymd_His') . ".csv",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        ];

        $callback = function() use($payments) {
            $file = fopen('php://output', 'w');
            
            // Add UTF-8 BOM for Excel compatibility
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, ['ID Pago', 'Fecha', 'Cliente', 'Servicio', 'Monto', 'Periodicidad', 'Próximo Vencimiento', 'Estado', 'Observación']);

            foreach ($payments as $p) {
                fputcsv($file, [
                    $p->pago_id,
                    $p->fecha,
                    $p->client ? ($p->client->empresa ?: $p->client->titular) : 'N/A',
                    $p->servicio,
                    $p->monto,
                    $p->periodicidad ?: 'Único',
                    $p->fecha_proximo_pago ?: '-',
                    $p->estado ?: 'Pagado',
                    $p->observacion ?: ''
                ]);
            }

            fclose($file);
        };

        return response()->streamDownload($callback, "reporte_cobros_" . date('Ymd_His') . ".csv", $headers);
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

        // Ticket promedio
        $paymentCount = $paymentsInRange->count();
        $ticketPromedio = $paymentCount > 0 ? ($ingresosTotales / $paymentCount) : 0;

        // Distribución por periodicidad (para gráfico de torta)
        $periodicitySums = ['Mensual' => 0, 'Anual' => 0, 'Único' => 0];
        foreach ($paymentsInRange as $p) {
            $per = $p->periodicidad ?: 'Único';
            if (isset($periodicitySums[$per])) {
                $periodicitySums[$per] += $this->parseAmount($p->monto);
            } else {
                $periodicitySums['Único'] += $this->parseAmount($p->monto);
            }
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

        // Proyecciones de cobranzas para los próximos 30 días
        $todayStr = Carbon::now()->format('Y-m-d');
        $in30DaysStr = Carbon::now()->addDays(30)->format('Y-m-d');
        $upcomingPayments = Payment::whereBetween('fecha_proximo_pago', [$todayStr, $in30DaysStr])->get();
        $proyeccionRenovaciones = 0;
        foreach ($upcomingPayments as $p) {
            $proyeccionRenovaciones += $this->parseAmount($p->monto);
        }

        // Tendencia mensual del año actual (Jan-Dec) para el gráfico de barras
        $añoActual = Carbon::now()->format('Y');
        $monthlySums = array_fill(1, 12, 0);
        $monthlyQuery = Payment::whereYear('fecha', $añoActual);
        if ($this->selected_client) {
            $monthlyQuery->where('cliente_id', $this->selected_client);
        }
        $monthlyPayments = $monthlyQuery->get();
        foreach ($monthlyPayments as $p) {
            $month = (int) Carbon::parse($p->fecha)->format('m');
            $monthlySums[$month] += $this->parseAmount($p->monto);
        }
        $this->monthlyData = array_values($monthlySums);
        $this->periodicitySums = $periodicitySums;

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
            'ticketPromedio' => $ticketPromedio,
            'clientesActivos' => $clientesActivos,
            'proyeccionRenovaciones' => $proyeccionRenovaciones,
            'vencimientos' => $vencimientos,
            'clientes' => $clientes,
        ])->layout('layouts.app', ['header' => 'Dashboard']);
    }
}

