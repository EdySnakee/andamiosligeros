<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleOrdenEmbarque extends Model
{
    protected $table = "detalles_orden_embarque";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'orden_id',
        'producto_id',
        'producto',
        'tipo_producto',
        'cantidad',
    ];
}
