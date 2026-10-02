<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Cotizaciones;
use App\DetalleCotizaciones;
use App\Clientes;
use App\User;
use App\OrdenTaller;
use App\OrdenTallerDetalle;
use App\OrdenTallerNota;
use App\Ventas;
use Auth;

class TallerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['listadoOrdenesPublico']]);
    }

    /**
     * Muestra el listado de todas las ventas aceptadas (status = 3)
     * con filtros de fecha. Por defecto muestra desde el 01/01/2026.
     */
    public function listadoOrdenes(Request $request)
    {
        $fecha_inicio = $request->get('fecha_inicio', date('Y-m-d', strtotime('-7 days')));
        $fecha_fin = $request->get('fecha_fin', date('Y-m-d'));
        $orden = $request->get('orden', 'DESC');

        $ordenes = Cotizaciones::select(
            'cotizaciones.*',
            'clientes.nombrecl',
            'clientes.telefonocl',
            'clientes.celularcl',
            'users.name AS nombre_vendedor',
            'ordenes_taller.estatus as estatus_taller',
            'ordenes_taller.numero_guia',
            'ordenes_taller.enlace_guia',
            'ordenes_taller.impreso'
        )
            ->from('cotizaciones')
            ->join('clientes', 'clientes.idcl', '=', 'cotizaciones.id_cliente')
            ->leftJoin('users', 'users.id', '=', 'cotizaciones.id_usuario_genera')
            ->leftJoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'cotizaciones.id_cotizacion')
            ->where('cotizaciones.status', 3)
            ->whereBetween('cotizaciones.fecha_venta', [$fecha_inicio, $fecha_fin])
            ->orderBy('cotizaciones.fecha_venta', $orden)
            ->get();

        $ids_cotizaciones = $ordenes->pluck('id_cotizacion')->toArray();

        // Get total pieces requested
        $totales_piezas = \DB::table('detalle_cotizaciones')
            ->select('id_cotizacion', \DB::raw('SUM(cantidad) as total'))
            ->whereIn('id_cotizacion', $ids_cotizaciones)
            ->groupBy('id_cotizacion')
            ->pluck('total', 'id_cotizacion');

        // Get total pieces finished
        $totales_terminadas = \DB::table('ordenes_taller_detalle')
            ->select('ordenes_taller.id_cotizacion', \DB::raw('SUM(ordenes_taller_detalle.cantidad_terminada) as total_terminadas'))
            ->join('ordenes_taller', 'ordenes_taller.id_orden_taller', '=', 'ordenes_taller_detalle.id_orden_taller')
            ->whereIn('ordenes_taller.id_cotizacion', $ids_cotizaciones)
            ->groupBy('ordenes_taller.id_cotizacion')
            ->pluck('total_terminadas', 'id_cotizacion');

        // Obtener datos de ventas para enlazar directamente a la vista de venta
        $ventas = \DB::table('ventas')
            ->select('id_cotizacion', 'ruta_encrypt', 'giro_empresa')
            ->whereIn('id_cotizacion', $ids_cotizaciones)
            ->orderBy('id_venta', 'DESC')
            ->get();

        $slugs_giro = [
            'ra' => 'redes-anticaidas',
            'rp' => 'redes-perimetrales',
            'sg' => 'score-gol',
            'al' => 'andamios-ligeros'
        ];

        $ventas_info = [];
        foreach ($ventas as $v) {
            if (!isset($ventas_info[$v->id_cotizacion])) {
                $ventas_info[$v->id_cotizacion] = $v;
            }
        }

        foreach ($ordenes as $item) {
            $total = $totales_piezas[$item->id_cotizacion] ?? 0;
            $terminadas = $totales_terminadas[$item->id_cotizacion] ?? 0;
            $item->porcentaje = $total > 0 ? round(($terminadas / $total) * 100) : 0;

            $venta = $ventas_info[$item->id_cotizacion] ?? null;
            if ($venta && !empty($venta->ruta_encrypt)) {
                $giro = $venta->giro_empresa ?: $item->giro_empresa;
                $slug = $slugs_giro[$giro] ?? 'andamios-ligeros';
                $item->url_venta = url('ventas/' . $slug . '/' . $venta->ruta_encrypt);
            } else {
                $item->url_venta = null;
            }
        }

        return view('app_redes/modulos/taller/listado_ordenes_taller', compact(
            'ordenes',
            'fecha_inicio',
            'fecha_fin',
            'orden'
        ));
    }

    /**
     * Muestra el listado PÚBLICO de todas las ventas aceptadas
     * sin opciones de modificación.
     */
    public function listadoOrdenesPublico(Request $request)
    {
        // Traemos únicamente los registros de los últimos 10 días por defecto
        $fecha_inicio = date('Y-m-d', strtotime('-30 days'));
        $fecha_fin = date('Y-m-d');

        $ordenes = Cotizaciones::select(
            'cotizaciones.*',
            'clientes.nombrecl',
            'clientes.telefonocl',
            'clientes.celularcl',
            'users.name AS nombre_vendedor',
            'ordenes_taller.estatus as estatus_taller',
            'ordenes_taller.numero_guia',
            'ordenes_taller.enlace_guia',
            'ordenes_taller.impreso'
        )
            ->from('cotizaciones')
            ->join('clientes', 'clientes.idcl', '=', 'cotizaciones.id_cliente')
            ->leftJoin('users', 'users.id', '=', 'cotizaciones.id_usuario_genera')
            ->leftJoin('ordenes_taller', 'ordenes_taller.id_cotizacion', '=', 'cotizaciones.id_cotizacion')
            ->where('cotizaciones.status', 3)
            ->whereBetween('cotizaciones.fecha_venta', [$fecha_inicio, $fecha_fin])
            // Primero ordenamos por estatus del taller: 
            // Pendiente (0 o nulo) -> Iniciado (1) -> Terminado (2) -> Enviado (3)
            ->orderByRaw('COALESCE(ordenes_taller.estatus, 0) ASC')
            // Luego ordenamos por fecha de venta (los más recientes primero dentro de su grupo)
            ->orderBy('cotizaciones.fecha_venta', 'DESC')
            ->get();

        $ids_cotizaciones = $ordenes->pluck('id_cotizacion')->toArray();

        // Get total pieces requested
        $totales_piezas = \DB::table('detalle_cotizaciones')
            ->select('id_cotizacion', \DB::raw('SUM(cantidad) as total'))
            ->whereIn('id_cotizacion', $ids_cotizaciones)
            ->groupBy('id_cotizacion')
            ->pluck('total', 'id_cotizacion');

        // Get total pieces finished
        $totales_terminadas = \DB::table('ordenes_taller_detalle')
            ->select('ordenes_taller.id_cotizacion', \DB::raw('SUM(ordenes_taller_detalle.cantidad_terminada) as total_terminadas'))
            ->join('ordenes_taller', 'ordenes_taller.id_orden_taller', '=', 'ordenes_taller_detalle.id_orden_taller')
            ->whereIn('ordenes_taller.id_cotizacion', $ids_cotizaciones)
            ->groupBy('ordenes_taller.id_cotizacion')
            ->pluck('total_terminadas', 'id_cotizacion');

        // Obtener datos de ventas para enlazar directamente a la vista de venta
        $ventas = \DB::table('ventas')
            ->select('id_cotizacion', 'ruta_encrypt', 'giro_empresa')
            ->whereIn('id_cotizacion', $ids_cotizaciones)
            ->orderBy('id_venta', 'DESC')
            ->get();

        $slugs_giro = [
            'ra' => 'redes-anticaidas',
            'rp' => 'redes-perimetrales',
            'sg' => 'score-gol',
            'al' => 'andamios-ligeros'
        ];

        $ventas_info = [];
        foreach ($ventas as $v) {
            if (!isset($ventas_info[$v->id_cotizacion])) {
                $ventas_info[$v->id_cotizacion] = $v;
            }
        }

        foreach ($ordenes as $item) {
            $total = $totales_piezas[$item->id_cotizacion] ?? 0;
            $terminadas = $totales_terminadas[$item->id_cotizacion] ?? 0;
            $item->porcentaje = $total > 0 ? round(($terminadas / $total) * 100) : 0;

            $venta = $ventas_info[$item->id_cotizacion] ?? null;
            if ($venta && !empty($venta->ruta_encrypt)) {
                $giro = $venta->giro_empresa ?: $item->giro_empresa;
                $slug = $slugs_giro[$giro] ?? 'andamios-ligeros';
                $item->url_venta = url('ventas/' . $slug . '/' . $venta->ruta_encrypt);
            } else {
                $item->url_venta = null;
            }
        }

        $counts = [
            'pendientes' => $ordenes->filter(function ($o) {
                return !isset($o->estatus_taller) || $o->estatus_taller == 0;
            })->count(),
            'iniciadas' => $ordenes->filter(function ($o) {
                return isset($o->estatus_taller) && $o->estatus_taller == 1;
            })->count(),
            'terminadas' => $ordenes->filter(function ($o) {
                return isset($o->estatus_taller) && $o->estatus_taller == 2;
            })->count(),
            'enviadas' => $ordenes->filter(function ($o) {
                return isset($o->estatus_taller) && $o->estatus_taller == 3;
            })->count(),
        ];

        return view('app_redes/modulos/taller/listado_ordenes_publico', compact(
            'ordenes',
            'counts'
        ));
    }

    /**
     * Muestra la Orden de Taller generada automáticamente a partir de la cotización.
     *
     * @param int $id_cotizacion
     */
    public function verOrden($id_cotizacion)
    {
        $cotizacion = Cotizaciones::find($id_cotizacion);

        if (empty($cotizacion) || $cotizacion->status != 3) {
            return redirect()->route('app_ordenes_taller')->with('error', 'Orden no encontrada o cotización no aceptada.');
        }

        $cliente = Clientes::find($cotizacion->id_cliente);

        $ordenTaller = OrdenTaller::where('id_cotizacion', $id_cotizacion)->first();
        if (!$ordenTaller) {
            // Manejo por si no existía el registro en taller
            $ordenTaller = new OrdenTaller();
            $ordenTaller->id_cotizacion = $id_cotizacion;
            $ordenTaller->estatus = 0;
            $ordenTaller->save();
        }

        $detalle = DetalleCotizaciones::select('detalle_cotizaciones.*', 'ordenes_taller_detalle.cantidad_terminada')
            ->leftJoin('ordenes_taller_detalle', function ($join) use ($ordenTaller) {
                $join->on('ordenes_taller_detalle.id_det_cotizacion', '=', 'detalle_cotizaciones.id_det_cotizacion')
                    ->where('ordenes_taller_detalle.id_orden_taller', '=', $ordenTaller->id_orden_taller);
            })
            ->where('detalle_cotizaciones.id_cotizacion', $id_cotizacion)
            ->get();

        $vendedor = User::find($cotizacion->id_usuario_genera);
        $fecha_impresion = date('d/m/Y H:i');

        // Cargar notas con su usuario
        $notas = $ordenTaller->notas()->with('user')->get();

        // Cargar datos de venta para origen y destino
        $venta = Ventas::where('id_cotizacion', $id_cotizacion)->first();

        return view('app_redes/modulos/taller/ver_orden_taller', compact(
            'cotizacion',
            'cliente',
            'detalle',
            'ordenTaller',
            'vendedor',
            'fecha_impresion',
            'notas',
            'venta'
        ));
    }

    /**
     * Redirige al listado (el agregar ahora es el mismo listado).
     */
    public function agregarOrden()
    {
        return redirect()->route('app_ordenes_taller');
    }

    public function actualizarProgreso(Request $request)
    {
        $id_orden_taller = $request->input('id_orden_taller');
        $cantidades = $request->input('cantidades', []);
        // Comentarios ya no se actualizan desde aquí, se usa el sistema de notas chat

        $ordenTaller = OrdenTaller::find($id_orden_taller);
        if (!$ordenTaller) {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada']);
        }

        if ($ordenTaller->estatus == 3) {
            return response()->json(['success' => false, 'message' => 'Esta orden ya fue marcada como enviada y no admite modificaciones.']);
        }

        // $ordenTaller->comentarios = $comentarios; // Desactivado por cambio a sistema de chat
        $ordenTaller->numero_guia = $request->input('numero_guia');
        $ordenTaller->enlace_guia = $request->input('enlace_guia');

        $total_piezas = 0;
        $total_terminadas = 0;

        foreach ($cantidades as $id_det => $cant) {
            $ordenDetalle = OrdenTallerDetalle::where('id_orden_taller', $id_orden_taller)
                ->where('id_det_cotizacion', $id_det)
                ->first();

            if ($ordenDetalle) {
                $ordenDetalle->cantidad_terminada = $cant;
                $ordenDetalle->save();
            } else {
                $ordenDetalle = new OrdenTallerDetalle();
                $ordenDetalle->id_orden_taller = $id_orden_taller;
                $ordenDetalle->id_det_cotizacion = $id_det;
                $ordenDetalle->cantidad_terminada = $cant;
                $ordenDetalle->save();
            }
        }

        $detallesOriginales = DetalleCotizaciones::where('id_cotizacion', $ordenTaller->id_cotizacion)->get();
        foreach ($detallesOriginales as $detOriginal) {
            $total_piezas += $detOriginal->cantidad;

            $dTerminada = OrdenTallerDetalle::where('id_orden_taller', $id_orden_taller)
                ->where('id_det_cotizacion', $detOriginal->id_det_cotizacion)->first();
            if ($dTerminada) {
                $total_terminadas += $dTerminada->cantidad_terminada;
            }
        }

        if ($ordenTaller->estatus != 3) {
            if ($total_terminadas == 0) {
                $ordenTaller->estatus = 0;
            } elseif ($total_terminadas > 0 && $total_terminadas < $total_piezas) {
                $ordenTaller->estatus = 1;
            } elseif ($total_terminadas >= $total_piezas) {
                $ordenTaller->estatus = 2;
            }
        }

        $ordenTaller->save();

        return response()->json([
            'success' => true,
            'message' => 'Progreso actualizado',
            'estatus' => $ordenTaller->estatus
        ]);
    }

    public function marcarImpreso(Request $request)
    {
        $id_orden_taller = $request->input('id_orden_taller');
        $ordenTaller = OrdenTaller::find($id_orden_taller);

        if (!$ordenTaller) {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada']);
        }

        $ordenTaller->impreso = 1;
        $ordenTaller->save();

        return response()->json(['success' => true]);
    }

    public function confirmarEnvio(Request $request)
    {
        $id_orden_taller = $request->input('id_orden_taller');
        $ordenTaller = OrdenTaller::find($id_orden_taller);

        if (!$ordenTaller) {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada']);
        }

        // El usuario solicitó que solo se marque la ORDEN como enviada, no la venta.
        $ordenTaller->estatus = 3;
        $ordenTaller->save();

        return response()->json(['success' => true, 'message' => 'La orden ha sido marcada como enviada.']);
    }

    public function agregarNota(Request $request)
    {
        $id_orden_taller = $request->input('id_orden_taller');
        $texto_nota = $request->input('nota');

        $ordenTaller = OrdenTaller::find($id_orden_taller);
        if (!$ordenTaller) {
            return response()->json(['success' => false, 'message' => 'Orden no encontrada']);
        }

        if ($ordenTaller->estatus == 3) {
            return response()->json(['success' => false, 'message' => 'Esta orden ya fue enviada y no permite añadir más notas.']);
        }

        if (empty(trim($texto_nota))) {
            return response()->json(['success' => false, 'message' => 'La nota no puede estar vacía']);
        }

        $nota = new OrdenTallerNota();
        $nota->id_orden_taller = $id_orden_taller;
        $nota->id_usuario = Auth::id();
        $nota->nota = $texto_nota;
        $nota->save();

        // Devolvemos la nota formateada para agregarla al UI sin refrescar
        return response()->json([
            'success' => true,
            'nota' => [
                'usuario' => Auth::user()->name,
                'fecha' => $nota->created_at->format('d/m/Y H:i'),
                'texto' => $nota->nota
            ]
        ]);
    }


    public function rastreoGuias()
    {
        return view('app_redes/modulos/taller/rastreo_guias/rastreo_de_guias');
    }
}