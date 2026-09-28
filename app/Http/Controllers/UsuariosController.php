<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\User;
use App\LoginLog;

class UsuariosController extends Controller
{
	private $max_row;
	public $id_cotizacion;

	function __construct()
	{
		$this->max_row = 10;
		$this->middleware('auth');
	}
	public function verUsuarios()
	{
		$objUsuarios = new User();
		$listado_usuarios = $objUsuarios->select("*")->paginate($this->max_row);
		return view('app_redes/modulos/usuarios/usuarios', compact('listado_usuarios'));
	}
	public function verRegistrosUsuarios()
	{
		$logs = LoginLog::with('user')
			->orderBy('created_at', 'desc')
			->paginate($this->max_row);

		return view('app_redes/modulos/usuarios/registro_usuarios/registros_usuarios', compact('logs'));
	}

	public function ajax_usuarios(Request $request)
	{
		if ($request->ajax()) {
			$data_post = new \stdClass();
			if (!empty($request->datos)) {
				$data_post = json_decode(json_encode($request->datos));
			}
			if (!empty($request->accion)) {
				switch ($request->accion) {
					case 'openModalUser':
						$accion = $data_post->accion_usr;
						$objUsuarios = User::find($data_post->id_usurio);
						return view('app_redes/modulos/usuarios/modal_usuarios', compact('accion', 'objUsuarios'));
						break;
					case 'editUser':
						$catalogosUsuarios = new User();
						$datos_to_edit = $catalogosUsuarios->find($data_post->id_usuario);
						$datos_to_edit->name = $data_post->nombre_usuario;
						$datos_to_edit->email = $data_post->email_usr;
						$datos_to_edit->password = bcrypt($data_post->password);
						$datos_to_edit->save();
						break;
					case 'ConfirmDesactiva':
						//print_r($data_post);
						$catalogosUsuarios = new User();
						$datos_to_edit = $catalogosUsuarios->find($data_post->num_usuario);
						$datos_to_edit->estatus = 0;
						$datos_to_edit->save();
						break;
					case 'ConfirmActiva':
						//print_r($data_post);
						$catalogosUsuarios = new User();
						$datos_to_edit = $catalogosUsuarios->find($data_post->num_usuario);
						$datos_to_edit->estatus = 1;
						$datos_to_edit->save();
						break;
					case 'ConfirmElimina':
						$catalogosUsuarios = new User();
						$datos_to_delete = $catalogosUsuarios->find($data_post->num_usuario);
						$datos_to_delete->delete();
						break;
					case 'getTablaUsuarios':
						$objUsuarios = new User();
						$listado_usuarios = $objUsuarios->select("*")->paginate($this->max_row);
						return view('app_redes/modulos/usuarios/tabla_listado_usuarios', compact('listado_usuarios'));
						break;
					default:
						# code...
						break;
				}
			}
		}
	}
}
