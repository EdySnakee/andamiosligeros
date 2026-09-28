<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProductosTiendaDetalle extends Model
{
    protected $table = "productos_tienda_detalle";
    public $timestamps = false;
    protected $primaryKey = "id_det_product";
    protected $fillable = [
        'id_det_product',
        'id_product',
        'descripcion_producto',
        'caracteristicas_producto',
        'extra_info_producto',
        'alto',
        'ancho',
        'profundidad',
        'diametro',
        'peso_soportado',
        'multiuso',
        'imagen_portada',
        'imagen_alt',
        'qr_enlace',
        'ar_enlace'
    ];
}
