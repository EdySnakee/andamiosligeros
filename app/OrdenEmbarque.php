<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenEmbarque extends Model
{
    protected $table = "ordenes_embarque";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'fecha',
        'id_destino',
        'destino',
        'id_origen',
        'origen',
        'total_piezas',
        'conducto',
        'respondable',
        'estado',
    ];
}
