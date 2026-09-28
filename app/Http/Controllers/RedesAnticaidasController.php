<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\Estados;
use App\Municipios;
use App\Utilidades;
use App\Cotizaciones;
use App\Protegeme;
use App\ClientesRedes;
use App\GaleriaClientes;

use App\Http\Requests;

class RedesAnticaidasController extends Controller{

    function __construct(){
        $this->middleware('auth');
    }

    public function showVistaGeneral()
    {
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->estatus == 1) {
            # code...
            $coti_redes_anti = Cotizaciones::where("giro_empresa", "ra")->get();
            $coti_redes_peri = Cotizaciones::where("giro_empresa", "rp")->get();
            $coti_scoregol = Cotizaciones::where("giro_empresa", "sg")->get();
            $coti_anda_lige = Cotizaciones::where("giro_empresa", "al")->get();

            $cant_re_anti = count($coti_redes_anti);
            $cant_re_peri = count($coti_redes_peri);
            $cant_sgol = count($coti_scoregol);
            $cant_anda_lig = count($coti_anda_lige);

            return view('app_redes/modulos/dashboard/dashboard', compact('cant_re_anti', 'cant_re_peri', 'cant_sgol', 'cant_anda_lig'));
        }else{
            return \Redirect::to('logout');
        }
    }
    public function showProyectos(){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
            $objProyectosRedes = new ProyectosRedes();
            $datos_proyectos_redes = $objProyectosRedes
                            ->select("*")
                            ->from("proyectos_redes AS pr")
                            ->join("estados AS est", "est.idestado", "=", "pr.id_estado")
                            ->get();
            $datos_cliente = ClientesRedes::all();

            //print_r($datos_cliente);
            return view('app_redes/modulos/proyectos/proyectos', array(
                'datos_proyectos_redes' => $datos_proyectos_redes,
                'datos_cliente' => $datos_cliente
            ));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
    }

    public function AddProyectos(){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
            $catalogo_estados = Estados::all();
            return view('app_redes/modulos/proyectos/add_proyectos/add_proyectos', array(
                "catalogo_estados" => $catalogo_estados
                ));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
    }
    public function ShowEditProyectos(Request $request){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
            //print_r($request->id_proyecto);
            $catalogoProyectos = new ProyectosRedes();
            $datos_proyecto = $catalogoProyectos
                            ->select("*")
                            ->from("proyectos_redes AS pr")
                            ->join("estados AS est", "est.idestado", "=", "pr.id_estado")
                            ->where("pr.id_proyecto", "=", $request->id_proyecto)
                            ->first();
            
            $catalogo_estados = Estados::all();
            return view('app_redes/modulos/proyectos/edit_proyecto/edit_proyecto', array(
                "catalogo_estados" => $catalogo_estados,
                "datos_proyecto" => $datos_proyecto
                ));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
    }

    public function ajax_proyectos(Request $request){
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if(!empty($request->datos)){
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'escribeURL':
                        $caracteres_especiales = new Utilidades();
                        $sin_caracteres = $caracteres_especiales->remplaza_caracteres($data_post->nombre_proyecto);
                        $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");
                        return $url_proyecto;
                        break;
                    case 'guardaProyecto':
                        //print_r($data_post->estado);
                        if ($data_post->estado != "undefined") {
                            if (!empty($data_post->nombre_proyecto) and !empty($data_post->estado)) {
                                # code...
                                //print_r($data_post->palabras_clave);
                                $Destino = "";
                                
                                $caracteres_especiales = new Utilidades();
                                $sin_caracteres = $caracteres_especiales->remplaza_caracteres($data_post->nombre_proyecto);
                                $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");

                                $datosProyectosRedes = new ProyectosRedes();
                                $datosProyectosRedes->nombre_proyecto = $data_post->nombre_proyecto;
                                $datosProyectosRedes->id_estado = $data_post->estado;
                                $datosProyectosRedes->url_proyecto = $url_proyecto;
                                $datosProyectosRedes->palabras_clave = $data_post->palabras_clave;
                                $datosProyectosRedes->descripcion = $data_post->descripcion;
                                $datosProyectosRedes->save();

                                $id_proyecto = $datosProyectosRedes->id_proyecto;

                                if (!empty($_FILES["archivo0"])) {
                                    $id_cliente = "proyectos";
                                    $carpeta = public_path().'/storage/proyectos/'.$id_proyecto;

                                    if (!file_exists($carpeta)) {
                                        mkdir($carpeta, 0777, true);
                                    }

                                    if (!empty($id_cliente)) {
                                        $ruta = $carpeta;
                                        if (!file_exists($ruta)) {
                                            mkdir($ruta, 0777, true);
                                        }
                                        $mensage = '';
                                        $key = $_FILES["archivo0"];
                                        $NombreOriginal ="";
                                        if($key['error'] == UPLOAD_ERR_OK ){
                                            if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR true) {
                                                $objProtegeme = new Protegeme();
                                                // $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
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
                                }else{
                                    $NombreOriginal = "";
                                }

                                $datos_proyectos_edit = $datosProyectosRedes->find($id_proyecto);
                                $datos_proyectos_edit->img_portada = $NombreOriginal;
                                $datos_proyectos_edit->save();
                                

                                return 1;
                                break;
                            }
                            else{
                                return 2;
                                break;
                            }
                        }else{
                            return 2;
                            break;
                        }
                        
                        /*
                        */                        
                    break;
                    case 'openConfirmDelete':
                        $catalogoProyectos = new ProyectosRedes();
                        $datos_proyecto = $catalogoProyectos->find($data_post->id_proyecto);
                        return $datos_proyecto;
                    break;
                    case 'confirmDelete':
                        //print_r($data_post->id_proyecto);
                        $id_proyecto = $data_post->id_proyecto;
                        /*
                        $carpeta_img_portada = public_path().'/storage/clientes/portadas/'.$id_proyecto;
                        $carpeta_img_galeria = public_path().'/storage/clientes/galerias/'.$id_proyecto;
                        
                        $eliminaDirectorio = new Utilidades();
                        $eliminandoImgPortada = $eliminaDirectorio->deleteDirectory($carpeta_img_portada);
                        
                        */
                        $catalogoProyectos = new ProyectosRedes();
                        $datos_to_delete = $catalogoProyectos->find($id_proyecto);
                        $result_delete = $datos_to_delete->delete();

                        $catalogoClientes = new ClientesRedes();
                        $datos_to_delete_client = $catalogoClientes->where("id_proyecto", "=", $id_proyecto)->get();
                        foreach ($datos_to_delete_client as $keyc) {
                            $keyc->delete();
                        };

                        $catalogoGaleriaClientes = new GaleriaClientes();
                        $datos_to_delete_gal = $catalogoGaleriaClientes->where("id_proyecto", "=", $id_proyecto)->get();
                        foreach ($datos_to_delete_gal as $keyg) {
                            $keyg->delete();
                        };
                        //return $result_delete;
                    break;
                    case 'actualizaProyectos':
                        $objProyectosRedes = new ProyectosRedes();
                        $datos_proyectos_redes = $objProyectosRedes
                                        ->select("*")
                                        ->from("proyectos_redes AS pr")
                                        ->join("estados AS est", "est.idestado", "=", "pr.id_estado")
                                        ->get();
                        //print_r($datos_proyectos_redes);
                        return view('app_redes/modulos/proyectos/items_proyectos', compact('datos_proyectos_redes'));
                    break;
                    case 'editaProyecto':
                        //print_r($data_post);
                        if (!empty($data_post->nombre_proyecto) and !empty($data_post->estado)) {

                            //$Destino = "";
                                
                            $caracteres_especiales = new Utilidades();
                            $sin_caracteres = $caracteres_especiales->remplaza_caracteres($data_post->nombre_proyecto);
                            $url_proyecto = mb_convert_case($sin_caracteres, MB_CASE_LOWER, "UTF-8");

                            $ProyectosRedes = new ProyectosRedes();
                            $datos_detventas_edit = $ProyectosRedes->find($data_post->id_proyecto);
                            $datos_detventas_edit->nombre_proyecto = $data_post->nombre_proyecto;
                            $datos_detventas_edit->id_estado = $data_post->estado;
                            $datos_detventas_edit->url_proyecto = $url_proyecto;
                            $datos_detventas_edit->palabras_clave = $data_post->palabras_clave;
                            $datos_detventas_edit->descripcion = $data_post->descripcion;
                            $datos_detventas_edit->save();

                            $id_proyecto = $datos_detventas_edit->id_proyecto;

                            if (!empty($_FILES["archivo0"])) {
                                $id_cliente = "proyectos";
                                $carpeta = public_path().'/storage/proyectos/'.$id_proyecto;

                                if (!file_exists($carpeta)) {
                                    mkdir($carpeta, 0777, true);
                                }

                                if (!empty($id_cliente)) {
                                    $ruta = $carpeta;
                                    if (!file_exists($ruta)) {
                                        mkdir($ruta, 0777, true);
                                    }
                                    $mensage = '';
                                    $key = $_FILES["archivo0"];
                                        $NombreOriginal ="";
                                        if($key['error'] == UPLOAD_ERR_OK )
                                            {
                                                if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR true) {
                                                    $objProtegeme = new Protegeme();
                                                    // $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                                    $NombreOriginal = $id_proyecto."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
                                                    $temporal = $key['tmp_name'];
                                                    $Destino = $ruta."/".$NombreOriginal;
                                                    move_uploaded_file($temporal, $Destino);
                                                }
                                            }
                                        if ($key['error']=='')
                                            {
                                                $mensage = 'exito';
                                            }
                                        if ($key['error']!='')
                                            {
                                                $mensage = 'fallo';
                                            }
                                        
                                    }
                                   if ($mensage == 'exito') {

                                   }
                                   if ($mensage == 'fallo') {

                                   }
                            }else{
                                $NombreOriginal = $datos_detventas_edit->img_portada;
                            }

                            $datos_proyectos_edit = $ProyectosRedes->find($id_proyecto);
                            $datos_proyectos_edit->img_portada = $NombreOriginal;
                            $datos_proyectos_edit->save();
                            
                            return 1;
                            break;
                        }else{
                            return 2;
                            break;
                        }
                    break;
                    default:
                break;
                }
            }
        }
    }
}
