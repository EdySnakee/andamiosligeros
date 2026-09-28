<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeguimientoTrabajo extends Model
{
    protected $table = "seguimiento_trabajo";
    public $timestamps = false;
    protected $primaryKey = "id_seguimiento";
    protected $fillable = [
        'id_seguimiento',
        'id_cotizacion',
        'cod_venta',
        'titulo_trabajo	',
        'fecha_elaboracion',
		'personal_labora',
		'comentario',
		'estatus'
    ];
}
