<?php

namespace App\Http\Controllers;

use Yajra\Datatables\Facades\Datatables;
use Illuminate\Http\Request;
use App\ProductosTienda;
use App\ProductosTiendaDetalle;
use App\ProductosTiendaMeta;
use App\ItemFiles;
use App\Productos;
use App\DetalleProducto;
use App\catalogoModelos;
use App\CategoriasTienda;
use App\Cotizaciones;
use App\Utilidades;
use App\Http\Requests;
use \Auth;

class TiendaEnLineaController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }

    public function showProductos(){
        return view('app_redes/modulos/tienda_online/productos/productos');
    }
    public function postProductoTienda(Request $request)
    {
        //dd($request->id_producto);
        $accion = "Agregar";
        $objProducto = new Productos();
        $objDetProducto = new DetalleProducto();
        $catModelos = catalogoModelos::all();
        $categoriasTienda = CategoriasTienda::all();
        $datos_generales = $objProducto::find($request->id_producto);
        $datos_adicionales = $objDetProducto::where('id_producto', $request->id_producto)->first();
    	//dd($datos_generales->nombre_p);
        $caracteres_especiales = new Utilidades();
        $sin_caracteres = $caracteres_especiales->remplaza_caracteres((!empty($datos_generales->nombre_p))?$datos_generales->nombre_p:'');
        $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");
    	return view('app_redes/modulos/tienda_online/productos/accion_producto/accion_producto', compact('accion', 'categoriasTienda', 'datos_generales', 'url_proyecto', 'datos_adicionales', 'catModelos'));
    }
    public function editProductoTienda(Request $request)
    {
        //dd($request->id_producto);
        $accion = "Editar";
        $objProductoTienda = new ProductosTienda();
        $objDetProductoTienda = new ProductosTiendaDetalle();
        $objMetaTienda = new ProductosTiendaMeta();
        $objGaleria = new ItemFiles();
        $catModelos = catalogoModelos::all();
        $categoriasTienda = CategoriasTienda::all();
        $datos_generales = $objProductoTienda::find($request->id_producto);
        $datos_meta = $objMetaTienda::where('id_product', $request->id_producto)->first();
        $datos_adicionales = $objDetProductoTienda::where('id_product', $request->id_producto)->first();
        $datos_galeria = $objGaleria::where('id_product', $request->id_producto)->where('file_tipo', 'galeria')->get();
        $url_proyecto = $datos_generales->post_url;
        return view('app_redes/modulos/tienda_online/productos/accion_producto/accion_producto', compact('accion', 'categoriasTienda', 'datos_generales', 'url_proyecto', 'datos_adicionales', 'datos_meta', 'datos_galeria', 'catModelos'));
    }
    public function serverSideTable(Request $request)
    {
        $objCotizaciones = new Cotizaciones;
        $objProductoTienda = new ProductosTienda();
        $listado_productos = $objProductoTienda
                ->select("pr.id_product", "pr.post_titulo", "pr.categoria", "pr.post_fecha", "pr.precio", "pr.post_estatus", "pr.post_url", "pr.estrella", "dp.imagen_portada")
                ->from("productos_tienda AS pr")
                ->Rightjoin("productos_tienda_detalle AS dp", "dp.id_product", "=", "pr.id_product")
                ->get();
        //dd($listado_productos);
        return Datatables::of($listado_productos)
            ->addColumn('action', function ($listado_productos) {
                /*BOTONERA*/
                
                
                if($listado_productos->post_estatus == 1){//Publicado
                    $btns_st = '
                        <li>
                            <form action="'.route('app_edit_tienda_productos').'" method="get" accept-charset="utf-8">
                                '.csrf_field().'
                                <input type="hidden" name="id_producto" id="id_producto" value="'.$listado_productos->id_product.'">
                                <input type="submit" id="Editar" value="Editar" class="btn btn-primary col-md-12 btn-dropdown-fix">
                            </form>
                        </li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva" id="confirm_desactiva" data-id-p="'.$listado_productos->id_product.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                if($listado_productos->post_estatus == 2){//Borrador
                    $btns_st = '
                        <li>
                            <form action="'.route('app_edit_tienda_productos').'" method="get" accept-charset="utf-8">
                                '.csrf_field().'
                                <input type="hidden" name="id_producto" id="id_producto" value="'.$listado_productos->id_product.'">
                                <input type="submit" id="Editar" value="Editar" class="btn btn-primary col-md-12 btn-dropdown-fix">
                            </form>
                        </li>
                        <li><input type="submit" name="confirm_activa_p" id="confirm_activa_p" data-id-p="'.$listado_productos->id_product.'" value="Publicar" class="btn btn-success col-md-12 btn-dropdown-fix"></li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva" id="confirm_desactiva" data-id-p="'.$listado_productos->id_product.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                if($listado_productos->post_estatus == 3){//Inactivo
                    $btns_st = '
                        <li>
                            <form action="'.route('app_edit_tienda_productos').'" method="get" accept-charset="utf-8">
                                '.csrf_field().'
                                <input type="hidden" name="id_producto" id="id_producto" value="'.$listado_productos->id_product.'">
                                <input type="submit" id="Editar" value="Editar" class="btn btn-primary col-md-12 btn-dropdown-fix">
                            </form>
                        </li>
                        <li><input type="submit" name="confirm_activa_p" id="confirm_activa_p" data-id-p="'.$listado_productos->id_product.'" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix"></li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_elimina_p" id="confirm_elimina_p" data-id-p="'.$listado_productos->id_product.'" value="Eliminar" class="btn btn-danger col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                if($listado_productos->post_estatus == 4){//Eliminado
                    $btns_st = '
                        <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="'.url("/sb-admin/edita-cotizacion/".$listado_productos->id_product).'" >Editar</a></li>
                        <li><a id="open_confirm_venta" data-id-p="'.$listado_productos->id_product.'" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Confirmar Venta</a></li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva" id="confirm_desactiva" data-id-p="'.$listado_productos->id_product.'" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }
                return '
                <div class="btn-group">
                    <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="productos-tienda-menu">
                        '.$btns_st.'
                    </ul>
                </div>
                ';
            })
            ->editColumn('post_titulo', function ($info_product) {
                return '<a target="_blank" href="'.url("/tienda/".$info_product->post_url).'">'.$info_product->post_titulo.'</a>';
            })
            ->editColumn('imagen_portada', function ($info_product) {
                return '
                <div class="img-thumb">
                    <img class="shadow-sm bg-white rounded" src="'.$info_product->imagen_portada.'" alt="">
                </div>
                ';
            })
            ->editColumn('post_estatus', function ($info_product) {
                if ($info_product->post_estatus == 1) {
                    return '<span class="status bg-gradient-success text-white">Publicado</span>';
                }
                if ($info_product->post_estatus == 2) {
                    return '<span class="status bg-secondary text-white">Borrador</span>';
                }
                if ($info_product->post_estatus == 3){
                    return '<span class="status bg-gradient-warning text-white">Inactivo</span>';
                }
                if ($info_product->post_estatus == 4){
                    return '<span class="status bg-gradient-danger text-white">Eliminado</span>';
                }
            })
            ->editColumn('estrella', function ($info_product) {
                if ($info_product->estrella == 0) {
                    return '<a href="#" class="estrella" id="activar_star"><i class="far fa-star"></i></a>';
                }
                if ($info_product->estrella == 1) {
                    return '<a href="#" class="estrella" id="desactiva_star"><i class="fas fa-star"></i></a>';
                }
            })
            ->editColumn('precio', function ($info_product) {    
                return "$ ".number_format($info_product->precio, 2, '.', ',');
            })
            ->make(true);
    }

    public function ajax_tienda(Request $request){
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if(!empty($request->datos)){
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                $objProductosModelTienda = new ProductosTienda();
                $objProductosModelTiendaDetalle = new ProductosTiendaDetalle();
                $objProductosModelTiendaMeta = new ProductosTiendaMeta();
                $objProductos = new Productos();
                switch ($request->accion) {
                    case 'escribeURL':
                        $caracteres_especiales = new Utilidades();
                        $sin_caracteres = $caracteres_especiales->remplaza_caracteres($data_post->titulo_seccion);
                        $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");
                        return $url_proyecto;
                    break;
                    case 'guardaProducto':
                        $datos_producto = $_POST;
                        $images_files = $_FILES;
                        
                        $imagen_destacada = $images_files['imagen_destacada'];
                        $imagen_destacada_social = $images_files['imagen_destacada_social'];
                        $imagen_galeria = $images_files['galeria'];

                        //dd($imagen_galeria);
                        
                        if (empty($datos_producto["titulo_producto"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido el titulo del producto",
                                "type_swal" => "error",
                            ];
                        }
                        if (empty($datos_producto["cate_product"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido seleccionar una categoria",
                                "type_swal" => "error",
                            ];
                        }
                        if (empty($datos_producto["tipo_cobro"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido seleccionar un tipo de cobro",
                                "type_swal" => "error",
                            ];
                        }

                        $response_id_producto = $objProductosModelTienda->postProductoTienda($datos_producto);
                        $result_detalle = $objProductosModelTienda->postProductosTiendaDetalle($datos_producto, $response_id_producto);
                        $result_meta = $objProductosModelTienda->postProductosTiendaMeta($datos_producto, $response_id_producto);

                        if (!empty($imagen_destacada) && $imagen_destacada['size'] != 0) {
                            $tipo_imagen = "destacada";
                            $data_imgs = $objProductosModelTienda->subeImagenes($imagen_destacada, $response_id_producto, $tipo_imagen);
                            //dd($data_imgs->ruta_web_img);
                            $editImgPrincipal = $objProductosModelTiendaDetalle::where('id_product', $response_id_producto)->first();
                            $editImgPrincipal->imagen_portada = $data_imgs->ruta_web_img;
                            $editImgPrincipal->imagen_alt = $data_imgs->file_name;
                            $editImgPrincipal->save();
                        }

                        if (!empty($imagen_destacada_social) && $imagen_destacada_social['size'] != 0) {
                            $tipo_imagen = "social";
                            $data_imgs = $objProductosModelTienda->subeImagenes($imagen_destacada_social, $response_id_producto, $tipo_imagen);
                            $editImgMeta = $objProductosModelTiendaMeta::where('id_product', $response_id_producto)->first();
                            $editImgMeta->meta_url_imagen = $data_imgs->ruta_web_img;
                            $editImgMeta->save();
                        }

                        if (!empty($imagen_galeria) && $imagen_galeria['size'][0] != 0) {
                            $tipo_imagen = "galeria";
                            $total_arrays = count($imagen_galeria['name']);
                            for($index = 0; $index < $total_arrays; $index++){
                                $orden = $index + 1;
                                $response_id_file = $objProductosModelTienda->subeImagenesGalerias($imagen_galeria, $response_id_producto, $index, $orden, $tipo_imagen);
                            } 
                        }


                        $edit_product = $objProductos::find($datos_producto["id_product_ref"]);
                        if (!empty($edit_product)) {
                            $edit_product->id_product_web = $response_id_producto;
                            $edit_product->save();
                        }
                        
                        return $swal_msjs = [
                            "tit_swal" => "Genial!",
                            "msj_swal" => "Se ha publicado el producto correctamente",
                            "type_swal" => "success",
                        ];

                    break;
                    case 'editaProducto':
                        $datos_producto = $_POST;
                        $images_files = $_FILES;

                        $imagen_destacada = $images_files['imagen_destacada'];
                        $imagen_destacada_social = $images_files['imagen_destacada_social'];
                        $imagen_galeria = $images_files['galeria'];

                        if (empty($datos_producto["titulo_producto"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido el titulo del producto",
                                "type_swal" => "error",
                            ];
                        }
                        if (empty($datos_producto["cate_product"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido seleccionar una categoria",
                                "type_swal" => "error",
                            ];
                        }
                        if (empty($datos_producto["tipo_cobro"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido seleccionar un tipo de cobro",
                                "type_swal" => "error",
                            ];
                        }
                        
                        $objProductosModelTienda->editProductoTienda($datos_producto);
                        $objProductosModelTienda->editProductosTiendaDetalle($datos_producto);
                        $objProductosModelTienda->editProductosTiendaMeta($datos_producto);

                        if (!empty($imagen_destacada) && $imagen_destacada['size'] != 0) {
                            $tipo_imagen = "destacada";
                            $data_imgs = $objProductosModelTienda->subeImagenes($imagen_destacada, $datos_producto["id_product"], $tipo_imagen);
                            $editImgPrincipal = $objProductosModelTiendaDetalle::where('id_product', $datos_producto["id_product"])->first();
                            $editImgPrincipal->imagen_portada = $data_imgs->ruta_web_img;
                            $editImgPrincipal->imagen_alt = $data_imgs->file_name;
                            $editImgPrincipal->save();
                        }
                        if (!empty($imagen_destacada_social) && $imagen_destacada_social['size'] != 0) {
                            $tipo_imagen = "social";
                            $data_imgs = $objProductosModelTienda->subeImagenes($imagen_destacada_social, $datos_producto["id_product"], $tipo_imagen);
                            $editImgMeta = $objProductosModelTiendaMeta::where('id_product', $datos_producto["id_product"])->first();
                            $editImgMeta->meta_url_imagen = $data_imgs->ruta_web_img;
                            $editImgMeta->save();
                        }
                        if (!empty($imagen_galeria) && $imagen_galeria['size'][0] != 0) {
                            $tipo_imagen = "galeria";
                            $total_arrays = count($imagen_galeria['name']);
                            for($index = 0; $index < $total_arrays; $index++){
                                $orden = $index + 1;
                                $response_id_file = $objProductosModelTienda->subeImagenesGalerias($imagen_galeria, $datos_producto["id_product"], $index, $orden, $tipo_imagen);
                            } 
                        }

                        return $swal_msjs = [
                            "tit_swal" => "Genial!",
                            "msj_swal" => "Se ha editado el producto",
                            "type_swal" => "success",
                        ];

                    break;
                    case 'confirmElimina':
                        $pTienda = new ProductosTienda();
                        $objProductosModelTiendaDetalle = new ProductosTiendaDetalle();
                        $objProductosModelTiendaMeta = new ProductosTiendaMeta();

                        $pTienda_to_delete = $pTienda->find($data_post->id_producto);
                        $pTienda_to_delete->delete();

                        $pTDetalle_to_delete = $objProductosModelTiendaDetalle->where('id_product',$data_post->id_producto);
                        $pTDetalle_to_delete->delete();
                        
                        $pTMeta_to_delete = $objProductosModelTiendaMeta->where('id_product',$data_post->id_producto);
                        $pTMeta_to_delete->delete();
                    break;
                    case 'confirmDesactiva':
                        $pTienda = new ProductosTienda();
                        $pTienda_desactiva = $pTienda->find($data_post->id_producto);
                        $pTienda_desactiva->post_estatus = 3;
                        $pTienda_desactiva->save();
                    break;
                    case 'confirmActiva':
                        $pTienda = new ProductosTienda();
                        $pTienda_activa = $pTienda->find($data_post->id_producto);
                        $pTienda_activa->post_estatus = 1;
                        $pTienda_activa->save();
                    break;
                    
                    default:
                    break;
                }
            }
        }
    }
}
