<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quote extends Model
{
    protected $table = 'presupuestos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'cliente_id', 'cliente_prospecto', 'fecha', 'moneda', 
        'total', 'estado', 'observacion', 'detalles'
    ];

    public function items()
    {
        return $this->hasMany(QuoteItem::class, 'presupuesto_id', 'id');
    }

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id', 'cliente_id');
    }
}
