<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Pool extends Model
{
    protected $table = 'pools';
    protected $primaryKey = 'pool_id';

    protected $fillable = [
        'proveedor_id', 'nombre', 'costo', 'periodicidad', 
        'fecha_compra', 'fecha_vencimiento', 'recurso_tipo', 
        'recurso_capacidad', 'estado', 'observacion'
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class, 'proveedor_id', 'proveedor_id');
    }

    public function payments()
    {
        return $this->hasMany(Payment::class, 'pool_id', 'pool_id');
    }

    /**
     * Calcular capacidad actualmente asignada/ocupada por los sub-servicios de clientes
     */
    public function getRecursoAsignadoAttribute()
    {
        return $this->payments()->sum('porcion_recurso');
    }

    /**
     * Calcular capacidad disponible
     */
    public function getRecursoDisponibleAttribute()
    {
        return max(0, $this->recurso_capacidad - $this->recurso_asignado);
    }

    /**
     * Calcular porcentaje ocupado de los recursos
     */
    public function getPorcentajeOcupadoAttribute()
    {
        if ($this->recurso_capacidad <= 0) {
            return 0;
        }
        return min(100, round(($this->recurso_asignado / $this->recurso_capacidad) * 100));
    }

    /**
     * Calcular ingresos totales generados por los sub-servicios vinculados
     */
    public function getIngresosTotalesAttribute()
    {
        // Sumar montos numéricos de pagos que no sean nulos
        return $this->payments()
            ->whereIn('estado', ['Pagado', 'Pendiente'])
            ->get()
            ->sum(function ($payment) {
                return is_numeric($payment->monto) ? (float)$payment->monto : 0;
            });
    }

    /**
     * Determinar si el Pool es rentable (Ingresos > Costo)
     */
    public function getEsRentableAttribute()
    {
        return $this->ingresos_totales >= $this->costo;
    }
}
