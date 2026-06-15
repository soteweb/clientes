<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Requirement extends Model
{
    protected $table = 'requerimientos';

    protected $fillable = [
        'cliente_id', 'prospecto_nombre', 'prospecto_contacto', 'prospecto_email',
        'titulo', 'descripcion', 'prioridad', 'estado', 'fecha_solicitud',
        'fecha_limite', 'estimacion_horas', 'presupuesto_estimado', 'observaciones'
    ];

    public function client()
    {
        return $this->belongsTo(Client::class, 'cliente_id', 'cliente_id');
    }

    // Accessor para obtener el color HSL/Tailwind de la prioridad
    public function getPrioridadBadgeColorAttribute()
    {
        switch ($this->prioridad) {
            case 'Urgente':
                return 'bg-red-100 text-red-800 border-red-200';
            case 'Alta':
                return 'bg-amber-100 text-amber-800 border-amber-200';
            case 'Baja':
                return 'bg-slate-100 text-slate-700 border-slate-200';
            case 'Media':
            default:
                return 'bg-blue-100 text-blue-800 border-blue-200';
        }
    }

    // Accessor para obtener el color HSL/Tailwind del estado
    public function getEstadoBadgeColorAttribute()
    {
        switch ($this->estado) {
            case 'Evaluando':
                return 'bg-indigo-100 text-indigo-800 border-indigo-200';
            case 'Presupuestado':
                return 'bg-cyan-100 text-cyan-800 border-cyan-200';
            case 'Aprobado':
                return 'bg-emerald-100 text-emerald-800 border-emerald-200';
            case 'En Desarrollo':
                return 'bg-purple-100 text-purple-800 border-purple-200';
            case 'Completado':
                return 'bg-green-100 text-green-800 border-green-200';
            case 'Cancelado':
                return 'bg-rose-100 text-rose-800 border-rose-200';
            case 'Pendiente':
            default:
                return 'bg-slate-100 text-slate-700 border-slate-200';
        }
    }
}
