<?php
namespace App\Http\Controllers;
    
    use Illuminate\Http\Request;

    use App\ProductosTienda;
    use App\ItemFiles;
    use App\Http\Requests;
    use App\FacebookApi;
    use App\Clientes;
    use App\OrdenesWeb;
    use App\OrdenesDetalle;
    use MercadoPago\SDK;
    use MercadoPago\Preference;
    use MercadoPago\Item;
    use App\OpenpayService;

    class CartWebController extends Controller
    {

        // comprar desde landing
        public function comprarAhora(Request $request)
        {
            // traemos el carrito de la session
            $cart = session()->get('cart');

            if (!$cart) {
                $cart = [];
                $product = [];
            }

            $existingProductKey = null;
            foreach ($cart as $key => $item) {
                if ($item['id_producto'] == $request->id_producto) {
                    $existingProductKey = $key;
                    break;
                }
            }

            if ($existingProductKey !== null) {
                // Actualizar la cantidad del producto existente
                $cart[$existingProductKey]['cantidad'] += $request->cantidad;
            } else {
                // Agregar el producto al carrito
                $cart[] = [
                    "id_producto" => $request->id_producto,
                    "titulo" => trim($request->post_titulo, " "),
                    "cantidad" => $request->cantidad,
                    "precio" => $request->precio_prodcuto,
                    "envio" => $request->envio,
                    "imagen" => $request->imagen,
                ];
            }

            $evento = "AddToCart";
            $host = $_SERVER["HTTP_HOST"];
            $url = $_SERVER["REQUEST_URI"];
            $url_actual = "https://" . $host . $url;
            $em = "";
            $ph = "";
            $content_name = trim($request->post_titulo, " ");
            $value = $request->precio_prodcuto;
            $envia_eventos = new FacebookApi();
            $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);

            // Almacena en carrito en la session
            session()->put('cart', $cart);

            // Calcula el número total de elementos en el carrito
            $cart_count = count($cart);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado al carrito.',
                    'cart_count' => $cart_count,
                ]);
            }

            // Redirigir al usuario a la vista del carrito
            return redirect()->route('ver_carrito');
        }

        public function addToCart(Request $request)
        {
            // dd($request->all());
            $cart = session()->get('cart');

            if (!$cart) {
                $cart = [];
            }

            //dd($request->all());
            $existingProductKey = null;
            foreach ($cart as $key => $item) {
                if ($item['id_producto'] == $request->id_producto) {
                    $existingProductKey = $key;
                    break;
                }
            }

            if ($existingProductKey !== null) {
                // Actualizar la cantidad del producto existente
                $cart[$existingProductKey]['cantidad'] += $request->cantidad;
            } else {
                // Agregar el producto al carrito
                $cart[] = [
                    "id_producto" => $request->id_producto,
                    "titulo" => trim($request->post_titulo, " "),
                    "cantidad" => $request->cantidad,
                    "precio" => $request->precio_prodcuto,
                    "envio" => $request->envio,
                    "imagen" => $request->imagen
                ];
            }


            $evento = "AddToCart";
            $host = $_SERVER["HTTP_HOST"];
            $url = $_SERVER["REQUEST_URI"];
            $url_actual = "https://" . $host . $url;
            $em = "";
            $ph = "";
            $content_name = trim($request->post_titulo, " ");
            $value = $request->precio_prodcuto;
            $envia_eventos = new FacebookApi();
            $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);

            // Almacena en carrito en la session
            session()->put('cart', $cart);

            // Calcula el número total de elementos en el carrito
            $cart_count = count($cart);

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'message' => 'Producto agregado al carrito.',
                    'cart_count' => $cart_count
                ]);
            }

            return redirect()->back()->with('success', 'Producto agregado al carrito.');
        }

        public function aumentarCantidadProducto(Request $request)
        {
            $cart = session()->get('cart');
            $id_producto = $request->id_producto;
            $accion = $request->accion;

            if ($accion == 'disminuir') {
                foreach ($cart as &$cart_item) {
                    if ($cart_item['id_producto'] == $id_producto) {
                        if ($cart_item['cantidad'] > 1) {
                            $cart_item['cantidad']--;
                        }
                        break;
                    }
                }
            } elseif ($accion == 'aumentar') {
                foreach ($cart as &$cart_item) {
                    if ($cart_item['id_producto'] == $id_producto) {
                        $cart_item['cantidad']++;
                        break;
                    }
                }
            }

            session()->put('cart', $cart);

            $total = 0;
            $envio = 0;

            foreach ($cart as $item) {
                $total += $item['precio'] * $item['cantidad'];
                $envio += $item['envio'] * $item['cantidad'];
            }

            $gran_total = $total + $envio;

            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'cart' => $cart,
                    'cart_item' => $cart_item,
                    'total' => number_format($total, 2, '.', ','),
                    'envio' => number_format($envio, 2, '.', ','),
                    'gran_total' => number_format($gran_total, 2, '.', ',')
                ]);
            }

            return view('web_andamios.carrito.contenido_carrito', compact('cart'));
        }

        public function showCart()
        {
            $cart = session()->get('cart');

            if (!$cart) {
                $cart = [];
                $message = "Tu carrito está vacío.";
            } else {
                $productCount = count($cart);
                if ($productCount === 1) {
                    $message = "Tu carrito contiene 1 producto.";
                } else {
                    $message = "Tu carrito contiene " . $productCount . " productos.";
                }
            }

            return view('web_andamios.carrito.carrito', [
                'cart' => $cart,
                'message' => $message,
            ]);
        }

        public function miniCart()
        {
            $miniCart = session()->get('cart');

            return view('web_andamios.carrito.contenido_mini_cart', compact('miniCart'));
        }

        // public function removeMiniCart(Request $request) {
        //     $id = $request->id_producto;
        //     // obtener el carrito almacenado en la sesión
        //     $cart = session()->get('cart');

        //     // utilizar array_filter() para filtrar el producto que se eliminará
        //     $cart = array_filter($cart, function ($item) use ($id) {
        //         return $item['id_producto'] != $id;
        //     });

        //     // almacenar el carrito actualizado en la sesión
        //     session()->put('cart', $cart);
        // }

        public function removeCart(Request $request)
        {
            $id = $request->id_producto;
            // obtener el carrito almacenado en la sesión
            $cart = session()->get('cart');

            // utilizar array_filter() para filtrar el producto que se eliminará
            $cart = array_filter($cart, function ($item) use ($id) {
                return $item['id_producto'] != $id;
            });

            // almacenar el carrito actualizado en la sesión
            session()->put('cart', $cart);
            $cart_count = count($cart);


            if ($request->ajax()) {
                return response()->json([
                    'success' => true,
                    'cart_count' => $cart_count
                ]);
            }

            // redirigir de vuelta al carrito de compras
            return redirect()->back()->with('message', 'Producto eliminado.');
        }

        public function clearCart()
        {
            session()->forget('cart');
            return redirect()->back()->with('message', 'Carrito vacio.');
        }

        public function checkout(Request $request)
        {
            // Obtener los datos del carrito de la sesión
            $cart = session()->get('cart');

            if (empty($cart)) {
                return redirect()->route('ver_carrito')->with('error', 'Tu carrito está vacío.');
            }

            // Convertir la Request a objeto para usar la sintaxis de los métodos estáticos
            $data_post = json_decode(json_encode($request->all()));

            // --- LÓGICA DE CÁLCULO ---
            $total = 0;
            $envio = 0;
            $num_articulos = 0;
            $articulo = [];

            foreach ($cart as $item) {
                $total += $item['precio'] * $item['cantidad'];
                // Asegurarse de que 'envio' existe y es numérico
                $envio += ($item['envio'] ?? 0) * $item['cantidad'];
                $num_articulos += $item['cantidad'];
                if ($item['id_producto'] == 1) {
                    $articulo = $item;
                }
            }

            $iva = 0.0;
            $gran_total = $total + $envio;

            // Si se activa la facturación
            if (!empty($data_post->iva) && $data_post->iva == "on") {
                $iva = $total * 0.16;
                $gran_total = $total + $iva + $envio;
            }

            // 1. GUARDAR CLIENTE 
            $datos_cliente = Clientes::postClienteTienda($data_post);

            if (empty($datos_cliente)) {
                return redirect()->back()->withInput()->with('error', 'Faltan datos del cliente para procesar la orden.');
            }

            // 2. GUARDAR ORDEN EN ESTATUS 9 (Orden Creada, Pago Pendiente)
            $status_orden = 9; // Estatus para 'Creada/Pendiente de Pago'
            $status_accion = "orden_creada";

            $datos_orden = OrdenesWeb::ordenesTienda(
                $datos_cliente,
                $num_articulos,
                $total,
                $iva,
                $gran_total,
                $data_post,
                $status_orden,
                $status_accion
            );

            // 3. GUARDAR DETALLE DE LA ORDEN
            OrdenesDetalle::postDetalleOrden($datos_orden, $cart);

            $id_orden_numerico = $datos_orden->id_orden;

            // 4. EVENTO DE FACEBOOK
            $evento = "InitiateCheckout";
            $host = $_SERVER["HTTP_HOST"];
            $url = $_SERVER["REQUEST_URI"];
            $url_actual = "https://" . $host . $url;
            $em = $data_post->email ?? "";
            $ph = $data_post->telefono ?? "";
            $content_name = "";
            $value = $gran_total; // Usar el total calculado
            $envia_eventos = new FacebookApi();
            $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);

            // 5. EVALUAR MÉTODO DE PAGO SELECCIONADO
            $metodo_pago = $request->input('metodo_pago', 'mercadopago');

            if ($metodo_pago === 'openpay') {
                $openpayService = new OpenpayService();
                $descripcionOrden = "Orden #" . $id_orden_numerico . " - Tienda Andamios Ligeros";

                // Si viene tokenizado desde openpay.js (Checkout transparente)
                if (!empty($request->input('token_id'))) {
                    $resCharge = $openpayService->createCardCharge([
                        'token_id' => $request->input('token_id'),
                        'device_session_id' => $request->input('device_session_id', ''),
                        'monto' => $gran_total,
                        'descripcion' => $descripcionOrden,
                        'order_id' => 'AL-' . $id_orden_numerico,
                        'redirect_url' => route('pago_tienda_online', [
                            'id_orden' => $id_orden_numerico,
                            'gateway' => 'openpay'
                        ]),
                        'cliente_nombre' => $data_post->nombre_c ?? '',
                        'cliente_email' => $data_post->email ?? '',
                        'cliente_telefono' => $data_post->telefono ?? '',
                    ]);

                    if ($resCharge['success'] && !empty($resCharge['data'])) {
                        $chargeData = $resCharge['data'];
                        $txId = $chargeData['id'] ?? '';
                        $txStatus = $chargeData['status'] ?? '';

                        $datos_orden->mp_payment_id = $txId;
                        $datos_orden->mp_payment_type = 'openpay_' . ($chargeData['method'] ?? 'card');

                        // Si requiere 3D Secure (Redirección bancaria de autenticación)
                        if ($txStatus === 'charge_pending' && !empty($chargeData['payment_method']['url'])) {
                            $datos_orden->mp_status = 'pending';
                            $datos_orden->status_orden = 9;
                            $datos_orden->save();

                            return redirect($chargeData['payment_method']['url']);
                        }

                        // Si fue aprobado directamente
                        if ($txStatus === 'completed') {
                            $datos_orden->mp_status = 'approved';
                            $datos_orden->status_orden = 1;
                            $datos_orden->mp_fecha_post = date('Y-m-d H:i:s');
                            $datos_orden->save();

                            session()->forget('cart');

                            $webhooksController = new WebhooksController();
                            $webhooksController->notificarOrdenAprobada($datos_orden);

                            return redirect()->route('pago_tienda_online', [
                                'id_orden' => $id_orden_numerico,
                                'gateway' => 'openpay'
                            ]);
                        }
                    }

                    \Log::error('Fallo al procesar cargo Openpay con tarjeta: ', $resCharge);
                    $errorCode = $resCharge['error_code'] ?? null;
                    $errorDescriptions = [
                        1000 => 'Ocurrió un error interno en el procesador de pagos. Por favor intenta más tarde.',
                        1001 => 'El formato de los datos de la transacción no es válido.',
                        1004 => 'Servicio temporalmente fuera de línea. Por favor intenta más tarde.',
                        1005 => 'Uno o más datos obligatorios no fueron proporcionados.',
                        2004 => 'El número de tarjeta no es válido.',
                        2005 => 'La fecha de expiración de la tarjeta no es válida.',
                        2006 => 'El código de seguridad (CVV) es inválido.',
                        2007 => 'El número de tarjeta es de prueba y solo es válido en modo Sandbox.',
                        3001 => 'La tarjeta fue declinada por el banco emisor. Por favor intenta con otra tarjeta.',
                        3002 => 'La tarjeta ha expirado.',
                        3003 => 'La tarjeta no tiene fondos suficientes. Por favor intenta con otra tarjeta o método de pago.',
                        3004 => 'La tarjeta fue reportada como robada o extraviada.',
                        3005 => 'La transacción fue rechazada por el sistema de seguridad o antifraude del banco.',
                        3006 => 'La operación no está permitida para este tipo de tarjeta.',
                        3008 => 'La tarjeta no es válida para transacciones en línea.',
                        3009 => 'La tarjeta fue reportada como extraviada.',
                        3010 => 'El banco emisor ha restringido el uso de esta tarjeta.',
                        3011 => 'El banco emisor solicita la retención de la tarjeta. Por favor contacta a tu banco.',
                        3012 => 'Se requiere autorización adicional del banco emisor.',
                        15001 => 'La autenticación de seguridad (3D Secure) fue rechazada por el banco emisor. Por favor intenta con otra tarjeta o método de pago.',
                    ];

                    if (isset($errorDescriptions[$errorCode])) {
                        $errorMsg = $errorDescriptions[$errorCode];
                    } elseif (!empty($resCharge['description'])) {
                        $desc = $resCharge['description'];
                        if (stripos($desc, 'Authentication/Account Verification Rejected') !== false || stripos($desc, '3D') !== false) {
                            $errorMsg = 'La autenticación de seguridad (3D Secure) fue rechazada por el banco emisor. Por favor intenta con otra tarjeta.';
                        } elseif (stripos($desc, 'declined') !== false) {
                            $errorMsg = 'La tarjeta fue declinada por el banco emisor. Por favor intenta con otra tarjeta.';
                        } elseif (stripos($desc, 'funds') !== false) {
                            $errorMsg = 'La tarjeta no tiene fondos suficientes. Por favor intenta con otra tarjeta o método de pago.';
                        } else {
                            $errorMsg = 'No fue posible procesar el cargo a tu tarjeta (' . ($errorCode ? "Código $errorCode" : 'declinada') . '). Por favor intenta con otro método.';
                        }
                    } else {
                        $errorMsg = 'No fue posible procesar el cargo a tu tarjeta. Verifica los datos o intenta con otro método.';
                    }

                    return redirect()->route('ver_carrito')->with('error', $errorMsg)->withInput();

                }

                // Generar Checkout Redirigido de Openpay (Fallback)
                $resCheckout = $openpayService->createCheckout([
                    'monto' => $gran_total,
                    'descripcion' => $descripcionOrden,
                    'order_id' => 'AL-' . $id_orden_numerico,
                    'redirect_url' => route('pago_tienda_online', [
                        'id_orden' => $id_orden_numerico,
                        'gateway' => 'openpay'
                    ]),
                    'cliente_nombre' => $data_post->nombre_c ?? '',
                    'cliente_email' => $data_post->email ?? '',
                    'cliente_telefono' => $data_post->telefono ?? '',
                ]);

                if ($resCheckout['success'] && !empty($resCheckout['data']['checkout_link'])) {
                    if (!empty($resCheckout['data']['id'])) {
                        $datos_orden->mp_payment_id = $resCheckout['data']['id'];
                        $datos_orden->mp_payment_type = 'openpay_checkout';
                        $datos_orden->save();
                    }
                    return redirect($resCheckout['data']['checkout_link']);
                } else {
                    \Log::error('Fallo al crear checkout Openpay: ', $resCheckout);
                    $errorMsg = $resCheckout['description'] ?? 'No fue posible iniciar el pago con Openpay. Intenta con otro método.';
                    return redirect()->route('ver_carrito')->with('error', $errorMsg);
                }
            }


            // 6. FLUJO MERCADO PAGO (POR DEFECTO)
            SDK::setAccessToken(config('services.mercadopago.token'));

            $prefijo_sitio = env('SITIO_PREFIJO', 'vallas'); // Debe ser 'vallas' en este sitio
            $id_orden_con_prefijo = $prefijo_sitio . '-' . $id_orden_numerico;
            $webhook_url = env('WEBHOOK_MP_URL', 'https://scoregol.com/mercadopago/webhook'); // URL CENTRALIZADA

            $preference = new Preference();

            $items = [];
            $total_items_precio = 0;

            foreach ($cart as $item) {
                $mp_item = new Item();
                $mp_item->title = $item['titulo'];
                $mp_item->unit_price = (float)$item['precio'];
                $mp_item->quantity = (int)$item['cantidad'];
                $items[] = $mp_item;
                $total_items_precio += (float)$item['precio'] * (int)$item['cantidad'];
            }

            // Agregar el IVA como un ítem separado si aplica
            if ($iva > 0) {
                $mp_item_iva = new Item();
                $mp_item_iva->title = "Impuesto IVA (16%)";
                $mp_item_iva->unit_price = (float)$iva;
                $mp_item_iva->quantity = 1;
                $items[] = $mp_item_iva;
                $total_items_precio += (float)$iva;
            }

            // Agregar el costo de envío como un ítem separado si aplica
            if ($envio > 0) {
                $mp_item_envio = new Item();
                $mp_item_envio->title = "Costo de Envío";
                $mp_item_envio->unit_price = (float)$envio;
                $mp_item_envio->quantity = 1;
                $items[] = $mp_item_envio;
                $total_items_precio += (float)$envio;
            }

            $preference->items = $items;
            $preference->external_reference = $id_orden_con_prefijo;
            $preference->notification_url = $webhook_url;

            $preference->back_urls = [
                "success" => route('pago_tienda_online', ['id_orden' => $id_orden_numerico]),
                "pending" => route('pago_tienda_online', ['id_orden' => $id_orden_numerico]),
                "failure" => route('pago_tienda_online', ['id_orden' => $id_orden_numerico])
            ];

            $preference->auto_return = "all";
            $preference->save();

            // Redirección a Mercado Pago
            return redirect($preference->init_point);
        }


        public function verDetalleProduct(Request $request)
        {
            $ObjProductTienda = ProductosTienda::where("post_url", $request->url_product)->first();
            if (!empty($ObjProductTienda->id_product)) {
                $urlProducto = $ObjProductTienda->post_url;
                if (!empty($urlProducto) == $request->url_product) {
                    $productosTienda = new ProductosTienda();
                    $info_productos_rel = $productosTienda
                        ->where("post_estatus", "=", 1)
                        ->orderBy('post_fecha', 'DESC')
                        ->limit(5)
                        ->get();
                    $info_producto = $productosTienda
                        ->select("*")
                        ->from("productos_tienda as PT")
                        ->leftJoin("productos_tienda_detalle AS PTD", "PTD.id_product", "=", "PT.id_product")
                        ->leftJoin("productos_tienda_meta AS PTM", "PTM.id_product", "=", "PT.id_product")
                        ->where("PT.post_url", $urlProducto)
                        ->first();

                    $galeria_productos = ItemFiles::where("id_product", $info_producto->id_product)->where("file_tipo", "galeria")->get();
                    $img_social = ItemFiles::where("id_product", $info_producto->id_product)->where("file_tipo", "social")->first();

                    $evento = "ViewContent";
                    $host = $_SERVER["HTTP_HOST"];
                    $url = $_SERVER["REQUEST_URI"];
                    $url_actual = "https://" . $host . $url;
                    $em = "";
                    $ph = "";
                    $content_name = $info_producto->post_titulo;
                    if (!empty($info_producto->precio2)) {
                        $value = $info_producto->precio2;
                    } else {
                        $value = $info_producto->precio;
                    }
                    $envia_eventos = new FacebookApi();
                    $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);

                    return view('web_andamios/tienda/detalle_productos/detalle_productos', array(
                        "info_producto" => $info_producto,
                        "galeria_productos" => $galeria_productos,
                        "info_productos_rel" => $info_productos_rel,
                        "img_social" => $img_social
                    ));
                } else {
                    echo "No existen registros en base de datos";
                }
            } else {
                if ($request->url_product == "carrito") {
                    return view('web_andamios.carrito.carrito');
                } else {
                    return \Redirect::to('/');
                }
            }
        }

        public function ajax_tienda_web(Request $request)
        {
            $data_post = new \stdClass();
            $iva = 0;
            $fact_activa = "false";

            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'actualizaProductos':
                        //dd($data_post);
                        $condicion_filtro = (!empty($data_post->categoria_activa)) ? ' PT.categoria = \'' . $data_post->categoria_activa . '\'' : 1;
                        $condicion_filtro .= (!empty($data_post->modelo_activo)) ? ' AND PT.modelo = \'' . $data_post->modelo_activo . '\'' : '';

                        $objProductosTienda = new ProductosTienda();
                        $productosTienda = $objProductosTienda
                            ->select('*')
                            ->from('productos_tienda as PT')
                            ->Leftjoin('productos_tienda_detalle as PTD',  'PT.id_product', '=', 'PTD.id_product')
                            ->whereIn('PT.post_estatus', [1, 3])
                            ->whereRaw($condicion_filtro)
                            ->orderBy('PT.estrella', 'DESC')
                            ->orderBy('PT.categoria', 'ASC')
                            ->get();
                        //STATUS 3 ES DE PRODUCTO VENCIDO
                        return view('web_andamios.tienda.listado_productos', compact('productosTienda'));
                        break;

                    case 'agregaImpuesto':
                        if ($data_post->activa_factura == "true") {
                            $vista = view("web_andamios.carrito.extra_factura")->render();
                            $iva = $data_post->subtotal * 0.16;
                            $total = $data_post->subtotal + $iva + $data_post->envio;
                        }
                        if ($data_post->activa_factura == "false") {
                            $iva = "";
                            $vista = "";
                            $total = $data_post->subtotal + $data_post->envio;
                        }
                        return response()->json([
                            'vista' => $vista,
                            'iva' => $iva,
                            'total' => $total
                        ]);
                        break;
                    case 'agregaCupon':
                        $fact_activa = $data_post->activa_factura;
                        $codigo = "500OFF";
                        $cupon = 500;
                        $activo = 0;
                        $subtotal = $data_post->subtotal;
                        $subtotal_original = $data_post->subtotal_original;
                        $total = $subtotal + $data_post->envio;

                        if ($fact_activa == "true") {
                            $iva = $subtotal * 0.16;
                        } else {
                            $iva = 0;
                        }

                        // CUPON ACTIVO
                        if ($data_post->campo_cupon == $codigo) {
                            $activo = 1;
                            $subtotal = $data_post->subtotal - $cupon;

                            $total = $subtotal + $data_post->envio + $iva;
                        }
                        if ($data_post->campo_cupon == $codigo && $fact_activa == "true") {
                            $iva = $subtotal * 0.16;
                            $total = $subtotal + $data_post->envio + $iva;
                        }
                        // CUPON CANCELADO
                        if ($data_post->campo_cupon == "" || $data_post->checked == "false" || $data_post->campo_cupon !== $codigo) {
                            $activo = 0;
                            $cupon = 0;
                            $subtotal = $subtotal_original;
                            $total = $subtotal + $data_post->envio + $iva;
                        }


                        return response()->json([
                            'subtotal' => $subtotal,
                            'cupon' => $cupon,
                            'total' => $total,
                            'activo' => $activo,
                        ]);

                        break;
                }
            }
        }
    }
