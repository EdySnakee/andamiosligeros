<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Condiciones extends Model
{
    protected $table = "config_cotizacion";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'tipo',
        'contenido',
    ];
}