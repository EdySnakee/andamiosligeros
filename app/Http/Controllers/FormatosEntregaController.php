<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FormatosHelperTrait;
use App\Cotizaciones;
use App\DetalleCotizaciones;
use App\FormatoEntrega;
use App\FormatoEntregaDetalle;
use Auth;
use PDF;
use DB;

class FormatosEntregaController extends Controller
{
    use FormatosHelperTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Panel principal de creación, edición, historial y balance de Formatos de Entrega.
     */
    public function index(Request $request, $id_cotizacion = null)
    {
        $idEditar = $request->input('editar');
        $formatoEdit = null;

        if (!empty($idEditar)) {
            $formatoEdit = FormatoEntrega::with('detalles')->where('id', (int) $idEditar)->first();
            if (!$formatoEdit) {
                return redirect()->route('app_formatos_entrega', $id_cotizacion ? ['id_cotizacion' => $id_cotizacion] : [])
                    ->with('error', 'El formato de entrega solicitado para edición no existe.');
            }
            if (!empty($formatoEdit->id_cotizacion) && empty($id_cotizacion)) {
                $id_cotizacion = $formatoEdit->id_cotizacion;
            }
        }

        $contexto = $this->cargarContextoCotizacion($id_cotizacion);
        if (!empty($id_cotizacion) && !$contexto) {
            return redirect()->route('app_formatos_entrega')->with('error', 'La cotización seleccionada no fue encontrada.');
        }

        $cotizacion = $contexto ? $contexto['cotizacion'] : null;
        $cliente = $contexto ? $contexto['cliente'] : null;
        $estatusInfo = $contexto ? $contexto['estatusInfo'] : null;

        // Historial: de la cotización si está vinculada, o los últimos 50 globales si es libre
        $queryHistorial = FormatoEntrega::with('detalles', 'usuario');
        if ($cotizacion) {
            $queryHistorial->where('id_cotizacion', $cotizacion->id_cotizacion);
        }
        $reportesAnteriores = $queryHistorial->orderBy('id', 'desc')->limit($cotizacion ? 200 : 50)->get();

        // Calcular entregas previas por partida cotizada:
        // 1) Totales reales (para la pestaña de Balance y Barra de Progreso)
        // 2) Excluyendo el formato en edición (para validar el tope estricto al editar)
        $entregadosTotales = [];
        $entregadosOtrosFormatos = [];

        if ($cotizacion) {
            $todosReportesCoti = FormatoEntrega::with('detalles')
                ->where('id_cotizacion', $cotizacion->id_cotizacion)
                ->get();

            foreach ($todosReportesCoti as $rep) {
                foreach ($rep->detalles as $det) {
                    if ($det->id_det_cotizacion) {
                        $k = (int) $det->id_det_cotizacion;
                        if (!isset($entregadosTotales[$k])) {
                            $entregadosTotales[$k] = 0;
                        }
                        $entregadosTotales[$k] += floatval($det->cantidad);

                        if (!$formatoEdit || (int) $rep->id !== (int) $formatoEdit->id) {
                            if (!isset($entregadosOtrosFormatos[$k])) {
                                $entregadosOtrosFormatos[$k] = 0;
                            }
                            $entregadosOtrosFormatos[$k] += floatval($det->cantidad);
                        }
                    }
                }
            }
        }

        $balanceProductos = [];
        $productosPendientes = [];
        $maximoPorDetalleParaForm = [];

        if ($contexto) {
            foreach ($contexto['detallesCotizacion'] as $item) {
                $key = (int) $item->id_det_cotizacion;
                $infoProd = self::obtenerInfoProductoCotizado($item);

                $cantCotizada = $infoProd['total_cotizado'];
                $cantEntregada = isset($entregadosTotales[$key]) ? $entregadosTotales[$key] : 0;
                $cantRestante = max(0, $cantCotizada - $cantEntregada);
                $cantEntregadaOtros = isset($entregadosOtrosFormatos[$key]) ? $entregadosOtrosFormatos[$key] : 0;
                $cantMaxParaForm = max(0, $cantCotizada - $cantEntregadaOtros);
                $completo = ($cantRestante <= 0.001);

                $maximoPorDetalleParaForm[$key] = $cantMaxParaForm;

                $infoItem = [
                    'id_det_cotizacion'  => $key,
                    'id_producto'        => $item->id_producto,
                    'nombre_producto'    => $infoProd['nombre_mostrar'],
                    'cantidad_cotizada'  => $cantCotizada,
                    'cantidad_entregada' => $cantEntregada,
                    'cantidad_restante'  => $cantRestante,
                    'cantidad_max_form'  => $cantMaxParaForm,
                    'unidad'             => $infoProd['unidad'],
                    'tipo_cobro'         => $infoProd['tipo_cobro'],
                    'completo'           => $completo,
                ];

                $balanceProductos[] = $infoItem;
                if (!$completo) {
                    $productosPendientes[] = $infoItem;
                }
            }
        }

        // Progreso general de entrega
        $porcentajeEntregado = 0;
        $resumenItemsEntregados = '';
        if (count($balanceProductos) > 0) {
            $porcentajesItems = [];
            foreach ($balanceProductos as $bp) {
                $p = $bp['cantidad_cotizada'] > 0 ? min(100, ($bp['cantidad_entregada'] / $bp['cantidad_cotizada']) * 100) : 100;
                $porcentajesItems[] = $p;
            }
            $porcentajeEntregado = round(array_sum($porcentajesItems) / count($porcentajesItems), 1);
            $totalProductosCompletos = count(array_filter($balanceProductos, function ($bp) {
                return $bp['completo'];
            }));
            $resumenItemsEntregados = $totalProductosCompletos . ' de ' . count($balanceProductos) . ' productos surtidos al 100%';
        }

        // Filas iniciales del formulario (Edición vs Creación desde cotización vs Creación libre)
        $filasFormulario = [];
        if ($formatoEdit) {
            foreach ($formatoEdit->detalles as $det) {
                $idDet = $det->id_det_cotizacion ? (int) $det->id_det_cotizacion : null;
                $maxDisp = ($idDet && isset($maximoPorDetalleParaForm[$idDet])) ? $maximoPorDetalleParaForm[$idDet] : null;
                $filasFormulario[] = [
                    'id_det_cotizacion' => $idDet,
                    'id_producto'       => $det->id_producto,
                    'nombre_producto'   => $det->nombre_producto,
                    'cantidad'          => floatval($det->cantidad),
                    'unidad'            => $det->unidad ?: 'pzas',
                    'max_disponible'    => $maxDisp,
                ];
            }
        } elseif ($cotizacion) {
            foreach ($productosPendientes as $itemPendiente) {
                $filasFormulario[] = [
                    'id_det_cotizacion' => $itemPendiente['id_det_cotizacion'],
                    'id_producto'       => $itemPendiente['id_producto'],
                    'nombre_producto'   => $itemPendiente['nombre_producto'],
                    'cantidad'          => $itemPendiente['cantidad_restante'],
                    'unidad'            => $itemPendiente['unidad'],
                    'max_disponible'    => $itemPendiente['cantidad_max_form'],
                ];
            }
        }

        // Valores de cabecera del documento
        $numeroSiguienteEntrega = $cotizacion ? ($reportesAnteriores->count() + 1) : 1;
        if ($formatoEdit) {
            $folioEntregaDefault = $formatoEdit->folio_entrega;
            $fechaDefault = $formatoEdit->fecha_formato !== null ? $this->normalizarFechaTexto($formatoEdit->fecha_formato) : ($formatoEdit->fecha ? date('d/m/Y', strtotime($formatoEdit->fecha)) : '');
            $clienteDefault = $formatoEdit->cliente;
            $telefonoDefault = $formatoEdit->telefono;
            $cotizacionPedidoDefault = $formatoEdit->folio_cotizacion;
            $vendedorDefault = $formatoEdit->vendedor;
            $observacionesDefault = $formatoEdit->observaciones;
        } elseif ($cotizacion) {
            $folioEntregaDefault = $numeroSiguienteEntrega === 1
                ? (string) $cotizacion->id_cotizacion
                : ($cotizacion->id_cotizacion . '-' . $numeroSiguienteEntrega);
            $fechaDefault = date('d/m/Y');
            $clienteDefault = $cliente ? $cliente->nombrecl : '';
            $telefonoDefault = $contexto['telefonoDefault'];
            $cotizacionPedidoDefault = $cotizacion->cod_cotizacion ?: (string) $cotizacion->id_cotizacion;
            $vendedorDefault = $contexto['vendedorDefault'];
            $observacionesDefault = '';
        } else {
            $ultimoId = (int) FormatoEntrega::max('id');
            $folioEntregaDefault = 'ENT-' . str_pad($ultimoId + 1, 5, '0', STR_PAD_LEFT);
            $fechaDefault = date('d/m/Y');
            $clienteDefault = '';
            $telefonoDefault = '';
            $cotizacionPedidoDefault = '';
            $vendedorDefault = Auth::user() ? Auth::user()->name : '';
            $observacionesDefault = '';
        }

        $assets = $this->obtenerAssetsAndamiosBase64(false);
        $logoBase64 = $assets['logoBase64'];
        $cintaBase64 = $assets['cintaBase64'];
        $catalogoProductos = $this->obtenerCatalogoProductos();
        $catalogoVendedores = $this->obtenerCatalogoVendedores();
        $cotizacionesRecientes = $this->obtenerCotizacionesRecientes(12);

        return view('app_redes.modulos.formatos.entrega.index', compact(
            'cotizacion',
            'cliente',
            'estatusInfo',
            'formatoEdit',
            'reportesAnteriores',
            'balanceProductos',
            'productosPendientes',
            'filasFormulario',
            'resumenItemsEntregados',
            'porcentajeEntregado',
            'numeroSiguienteEntrega',
            'folioEntregaDefault',
            'fechaDefault',
            'clienteDefault',
            'telefonoDefault',
            'cotizacionPedidoDefault',
            'vendedorDefault',
            'observacionesDefault',
            'logoBase64',
            'cintaBase64',
            'catalogoProductos',
            'catalogoVendedores',
            'cotizacionesRecientes'
        ));
    }

    /**
     * Guarda un nuevo formato de entrega.
     */
    public function guardar(Request $request)
    {
        return $this->procesarGuardado($request, null);
    }

    /**
     * Actualiza un formato de entrega existente.
     */
    public function actualizar(Request $request, $id_formato)
    {
        $formato = FormatoEntrega::where('id', (int) $id_formato)->first();
        if (!$formato) {
            return response()->json(['success' => false, 'message' => 'Formato de entrega no encontrado.'], 404);
        }

        return $this->procesarGuardado($request, $formato);
    }

    /**
     * Lógica unificada de validación estricta y persistencia para creación y edición.
     */
    private function procesarGuardado(Request $request, FormatoEntrega $formatoExistente = null)
    {
        $idCotizacion = $request->input('id_cotizacion');
        $idCotizacion = (!empty($idCotizacion) && (int) $idCotizacion > 0) ? (int) $idCotizacion : null;

        if ($formatoExistente && $idCotizacion === null && !empty($formatoExistente->id_cotizacion)) {
            $idCotizacion = (int) $formatoExistente->id_cotizacion;
        }

        $cotizacion = null;
        if ($idCotizacion) {
            $cotizacion = Cotizaciones::where('id_cotizacion', $idCotizacion)->first();
            if (!$cotizacion) {
                return response()->json(['success' => false, 'message' => 'La cotización vinculada no existe.'], 404);
            }
        }

        $productosInput = $request->input('productos', []);
        if (empty($productosInput) || !is_array($productosInput)) {
            return response()->json([
                'success' => false,
                'message' => 'Debes incluir al menos un producto a entregar en este formato.'
            ], 422);
        }

        // Calcular entregas acumuladas previas excluyendo el formato actual en edición
        $entregadosPorDetalle = [];
        if ($cotizacion) {
            $queryPrevios = FormatoEntrega::with('detalles')->where('id_cotizacion', $cotizacion->id_cotizacion);
            if ($formatoExistente) {
                $queryPrevios->where('id', '!=', $formatoExistente->id);
            }
            foreach ($queryPrevios->get() as $rep) {
                foreach ($rep->detalles as $det) {
                    if ($det->id_det_cotizacion) {
                        $k = (int) $det->id_det_cotizacion;
                        if (!isset($entregadosPorDetalle[$k])) {
                            $entregadosPorDetalle[$k] = 0;
                        }
                        $entregadosPorDetalle[$k] += floatval($det->cantidad);
                    }
                }
            }
        }

        // Acumulador en el request actual para evitar burlar el tope con filas duplicadas del mismo id_det_cotizacion
        $solicitadoEnEsteFormato = [];
        $detallesAGuardar = [];

        foreach ($productosInput as $p) {
            $idDet = ($cotizacion && !empty($p['id_det_cotizacion']) && (int) $p['id_det_cotizacion'] > 0)
                ? (int) $p['id_det_cotizacion']
                : null;
            $nombreProd = isset($p['nombre_producto']) ? trim($p['nombre_producto']) : '';
            $cantidad = isset($p['cantidad']) ? floatval($p['cantidad']) : 0;

            if ($cantidad <= 0 && $nombreProd === '') {
                continue;
            }

            if ($cantidad <= 0) {
                return response()->json([
                    'success' => false,
                    'message' => 'Todas las partidas incluidas deben tener una cantidad mayor a cero.'
                ], 422);
            }

            if ($idDet) {
                $itemCotizado = DetalleCotizaciones::where('id_det_cotizacion', $idDet)
                    ->where('id_cotizacion', $cotizacion->id_cotizacion)
                    ->first();

                if (!$itemCotizado) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Una de las partidas no corresponde a la cotización seleccionada.'
                    ], 422);
                }

                $infoProd = self::obtenerInfoProductoCotizado($itemCotizado);
                $cantCotizada = $infoProd['total_cotizado'];
                $unidad = !empty($p['unidad']) ? trim($p['unidad']) : $infoProd['unidad'];
                $cantYaEntregada = isset($entregadosPorDetalle[$idDet]) ? $entregadosPorDetalle[$idDet] : 0;
                $cantRestante = max(0, $cantCotizada - $cantYaEntregada);

                if (!isset($solicitadoEnEsteFormato[$idDet])) {
                    $solicitadoEnEsteFormato[$idDet] = 0;
                }
                $solicitadoEnEsteFormato[$idDet] += $cantidad;

                // REGLA ESTRICTA: No permitir entregar más de lo cotizado restante
                if ($solicitadoEnEsteFormato[$idDet] > ($cantRestante + 0.001)) {
                    $cantRestanteFmt = self::formatearCantidad($cantRestante);
                    $cantCotizadaFmt = self::formatearCantidad($cantCotizada);
                    $cantYaEntregadaFmt = self::formatearCantidad($cantYaEntregada);
                    $nombreMostrarErr = $nombreProd ?: $infoProd['nombre_mostrar'];

                    return response()->json([
                        'success' => false,
                        'message' => 'No puedes registrar una cantidad mayor a la cotizada para "' . $nombreMostrarErr . '". Cantidad máxima disponible restante: ' . $cantRestanteFmt . ' ' . $unidad . ' (Cotizado original: ' . $cantCotizadaFmt . ' ' . $unidad . ', ya entregado en otros formatos: ' . $cantYaEntregadaFmt . ' ' . $unidad . ').'
                    ], 422);
                }

                $detallesAGuardar[] = [
                    'id_det_cotizacion' => $idDet,
                    'id_producto'       => $itemCotizado->id_producto,
                    'nombre_producto'   => $nombreProd ?: $infoProd['nombre_mostrar'],
                    'cantidad'          => $cantidad,
                    'unidad'            => $unidad,
                ];
            } else {
                if ($nombreProd === '') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Por favor indica el nombre o descripción de todos los productos añadidos.'
                    ], 422);
                }

                $idProductoManual = (!empty($p['id_producto']) && (int) $p['id_producto'] > 0)
                    ? (int) $p['id_producto']
                    : null;
                $unidad = !empty($p['unidad']) ? trim($p['unidad']) : 'pzas';

                $detallesAGuardar[] = [
                    'id_det_cotizacion' => null,
                    'id_producto'       => $idProductoManual,
                    'nombre_producto'   => $nombreProd,
                    'cantidad'          => $cantidad,
                    'unidad'            => $unidad,
                ];
            }
        }

        if (count($detallesAGuardar) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Debes registrar al menos un producto con nombre y cantidad mayor a cero.'
            ], 422);
        }

        DB::beginTransaction();
        try {
            $esEdicion = ($formatoExistente !== null);

            if ($esEdicion) {
                $formato = $formatoExistente;
            } else {
                $formato = new FormatoEntrega();
                $formato->id_cotizacion = $cotizacion ? $cotizacion->id_cotizacion : null;
                $numeroEntrega = $cotizacion
                    ? (FormatoEntrega::where('id_cotizacion', $cotizacion->id_cotizacion)->count() + 1)
                    : 1;
                $formato->numero_entrega = $numeroEntrega;
                $formato->id_usuario = Auth::user() ? Auth::user()->id : null;
            }

            $folioInput = trim((string) $request->input('folio_entrega', ''));
            if ($folioInput === '') {
                if ($cotizacion) {
                    $folioInput = $formato->numero_entrega === 1
                        ? (string) $cotizacion->id_cotizacion
                        : ($cotizacion->id_cotizacion . '-' . $formato->numero_entrega);
                } else {
                    $ultimoId = (int) FormatoEntrega::max('id');
                    $folioInput = 'ENT-' . str_pad($ultimoId + 1, 5, '0', STR_PAD_LEFT);
                }
            }

            $fechaFormato = $this->normalizarFechaTexto($request->input('fecha_formato', ''));
            $fechaDate = $this->parseFechaParaDb($fechaFormato);

            $formato->folio_entrega    = $folioInput;
            $formato->fecha            = $fechaDate;
            $formato->fecha_formato    = $fechaFormato;
            $formato->cliente          = trim((string) $request->input('cliente', ''));
            $formato->telefono         = trim((string) $request->input('telefono', ''));
            $formato->folio_cotizacion = trim((string) $request->input('folio_cotizacion', ''));
            $formato->vendedor         = trim((string) $request->input('vendedor', ''));
            $formato->observaciones    = trim((string) $request->input('observaciones', ''));
            $formato->save();

            if ($esEdicion) {
                FormatoEntregaDetalle::where('id_formato_entrega', $formato->id)->delete();
            }

            foreach ($detallesAGuardar as $det) {
                $itemDetalle = new FormatoEntregaDetalle();
                $itemDetalle->id_formato_entrega = $formato->id;
                $itemDetalle->id_det_cotizacion  = $det['id_det_cotizacion'];
                $itemDetalle->id_producto        = $det['id_producto'];
                $itemDetalle->nombre_producto    = $det['nombre_producto'];
                $itemDetalle->cantidad           = $det['cantidad'];
                $itemDetalle->unidad             = $det['unidad'];
                $itemDetalle->save();
            }

            DB::commit();

            $urlEditar = $formato->id_cotizacion
                ? route('app_formatos_entrega', $formato->id_cotizacion) . '?editar=' . $formato->id
                : route('app_formatos_entrega') . '?editar=' . $formato->id;

            return response()->json([
                'success'    => true,
                'message'    => ($esEdicion ? 'Formato de entrega actualizado exitosamente' : 'Formato de entrega generado exitosamente') . ' con el folio: ' . $formato->folio_entrega,
                'id_formato' => $formato->id,
                'url_ver'    => route('app_formatos_entrega_ver', $formato->id),
                'url_pdf'    => route('app_formatos_entrega_pdf', $formato->id),
                'url_editar' => $urlEditar,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar el formato: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra la vista imprimible limpia de un formato de entrega.
     */
    public function ver($id_formato)
    {
        // La vista imprimible web se retiró: se conserva la ruta por compatibilidad y redirige al PDF.
        return redirect()->route('app_formatos_entrega_pdf', (int) $id_formato);
    }

    /**
     * Genera y descarga el PDF del formato de entrega usando DomPDF.
     */
    public function pdf($id_formato)
    {
        $formato = FormatoEntrega::with('detalles', 'cotizacion')->where('id', (int) $id_formato)->first();
        if (!$formato) {
            return abort(404, 'Formato de entrega no encontrado');
        }

        $assets = $this->obtenerAssetsAndamiosBase64(true);
        $data = [
            'formato'     => $formato,
            'logoBase64'  => $assets['logoBase64'],
            'cintaBase64' => $assets['cintaBase64'],
        ];

        $pdf = PDF::loadView('app_redes.modulos.formatos.entrega.pdf', $data);
        $pdf->setPaper('letter', 'portrait');

        $folioSanitizado = preg_replace('/[^A-Za-z0-9\-_]/', '_', $formato->folio_entrega ?: $formato->id);
        $filename = 'Formato_Entrega_' . $folioSanitizado . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Elimina un formato de entrega y reintegra las cantidades al balance.
     */
    public function eliminar($id_formato)
    {
        $formato = FormatoEntrega::where('id', (int) $id_formato)->first();
        if (!$formato) {
            return response()->json(['success' => false, 'message' => 'Formato no encontrado.'], 404);
        }

        $id_cotizacion = $formato->id_cotizacion;

        DB::beginTransaction();
        try {
            FormatoEntregaDetalle::where('id_formato_entrega', $formato->id)->delete();
            $formato->delete();
            DB::commit();

            return response()->json([
                'success'       => true,
                'message'       => 'Formato de entrega eliminado correctamente.' . ($id_cotizacion ? ' Las cantidades se han reintegrado al balance de la cotización.' : ''),
                'id_cotizacion' => $id_cotizacion,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }
}

