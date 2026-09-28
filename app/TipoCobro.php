<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoCobro extends Model
{
    protected $table = "cat_tipoCobro";
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'cat_tipo_cobro',
        'nombre',
        'descripcion',
        'status',
    ];
}