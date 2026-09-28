<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MovimientoInv extends Model
{
    protected $table = "movimientos_inventario";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'sucursal_origen_id',
        'sucursal_destino_id',
        'producto_id',
        'tipo_producto',
        'tipo_movimiento',
        'cantidad',
        'fecha_movimiento',
        'paqueteria',
        'num_guia',
        'comentarios'
    ];
}
