<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoEntregaDetalle extends Model
{
    protected $table = 'formatos_entrega_detalle';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_formato_entrega',
        'id_det_cotizacion',
        'id_producto',
        'nombre_producto',
        'cantidad',
        'unidad',
    ];

    /**
     * Formato de entrega padre.
     */
    public function formatoEntrega()
    {
        return $this->belongsTo(FormatoEntrega::class, 'id_formato_entrega', 'id');
    }

    /**
     * Partida original de cotización (si aplica).
     */
    public function detalleCotizacion()
    {
        return $this->belongsTo(DetalleCotizaciones::class, 'id_det_cotizacion', 'id_det_cotizacion');
    }
}

