<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Blog extends Model
{
    protected $table = "blog";
    public $timestamps = false;
    protected $primaryKey = "id_blog";
    protected $fillable = [
        'id_blog',
        'post_autor',
        'post_fecha',
        'post_hora',
        'post_contenido',
        'post_titulo',
        'post_estatus',
        'coment_estatus',
        'post_url',
        'palabras_clave',
        'meta_descripcion',
        'post_fecha_modificado',
		'post_hora_modificado',
        'img_portada'
    ];
}
