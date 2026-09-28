<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrdenTaller extends Model
{
    protected $table = 'ordenes_taller';
    protected $primaryKey = 'id_orden_taller';
    
    protected $fillable = [
        'id_cotizacion',
        'estatus',
        'comentarios',
        'numero_guia',
        'enlace_guia',
        'impreso'
    ];

    public function notas()
    {
        return $this->hasMany(\App\OrdenTallerNota::class, 'id_orden_taller')->orderBy('created_at', 'DESC');
    }
}
