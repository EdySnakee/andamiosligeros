<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Yajra\Datatables\Facades\Datatables;
use App\Http\Requests;
use App\PromocionesModel;
use App\TipoPromocion;
use App\Utilidades;
use App\ItemFiles;
use \Auth;
use SebastianBergmann\Environment\Console;

class PromosAdminController extends Controller
{
    function __construct()
    {
        $this->middleware('auth');
    }

    public function showPromos()
    {
        return view('app_redes/modulos/promociones/promos');
    }

    public function serverSideTable(Request $request)
    {
        $objPromociones = new PromocionesModel();
        $listado_promos = $objPromociones
            ->select("*")
            ->get();
        //dd($listado_promos);
        return Datatables::of($listado_promos)
            ->addColumn('action', function ($listado_promos) {

                $btn_editar = '
                <li>
                    <form action="' . route('app_edit_promos_web') . '" method="get" accept-charset="utf-8">
                        ' . csrf_field() . '
                        <input type="hidden" name="id_promo" id="id_promo" value="' . $listado_promos->id_promo . '">
                        <input type="submit" id="Editar" value="Editar" class="btn btn-primary col-md-12 btn-dropdown-fix">
                    </form>
                </li>
                ';

                if ($listado_promos->status == 1) { //Publicado
                    $btns_st = '
                        <li>
                            <form action="' . route('app_edit_promos_web') . '" method="get" accept-charset="utf-8">
                                ' . csrf_field() . '
                                <input type="hidden" name="id_promo" id="id_promo" value="' . $listado_promos->id_promo . '">
                                <input type="submit" id="Editar" value="Editar" class="btn btn-primary col-md-12 btn-dropdown-fix">
                            </form>
                        </li>
                        <li class="divider"><hr></li>
                        <li><input type="submit" name="confirm_desactiva_promo" id="confirm_desactiva_promo" data-id-promo="' . $listado_promos->id_promo . '" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix"></li>
                    ';
                }

                if ($listado_promos->status == 2 or $listado_promos->status == 3) { //Inactivo
                    $btns_st = '
                       <li><input type="submit" name="confirm_activa_promo" id="confirm_activa_promo" data-id-promo="' . $listado_promos->id_promo . '" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix"></li>
                        ' . $btn_editar . '
                    ';
                }

                return '
                <div class="btn-group">
                    <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Accion <span class="caret"></span></a>
                    <ul class="dropdown-menu" id="productos-tienda-menu">
                        ' . $btns_st . '
                    </ul>
                </div>
                ';
            })
            ->editColumn('post_titulo', function ($info_promo) {
                return '<a target="_blank" href="' . url("/promociones/" . $info_promo->url_promo) . '">' . $info_promo->nombre_product . '</a>';
            })
            ->editColumn('img_banner', function ($info_promo) {
                return '
                <div class="img-thumb">
                     <img class="shadow-sm bg-white rounded" src="' . url('') . '/web/prom/' . $info_promo->img_banner . '" alt="">
                </div>
                ';
            })
            ->addColumn('destacado_modal', function ($info_promo) {
                $checked = $info_promo->destacado_modal == 1 ? 'checked' : '';
                // Usamos un input tipo checkbox con una clase espec¨ªfica para el JS
                return '
            <div class="custom-control custom-switch">
                <input type="checkbox" class="custom-control-input toggle-destacado" 
                       id="destacado_' . $info_promo->id_promo . '" 
                       data-id="' . $info_promo->id_promo . '" 
                       ' . $checked . '>
                <label class="custom-control-label" for="destacado_' . $info_promo->id_promo . '"></label>
            </div>
        ';
            })
            ->editColumn('pstatus', function ($info_promo) {
                if ($info_promo->status == 1) {
                    return '<span class="status bg-gradient-success text-white">Activo</span>';
                }

                if ($info_promo->status == 2) {
                    return '<span class="status bg-gradient-warning text-white">Inactivo</span>';
                }
            })
            ->editColumn('envio', function ($info_promo) {
                return "$ " . number_format($info_promo->envio, 2, '.', ',');
            })
            ->editColumn('precio', function ($info_promo) {
                return "$ " . number_format($info_promo->costo_item, 2, '.', ',');
            })
            ->make(true);
    }

    public function accionPromo(Request $request)
    {

        if (!empty($request->id_promo)) {
            $accion = "Editar";
        } else {
            $accion = "Agregar";
        }
        $id_promo = (!empty($request->id_promo)) ? $request->id_promo : -1;

        $tipoPromo = TipoPromocion::all();
        $objPromos = new PromocionesModel();
        $objGaleria = new ItemFiles();
        $datos_galeria = $objGaleria::where('id_product', $id_promo)->where('file_tipo', 'gal_promo')->get();

        // dd($categoriasPromos);

        $datos_generales = $objPromos::find($id_promo);
        $datos_adicionales = "";

        return view('app_redes/modulos/promociones/accion_promo/accion_promo', compact('accion', 'datos_generales', 'datos_adicionales', 'datos_galeria', 'tipoPromo'));
    }

    public function ajax_promo(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                $objPromocion = new PromocionesModel();
                switch ($request->accion) {
                    case 'escribeURL':
                        $caracteres_especiales = new Utilidades();
                        $sin_caracteres = $caracteres_especiales->remplaza_caracteres($data_post->titulo_seccion);
                        $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");
                        return $url_proyecto;
                        break;
                    case 'guardaPromo':
                        $datos_promo = $_POST;
                        $images_files = $_FILES;

                        //  dd('Prov-->', $images_files);

                        $img_barra_pago = $images_files['imagen_destacada'];
                        $imagen_banner = $images_files['imagen_destacada'];
                        $imagen_google = $images_files['imagen_destacada_social'];


                        if (empty($datos_promo["titulo_producto"])) {
                            return $swal_msjs = [
                                "tit_swal" => "Ups!",
                                "msj_swal" => "Es requerido el titulo del producto",
                                "type_swal" => "error",
                            ];
                        }


                        // Validaci¨®n de que la cantidad m¨ªnima de compra sea mayor que la cantidad
                        if (isset($datos_promo["activa_cant_min"])) {
                            // Convertir los valores a enteros
                            $min = intval($datos_promo["cant_min"]);
                            $can = intval($datos_promo["cantidad"]);

                            if ($min < $can) {
                                return $swal_msjs = [
                                    "tit_swal" => "Ups!",
                                    "msj_swal" => "La cantidad m¨ªnima de compra debe ser mayor a la cantidad",
                                    "type_swal" => "error",
                                ];
                            }
                        }


                        $response_id_producto = $objPromocion->postPromocion($datos_promo);


                        if (!empty($img_barra_pago) && $img_barra_pago['size'] != 0) {
                            $tipo_imagen = "banner";
                            $data_imgs = $objPromocion->subeImagenes($img_barra_pago, $response_id_producto, $tipo_imagen);
                            //  dd($data_imgs->ruta_web_img);
                            $editImgPrincipal = $objPromocion::where('id_promo', $response_id_producto)->first();
                            $editImgPrincipal->img_barra_pago = $data_imgs->ruta_web_img;
                            $editImgPrincipal->save();
                        }

                        if (!empty($imagen_banner) && $imagen_banner['size'] != 0) {
                            $tipo_imagen = "destacada";
                            $data_imgs = $objPromocion->subeImagenes($imagen_banner, $response_id_producto, $tipo_imagen);
                            //  dd($data_imgs->ruta_web_img);
                            $editImgPrincipal = $objPromocion::where('id_promo', $response_id_producto)->first();
                            $editImgPrincipal->img_banner = $data_imgs->ruta_web_img;
                            $editImgPrincipal->save();
                        }

                        if (!empty($imagen_google) && $imagen_google['size'] != 0) {
                            $tipo_imagen = "social";
                            $data_imgs = $objPromocion->subeImagenes($imagen_google, $response_id_producto, $tipo_imagen);
                            // dd($data_imgs->ruta_web_img);
                            $editImgPrincipal = $objPromocion::where('id_promo', $response_id_producto)->first();
                            $editImgPrincipal->img_social = $data_imgs->ruta_web_img;
                            $editImgPrincipal->save();
                        }


                        return $swal_msjs = [
                            "tit_swal" => "Genial no!",
                            "msj_swal" => "Se ha publicado el producto correctamente",
                            "type_swal" => "success",
                        ];

                        break;
                    case 'editaPromo':
                        $datos_promo = $_POST;
                        $images_files = $_FILES;

                        $img_barra_pago = $images_files['imagen_destacada'];
                        $imagen_destacada = $images_files['imagen_destacada'];
                        $imagen_destacada_social = $images_files['imagen_destacada_social'];


                        $objPromocion->editPromocion($datos_promo);




                        if (!empty($img_barra_pago) && $img_barra_pago['size'] != 0) {
                            $tipo_imagen = "banner";
                            $data_imgs = $objPromocion->subeImagenes($img_barra_pago, $datos_promo["id_promo"], $tipo_imagen);
                            $editImgPrincipal = $objPromocion::where('id_promo', $datos_promo["id_promo"])->first();
                            $editImgPrincipal->img_barra_pago = $data_imgs->ruta_web_img;
                            $editImgPrincipal->save();
                        }
                        if (!empty($imagen_destacada) && $imagen_destacada['size'] != 0) {
                            $tipo_imagen = "destacada";
                            $data_imgs = $objPromocion->subeImagenes($imagen_destacada, $datos_promo["id_promo"], $tipo_imagen);
                            $editImgPrincipal = $objPromocion::where('id_promo', $datos_promo["id_promo"])->first();
                            $editImgPrincipal->img_banner = $data_imgs->ruta_web_img;
                            $editImgPrincipal->save();
                        }
                        if (!empty($imagen_destacada_social) && $imagen_destacada_social['size'] != 0) {
                            $tipo_imagen = "social";
                            $data_imgs = $objPromocion->subeImagenes($imagen_destacada_social, $datos_promo["id_promo"], $tipo_imagen);
                            $editImgMeta = $objPromocion::where('id_promo', $datos_promo["id_promo"])->first();
                            $editImgMeta->img_social = $data_imgs->ruta_web_img;
                            $editImgMeta->save();
                        }


                        return $swal_msjs = [
                            "tit_swal" => "Genial! ",
                            "msj_swal" => "Se ha editado el producto",
                            "type_swal" => "success",
                        ];

                        break;
                    case 'confirmDesactiva':
                        $promo = new PromocionesModel();
                        $promo_desactiva = $promo->find($data_post->id_promo);
                        $promo_desactiva->status = 2;
                        $promo_desactiva->save();
                        break;
                    case 'confirmActiva':
                        $promo = new PromocionesModel();
                        $promo_activa = $promo
                            ->find($data_post->id_promo);
                        $promo_activa->status = 1;
                        $promo_activa->save();
                        break;
                    case 'cambiarDestacado':
                        $id_promo = $data_post->id_promo;
                        $nuevo_estado = $data_post->nuevo_estado; // 1 o 0

                        $promo = PromocionesModel::find($id_promo);

                        // Si queremos ACTIVAR (poner en 1)
                        if ($nuevo_estado == 1) {
                            // 1. Validar que la promoci¨®n est¨¦ ACTIVA (status = 1)
                            if ($promo->status != 1) {
                                return response()->json([
                                    "tit_swal" => "No permitido",
                                    "msj_swal" => "No puedes destacar una promocion inactiva. Activala primero.",
                                    "type_swal" => "warning",
                                    "success" => false
                                ]);
                            }

                            // 2. Validar que no haya m¨¢s de 3 activas
                            $cantidad_actual = PromocionesModel::where('destacado_modal', 1)->count();
                            if ($cantidad_actual >= 3) {
                                return response()->json([
                                    "tit_swal" => "Limite alcanzado",
                                    "msj_swal" => "Solo puedes tener 3 promociones destacadas simultaneamente. Desactiva una para activar esta.",
                                    "type_swal" => "error",
                                    "success" => false
                                ]);
                            }
                        }

                        // Si pasamos las validaciones o estamos desactivando, procedemos
                        $promo->destacado_modal = $nuevo_estado;
                        $promo->save();

                        return response()->json([
                            "tit_swal" => "Actualizado",
                            "msj_swal" => "Estado de destacado actualizado correctamente.",
                            "type_swal" => "success",
                            "success" => true
                        ]);
                        break;
                    default:
                        break;
                }
            }
        }
    }
}
