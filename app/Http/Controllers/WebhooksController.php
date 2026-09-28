<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Cotizaciones;
use App\Ventas;
use App\TipoPago;
use App\Clientes;
use App\Utilidades;
use App\OrdenesWeb;
use App\OrdenesDetalle;
use App\FacebookApi;

class WebhooksController extends Controller
{
    public function notificaPago(Request $request)
    {
        //dd($request->all());
        $payment_id = $request->get('payment_id');
        $info_pago = $request->all();

        $ch = curl_init("https://api.mercadopago.com/v1/payments/{$payment_id}" . "?access_token=APP_USR-4889717567966924-101914-0d14476d62bb5e7c0158caa6589594a1-27900274");
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $response = curl_exec($ch);
        $response = json_decode($response);

        $datosCotizacion = new Cotizaciones();
        $infoCotizacion = $datosCotizacion->find($request->id_coti);

        $fecha = Utilidades::fecha();
        $usuario = "MP";
        $metodo_pago = "Mercado Pago";

        if ($response->status == "approved") {
            $status = 3; // STATUS 3 ES VENTA
            //ACTUALIZA TABLA COTIZACIONES
            $return_formato_cod_vta =  Cotizaciones::confirmaVende($request, $infoCotizacion, $fecha, $status);
            //GUARDA DATOS EN TABLA VENTAS
            $return_datos_venta = Ventas::guardaVenta($request, $infoCotizacion, $fecha, $status, $return_formato_cod_vta, $usuario);
            //GUARDA DATOS EN TABLA TIPO PAGO
            $return_tipo_pago =  TipoPago::addTipoPago($info_pago, $return_datos_venta, $metodo_pago);
        }
        if ($response->status == "pending" or $response->status == "in_process") {
            $status = 4; // STATUS 4 ES PENDIENTE
            //ACTUALIZA TABLA COTIZACIONES
            $return_formato_cod_vta =  Cotizaciones::cambiaStatus($request, $status);
        }

        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "ra") {
            if ($response->status == "approved") {
                return redirect()->route('web_ventas_redes', $return_datos_venta->ruta_encrypt);
            }
            if ($response->status == "pending" or $response->status == "in_process") {
                return redirect()->route('web_cotizaciones_redes', $infoCotizacion->ruta_encrypt);
            }
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "rp") {
            if ($response->status == "approved") {
                return redirect()->route('web_ventas_redes_p', $return_datos_venta->ruta_encrypt);
            }
            if ($response->status == "pending" or $response->status == "in_process") {
                return redirect()->route('web_cotizaciones_redes_p', $infoCotizacion->ruta_encrypt);
            }
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "sg") {
            if ($response->status == "approved") {
                return redirect()->route('web_ventas_scoregol', $return_datos_venta->ruta_encrypt);
            }
            if ($response->status == "pending" or $response->status == "in_process") {
                return redirect()->route('web_cotizaciones_scoregol', $infoCotizacion->ruta_encrypt);
            }
        }
        if (!empty($infoCotizacion->giro_empresa) and $infoCotizacion->giro_empresa == "al") {
            if ($response->status == "approved") {
                return redirect()->route('web_ventas_ligeros', $return_datos_venta->ruta_encrypt);
            }
            if ($response->status == "pending" or $response->status == "in_process") {
                return redirect()->route('web_cotizaciones_ligeros', $infoCotizacion->ruta_encrypt);
            }
        }
    }

    public function pagoTiendaOnline(Request $request)
    {
        // Este es el back_url (Return URL) de Mercado Pago.
        // NO debe hacer la consulta a la API de MP ni crear la orden.

        $id_orden_numerico = $request->get('id_orden');

        $info_orden = OrdenesWeb::find($id_orden_numerico); // Usamos el modelo OrdenesWeb

        if (empty($info_orden)) {
            $array_orden = [
                'num_orden' => 'N/A',
                'titulo_orden' => '❌ ORDEN NO ENCONTRADA ❌',
                'msj_orden' => 'No se encontró la orden. Contacta a soporte con tu comprobante de pago si lo tienes.',
                'color' => '#dc4c64',
                'total_orden' => 0
            ];
            return redirect()->route('status_vta', $array_orden);
        }

        // El estatus ya debe haber sido actualizado por el Webhook de Scoregol (actualizaOrdenWebhook)

        // Los estatus de la DB: 1=Venta/Aprobada, 2=Pendiente, 3=Error, 9=Creada/Abandonada
        if ($info_orden->status_orden == 1) {
            $titulo_orden = "🌟 GRACIAS POR TU COMPRA 🌟";
            $msj_orden = "Su compra se ha registrado con éxito con el número de órden: ";
            $color = "#14a44d";
            $cod_orden = sprintf('V%07d', $info_orden->id_orden);
        } elseif ($info_orden->status_orden == 2 || $info_orden->status_orden == 9) {
            $titulo_orden = "⚠ COMPRA PENDIENTE ⚠";
            $msj_orden = "Podemos darle seguimiento con el número de órden: ";
            $color = "#e4a11b";
            $cod_orden = sprintf('P%07d', $info_orden->id_orden);
        } else { // 3 (Error) o cualquier otro estatus
            $titulo_orden = "❌ HUBO UN PROBLEMA ❌";
            $msj_orden = "No temas, podemos darle seguimiento con el número de órden: ";
            $color = "#dc4c64";
            $cod_orden = sprintf('E%07d', $info_orden->id_orden);
        }

        // Lógica para obtener el artículo para la vista (si es necesario)
        $cart = session()->get('cart');
        $articulo = [];
        if (!empty($cart)) {
            foreach ($cart as $item) {
                if ($item['id_producto'] == 1) {
                    $articulo = $item;
                    break;
                }
            }
        }
        // Limpiamos el carrito SOLO si el estatus final es VENTA/APROBADA
        if ($info_orden->status_orden == 1) {
            session()->forget('cart');
        }

        $array_orden = [
            'num_orden' => $cod_orden,
            'titulo_orden' => $titulo_orden,
            'msj_orden' => $msj_orden,
            'color' => $color,
            'articulo' => $articulo,
            'total_orden' => $info_orden->gran_total // Usar el gran_total de la BD
        ];

        return redirect()->route('status_vta', $array_orden);
    }

    /**
     * 💡 FUNCIÓN NUEVA: Receptor del POST reenviado desde Scoregol.
     * Esta debe ser la URL configurada en routes.php: /webhooks/actualiza-orden
     */
    public function actualizaOrdenWebhook(Request $request)
    {
        // 1. Obtenemos todos los datos del POST
        $id_orden_remota = $request->get('id_orden');
        $status_mp = $request->get('status_mp');
        $payment_id = $request->get('payment_id');
        $payment_type = $request->get('payment_type');
        $total_pagado = (float) $request->get('total_pagado');
        $fecha_actual = date("Y-m-d H:i:s");

        // 2. Validación de datos mínimos
        if (empty($id_orden_remota) || empty($status_mp)) {
            \Log::warning('Webhook Andamios: Petición recibida con datos insuficientes.', $request->all());
            return response()->json(['message' => 'Datos insuficientes.'], 400);
        }

        \Log::info("Webhook Andamios: Procesando ID remoto #{$id_orden_remota}...");

        // --- LÓGICA DE ACTUALIZACIÓN DUAL CON VALIDACIÓN DE MONTO ---

        // 3. INTENTO 1: Buscar en Cotizaciones
        $info_cotizacion = \App\Cotizaciones::find($id_orden_remota);

        // Verificamos si existe Y SI EL MONTO COINCIDE
        if ($info_cotizacion && abs($info_cotizacion->total - $total_pagado) < 1.00) {

            \Log::info("Webhook Andamios: Coincidencia encontrada en COTIZACIONES.");

            // (Lógica de estatus de Cotizaciones)
            if ($status_mp == "approved") {
                $status_orden = 2; // PAGADO
            } elseif (in_array($status_mp, ["pending", "in_process"])) {
                $status_orden = 4; // PENDIENTE
            } else {
                $status_orden = 3; // RECHAZADO/ERROR
            }

            // $info_cotizacion->status = $status_orden;
            // $info_cotizacion->save();


            // *** ENVÍO DE CORREO DE ADMIN PARA COTIZACIÓN ***
            if ($status_orden == 2) { // Si fue aprobado
                try {
                    // Cotizaciones usa 'id_cliente'
                    $datos_cliente = \App\Clientes::find($info_cotizacion->id_cliente);
                    $detalle_items = \App\DetalleCotizaciones::where('id_cotizacion', $info_cotizacion->id_cotizacion)->get();

                    \Mail::send(
                        'emails.admin_notificacion_pago_cotizacion', // <-- Vista separada
                        [
                            'cotizacion' => $info_cotizacion,
                            'cliente' => $datos_cliente,
                            'detalles' => $detalle_items,
                            'mp_id' => $payment_id, // Pasamos el ID de MP por separado
                            'mp_payment_type' => $payment_type, // Pasamos el tipo de pago
                        ],
                        function ($message) use ($info_cotizacion) {
                            $message->to(env('ADMIN_NOTIFICATION_EMAIL', 'ventas@andamiosligeros.com'), 'Admin Ventas')
                                ->from(env('MAIL_FROM_ADDRESS', 'no-reply@andamiosligeros.com'), env('MAIL_FROM_NAME', 'Notificaciones Andamios'))
                                ->subject('✅ Pago (Andamios - Cotización): #' . $info_cotizacion->cod_cotizacion);
                        }
                    );
                } catch (\Exception $e) {
                    \Log::error("Webhook Andamios: Error al enviar email de ADMIN para Cotización #{$id_orden_remota}: " . $e->getMessage());
                }
            }
            // *** FIN DE CORREO ADMIN ***

            return response()->json(['message' => 'Cotización ' . $id_orden_remota . ' actualizada.'], 200);
        }

        // 4. INTENTO 2: Buscar en Órdenes de Carrito (Esta lógica se queda igual)
        $info_orden = \App\OrdenesWeb::find($id_orden_remota);

        // Verificamos si existe Y SI EL MONTO COINCIDE
        if ($info_orden && abs($info_orden->total - $total_pagado) < 1.00) {

            \Log::info("Webhook Andamios: Coincidencia encontrada en ORDENES.");

            // (Lógica de estatus de Órdenes)
            if ($status_mp == "approved") $status_orden = 1; // VENTA
            elseif (in_array($status_mp, ["pending", "in_process"])) $status_orden = 2; // PENDIENTE
            else $status_orden = 3; // ERROR

            // Guardamos todos los datos de MP porque OrdenesWeb SÍ tiene estos campos
            $info_orden->mp_payment_id = $payment_id;
            $info_orden->mp_payment_type = $payment_type;
            $info_orden->mp_status = $status_mp;
            $info_orden->mp_fecha_post = $fecha_actual;
            $info_orden->status_orden = $status_orden;
            $info_orden->save();

            // *** ENVÍO DE CORREOS DE ADMIN Y CLIENTE PARA ORDEN ***
            if ($status_orden == 1) { // Si fue aprobado
                try {
                    // OrdenesWeb usa 'idcl'
                    $datos_cliente = \App\Clientes::find($info_orden->idcl);
                    $cart_items = \App\OrdenesDetalle::where('id_orden', $info_orden->id_orden)->get();

                    if ($datos_cliente && $cart_items) {
                        // 1. Enviar al CLIENTE
                        \App\OrdenesWeb::enviaOrdenMail($datos_cliente, $info_orden, $cart_items);

                        // 2. Enviar al ADMIN
                        \Mail::send(
                            'emails.admin_notificacion_pago_orden', // <-- Vista separada
                            [
                                'orden' => $info_orden,
                                'cliente' => $datos_cliente,
                                'detalles' => $cart_items,
                                'mp_id' => $payment_id, // Pasamos el ID de MP
                                'mp_payment_type' => $payment_type, // Pasamos el tipo de pago
                            ],
                            function ($message) use ($info_orden) {
                                $message->to(env('ADMIN_NOTIFICATION_EMAIL', 'ventas@andamiosligeros.com'), 'Admin Ventas')
                                    ->from(env('MAIL_FROM_ADDRESS', 'no-reply@andamiosligeros.com'), env('MAIL_FROM_NAME', 'Notificaciones Andamios'))
                                    ->subject('✅ Pago (Andamios - Orden en Tienda en Línea): #' . $info_orden->id_orden);
                            }
                        );
                    }
                } catch (\Exception $e) {
                    \Log::error("Webhook Andamios: Error al enviar emails para Orden #{$id_orden_remota}: " . $e->getMessage());
                }
            }
            // *** FIN DE CORREOS ***

            return response()->json(['message' => 'Orden ' . $id_orden_remota . ' actualizada.'], 200);
        }

        // 5. ERROR: No se encontró
        \Log::warning("Webhook Andamios: ID #{$id_orden_remota} (Monto: {$total_pagado}) no encontrado en Cotizaciones ni en Órdenes, o el monto no coincidió.");
        return response()->json(['message' => 'ID de referencia no encontrado o monto no coincide.'], 404);
    }

    /**
     * MÉTODO DE RETORNO (back_urls) - Muestra un mensaje al cliente para Cotizaciones.
     */
    public function pagoCotizacionRetorno(Request $request)
    {
        $id_cotizacion = $request->get('id_cotizacion');
        $status_mp = $request->get('status'); // 'status' viene de la query string

        $info_cotizacion = \App\Cotizaciones::find($id_cotizacion);

        if (empty($info_cotizacion)) {
            return redirect('/')->with('error', 'Cotización no encontrada.');
        }

        if ($status_mp === 'success' || $status_mp === 'approved') {
            $titulo_orden = "🌟 GRACIAS POR TU PAGO 🌟";
            $msj_orden = "Su pago para la cotización ha sido registrado con éxito: ";
            $color = "#14a44d";
            $cod_orden = $info_cotizacion->cod_cotizacion;
        } elseif ($status_mp === 'pending') {
            $titulo_orden = "⚠ PAGO PENDIENTE ⚠";
            $msj_orden = "Tu pago está pendiente de aprobación. Número de cotización: ";
            $color = "#e4a11b";
            $cod_orden = $info_cotizacion->cod_cotizacion;
        } else { // failure
            $titulo_orden = "❌ PAGO RECHAZADO ❌";
            $msj_orden = "Tu pago fue rechazado. Número de cotización: ";
            $color = "#dc4c64";
            $cod_orden = $info_cotizacion->cod_cotizacion;
        }

        $array_orden = [
            'num_orden' => $cod_orden,
            'titulo_orden' => $titulo_orden,
            'msj_orden' => $msj_orden,
            'color' => $color,
            'articulo' => ['id_producto' => 0, 'titulo' => ''], // Evitar el error de 'articulo' no definido
            'total_orden' => $info_cotizacion->total
        ];

        // Reutilizamos la vista de 'status_venta' que ya corregimos
        return redirect()->route('status_vta', $array_orden);
    }

    public function statusVenta(Request $request)
    {
        //dd($request->all());
        $evento = "Purchase";
        $host = $_SERVER["HTTP_HOST"];
        $url = $_SERVER["REQUEST_URI"];
        $url_actual = "https://" . $host . $url;
        $em = "";
        $ph = "";
        $content_name = "";
        $value = "1.99";
        $envia_eventos = new FacebookApi();
        $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);
        //echo "<pre>";
        //print_r($respuesta_fb);
        //echo "</pre>";
        $datos_sts_vta = $request->all();
        $json_datos_sts_vta = json_decode(json_encode($datos_sts_vta));
        return view('web_andamios/status_venta/status_venta', compact('json_datos_sts_vta'));
    }
}
