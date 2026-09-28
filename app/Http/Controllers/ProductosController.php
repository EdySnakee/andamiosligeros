<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Protegeme;
use App\Productos;
use App\GiroEmpresas;
use App\DetalleProducto;


class ProductosController extends Controller
{
	function __construct()
	{
		$this->middleware('auth');
	}

	public function verProductos()
	{
		$objProducto = new Productos();
		$listado_productos = $objProducto
			->select("*")
			->from("productos AS pr")
			->join("giro_empresas AS gp", "gp.cod_giro", "=", "pr.giro_producto")
			->where("gp.status", 1)
			->where("pr.status_p", 1)
			->get();

		return view('app_redes/modulos/productos/productos', compact('listado_productos'));
	}
	public function addProductos()
	{
		$accion = "agregar";
		return view('app_redes/modulos/productos/accion_producto/accion_producto', compact('accion'));
	}

	public function editProducto(Request $request)
	{
		//print_r($_POST);
		$accion = "editar";
		//$detalle_producto = Productos::find($_POST['id_producto']);
		$objProducto = new Productos();
		$detalle_producto = $objProducto
			->select("*")
			->from("productos AS pr")
			->join("detalle_producto AS dp", "dp.id_producto", "=", "pr.id_producto")
			->where("pr.id_producto", $_POST['id_producto'])
			->first();
		$objGiroEmpresas = new GiroEmpresas();
		$giroEmpresas = $objGiroEmpresas->selectGiroEmpresas();
		//print_r($detalle_producto);
		return view('app_redes/modulos/productos/accion_producto/accion_producto', compact('accion', "detalle_producto", "giroEmpresas"));
	}
	public function ajax_productos(Request $request)
	{
		$data_post = new \stdClass();
		if (!empty($request->datos)) {
			$data_post = json_decode(json_encode($request->datos));
		}
		if (!empty($request->accion)) {
			switch ($request->accion) {
				case "seleccionaPlantilla":
					$numero_plantilla = $data_post->num_plantilla;
					$objGiroEmpresas = new GiroEmpresas();
					$giroEmpresas = $objGiroEmpresas->selectGiroEmpresas();
					$accion = $data_post->tipo_accion;
					if ($numero_plantilla == 1) {
						return view('app_redes/modulos/productos/accion_producto/plantillas_fichas_tecnicas/plantilla1', compact('accion', 'numero_plantilla', 'giroEmpresas'));
					}
					if ($numero_plantilla == 2) {
						return view('app_redes/modulos/productos/accion_producto/plantillas_fichas_tecnicas/plantilla2', compact('accion', 'numero_plantilla', 'giroEmpresas'));
					}
					break;
				case 'addProducto':
					//print_r($_FILES['imagen_destacada']);
					if (!empty($_POST["nombre_producto"])) {
						//print_r($_POST);
						//$_POST["caracteristicas_producto"];
						//$_POST["extra_info_producto"];
						//print_r($_POST);
						$nomproducto = explode(" ", $_POST["nombre_producto"]);
						$acronimo = "";

						foreach ($nomproducto as $w) {
							$acronimo .= $w[0];
						}

						$datosProductos = new Productos();
						$datosProductos->SKU = $acronimo;
						$datosProductos->num_plantilla = $_POST["num_plantilla"];
						$datosProductos->giro_producto = $_POST["giro_producto"];
						$datosProductos->nombre_p = $_POST["nombre_producto"];
						$datosProductos->tipo_cobro = $_POST["tipo_cobro"];
						if (\Auth::User()->tipo_usuario == "mayorista") {
							$datosProductos->precio_m = $_POST["precio_m"];
						} else {
							$datosProductos->precio = $_POST["precio_p"];
						}
						$datosProductos->status_p = 1;
						$datosProductos->save();

						$id_producto = $datosProductos->id_producto;

						$datosDetalleProductos = new DetalleProducto();
						$datosDetalleProductos->id_producto = $id_producto;
						$datosDetalleProductos->SKU = $acronimo;
						$datosDetalleProductos->descripcion_producto = $_POST["descripcion_producto"];
						$datosDetalleProductos->caracteristicas_producto = $_POST["caracteristicas_producto"];
						$datosDetalleProductos->extra_info_producto = $_POST["extra_info_producto"];
						$datosDetalleProductos->save();

						if (!empty($_FILES['imagen_destacada'])) {
							$carpeta = public_path() . '/storage/productos/' . $id_producto;

							if (!file_exists($carpeta)) {
								mkdir($carpeta, 0777, true);
							}

							if (!empty($id_producto)) {
								$ruta = $carpeta;
								if (!file_exists($ruta)) {
									mkdir($ruta, 0777, true);
								}
								$mensage = '';
								$key = $_FILES['imagen_destacada'];
								$NombreOriginal = "";
								if ($key['error'] == UPLOAD_ERR_OK) {
									if (!empty($key["type"]) and $key["type"] == "image/jpeg" or true) {
										$objProtegeme = new Protegeme();
										// $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
										$NombreOriginal = $id_producto . "_" . $objProtegeme->remplaza_caracteres_fotos($key['name']);
										$temporal = $key['tmp_name'];
										$Destino = $ruta . "/" . $NombreOriginal;
										move_uploaded_file($temporal, $Destino);
									}
								}
								if ($key['error'] == '') {
									$mensage = 'exito';
								}
								if ($key['error'] != '') {
									$mensage = 'fallo';
								}
							}
							if ($mensage == 'exito') {
							}
							if ($mensage == 'fallo') {
							}
							$datos_detalle_producto_edit = $datosDetalleProductos->where("id_producto", "=", $id_producto)->first();
							$datos_detalle_producto_edit->imagen = $NombreOriginal;
							$datos_detalle_producto_edit->save();
						} else {
							$NombreOriginal = "";
						}

						if (!empty($_FILES['banner'])) {
							// Definimos la ruta centralizada para banners
							$carpeta = public_path() . '/storage/productos/banners';

							if (!file_exists($carpeta)) {
								mkdir($carpeta, 0777, true);
							}

							$key = $_FILES['banner'];
							$NombreOriginalBanner = "";

							// Validamos errores y tipo de archivo
							if ($key['error'] == UPLOAD_ERR_OK) {
								if (!empty($key["type"]) and $key["type"] == "image/jpeg" or true) {
									$objProtegeme = new Protegeme();
									// Nombramos: ID_producto + _banner_ + NombreLimpio
									$NombreOriginalBanner = $id_producto . "_banner_" . $objProtegeme->remplaza_caracteres_fotos($key['name']);
									$temporal = $key['tmp_name'];
									$Destino = $carpeta . "/" . $NombreOriginalBanner;
									move_uploaded_file($temporal, $Destino);
								}
							}

							// Guardamos en la BD
							if ($NombreOriginalBanner != "") {
								$datos_detalle_producto_edit = $datosDetalleProductos->where("id_producto", "=", $id_producto)->first();
								$datos_detalle_producto_edit->banner = $NombreOriginalBanner;
								$datos_detalle_producto_edit->save();
							}
						}

						return 1;
						/*
                		*/
					} else {
						return 2;
					}
					break;
				case 'editProducto':
					//print_r($_POST);
					if (!empty($_POST['id_producto'])) {

						$datosProducto = Productos::where("id_producto", $_POST['id_producto'])->first();
						$datos_producto_edit = $datosProducto->find($_POST['id_producto']);

						$datos_producto_edit->num_plantilla = $_POST["num_plantilla"];
						$datos_producto_edit->giro_producto = $_POST["giro_producto"];
						$datos_producto_edit->nombre_p = $_POST["nombre_producto"];
						$datos_producto_edit->tipo_cobro = $_POST["tipo_cobro"];

						if (\Auth::User()->tipo_usuario == "mayorista") {
							$datos_producto_edit->precio_m = $_POST["precio_m"];
						} else {
							$datos_producto_edit->precio = $_POST["precio_p"];
						}

						$datos_producto_edit->save();

						$datosDetalleProductos = DetalleProducto::where("id_producto", $_POST['id_producto'])->first();
						$datos_producto_detalle_edit = $datosDetalleProductos->find($_POST['id_producto']);

						$datosDetalleProductos->descripcion_producto = $_POST["descripcion_producto"];
						$datosDetalleProductos->caracteristicas_producto = $_POST["caracteristicas_producto"];
						$datosDetalleProductos->extra_info_producto = $_POST["extra_info_producto"];
						$datosDetalleProductos->save();

						$id_producto = $_POST['id_producto'];
						if (!empty($_FILES['imagen_destacada']) and $_FILES['imagen_destacada']['size'] != 0) {
							$carpeta = public_path() . '/storage/productos/' . $id_producto;

							if (!file_exists($carpeta)) {
								mkdir($carpeta, 0777, true);
							}

							if (!empty($id_producto)) {
								$ruta = $carpeta;
								if (!file_exists($ruta)) {
									mkdir($ruta, 0777, true);
								}
								$mensage = '';
								$key = $_FILES['imagen_destacada'];
								$NombreOriginal = "";
								if ($key['error'] == UPLOAD_ERR_OK) {
									if (!empty($key["type"]) and $key["type"] == "image/jpeg" or true) {
										$objProtegeme = new Protegeme();
										// $NombreOriginal = $objProtegeme->remplaza_caracteres_fotos($id_proyecto.date('Ymd'));
										$NombreOriginal = $id_producto . "_" . $objProtegeme->remplaza_caracteres_fotos($key['name']);
										$temporal = $key['tmp_name'];
										$Destino = $ruta . "/" . $NombreOriginal;
										move_uploaded_file($temporal, $Destino);
									}
								}
								if ($key['error'] == '') {
									$mensage = 'exito';
								}
								if ($key['error'] != '') {
									$mensage = 'fallo';
								}
							}
							if ($mensage == 'exito') {
							}
							if ($mensage == 'fallo') {
							}
							$datos_detalle_producto_edit = $datosDetalleProductos->where("id_producto", "=", $id_producto)->first();
							$datos_detalle_producto_edit->imagen = $NombreOriginal;
							$datos_detalle_producto_edit->save();
						} else {
							$NombreOriginal = "";
						}

						if (!empty($_FILES['banner']) and $_FILES['banner']['size'] != 0) {
							$id_producto = $_POST['id_producto'];
							$carpeta = public_path() . '/storage/productos/banners';

							if (!file_exists($carpeta)) {
								mkdir($carpeta, 0777, true);
							}

							$key = $_FILES['banner'];
							$NombreOriginalBanner = "";

							if ($key['error'] == UPLOAD_ERR_OK) {
								if (!empty($key["type"]) and $key["type"] == "image/jpeg" or true) {
									$objProtegeme = new Protegeme();
									$NombreOriginalBanner = $id_producto . "_banner_" . $objProtegeme->remplaza_caracteres_fotos($key['name']);
									$temporal = $key['tmp_name'];
									$Destino = $carpeta . "/" . $NombreOriginalBanner;
									move_uploaded_file($temporal, $Destino);
								}
							}

							if ($NombreOriginalBanner != "") {
								$datos_detalle_producto_edit = DetalleProducto::where("id_producto", $id_producto)->first();
								if ($datos_detalle_producto_edit) {
									$datos_detalle_producto_edit->banner = $NombreOriginalBanner;
									$datos_detalle_producto_edit->save();
								}
							}
						}

						return 1;
					} else {
						return 2;
					}
					break;
				case 'confirmElimina':
					$datosProducto = new Productos();
					$datos_to_delete = $datosProducto->find($data_post->id_product);
					$datos_to_delete->delete();
					break;
			}
		}
	}
}
