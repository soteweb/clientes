<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'productos';
    protected $primaryKey = 'id';
    public $timestamps = false;

    protected $fillable = [
        'nombre', 'descripcion', 'periodicidad', 'tipo', 
        'costo', 'precio', 'proveedor'
    ];
}
