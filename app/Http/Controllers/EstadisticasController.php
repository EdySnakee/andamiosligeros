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
    public function __construct()
    {
        $this->middleware('auth');
    }

    /*
    |--------------------------------------------------------------------------
    | 1. ESTADÍSTICAS DE VENTAS
    |--------------------------------------------------------------------------
    */
    public function showEstVentas(Request $request)
    {
        $metricas = $this->getMetricasVentas();
        $analisis = $this->getAnalisisComercial(null, null, $metricas);
        $vendedoresPrin = $this->getVendedoresPrin();
        $productosMasVendidos = $this->getProductosMasVendidos();

        return view(
            'app_redes/modulos/estadisticas/ventas/view/est_ventas',
            array_merge($metricas, compact('vendedoresPrin', 'productosMasVendidos', 'analisis'))
        );
    }

    /**
     * Calcula métricas agregadas de ventas y cotizaciones en 2 consultas optimizadas.
     */
    public function getMetricasVentas($fechaInicio = null, $fechaFin = null)
    {
        $qVentas = DB::table('ventas');
        $qCotizaciones = DB::table('cotizaciones');

        if ($fechaInicio && $fechaFin) {
            $qVentas->whereBetween('fecha_venta', [$fechaInicio, $fechaFin]);
            $qCotizaciones->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $ventasAgg = $qVentas->selectRaw('
            COALESCE(SUM(total), 0) as total_ventas,
            COUNT(*) as numero_ventas,
            COALESCE(AVG(total), 0) as promedio_ventas,
            COALESCE(SUM(iva), 0) as total_iva,
            COALESCE(SUM(envio), 0) + COALESCE(SUM(envio_2), 0) as total_envios,
            COALESCE(SUM(envio_paqueteria), 0) + COALESCE(SUM(envio_paqueteria_2), 0) as total_envios_paqueteria
        ')->first();

        $cotisAgg = $qCotizaciones->selectRaw('
            COUNT(*) as num_cotizaciones,
            COALESCE(SUM(total), 0) as total_cotizaciones
        ')->first();

        $totalVentas           = (float) ($ventasAgg->total_ventas ?? 0);
        $numeroVentas          = (int) ($ventasAgg->numero_ventas ?? 0);
        $promedioVentas        = (float) ($ventasAgg->promedio_ventas ?? 0);
        $totalIVA              = (float) ($ventasAgg->total_iva ?? 0);
        $totalEnvios           = (float) ($ventasAgg->total_envios ?? 0);
        $totalEnviosPaqueteria = (float) ($ventasAgg->total_envios_paqueteria ?? 0);

        $numCotizaciones   = (int) ($cotisAgg->num_cotizaciones ?? 0);
        $totalCotizaciones = (float) ($cotisAgg->total_cotizaciones ?? 0);

        $tasaConversion = $numCotizaciones > 0 ? round(($numeroVentas / $numCotizaciones) * 100, 2) : 0;
        $totalNeto = $totalVentas - $totalIVA - $totalEnviosPaqueteria;

        return [
            'totalVentas'           => number_format($totalVentas, 2),
            'totalCotizaciones'     => number_format($totalCotizaciones, 2),
            'promedioVentas'        => number_format($promedioVentas, 2),
            'totalIVA'              => number_format($totalIVA, 2),
            'totalEnvios'           => number_format($totalEnvios, 2),
            'totalEnviosPaqueteria' => number_format($totalEnviosPaqueteria, 2),
            'totalNeto'             => number_format($totalNeto, 2),
            'numeroVentas'          => $numeroVentas,
            'numCotizaciones'       => $numCotizaciones,
            'tasaConversion'        => $tasaConversion,
        ];
    }

    /**
     * Calcula métricas avanzadas, embudo, salud logística, proyecciones y comparativa mensual para Análisis Comercial.
     */
    public function getAnalisisComercial($fechaInicio = null, $fechaFin = null, $metricas = null)
    {
        if (!$metricas) {
            $metricas = $this->getMetricasVentas($fechaInicio, $fechaFin);
        }

        $bruto     = (float) str_replace(',', '', $metricas['totalVentas']);
        $neto      = (float) str_replace(',', '', $metricas['totalNeto']);
        $iva       = (float) str_replace(',', '', $metricas['totalIVA']);
        $envios    = (float) str_replace(',', '', $metricas['totalEnvios']);
        $paq       = (float) str_replace(',', '', $metricas['totalEnviosPaqueteria']);
        $numVentas = (int) $metricas['numeroVentas'];
        $numCotis  = (int) $metricas['numCotizaciones'];
        $totalCoti = (float) str_replace(',', '', $metricas['totalCotizaciones']);

        // 1. Días transcurridos en el rango
        if ($fechaInicio && $fechaFin) {
            $tsIni = strtotime($fechaInicio);
            $tsFin = strtotime($fechaFin);
            $dias = max(1, (int) round(($tsFin - $tsIni) / 86400) + 1);
        } else {
            $minFecha = DB::table('ventas')->min('fecha_venta') ?: date('Y-m-01');
            $maxFecha = date('Y-m-d');
            $dias = max(1, (int) round((strtotime($maxFecha) - strtotime($minFecha)) / 86400) + 1);
        }

        // 2. Ratios y KPIs
        $tasaConversion     = $numCotis > 0 ? round(($numVentas / $numCotis) * 100, 2) : 0;
        $conversionValor    = $totalCoti > 0 ? round(($bruto / $totalCoti) * 100, 2) : 0;
        $ticketPromedio     = $numVentas > 0 ? round($bruto / $numVentas, 2) : 0;
        $ventasPorDia       = round($numVentas / $dias, 2);
        $cotizacionesPorDia = round($numCotis / $dias, 2);
        $netoPorDia         = round($neto / $dias, 2);
        $netoPorVenta       = $numVentas > 0 ? round($neto / $numVentas, 2) : 0;
        $margenNetoPct      = $bruto > 0 ? round(($neto / $bruto) * 100, 2) : 0;
        $ivaPct             = $bruto > 0 ? round(($iva / $bruto) * 100, 2) : 0;
        $paqueteriaPct      = $bruto > 0 ? round(($paq / $bruto) * 100, 2) : 0;

        // Pipeline abierto
        $pipelineAbiertoCant  = max(0, $numCotis - $numVentas);
        $pipelineAbiertoValor = max(0, $totalCoti - $bruto);

        // 3. Salud Logística (Envíos vs Paquetería)
        $superavitLogistico = $envios - $paq;
        $coberturaLogistica = $paq > 0 ? round(($envios / $paq) * 100, 2) : ($envios > 0 ? 100 : 0);

        // 4. Proyección al cierre de mes (lineal)
        $mostrarProyeccion = false;
        $diasTranscurridos = $dias;
        $diasMes           = 30;
        $factorProyeccion  = 1;
        $proyVentas        = $numVentas;
        $proyVentasBrutas  = $bruto;
        $proyVentaNeta     = $neto;
        $proyCotizaciones  = $numCotis;
        $proyTotalCotizado = $totalCoti;

        if ($fechaInicio && $fechaFin) {
            $tsIni = strtotime($fechaInicio);
            $tsFin = strtotime($fechaFin);
            $diaInicio = (int) date('d', $tsIni);
            $mesInicio = date('Y-m', $tsIni);
            $mesFin    = date('Y-m', $tsFin);
            $diasMes   = (int) date('t', $tsIni);
            $diaFin    = (int) date('d', $tsFin);

            if ($diaInicio === 1 && $mesInicio === $mesFin && $diaFin < $diasMes) {
                $mostrarProyeccion = true;
                $diasTranscurridos = $diaFin;
                $factorProyeccion  = round($diasMes / max(1, $diasTranscurridos), 4);

                $proyVentas        = (int) round($numVentas * ($diasMes / max(1, $diasTranscurridos)));
                $proyVentasBrutas  = round($bruto * ($diasMes / max(1, $diasTranscurridos)), 2);
                $proyVentaNeta     = round($neto * ($diasMes / max(1, $diasTranscurridos)), 2);
                $proyCotizaciones  = (int) round($numCotis * ($diasMes / max(1, $diasTranscurridos)));
                $proyTotalCotizado = round($totalCoti * ($diasMes / max(1, $diasTranscurridos)), 2);
            }
        }

        // 5. Comparativa histórica de los últimos 6 meses
        $comparativa = $this->getComparativaMensualHistorica(6);

        return [
            'dias'                  => $dias,
            'tasaConversion'        => $tasaConversion,
            'conversionValor'       => $conversionValor,
            'ticketPromedio'        => number_format($ticketPromedio, 2),
            'ventasPorDia'          => $ventasPorDia,
            'cotizacionesPorDia'    => $cotizacionesPorDia,
            'netoPorDia'            => number_format($netoPorDia, 2),
            'netoPorVenta'          => number_format($netoPorVenta, 2),
            'margenNetoPct'         => $margenNetoPct,
            'ivaPct'                => $ivaPct,
            'paqueteriaPct'         => $paqueteriaPct,
            'pipelineAbiertoCant'   => $pipelineAbiertoCant,
            'pipelineAbiertoValor'  => number_format($pipelineAbiertoValor, 2),
            'superavitLogistico'    => number_format($superavitLogistico, 2),
            'superavitLogisticoRaw' => $superavitLogistico,
            'coberturaLogistica'    => $coberturaLogistica,
            'totalVentas'           => $metricas['totalVentas'],
            'totalCotizaciones'     => $metricas['totalCotizaciones'],
            'totalIVA'              => $metricas['totalIVA'],
            'totalEnvios'           => $metricas['totalEnvios'],
            'totalEnviosPaqueteria' => $metricas['totalEnviosPaqueteria'],
            'totalNeto'             => $metricas['totalNeto'],
            'numeroVentas'          => $numVentas,
            'numCotizaciones'       => $numCotis,
            'mostrarProyeccion'     => $mostrarProyeccion,
            'diasTranscurridos'     => $diasTranscurridos,
            'diasMes'               => $diasMes,
            'factorProyeccion'      => $factorProyeccion,
            'proyVentas'            => $proyVentas,
            'proyVentasBrutas'      => number_format($proyVentasBrutas, 2),
            'proyVentaNeta'         => number_format($proyVentaNeta, 2),
            'proyCotizaciones'      => $proyCotizaciones,
            'proyTotalCotizado'     => number_format($proyTotalCotizado, 2),
            'comparativa'           => $comparativa,
        ];
    }

    /**
     * Tabla comparativa mensual histórica (últimos N meses).
     */
    public function getComparativaMensualHistorica($mesesAtras = 6)
    {
        $fechaInicioComp = date('Y-m-01', strtotime('-' . ($mesesAtras - 1) . ' months'));
        $fechaFinComp    = date('Y-m-t');

        $ventasMensuales = collect(DB::table('ventas')
            ->selectRaw('
                DATE_FORMAT(fecha_venta, "%Y-%m") as mes,
                COUNT(*) as ventas_count,
                COALESCE(SUM(total), 0) as total_bruto,
                COALESCE(SUM(iva), 0) as total_iva,
                COALESCE(SUM(envio_paqueteria), 0) + COALESCE(SUM(envio_paqueteria_2), 0) as total_paqueteria
            ')
            ->whereBetween('fecha_venta', [$fechaInicioComp, $fechaFinComp])
            ->groupBy(DB::raw('DATE_FORMAT(fecha_venta, "%Y-%m")'))
            ->get())->keyBy('mes');

        $cotisMensuales = collect(DB::table('cotizaciones')
            ->selectRaw('
                DATE_FORMAT(fecha, "%Y-%m") as mes,
                COUNT(*) as cotizaciones_count,
                COALESCE(SUM(total), 0) as total_cotizado
            ')
            ->whereBetween('fecha', [$fechaInicioComp, $fechaFinComp])
            ->groupBy(DB::raw('DATE_FORMAT(fecha, "%Y-%m")'))
            ->get())->keyBy('mes');

        $mesesNombres = [
            '01' => 'Enero', '02' => 'Febrero', '03' => 'Marzo', '04' => 'Abril',
            '05' => 'Mayo', '06' => 'Junio', '07' => 'Julio', '08' => 'Agosto',
            '09' => 'Septiembre', '10' => 'Octubre', '11' => 'Noviembre', '12' => 'Diciembre'
        ];

        $comparativa = [];
        $prevNeto = null;

        for ($i = $mesesAtras - 1; $i >= 0; $i--) {
            $ym = date('Y-m', strtotime("-$i months"));
            $partes = explode('-', $ym);
            $nombreMes = ($mesesNombres[$partes[1]] ?? $partes[1]) . ' ' . $partes[0];

            $v = $ventasMensuales->get($ym);
            $c = $cotisMensuales->get($ym);

            $numCotis   = $c ? (int) $c->cotizaciones_count : 0;
            $totalCotis = $c ? (float) $c->total_cotizado : 0;
            $numVentas  = $v ? (int) $v->ventas_count : 0;
            $bruto      = $v ? (float) $v->total_bruto : 0;
            $iva        = $v ? (float) $v->total_iva : 0;
            $paq        = $v ? (float) $v->total_paqueteria : 0;
            $neto       = $bruto - $iva - $paq;

            $diasEnMes = ($ym === date('Y-m')) ? max(1, (int) date('j')) : (int) date('t', strtotime($ym . '-01'));

            $conversion = $numCotis > 0 ? round(($numVentas / $numCotis) * 100, 1) : 0;
            $ticket     = $numVentas > 0 ? round($bruto / $numVentas, 2) : 0;
            $netoPorDia = round($neto / $diasEnMes, 2);

            $varNeto = null;
            if ($prevNeto !== null && $prevNeto > 0) {
                $varNeto = round((($neto - $prevNeto) / $prevNeto) * 100, 1);
            }
            $prevNeto = $neto;

            $comparativa[] = [
                'mes_key'            => $ym,
                'nombre_mes'         => $nombreMes,
                'cotizaciones_count' => $numCotis,
                'total_cotizado'     => number_format($totalCotis, 2),
                'ventas_count'       => $numVentas,
                'total_bruto'        => number_format($bruto, 2),
                'total_neto'         => number_format($neto, 2),
                'conversion_pct'     => $conversion,
                'ticket_promedio'    => number_format($ticket, 2),
                'neto_por_dia'       => number_format($netoPorDia, 2),
                'var_neto'           => $varNeto,
                'es_mes_actual'      => ($ym === date('Y-m')),
            ];
        }

        return $comparativa;
    }

    /**
     * Ranking de vendedores sin problema N+1 (3 consultas agrupadas en vez de 128+).
     */
    public function getVendedoresPrin($fechaInicio = null, $fechaFin = null)
    {
        // 1. Resumen de ventas por vendedor
        $vendedoresQuery = DB::table('ventas')
            ->leftJoin('users', 'users.id', '=', 'ventas.id_usuario_genera')
            ->select(
                'ventas.id_usuario_genera',
                DB::raw('COALESCE(users.name, "Desconocido") as nombre'),
                DB::raw('COUNT(*) as numero_ventas'),
                DB::raw('SUM(ventas.total) as total_generado')
            );

        if ($fechaInicio && $fechaFin) {
            $vendedoresQuery->whereBetween('ventas.fecha_venta', [$fechaInicio, $fechaFin]);
        }

        $vendedores = collect($vendedoresQuery
            ->groupBy('ventas.id_usuario_genera', 'users.name')
            ->orderBy('total_generado', 'desc')
            ->get());

        // 2. Resumen de cotizaciones por vendedor
        $cotisQuery = DB::table('cotizaciones')
            ->select(
                'id_usuario_genera',
                DB::raw('COUNT(*) as numero_cotizaciones'),
                DB::raw('SUM(total) as total_cotizado')
            );

        if ($fechaInicio && $fechaFin) {
            $cotisQuery->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $cotisPorVendedor = collect($cotisQuery
            ->groupBy('id_usuario_genera')
            ->get())
            ->keyBy('id_usuario_genera');

        // 3. Cliente estrella por vendedor (mayor venta)
        $sellerIds = $vendedores->pluck('id_usuario_genera')->filter()->all();
        $clientesEstrella = [];
        if (!empty($sellerIds)) {
            $topVentasQuery = DB::table('ventas as v1')
                ->join('clientes', 'clientes.idcl', '=', 'v1.id_cliente')
                ->select('v1.id_usuario_genera', 'clientes.nombrecl', 'v1.total')
                ->whereIn('v1.id_usuario_genera', $sellerIds);

            if ($fechaInicio && $fechaFin) {
                $topVentasQuery->whereBetween('v1.fecha_venta', [$fechaInicio, $fechaFin]);
            }

            $topVentas = $topVentasQuery->orderBy('v1.total', 'desc')->get();

            foreach ($topVentas as $tv) {
                if (!isset($clientesEstrella[$tv->id_usuario_genera])) {
                    $clientesEstrella[$tv->id_usuario_genera] = $tv->nombrecl;
                }
            }
        }

        // 4. Mapeo final
        return $vendedores->map(function ($v) use ($cotisPorVendedor, $clientesEstrella) {
            $id = $v->id_usuario_genera;
            $cotiInfo = $cotisPorVendedor->get($id);

            $numCot = $cotiInfo ? (int) $cotiInfo->numero_cotizaciones : 0;
            $totCot = $cotiInfo ? (float) $cotiInfo->total_cotizado : 0;
            $numVentas = (int) $v->numero_ventas;

            $v->numero_cotizaciones = $numCot;
            $v->total_cotizado = number_format($totCot, 2);
            $v->promedio_exito = $numCot > 0 ? round(($numVentas / $numCot) * 100, 2) : 0;
            $v->cliente_estrella = $clientesEstrella[$id] ?? 'N/A';
            $v->total_generado = number_format((float) $v->total_generado, 2);

            return $v;
        });
    }

    /**
     * Productos más vendidos ordenados por cantidad e importe.
     */
    public function getProductosMasVendidos($fechaInicio = null, $fechaFin = null, $limit = 8)
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
            ->whereNotNull('detalle_cotizaciones.nombre_producto')
            ->where('detalle_cotizaciones.nombre_producto', '!=', '')
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
            $producto->total_vendido = number_format((float) $producto->total_vendido, 2);
            return $producto;
        });
    }

    /**
     * Controlador AJAX para Estadísticas de Ventas.
     */
    public function ajax_est_ventas(Request $request)
    {
        if ($request->ajax()) {
            $accion = $request->input('accion');
            $datos = $request->input('datos', []);
            if (is_string($datos)) {
                $datos = json_decode($datos, true) ?: [];
            } elseif (is_object($datos)) {
                $datos = (array) $datos;
            }

            switch ($accion) {
                case 'estVentas':
                    $fechaInicio = !empty($datos['fecha_inicio']) ? $datos['fecha_inicio'] : null;
                    $fechaFin    = !empty($datos['fecha_fin']) ? $datos['fecha_fin'] : null;

                    $metricas = $this->getMetricasVentas($fechaInicio, $fechaFin);
                    $analisis = $this->getAnalisisComercial($fechaInicio, $fechaFin, $metricas);
                    $vendedoresPrin = $this->getVendedoresPrin($fechaInicio, $fechaFin);
                    $productosMasVendidos = $this->getProductosMasVendidos($fechaInicio, $fechaFin);

                    return response()->json(array_merge([
                        'success'              => true,
                        'vendedoresPrin'       => $vendedoresPrin,
                        'productosMasVendidos' => $productosMasVendidos,
                        'analisis'             => $analisis,
                    ], $metricas));

                case 'getVentasPorMes':
                    $fecha_inicio = !empty($datos['fecha_inicio']) ? $datos['fecha_inicio'] : date('Y-m-01', strtotime('-11 months'));
                    $fecha_fin    = !empty($datos['fecha_fin']) ? $datos['fecha_fin'] : date('Y-m-d');

                    $user = Auth::user();

                    // 1. Cotizaciones creadas en el período agrupadas por mes
                    $qCotis = DB::table('cotizaciones')
                        ->select(
                            DB::raw('DATE_FORMAT(fecha, "%Y-%m") as mes'),
                            DB::raw('COUNT(*) as cantidad_cotizaciones')
                        )
                        ->where('fecha', '>=', $fecha_inicio)
                        ->where('fecha', '<=', $fecha_fin);

                    if ($user && !$user->isAdmin()) {
                        $qCotis->where('id_usuario_genera', $user->id);
                    }

                    $cotisPorMes = collect($qCotis->groupBy(DB::raw('DATE_FORMAT(fecha, "%Y-%m")'))->get())
                        ->keyBy('mes');

                    // 2. Ventas reales concretadas en el período agrupadas por mes (misma fuente que las cards)
                    $qVentas = DB::table('ventas')
                        ->select(
                            DB::raw('DATE_FORMAT(fecha_venta, "%Y-%m") as mes'),
                            DB::raw('COUNT(*) as cantidad_ventas'),
                            DB::raw('COALESCE(SUM(total), 0) as importe_ventas')
                        )
                        ->where('fecha_venta', '>=', $fecha_inicio)
                        ->where('fecha_venta', '<=', $fecha_fin);

                    if ($user && !$user->isAdmin()) {
                        $qVentas->where('id_usuario_genera', $user->id);
                    }

                    $ventasPorMes = collect($qVentas->groupBy(DB::raw('DATE_FORMAT(fecha_venta, "%Y-%m")'))->get())
                        ->keyBy('mes');

                    // 3. Unificar meses ordenados cronológicamente
                    $todosLosMeses = $cotisPorMes->keys()->merge($ventasPorMes->keys())->unique()->sort()->values();

                    $datos_por_mes = $todosLosMeses->map(function ($mes) use ($cotisPorMes, $ventasPorMes) {
                        $c = $cotisPorMes->get($mes);
                        $v = $ventasPorMes->get($mes);

                        return (object) [
                            'mes'                   => $mes,
                            'cantidad_cotizaciones' => $c ? (int) $c->cantidad_cotizaciones : 0,
                            'cantidad_ventas'       => $v ? (int) $v->cantidad_ventas : 0,
                            'importe_ventas'        => $v ? (float) $v->importe_ventas : 0.0,
                        ];
                    });

                    return response()->json([
                        'success'      => true,
                        'datos'        => $datos_por_mes,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin'    => $fecha_fin
                    ]);

                default:
                    break;
            }
        }
        return response()->json(['error' => 'Solicitud no válida'], 400);
    }

    /*
    |--------------------------------------------------------------------------
    | 2. ESTADÍSTICAS DE COTIZACIONES
    |--------------------------------------------------------------------------
    */
    public function showEstCotizaciones()
    {
        $metricas = $this->getMetricasCotizaciones();
        $giros = $this->getCotizacionesPorGiro();
        $sucursales = $this->getSucursales();

        return view(
            'app_redes/modulos/estadisticas/cotizaciones/view/est_cotizaciones',
            compact('metricas', 'giros', 'sucursales')
        );
    }

    /**
     * Traer todas las sucursales para filtros.
     */
    public function getSucursales()
    {
        return Sucursales::select('id', 'nombre')->orderBy('nombre', 'asc')->get();
    }

    /**
     * Métricas agregadas de cotizaciones.
     */
    public function getMetricasCotizaciones($fechaInicio = null, $fechaFin = null)
    {
        $q = DB::table('cotizaciones');
        if ($fechaInicio && $fechaFin) {
            $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $agg = $q->selectRaw('
            COUNT(*) as total_cotizaciones,
            COALESCE(SUM(total), 0) as total_importe,
            COALESCE(AVG(total), 0) as promedio_importe,
            COUNT(DISTINCT DATE(fecha)) as dias_activos
        ')->first();

        $totalCotizaciones = (int) ($agg->total_cotizaciones ?? 0);
        $totalImporte      = (float) ($agg->total_importe ?? 0);
        $promedioImporte   = (float) ($agg->promedio_importe ?? 0);
        $diasActivos       = max(1, (int) ($agg->dias_activos ?? 1));
        $promedioPorDia    = round($totalCotizaciones / $diasActivos, 1);

        return [
            'totalCotizaciones' => $totalCotizaciones,
            'totalImporte'      => number_format($totalImporte, 2),
            'promedioImporte'   => number_format($promedioImporte, 2),
            'promedioPorDia'    => $promedioPorDia,
            'diasActivos'       => $diasActivos,
        ];
    }

    /**
     * Desglose de cotizaciones por division comercial (giro de empresa).
     */
    public function getCotizacionesPorGiro($fechaInicio = null, $fechaFin = null)
    {
        $q = DB::table('cotizaciones');
        if ($fechaInicio && $fechaFin) {
            $q->whereBetween('fecha', [$fechaInicio, $fechaFin]);
        }

        $girosRaw = $q->select('giro_empresa', DB::raw('COUNT(*) as total'), DB::raw('COALESCE(SUM(total), 0) as importe'))
            ->groupBy('giro_empresa')
            ->get();

        $nombresGiro = [
            'al' => 'Andamios Ligeros',
            'ra' => 'Redes Anticaídas',
            'rp' => 'Redes Perimetrales',
            'sg' => 'Scoregol'
        ];

        $coloresGiro = [
            'al' => ['bg' => '#0848af', 'class' => 'border-left-primary'],
            'ra' => ['bg' => '#1cc88a', 'class' => 'border-left-success'],
            'rp' => ['bg' => '#f6c23e', 'class' => 'border-left-warning'],
            'sg' => ['bg' => '#36b9cc', 'class' => 'border-left-info']
        ];

        $resultado = [];
        foreach ($girosRaw as $g) {
            $key = strtolower(trim($g->giro_empresa));
            $resultado[$key] = [
                'clave'   => $key,
                'nombre'  => $nombresGiro[$key] ?? strtoupper($key),
                'total'   => (int) $g->total,
                'importe' => number_format((float) $g->importe, 2),
                'color'   => $coloresGiro[$key] ?? ['bg' => '#4e73df', 'class' => 'border-left-primary']
            ];
        }

        foreach ($nombresGiro as $k => $nombre) {
            if (!isset($resultado[$k])) {
                $resultado[$k] = [
                    'clave'   => $k,
                    'nombre'  => $nombre,
                    'total'   => 0,
                    'importe' => '0.00',
                    'color'   => $coloresGiro[$k]
                ];
            }
        }

        return $resultado;
    }

    /**
     * Controlador AJAX para Estadísticas de Cotizaciones.
     */
    public function ajax_est_cotizaciones(Request $request)
    {
        if ($request->ajax()) {
            $accion = $request->input('accion');
            $datos = $request->input('datos', []);
            if (is_string($datos)) {
                $datos = json_decode($datos, true) ?: [];
            } elseif (is_object($datos)) {
                $datos = (array) $datos;
            }

            switch ($accion) {
                case 'getCotizacionesPorDia':
                    $tieneSucursales = !empty($datos['sucursales']) && is_array($datos['sucursales']) && count($datos['sucursales']) <= 3;
                    $diasPeriodo = $tieneSucursales ? 15 : 30;

                    $fecha_inicio = !empty($datos['fecha_inicio'])
                        ? date('Y-m-d', strtotime($datos['fecha_inicio']))
                        : date('Y-m-d', strtotime("-{$diasPeriodo} days"));
                    $fecha_fin = !empty($datos['fecha_fin'])
                        ? date('Y-m-d', strtotime($datos['fecha_fin']))
                        : date('Y-m-d');

                    $todasLasCotizaciones = [];

                    if ($tieneSucursales) {
                        $sucursalesMap = DB::table('sucursales')
                            ->whereIn('id', $datos['sucursales'])
                            ->pluck('nombre', 'id');

                        foreach ($datos['sucursales'] as $sucursalId) {
                            $nombreSucursal = $sucursalesMap[$sucursalId] ?? 'Sucursal ' . $sucursalId;

                            $query = DB::table('cotizaciones')
                                ->select(DB::raw('DATE(fecha) as dia'), DB::raw('COUNT(*) as total'))
                                ->where('fecha', '>=', $fecha_inicio)
                                ->where('fecha', '<=', $fecha_fin)
                                ->where('id_sucursal', $sucursalId)
                                ->groupBy(DB::raw('DATE(fecha)'))
                                ->orderBy('dia', 'ASC')
                                ->get();

                            $todasLasCotizaciones[] = [
                                'sucursal_id'     => $sucursalId,
                                'nombre_sucursal' => $nombreSucursal,
                                'datos'           => $query
                            ];
                        }
                    } else {
                        $q = DB::table('cotizaciones')
                            ->select(DB::raw('DATE(fecha) as dia'), DB::raw('COUNT(*) as total'))
                            ->where('fecha', '>=', $fecha_inicio)
                            ->where('fecha', '<=', $fecha_fin);

                        $user = Auth::user();
                        if ($user && !$user->isAdmin()) {
                            $q->where('id_usuario_genera', $user->id);
                        }

                        $cotizacionesPorDia = $q->groupBy(DB::raw('DATE(fecha)'))
                            ->orderBy('dia', 'ASC')
                            ->get();

                        $todasLasCotizaciones[] = [
                            'sucursal_id'     => null,
                            'nombre_sucursal' => 'Todas las sucursales',
                            'datos'           => $cotizacionesPorDia
                        ];
                    }

                    $metricas = $this->getMetricasCotizaciones($fecha_inicio, $fecha_fin);
                    $giros = $this->getCotizacionesPorGiro($fecha_inicio, $fecha_fin);

                    return response()->json([
                        'success'      => true,
                        'cotizaciones' => $todasLasCotizaciones,
                        'fecha_inicio' => $fecha_inicio,
                        'fecha_fin'    => $fecha_fin,
                        'tipo_grafica' => 'bar',
                        'metricas'     => $metricas,
                        'giros'        => $giros,
                    ]);

                default:
                    break;
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
