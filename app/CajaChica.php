<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CajaChica extends Model
{
    protected $table = "movimientos_caja_chica";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'user_id',
        'tipo_movimiento',
        'monto',
        'fecha',
        'descripcion',
        'comprobante'
    ];
}
