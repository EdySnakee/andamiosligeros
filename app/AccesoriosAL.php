<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class AccesoriosAL extends Model
{
    protected $table = "accesorios_andamios";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'fecha_actualizacion',
    ];
}
