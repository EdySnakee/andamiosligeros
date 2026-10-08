<?php

use Illuminate\Http\Request;
use App\catalogoModelos;
use App\FacebookApi;
/*
use App\ProyectosRedes;
use App\ClientesRedes;
use App\Estados;
use App\FacebookApi;
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It's a breeze. Simply tell Laravel the URIs it should respond to
| and give it the controller to call when that URI is requested.
|
*/


/*
Route::get('/proyectos/{url_proyectos}', [
        'uses' => 'PublicWebController@verProyectosRedes',
        'as' => 'web_proyectos_redes',
    ]
);
*/

/*
Route::get('/obras/{url_cliente}', [
        'uses' => 'PublicWebController@verObrasRedes',
        'as' => 'web_obras_redes',
    ]
);

*/


Route::get(
    '/proyectos/{url_proyectos}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verProyectosRedes',
        'as' => 'web_proyectos_redes',
    ]
);
/*inicio ver cotizaciones web*/
Route::get(
    '/cotizaciones/redes-anticaidas/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_redes',
    ]
);
Route::get(
    '/cotizaciones/redes-perimetrales/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_redes_p',
    ]
);
Route::get(
    '/cotizaciones/score-gol/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_scoregol',
    ]
);
Route::get(
    '/cotizaciones/andamios-ligeros/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_ligeros',
    ]
);
/*fin ver cotizaciones web*/

/*inicio ver ventas web*/
Route::get(
    '/ventas/redes-anticaidas/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verVentaClienteRedesAnticaidas',
        'as' => 'web_ventas_redes',
    ]
);
Route::get(
    '/ventas/redes-perimetrales/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verVentaClienteRedesAnticaidas',
        'as' => 'web_ventas_redes_p',
    ]
);
Route::get(
    '/ventas/score-gol/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verVentaClienteRedesAnticaidas',
        'as' => 'web_ventas_scoregol',
    ]
);
Route::get(
    '/ventas/andamios-ligeros/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@verVentaClienteRedesAnticaidas',
        'as' => 'web_ventas_ligeros',
    ]
);
Route::get(
    'webhooks/{id_coti}/{info_order}',
    [
        'uses' => 'WebhooksController@notificaPago',
        'as' => 'webhooks_post',
    ]
);
Route::get(
    'webhooks_promo/pay',
    [
        'uses' => 'WebhooksController@notificaPagoEnWeb',
        'as' => 'webhooks_post_web',
    ]
);
Route::get(
    '/status_venta',
    [
        'uses' => 'WebhooksController@statusVenta',
        'as' => 'status_vta',
    ]
);

Route::get('/pago-cotizacion-retorno', [
    'uses' => 'WebhooksController@pagoCotizacionRetorno',
    'as' => 'pago.cotizacion.retorno',
]);

/*fin ver ventas web*/
Route::get(
    '/pdf/redes-anticaidas/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_redes',
    ]
);
Route::get(
    '/pdf/score-gol/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_sgol',
    ]
);

Route::get(
    '/pdf/andamios-ligeros/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_al',
    ]
);

Route::get(
    '/pdf/redes-perimetrales/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfCotizacionClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_rp',
    ]
);

/*RUTA PDFS VENTAS*/

Route::get(
    '/pdfv/redes-anticaidas/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfVentaClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_redes',
    ]
);
Route::get(
    '/pdfv/score-gol/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfVentaClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_sgol',
    ]
);

Route::get(
    '/pdfv/andamios-ligeros/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfVentaClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_al',
    ]
);

Route::get(
    '/pdfv/redes-perimetrales/{ruta_encrypt}',
    [
        'uses' => 'WebProyectosRedesAnticaidasController@generaPdfVentaClienteRedesAnticaidas',
        'as' => 'web_cotizaciones_pdf_rp',
    ]
);

/************AQUI EMPIEZA EL ADMIN**************/

Route::post(
    'sb-admin/ajax_utilidades',
    [
        'uses' => 'RedesAnticaidasUtilidadesController@ajax_utilidades',
        'as' => 'ajax_utilidades_path',
    ]
);



Route::group(['middleware' => ['web']], function () {
    Route::auth();
    Route::get('/inicio', 'HomeController@index');
    Route::get('/register', function () {
        return Redirect::to('login');
        //return view('auth/register');
    });
    Route::post('/register', function () {
        return Redirect::to('login');
        //return view('auth/register');
    });

    Route::get('/ordenes-taller', [
        'uses' => 'TallerController@listadoOrdenesPublico',
        'as' => 'app_ordenes_taller_publico',
    ]);

    require_once('rutas/rutaModulos.php');

    Route::get('/', function () {
        if (!empty(Auth::User()->email)) {
            return Redirect::to('sb-admin/dashboard');
        } else {

            $evento = 'ViewContent';
            $host = $_SERVER["HTTP_HOST"];
            $url = $_SERVER["REQUEST_URI"];
            $url_actual = "https://" . $host . $url;

            //$envia_eventos = new FacebookApi();
            //$respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual);

            //echo "<pre>";
            //print_r($respuesta_fb);
            //echo "</pre>";
            /*
            $objCliRedes = new ClientesRedes();
            $datos_clientes = $objCliRedes
                ->select("*")
                ->from("clientesredes AS cr")
                ->join("proyectos_redes AS pr", "pr.id_proyecto", "=", "cr.id_proyecto")
                ->join("estados AS es", "pr.id_estado", "=", "es.idestado")
                ->inRandomOrder()
                ->limit(5)
                ->get();
            */
            //print_r($datos_clientes);

            return view('web_andamios/index/index');
        }
    });
});


/****RUTAS WEB****/
Route::get('/andamios-ligeros-galvanizados-en-merida', function () {
    $location = "Mérida";
    return view('web_andamios/andamios_ubicacion/andamios', compact("location"));
});
/*TRADICIONALES*/
Route::get('/andamios-ligeros-galvanizados-tradicionales-estandar', 'PublicWebController@verTradicionales')->name('web_tradicionales');
Route::get('/andamios-ligeros-galvanizados-tradicionales-5-peldanos-STP1', 'PublicWebController@verStp1')->name('web_stp1');
Route::get('/andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP2', 'PublicWebController@verStp2')->name('web_stp2');
Route::get('/andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP4', 'PublicWebController@verStp4')->name('web_stp4');
Route::get('/andamios-ligeros-galvanizados-tradicionales-4-peldanos-STP3', 'PublicWebController@verStp3')->name('web_stp3');

/*BANQUETEROS*/
Route::get('/andamios-ligeros-galvanizados-baqueteros', 'PublicWebController@verBanqueteros')->name('web_banqueteros');
Route::get('/andamios-ligeros-galvanizados-baqueteros-5-peldanos-SBT1', 'PublicWebController@verSbt1')->name('web_sbt1');
Route::get('/andamios-ligeros-galvanizados-baqueteros-4-peldanos-SBT2', 'PublicWebController@verSbt2')->name('web_sbt2');
Route::get('/andamios-ligeros-galvanizados-baqueteros-SBT4', function () {
    return view('web_andamios/productos/banqueteros/sbt4/sbt4');
});
Route::get('/andamios-ligeros-galvanizados-baqueteros-3-metros-SBT5', 'PublicWebController@verSbt5')->name('web_sbt5');
Route::get('/andamios-plegables-multiusos-galvanizados', 'PublicWebController@verSbt6')->name('web_sbt6');
Route::get('/andamios-ligeros-plegables-multiusos-galvanizados-sbt-8', 'PublicWebController@verSbt8')->name('web_sbt8');
/*PLAFONEROS*/
Route::get('/andamios-ligeros-galvanizados-plafoneros', 'PublicWebController@verPlafoneros')->name('web_plafoneros');
Route::get('/andamios-ligeros-galvanizados-plafoneros-barandal-SPL1', 'PublicWebController@verSpl1')->name('web_spl1');
Route::get('/andamios-ligeros-galvanizados-plafoneros-barandal-SPL2', 'PublicWebController@verSpl2')->name('web_spl2');
Route::get('/andamios-ligeros-galvanizados-plafoneros-barandal-SPL-3', 'PublicWebController@verSpl3')->name('web_spl3');
Route::get('/andamios-ligeros-galvanizados-plafoneros-barandal-SPL-4', 'PublicWebController@verSpl4')->name('web_spl4');


/*PASILLEROS*/
Route::get('/andamios-ligeros-galvanizados-pasilleros', 'PublicWebController@verPasilleros')->name('web_pasilleros');
Route::get('/andamios-ligeros-galvanizados-pasilleros-5-peldanos-SBT3', 'PublicWebController@verSbt3')->name('web_sbt3');
Route::get('/andamios-ligeros-galvanizados-pasilleros-4-peldanos-SBT4', 'PublicWebController@verSbt4')->name('web_sbt4');

/* LANDINGS */
Route::get('/andamio-ligero-plegable-sbt-10-landing', 'PublicWebController@landing')->name('landing');

/*PASERALA*/
Route::get('/andamios-ligeros-galvanizados-pasarela', 'PublicWebController@verPasarela')->name('web_pasarela');

/*DOBLES*/
Route::get('/andamios-ligeros-galvanizados-dobles', 'PublicWebController@verDobles')->name('web_dobles');

/*ALTOS*/
Route::get('/andamios-ligeros-galvanizados-altos', 'PublicWebController@verAltos')->name('web_altos');

/*LONGITUDINAL*/
Route::get('/andamios-ligeros-galvanizados-longitudinales-4-peldanos-SLT2', 'PublicWebController@verLongitudinal')->name('web_longitudinal');

/*ACCESORIOS*/
Route::get('/accesorios-para-andamios-ligeros-galvanizados', 'PublicWebController@verAccesorios')->name('web_accesorios');

/*VALLAS*/
Route::get('/vallas-metalicas-galvanizadas', 'PublicWebController@verVallas')->name('web_vallas');

/*ESCENARIOS*/
Route::get('/escenarios-para-eventos', 'PublicWebController@verEscenarios')->name('web_escenarios');

/*PROMOCION NOVIEMBRE*/
//Route::get('/promocion-andamio-plegable-noviembre-2022', 'PublicWebController@verPromo')->name('web_promo');
Route::get('/promocion-buen-fin-andamio-plegable-noviembre-2022', function () {
    return Redirect::route('web_promos');
});
Route::get('/promocion-buen-fin-andamio-banquetero-noviembre-2022', function () {
    return Redirect::route('web_promos');
});
Route::get('/promocion-mundialista-andamio-plegable', function () {
    return Redirect::route('web_promos');
});
Route::get('/promocion-de-navidad-2022-andamio-plegable', function () {
    return Redirect::route('web_promos');
});
Route::get('/andamio-ligero-banquetero-sbt4-precio-de-introduccion', function () {
    return Redirect::route('web_promos');
});
Route::get('/promocion-andamio-plegable-2500', function () {
    return Redirect::route('web_promos');
});
Route::get('/promocion-andamio-plegable-dia-del-albanene', function () {
    return Redirect::route('web_promos');
});
//URLS ACTIVAS AL 08/12/2022
Route::get(
    '/promociones',
    [
        'uses' => 'PublicWebController@verPromociones',
        'as' => 'web_promos',
    ]
);
Route::get(
    '/promociones/{url_promo}',
    [
        'uses' => 'PublicWebController@verDetallePromo',
        'as' => 'web_promo_redes',
    ]
);

Route::get(
    '/promociones_test/{url_promo}',
    [
        'uses' => 'PublicWebController@verDetallePromoTest',
        'as' => 'web_promo_redes',
    ]
);
/* PROMO 2023 BUEN FIN*/

Route::get(
    '/promociones-buen-fin-2023',
    [
        'uses' => 'PublicWebController@verPromoBuenFin',
        'as' => 'web_promos_bf',
    ]
);

//ENVÍOS PAQUETEXPRESS
Route::get('/envios-paquetexpress', function () {
    return view('web_andamios/envios_paquetexpress/envios_paquetexpress');
});

Route::get('/promocion-andamio-ligero-plegable-sbt6', function () {
    return Redirect::to('/promociones');
});
Route::get('/promocion-del-mes-andamio-plegable', function () {
    return Redirect::to('/promociones');
});
Route::get('/promocion-andamio-ligero-banquetero-sbt4', function () {
    return Redirect::to('/promociones');
});
Route::get('/promocion-andamio-ligero-tradicional-stp-4', function () {
    return Redirect::to('/promociones');
});

Route::get('/promocion-hot-sale-plataformas', function () {
    return Redirect::to('/promociones');
});


Route::get('/cuentas-oficiales', function () {
    return view('web_andamios/cuentas/cuentas');
});

Route::get('/thank-you', function () {
    return view('web_andamios/thank-youy/thank-youy');
});
Route::get('/thank-you-descarga', function () {
    return view('web_andamios/thank-youy/thank-youy-descarga');
});


// Formulario de distribuidor

Route::get('/formulario-distribuidor', function () {
    return view('web_andamios/formulario_og/formulario_og');
});


/* MEMORIAS DE CALCULO */
Route::get('/memoria-de-calculo-stp2', function () {
    return view('web_andamios/memorias_de_calculo/sbt2');
});
Route::get('/memoria-de-calculo-sbt4', function () {
    return view('web_andamios/memorias_de_calculo/sbt4');
});
Route::get('/memoria-de-calculo-sbt6', function () {
    return view('web_andamios/memorias_de_calculo/sbt6');
});


Route::get(
    'blog/',
    [
        'uses' => 'PublicWebController@verBlog',
        'as' => 'web_blog',
    ]
);

Route::get(
    '/blog/{url_blog}',
    [
        'uses' => 'PublicWebController@verDetalleBlog',
        'as' => 'web_blog_redes',
    ]
);

Route::post(
    'ajax_web',
    [
        'uses' => 'PublicWebController@ajax_web',
        'as' => 'path_ajax_web',
    ]
);

/*TIENDA EN LINEA RUTAS WEB*/
Route::get('/tienda-de-andamios-ligeros-galvanizados', function () {
    return Redirect::to('/tienda');
});

Route::get('/tienda', function () {
    $evento = "PageView";
    $host = $_SERVER["HTTP_HOST"];
    $url = $_SERVER["REQUEST_URI"];
    $url_actual = "https://" . $host . $url;
    $em = "";
    $ph = "";
    $content_name = "";
    $value = "";
    $envia_eventos = new FacebookApi();
    $respuesta_fb = $envia_eventos->FacebookApiModel($evento, $url_actual, $em, $ph, $content_name, $value);

    $catModelos = catalogoModelos::all();
    return view('web_andamios/tienda/tienda', compact('catModelos'));
});

Route::get('tienda/carrito', 'CartWebController@showCart')->name('ver_carrito');
Route::get('/minicart', 'CartWebController@miniCart');
Route::get('/aumentar_cantidad_producto', 'CartWebController@aumentarCantidadProducto');
Route::get('/add_to_cart', 'CartWebController@addToCart')->name('post_carrito');
Route::post('/clear', 'CartWebController@clearCart')->name('clear_carrito');
Route::get('/remove', 'CartWebController@removeCart')->name('remove_carrito');
Route::post('/checkout', 'CartWebController@checkout')->name('checkout');

// 1. RUTA DE RETORNO (BACK URL)
// Esta es la ruta a la que Mercado Pago redirecciona al cliente después de pagar.
Route::get('/pago-tienda-online', 'WebhooksController@pagoTiendaOnline')->name('pago_tienda_online');

// 2. RUTA DEL WEBHOOK RECEPTOR (EL NUEVO ENDPOINT)
// Esta es la ruta que recibe el POST reenviado desde Scoregol.
Route::post('/webhooks/actualiza-orden', 'WebhooksController@actualizaOrdenWebhook');

// 3. RUTA DEL WEBHOOK DE OPENPAY
Route::post('/openpay/webhook', 'WebhooksController@webhookOpenpay')->name('openpay_webhook');
Route::get('/openpay/codigo-verificacion', 'WebhooksController@obtenerCodigoVerificacionOpenpay')->name('openpay_codigo_verificacion');

// 4. RUTA DE PAGO OPENPAY PARA PROMOCIONES
Route::post('/promociones/pagar-openpay', 'PublicWebController@pagarPromoOpenpay')->name('openpay_pagar_promo');

// 5. RUTA DE PAGO OPENPAY PARA COTIZACIONES
Route::post('/cotizaciones/pagar-openpay', 'WebProyectosRedesAnticaidasController@pagarCotizacionOpenpay')->name('openpay_pagar_cotizacion');


// Comprar en landing
Route::get('/comprarAhora', 'CartWebController@comprarAhora')->name('comprar_ahora');

Route::get(
    '/tienda/{url_product}',
    [
        'uses' => 'CartWebController@verDetalleProduct',
        'as' => 'web_producto',
    ]
);

Route::post(
    'ajax_tienda_web',
    [
        'uses' => 'CartWebController@ajax_tienda_web',
        'as' => 'path_ajax_tienda_web',
    ]
);

Route::get('/sitemap.xml', 'PublicWebController@sitemap')->name('site_map');
Route::get('/FeedAndamiosXML.xml', 'PublicWebController@feedAndamios')->name('feed_andamios');
Route::get('/FeedVallasXML.xml', 'PublicWebController@feedVallas')->name('feed_vallas');
Route::get('/FeedOtrosXML.xml', 'PublicWebController@feedOtros')->name('feed_otros');
Route::get('/FeedPromosAndamiosXML.xml', 'PublicWebController@feedAndamiosPromos')->name('feed_andamios_promos');

Route::get('/catalogo-virtual-andamios-ligeros', function () {
    return view('web_andamios.catalogo.catalogo');
});

Route::get('/catalogo-virtual-andamios-ligeros-2025', function () {
    return view('web_andamios.catalogo_sep_2024.catalogo_sep_2024');
});

/*POLITICAS*/
Route::get('/politicas-privacidad', function () {
    return view('web_andamios.politicas.privacidad_y_seguridad.privacidad_y_seguridad');
});
Route::get('/politicas-cancelaciones', function () {
    return view('web_andamios.politicas.cancelaciones.cancelaciones');
});
Route::get('/politicas-devoluciones', function () {
    return view('web_andamios.politicas.devoluciones.devoluciones');
});
Route::get('/politicas-envios', function () {
    return view('web_andamios.politicas.envios.envios');
});
Route::get('/terminos-y-condiciones', function () {
    return view('web_andamios.politicas.compras.compras');
});
Route::get('/politicas-compras', function () {
    return redirect('/terminos-y-condiciones', 301);
});
Route::get('/politicas-pagos', function () {
    return view('web_andamios.politicas.pagos.pagos');
});
Route::get('/politicas-cambios', function () {
    return view('web_andamios.politicas.cambios.cambios');
});

Route::get('/galeria', function () {
    return view('web_andamios.galeria.galeria');
});

Route::get('/galeria', function () {
    $imagenes = \App\ImagenGaleria::orderBy('display_order', 'asc')->get();

    return view('web_andamios.galeria.galeria', compact('imagenes'));
});

Route::any('{any}', function () {
    return view('web_andamios.errors.404');
})->where('any', '.*');



/****FIN RUTAS WEB****/
/*


Route::get('/', function () {
    return view('welcome');
});

Route::auth();

Route::get('/home', 'HomeController@index');
*/