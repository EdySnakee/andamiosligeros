<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Ventas;
use \Auth;
class VentasController extends Controller
{
    private $max_row;
    function __construct(){
        $this->max_row = 10;
        $this->middleware('auth');
    }

    public function verVentas(){
        $objVentas = new Ventas();
        $usuario_id = \Auth::User()->id;
        $tipo_usuario = \Auth::User()->tipo_usuario;

        if ($tipo_usuario == 'f1' || $tipo_usuario == 'n2') {
            //FILTRAR F1 Y N2
            $listado_ventas = $objVentas
                ->select("vet.*", "cli.*", "us.*", "ordenes_taller.estatus as estatus_taller")
                ->from("ventas AS vet")
                ->join("clientes AS cli", "cli.idcl", "=", "vet.id_cliente")
                ->leftjoin("users AS us", "us.id", "=", "vet.id_usuario_genera")
                ->leftjoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'vet.id_cotizacion')
                ->where("vet.id_usuario_genera", $usuario_id)
                ->where("vet.giro_empresa", "al")
                ->orderBy('vet.id_venta', 'DESC')
                ->paginate($this->max_row);
        } else {
            $listado_ventas = $objVentas
                        ->select("vet.*", "cli.*", "us.*", "ordenes_taller.estatus as estatus_taller")
                        ->from("ventas AS vet")
                        ->join("clientes AS cli", "cli.idcl", "=", "vet.id_cliente")
                        ->leftjoin("users AS us", "us.id", "=", "vet.id_usuario_genera")
                        ->leftjoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'vet.id_cotizacion')
                        ->where("vet.giro_empresa", "al")
                        ->orderBy('vet.id_venta', 'DESC')
                        ->paginate($this->max_row);
        }

        return view('app_redes/modulos/ventas/listado_ventas', compact('listado_ventas'));
    }

    public function ajax_ventas(Request $request){
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if(!empty($request->datos)){
                $data_post = json_decode(json_encode($request->datos));
            }
            if (!empty($request->accion)) {
            	switch ($request->accion) {
            		case 'getTablaVentas':
                        $objVentas = new Ventas();
                        $this->max_row = (!empty($data_post->max_row)) ? $data_post->max_row : $this->max_row;

                        $condicion_filtro = (!empty($data_post->filtro_status_ventas)) ? ' vet.status like \'%'.$data_post->filtro_status_ventas.'%\'' : 1;
                        $condicion_filtro .= (!empty($data_post->filtrar_busqueda)) ? ' AND cli.nombrecl like \'%'.$data_post->filtrar_busqueda.'%\'' : ' AND 1';

                        $condicion_filtro .= (!empty($data_post->filtrar_busqueda_usuario)) ? ' AND us.name like \'%'.$data_post->filtrar_busqueda_usuario.'%\'' : ' AND 1';

                        $condicion_filtro .= (!empty($data_post->filtrar_giro_empresa)) ? ' AND vet.giro_empresa like \'%'.$data_post->filtrar_giro_empresa.'%\'' : ' AND 1';

                        $condicion_filtro .= (!empty($data_post->filtrar_busqueda_venta)) ? ' AND vet.id_cotizacion like \'%'.$data_post->filtrar_busqueda_venta.'%\'' : ' AND 1';

                        // $condicion_filtro .= (!empty($data_post->filtrar_busqueda_fecha)) ? ' AND vet.fecha_venta like \'%'.$data_post->filtrar_busqueda_fecha.'%\'' : ' AND 1';

                        if (!empty($data_post->filtrar_busqueda_fecha_inicio) && !empty($data_post->filtrar_busqueda_fecha_final)) {
                            $condicion_filtro .= ' AND vet.fecha_venta BETWEEN \'' . $data_post->filtrar_busqueda_fecha_inicio . '\' AND \'' . $data_post->filtrar_busqueda_fecha_final . '\'';
                        }

                        $usuario_id = \Auth::User()->id;
                        $tipo_usuario = \Auth::User()->tipo_usuario;
                
                        if ($tipo_usuario == 'f1' || $tipo_usuario == 'n2') {
                            //FILTRO DEL LISTADO DE VENTAS DE ZOILA
                            $listado_ventas = $objVentas
                                ->select("vet.*", "cli.*", "us.*", "ordenes_taller.estatus as estatus_taller")
                                ->from("ventas AS vet")
                                ->join("clientes AS cli", "cli.idcl", "=", "vet.id_cliente")
                                ->leftjoin("users AS us", "us.id", "=", "vet.id_usuario_genera")
                                ->leftjoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'vet.id_cotizacion')
                                ->where("vet.id_usuario_genera", $usuario_id)
                                ->where("vet.giro_empresa", "al")
                                ->whereRaw($condicion_filtro)
                                ->orderBy('vet.id_venta', 'DESC')
                                ->paginate($this->max_row);
                        }
                        else{
                            $listado_ventas = $objVentas
                                 ->select("vet.*", "cli.*", "us.*", "ordenes_taller.estatus as estatus_taller")
                                 ->from("ventas AS vet")
                                 ->join("clientes AS cli", "cli.idcl", "=", "vet.id_cliente")
                                 ->leftjoin("users AS us", "us.id", "=", "vet.id_usuario_genera")
                                 ->leftjoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'vet.id_cotizacion')
                                 ->where("vet.giro_empresa", "al")
                                 ->whereRaw($condicion_filtro)
                                 ->orderBy('vet.id_venta', 'DESC')
                                 ->paginate($this->max_row);
                        }

                        //dd($data_post);

                        return view('app_redes/modulos/ventas/tabla_listado_ventas', compact('listado_ventas'));
                    
                    break;
                    case 'confirmTerminaVta':
                        $datosVenta = new Ventas();
                        $cambia_estatus = $datosVenta->find($data_post->id_vta);
                        $cambia_estatus->status = 4;
                        $cambia_estatus->save();    
                    break;
                    case 'guardarLogisticaEnvio':
                        $this->checkLogisticaColumns();
                        $datosVenta = new Ventas();
                        $add_venta = $datosVenta->find($data_post->id_vta);
                        if ($add_venta) {
                            // Costo de envío cobrado al cliente
                            if (isset($data_post->envio)) {
                                $add_venta->envio = (float) $data_post->envio;
                            }

                            // Origen y destino
                            if (isset($data_post->origen)) {
                                $add_venta->origen = trim($data_post->origen) !== '' ? trim($data_post->origen) : null;
                            }
                            if (isset($data_post->destino)) {
                                $add_venta->destino = trim($data_post->destino) !== '' ? trim($data_post->destino) : null;
                            }

                            // Envío Paquetería 1
                            if (isset($data_post->paqueteria)) {
                                $add_venta->paqueteria = trim($data_post->paqueteria) !== '' ? trim($data_post->paqueteria) : null;
                            }
                            if (isset($data_post->envio_paqueteria)) {
                                $add_venta->envio_paqueteria = ($data_post->envio_paqueteria !== '' && $data_post->envio_paqueteria !== null)
                                    ? (float) $data_post->envio_paqueteria
                                    : null;
                            }
                            if (!empty($data_post->fecha_envio_paqueteria)) {
                                $add_venta->fecha_envio_paqueteria = $data_post->fecha_envio_paqueteria;
                            } elseif (!empty($add_venta->envio_paqueteria) && empty($add_venta->fecha_envio_paqueteria)) {
                                $add_venta->fecha_envio_paqueteria = date('Y-m-d');
                            }

                            // Segundo envío paquetería y ruta (opcional)
                            if (!empty($data_post->habilitar_segundo_envio)) {
                                $add_venta->envio_2 = (isset($data_post->envio_2) && $data_post->envio_2 !== '' && $data_post->envio_2 !== null)
                                    ? (float) $data_post->envio_2
                                    : null;
                                $add_venta->origen_2 = isset($data_post->origen_2) && trim($data_post->origen_2) !== '' ? trim($data_post->origen_2) : null;
                                $add_venta->destino_2 = isset($data_post->destino_2) && trim($data_post->destino_2) !== '' ? trim($data_post->destino_2) : null;

                                $add_venta->paqueteria_2 = !empty($data_post->paqueteria_2) ? trim($data_post->paqueteria_2) : null;
                                $add_venta->envio_paqueteria_2 = (isset($data_post->envio_paqueteria_2) && $data_post->envio_paqueteria_2 !== '' && $data_post->envio_paqueteria_2 !== null)
                                    ? (float) $data_post->envio_paqueteria_2
                                    : null;
                                if (!empty($data_post->fecha_envio_paqueteria_2)) {
                                    $add_venta->fecha_envio_paqueteria_2 = $data_post->fecha_envio_paqueteria_2;
                                } elseif (!empty($add_venta->envio_paqueteria_2) && empty($add_venta->fecha_envio_paqueteria_2)) {
                                    $add_venta->fecha_envio_paqueteria_2 = date('Y-m-d');
                                }
                            } else {
                                // Si no está habilitado el 2do envío, se limpian sus campos
                                $add_venta->envio_2 = null;
                                $add_venta->origen_2 = null;
                                $add_venta->destino_2 = null;
                                $add_venta->paqueteria_2 = null;
                                $add_venta->envio_paqueteria_2 = null;
                                $add_venta->fecha_envio_paqueteria_2 = null;
                            }

                            // Si la venta está en "Iniciado" (2) y hay monto de paquetería > 0, pasar a "Enviado" (5) automáticamente
                            $costoTotalPaq = (float) ($add_venta->envio_paqueteria ?? 0) + (float) ($add_venta->envio_paqueteria_2 ?? 0);
                            if ($add_venta->status == 2 && $costoTotalPaq > 0) {
                                $add_venta->status = 5;
                            }

                            $add_venta->save();
                            return response()->json(['success' => true]);
                        }
                        return response()->json(['success' => false, 'message' => 'Venta no encontrada'], 404);
                        break;
                    case 'addEnvio':
                    $datosVenta = new Ventas(); 
                    $add_venta = $datosVenta->find($data_post->id_vta); 
                    $add_venta->envio = $data_post->envio; 
                    $add_venta->save(); 
                    break;
                    case 'addEnvioPaqueteria':
                    $datosVenta = new Ventas();
                    $add_venta = $datosVenta->find($data_post->id_vta);
                    $add_venta->envio_paqueteria = $data_post->envio_paqueteria;
                    // Solo establece la fecha si aún no tenía un valor previo (created_at propio)
                    if (empty($add_venta->fecha_envio_paqueteria)) {
                        $add_venta->fecha_envio_paqueteria = date('Y-m-d');
                    }
                    // Si la venta está en "Iniciado" (2) y el monto es > 0, pasar a "Enviado" (5) automáticamente
                    // Pero NO actualizar la orden de taller (solicitud del usuario)
                    if ($add_venta->status == 2 && $data_post->envio_paqueteria > 0) {
                        $add_venta->status = 5;
                    }
                    $add_venta->save();
                    break;
                    case 'addPaqueteria':
                    $datosVenta = new Ventas();
                    $add_venta = $datosVenta->find($data_post->id_vta);
                    $add_venta->paqueteria = $data_post->paqueteria;
                    $add_venta->save();
                    break;
                    case 'addOrigen':
                    $datosVenta = new Ventas();
                    $add_venta = $datosVenta->find($data_post->id_vta);
                    $add_venta->origen = $data_post->origen;
                    $add_venta->save();
                    break;
                    case 'addDestino':
                    $datosVenta = new Ventas();
                    $add_venta = $datosVenta->find($data_post->id_vta);
                    $add_venta->destino = $data_post->destino;
                    $add_venta->save();
                    break;
				default:
            			# code...
            			break;
            	}
            }
        }
    }

    /**
     * Asegura que existan las columnas para el segundo envío en la base de datos si aún no existen.
     */
    private function checkLogisticaColumns()
    {
        static $checked = false;
        if ($checked) {
            return;
        }
        $checked = true;
        try {
            $cols = \DB::select("SHOW COLUMNS FROM ventas LIKE 'envio_paqueteria_2'");
            if (empty($cols)) {
                \DB::statement("ALTER TABLE ventas 
                    ADD COLUMN envio_paqueteria_2 DECIMAL(10,2) NULL AFTER fecha_envio_paqueteria,
                    ADD COLUMN paqueteria_2 VARCHAR(100) NULL AFTER envio_paqueteria_2,
                    ADD COLUMN fecha_envio_paqueteria_2 DATE NULL AFTER paqueteria_2");
            }

            $colsEnvio2 = \DB::select("SHOW COLUMNS FROM ventas LIKE 'envio_2'");
            if (empty($colsEnvio2)) {
                \DB::statement("ALTER TABLE ventas 
                    ADD COLUMN envio_2 DECIMAL(10,2) NULL AFTER envio,
                    ADD COLUMN origen_2 VARCHAR(150) NULL AFTER origen,
                    ADD COLUMN destino_2 VARCHAR(255) NULL AFTER destino");
            }
        } catch (\Exception $e) {
            \Log::error("Error asegurando columnas de logística 2: " . $e->getMessage());
        }
    }

    public function exportarVentas(Request $request)
    {
        $objVentas = new Ventas();
        $usuario_id = \Auth::User()->id;
        $tipo_usuario = \Auth::User()->tipo_usuario;

        // Aplicar los mismos filtros que getTablaVentas
        $condicion_filtro = (!empty($request->filtro_status_ventas)) ? ' vet.status like \'%'.$request->filtro_status_ventas.'%\'' : 1;
        $condicion_filtro .= (!empty($request->filtrar_busqueda)) ? ' AND cli.nombrecl like \'%'.$request->filtrar_busqueda.'%\'' : ' AND 1';
        $condicion_filtro .= (!empty($request->filtrar_busqueda_usuario)) ? ' AND us.name like \'%'.$request->filtrar_busqueda_usuario.'%\'' : ' AND 1';
        $condicion_filtro .= (!empty($request->filtrar_giro_empresa)) ? ' AND vet.giro_empresa like \'%'.$request->filtrar_giro_empresa.'%\'' : ' AND 1';
        $condicion_filtro .= (!empty($request->filtrar_busqueda_venta)) ? ' AND vet.id_cotizacion like \'%'.$request->filtrar_busqueda_venta.'%\'' : ' AND 1';

        if (!empty($request->filtrar_busqueda_fecha_inicio) && !empty($request->filtrar_busqueda_fecha_final)) {
            $condicion_filtro .= ' AND vet.fecha_venta BETWEEN \'' . $request->filtrar_busqueda_fecha_inicio . '\' AND \'' . $request->filtrar_busqueda_fecha_final . '\'';
        }

        $query = $objVentas
            ->select('vet.*', 'cli.nombrecl', 'us.name')
            ->from('ventas AS vet')
            ->join('clientes AS cli', 'cli.idcl', '=', 'vet.id_cliente')
            ->leftjoin('users AS us', 'us.id', '=', 'vet.id_usuario_genera')
            ->where('vet.giro_empresa', 'al')
            ->whereRaw($condicion_filtro)
            ->orderBy('vet.id_venta', 'DESC');

        if ($tipo_usuario == 'f1' || $tipo_usuario == 'n2') {
            $query->where('vet.id_usuario_genera', $usuario_id);
        }

        $ventas = $query->get();

        $statusMap = [2 => 'Iniciado', 3 => 'Pendiente', 4 => 'Terminado', 5 => 'Enviado'];

        $this->checkLogisticaColumns();

        $headers = [
            'COD Venta', 'Cliente', 'Fecha', 'IVA', 'Descuento', 'Total', 'Envío', 'Envío 2',
            'Estatus', 'Envío Paquetería', 'Paquetería', 'Fecha Env. Paquetería',
            'Envío Paquetería 2', 'Paquetería 2', 'Fecha Env. Paquetería 2',
            'Origen', 'Origen 2', 'Destino', 'Destino 2', 'Vendió'
        ];

        $filename = 'ventas_' . date('Y-m-d_His') . '.csv';

        $callback = function() use ($ventas, $headers, $statusMap) {
            $file = fopen('php://output', 'w');
            // BOM para que Excel abra UTF-8 correctamente
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));
            fputcsv($file, $headers);
            foreach ($ventas as $v) {
                fputcsv($file, [
                    $v->cod_venta,
                    $v->nombrecl,
                    $v->fecha_venta_formato,
                    '$' . number_format($v->iva, 2, '.', ','),
                    $v->porcentaje_descuento != 0 ? 'Si' : 'No',
                    '$' . number_format($v->total, 2, '.', ','),
                    '$' . number_format($v->envio, 2, '.', ','),
                    !empty($v->envio_2) ? '$' . number_format($v->envio_2, 2, '.', ',') : '',
                    isset($statusMap[$v->status]) ? $statusMap[$v->status] : $v->status,
                    $v->envio_paqueteria ? '$' . number_format($v->envio_paqueteria, 2, '.', ',') : '',
                    $v->paqueteria ?? '',
                    $v->fecha_envio_paqueteria ?? '',
                    !empty($v->envio_paqueteria_2) ? '$' . number_format($v->envio_paqueteria_2, 2, '.', ',') : '',
                    $v->paqueteria_2 ?? '',
                    $v->fecha_envio_paqueteria_2 ?? '',
                    $v->origen ?? '',
                    $v->origen_2 ?? '',
                    $v->destino ?? '',
                    $v->destino_2 ?? '',
                    $v->name ?? $v->id_usuario_genera,
                ]);
            }
            fclose($file);
        };

        return response()->stream($callback, 200, [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => 'attachment; filename="' . $filename . '"',
        ]);
    }
}
