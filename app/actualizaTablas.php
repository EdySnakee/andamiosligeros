<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class actualizaTablas extends Model
{
    protected $table = "actualiza_tablas";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'accion',
        'tipo_act',
        'tabla',
        'num_reg',
        'usuario',
        'fecha_act',
        'hora_act'
    ];
}
