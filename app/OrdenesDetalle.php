<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenesDetalle extends Model
{
    protected $table = "ordenes_detalle";
    public $timestamps = false;
    protected $primaryKey = "id_det_orden";
    protected $fillable = [
        'id_det_orden',
        'id_orden',
        'cantidad',
        'nombre_producto',
        'precio_unit',
        'total_ind',
        'estatus'
    ];

    public static function postDetalleOrden($datos_orden, $productos)
    {
        
        foreach ($productos as $key_detalle_orden => $item_det_orden) {
            $postOrdenesDetalle = new OrdenesDetalle();
            $postOrdenesDetalle->id_orden = $datos_orden->id_orden;
            $postOrdenesDetalle->cantidad = $item_det_orden['cantidad'];
            $postOrdenesDetalle->nombre_producto = $item_det_orden['titulo'];
            $postOrdenesDetalle->precio_unit = $item_det_orden['precio'];
            $postOrdenesDetalle->total_ind = $item_det_orden['cantidad']*$item_det_orden['precio'];
            $postOrdenesDetalle->estatus = 1;
            $postOrdenesDetalle->save();
        }

    }

}
