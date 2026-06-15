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
}
