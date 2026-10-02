<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Cotizaciones;
use App\Sucursales;
use App\Ventas;
use \Auth;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use App\User;

class EstadisticasController extends Controller
{
    // ESTADISTICAS VENTAS -> 
    public function showEstVentas()
    {
        $ventas = new Ventas();
        $cotizaciones = new Cotizaciones();

        // Estadísticas generales
        $totalVentas = $ventas->sum('total');
        $numeroVentas = $ventas->count();
        $promedioVentas = $ventas->avg('total');
        $numCotizaciones = $cotizaciones->count();
        $totalCotizaciones = $cotizaciones->sum('total');

        $totalIVA = $ventas->sum('iva');
        $totalEnvios = $ventas->sum('envio') + (float) ($ventas->sum('envio_2') ?? 0);
        $totalEnviosPaqueteria = $ventas->sum('envio_paqueteria') + (float) ($ventas->sum('envio_paqueteria_2') ?? 0);

        $totalNeto = $totalVentas - $totalIVA - $totalEnvios;

        // Formatear
        $totalVentas = number_format($totalVentas, 2);
        $totalCotizaciones = number_format($totalCotizaciones, 2);
        $promedioVentas = number_format($promedioVentas, 2);
        $totalIVA = number_format($totalIVA, 2);
        $totalEnvios = number_format($totalEnvios, 0);
        $totalEnviosPaqueteria = number_format($totalEnviosPaqueteria, 0);
        $totalNeto = number_format($totalNeto, 2);


        // Estadísticas vendedores
        $vendedoresPrin = $this->getVendedoresPrin();

        //Estadisticas productos mas vendido
        $productosMasVendidos = $this->getProductosMasVendidos();

        return view(
            'app_redes/modulos/estadisticas/ventas/view/est_ventas',
            compact(
                'totalVentas',
                'numeroVentas',
                'totalNeto',
                'totalCotizaciones',
                'numCotizaciones',
                'promedioVentas',
                'vendedoresPrin',
                'totalIVA',
                'totalEnvios',
                'totalEnviosPaqueteria',
                'productosMasVendidos'
            )
        );
    }

    private function getProductosMasVendidos($fechaInicio = null, $fechaFin = null, $limit = 8)
    {
        $query = DB::table('ventas')
            ->join('detalle_cotizaciones', 'ventas.id_cotizacion', '=', 'detalle_cotizaciones.id_cotizacion')
            ->select(
                'detalle_cotizaciones.id_producto',
                'detalle_cotizaciones.nombre_producto as nombre',
                DB::raw('SUM(detalle_cotizaciones.cantidad) as cantidad_vendida'),
                DB::raw('SUM(detalle_cotizaciones.total_ind) as total_vendido')
            );

        if ($fechaInicio && $fechaFin) {
            $query->whereBetween('ventas.fecha_venta', [$fechaInicio, $fechaFin]);
        }

        $productos = $query
            ->groupBy('detalle_cotizaciones.id_producto', 'detalle_cotizaciones.nombre_producto')
            ->orderBy('cantidad_vendida', 'desc')
            ->limit($limit)
            ->get();

        $productos = collect($productos);

        if ($productos->isEmpty()) {
            return collect();
        }

        $maxCantidad = $productos->max('cantidad_vendida');

        return $productos->map(function ($producto) use ($maxCantidad) {
            $producto->porcentaje = $maxCantidad > 0
                ? round(($producto->cantidad_vendida / $maxCantidad) * 100, 1)
                : 0;
            $producto->total_vendido = number_format($producto->total_vendido, 2);
            return $producto;
        });
    }

    public function showEstCotizaciones()
    {
        // Regresar la vista
        return view('app_redes/modulos/estadisticas/cotizaciones/view/est_cotizaciones');
    }


    public function getVendedoresPrin($fechaInicio = null, $fechaFin = null)
    {
        $ventas = new Ventas();
        $cotizaciones = new Cotizaciones(); // Modelo de cotizaciones

        // Si se proporcionan fechas, aplicar el filtro
        if ($fechaInicio && $fechaFin) {
            $ventas = $ventas->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
            $cotizaciones = $cotizaciones->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $vendedores = $ventas
            ->select(
                'id_usuario_genera',
                DB::raw('COUNT(*) as numero_ventas'),
                DB::raw('SUM(total) as total_generado')
            )
            ->groupBy('id_usuario_genera')
            ->orderBy('total_generado', 'desc')
            ->get();

        // Calcular datos adicionales
        $vendedores = $vendedores->map(function ($vendedor) use ($cotizaciones, $fechaInicio, $fechaFin) {
            // Datos de cotizaciones
            $cotis = (clone $cotizaciones)
                ->where('id_usuario_genera', $vendedor->id_usuario_genera)
                ->get();

            $vendedor->numero_cotizaciones = $cotis->count(); // Número de cotizaciones
            $vendedor->total_cotizado = $cotis->sum('total'); // Total cotizado

            // Calcular promedio de éxito
            $vendedor->promedio_exito = $vendedor->numero_cotizaciones > 0
                ? round(($vendedor->numero_ventas / $vendedor->numero_cotizaciones) * 100, 2)
                : 0;

            // Cliente estrella: Venta con el total más alto dentro del rango de fechas
            $clienteEstrella = Ventas::where('id_usuario_genera', $vendedor->id_usuario_genera)
                ->when($fechaInicio && $fechaFin, function ($query) use ($fechaInicio, $fechaFin) {
                    return $query->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
                })
                ->orderBy('total', 'desc')
                ->first();

            if ($clienteEstrella && $clienteEstrella->id_cliente) {
                $cliente = DB::table('clientes')->where('idcl', $clienteEstrella->id_cliente)->first();
                $vendedor->cliente_estrella = $cliente ? $cliente->nombrecl : 'N/A';
            } else {
                $vendedor->cliente_estrella = 'N/A';
            }

            // Obtener nombre del vendedor
            $usuario = DB::table('users')->where('id', $vendedor->id_usuario_genera)->first();
            $vendedor->nombre = $usuario ? $usuario->name : 'Desconocido';

            // Formatear totales
            $vendedor->total_generado = number_format($vendedor->total_generado, 2);
            $vendedor->total_cotizado = number_format($vendedor->total_cotizado, 2);

            return $vendedor;
        });

        return $vendedores;
    }

    // Traer USUARIOS
    public function getUsuarios()
    {
        // Traer usuarios
        $usuario = new User();

        $usuarios = $usuario
            ->select("*")
            ->get();

        return $usuarios;
    }

    // Traer USUARIOS
    public function getSucursales()
    {
        // Traer usuarios
        $sucursal = new Sucursales();

        $sucursales = $sucursal
            ->select("*")
            ->get();

        return $sucursales;
    }

    public function ajax_est_ventas(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }

            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'estVentas':
                        $fechaInicio = $data_post->fecha_inicio ?? null;
                        $fechaFin = $data_post->fecha_fin ?? null;

                        if (!$fechaInicio || !$fechaFin) {
                            return response()->json(['error' => 'Fechas requeridas'], 400);
                        }

                        // Query base (una sola vez)
                        $qVentas = Ventas::query()->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
                        $qCotizaciones = Cotizaciones::query()->whereBetween('fecha', [$fechaInicio, $fechaFin]);

                        // Agregados
                        $totalVentas = (float) $qVentas->sum('total');
                        $numeroVentas = (int) $qVentas->count();
                        $promedioVentas = (float) $qVentas->avg('total');

                        // Nuevos agregados
                        $totalIVA = (float) $qVentas->sum('iva');
                        $totalEnvios = (float) $qVentas->sum('envio') + (float) ($qVentas->sum('envio_2') ?? 0);
                        $totalEnviosPaqueteria = (float) $qVentas->sum('envio_paqueteria') + (float) ($qVentas->sum('envio_paqueteria_2') ?? 0);
                        $numCotizaciones = (int) $qCotizaciones->count();
                        $totalCotizaciones = (float) $qCotizaciones->sum('total');

                        // Neto = total - iva - envio
                        $totalNeto = $totalVentas - $totalIVA - $totalEnvios - $totalEnviosPaqueteria;

                        // Vendedores filtrados
                        $vendedoresPrin = $this->getVendedoresPrin($fechaInicio, $fechaFin);

                        // Productos más vendidos filtrados
                        $productosMasVendidos = $this->getProductosMasVendidos($fechaInicio, $fechaFin);

                        return response()->json([
                            'success' => true,

                            'totalVentas' => number_format($totalVentas, 2),
                            'totalCotizaciones' => number_format($totalCotizaciones, 2),

                            'numCotizaciones' => $numCotizaciones,
                            'numeroVentas' => $numeroVentas,

                            'promedioVentas' => number_format($promedioVentas, 2),

                            'totalIVA' => number_format($totalIVA, 2),
                            'totalEnvios' => number_format($totalEnvios, 2),
                            'totalEnviosPaqueteria' => number_format($totalEnviosPaqueteria, 2),
                            'totalNeto' => number_format($totalNeto, 2),

                            'vendedoresPrin' => $vendedoresPrin,
                            'productosMasVendidos' => $productosMasVendidos,
                        ]);
                    default:
                        break;
                    case 'getVentasPorMes':
                        $objCotizaciones = new Cotizaciones();
                        $usuario_id = \Auth::User()->id;
                        $tipo_usuario = \Auth::User()->tipo_usuario;

                        // Ajustar las fechas al primer y último día del mes respectivamente
                        $fecha_inicio = !empty($data_post->fecha_inicio) ? date('Y-m-01', strtotime($data_post->fecha_inicio)) : date('Y-m-01', strtotime('-11 months'));
                        $fecha_fin = !empty($data_post->fecha_fin) ? date('Y-m-t', strtotime($data_post->fecha_fin)) : date('Y-m-t');

                        $query = $objCotizaciones->select(
                            \DB::raw('DATE_FORMAT(fecha, "%Y-%m") as mes'),
                            \DB::raw('COUNT(*) as cantidad_cotizaciones'),
                            \DB::raw('SUM(CASE WHEN status = 3 THEN 1 ELSE 0 END) as cantidad_ventas'),
                            \DB::raw('SUM(CASE WHEN status = 3 THEN total ELSE 0 END) as importe_ventas')
                        )
                            ->where('giro_empresa', 'al')
                            ->where('fecha', '>=', $fecha_inicio)
                            ->where('fecha', '<=', $fecha_fin);

                        if ($tipo_usuario == 'f1' || $tipo_usuario == 'n2') {
                            $query->where('id_usuario_genera', $usuario_id);
                        }

                        $datos_por_mes = $query->groupBy(\DB::raw('DATE_FORMAT(fecha, "%Y-%m")'))
                            ->orderBy('mes', 'ASC')
                            ->get();

                        return response()->json([
                            'success' => true,
                            'datos' => $datos_por_mes,
                            'fecha_inicio' => $fecha_inicio,
                            'fecha_fin' => $fecha_fin
                        ]);
                        break;
                }
            }
        }
        return response()->json(['error' => 'Solicitud no válida'], 400);
    }

    // FIN - VENTAS <-
    public function ajax_est_cotizaciones(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }

            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'getCotizacionesPorDia':
                        $objCotizaciones = new Cotizaciones();
                        $usuario_id = \Auth::User()->id;
                        $tipo_usuario = \Auth::User()->tipo_usuario;

                        // Determinar el período basado en si hay sucursales seleccionadas
                        $tiene_sucursales = !empty($data_post->sucursales) && is_array($data_post->sucursales) && count($data_post->sucursales) <= 3;

                        // Ajustar las fechas según si hay sucursales seleccionadas (15 días) o no (30 días)
                        $dias_periodo = $tiene_sucursales ? 15 : 30;

                        $fecha_inicio = !empty($data_post->fecha_inicio)
                            ? date('Y-m-d', strtotime($data_post->fecha_inicio))
                            : date('Y-m-d', strtotime("-{$dias_periodo} days"));
                        $fecha_fin = !empty($data_post->fecha_fin)
                            ? date('Y-m-d', strtotime($data_post->fecha_fin))
                            : date('Y-m-d');

                        // Array para almacenar todas las series de datos
                        $todas_las_cotizaciones = [];

                        // Si se proporcionaron sucursales específicas
                        if ($tiene_sucursales) {
                            foreach ($data_post->sucursales as $sucursal_id) {
                                $query = $objCotizaciones->select(
                                    \DB::raw('DATE(fecha) as dia'),
                                    \DB::raw('COUNT(*) as total'),
                                    \DB::raw("'" . Sucursales::find($sucursal_id)->nombre . "' as nombre_sucursal")
                                )
                                    ->where('fecha', '>=', $fecha_inicio)
                                    ->where('fecha', '<=', $fecha_fin)
                                    ->where('id_sucursal', $sucursal_id)
                                    ->groupBy(\DB::raw('DATE(fecha)'))
                                    ->orderBy('dia', 'ASC')
                                    ->get();

                                $todas_las_cotizaciones[] = [
                                    'sucursal_id' => $sucursal_id,
                                    'nombre_sucursal' => Sucursales::find($sucursal_id)->nombre,
                                    'datos' => $query
                                ];
                            }
                            $tipo_grafica = 'bar';
                        } else {
                            // Consulta para todas las cotizaciones
                            $query = $objCotizaciones->select(
                                \DB::raw('DATE(fecha) as dia'),
                                \DB::raw('COUNT(*) as total')
                            )
                                ->where('fecha', '>=', $fecha_inicio)
                                ->where('fecha', '<=', $fecha_fin);

                            if ($tipo_usuario == 'f1' || $tipo_usuario == 'n2') {
                                $query->where('id_usuario_genera', $usuario_id);
                            }

                            $cotizaciones_por_dia = $query->groupBy(\DB::raw('DATE(fecha)'))
                                ->orderBy('dia', 'ASC')
                                ->get();

                            $todas_las_cotizaciones[] = [
                                'sucursal_id' => null,
                                'nombre_sucursal' => 'Todas las sucursales',
                                'datos' => $cotizaciones_por_dia
                            ];
                            $tipo_grafica = 'bar';
                        }

                        return response()->json([
                            'cotizaciones' => $todas_las_cotizaciones,
                            'fecha_inicio' => $fecha_inicio,
                            'fecha_fin' => $fecha_fin,
                            'tipo_grafica' => $tipo_grafica
                        ]);
                        break;
                }
            }
        }
        return response()->json(['error' => 'Solicitud no válida'], 400);
    }

    // ESTADISTICAS COTIZACIONES ->
    public function showEstadisticas(Request $request)
    {
        $moduloCotis = new Cotizaciones();

        // Obtener fechas desde la solicitud, o usar valores predeterminados
        $startDate = $request->input('startDate');
        $endDate = $request->input('endDate');

        // Establecer fechas predeterminadas si no se proporcionan
        if (empty($startDate) || empty($endDate)) {
            //$startDate = '2024-01-01';
            //$endDate = '2024-12-31';
            $startDate = Carbon::now()->startOfMonth()->toDateString();
            $endDate = Carbon::now()->endOfMonth()->toDateString();
        }

        // Obtener el total de cotizaciones agrupadas por status y la suma de importes para el rango de fechas proporcionado
        $cotizacionesPorStatus = $moduloCotis
            ->selectRaw('status, COUNT(*) as total, SUM(total) as totalImporte')
            ->whereBetween('fecha', [$startDate, $endDate])
            ->whereIn('id_usuario_genera', [11, 17, 20, 21, 24])
            ->groupBy('status')
            ->get();

        // Obtener el total de cotizaciones agrupadas por status y la suma de importes para el rango de fechas proporcionado
        $cotizacionesPorStatus2 = $moduloCotis
            ->selectRaw('status, COUNT(*) as total, SUM(total) as totalImporte')
            ->whereBetween('fecha', [$startDate, $endDate])
            ->whereIn('id_usuario_genera', [16])
            ->groupBy('status')
            ->get();

        // Convertir resultados a un array que puede ser utilizado en JavaScript
        $data = $cotizacionesPorStatus->map(function ($item) {
            return [
                'status' => $item->status,
                'total' => $item->total,
                'totalImporte' => $item->totalImporte
            ];
        });
        // Convertir resultados a un array que puede ser utilizado en JavaScript
        $data2 = $cotizacionesPorStatus2->map(function ($item) {
            return [
                'status' => $item->status,
                'total' => $item->total,
                'totalImporte' => $item->totalImporte
            ];
        });

        // Convertir los datos a JSON para uso en el script de JavaScript
        $cotizacionesData = $data->toJson();
        $cotizacionesData2 = $data2->toJson();

        // dd($cotizacionesData);

        // Pasar datos a la vista
        return view('app_redes/modulos/estadisticas/estadisticas', compact('cotizacionesData', 'cotizacionesData2'));
    }
    // Est AJAX
    public function ajax_estadisticas(Request $request)
    {
        if ($request->ajax()) {
            $data_post = new \stdClass();
            if (!empty($request->datos)) {
                $data_post = json_decode(json_encode($request->datos));
            }

            if (!empty($request->accion)) {
                switch ($request->accion) {
                    case 'getEstadisticasMID':
                        $objCotizaciones = new Cotizaciones();

                        $condicion_filtro = '';

                        if (!empty($data_post->fecha_inicio) && !empty($data_post->fecha_fin)) {
                            $condicion_filtro .= ' cot.fecha BETWEEN \'' . $data_post->fecha_inicio . '\' AND \'' . $data_post->fecha_fin . '\'';
                        }

                        $cotizacionesPorStatus = $objCotizaciones
                            ->selectRaw('status, COUNT(*) as total, SUM(total) as totalImporte')
                            ->from("cotizaciones AS cot")
                            ->whereIn('id_usuario_genera', [11, 17, 20, 21])
                            ->whereRaw($condicion_filtro)
                            ->groupBy('status')
                            ->get();

                        // Convertir resultados a un array para JSON
                        $data = $cotizacionesPorStatus->map(function ($item) {
                            return [
                                'status' => $item->status,
                                'total' => $item->total,
                                'totalImporte' => $item->totalImporte
                            ];
                        });

                        return response()->json(['cotizacionesData' => $data]);
                    case 'getEstadisticasCDMX':
                        $objCotizaciones = new Cotizaciones();

                        $condicion_filtro = '';

                        if (!empty($data_post->fecha_inicio) && !empty($data_post->fecha_fin)) {
                            $condicion_filtro .= ' cot.fecha BETWEEN \'' . $data_post->fecha_inicio . '\' AND \'' . $data_post->fecha_fin . '\'';
                        }

                        $cotizacionesPorStatus = $objCotizaciones
                            ->selectRaw('status, COUNT(*) as total, SUM(total) as totalImporte')
                            ->from("cotizaciones AS cot")
                            ->whereIn('id_usuario_genera', [16])
                            ->whereRaw($condicion_filtro)
                            ->groupBy('status')
                            ->get();

                        // Convertir resultados a un array para JSON
                        $data = $cotizacionesPorStatus->map(function ($item) {
                            return [
                                'status' => $item->status,
                                'total' => $item->total,
                                'totalImporte' => $item->totalImporte
                            ];
                        });

                        return response()->json(['cotizacionesData' => $data]);

                    default:
                        break;
                }
            }
        }
        return response()->json(['error' => 'Solicitud no válida'], 400);
    }
    // FIN - COTIZACIONES <-
}
