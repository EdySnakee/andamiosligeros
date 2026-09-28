<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use PHPMailer\PHPMailer;
use App\Utilidades;

class OrdenesWeb extends Model
{
    //
    protected $table = "ordenes";
    public $timestamps = false;
    protected $primaryKey = "id_orden";
    protected $fillable = [
        'id_orden',
        'idcl',
        'req_fact',
        'cantidad',
        'costo_articulo',
        'iva',
        'subtotal',
        'total',
        'status_accion',
        'mp_payment_id',
        'mp_payment_type',
        'mp_status',
        'mp_fecha_post',
        'fecha_post',
        'status_orden'
    ];

    public static function postOrden($req_mp, $data_post, $datos_cliente, $subtotal_orden, $costo_item, $status_accion, $status_orden)
    {
        //dd($datos_cliente->idcl);
        $iva = $subtotal_orden * 0.16;

        $ordenesWeb = new OrdenesWeb();
        $ordenesWeb->idcl = $datos_cliente->idcl;
        $ordenesWeb->req_fact = $data_post->iva;
        $ordenesWeb->cantidad = $data_post->cantidad;
        $ordenesWeb->costo_articulo = $data_post->costo_articulo;
        $ordenesWeb->iva = $iva;
        $ordenesWeb->subtotal = $subtotal_orden;
        $ordenesWeb->total = $subtotal_orden + $iva;
        $ordenesWeb->status_accion = $status_accion;
        if ($status_orden == 1) {
            $ordenesWeb->mp_payment_id = $req_mp->payment_id;
            $ordenesWeb->mp_payment_type = $req_mp->payment_type;
            $ordenesWeb->mp_status = $req_mp->status;
        }
        $ordenesWeb->fecha_post = date("Y-m-d H:i:s");
        $ordenesWeb->status_orden = $status_orden;
        $ordenesWeb->save();

        return $ordenesWeb;
    }
    public static function ordenesTienda($datos_cliente, $num_articulos, $total, $iva, $gran_total, $data_post, $status_orden, $status_accion)
    {
        //dd($datos_cliente);
        $ordenesWeb = new OrdenesWeb();
        $ordenesWeb->idcl = $datos_cliente->idcl;
        $ordenesWeb->req_fact = (!empty($datos_cliente->iva)) ? $datos_cliente->iva : "no";
        $ordenesWeb->cantidad = $num_articulos;
        $ordenesWeb->costo_articulo = $total;
        $ordenesWeb->subtotal = $total;
        $ordenesWeb->iva = $iva;
        $ordenesWeb->total = $gran_total;
        $ordenesWeb->status_accion = $status_accion;
        // Estos campos se llenarán DESPUÉS por el webhook.
        // Al crear la orden, deben estar vacíos o nulos.
        $ordenesWeb->mp_payment_id = '';
        $ordenesWeb->mp_payment_type = '';
        $ordenesWeb->mp_status = ''; // O 'pending' si prefieres
        $ordenesWeb->mp_fecha_post = date("Y-m-d H:i:s");
        $ordenesWeb->status_orden = $status_orden;
        $ordenesWeb->save();

        return $ordenesWeb;
    }
    public static function enviaOrdenMail($datos_cliente, $datos_orden, $cart)
    {
        $mail = new PHPMailer\PHPMailer();
        $enviaMail = new Utilidades();

        $titulo2 = "Confirmacíon de orden de compra " . $datos_orden->id_orden;
        // 1. Prepara las filas de productos para la tabla
        $productos_html = '';
        foreach ($cart as $item) {
            $productos_html .= '
                <tr>
                    <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px;">' . $item->cantidad . ' x ' . $item->nombre_producto . '</td>
                    <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px; text-align: right;">$' . number_format($item->total_ind, 2) . '</td>
                </tr>';
        }

        // 2. Prepara las filas de totales
        $totales_html = '
            <tr>
                <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px; text-align: right; border-top: 1px solid #eeeeee;">Subtotal</td>
                <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px; text-align: right; border-top: 1px solid #eeeeee;">$' . number_format($datos_orden->subtotal, 2) . '</td>
            </tr>
            <tr>
                <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px; text-align: right;">IVA</td>
                <td style="font-family: Arial, sans-serif; font-size: 14px; padding: 5px 10px; text-align: right;">$' . number_format($datos_orden->iva, 2) . '</td>
            </tr>
            <tr>
                <td style="font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; padding: 10px 10px; text-align: right; background-color: #f7f7f7;">TOTAL</td>
                <td style="font-family: Arial, sans-serif; font-size: 16px; font-weight: bold; padding: 10px 10px; text-align: right; background-color: #f7f7f7;">$' . number_format($datos_orden->total, 2) . '</td>
            </tr>
        ';
        $mensaje = '
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<title>Confirmacíon de orden de compra</title>
<meta name="viewport" content="width=device-width, initial-scale=1.0"/>
</head>
<body style="margin: 0; padding: 0; ">
<table border="0" cellpadding="0" cellspacing="0" width="100%"> 
<tr>
<td style="padding: 10px 0 30px 0;">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse; position: relative;">
<tr>
<td align="center" bgcolor="#fff" style="padding: 10px 30px; color: #043d8a; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; text-align: left;">
<img width="100px" src="https://andamiosligeros.com/web/img/logo-andamios-merida.png">
</td>
</tr>
<tr>
<td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
<b><p>¡Hola, ' . $datos_cliente->nombrecl . ', gracias por confiar en nosotros!</p></b>
</td>
</tr>
<tr>
<td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
<p style="text-align: justify;">Hemos recibido tu orden de compra con el número: <b>' . $datos_orden->id_orden . '<b>, con el le podrás dar seguimiento con nuestros asesores de venta.</p>

                                               <h4 style="font-family: Arial, sans-serif; margin-top: 30px;">Resumen de tu Orden (No. ' . $datos_orden->id_orden . ')</h4>
                                               <table width="100%" border="0" cellpadding="0" cellspacing="0" style="border: 1px solid #cccccc; border-collapse: collapse; margin-bottom: 20px;">
                                                   <thead>
                                                       <tr>
                                                           <th style="font-family: Arial, sans-serif; font-size: 14px; padding: 10px; background-color: #f7f7f7; text-align: left;">Producto (Cantidad x)</th>
                                                           <th style="font-family: Arial, sans-serif; font-size: 14px; padding: 10px; background-color: #f7f7f7; text-align: right;">Total</th>
                                                       </tr>
                                                   </thead>
                                                   <tbody>
                                                       ' . $productos_html . '
                                                       ' . $totales_html . '
                                                   </tbody>
                                               </table>
<p style="text-align: justify;">Contáctanos para darle seguimiento a tu orden de compra:</p>
<p style="text-align: justify;"> <a href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20Soy%20' . $datos_cliente->nombrecl . '%20y%20quiero%20realizar%20el%20seguimiento%20de%20mi%20compra%20con%20el%20número%20de%20Orden:' . $datos_orden->id_orden . '" target="_blank">Click aquí para dar seguimiento 👈</a> </p>
 <p style="text-align: justify;"><small><b>* Tiempo de entrega a convenir. *Envío gratuito solo aplica para tránsito terrestre</b></small></p>

 <p style="text-align: justify;">Es importante que este enterado que cuenta con la confidencialidad de sus datos proporcionados, los cuales serán utilizados única y exclusivamente para poder darle información sobre nuestros productos y posibles futuras promociones.</p>
<p style="text-align: justify;">Si quisiera brindarnos alguna información posterior o su cotización no puede esperar, también puede comunicarse sin compromiso con alguno de nuestros asesores marcando al 999 646 1314.</p>
<p>Saludos cordiales</p>
</td>
</tr>
<tr>
<td>
<h3 style="font-family: Arial, sans-serif;">NUESTROS CLIENTES:</h3>
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-3M.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Abitat.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-AKRA.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Anahuac-Organizacion-Constructora.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-AUDI.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Autopistas-Michoacan.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-CEMEX.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-CIMESA.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Constructora-Anglo.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Constructora-CHUFANI.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Freyssinet.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-FUJITA.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/CLiente-GIM.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Grupo-Copri.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Grupo-DAGS.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Grupo-R.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Hazama.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-ICA.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Kepler.png" alt="">
<img width="50px" src="https://andamiosligeros.com/web/img/clientes/Cliente-Lackma-Constructora.png" alt="">
</td>
</tr>
</table>
</td>
</tr>
<tr>
<td bgcolor="#ffbb01" style="padding: 30px 30px 30px 30px;">
<table border="0" cellpadding="0" cellspacing="0" width="100%">
<tr>
<td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" width="50%">
&reg; Copyright © 2022 andamiosligeros.com<web/img/>
                                            </td>
                                            <td align="right" style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" width="50%">
                                                <a style="color: #ffffff;"><font color="#ffffff"> Todos los derechos reservados. </font> </a>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                             </tr>
                        </table>
                     </td>
                </tr>
            </table>
        </body>
        </html>
        ';
        // Asegúrate que estás pasando el campo de email correcto. 
        // En Clientes.php el campo de email es 'emailcl', no 'email_c'.
        $mensaje_enviado = $enviaMail->envia_Correos($datos_cliente->emailcl, $titulo2, $mensaje, $mail);
    }
}
