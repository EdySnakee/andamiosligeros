<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SeguimientoBitacora extends Model
{
    protected $table = "seguimiento_bitacora";
    public $timestamps = false;
    protected $primaryKey = "id_bitracora";
    protected $fillable = [
        'id_bitracora',
        'id_seguimiento',
        'archivo',
        'tipo_archivo',
        'comentario	',
        'estatus'
    ];
}
