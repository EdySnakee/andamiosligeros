<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TipoPago extends Model
{
    protected $table = "tipo_pago";
    public $timestamps = false;
    protected $primaryKey = "id";
    protected $fillable = [
    	'id',
    	'id_venta',
		'total',
		'tipo_pago',
        'metodo_pago',
		'id_ref',
		'status'
    ];

    public static function addTipoPago($info_pago, $datos_venta, $metodo_pago)
    {
        $datosTipoPago = new TipoPago();
        $datosTipoPago->id_venta = $datos_venta->id_venta;
        $datosTipoPago->total = $datos_venta->total;
        $datosTipoPago->tipo_pago = $info_pago['payment_type'];
        $datosTipoPago->metodo_pago = $metodo_pago;
        $datosTipoPago->id_ref = $info_pago['payment_id'];
        $datosTipoPago->status = $info_pago['status'];
        $datosTipoPago->save();
    }
}
