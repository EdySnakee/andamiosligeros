<?php

/*
|--------------------------------------------------------------------------
| Rutas del Panel Administrativo (SB-Admin) con Control de Roles
|--------------------------------------------------------------------------
|
| Los roles definidos en el sistema son:
| - admin: Acceso total e irrestricto a todos los módulos.
| - vendedor (v1): Dashboard, Clientes, Cotizador, Ventas y Taller.
| - taller (t1): Órdenes de taller, Inventario, Cotizaciones y Ventas.
|
*/

/*
|--------------------------------------------------------------------------
| 1. RUTAS EXCLUSIVAS PARA ADMINISTRADOR (role:admin)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'role:admin']], function () {

    /* VISTA PROYECTOS / ESTADOS REDES */
    Route::get('sb-admin/estados', [
        'uses' => 'RedesAnticaidasController@showProyectos',
        'as'   => 'app_redes_proyectos',
    ]);
    Route::get('sb-admin/todos-los-estados', [
        'uses' => 'RedesAnticaidasController@showTodosProyectos',
        'as'   => 'app_redes_todos_proyectos',
    ]);
    Route::get('sb-admin/agregar-estados', [
        'uses' => 'RedesAnticaidasController@AddProyectos',
        'as'   => 'app_redes_add_proyectos',
    ]);
    Route::post('sb-admin/editar-estado', [
        'uses' => 'RedesAnticaidasController@ShowEditProyectos',
        'as'   => 'app_redes_edit_proyectos',
    ]);
    Route::post('sb-admin/ajax_proyectos', [
        'uses' => 'RedesAnticaidasController@ajax_proyectos',
        'as'   => 'ajax_proyectos_path',
    ]);

    /* CLIENTES REDES */
    Route::get('sb-admin/proyectos', [
        'uses' => 'ClientesRedesAnticaidasController@showClientes',
        'as'   => 'app_redes_clientes',
    ]);
    Route::get('sb-admin/agregar-proyectos', [
        'uses' => 'ClientesRedesAnticaidasController@showAddClientes',
        'as'   => 'app_redes_add_clientes',
    ]);
    Route::post('sb-admin/ajax_clientes', [
        'uses' => 'ClientesRedesAnticaidasController@ajax_clientes',
        'as'   => 'ajax_clientes_path',
    ]);
    Route::post('sb-admin/ajax_images_quill', [
        'uses' => 'ClientesRedesAnticaidasController@ajax_images_quill',
        'as'   => 'ajax_images_quill_path',
    ]);
    Route::post('sb-admin/editar-proyecto', [
        'uses' => 'ClientesRedesAnticaidasController@ShowEditClientes',
        'as'   => 'app_redes_edit_clientes',
    ]);

    /* TIENDA EN LÍNEA */
    Route::get('sb-admin/productos-tienda', [
        'uses' => 'TiendaEnLineaController@showProductos',
        'as'   => 'app_show_productos_web',
    ]);
    Route::get('sb-admin/add-producto-tienda', [
        'uses' => 'TiendaEnLineaController@postProductoTienda',
        'as'   => 'app_add_tienda_productos',
    ]);
    Route::get('sb-admin/ajustes_tienda', [
        'uses' => 'TiendaEnLineaController@ajustesTienda',
        'as'   => 'app_ajustes_tienda',
    ]);
    Route::get('sb-admin/edit-producto-tienda', [
        'uses' => 'TiendaEnLineaController@editProductoTienda',
        'as'   => 'app_edit_tienda_productos',
    ]);
    Route::get('sb-admin/ajax_table_products', [
        'uses' => 'TiendaEnLineaController@serverSideTable',
        'as'   => 'path_ajax_table_products',
    ]);
    Route::post('sb-admin/ajax_tienda', [
        'uses' => 'TiendaEnLineaController@ajax_tienda',
        'as'   => 'ajax_tienda_path',
    ]);

    /* PROMOCIONES */
    Route::get('sb-admin/all-promos', [
        'uses' => 'PromosAdminController@showPromos',
        'as'   => 'app_show_promos_web',
    ]);
    Route::get('sb-admin/add-promo', [
        'uses' => 'PromosAdminController@accionPromo',
        'as'   => 'app_accion_promos_web',
    ]);
    Route::get('sb-admin/edit-promo', [
        'uses' => 'PromosAdminController@accionPromo',
        'as'   => 'app_edit_promos_web',
    ]);
    Route::get('sb-admin/ajax_table_promos', [
        'uses' => 'PromosAdminController@serverSideTable',
        'as'   => 'path_ajax_table_promos',
    ]);
    Route::post('sb-admin/ajax_promo', [
        'uses' => 'PromosAdminController@ajax_promo',
        'as'   => 'ajax_promo_path',
    ]);

    /* BLOG */
    Route::get('sb-admin/articulos', [
        'uses' => 'BlogController@showArticulos',
        'as'   => 'app_redes_blog',
    ]);
    Route::get('sb-admin/agregar-articulos', [
        'uses' => 'BlogController@showAddArticulos',
        'as'   => 'app_redes_add_blog',
    ]);
    Route::post('sb-admin/editar-articulos', [
        'uses' => 'BlogController@editArticulos',
        'as'   => 'app_redes_edit_blog',
    ]);
    Route::post('sb-admin/ajax_blog', [
        'uses' => 'BlogController@ajax_blog',
        'as'   => 'ajax_blog_path',
    ]);

    /* PRODUCTOS (Catálogo) */
    Route::get('sb-admin/productos', [
        'uses' => 'ProductosController@verProductos',
        'as'   => 'app_ver_productos',
    ]);
    Route::get('sb-admin/agregar-producto', [
        'uses' => 'ProductosController@addProductos',
        'as'   => 'app_add_productos',
    ]);
    Route::post('sb-admin/editar-producto', [
        'uses' => 'ProductosController@editProducto',
        'as'   => 'app_edit_productos',
    ]);
    Route::post('sb-admin/ajax_productos', [
        'uses' => 'ProductosController@ajax_productos',
        'as'   => 'ajax_productos_path',
    ]);

    /* GESTIÓN DE USUARIOS */
    Route::get('sb-admin/usuarios', [
        'uses' => 'UsuariosController@verUsuarios',
        'as'   => 'app_ver_usuarios',
    ]);
    Route::get('sb-admin/registros-usuarios', [
        'uses' => 'UsuariosController@verRegistrosUsuarios',
        'as'   => 'app_ver_registros_usuarios',
    ]);
    Route::post('sb-admin/ajax_usuarios', [
        'uses' => 'UsuariosController@ajax_usuarios',
        'as'   => 'ajax_usuarios_path',
    ]);

    /* HERRAMIENTAS */
    Route::get('sb-admin/codificar', [
        'uses' => 'HerramientasController@verCodificar',
        'as'   => 'app_codificar',
    ]);

    /* CAJA CHICA */
    Route::get('sb-admin/caja', [
        'uses' => 'CajaChicaController@vistaCaja',
        'as'   => 'path_vista_caja',
    ]);
    Route::post('sb-admin/ajax_caja', [
        'uses' => 'CajaChicaController@ajax_caja_chica',
        'as'   => 'path_caja_ajax',
    ]);

    /* ESTADÍSTICAS */
    Route::get('sb-admin/estadisticas', [
        'uses' => 'EstadisticasController@showEstadisticas',
        'as'   => 'app_estadisticas',
    ]);
    Route::get('sb-admin/est-ventas', [
        'uses' => 'EstadisticasController@showEstVentas',
        'as'   => 'est_ventas',
    ]);
    Route::get('sb-admin/est-cotizaciones', [
        'uses' => 'EstadisticasController@showEstCotizaciones',
        'as'   => 'est_cotizaciones',
    ]);
    Route::get('/getUsuarios', 'EstadisticasController@getUsuarios');
    Route::get('/getSucursales', 'EstadisticasController@getSucursales');
    Route::post('sb-admin/ajax_est_ventas', [
        'uses' => 'EstadisticasController@ajax_est_ventas',
        'as'   => 'ajax_est_ventas',
    ]);
    Route::post('sb-admin/ajax_est_cotizaciones', [
        'uses' => 'EstadisticasController@ajax_est_cotizaciones',
        'as'   => 'ajax_est_cotizaciones',
    ]);
    Route::post('sb-admin/ajax_estadisticas', [
        'uses' => 'EstadisticasController@ajax_estadisticas',
        'as'   => 'ajax_estadisticas_path',
    ]);
});

/*
|--------------------------------------------------------------------------
| 2. RUTAS PARA ADMIN Y VENDEDOR (role:admin,vendedor)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'role:admin,vendedor']], function () {

    /* DASHBOARD */
    Route::get('sb-admin/dashboard', [
        'uses' => 'RedesAnticaidasController@showVistaGeneral',
        'as'   => 'path_vista_general',
    ]);

    /* CLIENTES */
    Route::get('sb-admin/clientes', [
        'uses' => 'ClientesController@muestraClientes',
        'as'   => 'app_redes_clientesweb',
    ]);
});

/*
|--------------------------------------------------------------------------
| 3. RUTAS PARA ADMIN Y TALLER (role:admin,taller)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'role:admin,taller']], function () {

    /* INVENTARIO */
    Route::get('sb-admin/inventario', [
        'uses' => 'InventarioController@vistaAdmin',
        'as'   => 'path_vista_admin',
    ]);
    Route::post('sb-admin/ajax_inventario', [
        'uses' => 'InventarioController@ajax_inventario_admin',
        'as'   => 'path_inv_ajax',
    ]);

    /* ORDENES DE EMBARQUE */
    Route::get('sb-admin/ordenes-embarque', [
        'uses' => 'OrdenEmbarqueController@ordenesEmbarque',
        'as'   => 'path_orden_ambarque',
    ]);
    Route::post('sb-admin/ajax_ordenes_embarque', [
        'uses' => 'OrdenEmbarqueController@ajax_ordenes_embarque',
        'as'   => 'ajax_or_emb',
    ]);
});

/*
|--------------------------------------------------------------------------
| 4. RUTAS PARA ADMIN, VENDEDOR Y TALLER (role:admin,vendedor,taller)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth', 'role:admin,vendedor,taller']], function () {

    /* OPERACIONES AJAX DE CLIENTES (Creación/edición desde cotizador y pedidos) */
    Route::post('sb-admin/ajax_clientes_web', [
        'uses' => 'ClientesController@ajax_clientes_web',
        'as'   => 'ajax_clientesweb_path',
    ]);

    /* COTIZADOR */
    Route::get('sb-admin/cotizaciones', [
        'uses' => 'CotizadorController@verCotizaciones',
        'as'   => 'app_ver_cotizaciones',
    ]);
    Route::get('sb-admin/exportar-cotizaciones', [
        'uses' => 'CotizadorController@exportarCotizaciones',
        'as'   => 'path_exportar_cotizaciones',
    ]);
    Route::get('sb-admin/genera-cotizacion', [
        'uses' => 'CotizadorController@generaCotizacion',
        'as'   => 'app_redes_cotizaciones',
    ]);
    Route::get('sb-admin/genera-cotizacion-renta', [
        'uses' => 'CotizadorController@generaRenta',
        'as'   => 'app_redes_renta',
    ]);
    Route::get('sb-admin/edita-cotizacion/{id_cotizacion}', [
        'uses' => 'CotizadorController@editaCotizacion',
        'as'   => 'app_redes_edita_cotizaciones',
    ]);
    Route::post('sb-admin/ajax_cotizador', [
        'uses' => 'CotizadorController@ajax_cotizador',
        'as'   => 'path_ajax_cotizador',
    ]);
    Route::get('sb-admin/ajax_cotizador', [
        'uses' => 'CotizadorController@serverSideTable',
        'as'   => 'path_ajax_get_cotizador',
    ]);
    Route::get('/buscar_clientes', 'CotizadorController@buscarCliente')->name('buscar_cliente');

    /* SEGUIMIENTO TRABAJO */
    Route::get('sb-admin/seguimineto/{id_cotizacion}', [
        'uses' => 'SeguimientoProyectosController@seguimientoCotizaciones',
        'as'   => 'app_seguimiento_controller',
    ]);
    Route::post('sb-admin/ajax_seguimiento', [
        'uses' => 'SeguimientoProyectosController@ajax_seguimiento',
        'as'   => 'ajax_seguimiento_path',
    ]);

    /* VENTAS */
    Route::get('sb-admin/ventas', [
        'uses' => 'VentasController@verVentas',
        'as'   => 'app_ver_ventas',
    ]);
    Route::post('sb-admin/ajax_ventas', [
        'uses' => 'VentasController@ajax_ventas',
        'as'   => 'path_ajax_ventas',
    ]);
    Route::get('sb-admin/exportar-ventas', [
        'uses' => 'VentasController@exportarVentas',
        'as'   => 'path_exportar_ventas',
    ]);

    /* TALLER */
    Route::get('sb-admin/ordenes-taller', [
        'uses' => 'TallerController@listadoOrdenes',
        'as'   => 'app_ordenes_taller',
    ]);
    Route::get('sb-admin/rastreo-guias', [
        'uses' => 'TallerController@rastreoGuias',
        'as'   => 'app_rastreo_guias',
    ]);
    Route::get('sb-admin/agregar-orden-taller', [
        'uses' => 'TallerController@agregarOrden',
        'as'   => 'app_agregar_orden_taller',
    ]);
    Route::get('sb-admin/orden-taller/{id_cotizacion}', [
        'uses' => 'TallerController@verOrden',
        'as'   => 'app_ver_orden_taller',
    ]);
    Route::post('sb-admin/orden-taller/actualizar-progreso', [
        'uses' => 'TallerController@actualizarProgreso',
        'as'   => 'app_actualizar_progreso_taller',
    ]);
    Route::post('sb-admin/orden-taller/marcar-impreso', [
        'uses' => 'TallerController@marcarImpreso',
        'as'   => 'app_marcar_impreso_taller',
    ]);
    Route::post('sb-admin/orden-taller/agregar-nota', [
        'uses' => 'TallerController@agregarNota',
        'as'   => 'app_agregar_nota_taller',
    ]);
    Route::post('sb-admin/orden-taller/confirmar-envio', [
        'uses' => 'TallerController@confirmarEnvio',
        'as'   => 'app_confirmar_envio_taller',
    ]);

    /* FORMATOS (ENTREGA Y CAMBIO DE PRODUCTO) */
    Route::get('sb-admin/formatos/buscar-cotizacion', [
        'uses' => 'FormatosEntregaController@buscarCotizacion',
        'as'   => 'app_formatos_buscar_cotizacion',
    ]);
    Route::get('sb-admin/formatos/buscar-productos', [
        'uses' => 'FormatosEntregaController@buscarProductos',
        'as'   => 'app_formatos_buscar_productos',
    ]);
    Route::get('sb-admin/formatos/buscar-clientes', [
        'uses' => 'FormatosEntregaController@buscarClientes',
        'as'   => 'app_formatos_buscar_clientes',
    ]);

    /* FORMATO DE ENTREGA */
    Route::post('sb-admin/formatos/entrega/guardar', [
        'uses' => 'FormatosEntregaController@guardar',
        'as'   => 'app_formatos_entrega_guardar',
    ]);
    Route::post('sb-admin/formatos/entrega/{id_formato}/actualizar', [
        'uses' => 'FormatosEntregaController@actualizar',
        'as'   => 'app_formatos_entrega_actualizar',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/entrega/{id_formato}/ver', [
        'uses' => 'FormatosEntregaController@ver',
        'as'   => 'app_formatos_entrega_ver',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/entrega/{id_formato}/pdf', [
        'uses' => 'FormatosEntregaController@pdf',
        'as'   => 'app_formatos_entrega_pdf',
    ])->where('id_formato', '[0-9]+');
    Route::delete('sb-admin/formatos/entrega/{id_formato}/eliminar', [
        'uses' => 'FormatosEntregaController@eliminar',
        'as'   => 'app_formatos_entrega_eliminar',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/entrega/{id_cotizacion?}', [
        'uses' => 'FormatosEntregaController@index',
        'as'   => 'app_formatos_entrega',
    ])->where('id_cotizacion', '[0-9]+');

    /* FORMATO DE CAMBIO DE PRODUCTO */
    Route::post('sb-admin/formatos/cambio-producto/guardar', [
        'uses' => 'FormatosCambioController@guardar',
        'as'   => 'app_formatos_cambio_guardar',
    ]);
    Route::post('sb-admin/formatos/cambio-producto/{id_formato}/actualizar', [
        'uses' => 'FormatosCambioController@actualizar',
        'as'   => 'app_formatos_cambio_actualizar',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/cambio-producto/{id_formato}/ver', [
        'uses' => 'FormatosCambioController@ver',
        'as'   => 'app_formatos_cambio_ver',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/cambio-producto/{id_formato}/pdf', [
        'uses' => 'FormatosCambioController@pdf',
        'as'   => 'app_formatos_cambio_pdf',
    ])->where('id_formato', '[0-9]+');
    Route::delete('sb-admin/formatos/cambio-producto/{id_formato}/eliminar', [
        'uses' => 'FormatosCambioController@eliminar',
        'as'   => 'app_formatos_cambio_eliminar',
    ])->where('id_formato', '[0-9]+');
    Route::get('sb-admin/formatos/cambio-producto/{id_cotizacion?}', [
        'uses' => 'FormatosCambioController@index',
        'as'   => 'app_formatos_cambio',
    ])->where('id_cotizacion', '[0-9]+');
});

/*
|--------------------------------------------------------------------------
| 5. INVENTARIO SUCURSAL (Para sucursales / roles existentes)
|--------------------------------------------------------------------------
*/
Route::group(['middleware' => ['auth']], function () {
    Route::get('sb-admin/inventarioSuc', [
        'uses' => 'InventarioSucController@inventarioSuc',
        'as'   => 'path_inv_suc',
    ]);
    Route::post('sb-admin/inventarioSuc', [
        'uses' => 'InventarioSucController@ajax_inventario',
        'as'   => 'ajax_inv_path',
    ]);
});