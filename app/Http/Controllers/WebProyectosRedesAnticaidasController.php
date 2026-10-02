<?php

namespace App\Http\Controllers;

//use Mail;
//use Illuminate\Support\Facades\Mail;
use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\Blog;
use App\Utilidades;
use App\Cotizaciones;
use App\Ventas;
use App\Clientes;
use App\Productos;
use App\User;
use App\DetalleProducto;
use App\DetalleCotizaciones;
use App\ClientesRedes;
use App\GaleriaClientes;
use App\Http\Requests;
use Redirect;
use PHPMailer\PHPMailer;
use MercadoPago\SDK;
use MercadoPago\Preference;
use MercadoPago\Item;
use App\OpenpayService;
use App\Http\Controllers\WebhooksController;

//require_once("phpmailer/PHPMailerAutoload.php");

class WebProyectosRedesAnticaidasController extends Controller
{
    public function sitemap()
    {
        $Proyectos = ProyectosRedes::all();
        $Clientes = ClientesRedes::all();
        $Blog = Blog::all();

        //print_r($Proyectos);
        return response()->view('web_redes/xml/sitemap', compact('Proyectos', 'Clientes', 'Blog'))->header('Content-Type', 'text/xml');
    }
    public function verProyectosRedes(Request $request)
    {
        //print_r($request->url_proyectos);
        $Proyectos = ProyectosRedes::where("url_proyecto", $request->url_proyectos)->first();
        if (!empty($Proyectos->id_proyecto)) {
            //print_r($Proyectos->id_proyecto);
            $clientesRedes = ClientesRedes::where("id_proyecto", $Proyectos->id_proyecto)->get();
            $galeriaClientesRedesArray = GaleriaClientes::where("id_proyecto", $Proyectos->id_proyecto)->get();
            $urlProyectos = $Proyectos->url_proyecto;
        } else {
            return Redirect::to('/inicio');
        }

        if (!empty($request)) {
            if (!empty($urlProyectos) == $request->url_proyectos) {

                $tipo_menu = "proyectos";
                return view('web_redes/proyectos/landing', compact("urlProyectos", "tipo_menu", "Proyectos", "clientesRedes", "galeriaClientesRedesArray"));
            } else {
                echo "No existen registros en base de datos";
            }
        } else {
            return Redirect::to('/inicio');
        }
    }

    public function seccionProyectos(Request $request)
    {
        $objProyectosRedes = new ProyectosRedes();
        $datos_estados = $objProyectosRedes
            ->select("*")
            ->from("proyectos_redes AS pr")
            ->join("estados AS es", "pr.id_estado", "=", "es.idestado")
            ->orderBy('es.estado', 'ASC')
            ->get();

        $objCliRedes = new ClientesRedes();
        $datos_clientes = $objCliRedes
            ->select("*")
            ->from("clientesredes AS cr")
            ->where("cr.id_proyecto", "=", $datos_estados[0]["id_proyecto"])
            ->join("proyectos_redes AS pr", "pr.id_proyecto", "=", "cr.id_proyecto")
            ->join("estados AS es", "pr.id_estado", "=", "es.idestado")
            ->orderBy('es.estado', 'ASC')
            ->get();
        $tipo_menu = "principal";
        return view('web_redes/proyectos/proyectos', array(
            "tipo_menu" => $tipo_menu,
            "datos_estados" => $datos_estados,
            "datos_clientes" => $datos_clientes
        ));
    }
    public function verObrasRedes(Request $request)
    {
        $clientesRedes = ClientesRedes::where("url_cliente", $request->url_cliente)->first();
        if (!empty($clientesRedes->url_cliente)) {
            $galeriaClientesRedes = GaleriaClientes::where("id_cliente", $clientesRedes->id_cliente)->get();
            return view('web_redes/obras/landing', compact("clientesRedes", "galeriaClientesRedes"));
        } else {
            return Redirect::to('/inicio');
        }
    }

    public function UrlsGeolocalizable($value = '')
    {
        echo $_SERVER['REMOTE_ADDR'];
        echo var_export(unserialize(file_get_contents('http://www.geoplugin.net/php.gp?ip=' . $_SERVER['REMOTE_ADDR'])));
    }

    public function verCotizacionClienteRedesAnticaidas(Request $request)
    {
        $tipo_vista = "Cotizaciones";
        $cotizacionesRedes = Cotizaciones::where("ruta_encrypt", $request->ruta_encrypt)->first();
        if (isset($cotizacionesRedes->id_cotizacion) and !empty($cotizacionesRedes->id_cotizacion and $cotizacionesRedes->status == 1 or $cotizacionesRedes->status == 3 or $cotizacionesRedes->status == 4 or $cotizacionesRedes->status == 5)) {
            $objDetalleCoti = new DetalleCotizaciones();
            $DetalleCotizaciones = $objDetalleCoti
                ->select("*")
                ->from("detalle_cotizaciones as dc")
                ->leftJoin("productos AS pr", "pr.id_producto", "=", "dc.id_producto")
                ->leftJoin("detalle_producto AS dpr", "dpr.id_producto", "=", "dc.id_producto")
                ->where("id_cotizacion", $cotizacionesRedes->id_cotizacion)
                ->orderBy("id_det_cotizacion", "ASC")
                ->get();

            $infoCliente = Clientes::where("idcl", $cotizacionesRedes->id_cliente)->first();

            $vendedor = User::find($cotizacionesRedes->id_usuario_genera);

            foreach ($DetalleCotizaciones as $key) {
                # code...
                $infoProducto = Productos::where("id_producto", $key->id_producto)->first();
                //print_r($infoProducto->id_producto."<br>");
                $idsproductos[] = $infoProducto->id_producto;
            }
            $idsproducts_unicos = array_unique($idsproductos);
            //print_r($cotizacionesRedes->giro_empresa);
            // --- INICIO: LÓGICA DE PREFERENCIA DE PAGO ---

            $preference_id = null; // Inicializamos por si falla

            // Solo generamos la preferencia si la cotización permite pago por MP
            if ($cotizacionesRedes->mp_status == 'si' && ($cotizacionesRedes->status == 1 || $cotizacionesRedes->status == 5)) {

                try {
                    // 1. SDK de Mercado Pago
                    \MercadoPago\SDK::setAccessToken(config('services.mercadopago.token'));

                    // 2. Crea un objeto de preferencia
                    $preference = new \MercadoPago\Preference();

                    // 3. Crea un ítem en la preferencia
                    $item = new \MercadoPago\Item();
                    $item->title = 'Cotización ' . $cotizacionesRedes->cod_cotizacion;
                    $item->quantity = 1;
                    $item->unit_price = (float) $cotizacionesRedes->total; // Asegurarse de que sea float

                    $preference->items = array($item);

                    // 4. *** CONFIGURACIÓN DEL WEBHOOK CENTRAL ***

                    // Obtenemos el prefijo del sitio desde el .env (debe ser 'andamios')
                    $prefijo_sitio = env('SITIO_PREFIJO', 'andamios');

                    // Usamos el ID de la cotización como ID de orden
                    $id_orden_con_prefijo = $prefijo_sitio . '-' . $cotizacionesRedes->id_cotizacion;

                    // URL del Webhook Central (Scoregol)
                    $webhook_url = env('WEBHOOK_MP_URL', 'https://scoregol.com/mercadopago/webhook');

                    $preference->external_reference = $id_orden_con_prefijo;
                    $preference->notification_url = $webhook_url;

                    // 5. *** URLs DE RETORNO (para el cliente) ***
                    $urlSuccess = str_replace('http://', 'https://', route('pago.cotizacion.retorno', ['id_cotizacion' => $cotizacionesRedes->id_cotizacion, 'status' => 'success']));
                    $urlFailure = str_replace('http://', 'https://', route('pago.cotizacion.retorno', ['id_cotizacion' => $cotizacionesRedes->id_cotizacion, 'status' => 'failure']));
                    $urlPending = str_replace('http://', 'https://', route('pago.cotizacion.retorno', ['id_cotizacion' => $cotizacionesRedes->id_cotizacion, 'status' => 'pending']));

                    $preference->back_urls = array(
                        "success" => $urlSuccess,
                        "failure" => $urlFailure,
                        "pending" => $urlPending
                    );
                    $preference->auto_return = "approved";

                    // 6. Guardar la preferencia
                    $preference->save();
                    if (!empty($preference->id)) {
                        $preference_id = $preference->id;
                    } elseif (!empty($preference->error)) {
                        \Log::error("Error al guardar preferencia de MP para Cotización {$cotizacionesRedes->id_cotizacion}: ", (array) $preference->error);
                    }

                } catch (\Exception $e) {
                    // Manejar el error si MP falla
                    \Log::error("Error al crear preferencia de MP para Cotización {$cotizacionesRedes->id_cotizacion}: " . $e->getMessage());
                }
            }
            // --- FIN: LÓGICA DE PREFERENCIA DE PAGO ---

            return view('app_redes/modulos/cotizador/ver_cotizacion/ver_cotizacion', compact("cotizacionesRedes", "DetalleCotizaciones", "infoCliente", "idsproducts_unicos", "tipo_vista", "preference_id", "vendedor"));
        } else {
            return Redirect::to('/');
        }
    }

    public function verVentaClienteRedesAnticaidas(Request $request)
    {
        $tipo_vista = "Ventas";
        $ventasRedes = Ventas::where("ruta_encrypt", $request->ruta_encrypt)->first();
        if (isset($ventasRedes->id_cotizacion) && !empty($ventasRedes->id_cotizacion) && in_array($ventasRedes->status, [2, 3, 4, 5])) {
            $DetalleCotizaciones = DetalleCotizaciones::where("id_cotizacion", $ventasRedes->id_cotizacion)->get();
            $infoCliente = Clientes::where("idcl", $ventasRedes->id_cliente)->first();

            $idsproductos = [];
            foreach ($DetalleCotizaciones as $key) {
                # code...
                $infoProducto = Productos::where("id_producto", $key->id_producto)->first();
                if ($infoProducto) {
                    $idsproductos[] = $infoProducto->id_producto;
                }
            }
            $idsproducts_unicos = array_unique($idsproductos);
            //print_r($ventasRedes->giro_empresa);
            if (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'ra') {
                return view('app_redes/modulos/ventas/ver_ventas/ver_ventas_redes', compact("ventasRedes", "DetalleCotizaciones", "infoCliente", "idsproducts_unicos", "tipo_vista"));
            }
            if (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'rp') {
                return view('app_redes/modulos/ventas/ver_ventas/ver_ventas_rp', compact("ventasRedes", "DetalleCotizaciones", "infoCliente", "idsproducts_unicos", "tipo_vista"));
            }
            if (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'al') {
                return view('app_redes/modulos/ventas/ver_ventas/ver_ventas_al', compact("ventasRedes", "DetalleCotizaciones", "infoCliente", "idsproducts_unicos", "tipo_vista"));
            }
            if (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'sg') {
                return view('app_redes/modulos/ventas/ver_ventas/ver_ventas_sg', compact("ventasRedes", "DetalleCotizaciones", "infoCliente", "idsproducts_unicos", "tipo_vista"));
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function generaPdfCotizacionClienteRedesAnticaidas(Request $request)
    {
        $cotizacionesRedes = Cotizaciones::where("ruta_encrypt", $request->ruta_encrypt)->first();
        if (!empty($cotizacionesRedes->id_cotizacion)) {
            $DetalleCotizaciones = DetalleCotizaciones::where("id_cotizacion", $cotizacionesRedes->id_cotizacion)->get();
            $infoCliente = Clientes::where("idcl", $cotizacionesRedes->id_cliente)->first();
            foreach ($DetalleCotizaciones as $key) {
                # code...
                $infoProducto = Productos::where("id_producto", $key->id_producto)->first();
                $idsproductos[] = $infoProducto->id_producto;
            }

            $idsproducts_unicos = array_unique($idsproductos);

            $nombre_archivo_pdf = $cotizacionesRedes->cod_cotizacion . "-" . $cotizacionesRedes->fecha;

            if (!empty($cotizacionesRedes->giro_empresa) and $cotizacionesRedes->giro_empresa == 'ra') {

                $pdf = \PDF::loadView('app_redes/modulos/cotizador/crea_pdf/crea_pdf_ra', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "cotizacionesRedes" => $cotizacionesRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
                //return view('app_redes/modulos/cotizador/crea_pdf/crea_pdf_ra', compact("cotizacionesRedes","DetalleCotizaciones", "infoCliente", "idsproducts_unicos"));

            } elseif (!empty($cotizacionesRedes->giro_empresa) and $cotizacionesRedes->giro_empresa == 'sg') {
                $pdf = \PDF::loadView('app_redes/modulos/cotizador/crea_pdf/crea_pdf_sg', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "cotizacionesRedes" => $cotizacionesRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } elseif (!empty($cotizacionesRedes->giro_empresa) and $cotizacionesRedes->giro_empresa == 'al') {
                $pdf = \PDF::loadView('app_redes/modulos/cotizador/crea_pdf/crea_pdf_al', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "cotizacionesRedes" => $cotizacionesRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } elseif (!empty($cotizacionesRedes->giro_empresa) and $cotizacionesRedes->giro_empresa == 'rp') {
                $pdf = \PDF::loadView('app_redes/modulos/cotizador/crea_pdf/crea_pdf_rp', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "cotizacionesRedes" => $cotizacionesRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } else {
                return "SIN PDF CONFIGURADO";
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function generaPdfVentaClienteRedesAnticaidas(Request $request)
    {
        $ventasRedes = Ventas::where("ruta_encrypt", $request->ruta_encrypt)->first();
        if (!empty($ventasRedes->id_cotizacion)) {
            $DetalleCotizaciones = DetalleCotizaciones::where("id_cotizacion", $ventasRedes->id_cotizacion)->get();
            $infoCliente = Clientes::where("idcl", $ventasRedes->id_cliente)->first();
            foreach ($DetalleCotizaciones as $key) {
                # code...
                $infoProducto = Productos::where("id_producto", $key->id_producto)->first();
                $idsproductos[] = $infoProducto->id_producto;
            }

            $idsproducts_unicos = array_unique($idsproductos);

            $nombre_archivo_pdf = $ventasRedes->cod_venta . "-" . $ventasRedes->fecha_venta;

            print_r($ventasRedes->giro_empresa);
            if (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'ra') {

                $pdf = \PDF::loadView('app_redes/modulos/ventas/crea_pdf/crea_pdf_ra', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "ventasRedes" => $ventasRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
                //return view('app_redes/modulos/ventas/crea_pdf/crea_pdf_ra', compact("ventasRedes","DetalleCotizaciones", "infoCliente", "idsproducts_unicos"));

            } elseif (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'sg') {
                $pdf = \PDF::loadView('app_redes/modulos/ventas/crea_pdf/crea_pdf_sg', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "ventasRedes" => $ventasRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } elseif (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'al') {
                $pdf = \PDF::loadView('app_redes/modulos/ventas/crea_pdf/crea_pdf_al', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "ventasRedes" => $ventasRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } elseif (!empty($ventasRedes->giro_empresa) and $ventasRedes->giro_empresa == 'rp') {
                $pdf = \PDF::loadView('app_redes/modulos/ventas/crea_pdf/crea_pdf_rp', ["infoCliente" => $infoCliente, "DetalleCotizaciones" => $DetalleCotizaciones, "ventasRedes" => $ventasRedes, "idsproducts_unicos" => $idsproducts_unicos]);
                return $pdf->download($nombre_archivo_pdf . '.pdf');
            } else {
                return "SIN PDF CONFIGURADO";
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function verBlog(Request $request)
    {
        $objBlog = new Blog();
        $info_blog = $objBlog
            ->where("post_estatus", "=", "activo")
            ->orderBy('post_fecha', 'ASC')
            ->get();
        $tipo_menu = "principal";
        return view('web_redes/blog/blog', array(
            "tipo_menu" => $tipo_menu,
            "info_blog" => $info_blog
        ));
    }

    public function verDetalleBlog(Request $request)
    {
        $ObjBlog = Blog::where("post_url", $request->url_blog)->first();
        if (!empty($ObjBlog->id_blog) and $ObjBlog->post_estatus == "activo") {
            $urlBlog = $ObjBlog->post_url;
            if (!empty($urlBlog) == $request->url_blog) {
                $tipo_menu = "principal";

                $objCliRedes = new ClientesRedes();
                $datos_clientes = $objCliRedes
                    ->inRandomOrder()
                    ->limit(5)
                    ->get();

                $objBlog = new Blog();
                $info_blog = $objBlog
                    ->where("post_estatus", "=", "activo")
                    ->orderBy('post_fecha', 'ASC')
                    ->limit(5)
                    ->get();

                return view('web_redes/blog/detalle_blog/detalle_blog', array(
                    "tipo_menu" => $tipo_menu,
                    "ObjBlog" => $ObjBlog,
                    "datos_clientes" => $datos_clientes,
                    "info_blog" => $info_blog
                ));
            } else {
                echo "No existen registros en base de datos";
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function ajax_landing(Request $request)
    {
        $data_post = new \stdClass();

        if (!empty($request->datos)) {
            $data_post = json_decode(json_encode($request->datos));
        }

        if (!empty($request->accion)) {
            switch ($request->accion) {
                case "activaCliente":
                    $clientesRedes = ClientesRedes::where("id_cliente", $data_post->id_cliente)->first();
                    $galeriaClientesRedes = GaleriaClientes::where("id_cliente", $data_post->id_cliente)->get();
                    //print_r($galeriaClientesRedes);
                    return view('web_redes/proyectos/info_cliente', array(
                        "clientesRedes" => $clientesRedes,
                        "galeriaClientesRedes" => $galeriaClientesRedes,
                    ));
                    break;

                case 'enviaFormulario':
                    //$mail = new PHPMailer();
                    $mail = new PHPMailer\PHPMailer();
                    $enviaMail = new Utilidades();
                    $mensaje_cliente = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Inscripción Cliente</title>
                    </head>
                    <body>
                    <strong>CONTACTO DESDE : </strong>' . $data_post->url_contacto . '<br>
                    <strong>Nombre : </strong>' . $data_post->name . '<br>
                    <strong>Email : </strong>' . $data_post->email . '<br>
                    <strong>Teléfono : </strong>' . $data_post->telefono . '<br>
                    <strong>Celular: </strong>' . $data_post->celular . '<br>
                    <strong>Mensaje : </strong>' . $data_post->message . '<br>
                    </body>
                    </html>
                    ';
                    $mail->FromName = "mallasanticaidas.com";
                    $titulo = "Contacto desde mallasanticaidas";
                    $correo_agente = "ventas@scoregol.com";
                    echo $mensaje_enviado = $enviaMail->envia_Correos_inscripcion($correo_agente, $titulo, $mensaje_cliente, $mail);

                    $titulo2 = $data_post->name . " gracias por contactarnos";
                    $mensaje = '
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Bienenido a Mallasanticaidas</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    </head>
                    <body style="margin: 0; padding: 0; ">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                            <tr>
                                <td style="padding: 10px 0 30px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse; position: relative;">
                                        <tr>
                                            <td align="center" bgcolor="#fff" style="padding: 10px 30px; color: #043d8a; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; text-align: left;">
                                                <img width="100px" src="https://mallasanticaidas.com/landing/imagenes/redes-anticaidas-logotipo-600x662.jpg">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                            <b><p>Hola, ' . $data_post->name . '</p></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            <p style="text-align: justify;">¡Gracias por contactarnos! en este momento estamos revisando la información que nos proporcionó para poder ofrecerle una cotización personalizada con las especificaciones que requiere.</p>
                                                            <p style="text-align: justify;">Es importante que este enterado que cuenta con la confidencialidad de sus datos proporcionados, los cuales serán utilizados única y exclusivamente para poder darle información sobre nuestros productos y posibles futuras promociones.</p>
                                                            <p style="text-align: justify;">Si quisiera brindarnos alguna información posterior o su cotización no puede esperar, también puede comunicarse sin compromiso con alguno de nuestros asesores marcando al 556 932 8135.</p>
                                                                
                                                            <p>Saludos cordiales</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h3 style="font-family: Arial, sans-serif;">NUESTROS CLIENTES:</h3>
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-3M.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Abitat.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-AKRA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Anahuac-Organizacion-Constructora.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-AUDI.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Autopistas-Michoacan.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-CEMEX.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-CIMESA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Constructora-Anglo.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Constructora-CHUFANI.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Freyssinet.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-FUJITA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/CLiente-GIM.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-Copri.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-DAGS.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-R.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Hazama.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-ICA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Kepler.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Lackma-Constructora.png" alt="">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="#915098" style="padding: 30px 30px 30px 30px;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" width="50%">
                                                            &reg; Copyright © 2021 mallasanticaidas.com<br/>
                                                            
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
                    $mensaje_enviado = $enviaMail->envia_Correos_inscripcion($data_post->email, $titulo2, $mensaje, $mail);
                    //print_r($data_post->email);
                    break;

                case 'enviaFormularioLandings':
                    //$mail = new PHPMailer();
                    $mail = new PHPMailer\PHPMailer();
                    $enviaMail = new Utilidades();
                    $mensaje_cliente = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Inscripción Cliente</title>
                    </head>
                    <body>
                    <strong>CONTACTO DESDE : </strong>' . $data_post->url_contacto . '<br>
                    <strong>Nombre : </strong>' . $data_post->name . '<br>
                    <strong>Email : </strong>' . $data_post->email . '<br>
                    <strong>Celular: </strong>' . $data_post->celular . '<br>
                    <strong>Mensaje : </strong>' . $data_post->message . '<br>
                    </body>
                    </html>
                    ';
                    $mail->FromName = "mallasanticaidas.com";
                    $titulo = "Contacto desde mallasanticaidas";
                    $correo_agente = "ventas@scoregol.com";
                    echo $mensaje_enviado = $enviaMail->envia_Correos_inscripcion($correo_agente, $titulo, $mensaje_cliente, $mail);
                    //print_r($data_post->email);
                    $titulo2 = $data_post->name . " gracias por contactarnos";
                    $mensaje = '
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Bienenido a Mallasanticaidas</title>
                        <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
                    </head>
                    <body style="margin: 0; padding: 0; ">
                        <table border="0" cellpadding="0" cellspacing="0" width="100%"> 
                            <tr>
                                <td style="padding: 10px 0 30px 0;">
                                    <table align="center" border="0" cellpadding="0" cellspacing="0" width="600" style="border: 1px solid #cccccc; border-collapse: collapse; position: relative;">
                                        <tr>
                                            <td align="center" bgcolor="#fff" style="padding: 10px 30px; color: #043d8a; font-size: 28px; font-weight: bold; font-family: Arial, sans-serif; text-align: left;">
                                                <img width="100px" src="https://mallasanticaidas.com/landing/imagenes/redes-anticaidas-logotipo-600x662.jpg">
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="#ffffff" style="padding: 40px 30px 40px 30px;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="color: #153643; font-family: Arial, sans-serif; font-size: 24px;">
                                                            <b><p>Hola, ' . $data_post->name . '</p></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            <p style="text-align: justify;">¡Gracias por contactarnos! en este momento estamos revisando la información que nos proporcionó para poder ofrecerle una cotización personalizada con las especificaciones que requiere.</p>
                                                            <p style="text-align: justify;">Es importante que este enterado que cuenta con la confidencialidad de sus datos proporcionados, los cuales serán utilizados única y exclusivamente para poder darle información sobre nuestros productos y posibles futuras promociones.</p>
                                                            <p style="text-align: justify;">Si quisiera brindarnos alguna información posterior o su cotización no puede esperar, también puede comunicarse sin compromiso con alguno de nuestros asesores marcando al  556 932 8135.</p>
                                                                
                                                            <p>Saludos cordiales</p>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td>
                                                            <h3 style="font-family: Arial, sans-serif;">NUESTROS CLIENTES:</h3>
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-3M.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Abitat.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-AKRA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Anahuac-Organizacion-Constructora.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-AUDI.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Autopistas-Michoacan.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-CEMEX.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-CIMESA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Constructora-Anglo.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Constructora-CHUFANI.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Freyssinet.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-FUJITA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/CLiente-GIM.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-Copri.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-DAGS.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Grupo-R.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Hazama.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-ICA.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Kepler.png" alt="">
                                                            <img width="50px" src="https://mallasanticaidas.com/landing/clientes/Cliente-Lackma-Constructora.png" alt="">
                                                        </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td bgcolor="#915098" style="padding: 30px 30px 30px 30px;">
                                                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                                                    <tr>
                                                        <td style="color: #ffffff; font-family: Arial, sans-serif; font-size: 12px;" width="50%">
                                                            &reg; Copyright © 2021 mallasanticaidas.com<br/>
                                                            
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
                    $mensaje_enviado = $enviaMail->envia_Correos_inscripcion($data_post->email, $titulo2, $mensaje, $mail);
                    break;

                case 'selectEstado':
                    $objCliRedes = new ClientesRedes();
                    $datos_clientes = $objCliRedes->where("id_proyecto", "=", $data_post->id_proyecto)->get();


                    return view('web_redes/proyectos/proyectos_items', array(
                        "datos_clientes" => $datos_clientes
                    ));
                    break;

                case 'cambiaURLproyecto':
                    $objProyectosRedes = new ProyectosRedes();
                    $datos_estados = $objProyectosRedes
                        ->select("*")
                        ->from("proyectos_redes AS pr")
                        ->join("estados AS es", "pr.id_estado", "=", "es.idestado")
                        ->where("pr.id_proyecto", "=", $data_post->id_proyecto)
                        ->orderBy('es.estado', 'ASC')
                        ->first();

                    return view('web_redes/proyectos/url_item_proyectos', array(
                        "datos_estados" => $datos_estados
                    ));
                    break;

                default:
                    # code...
                    break;
            }
        }
    }

    /**
     * Procesa el cargo directo de Openpay para una cotización.
     */
    public function pagarCotizacionOpenpay(Request $request)
    {
        $id_cotizacion = (int) $request->input('id_cotizacion');
        $token_id = $request->input('token_id');
        $device_session_id = $request->input('device_session_id', '');

        if (!$id_cotizacion || !$token_id) {
            return response()->json([
                'success' => false,
                'message' => 'Faltan datos obligatorios para procesar la transacción.'
            ], 400);
        }

        $cotizacion = Cotizaciones::find($id_cotizacion);
        if (!$cotizacion) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la cotización especificada.'
            ], 404);
        }

        $cliente = Clientes::where('idcl', $cotizacion->id_cliente)->first();

        $nombreCliente = (!empty($cliente) && !empty(trim($cliente->nombrecl))) ? trim($cliente->nombrecl) : 'Cliente';
        $emailCliente = (!empty($cliente) && !empty(trim($cliente->emailcl))) ? trim($cliente->emailcl) : 'ventas@andamiosligeros.com';
        $telCliente = !empty($cliente) ? (!empty($cliente->telefonocl) ? $cliente->telefonocl : $cliente->celularcl) : '';

        try {
            $openpayService = new OpenpayService();

            $resCharge = $openpayService->createCardCharge([
                'token_id' => $token_id,
                'device_session_id' => $device_session_id,
                'monto' => (float) $cotizacion->total,
                'descripcion' => 'Cotización Andamios Ligeros #' . $cotizacion->cod_cotizacion,
                'order_id' => 'COT-' . $cotizacion->id_cotizacion,
                'redirect_url' => str_replace('http://', 'https://', route('pago.cotizacion.retorno', [
                    'id_cotizacion' => $cotizacion->id_cotizacion,
                    'gateway' => 'openpay'
                ])),
                'cliente_nombre' => $nombreCliente,
                'cliente_email' => $emailCliente,
                'cliente_telefono' => $telCliente,
            ]);

            if ($resCharge['success']) {
                $chargeData = $resCharge['data'];
                $txStatus = $chargeData['status'] ?? '';

                // Si requiere redirección 3D Secure
                if ($txStatus === 'charge_pending' && !empty($chargeData['payment_method']['url'])) {
                    return response()->json([
                        'success' => true,
                        'redirect_url' => $chargeData['payment_method']['url']
                    ]);
                }

                // Si fue aprobado directamente
                if ($txStatus === 'completed') {
                    $webhooksController = new WebhooksController();
                    $webhooksController->notificarCotizacionAprobada(
                        $cotizacion,
                        $chargeData['id'] ?? '',
                        'openpay_' . ($chargeData['method'] ?? 'card')
                    );

                    return response()->json([
                        'success' => true,
                        'redirect_url' => route('pago.cotizacion.retorno', [
                            'id_cotizacion' => $cotizacion->id_cotizacion,
                            'status' => 'success',
                            'gateway' => 'openpay'
                        ])
                    ]);
                }
            }

            \Log::error('Fallo al procesar cargo Openpay Cotización: ', $resCharge);
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
                $errorMsg = 'No se pudo completar el cobro con la tarjeta proporcionada. Intenta con otra tarjeta.';
            }

            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 422);

        } catch (\Exception $e) {
            \Log::error('Excepción al pagar cotización con Openpay: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado al procesar tu tarjeta. Por favor intenta nuevamente.'
            ], 500);
        }
    }
}
