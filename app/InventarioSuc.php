<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InventarioSuc extends Model
{
    protected $table = "inventario_sucursal";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'sucursal_id',
        'producto_id',
        'tipo_producto',
        'cantidad',
        'fecha_actualizacion',
    ];
}
