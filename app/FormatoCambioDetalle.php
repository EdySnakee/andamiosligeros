<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoCambioDetalle extends Model
{
    const TIPO_ENTREGADO = 'entregado';
    const TIPO_SUSTITUCION = 'sustitucion';

    protected $table = 'formatos_cambio_detalle';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_formato_cambio',
        'tipo_partida',
        'id_producto',
        'nombre_producto',
        'cantidad',
        'precio_unitario',
        'importe',
        'estado_observaciones',
    ];

    /**
     * Formato de cambio padre.
     */
    public function formatoCambio()
    {
        return $this->belongsTo(FormatoCambio::class, 'id_formato_cambio', 'id');
    }
}

