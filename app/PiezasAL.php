<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PiezasAL extends Model
{
    protected $table = "piezas_andamios";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'modelo_id',
        'nombre_pieza',
        'cantidad',
    ];
}
