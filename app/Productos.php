<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Productos extends Model
{
    protected $table = "productos";
    public $timestamps = false;
    protected $primaryKey = "id_producto";
    protected $fillable = [
        'id_producto',
        'SKU',
        'giro_producto',
        'nombre_p',
        'tipo_cobro',
		'precio',
		'status_p',
        'clave_prod_serv',
        'clave_unidad',
        'unidad'
    ];
}
