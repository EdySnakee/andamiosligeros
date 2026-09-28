<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTallerNota extends Model
{
    protected $table = 'ordenes_taller_notas';
    protected $primaryKey = 'id_nota_taller';
    
    protected $fillable = [
        'id_orden_taller',
        'id_usuario',
        'nota'
    ];

    public function user()
    {
        return $this->belongsTo(\App\User::class, 'id_usuario');
    }

    public function ordenTaller()
    {
        return $this->belongsTo(\App\OrdenTaller::class, 'id_orden_taller');
    }
}
