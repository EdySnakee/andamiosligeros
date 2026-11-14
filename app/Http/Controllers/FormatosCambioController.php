<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Controllers\Traits\FormatosHelperTrait;
use App\Cotizaciones;
use App\FormatoCambio;
use App\FormatoCambioDetalle;
use Auth;
use PDF;
use DB;

class FormatosCambioController extends Controller
{
    use FormatosHelperTrait;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Panel principal de creación, edición e historial de Formatos de Cambio de Producto.
     */
    public function index(Request $request, $id_cotizacion = null)
    {
        $idEditar = $request->input('editar');
        $formatoEdit = null;

        if (!empty($idEditar)) {
            $formatoEdit = FormatoCambio::with('detalles')->where('id', (int) $idEditar)->first();
            if (!$formatoEdit) {
                return redirect()->route('app_formatos_cambio', $id_cotizacion ? ['id_cotizacion' => $id_cotizacion] : [])
                    ->with('error', 'El formato de cambio solicitado para edición no existe.');
            }
            if (!empty($formatoEdit->id_cotizacion) && empty($id_cotizacion)) {
                $id_cotizacion = $formatoEdit->id_cotizacion;
            }
        }

        $contexto = $this->cargarContextoCotizacion($id_cotizacion);
        if (!empty($id_cotizacion) && !$contexto) {
            return redirect()->route('app_formatos_cambio')->with('error', 'La cotización seleccionada no fue encontrada.');
        }

        $cotizacion = $contexto ? $contexto['cotizacion'] : null;
        $cliente = $contexto ? $contexto['cliente'] : null;
        $estatusInfo = $contexto ? $contexto['estatusInfo'] : null;

        // Historial: de la cotización o los últimos 50 globales
        $queryHistorial = FormatoCambio::with('detalles', 'usuario');
        if ($cotizacion) {
            $queryHistorial->where('id_cotizacion', $cotizacion->id_cotizacion);
        }
        $formatosAnteriores = $queryHistorial->orderBy('id', 'desc')->limit($cotizacion ? 200 : 50)->get();

        // Productos de la cotización para agregar rápidamente a la tabla "1. Producto que entrega / cambia el cliente"
        $productosCotizacion = [];
        if ($contexto) {
            foreach ($contexto['detallesCotizacion'] as $item) {
                $infoProd = self::obtenerInfoProductoCotizado($item);
                $productosCotizacion[] = [
                    'id_producto'     => $item->id_producto,
                    'nombre_producto' => $infoProd['nombre_mostrar'],
                    'cantidad'        => $infoProd['total_cotizado'],
                    'precio_unit'     => floatval($item->precio_unit ?: 0),
                ];
            }
        }

        // Partidas iniciales de ambas tablas
        $filasEntregados = [];
        $filasSustitucion = [];

        if ($formatoEdit) {
            foreach ($formatoEdit->detalles as $det) {
                if ($det->tipo_partida === FormatoCambioDetalle::TIPO_ENTREGADO) {
                    $filasEntregados[] = [
                        'id_producto'          => $det->id_producto,
                        'nombre_producto'      => $det->nombre_producto,
                        'cantidad'             => floatval($det->cantidad),
                        'precio_unitario'      => floatval($det->precio_unitario),
                        'estado_observaciones' => $det->estado_observaciones,
                    ];
                } else {
                    $filasSustitucion[] = [
                        'id_producto'     => $det->id_producto,
                        'nombre_producto' => $det->nombre_producto,
                        'cantidad'        => floatval($det->cantidad),
                        'precio_unitario' => floatval($det->precio_unitario),
                        'importe'         => floatval($det->importe),
                    ];
                }
            }
        }

        // Si no hay partidas cargadas (creación nueva), iniciar ambas tablas con 1 fila lista como en el formato físico
        if (count($filasEntregados) === 0) {
            $filasEntregados[] = [
                'id_producto'          => null,
                'nombre_producto'      => '',
                'cantidad'             => '',
                'precio_unitario'      => '',
                'estado_observaciones' => '',
            ];
        }
        if (count($filasSustitucion) === 0) {
            $filasSustitucion[] = [
                'id_producto'     => null,
                'nombre_producto' => '',
                'cantidad'        => '',
                'precio_unitario' => '',
                'importe'         => '',
            ];
        }

        // Datos de cabecera y condiciones
        if ($formatoEdit) {
            $folioCambioDefault = $formatoEdit->folio_cambio;
            $fechaDefault = $formatoEdit->fecha_formato !== null ? $this->normalizarFechaTexto($formatoEdit->fecha_formato) : ($formatoEdit->fecha ? date('d/m/Y', strtotime($formatoEdit->fecha)) : '');
            $clienteDefault = $formatoEdit->cliente;
            $telefonoDefault = $formatoEdit->telefono;
            $cotizacionFacturaDefault = $formatoEdit->cotizacion_factura;
            $vendedorDefault = $formatoEdit->vendedor;
            $formasPagoSeleccionadas = array_filter(array_map('trim', explode(',', (string) $formatoEdit->forma_pago)));
            $fechaPagoDefault = $this->normalizarFechaTexto($formatoEdit->fecha_pago);
            $observacionesDefault = $formatoEdit->observaciones;
        } elseif ($cotizacion) {
            $numSiguiente = $formatosAnteriores->count() + 1;
            $folioCambioDefault = $numSiguiente === 1
                ? ('CAM-' . $cotizacion->id_cotizacion)
                : ('CAM-' . $cotizacion->id_cotizacion . '-' . $numSiguiente);
            $fechaDefault = date('d/m/Y');
            $clienteDefault = $cliente ? $cliente->nombrecl : '';
            $telefonoDefault = $contexto['telefonoDefault'];
            $cotizacionFacturaDefault = $cotizacion->cod_cotizacion ?: (string) $cotizacion->id_cotizacion;
            $vendedorDefault = $contexto['vendedorDefault'];
            $formasPagoSeleccionadas = [];
            $fechaPagoDefault = date('d/m/Y');
            $observacionesDefault = '';
        } else {
            $ultimoId = (int) FormatoCambio::max('id');
            $folioCambioDefault = 'CAM-' . str_pad($ultimoId + 1, 5, '0', STR_PAD_LEFT);
            $fechaDefault = date('d/m/Y');
            $clienteDefault = '';
            $telefonoDefault = '';
            $cotizacionFacturaDefault = '';
            $vendedorDefault = Auth::user() ? Auth::user()->name : '';
            $formasPagoSeleccionadas = [];
            $fechaPagoDefault = date('d/m/Y');
            $observacionesDefault = '';
        }

        $assets = $this->obtenerAssetsAndamiosBase64(false);
        $logoBase64 = $assets['logoBase64'];
        $cintaBase64 = $assets['cintaBase64'];
        $catalogoProductos = $this->obtenerCatalogoProductos();
        $catalogoVendedores = $this->obtenerCatalogoVendedores();
        $cotizacionesRecientes = $this->obtenerCotizacionesRecientes(12);

        return view('app_redes.modulos.formatos.cambio.index', compact(
            'cotizacion',
            'cliente',
            'estatusInfo',
            'formatoEdit',
            'formatosAnteriores',
            'productosCotizacion',
            'filasEntregados',
            'filasSustitucion',
            'folioCambioDefault',
            'fechaDefault',
            'clienteDefault',
            'telefonoDefault',
            'cotizacionFacturaDefault',
            'vendedorDefault',
            'formasPagoSeleccionadas',
            'fechaPagoDefault',
            'observacionesDefault',
            'logoBase64',
            'cintaBase64',
            'catalogoProductos',
            'catalogoVendedores',
            'cotizacionesRecientes'
        ));
    }

    /**
     * Guarda un nuevo formato de cambio de producto.
     */
    public function guardar(Request $request)
    {
        return $this->procesarGuardado($request, null);
    }

    /**
     * Actualiza un formato de cambio de producto existente.
     */
    public function actualizar(Request $request, $id_formato)
    {
        $formato = FormatoCambio::where('id', (int) $id_formato)->first();
        if (!$formato) {
            return response()->json(['success' => false, 'message' => 'Formato de cambio no encontrado.'], 404);
        }

        return $this->procesarGuardado($request, $formato);
    }

    /**
     * Lógica unificada de validación y persistencia para creación y edición.
     */
    private function procesarGuardado(Request $request, FormatoCambio $formatoExistente = null)
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

        $entregadosInput = $request->input('entregados', []);
        $sustitucionesInput = $request->input('sustituciones', []);

        $partidasAGuardar = [];
        $totalReconocido = 0;
        $totalSustitucion = 0;

        // 1. Procesar productos que entrega / cambia el cliente
        if (is_array($entregadosInput)) {
            foreach ($entregadosInput as $row) {
                $nombre = isset($row['nombre_producto']) ? trim($row['nombre_producto']) : '';
                $cantidadRaw = isset($row['cantidad']) ? $row['cantidad'] : '';
                $valorRaw = isset($row['valor_reconocido']) ? $row['valor_reconocido'] : '';
                $estadoObs = isset($row['estado_observaciones']) ? trim($row['estado_observaciones']) : '';

                // Omitir filas completamente vacías
                if ($nombre === '' && $cantidadRaw === '' && $valorRaw === '' && $estadoObs === '') {
                    continue;
                }

                if ($nombre === '') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Indica el nombre o descripción de cada producto en la sección "1. Producto que entrega / cambia el cliente".'
                    ], 422);
                }

                $cantidad = floatval($cantidadRaw);
                if ($cantidad <= 0) {
                    $cantidad = 1;
                }
                $idProdEnt = (!empty($row['id_producto']) && (int) $row['id_producto'] > 0) ? (int) $row['id_producto'] : null;
                if ($valorRaw === '' && $idProdEnt) {
                    $prodCat = \App\Productos::where('id_producto', $idProdEnt)->first();
                    $valorReconocido = $prodCat ? round($cantidad * max(0, floatval($prodCat->precio)), 2) : 0;
                } else {
                    $valorReconocido = max(0, floatval($valorRaw));
                }

                $totalReconocido += $valorReconocido;

                $partidasAGuardar[] = [
                    'tipo_partida'         => FormatoCambioDetalle::TIPO_ENTREGADO,
                    'id_producto'          => $idProdEnt,
                    'nombre_producto'      => $nombre,
                    'cantidad'             => $cantidad,
                    'precio_unitario'      => $valorReconocido,
                    'importe'              => $valorReconocido,
                    'estado_observaciones' => $estadoObs,
                ];
            }
        }

        // 2. Procesar productos nuevos / de sustitución
        if (is_array($sustitucionesInput)) {
            foreach ($sustitucionesInput as $row) {
                $nombre = isset($row['nombre_producto']) ? trim($row['nombre_producto']) : '';
                $cantidadRaw = isset($row['cantidad']) ? $row['cantidad'] : '';
                $precioRaw = isset($row['precio_unitario']) ? $row['precio_unitario'] : '';
                $importeRaw = isset($row['importe']) ? $row['importe'] : '';

                // Omitir filas completamente vacías
                if ($nombre === '' && $cantidadRaw === '' && $precioRaw === '' && $importeRaw === '') {
                    continue;
                }

                if ($nombre === '') {
                    return response()->json([
                        'success' => false,
                        'message' => 'Indica el nombre o descripción de cada producto en la sección "2. Producto nuevo / producto de sustitución".'
                    ], 422);
                }

                $cantidad = floatval($cantidadRaw);
                if ($cantidad <= 0) {
                    $cantidad = 1;
                }
                $precioUnit = max(0, floatval($precioRaw));
                $importe = ($importeRaw !== '' && is_numeric($importeRaw))
                    ? max(0, floatval($importeRaw))
                    : round($cantidad * $precioUnit, 2);

                $totalSustitucion += $importe;

                $partidasAGuardar[] = [
                    'tipo_partida'         => FormatoCambioDetalle::TIPO_SUSTITUCION,
                    'id_producto'          => (!empty($row['id_producto']) && (int) $row['id_producto'] > 0) ? (int) $row['id_producto'] : null,
                    'nombre_producto'      => $nombre,
                    'cantidad'             => $cantidad,
                    'precio_unitario'      => $precioUnit,
                    'importe'              => $importe,
                    'estado_observaciones' => null,
                ];
            }
        }

        if (count($partidasAGuardar) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Debes registrar al menos un producto entregado o un producto de sustitución para guardar el formato.'
            ], 422);
        }

        $formasPagoInput = $request->input('forma_pago', []);
        if (is_array($formasPagoInput)) {
            $formasPagoLimpio = implode(', ', array_filter(array_map('trim', $formasPagoInput)));
        } else {
            $formasPagoLimpio = trim((string) $formasPagoInput);
        }

        DB::beginTransaction();
        try {
            $esEdicion = ($formatoExistente !== null);

            if ($esEdicion) {
                $formato = $formatoExistente;
            } else {
                $formato = new FormatoCambio();
                $formato->id_cotizacion = $cotizacion ? $cotizacion->id_cotizacion : null;
                $formato->id_usuario = Auth::user() ? Auth::user()->id : null;
            }

            $folioInput = trim((string) $request->input('folio_cambio', ''));
            if ($folioInput === '') {
                if ($cotizacion) {
                    $conteo = FormatoCambio::where('id_cotizacion', $cotizacion->id_cotizacion)->count() + 1;
                    $folioInput = $conteo === 1
                        ? ('CAM-' . $cotizacion->id_cotizacion)
                        : ('CAM-' . $cotizacion->id_cotizacion . '-' . $conteo);
                } else {
                    $ultimoId = (int) FormatoCambio::max('id');
                    $folioInput = 'CAM-' . str_pad($ultimoId + 1, 5, '0', STR_PAD_LEFT);
                }
            }

            $fechaFormato = $this->normalizarFechaTexto($request->input('fecha_formato', ''));
            $fechaDate = $this->parseFechaParaDb($fechaFormato);

            $formato->folio_cambio       = $folioInput;
            $formato->fecha              = $fechaDate;
            $formato->fecha_formato      = $fechaFormato;
            $formato->cliente            = trim((string) $request->input('cliente', ''));
            $formato->telefono           = trim((string) $request->input('telefono', ''));
            $formato->cotizacion_factura = trim((string) $request->input('cotizacion_factura', ''));
            $formato->vendedor           = trim((string) $request->input('vendedor', ''));
            $formato->forma_pago         = $formasPagoLimpio;
            $formato->fecha_pago         = $this->normalizarFechaTexto($request->input('fecha_pago', ''));
            $formato->total_reconocido   = round($totalReconocido, 2);
            $formato->total_sustitucion  = round($totalSustitucion, 2);
            $formato->diferencia_pagar   = round($totalSustitucion - $totalReconocido, 2);
            $formato->observaciones      = trim((string) $request->input('observaciones', ''));
            $formato->save();

            if ($esEdicion) {
                FormatoCambioDetalle::where('id_formato_cambio', $formato->id)->delete();
            }

            foreach ($partidasAGuardar as $det) {
                $detalle = new FormatoCambioDetalle();
                $detalle->id_formato_cambio    = $formato->id;
                $detalle->tipo_partida         = $det['tipo_partida'];
                $detalle->id_producto          = $det['id_producto'];
                $detalle->nombre_producto      = $det['nombre_producto'];
                $detalle->cantidad             = $det['cantidad'];
                $detalle->precio_unitario      = $det['precio_unitario'];
                $detalle->importe              = $det['importe'];
                $detalle->estado_observaciones = $det['estado_observaciones'];
                $detalle->save();
            }

            DB::commit();

            $urlEditar = $formato->id_cotizacion
                ? route('app_formatos_cambio', $formato->id_cotizacion) . '?editar=' . $formato->id
                : route('app_formatos_cambio') . '?editar=' . $formato->id;

            return response()->json([
                'success'    => true,
                'message'    => ($esEdicion ? 'Formato de cambio actualizado exitosamente' : 'Formato de cambio generado exitosamente') . ' con el folio: ' . $formato->folio_cambio,
                'id_formato' => $formato->id,
                'url_ver'    => route('app_formatos_cambio_ver', $formato->id),
                'url_pdf'    => route('app_formatos_cambio_pdf', $formato->id),
                'url_editar' => $urlEditar,
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json([
                'success' => false,
                'message' => 'Ocurrió un error al guardar el formato de cambio: ' . $e->getMessage()
            ], 500);
        }
    }

    /**
     * Muestra la vista imprimible limpia de un formato de cambio de producto.
     */
    public function ver($id_formato)
    {
        // La vista imprimible web se retiró: se conserva la ruta por compatibilidad y redirige al PDF.
        return redirect()->route('app_formatos_cambio_pdf', (int) $id_formato);
    }

    /**
     * Genera y descarga el PDF del formato de cambio usando DomPDF.
     */
    public function pdf($id_formato)
    {
        $formato = FormatoCambio::with('detallesEntregados', 'detallesSustitucion', 'cotizacion')
            ->where('id', (int) $id_formato)
            ->first();
        if (!$formato) {
            return abort(404, 'Formato de cambio no encontrado');
        }

        $assets = $this->obtenerAssetsAndamiosBase64(true);
        $formasPago = array_filter(array_map('trim', explode(',', (string) $formato->forma_pago)));

        $data = [
            'formato'     => $formato,
            'formasPago'  => $formasPago,
            'logoBase64'  => $assets['logoBase64'],
            'cintaBase64' => $assets['cintaBase64'],
        ];

        $pdf = PDF::loadView('app_redes.modulos.formatos.cambio.pdf', $data);
        $pdf->setPaper('letter', 'portrait');

        $folioSanitizado = preg_replace('/[^A-Za-z0-9\-_]/', '_', $formato->folio_cambio ?: $formato->id);
        $filename = 'Formato_Cambio_' . $folioSanitizado . '.pdf';

        return $pdf->stream($filename);
    }

    /**
     * Elimina un formato de cambio de producto.
     */
    public function eliminar($id_formato)
    {
        $formato = FormatoCambio::where('id', (int) $id_formato)->first();
        if (!$formato) {
            return response()->json(['success' => false, 'message' => 'Formato no encontrado.'], 404);
        }

        DB::beginTransaction();
        try {
            FormatoCambioDetalle::where('id_formato_cambio', $formato->id)->delete();
            $formato->delete();
            DB::commit();

            return response()->json([
                'success' => true,
                'message' => 'Formato de cambio eliminado correctamente.',
            ]);
        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => 'Error al eliminar: ' . $e->getMessage()], 500);
        }
    }
}

