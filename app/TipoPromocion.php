<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPromocion extends Model
{
    //
    protected $table = "tipos_promos";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'nombre',
        'etiqueta',
        'status'
    ];
}
