<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $table = 'proveedores';
    protected $primaryKey = 'proveedor_id';

    protected $fillable = [
        'nombre', 'contacto', 'telefono', 'email', 'sitio_web', 'observacion'
    ];

    public function pools()
    {
        return $this->hasMany(Pool::class, 'proveedor_id', 'proveedor_id');
    }
}
