<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class QuoteItem extends Model
{
    protected $table = 'presupuesto_items';
    protected $primaryKey = 'item_id';
    public $timestamps = false;

    protected $fillable = [
        'presupuesto_id', 'producto_id', 'descripcion', 
        'cantidad', 'precio_unitario', 'subtotal'
    ];

    public function quote()
    {
        return $this->belongsTo(Quote::class, 'presupuesto_id', 'id');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'producto_id', 'id');
    }
}
