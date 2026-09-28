<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Protegeme;
use App\Blog;
use App\CreatePostFileAction;

use App\ClientesRedes;
use App\Http\Requests;
use \Auth;

class BlogController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    public function showArticulos(Request $request){

    	if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin') {
	        $moduloBlog=new Blog();
	        $listado_blog = $moduloBlog
	            ->select("*")
	            ->from("blog AS bl")
	            ->join("users AS usr", "usr.id", "=", "bl.post_autor")
	            ->orderBy('bl.post_fecha', 'DESC')
	            ->get();
	        return view('app_redes/modulos/blog/blog', compact('listado_blog'));

        }elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user') {
            return redirect(route('path_vista_general'));
        }else{
    		//return redirect(route('path_control_errores'));
        }

    }

    public function showAddArticulos(Request $request){
    	if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin') {
	    	$accion = "agregar";
	        return view('app_redes/modulos/blog/accion_blog/accion_blog', compact("accion"));
		}elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user') {
		    return redirect(route('path_vista_general'));
		}else{
			//return redirect(route('path_control_errores'));
		}
    }

    public function editArticulos(Request $request){
    	if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'admin') {
	    	$accion = "editar";
	    	$id_blog = $request->id_blog;
	    	$info_blog = Blog::find($id_blog);    	
	        return view('app_redes/modulos/blog/accion_blog/accion_blog', compact("info_blog", "accion"));
		}elseif (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->tipo_usuario == 'user') {
		    return redirect(route('path_vista_general'));
		}else{
			//return redirect(route('path_control_errores'));
		}
    }
    
    public function ajax_blog(Request $request)
    {
        $data_post = new \stdClass();

        if(!empty($request->datos))
        { $data_post = json_decode(json_encode($request->datos));}

        if(!empty($request->accion)){
            switch($request->accion)
            {
                case 'guardaBlog':
                	if (!empty($_POST["titulo_articulo"])) {
	                    $datosBlogRedes = new Blog();
						$datosBlogRedes->post_autor = Auth::User()->id;
						$datosBlogRedes->post_fecha = date('Y-m-d');
						$datosBlogRedes->post_hora = date('h-i-s');
						$datosBlogRedes->post_contenido = $_POST["contenido_html"];
						$datosBlogRedes->post_titulo = $_POST["titulo_articulo"];
						$datosBlogRedes->post_estatus = "activo";
						$datosBlogRedes->coment_estatus = 1;
						$datosBlogRedes->post_url = $_POST["url_articulo"];
						$datosBlogRedes->palabras_clave = $_POST["palabras_clave"];
						$datosBlogRedes->meta_descripcion = $_POST["meta_descripcion"];
						$datosBlogRedes->post_fecha_modificado = date('Y-m-d');
						$datosBlogRedes->post_hora_modificado = date('H-i-s');
	                    $datosBlogRedes->save();
	                    
	                    $id_blog = $datosBlogRedes->id_blog;
	                    if (!empty($_FILES['img_portada'])) {
	                        $carpeta = public_path().'/storage/blog/'.$id_blog;

	                        if (!file_exists($carpeta)) {
	                            mkdir($carpeta, 0777, true);
	                        }

	                        if (!empty($id_blog)) {
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
	                                    $NombreOriginalPortada = $id_blog."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
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
		                    $datos_blog_edit = $datosBlogRedes->find($id_blog);
		                    $datos_blog_edit->img_portada = $NombreOriginalPortada;
		                    $datos_blog_edit->save();
	                    }else{
	                        $NombreOriginalPortada = "";
	                    }
	                    return 1;
                	}else{
                		return 2;
                	}
                break;
                case 'editaBlog':
                	//print_r($_POST);
                	if (!empty($_POST["id_blog"])) {

                		$datosBlogRedes = Blog::where("id_blog", $_POST['id_blog'])->first();
						$datos_blog_edit = $datosBlogRedes->find($_POST['id_blog']);

						$datos_blog_edit->post_contenido = $_POST["contenido_html"];
						$datos_blog_edit->post_titulo = $_POST["titulo_articulo"];
						$datos_blog_edit->post_estatus = "activo";
						$datos_blog_edit->coment_estatus = 1;
						$datos_blog_edit->post_url = $_POST["url_articulo"];
						$datos_blog_edit->palabras_clave = $_POST["palabras_clave"];
						$datos_blog_edit->meta_descripcion = $_POST["meta_descripcion"];
						$datos_blog_edit->post_fecha_modificado = date('Y-m-d');
						$datos_blog_edit->post_hora_modificado = date('H-i-s');
	                    $datos_blog_edit->save();
	                    
	                    $id_blog = $_POST['id_blog'];
	                    if (!empty($_FILES['img_portada']) AND $_FILES['img_portada']['size'] != 0) {
	                        $carpeta = public_path().'/storage/blog/'.$id_blog;

	                        if (!file_exists($carpeta)) {
	                            mkdir($carpeta, 0777, true);
	                        }

	                        if (!empty($id_blog)) {
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
	                                    $NombreOriginalPortada = $id_blog."_".$objProtegeme->remplaza_caracteres_fotos($key['name']);
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
		                    $datos_blog_edit_img = $datosBlogRedes->find($id_blog);
		                    $datos_blog_edit_img->img_portada = $NombreOriginalPortada;
		                    $datos_blog_edit_img->save();
	                    }else{
	                        $NombreOriginalPortada = "";
	                    }
	                    return 1;
                	}else{
                		return 2;
                	}
                	break;
            }
        }

    }
}
