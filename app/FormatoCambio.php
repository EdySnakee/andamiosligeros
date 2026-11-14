<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoCambio extends Model
{
    protected $table = 'formatos_cambio';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_cotizacion',
        'folio_cambio',
        'fecha',
        'fecha_formato',
        'cliente',
        'telefono',
        'cotizacion_factura',
        'vendedor',
        'forma_pago',
        'fecha_pago',
        'total_reconocido',
        'total_sustitucion',
        'diferencia_pagar',
        'observaciones',
        'id_usuario',
    ];

    /**
     * Todas las partidas asociadas al formato de cambio.
     */
    public function detalles()
    {
        return $this->hasMany(FormatoCambioDetalle::class, 'id_formato_cambio', 'id')->orderBy('id', 'asc');
    }

    /**
     * Partidas de producto que entrega / cambia el cliente.
     */
    public function detallesEntregados()
    {
        return $this->hasMany(FormatoCambioDetalle::class, 'id_formato_cambio', 'id')
            ->where('tipo_partida', FormatoCambioDetalle::TIPO_ENTREGADO)
            ->orderBy('id', 'asc');
    }

    /**
     * Partidas de producto nuevo / sustitución.
     */
    public function detallesSustitucion()
    {
        return $this->hasMany(FormatoCambioDetalle::class, 'id_formato_cambio', 'id')
            ->where('tipo_partida', FormatoCambioDetalle::TIPO_SUSTITUCION)
            ->orderBy('id', 'asc');
    }

    /**
     * Cotización asociada (opcional).
     */
    public function cotizacion()
    {
        return $this->belongsTo(Cotizaciones::class, 'id_cotizacion', 'id_cotizacion');
    }

    /**
     * Usuario del sistema que registró el formato.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'id_usuario', 'id');
    }
}

