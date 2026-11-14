<?php

namespace App\Http\Controllers\Traits;

use Illuminate\Http\Request;
use App\Cotizaciones;
use App\DetalleCotizaciones;
use App\Clientes;
use App\Productos;
use App\User;
use App\Ventas;
use App\Utilidades;
use Auth;

trait FormatosHelperTrait
{
    /**
     * Obtiene las últimas cotizaciones/ventas (hasta 12) usando índice primario sin joins pesados.
     */
    protected function obtenerCotizacionesRecientes($limite = 12)
    {
        $cotizaciones = Cotizaciones::select(
                'id_cotizacion',
                'id_cliente',
                'id_usuario_genera',
                'cod_cotizacion',
                'cod_venta',
                'fecha',
                'fecha_formato',
                'status',
                'giro_empresa'
            )
            ->where('giro_empresa', 'al')
            ->orderBy('id_cotizacion', 'DESC')
            ->limit($limite)
            ->get();

        if ($cotizaciones->count() < $limite) {
            $faltantes = $limite - $cotizaciones->count();
            $idsExistentes = $cotizaciones->lists('id_cotizacion')->all();
            $extraQuery = Cotizaciones::select(
                'id_cotizacion',
                'id_cliente',
                'id_usuario_genera',
                'cod_cotizacion',
                'cod_venta',
                'fecha',
                'fecha_formato',
                'status',
                'giro_empresa'
            );
            if (!empty($idsExistentes)) {
                $extraQuery->whereNotIn('id_cotizacion', $idsExistentes);
            }
            $extras = $extraQuery->orderBy('id_cotizacion', 'DESC')->limit($faltantes)->get();
            $cotizaciones = $cotizaciones->merge($extras);
        }

        return $this->formatearCotizacionesBusqueda($cotizaciones);
    }

    /**
     * Hidrata clientes, vendedores y folios de venta únicamente para las cotizaciones seleccionadas (máx. 12).
     */
    protected function formatearCotizacionesBusqueda($cotizaciones)
    {
        if ($cotizaciones->isEmpty()) {
            return collect([]);
        }

        $idsCoti = $cotizaciones->lists('id_cotizacion')->filter()->unique()->values()->all();
        $idsCli = $cotizaciones->lists('id_cliente')->filter()->unique()->values()->all();
        $idsUsr = $cotizaciones->lists('id_usuario_genera')->filter()->unique()->values()->all();

        $clientesMap = !empty($idsCli)
            ? Clientes::select('idcl', 'nombrecl', 'telefonocl', 'celularcl')->whereIn('idcl', $idsCli)->get()->keyBy('idcl')
            : collect([]);

        $usuariosMap = !empty($idsUsr)
            ? User::select('id', 'name')->whereIn('id', $idsUsr)->get()->keyBy('id')
            : collect([]);

        $ventasMap = !empty($idsCoti)
            ? Ventas::select('id_cotizacion', 'cod_venta')->whereIn('id_cotizacion', $idsCoti)->get()->keyBy('id_cotizacion')
            : collect([]);

        $estatusMap = [
            1 => 'Activo',
            2 => 'Inactivo',
            3 => 'Venta Aceptada',
            4 => 'Pendiente',
            5 => 'Vencida',
            6 => 'Facturado',
        ];

        return $cotizaciones->map(function ($c) use ($clientesMap, $usuariosMap, $ventasMap, $estatusMap) {
            $cli = isset($clientesMap[$c->id_cliente]) ? $clientesMap[$c->id_cliente] : null;
            $usr = isset($usuariosMap[$c->id_usuario_genera]) ? $usuariosMap[$c->id_usuario_genera] : null;
            $vta = isset($ventasMap[$c->id_cotizacion]) ? $ventasMap[$c->id_cotizacion] : null;
            $statusInt = (int) $c->status;

            return [
                'id_cotizacion'  => $c->id_cotizacion,
                'cod_cotizacion' => $c->cod_cotizacion ?: ('COT-' . $c->id_cotizacion),
                'cod_venta'      => ($vta && $vta->cod_venta) ? $vta->cod_venta : ($c->cod_venta ?: ''),
                'cliente'        => ($cli && $cli->nombrecl) ? $cli->nombrecl : 'Sin cliente',
                'telefono'       => $cli ? ($cli->telefonocl ?: ($cli->celularcl ?: '')) : '',
                'vendedor'       => $usr ? $usr->name : '',
                'fecha_formato'  => $c->fecha_formato ?: $c->fecha,
                'status'         => $statusInt,
                'status_label'   => isset($estatusMap[$statusInt]) ? $estatusMap[$statusInt] : 'Otro',
                'giro_empresa'   => $c->giro_empresa,
            ];
        })->values();
    }

    /**
     * Busca cotizaciones/ventas activas o aceptadas para vincularlas a un formato (máximo 12 resultados, optimizada).
     */
    public function buscarCotizacion(Request $request)
    {
        $term = trim($request->input('term', $request->input('q', '')));
        $limite = 12;

        if ($term === '') {
            return response()->json($this->obtenerCotizacionesRecientes($limite));
        }

        $idsPorVenta = [];
        // Buscar coincidencia de folio en tabla ventas solo si el término parece folio de venta o alfanumérico corto
        if (stripos($term, 'val') !== false || strlen($term) >= 3) {
            $idsPorVenta = Ventas::where('cod_venta', 'LIKE', '%' . $term . '%')
                ->orderBy('id_venta', 'DESC')
                ->limit($limite)
                ->lists('id_cotizacion')
                ->filter()
                ->all();
        }

        // Si el usuario buscó un ID numérico exacto, priorizar búsqueda por PK directa (< 1 ms)
        $exacta = null;
        $idNumericoExtraido = null;
        if (ctype_digit($term)) {
            $idNumericoExtraido = (int) $term;
        } elseif (preg_match('/^(?:cal|cot)0*(\d+)$/i', $term, $m)) {
            $idNumericoExtraido = (int) $m[1];
        }

        if ($idNumericoExtraido !== null && $idNumericoExtraido > 0) {
            $exacta = Cotizaciones::select(
                    'id_cotizacion',
                    'id_cliente',
                    'id_usuario_genera',
                    'cod_cotizacion',
                    'cod_venta',
                    'fecha',
                    'fecha_formato',
                    'status',
                    'giro_empresa'
                )
                ->where('id_cotizacion', $idNumericoExtraido)
                ->first();
        }

        // Búsqueda principal escaneando por PK descendente y haciendo join 1-a-1 únicamente contra clientes (PK idcl)
        $cotizaciones = Cotizaciones::from('cotizaciones AS cot')
            ->leftJoin('clientes AS cli', 'cli.idcl', '=', 'cot.id_cliente')
            ->select(
                'cot.id_cotizacion',
                'cot.id_cliente',
                'cot.id_usuario_genera',
                'cot.cod_cotizacion',
                'cot.cod_venta',
                'cot.fecha',
                'cot.fecha_formato',
                'cot.status',
                'cot.giro_empresa'
            )
            ->where(function ($w) use ($term, $idsPorVenta, $idNumericoExtraido) {
                if ($idNumericoExtraido !== null && $idNumericoExtraido > 0) {
                    $w->orWhere('cot.id_cotizacion', $idNumericoExtraido);
                }
                if (!empty($idsPorVenta)) {
                    $w->orWhereIn('cot.id_cotizacion', $idsPorVenta);
                }
                $w->orWhere('cot.cod_cotizacion', 'LIKE', '%' . $term . '%')
                  ->orWhere('cot.cod_venta', 'LIKE', '%' . $term . '%')
                  ->orWhere('cli.nombrecl', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('cot.id_cotizacion', 'DESC')
            ->limit($limite)
            ->get();

        if ($exacta && !$cotizaciones->contains('id_cotizacion', $exacta->id_cotizacion)) {
            $cotizaciones->prepend($exacta);
            $cotizaciones = $cotizaciones->take($limite);
        }

        // Ordenar en PHP priorizando Andamios Ligeros ('al') y folio más reciente sin penalizar SQL con filesort
        $ordenadas = $cotizaciones->sort(function ($a, $b) {
            $pa = ($a->giro_empresa === 'al') ? 0 : 1;
            $pb = ($b->giro_empresa === 'al') ? 0 : 1;
            if ($pa !== $pb) {
                return $pa - $pb;
            }
            return (int) $b->id_cotizacion - (int) $a->id_cotizacion;
        })->values();

        return response()->json($this->formatearCotizacionesBusqueda($ordenadas));
    }

    /**
     * Búsqueda AJAX de productos activos del catálogo para autocompletado.
     */
    public function buscarProductos(Request $request)
    {
        $term = trim($request->input('term', $request->input('q', '')));

        $query = Productos::where('status_p', 1);

        if ($term !== '') {
            $query->where(function ($w) use ($term) {
                $w->where('nombre_p', 'LIKE', '%' . $term . '%')
                  ->orWhere('SKU', 'LIKE', '%' . $term . '%');
            });
        }

        $productos = $query
            ->orderByRaw("CASE WHEN giro_producto = 'al' THEN 0 ELSE 1 END ASC")
            ->orderBy('nombre_p', 'ASC')
            ->limit(40)
            ->get();

        $resultados = $productos->map(function ($p) {
            return [
                'id'     => $p->id_producto,
                'nombre' => $p->nombre_p,
                'sku'    => $p->SKU ?: '',
                'giro'   => $p->giro_producto ?: '',
                'precio' => (float) ($p->precio ?: 0),
                'unidad' => $this->normalizarUnidad($p->unidad),
            ];
        });

        return response()->json($resultados);
    }

    /**
     * Obtiene el catálogo completo de productos activos para precarga en vistas.
     */
    protected function obtenerCatalogoProductos()
    {
        return Productos::where('status_p', 1)
            ->orderByRaw("CASE WHEN giro_producto = 'al' THEN 0 ELSE 1 END ASC")
            ->orderBy('nombre_p', 'ASC')
            ->get(['id_producto', 'nombre_p', 'SKU', 'giro_producto', 'precio', 'unidad'])
            ->map(function ($p) {
                return [
                    'id'     => $p->id_producto,
                    'nombre' => $p->nombre_p,
                    'sku'    => $p->SKU ?: '',
                    'giro'   => $p->giro_producto ?: '',
                    'precio' => (float) ($p->precio ?: 0),
                    'unidad' => $this->normalizarUnidad($p->unidad),
                ];
            });
    }

    /**
     * Carga cotización, cliente, vendedor, venta y partidas si existe $id_cotizacion.
     */
    protected function cargarContextoCotizacion($id_cotizacion)
    {
        if (empty($id_cotizacion)) {
            return null;
        }

        $cotizacion = Cotizaciones::where('id_cotizacion', $id_cotizacion)->first();
        if (!$cotizacion) {
            return null;
        }

        $cliente = Clientes::where('idcl', $cotizacion->id_cliente)->first();
        $vendedor = !empty($cotizacion->id_usuario_genera)
            ? User::where('id', $cotizacion->id_usuario_genera)->first()
            : null;
        $venta = Ventas::where('id_cotizacion', $cotizacion->id_cotizacion)->first();
        $detallesCotizacion = DetalleCotizaciones::where('id_cotizacion', $cotizacion->id_cotizacion)
            ->orderBy('id_det_cotizacion', 'asc')
            ->get();

        $telefonoDefault = '';
        if ($cliente) {
            $telefonoDefault = !empty($cliente->telefonocl) ? $cliente->telefonocl : ($cliente->celularcl ?: '');
        }

        $vendedorDefault = $vendedor ? $vendedor->name : (Auth::user() ? Auth::user()->name : '');

        $estatusMap = [
            1 => ['texto' => 'Cotización Activa', 'badge' => 'badge-info'],
            2 => ['texto' => 'Inactiva', 'badge' => 'badge-secondary'],
            3 => ['texto' => 'Venta Aceptada', 'badge' => 'badge-success'],
            4 => ['texto' => 'Pendiente', 'badge' => 'badge-warning text-dark'],
            5 => ['texto' => 'Vencida', 'badge' => 'badge-secondary'],
            6 => ['texto' => 'Facturado', 'badge' => 'badge-primary'],
        ];
        $statusInt = (int) $cotizacion->status;
        $estatusInfo = isset($estatusMap[$statusInt])
            ? $estatusMap[$statusInt]
            : ['texto' => 'Estatus #' . $statusInt, 'badge' => 'badge-light'];

        return [
            'cotizacion'         => $cotizacion,
            'cliente'            => $cliente,
            'vendedor'           => $vendedor,
            'venta'              => $venta,
            'detallesCotizacion' => $detallesCotizacion,
            'telefonoDefault'    => $telefonoDefault,
            'vendedorDefault'    => $vendedorDefault,
            'estatusInfo'        => $estatusInfo,
        ];
    }

    /**
     * Obtiene logo y cinta de seguridad de Andamios Ligeros en Base64.
     */
    protected function obtenerAssetsAndamiosBase64($paraPdf = false)
    {
        if ($paraPdf) {
            $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/andamios.jpg');
            if (empty($logo)) {
                $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/andamios.png');
            }
            $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/Header-Cinta-de-Seguridad.jpg');
            if (empty($cinta)) {
                $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/Header-Cinta-de-Seguridad.png');
            }
        } else {
            $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/andamios.png');
            if (empty($logo)) {
                $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/andamios.jpg');
            }
            $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/Header-Cinta-de-Seguridad.png');
            if (empty($cinta)) {
                $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/Header-Cinta-de-Seguridad.jpg');
            }
        }

        return [
            'logoBase64'  => $logo,
            'cintaBase64' => $cinta,
        ];
    }

    /**
     * Convierte una fecha escrita en formato dd/mm/yyyy, dd/mm/yy o yyyy-mm-dd a Y-m-d o null si está vacía.
     */
    protected function parseFechaParaDb($fechaTexto)
    {
        $limpia = trim((string) $fechaTexto);
        if ($limpia === '' || strpos($limpia, '_') !== false) {
            return null;
        }

        $sinEspacios = str_replace(' ', '', $limpia);
        if (preg_match('/^(\d{1,2})\/(\d{1,2})\/(\d{2}|\d{4})$/', $sinEspacios, $m)) {
            $anio = (int) $m[3];
            if (strlen($m[3]) === 2) {
                $anio += 2000;
            }
            if (checkdate((int) $m[2], (int) $m[1], $anio)) {
                return sprintf('%04d-%02d-%02d', $anio, (int) $m[2], (int) $m[1]);
            }
        }

        if (preg_match('/^(\d{4})-(\d{1,2})-(\d{1,2})$/', $sinEspacios, $m)) {
            if (checkdate((int) $m[2], (int) $m[3], (int) $m[1])) {
                return sprintf('%04d-%02d-%02d', (int) $m[1], (int) $m[2], (int) $m[3]);
            }
        }

        return null;
    }

    /**
     * Normaliza un texto de fecha al formato estándar del selector (dd/mm/yyyy).
     * Si no es una fecha válida devuelve el texto original recortado (o vacío).
     */
    public function normalizarFechaTexto($fechaTexto)
    {
        $fechaDb = $this->parseFechaParaDb($fechaTexto);
        if ($fechaDb === null) {
            $limpia = trim((string) $fechaTexto);
            return strpos($limpia, '_') !== false ? '' : $limpia;
        }
        return date('d/m/Y', strtotime($fechaDb));
    }

    /**
     * Búsqueda AJAX de clientes (nombre, teléfono, celular o RFC) para autocompletado.
     */
    public function buscarClientes(Request $request)
    {
        $term = trim($request->input('term', $request->input('q', '')));
        if (mb_strlen($term) < 2) {
            return response()->json([]);
        }

        $clientes = Clientes::select('idcl', 'nombrecl', 'telefonocl', 'celularcl', 'emailcl', 'rfccl')
            ->where(function ($w) use ($term) {
                $w->where('nombrecl', 'LIKE', '%' . $term . '%')
                  ->orWhere('telefonocl', 'LIKE', '%' . $term . '%')
                  ->orWhere('celularcl', 'LIKE', '%' . $term . '%')
                  ->orWhere('rfccl', 'LIKE', '%' . $term . '%');
            })
            ->orderBy('idcl', 'DESC')
            ->limit(15)
            ->get();

        $termLower = mb_strtolower($term);
        $resultados = $clientes->map(function ($c) {
            $tel = trim((string) $c->telefonocl);
            $cel = trim((string) $c->celularcl);
            return [
                'id'       => $c->idcl,
                'nombre'   => trim((string) $c->nombrecl),
                'telefono' => $tel !== '' ? $tel : $cel,
                'celular'  => $cel,
                'email'    => trim((string) $c->emailcl),
                'rfc'      => trim((string) $c->rfccl),
            ];
        })->filter(function ($c) {
            return $c['nombre'] !== '';
        })->sort(function ($a, $b) use ($termLower) {
            $pa = (mb_strpos(mb_strtolower($a['nombre']), $termLower) === 0) ? 0 : 1;
            $pb = (mb_strpos(mb_strtolower($b['nombre']), $termLower) === 0) ? 0 : 1;
            if ($pa !== $pb) {
                return $pa - $pb;
            }
            return (int) $b['id'] - (int) $a['id'];
        })->values();

        return response()->json($resultados);
    }

    /**
     * Listado de usuarios activos del sistema (vendedores / personal) para autocompletado.
     */
    protected function obtenerCatalogoVendedores()
    {
        return User::where('estatus', 1)
            ->orderBy('name', 'ASC')
            ->get(['id', 'name', 'tipo_usuario'])
            ->map(function ($u) {
                $roles = ['admin' => 'Administrador', 'v1' => 'Vendedor', 't1' => 'Taller'];
                return [
                    'id'     => $u->id,
                    'nombre' => trim(preg_replace('/[^\p{L}\p{N}\s\.\-]/u', '', (string) $u->name)),
                    'rol'    => isset($roles[$u->tipo_usuario]) ? $roles[$u->tipo_usuario] : $u->tipo_usuario,
                ];
            })
            ->filter(function ($u) {
                return $u['nombre'] !== '';
            })
            ->values();
    }

    /**
     * Normaliza la unidad de medida para mostrar.
     */
    protected function normalizarUnidad($unidad)
    {
        $u = strtoupper(trim((string) $unidad));
        if ($u === '' || $u === 'PIEZA' || $u === 'PIEZAS' || $u === 'PZA' || $u === 'PZAS') {
            return 'pzas';
        }
        if ($u === 'M2' || $u === 'M²') {
            return 'm²';
        }
        return strtolower($u);
    }

    /**
     * Formatea una cantidad eliminando decimales .00 innecesarios.
     */
    public static function formatearCantidad($valor)
    {
        $num = floatval($valor);
        return number_format($num, $num == intval($num) ? 0 : 2, '.', ',');
    }

    /**
     * Obtiene cantidad total cotizada, unidad y nombre formateado de una partida cotizada.
     */
    public static function obtenerInfoProductoCotizado($item)
    {
        $tipoCobro = strtolower(trim($item->tipo_cobro ?: 'fijo'));
        $cant = floatval($item->cantidad ?: 1);

        if ($tipoCobro === 'm2') {
            $dim = floatval($item->dimensiones);
            if ($dim <= 0) {
                $largo = floatval($item->largo);
                $alto = floatval($item->alto);
                $dim = ($largo > 0 && $alto > 0) ? ($largo * $alto) : 1;
            }
            $totalCotizado = $cant > 1 ? ($cant * $dim) : $dim;
            $unidad = 'm²';
            $formatoDim = self::formatearCantidad($totalCotizado);
            $nombreMostrar = $item->nombre_producto . ' (' . $formatoDim . ' m²)';
        } else {
            $totalCotizado = $cant;
            $unidad = 'pzas';
            $nombreMostrar = $item->nombre_producto;
            if (!empty($item->dimensiones) && $item->dimensiones != 'N/A') {
                $nombreMostrar .= ' (' . $item->dimensiones . ')';
            }
        }

        return [
            'total_cotizado' => $totalCotizado,
            'unidad'         => $unidad,
            'nombre_mostrar' => $nombreMostrar,
            'tipo_cobro'     => $tipoCobro,
        ];
    }
}

