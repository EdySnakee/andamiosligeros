<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Ventas extends Model
{
    protected $table = "ventas";
    public $timestamps = false;
    protected $primaryKey = "id_venta";
    protected $fillable = [
    	'id_venta',
    	'id_cotizacion',
		'giro_empresa',
		'id_cliente',
		'id_usuario_genera',
		'cod_venta',
		'fecha_venta',
		'fecha_venta_formato',
		'hora_venta',
		'porcentaje_descuento',
		'descuento_aplicado',
		'subtotal',
		'iva',
		'total',
		'envio',
		'envio_2',
		'envio_paqueteria',
		'paqueteria',
		'fecha_envio_paqueteria',
		'envio_paqueteria_2',
		'paqueteria_2',
		'fecha_envio_paqueteria_2',
		'origen',
		'origen_2',
		'destino',
		'destino_2',
		'status',
		'qr_status',
		'ruta_encrypt'
    ];

	public static function guardaVenta($data_post, $infoCotizacion, $fecha, $status, $return_formato_cod_vta, $usuario){
		$datosVenta = new Ventas();
		$datosVenta->id_cotizacion = $data_post->id_coti;
		$datosVenta->giro_empresa = $infoCotizacion->giro_empresa;
		$datosVenta->id_cliente = $infoCotizacion->id_cliente;
		$datosVenta->id_usuario_genera = $usuario;
		$datosVenta->cod_venta = $return_formato_cod_vta;
		$datosVenta->fecha_venta = date('Y-m-d');
		$datosVenta->fecha_venta_formato = $fecha;
		$datosVenta->hora_venta = date('H:i:s');
		$datosVenta->porcentaje_descuento = $infoCotizacion->descuento;
		$datosVenta->descuento_aplicado = $infoCotizacion->descuento_aplicado;
		$datosVenta->subtotal = $infoCotizacion->subtotal;
		$datosVenta->iva = $infoCotizacion->iva;
		$datosVenta->envio = $infoCotizacion->envio;
		$datosVenta->total = $infoCotizacion->total;
		$datosVenta->status = $status;
		$datosVenta->save();
		$guarda_datos_adicionales = $datosVenta->find($datosVenta->id_venta);
		$guarda_datos_adicionales->ruta_encrypt = md5($datosVenta->id_venta);
		$guarda_datos_adicionales->save();

		$qrimage = public_path().'/storage/qrs_ventas/'.$datosVenta->id_venta.'.png';
		
		
		if ($datosVenta->giro_empresa == "ra") {
			$ruta_cotizacion = "redes-anticaidas/".$guarda_datos_adicionales->ruta_encrypt;
			\QRCode::url(url('ventas/redes-anticaidas/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
		}
		if ($datosVenta->giro_empresa == "rp") {
			$ruta_cotizacion = "redes-perimetrales/".$guarda_datos_adicionales->ruta_encrypt;
			\QRCode::url(url('ventas/redes-perimetrales/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
		}
		if ($datosVenta->giro_empresa == "sg") {
			$ruta_cotizacion = "score-gol/".$guarda_datos_adicionales->ruta_encrypt;
			\QRCode::url(url('ventas/score-gol/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
		}
		if ($datosVenta->giro_empresa == "al") {
			$ruta_cotizacion = "andamios-ligeros/".$guarda_datos_adicionales->ruta_encrypt;
			\QRCode::url(url('ventas/andamios-ligeros/')."/".$guarda_datos_adicionales->ruta_encrypt)->setOutfile($qrimage)->png();
		}

		$guarda_qr_status = $datosVenta->find($datosVenta->id_venta);
		$guarda_qr_status->qr_status = 1;
		$guarda_qr_status->save();

		return $guarda_datos_adicionales;
	}
}
