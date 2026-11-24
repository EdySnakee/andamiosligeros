<?php

namespace App\Http\Middleware;

use App\Cotizaciones;
use App\FormatoCambio;
use App\FormatoEntrega;
use App\HoraExtraEvento;
use App\HoraExtraSolicitud;
use App\OrdenEmbarque;
use App\OrdenTaller;
use App\SeguimientoTrabajo;
use App\Ventas;
use Carbon\Carbon;
use Closure;
use Illuminate\Support\Facades\Auth;

class RegistrarActividadHorasExtra
{
    /**
     * Registra ingresos a páginas y acciones de negocio dentro del sistema
     * únicamente mientras el usuario tiene una sesión de horas extra en curso.
     * Nunca interrumpe la petición principal.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        try {
            if ($request->attributes->get('_he_actividad_registrada', false)) {
                return $response;
            }
            $request->attributes->set('_he_actividad_registrada', true);

            if (!Auth::check()) {
                return $response;
            }

            $path = trim($request->path(), '/');
            if ($path === 'sb-admin/horas-extra/latido'
                || preg_match('#^sb-admin/horas-extra/\d+/(iniciar|finalizar)$#', $path)
            ) {
                return $response;
            }

            $metodo = strtoupper($request->method());

            // En peticiones GET solo registrar ingresos reales a páginas (ignorar autocompletados/tablas AJAX)
            if ($metodo === 'GET' && ($request->ajax() || $request->wantsJson())) {
                return $response;
            }

            // No registrar intentos fallidos (validaciones 422, errores 4xx/5xx o JSON de error)
            $jsonResp = $this->extraerJsonRespuesta($response);
            if ($metodo !== 'GET' && !$this->esRespuestaExitosa($response, $jsonResp)) {
                return $response;
            }

            $userId = (int) Auth::id();
            $solicitud = HoraExtraSolicitud::where('user_id', $userId)
                ->where('estatus', HoraExtraSolicitud::ESTATUS_EN_CURSO)
                ->select('id', 'user_id')
                ->first();

            if (!$solicitud) {
                return $response;
            }

            $accionRaw = $request->input('accion');
            $accionLimpia = '';
            if (is_string($accionRaw) && $accionRaw !== '') {
                $accionLimpia = substr(preg_replace('/[^A-Za-z0-9_\-]/', '', $accionRaw), 0, 50);
            }

            // Ignorar sub-acciones AJAX automáticas de hidratación de tablas, filtros o apertura de modales
            if ($accionLimpia !== '') {
                $ignorarGlobal = [
                    'getTablaCotizaciones',
                    'muestraTablaCotizaciones',
                    'getTablaVentas',
                    'muestraTablaClientes',
                    'getTablaUsuarios',
                    'buscaClientes',
                    'seleccionaCliente',
                    'muestraProductos',
                    'detallarProducto',
                    'getMetodosPago',
                    'openConfirmInfo',
                    'openAddCondicion',
                    'openAddCliente',
                    'openEdit',
                    'dividirLugares',
                    'openModal',
                    'openModalUser',
                    'openModalProyecto',
                    'openModalBitacora',
                    'openModalEditBitacora',
                    'openModalTransferencia',
                    'actualizarTotales',
                    'actualizarInv',
                    'actualizarMov',
                    'filtrarCategoria',
                    'filtrarOrdenEm',
                    'getOrdenID',
                    'agregaEmpresa',
                    'actualizaContBitacora',
                ];
                if (in_array($accionLimpia, $ignorarGlobal, true)) {
                    return $response;
                }

                if ($path === 'sb-admin/ajax_cotizador' && in_array($accionLimpia, [
                    'agregarConcepto',
                    'eliminarConcepto',
                    'eliminaImpuesto',
                    'agregaImpuesto',
                    'addDescuento',
                    'addEnvio',
                    'delEnvio',
                    'validaEnvio',
                ], true)) {
                    return $response;
                }
            }

            $queryParams = [];
            if ($accionLimpia !== '') {
                $queryParams['accion'] = $accionLimpia;
            }

            $datos = $this->decodificarDatos($request);

            // 1. Cotizaciones y conversión a Venta
            if ($path === 'sb-admin/ajax_cotizador' && $accionLimpia !== '') {
                $idCoti = $this->extraerIdCotizacion($datos, $jsonResp, $accionLimpia, $userId);
                if ($idCoti > 0) {
                    $queryParams['coti'] = $idCoti;
                }
                if ($accionLimpia === 'confirmVende' && $idCoti > 0) {
                    $venta = Ventas::where('id_cotizacion', $idCoti)
                        ->orderBy('id_venta', 'desc')
                        ->select('id_venta')
                        ->first();
                    if ($venta) {
                        $queryParams['vta'] = (int) $venta->id_venta;
                    }
                }
            }

            // 2. Gestión y logística de Ventas
            if ($path === 'sb-admin/ajax_ventas') {
                $idVta = !empty($datos['id_vta'])
                    ? (int) $datos['id_vta']
                    : (!empty($datos['id_venta']) ? (int) $datos['id_venta'] : 0);
                if ($idVta > 0) {
                    $queryParams['vta'] = $idVta;
                }
            }

            // 3. Órdenes de Taller (acciones POST que reciben id_orden_taller)
            if (strpos($path, 'sb-admin/orden-taller/') === 0 && $metodo !== 'GET') {
                $idCotTaller = (int) $request->input('id_cotizacion', 0);
                if ($idCotTaller <= 0) {
                    $idOrdenTaller = (int) $request->input('id_orden_taller', 0);
                    if ($idOrdenTaller > 0) {
                        $ordenTaller = OrdenTaller::where('id_orden_taller', $idOrdenTaller)
                            ->select('id_cotizacion')
                            ->first();
                        if ($ordenTaller) {
                            $idCotTaller = (int) $ordenTaller->id_cotizacion;
                        }
                    }
                }
                if ($idCotTaller > 0) {
                    $queryParams['ot'] = $idCotTaller;
                }
            }

            // 4. Órdenes de Embarque
            if ($path === 'sb-admin/ajax_ordenes_embarque' && $accionLimpia !== '') {
                $idOe = 0;
                if ($accionLimpia === 'guardarOrdenEm') {
                    $ultimaOe = OrdenEmbarque::orderBy('id', 'desc')->select('id')->first();
                    if ($ultimaOe) {
                        $idOe = (int) $ultimaOe->id;
                    }
                } elseif (!empty($datos['ordenData']) && is_array($datos['ordenData']) && !empty($datos['ordenData']['id'])) {
                    $idOe = (int) $datos['ordenData']['id'];
                } elseif (!empty($datos['id'])) {
                    $idOe = (int) $datos['id'];
                }
                if ($idOe > 0) {
                    $queryParams['oe'] = $idOe;
                }
            }

            // 5. Formatos de Entrega y de Cambio de Producto
            if ($path === 'sb-admin/formatos/entrega/guardar') {
                $idFe = !empty($jsonResp['id_formato']) ? (int) $jsonResp['id_formato'] : 0;
                if ($idFe <= 0) {
                    $ultFe = FormatoEntrega::where('id_usuario', $userId)->orderBy('id', 'desc')->select('id')->first();
                    $idFe = $ultFe ? (int) $ultFe->id : 0;
                }
                if ($idFe > 0) {
                    $queryParams['fe'] = $idFe;
                }
            } elseif ($metodo === 'GET' && strpos($path, 'sb-admin/formatos/entrega') === 0 && (int) $request->input('editar', 0) > 0) {
                $queryParams['fe'] = (int) $request->input('editar');
            }

            if ($path === 'sb-admin/formatos/cambio-producto/guardar') {
                $idFc = !empty($jsonResp['id_formato']) ? (int) $jsonResp['id_formato'] : 0;
                if ($idFc <= 0) {
                    $ultFc = FormatoCambio::where('id_usuario', $userId)->orderBy('id', 'desc')->select('id')->first();
                    $idFc = $ultFc ? (int) $ultFc->id : 0;
                }
                if ($idFc > 0) {
                    $queryParams['fc'] = $idFc;
                }
            } elseif ($metodo === 'GET' && strpos($path, 'sb-admin/formatos/cambio-producto') === 0 && (int) $request->input('editar', 0) > 0) {
                $queryParams['fc'] = (int) $request->input('editar');
            }

            // 6. Seguimiento de proyectos / ventas
            if ($path === 'sb-admin/ajax_seguimiento' && $accionLimpia !== '') {
                $idCotSeg = !empty($datos['id_cotizacion'])
                    ? (int) $datos['id_cotizacion']
                    : (int) $request->input('id_cotizacion', 0);
                if ($idCotSeg <= 0) {
                    $idProy = !empty($datos['id_proyecto'])
                        ? (int) $datos['id_proyecto']
                        : (int) $request->input('id_proyecto', 0);
                    if ($idProy > 0) {
                        $seg = SeguimientoTrabajo::where('id_seguimiento', $idProy)
                            ->select('id_cotizacion')
                            ->first();
                        if ($seg) {
                            $idCotSeg = (int) $seg->id_cotizacion;
                        }
                    }
                }
                if ($idCotSeg > 0) {
                    $queryParams['coti'] = $idCotSeg;
                }
            }

            // 7. Clientes
            if ($path === 'sb-admin/ajax_clientes_web' && $accionLimpia !== '') {
                $idCli = 0;
                if ($accionLimpia === 'AddCliente' && !empty($jsonResp['idcl'])) {
                    $idCli = (int) $jsonResp['idcl'];
                } elseif (!empty($datos['id_cliente'])) {
                    $idCli = (int) $datos['id_cliente'];
                }
                if ($idCli > 0) {
                    $queryParams['cli'] = $idCli;
                }
            }

            $sufijoQuery = !empty($queryParams) ? ('?' . http_build_query($queryParams)) : '';
            $ruta = $metodo . ' /' . ltrim($path, '/') . $sufijoQuery;

            if ($metodo === 'GET') {
                $dedupeSeg = (int) config('horas_extra.dedupe_accion_get_seg', 30);
                $desde = Carbon::now()->subSeconds($dedupeSeg);
                $recienteMismaRuta = HoraExtraEvento::where('solicitud_id', $solicitud->id)
                    ->where('tipo', HoraExtraEvento::TIPO_ACCION)
                    ->where('ruta', $ruta)
                    ->where('created_at', '>=', $desde)
                    ->exists();

                if ($recienteMismaRuta) {
                    return $response;
                }
            }

            HoraExtraEvento::registrar($solicitud, HoraExtraEvento::TIPO_ACCION, $request, [
                'user_id' => $userId,
                'ruta'    => $ruta,
            ]);
        } catch (\Throwable $e) {
            // Silencioso para no afectar la operación del sistema
        }

        return $response;
    }

    /**
     * Normaliza el payload 'datos' enviado por peticiones AJAX del panel.
     *
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    protected function decodificarDatos($request)
    {
        $datos = $request->input('datos');
        if (is_string($datos)) {
            $datos = json_decode($datos, true) ?: [];
        } elseif (is_object($datos)) {
            $datos = json_decode(json_encode($datos), true) ?: [];
        }
        return is_array($datos) ? $datos : [];
    }

    /**
     * Decodifica el cuerpo JSON de la respuesta si aplica.
     *
     * @param mixed $response
     * @return array
     */
    protected function extraerJsonRespuesta($response)
    {
        if (!is_object($response) || !method_exists($response, 'getContent')) {
            return [];
        }
        $contenido = (string) $response->getContent();
        if ($contenido === '' || ($contenido[0] !== '{' && $contenido[0] !== '[')) {
            return [];
        }
        $json = json_decode($contenido, true);
        return is_array($json) ? $json : [];
    }

    /**
     * Determina si una respuesta de acción modificadora fue exitosa.
     *
     * @param mixed $response
     * @param array $jsonResp
     * @return bool
     */
    protected function esRespuestaExitosa($response, array $jsonResp)
    {
        if (is_object($response) && method_exists($response, 'getStatusCode')) {
            if ((int) $response->getStatusCode() >= 400) {
                return false;
            }
        }
        if (array_key_exists('success', $jsonResp) && $jsonResp['success'] === false) {
            return false;
        }
        if (isset($jsonResp['status']) && $jsonResp['status'] === 'error') {
            return false;
        }
        return true;
    }

    /**
     * Obtiene el id_cotizacion involucrado en una operación de ajax_cotizador.
     *
     * @param array $datos
     * @param array $jsonResp
     * @param string $accion
     * @param int $userId
     * @return int
     */
    protected function extraerIdCotizacion(array $datos, array $jsonResp, $accion, $userId)
    {
        if ($accion === 'postCotizacion') {
            if (!empty($jsonResp['ruta_coti'])) {
                $hash = basename((string) $jsonResp['ruta_coti']);
                if ($hash !== '') {
                    $coti = Cotizaciones::where('ruta_encrypt', $hash)
                        ->select('id_cotizacion')
                        ->first();
                    if ($coti) {
                        return (int) $coti->id_cotizacion;
                    }
                }
            }

            $ultima = Cotizaciones::where('id_usuario_genera', $userId)
                ->orderBy('id_cotizacion', 'desc')
                ->select('id_cotizacion')
                ->first();

            return $ultima ? (int) $ultima->id_cotizacion : 0;
        }

        if (!empty($datos['id_cotizacion'])) {
            return (int) $datos['id_cotizacion'];
        }
        if (!empty($datos['id_coti'])) {
            return (int) $datos['id_coti'];
        }

        return 0;
    }
}
