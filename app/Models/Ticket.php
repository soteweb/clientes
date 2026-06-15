<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    protected $table = 'tickets';
    protected $primaryKey = 'ticket_id';
    public $timestamps = false; // Manejado por columnas fecha_creacion y fecha_actualizacion

    protected $fillable = [
        'codigo', 'cliente_id', 'solicitante_nombre', 
        'solicitante_telefono', 'solicitante_email', 
        'asunto', 'mensaje', 'archivo_path', 'archivo_nombre',
        'prioridad', 'estado', 'observaciones_admin', 
        'fecha_creacion', 'fecha_actualizacion'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id', 'cliente_id');
    }
}
