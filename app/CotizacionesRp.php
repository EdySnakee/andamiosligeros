<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CotizacionesRp extends Model
{
    protected $table = "cotizaciones";
    public $timestamps = false;
    protected $primaryKey = "id_cotizacion";
    protected $fillable = [
        'id_cotizacion',
        'giro_empresa',
        'id_cliente',
        'id_usuario_genera',
        'cod_cotizacion',
        'fecha',
        'fecha_formato',
        'hora',
        'porcentaje_descuento',
        'descuento_aplicado',
        'subtotal',
        'iva',
        'total',
        'status',
        'ruta_encrypt'
    ];
}
