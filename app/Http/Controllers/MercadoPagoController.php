<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Cotizaciones;
use App\Ventas;
use App\TipoPago;
use App\Utilidades;


class MercadoPagoController extends Controller
{
    public function showStatusMP(Request $info_order)
    {
        return view("app_redes/modulos/cotizador/ordenesmp/ordenes", compact('info_order'));
    }
    public function pagoTest(Request $request)
    {
        # LO QUE PONGA AQUÍ LO VOY A PONER EN WEBHOOKS CONTROLLER CUANDO ESTE EN PRODUCCION
        //dd($request->get('id_coti'));
        
        $payment_id = $request->get('payment_id');
        $info_pago = $request->all();
        //dd($payment_id);
        
        $ch = curl_init("https://api.mercadopago.com/v1/payments/{$payment_id}" . "?access_token=APP_USR-3586562848974707-101914-b6cedaf6e0bf2039ebba3a350ee6bcd3-1221009882");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);

        $datosCotizacion = new Cotizaciones();
        $infoCotizacion = $datosCotizacion->find($request->id_coti);
        
        $fecha = Utilidades::fecha();
        
        if ($response->status == "approved") {
            
            $usuario = "MP";
            $status = 3; // STATUS 3 ES VENTA
            $metodo_pago = "Mercado Pago";

            //ACTUALIZA TABLA COTIZACIONES
            $return_formato_cod_vta =  Cotizaciones::confirmaVende($request, $infoCotizacion, $fecha, $status);
            //GUARDA DATOS EN TABLA VENTAS
            $return_datos_venta = Ventas::guardaVenta($request, $infoCotizacion, $fecha, $status,$return_formato_cod_vta, $usuario);
            //GUARDA DATOS EN TABLA TIPO PAGO
            $return_tipo_pago =  TipoPago::addTipoPago($info_pago, $return_datos_venta, $metodo_pago);
        }
        
        
       
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "ra") {
            return redirect()->route('web_ventas_redes', $return_datos_venta->ruta_encrypt);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "rp") {
            return redirect()->route('web_ventas_redes_p', $return_datos_venta->ruta_encrypt);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "sg") {
            return redirect()->route('web_ventas_scoregol', $return_datos_venta->ruta_encrypt);
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "al") {
            return redirect()->route('web_ventas_ligeros', $return_datos_venta->ruta_encrypt);
        }
        
    }
}
