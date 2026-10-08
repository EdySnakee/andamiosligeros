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

        // Si el usuario regresa de Openpay y la orden sigue en estatus 9 (creada/pendiente)
        if ($request->get('gateway') === 'openpay' && $info_orden->status_orden == 9) {
            $openpayTxId = $request->get('id') ?: $info_orden->mp_payment_id;
            if (!empty($openpayTxId)) {
                try {
                    $openpayService = new \App\OpenpayService();
                    $charge = $openpayService->getCharge($openpayTxId);
                    if ($charge['success'] && isset($charge['data']['status'])) {
                        if ($charge['data']['status'] === 'completed') {
                            $info_orden->status_orden = 1;
                            $info_orden->mp_payment_id = $charge['data']['id'];
                            $info_orden->mp_payment_type = 'openpay_' . ($charge['data']['method'] ?? 'card');
                            $info_orden->mp_status = 'approved';
                            $info_orden->mp_fecha_post = date('Y-m-d H:i:s');
                            $info_orden->save();

                            $this->notificarOrdenAprobada($info_orden);
                        } elseif (in_array($charge['data']['status'], ['in_progress', 'charge_pending'])) {
                            $info_orden->status_orden = 2; // Pendiente
                            $info_orden->save();
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Error verificando cargo Openpay en retorno: ' . $e->getMessage());
                }
            }
        }

        // El estatus ya debe haber sido actualizado por el Webhook o por la consulta directa


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
                $this->notificarCotizacionAprobada($info_cotizacion, $payment_id, $payment_type);
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

        // Si el usuario regresa de Openpay (ej. autenticación 3D Secure)
        if ($request->get('gateway') === 'openpay') {
            $openpayTxId = $request->get('id');
            if (!empty($openpayTxId)) {
                try {
                    $openpayService = new \App\OpenpayService();
                    $charge = $openpayService->getCharge($openpayTxId);
                    if ($charge['success'] && isset($charge['data']['status'])) {
                        if ($charge['data']['status'] === 'completed') {
                            $status_mp = 'success';
                            $this->notificarCotizacionAprobada(
                                $info_cotizacion,
                                $charge['data']['id'] ?? '',
                                'openpay_' . ($charge['data']['method'] ?? 'card')
                            );
                        } elseif (in_array($charge['data']['status'], ['in_progress', 'charge_pending'])) {
                            $status_mp = 'pending';
                        } else {
                            $status_mp = 'failure';
                        }
                    }
                } catch (\Exception $e) {
                    \Log::error('Error verificando cargo Openpay cotizacion en retorno: ' . $e->getMessage());
                }
            }
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

    /**
     * Webhook oficial para recibir notificaciones automáticas de Openpay.
     */
    public function webhookOpenpay(Request $request)
    {
        \Log::info('Webhook Openpay recibido: ', $request->all());

        $type = $request->input('type');

        // Manejo del evento de verificación de Openpay al registrar el Webhook en el Dashboard
        if ($type === 'verification') {
            $code = $request->input('verification_code');
            \Log::info("Openpay Webhook Verification Code recibido: " . $code);
            @file_put_contents(storage_path('logs/openpay_verification_code.txt'), $code);

            try {
                \Mail::raw("El código de verificación del Webhook de Openpay es: {$code}\n\nIngrésalo en tu panel de Openpay para confirmar el webhook.", function ($message) use ($code) {
                    $message->to(env('ADMIN_NOTIFICATION_EMAIL', 'ventas@andamiosligeros.com'), 'Admin Ventas')
                        ->from(env('MAIL_FROM_ADDRESS', 'no-reply@andamiosligeros.com'), env('MAIL_FROM_NAME', 'Notificaciones Andamios'))
                        ->subject('🔑 Código de Verificación Webhook Openpay: ' . $code);
                });
            } catch (\Exception $e) {
                \Log::warning("No se pudo enviar email de verification_code Openpay: " . $e->getMessage());
            }

            return response()->json(['status' => 'success', 'verification_code' => $code], 200);
        }

        $transaction = $request->input('transaction', []);

        if (empty($transaction)) {
            return response()->json(['message' => 'Sin datos de transacción.'], 400);
        }

        $orderIdRaw = $transaction['order_id'] ?? null;
        $id_orden = null;

        if ($orderIdRaw && strpos($orderIdRaw, 'COT-') === 0) {
            $id_cot = (int) str_replace('COT-', '', $orderIdRaw);
            $info_cot = \App\Cotizaciones::find($id_cot);
            if ($info_cot) {
                if ($type === 'charge.succeeded' || ($transaction['status'] ?? '') === 'completed') {
                    $this->notificarCotizacionAprobada(
                        $info_cot,
                        $transaction['id'] ?? '',
                        'openpay_' . ($transaction['method'] ?? 'card')
                    );
                }
                return response()->json(['message' => 'Cotización notificada con éxito.'], 200);
            }
        }

        if ($orderIdRaw && strpos($orderIdRaw, 'AL-') === 0) {
            $id_orden = (int) str_replace('AL-', '', $orderIdRaw);
        }

        if (!$id_orden && !empty($transaction['id'])) {
            $info_orden_by_tx = \App\OrdenesWeb::where('mp_payment_id', $transaction['id'])->first();
            if ($info_orden_by_tx) {
                $id_orden = $info_orden_by_tx->id_orden;
            }
        }

        if (!$id_orden) {
            \Log::warning('Webhook Openpay: No se pudo determinar el ID de la orden.', $transaction);
            return response()->json(['message' => 'Orden no identificada.'], 404);
        }

        $info_orden = \App\OrdenesWeb::find($id_orden);

        if (!$info_orden) {
            \Log::warning("Webhook Openpay: Orden #{$id_orden} no encontrada en base de datos.");
            return response()->json(['message' => 'Orden no encontrada.'], 404);
        }

        // Idempotencia: Si ya está en estatus 1 (aprobada), respondemos 200 sin duplicar correos
        if ($info_orden->status_orden == 1) {
            return response()->json(['message' => 'Orden ya confirmada previamente.'], 200);
        }

        $txStatus = $transaction['status'] ?? '';
        $txMethod = $transaction['method'] ?? 'card';
        $txId = $transaction['id'] ?? '';

        if ($type === 'charge.succeeded' || $txStatus === 'completed') {
            $info_orden->status_orden = 1; // VENTA / APROBADO
            $info_orden->mp_status = 'approved';
            $info_orden->mp_payment_id = $txId;
            $info_orden->mp_payment_type = 'openpay_' . $txMethod;
            $info_orden->mp_fecha_post = date('Y-m-d H:i:s');
            $info_orden->save();

            $this->notificarOrdenAprobada($info_orden);
        } elseif (in_array($txStatus, ['in_progress', 'charge_pending'])) {
            $info_orden->status_orden = 2; // PENDIENTE
            $info_orden->mp_status = 'pending';
            $info_orden->save();
        } elseif ($type === 'charge.failed' || in_array($txStatus, ['failed', 'cancelled'])) {
            $info_orden->status_orden = 3; // ERROR / RECHAZADO
            $info_orden->mp_status = 'rejected';
            $info_orden->save();
        }

        return response()->json(['status' => 'success'], 200);
    }

    /**
     * Helper para enviar correos de notificación al cliente y admin cuando una orden es aprobada.
     */
    public function notificarOrdenAprobada($info_orden)
    {
        try {
            $datos_cliente = \App\Clientes::find($info_orden->idcl);
            $cart_items = \App\OrdenesDetalle::where('id_orden', $info_orden->id_orden)->get();

            if ($datos_cliente && $cart_items) {
                // 1. Enviar al CLIENTE
                \App\OrdenesWeb::enviaOrdenMail($datos_cliente, $info_orden, $cart_items);

                // 2. Enviar al ADMIN
                \Mail::send(
                    'emails.admin_notificacion_pago_orden',
                    [
                        'orden' => $info_orden,
                        'cliente' => $datos_cliente,
                        'detalles' => $cart_items,
                        'mp_id' => $info_orden->mp_payment_id,
                        'mp_payment_type' => $info_orden->mp_payment_type,
                    ],
                    function ($message) use ($info_orden) {
                        $message->to(env('ADMIN_NOTIFICATION_EMAIL', 'ventas@andamiosligeros.com'), 'Admin Ventas')
                            ->from(env('MAIL_FROM_ADDRESS', 'no-reply@andamiosligeros.com'), env('MAIL_FROM_NAME', 'Notificaciones Andamios'))
                            ->subject('✅ Pago (Andamios - Orden en Tienda en Línea): #' . $info_orden->id_orden);
                    }
                );
            }
        } catch (\Exception $e) {
            \Log::error("Webhook Andamios: Error al enviar emails para Orden #{$info_orden->id_orden}: " . $e->getMessage());
        }
    }

    /**
     * Helper para enviar correo de notificación al admin cuando una cotización es pagada.
     */
    public function notificarCotizacionAprobada($info_cotizacion, $payment_id, $payment_type)
    {
        try {
            $datos_cliente = \App\Clientes::find($info_cotizacion->id_cliente);
            $detalle_items = \App\DetalleCotizaciones::where('id_cotizacion', $info_cotizacion->id_cotizacion)->get();

            \Mail::send(
                'emails.admin_notificacion_pago_cotizacion',
                [
                    'cotizacion' => $info_cotizacion,
                    'cliente' => $datos_cliente,
                    'detalles' => $detalle_items,
                    'mp_id' => $payment_id,
                    'mp_payment_type' => $payment_type,
                ],
                function ($message) use ($info_cotizacion) {
                    $message->to(env('ADMIN_NOTIFICATION_EMAIL', 'ventas@andamiosligeros.com'), 'Admin Ventas')
                        ->from(env('MAIL_FROM_ADDRESS', 'no-reply@andamiosligeros.com'), env('MAIL_FROM_NAME', 'Notificaciones Andamios'))
                        ->subject('✅ Pago (Andamios - Cotización): #' . $info_cotizacion->cod_cotizacion);
                }
            );
        } catch (\Exception $e) {
            \Log::error("Webhook Andamios: Error al enviar email de ADMIN para Cotización #{$info_cotizacion->id_cotizacion}: " . $e->getMessage());
        }
    }

    /**
     * Endpoint auxiliar para consultar fácilmente el código de verificación de Openpay sin acceder por SSH.
     */
    public function obtenerCodigoVerificacionOpenpay()
    {
        $path = storage_path('logs/openpay_verification_code.txt');
        if (file_exists($path)) {
            $code = trim(file_get_contents($path));
            return response("<div style='font-family:sans-serif;padding:40px;text-align:center;'><h2>Código de verificación de Openpay:</h2><h1 style='color:#002f6c;font-size:38px;letter-spacing:2px;background:#f1f5f9;padding:16px 28px;display:inline-block;border-radius:10px;border:1px solid #cbd5e1;'>{$code}</h1><p style='color:#64748b;margin-top:16px;font-size:15px;'>Copia y pega este código en el modal de Openpay para verificar tu Webhook.</p></div>");
        }
        return response("<div style='font-family:sans-serif;padding:40px;text-align:center;'><h3 style='color:#991b1b;'>Aún no se ha recibido ningún código de verificación.</h3><p style='color:#64748b;'>Asegúrate de registrar la URL en el panel de Openpay y pulsar en \"Configurar\".</p></div>", 404);
    }
}

