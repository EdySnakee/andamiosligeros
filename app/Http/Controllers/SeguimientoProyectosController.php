<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\SeguimientoTrabajo;
use App\SeguimientoBitacora;
use App\Cotizaciones;
use App\Ventas;
use App\Clientes;
use App\Protegeme;
use App\Http\Requests;

class SeguimientoProyectosController extends Controller
{
    private $max_row;

    function __construct(){
        $this->max_row = 10;
        $this->middleware('auth');
    }

    public function seguimientoCotizaciones(Request $request)
    {
        $info_cotizacion = Ventas::where("id_cotizacion", $request->id_cotizacion)->first();
        if (isset($info_cotizacion->id_cotizacion) and !empty($info_cotizacion->id_cotizacion)) {
            //print_r($info_cotizacion->id_cotizacion);
            $datosSeguimientoTrabajo = SeguimientoTrabajo::where("id_cotizacion", $info_cotizacion->id_cotizacion)->first();
            
            $datosCliente = Clientes::where("idcl", $info_cotizacion->id_cliente)->first();
            //dd($datosSeguimientoBitacora);
            return view('app_redes/modulos/cotizador/seguimiento/seguimiento', compact("info_cotizacion", "datosSeguimientoTrabajo", "datosCliente"));
        }else{
            return redirect(route('app_ver_cotizaciones'));
        }
    }
    public function ajax_seguimiento(Request $request){
		if ($request->ajax()) {
			$data_post = new \stdClass();
			if(!empty($request->datos)){
				$data_post = json_decode(json_encode($request->datos));
			}
			if (!empty($request->accion)) {
				switch ($request->accion) {
					case 'openModalProyecto':
						//dd($data_post->accion_usr);
						$accion = $data_post->accion_usr;
						return view('app_redes/modulos/cotizador/seguimiento/modal_seguimiento', compact('accion', 'data_post'));
					break;
					case 'postSeguimientoProyecto':
						if (!empty($data_post->titulo_trabajo) and !empty($data_post->personal_labora)) {
							$info_cotizacion = Cotizaciones::where("id_cotizacion", $data_post->id_cotizacion)->first();
							$post_seguimiento = new SeguimientoTrabajo();
							$post_seguimiento->id_cotizacion = $info_cotizacion->id_cotizacion;
							$post_seguimiento->cod_venta = $info_cotizacion->cod_venta;
							$post_seguimiento->titulo_trabajo = $data_post->titulo_trabajo;
							$post_seguimiento->fecha_elaboracion = $data_post->fecha_elaboracion;
							$post_seguimiento->personal_labora = $data_post->personal_labora;
							$post_seguimiento->comentario = $data_post->comentario;
							$post_seguimiento->estatus = 1;
							$post_seguimiento->save();

							$datosSeguimientoTrabajo = SeguimientoTrabajo::where("id_cotizacion", $info_cotizacion->id_cotizacion)->first();

							return view('app_redes/modulos/cotizador/seguimiento/contenido_bitacoras', compact('info_cotizacion', 'datosSeguimientoTrabajo'));
						}else{
							return 1;
						}
					break;
					case 'openModalBitacora':
						return view('app_redes/modulos/cotizador/seguimiento/modal_bitacora', compact('data_post'));
					break;
					case 'openModalEditBitacora':
						$info_bitacora = SeguimientoBitacora::find($data_post->id_bitacora);
						//dd($info_bitacora->archivo);
						$view = view('app_redes/modulos/cotizador/seguimiento/modal_edit_bitacora', compact('data_post', 'info_bitacora'))->render();

						$archivo = '/'.$info_bitacora->id_seguimiento.'/'.$info_bitacora->archivo;
						return response()->json(['html'=>$view, 'archivo'=>$archivo]);
					break;
					case 'postBitacora':
						//print_r($_FILES["archivo0"]);
						
						if (!empty($_FILES["archivo0"]) AND !empty($_FILES["archivo0"]["type"]) AND $_FILES["archivo0"]["type"] == "image/jpeg" OR $_FILES["archivo0"]["type"] == "image/png" OR $_FILES["archivo0"]["type"] == "application/pdf") {
							$array_tipo = explode("/", $_FILES["archivo0"]["type"]);
							//print_r($array_tipo["1"]);
							
							$id_proyecto = $data_post->id_proyecto;
                            $carpeta = public_path().'/storage/bitacoras/'.$id_proyecto;

                            if (!file_exists($carpeta)) {
                                mkdir($carpeta, 0777, true);
                            }
							if (!empty($id_proyecto)) {
                                $ruta = $carpeta;
                                if (!file_exists($ruta)) {
                                    mkdir($ruta, 0777, true);
                                }
                                $mensage = '';
                                $key = $_FILES["archivo0"];
                                $NombreOriginal ="";
                                if($key['error'] == UPLOAD_ERR_OK ){
                                    if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR $key["type"] == "image/png" OR $key["type"] == "application/pdf" OR true) {
                                        $objProtegeme = new Protegeme();
                                        $NombreOriginal = $id_proyecto."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
                                        $temporal = $key['tmp_name'];
                                        $Destino = $ruta."/".$NombreOriginal;
                                        move_uploaded_file($temporal, $Destino);
                                    }
                                }
                                if ($key['error']==''){
                                    $mensage = 'exito';
                                }
                                if ($key['error']!=''){
                                    $mensage = 'fallo';
                                }
                            }
                            if ($mensage == 'exito') {
                            }
                            if ($mensage == 'fallo') {
                            }
                            
                            $postBitacora = new SeguimientoBitacora();
							$postBitacora->id_seguimiento = $id_proyecto;
							$postBitacora->archivo = $NombreOriginal;
							$postBitacora->tipo_archivo = $array_tipo["1"];
							$postBitacora->comentario = $data_post->descrip_archivo;
							$postBitacora->estatus = 1;
							$postBitacora->save();

							$datosVenta = new Ventas();
	                        $cambia_estatus = $datosVenta->where("id_cotizacion", $data_post->id_cotizacion)->first();
	                        $cambia_estatus->status = 2;
	                        $cambia_estatus->save();

							$info_cotizacion = Cotizaciones::where("id_cotizacion", $data_post->id_cotizacion)->first();
							$datosSeguimientoTrabajo = SeguimientoTrabajo::where("id_cotizacion", $data_post->id_cotizacion)->first();

							return view('app_redes/modulos/cotizador/seguimiento/contenido_bitacoras', compact('info_cotizacion', 'datosSeguimientoTrabajo'));
						}else{
							return 1;
						}
					break;
					case 'eliminaBitacora':
						$del_bitacora = SeguimientoBitacora::find($data_post->id_bitacora);
						$del_bitacora->delete();
					break;
					case 'editBitacora':
						$postBitacora = new SeguimientoBitacora();
						$edit_bitacora = $postBitacora::find($data_post->id_bitacora);
						//dd($edit_bitacora);
						if (isset($_FILES["archivo0"]) AND !empty($_FILES["archivo0"])) {
							$array_tipo = explode("/", $_FILES["archivo0"]["type"]);
							//print_r($array_tipo["1"]);
							
							$id_proyecto = $data_post->id_proyecto;
                            $carpeta = public_path().'/storage/bitacoras/'.$id_proyecto;

                            if (!file_exists($carpeta)) {
                                mkdir($carpeta, 0777, true);
                            }
							if (!empty($id_proyecto)) {
                                $ruta = $carpeta;
                                if (!file_exists($ruta)) {
                                    mkdir($ruta, 0777, true);
                                }
                                $mensage = '';
                                $key = $_FILES["archivo0"];
                                $NombreOriginal ="";
                                if($key['error'] == UPLOAD_ERR_OK ){
                                    if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR $key["type"] == "image/png" OR $key["type"] == "application/pdf" OR true) {
                                        $objProtegeme = new Protegeme();
                                        $NombreOriginal = $id_proyecto."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
                                        $temporal = $key['tmp_name'];
                                        $Destino = $ruta."/".$NombreOriginal;
                                        move_uploaded_file($temporal, $Destino);
                                    }
                                }
                                if ($key['error']==''){
                                    $mensage = 'exito';
                                }
                                if ($key['error']!=''){
                                    $mensage = 'fallo';
                                }
                            }
                            if ($mensage == 'exito') {
                            }
                            if ($mensage == 'fallo') {
                            }
                            $edit_bitacora->archivo = $NombreOriginal;
                            $edit_bitacora->tipo_archivo = $array_tipo["1"];
						}
						$edit_bitacora->comentario = $data_post->descrip_archivo;
						$edit_bitacora->save();
						
					break;
					case 'actualizaContBitacora':
						$info_cotizacion = Cotizaciones::where("id_cotizacion", $data_post->id_cotizacion)->first();
						$datosSeguimientoTrabajo = SeguimientoTrabajo::where("id_cotizacion", $data_post->id_cotizacion)->first();

						return view('app_redes/modulos/cotizador/seguimiento/contenido_bitacoras', compact('info_cotizacion', 'datosSeguimientoTrabajo'));
						
					break;
					default:
						# code...
						break;
				}
			}
		}
	}
}
