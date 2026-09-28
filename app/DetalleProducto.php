<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleProducto extends Model
{
    protected $table = "detalle_producto";
    public $timestamps = false;
    protected $primaryKey = "id_det_product";
    protected $fillable = [
        'id_det_product',
        'id_producto',
        'SKU',
        'descripcion_producto',
        'caracteristicas_producto',
		'extra_info_producto',
		'imagen',
        'banner'
    ];
}
