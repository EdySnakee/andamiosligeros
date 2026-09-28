<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class GaleriaClientes extends Model
{
    protected $table = "galeria_clientes";
    public $timestamps = false;
    protected $primaryKey = "id_imagen";
    protected $fillable = [
        'id_imagen',
        'id_cliente',
        'id_proyecto',
		'img_galeria'
    ];
}
