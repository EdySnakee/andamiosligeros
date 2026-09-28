<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\ProyectosRedes;
use App\ClientesRedes;
use App\GaleriaClientes;
use App\Estados;
use App\Municipios;
use App\Utilidades;
use App\Protegeme;
use App\CreatePostFileAction;
use App\Http\Requests;

class ClientesRedesAnticaidasController extends Controller
{
	function __construct(){
        $this->middleware('auth');
    }

    public function showClientes(Request $request){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
            $moduloClientes=new ClientesRedes();
            $catalogo_proyectos = $moduloClientes
                ->select("*")
                ->from("clientesredes AS cr")
                ->join("proyectos_redes AS pr", "pr.id_proyecto", "=", "cr.id_proyecto")
                ->orderBy('cr.id_cliente', 'DESC')
                ->get();

            return view('app_redes/modulos/clientes/clientes', compact('catalogo_proyectos'));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
    }

    public function showAddClientes(){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
        	$catalogo_proyectos = ProyectosRedes::all();
            return view('app_redes/modulos/clientes/add_clientes/add_clientes', compact('catalogo_proyectos'));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
        
    }

    public function ShowEditClientes(Request $request){
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin' and \Auth::User()->estatus == 1) {
            //print_r($request->id_cliente);
            $catalogoClientes = new ClientesRedes();
            $datos_cliente = $catalogoClientes->find($request->id_cliente);

            $catalogo_proyectos = ProyectosRedes::all();

            $catalogoGaleriasClientes = new GaleriaClientes();
            $datos_galeria_cliente = $catalogoGaleriasClientes->where("id_cliente", "=", $request->id_cliente)->get();

            return view('app_redes/modulos/clientes/edit_clientes/edit_clientes', compact('datos_cliente', 'catalogo_proyectos', 'datos_galeria_cliente'));
        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user' and \Auth::User()->estatus == 1) {
            return redirect(route('path_vista_general'));
        }else{
            return \Redirect::to('logout');
        }
    }

    public function ajax_images_quill(Request $request, CreatePostFileAction $createPostFileAction){
    	$image = $createPostFileAction->run($request->image);

        return response()->json([
            "url" => asset($image)
        ]);

    }
    public function ajax_clientes(Request $request)
    {
        $data_post = new \stdClass();

        if(!empty($request->datos))
        { $data_post = json_decode(json_encode($request->datos));}

        if(!empty($request->accion)){
            switch($request->accion)
            {
                case 'editaClientes':
                    $id_proyecto = $_POST["proyecto"];
                    $id_cliente = $_POST["id_cliente"];

                    //print_r($_FILES['img_portada']);

                    $datosClientesRedes = new ClientesRedes();
                    $datos_clientes_edit = $datosClientesRedes->find($id_cliente);
                    $datos_clientes_edit->id_proyecto = $id_proyecto;
                    $datos_clientes_edit->nombre_cliente = $_POST["nombre_cliente"];
                    $datos_clientes_edit->palabras_clave = $_POST["palabras_clave"];
                    $datos_clientes_edit->descripcion_pry = $_POST["descripcion_pry"];
                    $datos_clientes_edit->latitud = $_POST["latitud"];
                    $datos_clientes_edit->longitud = $_POST["longitud"];
                    $datos_clientes_edit->contenido_html = $_POST["contenido_html"];
                    $datos_clientes_edit->url_cliente = $_POST["url_cliente"];
                    $datos_clientes_edit->save();

                    /*
                    */
                    //print_r($_FILES['img_portada']);
                    if (!empty($_FILES['img_portada']) && $_FILES['img_portada']['size'] != 0) {
                        //echo "entro en la condicion";
                        $carpeta = public_path().'/storage/clientes/portadas/'.$id_proyecto.'/'.$id_cliente;

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }

                        if (!empty($id_cliente)) {
                            $ruta = $carpeta;
                            if (!file_exists($ruta)) {
                                mkdir($ruta, 0777, true);
                            }
                            $mensage = '';
                            $key = $_FILES['img_portada'];
                            $NombreOriginalPortada ="";
                            if($key['error'] == UPLOAD_ERR_OK ){
                                if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR true) {
                                    $objProtegeme = new Protegeme();
                                    // $NombreOriginalPortada = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                    $NombreOriginalPortada = $id_proyecto."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
                                    $temporal = $key['tmp_name'];
                                    $Destino = $ruta."/".$NombreOriginalPortada;
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
                        $NombreOriginalPortada = $datos_clientes_edit->imagenp;
                        //print_r($NombreOriginalPortada);
                    }

                    
                    $actualiza_portada_edit = $datosClientesRedes->find($id_cliente);
                    $actualiza_portada_edit->imagenp = $NombreOriginalPortada;
                    $actualiza_portada_edit->save();

                    $countfiles = count($_FILES['imgs_galeria']['name']);
                    // Upload directory
                    $upload_location = public_path().'/storage/clientes/galerias/'.$id_proyecto.'/'.$id_cliente;

                    if (!file_exists($upload_location)) {
                        mkdir($upload_location, 0777, true);
                    }
                    if (!empty($_FILES['imgs_galeria']) && $_FILES['imgs_galeria']['size'] != 0) {
                        $ruta = $upload_location;
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }
                        $NombreOriginal ="";
                        // To store uploaded files path
                        $files_arr = array();
                        // Loop all files
                        for($index = 0;$index < $countfiles;$index++){
                           if(isset($_FILES['imgs_galeria']['name'][$index]) && $_FILES['imgs_galeria']['name'][$index] != ''){
                                // File name
                                $filename = $_FILES['imgs_galeria']['name'][$index];
                                // Get extension
                                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                // Valid image extension
                                $valid_ext = array("png","jpeg","jpg");
                                // Check extension
                                if(in_array($ext, $valid_ext)){
                                    // File path
                                    $path = $upload_location.$filename;
                                    // Upload file
                                    $objProtegeme = new Protegeme();
                                    // $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                    $NombreOriginal = $id_cliente."_".$objProtegeme->remplaza_caracteres_fotos($_FILES['imgs_galeria']['name'][$index]);
                                    $temporal = $_FILES['imgs_galeria']['tmp_name'][$index];
                                    $Destino = $ruta."/".$NombreOriginal;
                                    //move_uploaded_file($temporal, $Destino);
                                    if(move_uploaded_file($temporal, $Destino)){
                                        $files_arr[] = $Destino;
                                    }
                                }
                                //echo json_encode($NombreOriginal);
                                $datosGaleriaClientes = new GaleriaClientes();
                                $datosGaleriaClientes->id_cliente = $id_cliente;
                                $datosGaleriaClientes->id_proyecto = $id_proyecto;
                                $datosGaleriaClientes->img_galeria = $NombreOriginal;
                                $datosGaleriaClientes->save();
                            }else{
                                $NombreOriginal = "";
                            }
                        }
                    }

                    return 1;
                    

                break;
                case "guardaCliente":
                    /*
                    print_r($_FILES);
                    */
                	if ($data_post->id_proyecto != "null" and !empty($data_post->cliente)) {
                		$id_proyecto = $data_post->id_proyecto;
                		$nombre_cliente = $data_post->cliente;
                		$datosClientesRedes = new ClientesRedes();
                        $datosClientesRedes->id_proyecto = $id_proyecto;
                        $datosClientesRedes->nombre_cliente = $nombre_cliente;
                        $datosClientesRedes->latitud = $data_post->latitud;
                        $datosClientesRedes->longitud = $data_post->longitud;
                        $datosClientesRedes->contenido_html = $data_post->texto_html;
                        $datosClientesRedes->fecha_alta = date('Y-m-d');
                        $datosClientesRedes->save();

                        $id_cliente = $datosClientesRedes->id_cliente;

                        if (!empty($_FILES)) {							
							foreach ($_FILES as $key){
								if (!empty($_FILES)) {
                                    $carpeta = public_path().'/storage/clientes/galerias/'.$id_proyecto.'/'.$id_cliente;

                                    if (!file_exists($carpeta)) {
                                        mkdir($carpeta, 0777, true);
                                    }

                                    if (!empty($id_cliente)) {
                                        $ruta = $carpeta;
                                        if (!file_exists($ruta)) {
                                            mkdir($ruta, 0777, true);
                                        }
                                        $mensage = '';
                                        $NombreOriginal ="";
                                        if($key['error'] == UPLOAD_ERR_OK ){
                                            if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR true) {
                                                $objProtegeme = new Protegeme();
                                                // $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                                $NombreOriginal = $id_cliente."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
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

                                $datosGaleriaClientes = new GaleriaClientes();
                                $datosGaleriaClientes->id_cliente = $id_cliente;
                                $datosGaleriaClientes->id_proyecto = $id_proyecto;
                                $datosGaleriaClientes->img_galeria = $NombreOriginal;
                                $datosGaleriaClientes->save();
							}
	                    }else{
	                        $NombreOriginal = "";
	                    }
                        return 1;
                	} else {
                		return 2;
                	}
                break;

                case 'guardaClientes2':

                    $id_proyecto = $_POST["proyecto"];
                    $nombre_cliente = $_POST["nombre_cliente"];

                    $datosClientesRedes = new ClientesRedes();
                    $datosClientesRedes->id_proyecto = $id_proyecto;
                    $datosClientesRedes->nombre_cliente = $nombre_cliente;
                    $datosClientesRedes->palabras_clave = $_POST["palabras_clave"];
                    $datosClientesRedes->descripcion_pry = $_POST["descripcion_pry"];
                    $datosClientesRedes->latitud = $_POST["latitud"];
                    $datosClientesRedes->longitud = $_POST["longitud"];
                    $datosClientesRedes->contenido_html = $_POST["contenido_html"];
                    $datosClientesRedes->url_cliente = $_POST["url_cliente"];
                    $datosClientesRedes->fecha_alta = date('Y-m-d');
                    $datosClientesRedes->save();
                    
                    $id_cliente = $datosClientesRedes->id_cliente;

                    //print_r($_FILES['img_portada']);

                    if (!empty($_FILES['img_portada'])) {
                        $carpeta = public_path().'/storage/clientes/portadas/'.$id_proyecto.'/'.$id_cliente;

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }

                        if (!empty($id_cliente)) {
                            $ruta = $carpeta;
                            if (!file_exists($ruta)) {
                                mkdir($ruta, 0777, true);
                            }
                            $mensage = '';
                            $key = $_FILES['img_portada'];
                            $NombreOriginalPortada ="";
                            if($key['error'] == UPLOAD_ERR_OK ){
                                if (!empty($key["type"]) AND $key["type"] == "image/jpeg" OR true) {
                                    $objProtegeme = new Protegeme();
                                    // $NombreOriginalPortada = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                    $NombreOriginalPortada = $id_proyecto."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
                                    $temporal = $key['tmp_name'];
                                    $Destino = $ruta."/".$NombreOriginalPortada;
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
                        $NombreOriginalPortada = "";
                    }

                    //print_r($NombreOriginalPortada);

                    $datos_clientes_edit = $datosClientesRedes->find($id_cliente);
                    $datos_clientes_edit->imagenp = $NombreOriginalPortada;
                    $datos_clientes_edit->save();
                    
                    
                    /*
                    */

                    //print_r($_FILES['imgs_galeria']);
                    // Count total files

                    $countfiles = count($_FILES['imgs_galeria']['name']);
                    // Upload directory
                    $upload_location = public_path().'/storage/clientes/galerias/'.$id_proyecto.'/'.$id_cliente;

                    if (!file_exists($upload_location)) {
                        mkdir($upload_location, 0777, true);
                    }
                    if (!empty($id_cliente)) {
                        $ruta = $upload_location;
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }
                        $NombreOriginal ="";
                        // To store uploaded files path
                        $files_arr = array();
                        // Loop all files
                        for($index = 0;$index < $countfiles;$index++){
                           if(isset($_FILES['imgs_galeria']['name'][$index]) && $_FILES['imgs_galeria']['name'][$index] != ''){
                                // File name
                                $filename = $_FILES['imgs_galeria']['name'][$index];
                                // Get extension
                                $ext = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
                                // Valid image extension
                                $valid_ext = array("png","jpeg","jpg");
                                // Check extension
                                if(in_array($ext, $valid_ext)){
                                    // File path
                                    $path = $upload_location.$filename;
                                    // Upload file
                                    $objProtegeme = new Protegeme();
                                    // $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
                                    $NombreOriginal = $id_cliente."_".$objProtegeme->remplaza_caracteres_fotos($_FILES['imgs_galeria']['name'][$index]);
                                    $temporal = $_FILES['imgs_galeria']['tmp_name'][$index];
                                    $Destino = $ruta."/".$NombreOriginal;
                                    //move_uploaded_file($temporal, $Destino);
                                    if(move_uploaded_file($temporal, $Destino)){
                                        $files_arr[] = $Destino;
                                    }
                                }
                            }else{
                                $NombreOriginal = "";
                            }
                            //echo json_encode($NombreOriginal);
                            $datosGaleriaClientes = new GaleriaClientes();
                            $datosGaleriaClientes->id_cliente = $id_cliente;
                            $datosGaleriaClientes->id_proyecto = $id_proyecto;
                            $datosGaleriaClientes->img_galeria = $NombreOriginal;
                            $datosGaleriaClientes->save();
                        }
                    }

                    return 1;
                    /*
                    */
                break;

                case 'openConfirmDelete':
                    $catalogoClientes = new ClientesRedes();
                    $datos_cliente = $catalogoClientes->find($data_post->id_cliente);
                    return $datos_cliente;
                break;
                case 'confirmDelete':
                    $id_cliente = $data_post->id_cliente;
                    $datosCatClientes = new ClientesRedes();
                    $datos_to_delete_gal = $datosCatClientes->where("id_cliente", "=", $id_cliente)->first();
                    $id_proyecto = $datos_to_delete_gal->id_proyecto;
                    $carpeta_img_portada = public_path().'/storage/clientes/portadas/'.$id_proyecto.'/'.$id_cliente;

                    $arrayArchivos = scandir($carpeta_img_portada);

                    for($i=0; $i < count($arrayArchivos); $i++ ){
                        $urlArchivo = $carpeta_img_portada.'/'.$arrayArchivos[$i];
                        if (file_exists($urlArchivo) &&  $arrayArchivos[$i]!='.' && $arrayArchivos[$i]!='..' ) {
                            $success = unlink($urlArchivo);
                            if (!$success) {
                                throw new Exception("Cannot delete $urlArchivo");
                            }else{echo 'exito<br>';
                            }
                        }
                    }
                    $carpeta_img_galeria = public_path().'/storage/clientes/galerias/'.$id_proyecto.'/'.$id_cliente;
                    $arrayArchivosGal = scandir($carpeta_img_galeria);

                    for($i=0; $i < count($arrayArchivosGal); $i++ ){
                        $urlArchivoGal = $carpeta_img_galeria.'/'.$arrayArchivosGal[$i];
                        if (file_exists($urlArchivoGal) &&  $arrayArchivosGal[$i]!='.' && $arrayArchivosGal[$i]!='..' ) {
                            $success = unlink($urlArchivoGal);
                            if (!$success) {
                                throw new Exception("Cannot delete $urlArchivoGal");
                            }else{echo 'exito<br>';
                            }
                        }
                    }

                    /*
                    */
                    $catalogoClientes = new ClientesRedes();
                    $datos_to_delete = $catalogoClientes->find($id_cliente);
                    $datos_to_delete->delete();

                    $catalogoGaleriaClientes = new GaleriaClientes();
                    $datos_to_delete_gal = $catalogoGaleriaClientes->where("id_cliente", "=", $id_cliente)->get();
                    foreach ($datos_to_delete_gal as $key) {
                        $key->delete();
                    };

                    

                    //return $result_delete;
                break;
                case 'actualizaClientes':
                    $moduloClientes=new ClientesRedes();
                    $catalogo_proyectos = $moduloClientes
                        ->select("*")
                        ->from("clientesredes AS cr")
                        ->join("proyectos_redes AS pr", "pr.id_proyecto", "=", "cr.id_proyecto")
                        ->orderBy('cr.id_cliente', 'DESC')
                        ->get();
                    //print_r($datos_proyectos_redes);
                    return view('app_redes/modulos/clientes/tabla_listado_clientes', compact('catalogo_proyectos'));
                break;

                case 'confirmDeleteImagenGal':
                    $catalogoGaleriaClientes = new GaleriaClientes();
                    $info_galeria = $catalogoGaleriaClientes->find($data_post->id_imagen);

                    $carpeta_img_galeria = public_path().'/storage/clientes/galerias/'.$info_galeria->id_proyecto.'/'.$info_galeria->id_cliente.'/'.$info_galeria->img_galeria;
                    //print_r($carpeta_img_galeria);

                    if (file_exists($carpeta_img_galeria)) {
                        $success = unlink($carpeta_img_galeria);
                        if (!$success) {
                            throw new Exception("Algo salió mal no se puede eliminar $carpeta_img_galeria");
                        }else{
                        }
                    }
                    
                    $datos_to_delete_gal = $catalogoGaleriaClientes->find($data_post->id_imagen);
                    $datos_to_delete_gal->delete();
                    /*
                    */
                    
                    $datos_galeria_cliente = $catalogoGaleriaClientes->where("id_cliente", "=", $data_post->id_cliente)->get();

                    $catalogoClientes = new ClientesRedes();
                    $datos_cliente = $catalogoClientes->find($data_post->id_cliente);

                    return view('app_redes/modulos/clientes/edit_clientes/imagenes_galeria', compact('datos_cliente','datos_galeria_cliente'));
                break;
            }
        }

    }
}
