<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ModeloAndamio extends Model
{
    protected $table = "modelos_andamios";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nombre',
        'descripcion',
        'costo',
        'fecha_actualizacion',
    ];
}
