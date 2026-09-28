<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ProyectosRedes extends Model
{
    protected $table = "proyectos_redes";
    public $timestamps = false;
    protected $primaryKey = "id_proyecto";
    protected $fillable = [
        'id_proyecto',
        'nombre_proyecto',
        'id_estado',
        'url_proyecto',
        'palabras_clave',
		'descripcion',
		'img_portada'
    ];
}
