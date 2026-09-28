<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sucursales extends Model
{
    protected $table = "sucursales";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nombre',
        'ubicacion',
        'responsable',
        'fecha_registro',
    ];
}
