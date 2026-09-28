<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Empresas extends Model
{
    protected $table = "empresas";
    public $timestamps = false;
    protected $primaryKey = "id_empresa";
    protected $fillable = [
        'id_empresa',
        'nombre_empresa',
        'razon_social',
        'rfc	',
        'estatus'
    ];
}
