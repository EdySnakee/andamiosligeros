<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Clientes;
use App\Estados;
use App\Empresas;


class ClientesController extends Controller
{
    function __construct(){
        $this->middleware('auth');
    }
    public function muestraClientes(Request $request){
        //$info_clientes = Clientes::all();
        //$info_clientes = Clientes::all();
		//$datos_json = json_encode($info_clientes);
		
        return view('app_redes/modulos/clientes_web/clientes_web');
    }
    public function ajax_clientes_web(Request $request){
		if ($request->ajax()) {
			$data_post = new \stdClass();
			if(!empty($request->datos)){
				$data_post = json_decode(json_encode($request->datos));
			}
			if (!empty($request->accion)) {
				switch ($request->accion) {
					case 'openAddCliente':
							$catalogo_estados = Estados::all();
							$accion = $data_post->accion_cliente;
							return view('app_redes/modulos/clientes_web/add_cliente/modal_add_cliente', compact('accion', 'catalogo_estados'));
						break;
					case 'AddCliente':
						if (!empty($data_post->nombres_cliente)) {
							$accion = "agregar";
							$objDataCliente = new Clientes();
	                        //$objDataCliente->nombrecl = $data_post->nombres_cliente." ".$data_post->a_paterno." ".$data_post->a_materno;
	                        $objDataCliente->lead = $data_post->numero_lead;
	                        $objDataCliente->nombrecl = $data_post->nombres_cliente;
	                        $objDataCliente->rfccl = $data_post->rfc;
	                        $objDataCliente->direccioncl = $data_post->direccion;
	                        $objDataCliente->cpcl = $data_post->cp;
	                        $objDataCliente->estado = (!empty($data_post->estado) ? $data_post->estado : '');
	                        $objDataCliente->municipio = (!empty($data_post->ciudad_p) ? $data_post->ciudad_p : '');
	                        $objDataCliente->lugarcl = (!empty($data_post->ciudad_p) ? $data_post->ciudad_p : '')." | ".(!empty($data_post->estado) ? $data_post->estado : '');
	                        $objDataCliente->telefonocl = $data_post->telefono;
	                        $objDataCliente->celularcl = $data_post->celular;
	                        $objDataCliente->emailcl = $data_post->email;
	                        $objDataCliente->comentarioscl = $data_post->comentarios;
	                        $objDataCliente->save();

	                        if ($data_post->es_empresa == "true") {
	                        	$objEmpresa = new Empresas();
	                        	$objEmpresa->nombre_empresa = $data_post->nombre_empresa;
		                        $objEmpresa->razon_social = $data_post->r_social;
		                        $objEmpresa->rfc = $data_post->rfc_empresa;
		                        $objEmpresa->estatus = 1;
		                        $objEmpresa->save();

		                        $datos_cliente_edit = $objDataCliente->find($objDataCliente->idcl);
                                $datos_cliente_edit->id_empresa = $objEmpresa->id_empresa;
                                $datos_cliente_edit->save();
	                        }

							return response()->json($objDataCliente);
	                        //$datos_clientes = Clientes::all();
        					//return view('app_redes/modulos/extras/options_clientes', compact('datos_clientes', 'accion'));
						}
					break;
					case 'openEdit':
						$catalogo_estados = Estados::all();
						$accion = "editar";
						$info_cliente = Clientes::find($data_post->id_cliente);

						if (!empty($info_cliente->id_empresa) and $info_cliente->id_empresa >= 1) {
							$objEmpresa = Empresas::find($info_cliente->id_empresa);
						}else{
							$objEmpresa = "";
						}

						return view('app_redes/modulos/clientes_web/add_cliente/modal_add_cliente', compact('accion', 'catalogo_estados', 'info_cliente', 'objEmpresa'));
					break;
					case 'editCliente':
						//print_r($data_post);
						if (!empty($data_post->nombres_cliente)) {
							$objEditDataCliente = Clientes::find($data_post->id_cliente);
	                        //$objEditDataCliente->nombrecl = $data_post->nombres_cliente." ".$data_post->a_paterno." ".$data_post->a_materno;
							$objEditDataCliente->lead = $data_post->numero_lead;
							$objEditDataCliente->nombrecl = $data_post->nombres_cliente;
	                        $objEditDataCliente->rfccl = $data_post->rfc;
	                        $objEditDataCliente->direccioncl = $data_post->direccion;
	                        $objEditDataCliente->cpcl = $data_post->cp;
							$objEditDataCliente->estado = (!empty($data_post->estado) ? $data_post->estado : '');
	                        $objEditDataCliente->municipio = (!empty($data_post->ciudad_p) ? $data_post->ciudad_p : '');
							if (!empty($data_post->estado) ) {
								$objEditDataCliente->lugarcl = (!empty($data_post->ciudad_p) ? $data_post->ciudad_p : '')." | ".(!empty($data_post->estado) ? $data_post->estado : '');
							}
	                        $objEditDataCliente->telefonocl = $data_post->telefono;
	                        $objEditDataCliente->celularcl = $data_post->celular;
	                        $objEditDataCliente->emailcl = $data_post->email;
	                        $objEditDataCliente->comentarioscl = $data_post->comentarios;
	                        $objEditDataCliente->save();

	                        if ($data_post->es_empresa == "true") {
	                        	if (!empty($objEditDataCliente->id_empresa) and $objEditDataCliente->id_empresa >= 1) {
		                        	$objEditEmpresa = Empresas::find($objEditDataCliente->id_empresa);
		                        	$objEditEmpresa->nombre_empresa = $data_post->nombre_empresa;
			                        $objEditEmpresa->razon_social = $data_post->r_social;
			                        $objEditEmpresa->rfc = $data_post->rfc_empresa;
			                        $objEditEmpresa->estatus = 1;
			                        $objEditEmpresa->save();
	                        	}else{
	                        		$objEmpresa = new Empresas();
		                        	$objEmpresa->nombre_empresa = $data_post->nombre_empresa;
			                        $objEmpresa->razon_social = $data_post->r_social;
			                        $objEmpresa->rfc = $data_post->rfc_empresa;
			                        $objEmpresa->estatus = 1;
			                        $objEmpresa->save();

			                        $datos_cliente_edit = $objEditDataCliente->find($objEditDataCliente->idcl);
	                                $datos_cliente_edit->id_empresa = $objEmpresa->id_empresa;
	                                $datos_cliente_edit->save();
	                        	}
	                        }
						}
					break;
					case 'agregaEmpresa':
						return view('app_redes/modulos/extras/options_empresas');
					break;
					case 'confirmDesactivaClient':
						$datosClientes = new Clientes();
                        $datos_to_delete = $datosClientes->find($data_post->id_cliente);
                        $datos_to_delete->delete();
					break;
					case 'muestraTablaClientes':
						//print_r($data_post);
						$info_clientes = Clientes::all();
						$data = array();
						foreach ($info_clientes as $item_cliente) {
							$botonera = '
                            <div class="btn-group"><a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
							    <ul class="dropdown-menu" id="prospecto-menu">
							        <li><button class="btn btn-default col-md-12 btn-dropdown-fix" id="open_edit" id-cliente="'.$item_cliente->idcl.'">Editar</button></li>
							        <li class="divider">
							            <hr>
							        </li>
							        <li><input type="submit" name="confirm_delete_cliente" id="confirm_delete_cliente" id-cliente="'.$item_cliente->idcl.'" value="Eliminar" class="btn btn-default col-md-12 btn-dropdown-fix"></li>
							    </ul>
							</div>
                            ';
							$separador = "|";
							$array_lugar = explode($separador, $item_cliente->lugarcl);
							//print_r($array_lugar);
							$sub_array = array();
                            $sub_array["idcl"] = $item_cliente->idcl;
                            $sub_array["nombrecl"] = $item_cliente->nombrecl;
                            $sub_array["rfccl"] = $item_cliente->rfccl;
                            $sub_array["estado"] = (!empty($array_lugar[1]) ? $array_lugar[1] : '');
                            $sub_array["ciudad"] = (!empty($array_lugar[0]) ? $array_lugar[0] : '');
                            $sub_array["telefonocl"] = $item_cliente->telefonocl;
                            $sub_array["celularcl"] = $item_cliente->celularcl;
                            $sub_array["emailcl"] = $item_cliente->emailcl;
                            $sub_array["botonera"] = $botonera;
                            $data[] = $sub_array;
						}
						$arreglo = array("data"=>$data);
                        echo json_encode($arreglo);
					break;
					case 'dividirLugares':
						$objClientes = new Clientes();

						$datos_clientes = $objClientes::all();

						foreach ($datos_clientes as $item_cliente){
							$separador = "|";
							$array_lugar = explode($separador, $item_cliente->lugarcl);
							$estado = $array_lugar[1];
							$ciudad = $array_lugar[0];
							$find_cliente = $objClientes::find($item_cliente->idcl);
							$find_cliente->estado = $estado;
							$find_cliente->municipio = $ciudad;
							$find_cliente->save();
						}
					break;
					default:
						# code...
						break;
				}
			}
		}
	}
}
