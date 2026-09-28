<?php

namespace App\Http\Controllers;

use App\CajaChica;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\SaldosCajaChica;
use App\User;
use Carbon\Carbon;
use App\Protegeme;

class CajaChicaController extends Controller
{

    private $id_usuario;
    private $max_row = 100;

    function __construct()
    {
        $this->middleware('auth');
    }

    // Traer USUARIOS
    public function getusuarios()
    {
        // Traer usuarios
        $usuario = new User();

        $usuarios = $usuario
            ->select("*")
            ->get();

        return $usuarios;
    }

    public function getusuariosFiltrados(){

        $usuarios = User::whereIn('id', [14, 16, 29,25,32, 28])->get();

        return $usuarios;
    }

    // Traer HISTORIAL
    public function getHistorial($user_id, $fechaInicio, $fechaFin)
    {
        // Traer el historial de la caja
        $historial = CajaChica::where('user_id', $user_id)
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->orderBy('fecha', 'DESC')
            ->paginate($this->max_row);

        return $historial;
    }

    // Traer MOVIMIENTOS RECIENTES
    public function getMovRecientes($user_id, $fechaInicio, $fechaFin)
    {
        // Traer los 4 movimientos más recientes de la tabla movimientos_caja_chica
        $movRecientes = CajaChica::where('user_id', $user_id)
            ->orderBy('fecha', 'desc')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->limit(4)
            ->get();

        return $movRecientes;
    }

    // Traer INGRESOS
    public function getIngresos($user_id, $fechaInicio, $fechaFin)
    {
        // Calcular el total de ingresos de la tabla movimientos_caja_chica
        $totalIngresos = CajaChica::where('user_id', $user_id)
            ->where('tipo_movimiento', 'ingreso')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('monto');

        return $totalIngresos;
    }

    // Traer GASTOS
    public function getGastos($user_id, $fechaInicio, $fechaFin)
    {
        // Calcular el total de ingresos de la tabla movimientos_caja_chica
        $totalGastos = CajaChica::where('user_id', $user_id)
            ->where('tipo_movimiento', 'gasto')
            ->whereBetween('fecha', [$fechaInicio, $fechaFin])
            ->sum('monto');

        return $totalGastos;
    }

    // Traer SALDO ACTUALIZADOS
    public function getSaldo($user_id)
    {
        // Traer el último saldo usando el campo fecha_actualizacion
        $saldoActual = SaldosCajaChica::where('user_id', $user_id)
            ->orderBy('fecha_actualizacion', 'desc')
            ->first(); // Obtener el primer registro

        return $saldoActual ? $saldoActual->saldo : null;
    }

    // INIt -> validacion de usuario para caja-chica
    public function vistaCaja()
    {
        if (!empty(\Auth::User()->tipo_usuario) and \Auth::User()->estatus == 1) {

            $id_usuario = \Auth::User()->id;

            $fechaInicio = Carbon::now()->startOfMonth()->toDateString();
            $fechaFin = Carbon::now()->endOfMonth()->toDateString();


            $ingresos = $this->getIngresos($id_usuario, $fechaInicio, $fechaFin);

            $gastos = $this->getGastos($id_usuario, $fechaInicio, $fechaFin);

            $movRecientes = $this->getMovRecientes($id_usuario, $fechaInicio, $fechaFin);

            $historial = $this->getHistorial($id_usuario, $fechaInicio, $fechaFin);

            $saldo = $this->getSaldo($id_usuario);

            $usuarios = $this->getusuariosFiltrados();

            // Retornar la vista con todas las variables
            return view('app_redes/modulos/caja_chica/view/caja_chica', compact(
                'ingresos',
                'usuarios',
                'gastos',
                'saldo',
                'movRecientes',
                'historial',
            ));
        } else {
            return \Redirect::to('logout');
        }
    }

    // AJAX de caja-chica (path_caja_ajax)
    public function ajax_caja_chica(Request $request)
    {
        $data_post = new \stdClass();
        if (!empty($request->datos)) {
            $data_post = json_decode(json_encode($request->datos));
        }
        if ($request->ajax()) {
            switch ($request->accion) {
                case 'guardarRegistro':
                    // Obtener los datos directamente del request
                    $id_usuario = $request->id_user != 0 ? $request->id_user : \Auth::User()->id;
                    $tipo_movimiento = $request->tipo_movimiento;
                    $monto = $request->monto;
                    $descripcion = $request->descripcion;

                    // Crear el registro de caja chica
                    $caja_chica = new CajaChica();

                    if (!empty($_FILES["comprobante"])) {
                        $array_tipo = explode("/", $_FILES["comprobante"]["type"]);

                        $carpeta = public_path() . '/storage/comprobantes/' . $id_usuario . '/' . Carbon::now()->format('Y-m');

                        if (!file_exists($carpeta)) {
                            mkdir($carpeta, 0777, true);
                        }
                        $ruta = $carpeta;
                        if (!file_exists($ruta)) {
                            mkdir($ruta, 0777, true);
                        }
                        $mensage = '';
                        $key = $_FILES["comprobante"];
                        $NombreOriginal = "";
                        if ($key['error'] == UPLOAD_ERR_OK) {
                            if (!empty($key["type"]) and $key["type"] == "image/jpeg" or $key["type"] == "image/png" or $key["type"] == "application/pdf" or true) {
                                $objProtegeme = new Protegeme();
                                $NombreOriginal = $id_usuario . '/' . Carbon::now()->format('Y-m') . '/' . $objProtegeme->remplaza_caracteres_fotos($key['name']);
                                $NombreRuta = $objProtegeme->remplaza_caracteres_fotos($key['name']);
                                $temporal = $key['tmp_name'];
                                $Destino = $ruta . "/" . $NombreRuta;
                                move_uploaded_file($temporal, $Destino);
                            }
                        }

                        if ($key['error'] == '') {
                            $mensage = 'exito';
                        }
                        if ($key['error'] != '') {
                            $mensage = 'fallo';
                        }

                        $caja_chica->comprobante = $NombreOriginal;
                    }

                    $caja_chica->user_id = $id_usuario;
                    $caja_chica->tipo_movimiento = $tipo_movimiento;
                    $caja_chica->monto = $monto;
                    $caja_chica->descripcion = $descripcion;

                    $caja_chica->save();

                    // Actualizar el saldo del usuario
                    $saldo_actual = SaldosCajaChica::where('user_id', $id_usuario)->latest('fecha_actualizacion')->first();

                    if ($saldo_actual) {
                        $saldo_actual->saldo += $tipo_movimiento === 'ingreso' ? $monto : -$monto;
                        $saldo_actual->save();
                    } else {
                        $nuevo_saldo = new SaldosCajaChica();
                        $nuevo_saldo->user_id = $id_usuario;
                        $nuevo_saldo->saldo = $tipo_movimiento === 'ingreso' ? $monto : -$monto;
                        $nuevo_saldo->save();
                    }

                    return response()->json([
                        'status' => 'success',
                        'message' => 'Registro guardado correctamente',
                    ], 200);
                    break;

                case 'actualizarRegistro':
                    $caja_chica = CajaChica::find($request->id);

                    $id_usuario = $caja_chica->user_id;
                    $monto_anterior = $caja_chica->monto;
                    $tipo_movimiento_anterior = $caja_chica->tipo_movimiento;

                    if ($caja_chica) {
                        if (!empty($_FILES["comprobante"])) {
                            $array_tipo = explode("/", $_FILES["comprobante"]["type"]);
                            //print_r($array_tipo["1"]);

                            $carpeta = public_path() . '/storage/comprobantes/' . $id_usuario . '/' . Carbon::now()->format('Y-m');


                            if (!file_exists($carpeta)) {
                                mkdir($carpeta, 0777, true);
                            }
                            $ruta = $carpeta;
                            if (!file_exists($ruta)) {
                                mkdir($ruta, 0777, true);
                            }
                            $mensage = '';
                            $key = $_FILES["comprobante"];
                            $NombreOriginal = "";
                            if ($key['error'] == UPLOAD_ERR_OK) {
                                if (!empty($key["type"]) and $key["type"] == "image/jpeg" or $key["type"] == "image/png" or $key["type"] == "application/pdf" or true) {
                                    $objProtegeme = new Protegeme();
                                    $NombreOriginal = $id_usuario . '/' . Carbon::now()->format('Y-m') . '/' . $objProtegeme->remplaza_caracteres_fotos($key['name']);
                                    $NombreRuta = $objProtegeme->remplaza_caracteres_fotos($key['name']);
                                    $temporal = $key['tmp_name'];
                                    $Destino = $ruta . "/" . $NombreRuta;
                                    move_uploaded_file($temporal, $Destino);
                                    $caja_chica->comprobante = $NombreOriginal;
                                }
                            }

                            if ($key['error'] == '') {
                                $mensage = 'exito';
                            }
                            if ($key['error'] != '') {
                                $mensage = 'fallo';
                            }
                        }

                        // Actualizar los datos
                        $caja_chica->tipo_movimiento = $request->tipo_movimiento;
                        $caja_chica->monto = $request->monto;
                        $caja_chica->descripcion = $request->descripcion;

                        $caja_chica->save();

                        // Ajustar el saldo
                        $saldo_actual = SaldosCajaChica::where('user_id', $caja_chica->user_id)->latest('fecha_actualizacion')->first();
                        if ($saldo_actual) {
                            $saldo_actual->saldo += ($tipo_movimiento_anterior === 'ingreso' ? -$monto_anterior : $monto_anterior);
                            $saldo_actual->saldo += ($request->tipo_movimiento === 'ingreso' ? $request->monto : -$request->monto);
                            $saldo_actual->save();
                        }

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Registro actualizado correctamente',
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Registro no encontrado',
                        ], 404);
                    }
                    break;
                case 'eliminarRegistro':
                    // Datos del modal
                    $datos = $data_post;

                    // Buscar el registro a eliminar por ID
                    $caja_chica = CajaChica::find($datos->id);

                    if ($caja_chica) {
                        // Guardar los valores anteriores para ajustar el saldo correctamente
                        $monto_anterior = $caja_chica->monto;
                        $tipo_movimiento_anterior = $caja_chica->tipo_movimiento;

                        // Obtener el saldo actual del usuario
                        $saldo_actual = SaldosCajaChica::where('user_id', $caja_chica->user_id)->latest('fecha_actualizacion')->first();

                        // Ajustar el saldo basado en el tipo de movimiento del registro eliminado
                        if ($saldo_actual) {
                            // Revertir el monto anterior
                            $saldo_actual->saldo += ($tipo_movimiento_anterior === 'ingreso') ? -$monto_anterior : $monto_anterior;
                            $saldo_actual->save();
                        }

                        // Eliminar el registro de caja chica
                        $caja_chica->delete();

                        return response()->json([
                            'status' => 'success',
                            'message' => 'Registro eliminado',
                        ], 200);
                    } else {
                        return response()->json([
                            'status' => 'error',
                            'message' => 'Registro no encontrado',
                        ], 404);
                    }
                    break;
                case 'userCajaChica':
                    // Datos del usuario a buscar
                    $id_usuario = $data_post->id;


                    if ($data_post->fecha_inicio == '') {
                        $fechaInicio = Carbon::now()->startOfMonth()->toDateString();
                        $fechaFin = Carbon::now()->endOfMonth()->toDateString();
                    } else {
                        $fechaInicio = $data_post->fecha_inicio;
                        $fechaFin = $data_post->fecha_fin;
                    }

                    // Obtener la información relacionada con la caja chica del usuario
                    $ingresos = $this->getIngresos($id_usuario, $fechaInicio, $fechaFin);
                    $gastos = $this->getGastos($id_usuario, $fechaInicio, $fechaFin);
                    $saldo = $this->getSaldo($id_usuario);
                    $movRecientes = $this->getMovRecientes($id_usuario, $fechaInicio, $fechaFin);
                    $historial = $this->getHistorial($id_usuario, $fechaInicio, $fechaFin);

                    // Retornar la respuesta en formato JSON para el frontend
                    return response()->json([
                        'status' => 'success',
                        'ingresos' => $ingresos,
                        'gastos' => $gastos,
                        'saldo' => $saldo,
                        'movRecientes' => $movRecientes,
                        'historial' => $historial,
                    ], 200);
                    break;
            }
        }
    }
}
