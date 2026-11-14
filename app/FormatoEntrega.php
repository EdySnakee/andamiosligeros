<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class FormatoEntrega extends Model
{
    protected $table = 'formatos_entrega';
    protected $primaryKey = 'id';
    public $timestamps = true;

    protected $fillable = [
        'id_cotizacion',
        'numero_entrega',
        'folio_entrega',
        'fecha',
        'fecha_formato',
        'cliente',
        'telefono',
        'folio_cotizacion',
        'vendedor',
        'observaciones',
        'id_usuario',
    ];

    /**
     * Partidas de productos incluidos en el formato de entrega.
     */
    public function detalles()
    {
        return $this->hasMany(FormatoEntregaDetalle::class, 'id_formato_entrega', 'id')->orderBy('id', 'asc');
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

