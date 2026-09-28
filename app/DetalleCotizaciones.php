<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DetalleCotizaciones extends Model
{
    protected $table = "detalle_cotizaciones";
    public $timestamps = false;
    protected $primaryKey = "id_det_cotizacion";
    protected $fillable = [
        'id_det_cotizacion',
        'id_cotizacion',
        'id_producto',
        'cantidad',
        'nombre_producto',
        'largo',
        'alto',
        'precio_unit',
        'dimensiones',
        'tipo_cobro',
        'total_ind',
        'titulo_descripcion',
        'estatus'
    ];
}
