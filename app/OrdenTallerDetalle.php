<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTallerDetalle extends Model
{
    protected $table = 'ordenes_taller_detalle';
    protected $primaryKey = 'id_orden_detalle';
    
    protected $fillable = [
        'id_orden_taller',
        'id_det_cotizacion',
        'cantidad_terminada'
    ];
}
