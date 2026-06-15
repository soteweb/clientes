<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clientes';
    protected $primaryKey = 'cliente_id';
    public $timestamps = false;

    protected $fillable = [
        'empresa', 'titular', 'ruc', 'telefono', 
        'email', 'direccion', 'ciudad', 'estado', 'observacion'
    ];

    public function payments()
    {
        return $this->hasMany(Payment::class, 'cliente_id', 'cliente_id');
    }

    public function quotes()
    {
        return $this->hasMany(Quote::class, 'cliente_id', 'cliente_id');
    }

    public function requirements()
    {
        return $this->hasMany(Requirement::class, 'cliente_id', 'cliente_id');
    }
}
