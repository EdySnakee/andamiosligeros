<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Municipios extends Model
{
    protected $table = "municipios";
    public $timestamps = false;
    protected $primaryKey = "idmunicipio";
    protected $fillable = [
        'idestado','municipio'
    ];

    public function estado()
    {
        return $this->belongsTo(Estados::class, 'idestado');
    }
}

