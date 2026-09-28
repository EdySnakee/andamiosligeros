<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ClientesRedes extends Model
{
    protected $table = "clientesredes";
    public $timestamps = false;
    protected $primaryKey = "id_cliente";
    protected $fillable = [
        'id_cliente',
        'id_proyecto',
        'nombre_cliente',
        'palabras_clave',
        'descripcion_pry',
        'latitud',
        'longitud',
        'contenido_html',
        'url_cliente',
        'imagenp',
		'fecha_alta'
    ];
}
