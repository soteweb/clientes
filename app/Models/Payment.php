<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'pagos';
    protected $primaryKey = 'pago_id';
    public $timestamps = false;

    protected $fillable = [
        'fecha', 'cliente_id', 'servicio', 'monto', 
        'periodicidad', 'fecha_proximo_pago', 'observacion', 'estado',
        'pool_id', 'porcion_recurso'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id', 'cliente_id');
    }

    public function pool()
    {
        return $this->belongsTo(Pool::class, 'pool_id', 'pool_id');
    }

    public static function formatMonto($value)
    {
        if (empty($value)) {
            return '0';
        }

        // If it only contains digits, dots, commas, or spaces
        if (preg_match('/^[0-9.,\s]+$/', $value)) {
            $cleaned = preg_replace('/[^0-9]/', '', $value);
            if ($cleaned === '') {
                return $value;
            }
            return number_format((float) $cleaned, 0, ',', '.');
        }

        return $value;
    }

    public function getMontoFormateadoAttribute()
    {
        return self::formatMonto($this->monto);
    }
}
