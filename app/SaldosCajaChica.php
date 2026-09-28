<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SaldosCajaChica extends Model
{
    protected $table = "saldos_caja_chica";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
        'id',
        'user_id',
        'saldo',
        'fecha_actualizacion',
    ];
}
