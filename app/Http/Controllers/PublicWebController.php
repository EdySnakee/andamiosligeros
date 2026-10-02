<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Blog;
use App\ProductosTienda;
use App\OrdenesWeb;
use Redirect;
use App\Utilidades;
use PHPMailer\PHPMailer;
use App\Http\Requests;
use App\Clientes;
use App\PromocionesModel;
use App\OrdenesDetalle;
use App\OpenpayService;
use App\Http\Controllers\WebhooksController;


class PublicWebController extends Controller
{
    public function sitemap()
    {
        $Blog = Blog::all();
        $Promos = PromocionesModel::all();
        $Tienda = ProductosTienda::all();
        //print_r($Proyectos);
        return response()->view('web_andamios/xml/sitemap', compact('Blog', 'Promos', 'Tienda'))->header('Content-Type', 'text/xml');
    }
    public function feedAndamios()
    {
        $objProdTienda = new ProductosTienda();
        $Ptienda = $objProdTienda
            ->select("*")
            ->from("productos_tienda as PT")
            ->leftJoin("productos_tienda_detalle as PTD", "PT.id_product", "=", "PTD.id_product")
            ->whereIn("PT.categoria", ["accesorio", "andamio"])
            ->get();
            
        return response()
            ->view('web_andamios/feeds/andamiosxml', compact('Ptienda'))
            ->header('Content-Type', 'text/xml');
    }

    public function feedVallas()
    {
        $objProdTienda = new ProductosTienda();
        $Ptienda = $objProdTienda
            ->select("*")
            ->from("productos_tienda as PT")
            ->leftJoin("productos_tienda_detalle as PTD", "PT.id_product", "=", "PTD.id_product")
            ->whereIn("PT.categoria", ["vallas"])
            ->get();
            
        return response()
            ->view('web_andamios/feeds/vallasxml', compact('Ptienda'))
            ->header('Content-Type', 'text/xml');
    }

    public function feedOtros()
    {
        $objProdTienda = new ProductosTienda();
        $Ptienda = $objProdTienda
            ->select("*")
            ->from("productos_tienda as PT")
            ->leftJoin("productos_tienda_detalle as PTD", "PT.id_product", "=", "PTD.id_product")
            ->whereIn("PT.categoria", ["otros"])
            ->get();
            
        return response()
            ->view('web_andamios/feeds/otrosxml', compact('Ptienda'))
            ->header('Content-Type', 'text/xml');
    }

    public function feedAndamiosPromos()
    {
        $Ppromos = PromocionesModel::where('status', 1)->get();
        // dd($Ppromos);
        return response()->view('web_andamios/feeds/andamiospromosxml', compact('Ppromos'))->header('Content-Type', 'text/xml');
    }
    public function verTradicionales()
    {
        return view('web_andamios/productos/tradicional/tradicional');
    }
    public function verStp1()
    {
        return view('web_andamios/productos/tradicional/stp1/stp1');
    }
    public function verStp2()
    {
        return view('web_andamios/productos/tradicional/stp2/stp2');
    }
    public function verStp4()
    {
        return view('web_andamios/productos/tradicional/stp4/stp4');
    }
    public function verStp3()
    {
        return view('web_andamios/productos/tradicional/stp3/stp3');
    }
    public function verBanqueteros()
    {
        return view('web_andamios/productos/banqueteros/banqueteros');
    }
    public function verSbt1()
    {
        return view('web_andamios/productos/banqueteros/sbt1/sbt1');
    }
    public function verSbt2()
    {
        return view('web_andamios/productos/banqueteros/sbt2/sbt2');
    }
    public function verSbt5()
    {
        return view('web_andamios/productos/banqueteros/sbt5/sbt5');
    }
    public function verSbt6()
    {
        return view('web_andamios/productos/banqueteros/sbt6/sbt6');
    }
    public function verSbt8()
    {
        return view('web_andamios/productos/banqueteros/sbt8/sbt8');
    }
    public function verPlafoneros()
    {
        return view('web_andamios/productos/plafoneros/plafoneros');
    }
    public function verSpl1()
    {
        return view('web_andamios/productos/plafoneros/spl1/spl1');
    }
    public function verSpl2()
    {
        return view('web_andamios/productos/plafoneros/spl2/spl2');
    }
    public function verSpl3()
    {
        return view('web_andamios/productos/plafoneros/spl3/spl3');
    }
    public function verSpl4()
    {
        return view('web_andamios/productos/plafoneros/spl4/spl4');
    }
    public function verPasilleros()
    {
        return view('web_andamios/productos/pasilleros/pasilleros');
    }
    public function verSbt3()
    {
        return view('web_andamios/productos/pasilleros/sbt3/sbt3');
    }
    public function verSbt4()
    {
        return view('web_andamios/productos/pasilleros/sbt4/sbt4');
    }
    public function verPasarela()
    {
        return view('web_andamios/productos/pasarela/pasarela');
    }
    public function verDobles()
    {
        return view('web_andamios/productos/dobles/dobles');
    }
    public function verAltos()
    {
        return view('web_andamios/productos/altos/altos');
    }
    public function verLongitudinal()
    {
        return view('web_andamios/productos/longitudinal/longitudinal');
    }
    public function verAccesorios()
    {
        $objProductosTienda = new ProductosTienda();
        $catProductos = $objProductosTienda
            ->select('*')
            ->from('productos_tienda as PT')
            ->Leftjoin('productos_tienda_detalle as PTD',  'PT.id_product', '=', 'PTD.id_product')
            ->where('PT.post_estatus', 1)
            ->where('PT.categoria', 'accesorio')
            ->get();

        return view('web_andamios/productos/accesorios/accesorios', compact('catProductos'));
    }

    public function verVallas()
    {
        return view('web_andamios/productos/vallas/vallas');
    }

    public function verEscenarios()
    {
        return view('web_andamios/productos/escenarios/escenarios');
    }

    // LANDINGS
    public function landing()
    {
        return view('web_andamios/landing/landing');
    }

    public function verBlog(Request $request)
    {
        $objBlog = new Blog();
        $info_blog = $objBlog
            ->where("post_estatus", "=", "activo")
            ->orderBy('post_fecha', 'DESC')
            ->get();
        return view('web_andamios/blog/blog', array(
            "info_blog" => $info_blog
        ));
    }
    public function verDetalleBlog(Request $request)
    {
        $ObjBlog = Blog::where("post_url", $request->url_blog)->first();
        if (!empty($ObjBlog->id_blog) and $ObjBlog->post_estatus == "activo") {
            $urlBlog = $ObjBlog->post_url;
            if (!empty($urlBlog) == $request->url_blog) {
                $objBlog = new Blog();
                $objProductos = new ProductosTienda();
                $info_blog = $objBlog
                    ->where("post_estatus", "=", "activo")
                    ->orderBy('post_fecha', 'DESC')
                    ->limit(5)
                    ->get();

                $productosTienda = $objProductos
                    ->select('*')
                    ->from('productos_tienda as PT')
                    ->Leftjoin('productos_tienda_detalle as PTD',  'PT.id_product', '=', 'PTD.id_product')
                    ->where('PT.post_estatus', 1)
                    ->orderBy('PT.estrella', 'DESC')
                    ->orderBy('PT.categoria', 'DESC')
                    ->limit(3)
                    ->get();

                return view('web_andamios/blog/detalle_blog/detalle_blog', array(
                    "ObjBlog" => $ObjBlog,
                    "info_blog" => $info_blog,
                    "productosTienda" => $productosTienda
                ));
            } else {
                echo "No existen registros en base de datos";
            }
        } else {
            return Redirect::to('/');
        }
    }

    public function verPromociones()
    {
        $objPromos = new PromocionesModel();
        $items_promos = $objPromos->orderBy('status', 'ASC')->orderBy('orden', 'ASC')->where('tipo_promo', 'normal')->get();
        return view('web_andamios/listado_promos/listado_promos', compact('items_promos'));
    }
    public function verPromoBuenFin()
    {
        $objPromos = new PromocionesModel();
        $items_promos = $objPromos->orderBy('orden', 'DESC')->where('tipo_promo', 'buen_fin')->get();
        return view('web_andamios/buen_fin_2023/buen_fin', compact('items_promos'));
    }
    public function verDetallePromo(Request $request)
    {

        $objPromos = new PromocionesModel();
        $item_promo = $objPromos->where("url_promo", $request->url_promo)->first();

        if (!empty($item_promo)) {
            //dd($item_promo->img_social);
            $img_barra_pago = $item_promo->img_barra_pago;
            $img_banner = $item_promo->img_banner;
            $img_social = $item_promo->img_banner;
            $costo_item = $item_promo->costo_item; //PRECIO PRODUCTO
            $costo_desc = $item_promo->costo_desc; //PRECIO PROMO
            $costo_envio = $item_promo->envio; //PRECIO ENVIO
            $fondo_promo = "";
            $descripcion = $item_promo->descripcion;
            $cantidad = 1; //CANTIDAD INICIAL
            $cant_min =  (!empty($item_promo->cant_min)) ? $item_promo->cant_min : 0; //CANTIDAD INICIAL
            $nombre_product = $item_promo->nombre_product; //NOMBRE PRODUCTO
            $meta_titulo = $item_promo->meta_titulo;
            return view('web_andamios/promo/promo', compact('item_promo', 'costo_desc', 'cant_min', 'descripcion', 'fondo_promo', 'costo_item', 'costo_envio', 'cantidad', 'nombre_product', 'img_barra_pago', "img_banner", "img_social", "meta_titulo"));
        } else {
            return Redirect::to('/promociones');
        }
    }
    public function verDetallePromoTest(Request $request)
    {

        $objPromos = new PromocionesModel();
        $item_promo = $objPromos->where("url_promo", $request->url_promo)->first();

        if (!empty($item_promo)) {
            //dd($item_promo->img_social);
            $img_barra_pago = $item_promo->img_barra_pago;
            $img_banner = $item_promo->img_banner;
            $img_social = $item_promo->img_banner;
            $costo_item = $item_promo->costo_item; //PRECIO PRODUCTO
            $costo_desc = $item_promo->costo_desc; //PRECIO PROMO
            $costo_envio = $item_promo->envio; //PRECIO ENVIO
            $fondo_promo = "";
            $descripcion = $item_promo->descripcion;
            $cantidad = 1; //CANTIDAD INICIAL
            $cant_min =  (!empty($item_promo->cant_min)) ? $item_promo->cant_min : 0; //CANTIDAD INICIAL
            $nombre_product = $item_promo->nombre_product; //NOMBRE PRODUCTO
            $meta_titulo = $item_promo->meta_titulo;

            return view('web_andamios/promo_test/promo', compact('item_promo', 'costo_desc', 'cant_min', 'descripcion', 'fondo_promo', 'costo_item', 'costo_envio', 'cantidad', 'nombre_product', 'img_barra_pago', "img_banner", "img_social", "meta_titulo"));
        } else {
            return Redirect::to('/promociones');
        }
    }

    public function ajax_web(Request $request)
    {
        $data_post = new \stdClass();
        if (!empty($request->datos)) {
            $data_post = json_decode(json_encode($request->datos));
        }
        if (!empty($request->accion)) {
            switch ($request->accion) {
                case 'enviaFormulario':
                    $mail = new PHPMailer\PHPMailer();
                    $enviaMail = new Utilidades();
                    $mensaje_cliente = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Contacto Cliente</title>
                    </head>
                    <body>
                    <strong>CONTACTO DESDE : </strong>' . $data_post->url_contacto . '<br>
                    <strong>Nombre : </strong>' . $data_post->name . '<br>
                    <strong>Email : </strong>' . $data_post->email . '<br>
                    <strong>Tel��fono : </strong>' . $data_post->telefono . '<br>
                    <strong>Celular: </strong>' . $data_post->celular . '<br>
                    <strong>Mensaje : </strong>' . $data_post->message . '<br>
                    </body>
                    </html>
                    ';
                    $mail->FromName = "Andamios Ligeros";
                    $titulo = "Contacto desde andamiosligeros.com";
                    $correo_agente = "ventas@andamiosligeros.com";
                    echo $mensaje_enviado = $enviaMail->envia_Correos($correo_agente, $titulo, $mensaje_cliente, $mail);

                    $titulo2 = $data_post->name . " gracias por contactarnos";
                    $mensaje = '
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Bienenido a Andamios Ligeros</title>
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
                                                            <b><p>Hola, ' . $data_post->name . '</p></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            <p style="text-align: justify;">�1�70�1�73Gracias por contactarnos! en este momento estamos revisando la informaci�1�7�1�7n que nos proporcion�1�7�1�7 para poder ofrecerle una cotizaci�1�7�1�7n personalizada con las especificaciones que requiere.</p>
                                                            
                                                            <p style="text-align: justify;">�1�70�1�73Felicidades! Te regalamos un descuento de $500.00MXN en tu primera compra.</p>
                                                            <p style="text-align: justify;"> <a href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20Soy%20' . $data_post->name . '%20y%20quiero%20aprovechar%20mi%20cup�1�7�1�7n%20de%20500.00%20pesos" target="_blank">Click aqu�1�7�1�7 para obtener el beneficio �1�79�1�76</a> </p>
                                                            <p style="text-align: justify;"><small><b>* No aplica con otras promociones. * Vigencia 5 d�1�7�1�7as</b></small></p>
                                                            
                                                            <p style="text-align: justify;">Es importante que este enterado que cuenta con la confidencialidad de sus datos proporcionados, los cuales ser�1�7�1�7n utilizados �1�7�1�7nica y exclusivamente para poder darle informaci�1�7�1�7n sobre nuestros productos y posibles futuras promociones.</p>
                                                            <p style="text-align: justify;">Si quisiera brindarnos alguna informaci�1�7�1�7n posterior o su cotizaci�1�7�1�7n no puede esperar, tambi�1�7�1�7n puede comunicarse sin compromiso con alguno de nuestros asesores marcando al 999 646 1314.</p>
                                                                
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
                                                            &reg; Copyright �1�70�1�78 2022 andamiosligeros.com<web/img/>
                                                            
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
                    $mensaje_enviado = $enviaMail->envia_Correos($data_post->email, $titulo2, $mensaje, $mail);
                    break;
                case 'enviaCotizacion':
                    $mail = new PHPMailer\PHPMailer();
                    $enviaMail = new Utilidades();
                    $mensaje_cliente = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Cotizaci��n Cliente</title>
                    </head>
                    <body>
                    <strong>COTIZACI�0�7N DESDE : </strong>' . $data_post->url_contacto . '<br>
                    <strong>Nombre : </strong>' . $data_post->name . '<br>
                    <strong>Producto seleccionado: </strong>' . $data_post->andamio_interes . '<br>
                    <strong>Email : </strong>' . $data_post->email . '<br>
                    <strong>Celular: </strong>' . $data_post->celular . '<br>
                    <strong>Mensaje : </strong>' . $data_post->message . '<br>
                    </body>
                    </html>
                    ';
                    $mail->FromName = "Andamios Ligeros";
                    $titulo = "Cotizaci��n desde andamiosligeros.com";
                    $correo_agente = "ventas@andamiosligeros.com";
                    echo $mensaje_enviado = $enviaMail->envia_Correos($correo_agente, $titulo, $mensaje_cliente, $mail);

                    $titulo2 = $data_post->name . " gracias por contactarnos";
                    $mensaje = '
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Bienenido a Andamios Ligeros</title>
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
                                                            <b><p>Hola, ' . $data_post->name . '</p></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            <p style="text-align: justify;">�1�70�1�73Gracias por contactarnos! en este momento estamos revisando la informaci�1�7�1�7n que nos proporcion�1�7�1�7 para poder ofrecerle una cotizaci�1�7�1�7n personalizada con las especificaciones que requiere.</p>

                                                            <p style="text-align: justify;">�1�70�1�73Felicidades! Te regalamos un descuento de $500.00MXN en tu primera compra.</p>
                                                            <p style="text-align: justify;"> <a href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20Soy%20' . $data_post->name . '%20y%20quiero%20aprovechar%20mi%20cup�1�7�1�7n%20de%20500.00%20pesos" target="_blank">Click aqu�1�7�1�7 para obtener el beneficio �1�79�1�76</a> </p>
                                                            <p style="text-align: justify;"><small><b>* No aplica con otras promociones. * Vigencia 5 d�1�7�1�7as</b></small></p>

                                                            <p style="text-align: justify;">Es importante que este enterado que cuenta con la confidencialidad de sus datos proporcionados, los cuales ser�1�7�1�7n utilizados �1�7�1�7nica y exclusivamente para poder darle informaci�1�7�1�7n sobre nuestros productos y posibles futuras promociones.</p>
                                                            <p style="text-align: justify;">Si quisiera brindarnos alguna informaci�1�7�1�7n posterior o su cotizaci�1�7�1�7n no puede esperar, tambi�1�7�1�7n puede comunicarse sin compromiso con alguno de nuestros asesores marcando al 999 646 1314.</p>
                                                                
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
                                                            &reg; Copyright �1�70�1�78 2022 andamiosligeros.com<web/img/>
                                                            
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
                    $mensaje_enviado = $enviaMail->envia_Correos($data_post->email, $titulo2, $mensaje, $mail);
                    break;
                case 'enviaFicha':
                    $mail = new PHPMailer\PHPMailer();
                    $enviaMail = new Utilidades();
                    $mensaje_cliente = '
                    <!DOCTYPE html>
                    <html>
                    <head>
                    <meta charset="utf-8">
                    <meta http-equiv="X-UA-Compatible" content="IE=edge">
                    <title>Cliente descarga ficha T��cnica</title>
                    </head>
                    <body>
                    <strong>COTIZACI�0�7N DESDE : </strong>' . $data_post->url_contacto . '<br>
                    <strong>Nombre : </strong>' . $data_post->name . '<br>
                    <strong>Email : </strong>' . $data_post->email . '<br>
                    <strong>Celular: </strong>' . $data_post->celular . '<br>
                    </body>
                    </html>
                    ';
                    $mail->FromName = "Andamios Ligeros";
                    $titulo = "Cotizaci��n desde andamiosligeros.com";
                    $correo_agente = "ventas@andamiosligeros.com";
                    echo $mensaje_enviado = $enviaMail->envia_Correos($correo_agente, $titulo, $mensaje_cliente, $mail);

                    $titulo2 = "Hola" . $data_post->name . ", aqu�1�7�1�7 puedes descargar la ficha t�1�7�1�7cnica";
                    $mensaje = '
                    <html xmlns="http://www.w3.org/1999/xhtml">
                    <head>
                        <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
                        <title>Bienenido a Andamios Ligeros</title>
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
                                                            <b><p>Hola, ' . $data_post->name . '</p></b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="padding: 20px 0 30px 0; color: #153643; font-family: Arial, sans-serif; font-size: 16px; line-height: 20px;">
                                                            <p style="text-align: justify;">Estimado cliente en el siguiente enlace podr�1�7�1�7 descargar la ficha t�1�7�1�7cnica solicitada</p>
                                                            <p><a style="text-align: justify; background: #0648d6; color: white; padding: 5px 10px;" target="_blank" href="https://andamiosligeros.com/fichas_tecnicas/' . $data_post->ficha_andamio . '">Descargar Ficha T�1�7�1�7cnica</a></p>
                                                            
                                                            <p style="text-align: justify;">�1�70�1�73Felicidades! Te regalamos un descuento de $500.00MXN en tu primera compra.</p>
                                                            <p style="text-align: justify;"> <a href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20Soy%20' . $data_post->name . '%20y%20quiero%20aprovechar%20mi%20cup�1�7�1�7n%20de%20500.00%20pesos" target="_blank">Click aqu�1�7�1�7 para obtener el beneficio �1�79�1�76</a> </p>
                                                            <p style="text-align: justify;"><small><b>* No aplica con otras promociones. * Vigencia 5 d�1�7�1�7as</b></small></p>

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
                                                            &reg; Copyright �1�70�1�78 2022 andamiosligeros.com<web/img/>
                                                            
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
                    $mensaje_enviado = $enviaMail->envia_Correos($data_post->email, $titulo2, $mensaje, $mail);
                    break;
                case 'activaMercadoPago':

                    $datos_factura = !empty($data_post->datos_factura) ? $data_post->datos_factura : '';
                    $datos_cliente = Clientes::validaCliente($data_post);
                    //dd($datos_cliente->nombrecl);

                    if (empty($datos_cliente)) {
                        $datos_cliente = Clientes::postClienteWeb($data_post);
                    }

                    $req_mp = "";
                    $status_accion = "confirma_pedido";
                    $status_orden = 0;

                    $cantidad = (int) $data_post->cantidad;
                    $envio = (float) $data_post->envio;
                    $costo_item = (float) $data_post->costo_articulo; // Precio unitario real del producto (sin envío)
                    $nombre_product = $data_post->nombre_product;

                    $subtotal_orden = $cantidad * $costo_item; // Subtotal únicamente de productos
                    $total_envio = $cantidad * $envio;
                    $subtotal_con_envio = $subtotal_orden + $total_envio;

                    $requiere_iva = (!empty($data_post->iva) && ($data_post->iva === 'si' || $data_post->iva === 'on'));

                    if ($requiere_iva) {
                        $iva = round($subtotal_con_envio * 0.16, 2);
                        $total_final = $subtotal_con_envio + $iva;
                    } else {
                        $iva = 0.0;
                        $total_final = $subtotal_con_envio;
                    }

                    $datos_orden = OrdenesWeb::postOrden(
                        $req_mp,
                        $data_post,
                        $datos_cliente,
                        $subtotal_orden,
                        $costo_item,
                        $status_accion,
                        $status_orden,
                        $iva,
                        $total_final
                    );

                    // Registrar detalle del producto de la promoción para historial y notificaciones con su precio real
                    $item_detalle = [
                        [
                            'cantidad' => $cantidad,
                            'titulo' => $nombre_product,
                            'precio' => $costo_item,
                        ]
                    ];
                    OrdenesDetalle::postDetalleOrden($datos_orden, $item_detalle);

                    return view('web_andamios/barra_pago/funcion_mp', compact('costo_item', 'envio', 'total_envio', 'iva', 'cantidad', 'nombre_product', 'datos_factura', 'datos_orden', 'datos_cliente'));
                    break;
            }
        }
    }

    /**
     * Procesa el cargo directo de Openpay para una orden generada en promociones.
     */
    public function pagarPromoOpenpay(Request $request)
    {
        $id_orden = (int) $request->input('id_orden');
        $token_id = $request->input('token_id');
        $device_session_id = $request->input('device_session_id', '');

        if (!$id_orden || !$token_id) {
            return response()->json([
                'success' => false,
                'message' => 'Faltan datos obligatorios para procesar la transacción.'
            ], 400);
        }

        $orden = OrdenesWeb::find($id_orden);
        if (!$orden) {
            return response()->json([
                'success' => false,
                'message' => 'No se encontró la orden especificada.'
            ], 404);
        }

        $cliente = Clientes::find($orden->idcl);

        try {
            $openpayService = new OpenpayService();

            $resCharge = $openpayService->createCardCharge([
                'token_id' => $token_id,
                'device_session_id' => $device_session_id,
                'monto' => $orden->total,
                'descripcion' => 'Promoción Andamios Ligeros #' . $orden->id_orden,
                'order_id' => 'AL-' . $orden->id_orden,
                'redirect_url' => route('pago_tienda_online', [
                    'id_orden' => $orden->id_orden,
                    'gateway' => 'openpay'
                ]),
                'cliente_nombre' => $cliente ? $cliente->nombrecl : 'Cliente',
                'cliente_email' => $cliente ? $cliente->emailcl : 'contacto@andamiosligeros.com',
                'cliente_telefono' => $cliente ? ($cliente->telefonocl ?: $cliente->celularcl) : '',
            ]);

            if ($resCharge['success']) {
                $chargeData = $resCharge['data'];
                $txStatus = $chargeData['status'] ?? '';

                $orden->mp_payment_id = $chargeData['id'] ?? '';
                $orden->mp_payment_type = 'openpay_' . ($chargeData['method'] ?? 'card');

                // Si requiere redirección 3D Secure
                if ($txStatus === 'charge_pending' && !empty($chargeData['payment_method']['url'])) {
                    $orden->mp_status = 'pending';
                    $orden->status_orden = 9;
                    $orden->save();

                    return response()->json([
                        'success' => true,
                        'redirect_url' => $chargeData['payment_method']['url']
                    ]);
                }

                // Si fue aprobado directamente
                if ($txStatus === 'completed') {
                    $orden->mp_status = 'approved';
                    $orden->status_orden = 1;
                    $orden->mp_fecha_post = date('Y-m-d H:i:s');
                    $orden->save();

                    $webhooksController = new WebhooksController();
                    $webhooksController->notificarOrdenAprobada($orden);

                    return response()->json([
                        'success' => true,
                        'redirect_url' => route('pago_tienda_online', [
                            'id_orden' => $orden->id_orden,
                            'gateway' => 'openpay'
                        ])
                    ]);
                }
            }

            \Log::error('Fallo al procesar cargo Openpay Promo: ', $resCharge);
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

            return response()->json([
                'success' => false,
                'message' => $errorMsg
            ], 400);

        } catch (\Exception $e) {
            \Log::error('Excepción al procesar pago Openpay en Promo: ' . $e->getMessage());
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error inesperado al procesar el pago. Por favor intenta más tarde.'
            ], 500);
        }
    }
}
