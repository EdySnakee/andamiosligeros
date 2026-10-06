<?php


/*VISTA GENERAL*/
Route::get('sb-admin/dashboard', [
    'uses' => 'RedesAnticaidasController@showVistaGeneral',
    'as' => 'path_vista_general'
]);



Route::get('sb-admin/estados', [
    'uses' => 'RedesAnticaidasController@showProyectos',
    'as' => 'app_redes_proyectos',
]
);

Route::get('sb-admin/todos-los-estados', [
    'uses' => 'RedesAnticaidasController@showTodosProyectos',
    'as' => 'app_redes_todos_proyectos',
]
);

Route::get('sb-admin/agregar-estados', [
    'uses' => 'RedesAnticaidasController@AddProyectos',
    'as' => 'app_redes_add_proyectos',
]
);

Route::post('sb-admin/editar-estado', [
    'uses' => 'RedesAnticaidasController@ShowEditProyectos',
    'as' => 'app_redes_edit_proyectos',
]
);

Route::post('sb-admin/ajax_proyectos', [
    'uses' => 'RedesAnticaidasController@ajax_proyectos',
    'as' => 'ajax_proyectos_path',
]
);

/*AGREGAR CLIENTES*/

Route::get('sb-admin/proyectos', [
    'uses' => 'ClientesRedesAnticaidasController@showClientes',
    'as' => 'app_redes_clientes',
]
);

Route::get('sb-admin/agregar-proyectos', [
    'uses' => 'ClientesRedesAnticaidasController@showAddClientes',
    'as' => 'app_redes_add_clientes',
]
);
Route::post('sb-admin/ajax_clientes', [
    'uses' => 'ClientesRedesAnticaidasController@ajax_clientes',
    'as' => 'ajax_clientes_path',
]
);
Route::post('sb-admin/ajax_images_quill', [
    'uses' => 'ClientesRedesAnticaidasController@ajax_images_quill',
    'as' => 'ajax_images_quill_path',
]
);

/*EDITAR CLIENTES*/
Route::post('sb-admin/editar-proyecto', [
    'uses' => 'ClientesRedesAnticaidasController@ShowEditClientes',
    'as' => 'app_redes_edit_clientes',
]
);
/* TIENDA EN LINEA */
Route::get('sb-admin/productos-tienda', [
    'uses' => 'TiendaEnLineaController@showProductos',
    'as' => 'app_show_productos_web',
]
);

Route::get('sb-admin/add-producto-tienda', [
    'uses' => 'TiendaEnLineaController@postProductoTienda',
    'as' => 'app_add_tienda_productos',
]
);

Route::get('sb-admin/ajustes_tienda', [
    'uses' => 'TiendaEnLineaController@ajustesTienda',
    'as' => 'app_ajustes_tienda',
]
);

Route::get('sb-admin/edit-producto-tienda', [
    'uses' => 'TiendaEnLineaController@editProductoTienda',
    'as' => 'app_edit_tienda_productos',
]
);


Route::get('sb-admin/ajax_table_products', [
    'uses' => 'TiendaEnLineaController@serverSideTable',
    'as' => 'path_ajax_table_products',
]
);
Route::post('sb-admin/ajax_tienda', [
    'uses' => 'TiendaEnLineaController@ajax_tienda',
    'as' => 'ajax_tienda_path',
]
);
/* PROMOCIONES */
Route::get('sb-admin/all-promos', [
    'uses' => 'PromosAdminController@showPromos',
    'as' => 'app_show_promos_web',
]
);

Route::get('sb-admin/add-promo', [
    'uses' => 'PromosAdminController@accionPromo',
    'as' => 'app_accion_promos_web',
]
);

Route::get('sb-admin/edit-promo', [
    'uses' => 'PromosAdminController@accionPromo',
    'as' => 'app_edit_promos_web',
]
);

Route::get('sb-admin/ajax_table_promos', [
    'uses' => 'PromosAdminController@serverSideTable',
    'as' => 'path_ajax_table_promos',
]
);

Route::post('sb-admin/ajax_promo', [
    'uses' => 'PromosAdminController@ajax_promo',
    'as' => 'ajax_promo_path',
]
);

/*BLOG*/

Route::get('sb-admin/articulos', [
    'uses' => 'BlogController@showArticulos',
    'as' => 'app_redes_blog',
]
);
Route::get('sb-admin/agregar-articulos', [
    'uses' => 'BlogController@showAddArticulos',
    'as' => 'app_redes_add_blog',
]
);
Route::post('sb-admin/editar-articulos', [
    'uses' => 'BlogController@editArticulos',
    'as' => 'app_redes_edit_blog',
]
);
Route::post('sb-admin/ajax_blog', [
    'uses' => 'BlogController@ajax_blog',
    'as' => 'ajax_blog_path',
]
);
/***CLIENTES WEB***/

Route::get('sb-admin/clientes', [
    'uses' => 'ClientesController@muestraClientes',
    'as' => 'app_redes_clientesweb',
]
);
Route::post('sb-admin/ajax_clientes_web', [
    'uses' => 'ClientesController@ajax_clientes_web',
    'as' => 'ajax_clientesweb_path',
]
);
/*******COTIZADOR**********/
Route::get('sb-admin/cotizaciones', [
    'uses' => 'CotizadorController@verCotizaciones',
    'as' => 'app_ver_cotizaciones',
]
);
Route::get('sb-admin/exportar-cotizaciones', [
    'uses' => 'CotizadorController@exportarCotizaciones',
    'as' => 'path_exportar_cotizaciones',
]
);
Route::get('sb-admin/genera-cotizacion', [
    'uses' => 'CotizadorController@generaCotizacion',
    'as' => 'app_redes_cotizaciones',
]
);
Route::get('sb-admin/genera-cotizacion-renta', [
    'uses' => 'CotizadorController@generaRenta',
    'as' => 'app_redes_renta',
]
);
Route::get('sb-admin/edita-cotizacion/{id_cotizacion}', [
    'uses' => 'CotizadorController@editaCotizacion',
    'as' => 'app_redes_edita_cotizaciones',
]
);
Route::post('sb-admin/ajax_cotizador', [
    'uses' => 'CotizadorController@ajax_cotizador',
    'as' => 'path_ajax_cotizador',
]
);
Route::get('sb-admin/ajax_cotizador', [
    'uses' => 'CotizadorController@serverSideTable',
    'as' => 'path_ajax_get_cotizador',
]
);

Route::get('/buscar_clientes', 'CotizadorController@buscarCliente')->name('buscar_cliente');


/*****VENTAS********/
Route::get('sb-admin/ventas', [
    'uses' => 'VentasController@verVentas',
    'as' => 'app_ver_ventas',
]
);
Route::post('sb-admin/ajax_ventas', [
    'uses' => 'VentasController@ajax_ventas',
    'as' => 'path_ajax_ventas',
]
);
Route::get('sb-admin/exportar-ventas', [
    'uses' => 'VentasController@exportarVentas',
    'as' => 'path_exportar_ventas',
]
);
/****PRODUCTOS ***********/

Route::get('sb-admin/productos', [
    'uses' => 'ProductosController@verProductos',
    'as' => 'app_ver_productos',
]
);
Route::get('sb-admin/agregar-producto', [
    'uses' => 'ProductosController@addProductos',
    'as' => 'app_add_productos',
]
);

Route::post('sb-admin/editar-producto', [
    'uses' => 'ProductosController@editProducto',
    'as' => 'app_edit_productos',
]
);

Route::post('sb-admin/ajax_productos', [
    'uses' => 'ProductosController@ajax_productos',
    'as' => 'ajax_productos_path',
]
);

/*USUARIOS*/

Route::get('sb-admin/usuarios', [
    'uses' => 'UsuariosController@verUsuarios',
    'as' => 'app_ver_usuarios',
]
);

Route::get('sb-admin/registros-usuarios', [
    'uses' => 'UsuariosController@verRegistrosUsuarios',
    'as' => 'app_ver_registros_usuarios',
]
);

Route::post('sb-admin/ajax_usuarios', [
    'uses' => 'UsuariosController@ajax_usuarios',
    'as' => 'ajax_usuarios_path',
]
);

/*SEGUIMIENTO TRABAJO*/

Route::get('sb-admin/seguimineto/{id_cotizacion}', [
    'uses' => 'SeguimientoProyectosController@seguimientoCotizaciones',
    'as' => 'app_seguimiento_controller',
]
);

Route::post('sb-admin/ajax_seguimiento', [
    'uses' => 'SeguimientoProyectosController@ajax_seguimiento',
    'as' => 'ajax_seguimiento_path',
]
);

/* HERRMIENTAS */

Route::get('sb-admin/codificar', [
    'uses' => 'HerramientasController@verCodificar',
    'as' => 'app_codificar',
]
);

/*ESTADISTICAS*/
Route::get('sb-admin/estadisticas', [
    'uses' => 'EstadisticasController@showEstadisticas',
    'as' => 'app_estadisticas',
]
);

/*ESTADISTICAS VENTAS*/
Route::get('sb-admin/est-ventas', [
    'uses' => 'EstadisticasController@showEstVentas',
    'as' => 'est_ventas',
]
);

Route::get('sb-admin/est-cotizaciones', [
    'uses' => 'EstadisticasController@showEstCotizaciones',
    'as' => 'est_cotizaciones',
]
);

// USUARIOS
Route::get('/getUsuarios', 'EstadisticasController@getUsuarios');

// SUCURSALES
Route::get('/getSucursales', 'EstadisticasController@getSucursales');

/* AJAX EST-VENTAS*/
Route::post('sb-admin/ajax_est_ventas', [
    'uses' => 'EstadisticasController@ajax_est_ventas',
    'as' => 'ajax_est_ventas',
]
);

// AJAX EST COTIZACIONES
Route::post('sb-admin/ajax_est_cotizaciones', [
    'uses' => 'EstadisticasController@ajax_est_cotizaciones',
    'as' => 'ajax_est_cotizaciones',
]
);

/* AJAX ESTADISTICAS*/
Route::post('sb-admin/ajax_estadisticas', [
    'uses' => 'EstadisticasController@ajax_estadisticas',
    'as' => 'ajax_estadisticas_path',
]
);

/* INVENTARIO */
Route::get('sb-admin/inventario', [
    'uses' => 'InventarioController@vistaAdmin',
    'as' => 'path_vista_admin'
]);
/* AJAX */
Route::post('sb-admin/ajax_inventario', [
    'uses' => 'InventarioController@ajax_inventario_admin',
    'as' => 'path_inv_ajax'
]);


/* ORDENES DE EMBARQUE */
Route::get('sb-admin/ordenes-embarque', [
    'uses' => 'OrdenEmbarqueController@ordenesEmbarque',
    'as' => 'path_orden_ambarque'
]);

/* AJAX ORDENES DE EMBARQUE */
Route::post('sb-admin/ajax_ordenes_embarque', [
    'uses' => 'OrdenEmbarqueController@ajax_ordenes_embarque',
    'as' => 'ajax_or_emb'
]);


/* INVENTARIO SUCURSAL */
Route::get('sb-admin/inventarioSuc', [
    'uses' => 'InventarioSucController@inventarioSuc',
    'as' => 'path_inv_suc'
]);

/* AJAX INVENTARIO SUCURSAL */
Route::post('sb-admin/inventarioSuc', [
    'uses' => 'InventarioSucController@ajax_inventario',
    'as' => 'ajax_inv_path',
]
);

/* CAJA CHICA */
Route::get('sb-admin/caja', [
    'uses' => 'CajaChicaController@vistaCaja',
    'as' => 'path_vista_caja'
]);
/* AJAX CAJA CHICA */
Route::post('sb-admin/ajax_caja', [
    'uses' => 'CajaChicaController@ajax_caja_chica',
    'as' => 'path_caja_ajax'
]);

/* TALLER */
Route::get('sb-admin/ordenes-taller', [
    'uses' => 'TallerController@listadoOrdenes',
    'as' => 'app_ordenes_taller',
]);

// RASTREO DE GUIAS
Route::get('sb-admin/rastreo-guias', [
    'uses' => 'TallerController@rastreoGuias',
    'as' => 'app_rastreo_guias',
]);

Route::get('sb-admin/agregar-orden-taller', [
    'uses' => 'TallerController@agregarOrden',
    'as' => 'app_agregar_orden_taller',
]);
Route::get('sb-admin/orden-taller/{id_cotizacion}', [
    'uses' => 'TallerController@verOrden',
    'as' => 'app_ver_orden_taller',
]);
Route::post('sb-admin/orden-taller/actualizar-progreso', [
    'uses' => 'TallerController@actualizarProgreso',
    'as' => 'app_actualizar_progreso_taller',
]);
Route::post('sb-admin/orden-taller/marcar-impreso', [
    'uses' => 'TallerController@marcarImpreso',
    'as' => 'app_marcar_impreso_taller',
]);
Route::post('sb-admin/orden-taller/agregar-nota', [
    'uses' => 'TallerController@agregarNota',
    'as' => 'app_agregar_nota_taller',
]);
Route::post('sb-admin/orden-taller/confirmar-envio', [
    'uses' => 'TallerController@confirmarEnvio',
    'as' => 'app_confirmar_envio_taller',
]);