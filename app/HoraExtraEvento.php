<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HoraExtraEvento extends Model
{
    protected $table = 'horas_extra_eventos';

    public $timestamps = false;

    const TIPO_INICIO = 'inicio';
    const TIPO_FIN = 'fin';
    const TIPO_LATIDO = 'latido';
    const TIPO_ACCION = 'accion';
    const TIPO_CIERRE_ADMIN = 'cierre_admin';

    const UBICACION_CONCEDIDA = 'concedida';
    const UBICACION_DENEGADA = 'denegada';
    const UBICACION_NO_DISPONIBLE = 'no_disponible';

    /**
     * Cachés en memoria para enriquecer la línea de tiempo sin consultas N+1.
     */
    protected static $cacheCotizaciones = [];
    protected static $cacheVentasPorId = [];
    protected static $cacheVentasPorCoti = [];
    protected static $cacheOrdenesEmbarque = [];
    protected static $cacheFormatosEntrega = [];
    protected static $cacheFormatosCambio = [];
    protected static $cacheClientes = [];

    protected $fillable = [
        'solicitud_id',
        'user_id',
        'tipo',
        'ruta',
        'ip',
        'user_agent',
        'latitud',
        'longitud',
        'precision_m',
        'ubicacion_estado',
        'created_at',
    ];

    protected $dates = [
        'created_at',
    ];

    protected $casts = [
        'latitud'     => 'float',
        'longitud'    => 'float',
        'precision_m' => 'integer',
    ];

    /**
     * Relación con la solicitud de horas extra.
     */
    public function solicitud()
    {
        return $this->belongsTo(HoraExtraSolicitud::class, 'solicitud_id');
    }

    /**
     * Relación con el usuario que generó el evento.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Obtiene la IP real del cliente respetando cabeceras de proxy.
     *
     * @param Request $request
     * @return string|null
     */
    public static function ipCliente(Request $request)
    {
        $ip = null;
        if (!empty($request->server('HTTP_CLIENT_IP'))) {
            $ip = $request->server('HTTP_CLIENT_IP');
        } elseif (!empty($request->server('HTTP_X_FORWARDED_FOR'))) {
            $partes = explode(',', $request->server('HTTP_X_FORWARDED_FOR'));
            $ip = trim($partes[0]);
        } else {
            $ip = $request->server('REMOTE_ADDR');
        }

        return $ip ? substr((string) $ip, 0, 64) : null;
    }

    /**
     * Registra un evento de auditoría o actividad vinculado a una solicitud.
     *
     * @param HoraExtraSolicitud|int $solicitud
     * @param string $tipo
     * @param Request $request
     * @param array $extra
     * @return self
     */
    public static function registrar($solicitud, $tipo, Request $request, array $extra = [])
    {
        $solicitudId = is_object($solicitud) ? (int) $solicitud->id : (int) $solicitud;

        if (isset($extra['user_id'])) {
            $userId = (int) $extra['user_id'];
        } elseif (is_object($solicitud) && !empty($solicitud->user_id)) {
            $userId = (int) $solicitud->user_id;
        } elseif (Auth::check()) {
            $userId = (int) Auth::id();
        } else {
            $userId = 0;
        }

        $ruta = isset($extra['ruta'])
            ? $extra['ruta']
            : ('/' . ltrim($request->path(), '/'));

        $ua = $request->server('HTTP_USER_AGENT');

        return self::create([
            'solicitud_id'     => $solicitudId,
            'user_id'          => $userId,
            'tipo'             => $tipo,
            'ruta'             => $ruta !== null ? substr((string) $ruta, 0, 255) : null,
            'ip'               => isset($extra['ip']) ? $extra['ip'] : self::ipCliente($request),
            'user_agent'       => $ua ? substr((string) $ua, 0, 255) : null,
            'latitud'          => array_key_exists('latitud', $extra) ? $extra['latitud'] : null,
            'longitud'         => array_key_exists('longitud', $extra) ? $extra['longitud'] : null,
            'precision_m'      => array_key_exists('precision_m', $extra) ? $extra['precision_m'] : null,
            'ubicacion_estado' => array_key_exists('ubicacion_estado', $extra) ? $extra['ubicacion_estado'] : null,
            'created_at'       => isset($extra['created_at']) ? $extra['created_at'] : Carbon::now(),
        ]);
    }

    /**
     * Precarga en bloque las entidades referenciadas en una colección de eventos.
     *
     * @param mixed $eventos
     * @return void
     */
    public static function precargarParaEventos($eventos)
    {
        $idsCoti = [];
        $idsVta = [];
        $idsOe = [];
        $idsFe = [];
        $idsFc = [];
        $idsCli = [];

        foreach ($eventos as $ev) {
            $rutaStr = (string) ($ev->ruta ?: '');
            if ($rutaStr === '') {
                continue;
            }

            if (preg_match('/[?&]coti=(\d+)/', $rutaStr, $m)) {
                $idsCoti[] = (int) $m[1];
            }
            if (preg_match('/[?&]ot=(\d+)/', $rutaStr, $m)) {
                $idsCoti[] = (int) $m[1];
            }
            if (preg_match('/[?&]vta=(\d+)/', $rutaStr, $m)) {
                $idsVta[] = (int) $m[1];
            }
            if (preg_match('/[?&]oe=(\d+)/', $rutaStr, $m)) {
                $idsOe[] = (int) $m[1];
            }
            if (preg_match('/[?&]fe=(\d+)/', $rutaStr, $m)) {
                $idsFe[] = (int) $m[1];
            }
            if (preg_match('/[?&]fc=(\d+)/', $rutaStr, $m)) {
                $idsFc[] = (int) $m[1];
            }
            if (preg_match('/[?&]cli=(\d+)/', $rutaStr, $m)) {
                $idsCli[] = (int) $m[1];
            }

            if (preg_match('#sb-admin/(?:edita-cotizacion|seguimineto|orden-taller)/(\d+)(?:\?|$)#', $rutaStr, $m)) {
                $idsCoti[] = (int) $m[1];
            } elseif (preg_match('#sb-admin/formatos/entrega/(\d+)/(?:actualizar|ver|pdf|eliminar)(?:\?|$)#', $rutaStr, $m)) {
                $idsFe[] = (int) $m[1];
            } elseif (preg_match('#sb-admin/formatos/entrega/(\d+)(?:\?|$)#', $rutaStr, $m)) {
                $idsCoti[] = (int) $m[1];
            } elseif (preg_match('#sb-admin/formatos/cambio-producto/(\d+)/(?:actualizar|ver|pdf|eliminar)(?:\?|$)#', $rutaStr, $m)) {
                $idsFc[] = (int) $m[1];
            } elseif (preg_match('#sb-admin/formatos/cambio-producto/(\d+)(?:\?|$)#', $rutaStr, $m)) {
                $idsCoti[] = (int) $m[1];
            }
        }

        if (!empty($idsCoti)) {
            self::precargarCotizaciones($idsCoti);
        }
        if (!empty($idsVta) || !empty($idsCoti)) {
            self::precargarVentas($idsVta, $idsCoti);
        }
        if (!empty($idsOe)) {
            self::precargarOrdenesEmbarque($idsOe);
        }
        if (!empty($idsFe)) {
            self::precargarFormatosEntrega($idsFe);
        }
        if (!empty($idsFc)) {
            self::precargarFormatosCambio($idsFc);
        }
        if (!empty($idsCli)) {
            self::precargarClientes($idsCli);
        }
    }

    /**
     * Precarga en una sola consulta un conjunto de cotizaciones por ID.
     *
     * @param array $ids
     * @return void
     */
    public static function precargarCotizaciones(array $ids)
    {
        $faltantes = [];
        foreach ($ids as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheCotizaciones)) {
                $faltantes[$idInt] = $idInt;
            }
        }

        if (empty($faltantes)) {
            return;
        }

        try {
            $filas = Cotizaciones::whereIn('id_cotizacion', array_values($faltantes))
                ->select('id_cotizacion', 'cod_cotizacion', 'giro_empresa', 'ruta_encrypt')
                ->get();

            foreach ($faltantes as $idBuscado) {
                self::$cacheCotizaciones[$idBuscado] = null;
            }
            foreach ($filas as $coti) {
                self::$cacheCotizaciones[(int) $coti->id_cotizacion] = $coti;
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    /**
     * Precarga ventas por id_venta y/o por id_cotizacion.
     *
     * @param array $idsVenta
     * @param array $idsCoti
     * @return void
     */
    public static function precargarVentas(array $idsVenta = [], array $idsCoti = [])
    {
        $faltanVta = [];
        foreach ($idsVenta as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheVentasPorId)) {
                $faltanVta[$idInt] = $idInt;
            }
        }

        $faltanCoti = [];
        foreach ($idsCoti as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheVentasPorCoti)) {
                $faltanCoti[$idInt] = $idInt;
            }
        }

        if (empty($faltanVta) && empty($faltanCoti)) {
            return;
        }

        try {
            $query = Ventas::select('id_venta', 'id_cotizacion', 'cod_venta', 'giro_empresa', 'ruta_encrypt')
                ->orderBy('id_venta', 'desc');

            $query->where(function ($q) use ($faltanVta, $faltanCoti) {
                if (!empty($faltanVta)) {
                    $q->whereIn('id_venta', array_values($faltanVta));
                }
                if (!empty($faltanCoti)) {
                    $q->orWhereIn('id_cotizacion', array_values($faltanCoti));
                }
            });

            $filas = $query->get();

            foreach ($faltanVta as $idV) {
                self::$cacheVentasPorId[$idV] = null;
            }
            foreach ($faltanCoti as $idC) {
                self::$cacheVentasPorCoti[$idC] = null;
            }

            foreach ($filas as $vta) {
                $idV = (int) $vta->id_venta;
                $idC = (int) $vta->id_cotizacion;
                self::$cacheVentasPorId[$idV] = $vta;
                if ($idC > 0 && empty(self::$cacheVentasPorCoti[$idC])) {
                    self::$cacheVentasPorCoti[$idC] = $vta;
                }
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    /**
     * Precarga órdenes de embarque por ID.
     */
    public static function precargarOrdenesEmbarque(array $ids)
    {
        $faltantes = [];
        foreach ($ids as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheOrdenesEmbarque)) {
                $faltantes[$idInt] = $idInt;
            }
        }
        if (empty($faltantes)) {
            return;
        }

        try {
            $filas = OrdenEmbarque::whereIn('id', array_values($faltantes))
                ->select('id', 'origen', 'destino')
                ->get();

            foreach ($faltantes as $idBuscado) {
                self::$cacheOrdenesEmbarque[$idBuscado] = null;
            }
            foreach ($filas as $oe) {
                self::$cacheOrdenesEmbarque[(int) $oe->id] = $oe;
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    /**
     * Precarga formatos de entrega por ID.
     */
    public static function precargarFormatosEntrega(array $ids)
    {
        $faltantes = [];
        foreach ($ids as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheFormatosEntrega)) {
                $faltantes[$idInt] = $idInt;
            }
        }
        if (empty($faltantes)) {
            return;
        }

        try {
            $filas = FormatoEntrega::whereIn('id', array_values($faltantes))
                ->select('id', 'folio_entrega', 'id_cotizacion')
                ->get();

            foreach ($faltantes as $idBuscado) {
                self::$cacheFormatosEntrega[$idBuscado] = null;
            }
            foreach ($filas as $fe) {
                self::$cacheFormatosEntrega[(int) $fe->id] = $fe;
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    /**
     * Precarga formatos de cambio por ID.
     */
    public static function precargarFormatosCambio(array $ids)
    {
        $faltantes = [];
        foreach ($ids as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheFormatosCambio)) {
                $faltantes[$idInt] = $idInt;
            }
        }
        if (empty($faltantes)) {
            return;
        }

        try {
            $filas = FormatoCambio::whereIn('id', array_values($faltantes))
                ->select('id', 'folio_cambio', 'id_cotizacion')
                ->get();

            foreach ($faltantes as $idBuscado) {
                self::$cacheFormatosCambio[$idBuscado] = null;
            }
            foreach ($filas as $fc) {
                self::$cacheFormatosCambio[(int) $fc->id] = $fc;
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    /**
     * Precarga clientes por ID.
     */
    public static function precargarClientes(array $ids)
    {
        $faltantes = [];
        foreach ($ids as $id) {
            $idInt = (int) $id;
            if ($idInt > 0 && !array_key_exists($idInt, self::$cacheClientes)) {
                $faltantes[$idInt] = $idInt;
            }
        }
        if (empty($faltantes)) {
            return;
        }

        try {
            $filas = Clientes::whereIn('idcl', array_values($faltantes))
                ->select('idcl', 'nombrecl')
                ->get();

            foreach ($faltantes as $idBuscado) {
                self::$cacheClientes[$idBuscado] = null;
            }
            foreach ($filas as $cli) {
                self::$cacheClientes[(int) $cli->idcl] = $cli;
            }
        } catch (\Throwable $e) {
            // Silencioso
        }
    }

    public static function obtenerCotizacion($idCotizacion)
    {
        $idInt = (int) $idCotizacion;
        if ($idInt <= 0) {
            return null;
        }
        if (!array_key_exists($idInt, self::$cacheCotizaciones)) {
            self::precargarCotizaciones([$idInt]);
        }
        return isset(self::$cacheCotizaciones[$idInt]) ? self::$cacheCotizaciones[$idInt] : null;
    }

    public static function obtenerVenta($idVenta = 0, $idCotizacion = 0)
    {
        $idV = (int) $idVenta;
        if ($idV > 0) {
            if (!array_key_exists($idV, self::$cacheVentasPorId)) {
                self::precargarVentas([$idV], []);
            }
            if (!empty(self::$cacheVentasPorId[$idV])) {
                return self::$cacheVentasPorId[$idV];
            }
        }

        $idC = (int) $idCotizacion;
        if ($idC > 0) {
            if (!array_key_exists($idC, self::$cacheVentasPorCoti)) {
                self::precargarVentas([], [$idC]);
            }
            if (!empty(self::$cacheVentasPorCoti[$idC])) {
                return self::$cacheVentasPorCoti[$idC];
            }
        }

        return null;
    }

    protected static function slugGiro($giro)
    {
        $g = strtolower(trim((string) $giro));
        if ($g === 'ra') {
            return 'redes-anticaidas';
        }
        if ($g === 'rp') {
            return 'redes-perimetrales';
        }
        if ($g === 'sg') {
            return 'score-gol';
        }
        return 'andamios-ligeros';
    }

    public static function urlCotizacion($coti)
    {
        if (!empty($coti->ruta_encrypt)) {
            return url('/cotizaciones/' . self::slugGiro($coti->giro_empresa) . '/' . $coti->ruta_encrypt);
        }
        return url('/sb-admin/edita-cotizacion/' . $coti->id_cotizacion);
    }

    public static function urlVenta($venta)
    {
        if (!empty($venta->ruta_encrypt)) {
            return url('/ventas/' . self::slugGiro($venta->giro_empresa) . '/' . $venta->ruta_encrypt);
        }
        return url('/sb-admin/ventas');
    }

    protected static function datosEnlaceCotizacion($idCoti)
    {
        $idInt = (int) $idCoti;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        $coti = self::obtenerCotizacion($idInt);
        if ($coti) {
            $codigo = !empty($coti->cod_cotizacion) ? $coti->cod_cotizacion : ('#' . $idInt);
            return [
                'texto' => $codigo,
                'url'   => self::urlCotizacion($coti),
            ];
        }

        return [
            'texto' => '#' . $idInt,
            'url'   => null,
        ];
    }

    protected static function datosEnlaceVenta($idVta, $idCotiFallback = 0)
    {
        $venta = self::obtenerVenta((int) $idVta, (int) $idCotiFallback);
        if ($venta) {
            $codigo = !empty($venta->cod_venta) ? $venta->cod_venta : ('#' . $venta->id_venta);
            return [
                'texto' => $codigo,
                'url'   => self::urlVenta($venta),
            ];
        }

        if ((int) $idVta > 0) {
            return [
                'texto' => '#' . (int) $idVta,
                'url'   => url('/sb-admin/ventas'),
            ];
        }

        if ((int) $idCotiFallback > 0) {
            return self::datosEnlaceCotizacion((int) $idCotiFallback);
        }

        return ['texto' => null, 'url' => null];
    }

    protected static function datosEnlaceOrdenTaller($idCotizacion)
    {
        $idInt = (int) $idCotizacion;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        $venta = self::obtenerVenta(0, $idInt);
        $coti = self::obtenerCotizacion($idInt);

        if ($venta && !empty($venta->cod_venta)) {
            $folio = $venta->cod_venta;
        } elseif ($coti && !empty($coti->cod_cotizacion)) {
            $folio = $coti->cod_cotizacion;
        } else {
            $folio = '#' . $idInt;
        }

        return [
            'texto' => $folio,
            'url'   => url('/sb-admin/orden-taller/' . $idInt),
        ];
    }

    protected static function datosEnlaceSeguimiento($idCotizacion)
    {
        $idInt = (int) $idCotizacion;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        $venta = self::obtenerVenta(0, $idInt);
        $coti = self::obtenerCotizacion($idInt);

        if ($venta && !empty($venta->cod_venta)) {
            $folio = $venta->cod_venta;
        } elseif ($coti && !empty($coti->cod_cotizacion)) {
            $folio = $coti->cod_cotizacion;
        } else {
            $folio = '#' . $idInt;
        }

        return [
            'texto' => $folio,
            'url'   => url('/sb-admin/seguimineto/' . $idInt),
        ];
    }

    protected static function datosEnlaceOrdenEmbarque($idOrden)
    {
        $idInt = (int) $idOrden;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        if (!array_key_exists($idInt, self::$cacheOrdenesEmbarque)) {
            self::precargarOrdenesEmbarque([$idInt]);
        }
        $oe = isset(self::$cacheOrdenesEmbarque[$idInt]) ? self::$cacheOrdenesEmbarque[$idInt] : null;

        if ($oe && !empty($oe->origen) && !empty($oe->destino)) {
            $texto = '#' . $oe->id . ' (' . $oe->origen . ' -> ' . $oe->destino . ')';
        } else {
            $texto = '#' . $idInt;
        }

        return [
            'texto' => $texto,
            'url'   => url('/sb-admin/ordenes-embarque'),
        ];
    }

    protected static function datosEnlaceFormatoEntrega($idFormato)
    {
        $idInt = (int) $idFormato;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        if (!array_key_exists($idInt, self::$cacheFormatosEntrega)) {
            self::precargarFormatosEntrega([$idInt]);
        }
        $fe = isset(self::$cacheFormatosEntrega[$idInt]) ? self::$cacheFormatosEntrega[$idInt] : null;

        if ($fe && !empty($fe->folio_entrega)) {
            $folio = trim((string) $fe->folio_entrega);
            $texto = ctype_digit($folio) ? ('Folio ' . $folio) : $folio;
        } else {
            $texto = '#' . $idInt;
        }

        return [
            'texto' => $texto,
            'url'   => url('/sb-admin/formatos/entrega/' . $idInt . '/ver'),
        ];
    }

    protected static function datosEnlaceFormatoCambio($idFormato)
    {
        $idInt = (int) $idFormato;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        if (!array_key_exists($idInt, self::$cacheFormatosCambio)) {
            self::precargarFormatosCambio([$idInt]);
        }
        $fc = isset(self::$cacheFormatosCambio[$idInt]) ? self::$cacheFormatosCambio[$idInt] : null;

        $texto = ($fc && !empty($fc->folio_cambio))
            ? trim((string) $fc->folio_cambio)
            : ('#' . $idInt);

        return [
            'texto' => $texto,
            'url'   => url('/sb-admin/formatos/cambio-producto/' . $idInt . '/ver'),
        ];
    }

    protected static function datosEnlaceCliente($idCliente)
    {
        $idInt = (int) $idCliente;
        if ($idInt <= 0) {
            return ['texto' => null, 'url' => null];
        }

        if (!array_key_exists($idInt, self::$cacheClientes)) {
            self::precargarClientes([$idInt]);
        }
        $cli = isset(self::$cacheClientes[$idInt]) ? self::$cacheClientes[$idInt] : null;

        $texto = ($cli && !empty($cli->nombrecl))
            ? trim((string) $cli->nombrecl)
            : ('#' . $idInt);

        return [
            'texto' => $texto,
            'url'   => url('/sb-admin/clientes'),
        ];
    }

    /**
     * Traduce el evento actual a un módulo, descripción en español ("Ingresó a ...") y enlace opcional.
     *
     * @return array
     */
    public function describirActividad()
    {
        if ($this->tipo === self::TIPO_INICIO) {
            return [
                'modulo'       => 'Horas extra',
                'descripcion'  => 'Inició la sesión de horas extra',
                'enlace_texto' => null,
                'enlace_url'   => null,
                'es_hito'      => true,
            ];
        }
        if ($this->tipo === self::TIPO_FIN) {
            return [
                'modulo'       => 'Horas extra',
                'descripcion'  => 'Finalizó la sesión y envió su resumen de actividades',
                'enlace_texto' => null,
                'enlace_url'   => null,
                'es_hito'      => true,
            ];
        }
        if ($this->tipo === self::TIPO_CIERRE_ADMIN) {
            return [
                'modulo'       => 'Horas extra',
                'descripcion'  => 'Sesión cerrada administrativamente',
                'enlace_texto' => null,
                'enlace_url'   => null,
                'es_hito'      => true,
            ];
        }

        $raw = trim((string) $this->ruta);
        $metodo = 'GET';
        $urlParte = $raw;

        if (preg_match('/^(GET|POST|PUT|PATCH|DELETE)\s+(.+)$/i', $raw, $m)) {
            $metodo = strtoupper($m[1]);
            $urlParte = trim($m[2]);
        }

        $partes = explode('?', $urlParte, 2);
        $path = trim($partes[0], '/');
        $accionAjax = null;
        $ctx = [
            'coti' => 0,
            'vta'  => 0,
            'ot'   => 0,
            'oe'   => 0,
            'fe'   => 0,
            'fc'   => 0,
            'cli'  => 0,
        ];

        if (isset($partes[1]) && $partes[1] !== '') {
            parse_str($partes[1], $query);
            if (!empty($query['accion']) && is_string($query['accion'])) {
                $accionAjax = $query['accion'];
            }
            foreach (array_keys($ctx) as $llave) {
                if (!empty($query[$llave])) {
                    $ctx[$llave] = (int) $query[$llave];
                }
            }
        }

        $info = self::traducirRuta($metodo, $path, $accionAjax, $ctx);

        if ($this->tipo === self::TIPO_LATIDO) {
            return [
                'modulo'       => $info['modulo'],
                'descripcion'  => 'Permanencia activa en ' . $info['pantalla'],
                'enlace_texto' => isset($info['enlace_texto']) ? $info['enlace_texto'] : null,
                'enlace_url'   => isset($info['enlace_url']) ? $info['enlace_url'] : null,
                'es_hito'      => false,
            ];
        }

        return [
            'modulo'       => $info['modulo'],
            'descripcion'  => $info['descripcion'],
            'enlace_texto' => isset($info['enlace_texto']) ? $info['enlace_texto'] : null,
            'enlace_url'   => isset($info['enlace_url']) ? $info['enlace_url'] : null,
            'es_hito'      => false,
        ];
    }

    /**
     * Convierte una ruta + método + acción AJAX + IDs capturados en texto claro y enlace directo.
     *
     * @param string $metodo
     * @param string $path
     * @param string|null $accionAjax
     * @param array|int $ctx
     * @return array
     */
    public static function traducirRuta($metodo, $path, $accionAjax = null, $ctx = [])
    {
        $metodo = strtoupper((string) $metodo);
        $path = trim((string) $path, '/');

        if (is_int($ctx) || is_numeric($ctx)) {
            $ctx = ['coti' => (int) $ctx];
        }
        $idCoti = isset($ctx['coti']) ? (int) $ctx['coti'] : 0;
        $idVta  = isset($ctx['vta']) ? (int) $ctx['vta'] : 0;
        $idOt   = isset($ctx['ot']) ? (int) $ctx['ot'] : 0;
        $idOe   = isset($ctx['oe']) ? (int) $ctx['oe'] : 0;
        $idFe   = isset($ctx['fe']) ? (int) $ctx['fe'] : 0;
        $idFc   = isset($ctx['fc']) ? (int) $ctx['fc'] : 0;
        $idCli  = isset($ctx['cli']) ? (int) $ctx['cli'] : 0;

        // 1. Cotizador y conversión de cotización a Venta
        if ($path === 'sb-admin/ajax_cotizador') {
            if ($accionAjax === 'confirmVende') {
                $linkVta = self::datosEnlaceVenta($idVta, $idCoti);
                return [
                    'modulo'       => 'Ventas',
                    'pantalla'     => 'Ventas',
                    'descripcion'  => $linkVta['texto'] ? 'Realizó venta' : 'Realizó una venta',
                    'enlace_texto' => $linkVta['texto'],
                    'enlace_url'   => $linkVta['url'],
                ];
            }

            $link = self::datosEnlaceCotizacion($idCoti);

            if ($accionAjax === 'postCotizacion') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizar',
                    'descripcion'  => $link['texto'] ? 'Creó cotización' : 'Creó una cotización',
                    'enlace_texto' => $link['texto'],
                    'enlace_url'   => $link['url'],
                ];
            }
            if ($accionAjax === 'editCotizacion') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizaciones',
                    'descripcion'  => $link['texto'] ? 'Modificó cotización' : 'Modificó una cotización',
                    'enlace_texto' => $link['texto'],
                    'enlace_url'   => $link['url'],
                ];
            }
            if ($accionAjax === 'confirmDesactiva') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizaciones',
                    'descripcion'  => $link['texto'] ? 'Desactivó cotización' : 'Desactivó una cotización',
                    'enlace_texto' => $link['texto'],
                    'enlace_url'   => $link['url'],
                ];
            }
            if ($accionAjax === 'confirmActiva') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizaciones',
                    'descripcion'  => $link['texto'] ? 'Reactivó cotización' : 'Reactivó una cotización',
                    'enlace_texto' => $link['texto'],
                    'enlace_url'   => $link['url'],
                ];
            }
            if ($accionAjax === 'confirmElimina') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizaciones',
                    'descripcion'  => $idCoti > 0 ? ('Eliminó cotización #' . $idCoti) : 'Eliminó una cotización',
                    'enlace_texto' => null,
                    'enlace_url'   => null,
                ];
            }
            if ($accionAjax === 'generaQR') {
                return [
                    'modulo'       => 'Cotizador',
                    'pantalla'     => 'Cotizaciones',
                    'descripcion'  => 'Generó código QR de cotización',
                    'enlace_texto' => $link['texto'],
                    'enlace_url'   => $link['url'],
                ];
            }

            return [
                'modulo'       => 'Cotizador',
                'pantalla'     => 'Cotizar',
                'descripcion'  => 'Trabajó en Cotizar',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }

        // 2. Ventas (actualización de estatus y logística con enlace directo a la venta)
        if ($path === 'sb-admin/ajax_ventas') {
            $linkVta = self::datosEnlaceVenta($idVta, $idCoti);
            $tieneFolio = !empty($linkVta['texto']);

            $accionesVta = [
                'confirmTerminaVta'     => $tieneFolio ? 'Concluyó venta' : 'Concluyó una venta',
                'guardarLogisticaEnvio' => $tieneFolio ? 'Modificó logística de venta' : 'Modificó logística de una venta',
                'addEnvio'              => $tieneFolio ? 'Agregó envío a venta' : 'Agregó envío a una venta',
                'addEnvioPaqueteria'    => $tieneFolio ? 'Registró paquetería en venta' : 'Registró paquetería en una venta',
                'addPaqueteria'         => $tieneFolio ? 'Modificó paquetería de venta' : 'Modificó paquetería de una venta',
                'addOrigen'             => $tieneFolio ? 'Modificó origen de venta' : 'Modificó origen de una venta',
                'addDestino'            => $tieneFolio ? 'Modificó destino de venta' : 'Modificó destino de una venta',
            ];

            $desc = ($accionAjax && isset($accionesVta[$accionAjax]))
                ? $accionesVta[$accionAjax]
                : ($tieneFolio ? 'Modificó venta' : 'Ingresó a Ventas');

            return [
                'modulo'       => 'Ventas',
                'pantalla'     => 'Ventas',
                'descripcion'  => $desc,
                'enlace_texto' => $linkVta['texto'],
                'enlace_url'   => $linkVta['url'],
            ];
        }

        // 3. Órdenes de Taller (acciones POST con redirección a la orden)
        $accionesTaller = [
            'sb-admin/orden-taller/actualizar-progreso' => ['Actualizó avance de orden de taller', 'Actualizó avance en Orden de Taller'],
            'sb-admin/orden-taller/marcar-impreso'      => ['Marcó impresa orden de taller', 'Marcó Orden de Taller como impresa'],
            'sb-admin/orden-taller/agregar-nota'        => ['Agregó nota en orden de taller', 'Agregó nota en Orden de Taller'],
            'sb-admin/orden-taller/confirmar-envio'     => ['Confirmó envío de orden de taller', 'Confirmó envío de Orden de Taller'],
        ];
        if (isset($accionesTaller[$path])) {
            $linkOt = self::datosEnlaceOrdenTaller($idOt ?: $idCoti);
            return [
                'modulo'       => 'Taller',
                'pantalla'     => 'Órdenes de Taller',
                'descripcion'  => $linkOt['texto'] ? $accionesTaller[$path][0] : $accionesTaller[$path][1],
                'enlace_texto' => $linkOt['texto'],
                'enlace_url'   => $linkOt['url'],
            ];
        }

        // 4. Órdenes de Embarque
        if ($path === 'sb-admin/ajax_ordenes_embarque') {
            if ($accionAjax === 'eliminarOrden') {
                return [
                    'modulo'       => 'Embarques',
                    'pantalla'     => 'Órdenes de Embarque',
                    'descripcion'  => $idOe > 0 ? ('Eliminó orden de embarque #' . $idOe) : 'Eliminó una orden de embarque',
                    'enlace_texto' => null,
                    'enlace_url'   => null,
                ];
            }

            $linkOe = self::datosEnlaceOrdenEmbarque($idOe);
            $tieneOe = !empty($linkOe['texto']);
            $accionesOe = [
                'guardarOrdenEm'  => $tieneOe ? 'Creó orden de embarque' : 'Creó una orden de embarque',
                'actualizarOrden' => $tieneOe ? 'Modificó orden de embarque' : 'Modificó una orden de embarque',
                'autorizarOrden'  => $tieneOe ? 'Autorizó orden de embarque' : 'Autorizó una orden de embarque',
                'completarOrden'  => $tieneOe ? 'Completó orden de embarque' : 'Completó una orden de embarque',
            ];

            $desc = ($accionAjax && isset($accionesOe[$accionAjax]))
                ? $accionesOe[$accionAjax]
                : ($tieneOe ? 'Actualizó orden de embarque' : 'Actualizó Órdenes de Embarque');

            return [
                'modulo'       => 'Embarques',
                'pantalla'     => 'Órdenes de Embarque',
                'descripcion'  => $desc,
                'enlace_texto' => $linkOe['texto'],
                'enlace_url'   => $linkOe['url'],
            ];
        }

        // 5. Creación o edición de Formatos de Entrega y Cambio de Producto
        if ($path === 'sb-admin/formatos/entrega/guardar') {
            $linkFe = self::datosEnlaceFormatoEntrega($idFe);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => $linkFe['texto'] ? 'Creó formato de entrega' : 'Creó un Formato de Entrega',
                'enlace_texto' => $linkFe['texto'],
                'enlace_url'   => $linkFe['url'],
            ];
        }
        if ($path === 'sb-admin/formatos/entrega' && $idFe > 0) {
            $linkFe = self::datosEnlaceFormatoEntrega($idFe);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => 'Ingresó a editar formato de entrega',
                'enlace_texto' => $linkFe['texto'],
                'enlace_url'   => $linkFe['url'],
            ];
        }
        if ($path === 'sb-admin/formatos/cambio-producto/guardar') {
            $linkFc = self::datosEnlaceFormatoCambio($idFc);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => $linkFc['texto'] ? 'Creó formato de cambio' : 'Creó un Formato de Cambio de Producto',
                'enlace_texto' => $linkFc['texto'],
                'enlace_url'   => $linkFc['url'],
            ];
        }
        if ($path === 'sb-admin/formatos/cambio-producto' && $idFc > 0) {
            $linkFc = self::datosEnlaceFormatoCambio($idFc);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => 'Ingresó a editar formato de cambio',
                'enlace_texto' => $linkFc['texto'],
                'enlace_url'   => $linkFc['url'],
            ];
        }

        // 6. Seguimiento de proyectos / ventas
        if ($path === 'sb-admin/ajax_seguimiento') {
            $linkSeg = self::datosEnlaceSeguimiento($idCoti);
            $tieneSeg = !empty($linkSeg['texto']);
            $accionesSeg = [
                'postSeguimientoProyecto' => $tieneSeg ? 'Inició seguimiento de venta' : 'Guardó avances de proyecto',
                'postBitacora'            => $tieneSeg ? 'Registró avance en seguimiento' : 'Registró avance en bitácora',
                'editBitacora'            => $tieneSeg ? 'Modificó avance en seguimiento' : 'Modificó entrada de bitácora',
                'eliminaBitacora'         => $tieneSeg ? 'Eliminó avance en seguimiento' : 'Eliminó entrada de bitácora',
            ];
            return [
                'modulo'       => 'Seguimiento',
                'pantalla'     => 'Seguimiento',
                'descripcion'  => ($accionAjax && isset($accionesSeg[$accionAjax])) ? $accionesSeg[$accionAjax] : 'Actualizó Seguimiento',
                'enlace_texto' => $linkSeg['texto'],
                'enlace_url'   => $linkSeg['url'],
            ];
        }

        // 7. Clientes
        if ($path === 'sb-admin/ajax_clientes_web') {
            if ($accionAjax === 'confirmDesactivaClient') {
                return [
                    'modulo'       => 'Clientes',
                    'pantalla'     => 'Clientes',
                    'descripcion'  => $idCli > 0 ? ('Dio de baja cliente #' . $idCli) : 'Dio de baja un cliente',
                    'enlace_texto' => null,
                    'enlace_url'   => null,
                ];
            }
            $linkCli = self::datosEnlaceCliente($idCli);
            $tieneCli = !empty($linkCli['texto']);
            $accionesCli = [
                'AddCliente'  => $tieneCli ? 'Registró cliente' : 'Registró un nuevo cliente',
                'editCliente' => $tieneCli ? 'Modificó cliente' : 'Modificó un cliente',
            ];
            return [
                'modulo'       => 'Clientes',
                'pantalla'     => 'Clientes',
                'descripcion'  => ($accionAjax && isset($accionesCli[$accionAjax])) ? $accionesCli[$accionAjax] : 'Ingresó a Clientes',
                'enlace_texto' => $linkCli['texto'],
                'enlace_url'   => $linkCli['url'],
            ];
        }

        // 8. Otros endpoints AJAX del panel
        $mapaAjax = [
            'sb-admin/ajax_clientes' => [
                'modulo'   => 'Clientes',
                'pantalla' => 'Clientes',
                'default'  => 'Ingresó a Clientes',
                'acciones' => [
                    'guardaClientes2'   => 'Registró un nuevo cliente',
                    'actualizaClientes' => 'Modificó un cliente',
                    'confirmDelete'     => 'Eliminó un cliente',
                ],
            ],
            'sb-admin/ajax_inventario' => [
                'modulo'   => 'Inventario',
                'pantalla' => 'Inventario General',
                'default'  => 'Actualizó Inventario General',
                'acciones' => [
                    'guardarTransferenica' => 'Registró transferencia de inventario',
                ],
            ],
            'sb-admin/inventarioSuc' => [
                'modulo'   => 'Inventario Sucursal',
                'pantalla' => 'Inventario Sucursal',
                'default'  => $metodo === 'GET' ? 'Ingresó a Inventario Sucursal' : 'Actualizó Inventario Sucursal',
                'acciones' => [
                    'guardarEntrada'       => 'Registró entrada en Inventario Sucursal',
                    'guardarTransferenica' => 'Registró transferencia en Inventario Sucursal',
                ],
            ],
            'sb-admin/ajax_caja' => [
                'modulo'   => 'Caja chica',
                'pantalla' => 'Caja chica',
                'default'  => 'Actualizó Caja chica',
                'acciones' => [
                    'guardarRegistro'    => 'Registró movimiento en Caja chica',
                    'actualizarRegistro' => 'Modificó movimiento en Caja chica',
                    'eliminarRegistro'   => 'Eliminó movimiento en Caja chica',
                ],
            ],
            'sb-admin/ajax_productos' => [
                'modulo'   => 'Productos',
                'pantalla' => 'Listado de productos',
                'default'  => 'Actualizó catálogo de productos',
                'acciones' => [
                    'addProducto'    => 'Creó un producto en catálogo',
                    'editProducto'   => 'Modificó un producto en catálogo',
                    'confirmElimina' => 'Eliminó un producto del catálogo',
                ],
            ],
            'sb-admin/ajax_tienda' => [
                'modulo'   => 'Tienda Web',
                'pantalla' => 'Productos Tienda',
                'default'  => 'Actualizó Productos Tienda',
                'acciones' => [
                    'guardaProducto'   => 'Publicó producto en Tienda en Línea',
                    'editaProducto'    => 'Modificó producto en Tienda en Línea',
                    'confirmElimina'   => 'Eliminó producto de Tienda en Línea',
                    'confirmDesactiva' => 'Desactivó producto de Tienda en Línea',
                    'confirmActiva'    => 'Activó producto de Tienda en Línea',
                ],
            ],
            'sb-admin/ajax_promo' => [
                'modulo'   => 'Promociones',
                'pantalla' => 'Promociones',
                'default'  => 'Actualizó Promociones',
                'acciones' => [],
            ],
            'sb-admin/ajax_blog' => [
                'modulo'   => 'Blog',
                'pantalla' => 'Blog',
                'default'  => 'Actualizó Blog',
                'acciones' => [
                    'guardaBlog' => 'Publicó artículo en Blog',
                    'editaBlog'  => 'Modificó artículo en Blog',
                ],
            ],
            'sb-admin/ajax_usuarios' => [
                'modulo'   => 'Usuarios',
                'pantalla' => 'Todos los usuarios',
                'default'  => 'Actualizó Usuarios',
                'acciones' => [
                    'addUser'          => 'Creó un usuario',
                    'createUser'       => 'Creó un usuario',
                    'editUser'         => 'Modificó un usuario',
                    'ConfirmDesactiva' => 'Desactivó un usuario',
                    'ConfirmActiva'    => 'Activó un usuario',
                    'ConfirmElimina'   => 'Eliminó un usuario',
                ],
            ],
        ];

        if (isset($mapaAjax[$path])) {
            $cfg = $mapaAjax[$path];
            $desc = ($accionAjax && isset($cfg['acciones'][$accionAjax]))
                ? $cfg['acciones'][$accionAjax]
                : $cfg['default'];
            return [
                'modulo'       => $cfg['modulo'],
                'pantalla'     => $cfg['pantalla'],
                'descripcion'  => $desc,
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }

        // 9. Páginas del menú ("Ingresó a {Nombre de la página}")
        $paginas = [
            'sb-admin/dashboard'                 => ['Dashboard', 'Dashboard', 'Ingresó a Dashboard'],
            'sb-admin/genera-cotizacion'         => ['Cotizador', 'Cotizar', 'Ingresó a Cotizar'],
            'sb-admin/genera-cotizacion-renta'   => ['Cotizador', 'Cotizar Renta', 'Ingresó a Cotizar Renta'],
            'sb-admin/cotizaciones'              => ['Cotizador', 'Cotizaciones', 'Ingresó a Cotizaciones'],
            'sb-admin/exportar-cotizaciones'     => ['Cotizador', 'Cotizaciones', 'Exportó reporte de Cotizaciones'],
            'sb-admin/ventas'                    => ['Ventas', 'Ventas', 'Ingresó a Ventas'],
            'sb-admin/exportar-ventas'           => ['Ventas', 'Ventas', 'Exportó reporte de Ventas'],
            'sb-admin/clientes'                  => ['Clientes', 'Clientes', 'Ingresó a Clientes'],
            'sb-admin/est-ventas'                => ['Estadísticas', 'Est. de Ventas', 'Ingresó a Est. de Ventas'],
            'sb-admin/est-cotizaciones'          => ['Estadísticas', 'Est. Cotizaciones', 'Ingresó a Est. Cotizaciones'],
            'sb-admin/estadisticas'              => ['Estadísticas', 'Estadísticas', 'Ingresó a Estadísticas'],
            'sb-admin/formatos/entrega'          => ['Formatos', 'Formato de Entrega', 'Ingresó a Formato de Entrega'],
            'sb-admin/formatos/cambio-producto'  => ['Formatos', 'Cambio de Producto', 'Ingresó a Cambio de Producto'],
            'sb-admin/ordenes-taller'            => ['Taller', 'Órdenes de Taller', 'Ingresó a Órdenes de Taller'],
            'sb-admin/agregar-orden-taller'      => ['Taller', 'Nueva Orden de Taller', 'Ingresó a Nueva Orden de Taller'],
            'sb-admin/rastreo-guias'             => ['Taller', 'Rastreo de Guías', 'Ingresó a Rastreo de Guías'],
            'sb-admin/inventario'                => ['Inventario', 'Inventario General', 'Ingresó a Inventario General'],
            'sb-admin/ordenes-embarque'          => ['Embarques', 'Órdenes de Embarque', 'Ingresó a Órdenes de Embarque'],
            'sb-admin/horas-extra'               => ['Horas extra', 'Horas extra', 'Ingresó a Horas extra'],
            'sb-admin/horas-extra/guardar'       => ['Horas extra', 'Horas extra', 'Registró una solicitud de Horas extra'],
            'sb-admin/horas-extra/reporte/pdf'   => ['Horas extra', 'Horas extra', 'Descargó reporte PDF de Horas extra'],
            'sb-admin/productos'                 => ['Productos', 'Listado de productos', 'Ingresó a Listado de productos'],
            'sb-admin/agregar-producto'          => ['Productos', 'Agregar producto', 'Ingresó a Agregar producto'],
            'sb-admin/productos-tienda'          => ['Tienda Web', 'Productos Tienda', 'Ingresó a Productos Tienda'],
            'sb-admin/add-producto-tienda'       => ['Tienda Web', 'Agregar producto Tienda', 'Ingresó a Agregar producto Tienda'],
            'sb-admin/ajustes_tienda'            => ['Tienda Web', 'Ajustes de Tienda', 'Ingresó a Ajustes de Tienda'],
            'sb-admin/all-promos'                => ['Promociones', 'Promociones', 'Ingresó a Promociones'],
            'sb-admin/add-promo'                 => ['Promociones', 'Agregar promoción', 'Ingresó a Agregar promoción'],
            'sb-admin/articulos'                 => ['Blog', 'Todos los artículos', 'Ingresó a Todos los artículos'],
            'sb-admin/agregar-articulos'         => ['Blog', 'Agregar artículo', 'Ingresó a Agregar artículo'],
            'sb-admin/caja'                      => ['Caja chica', 'Caja chica', 'Ingresó a Caja chica'],
            'sb-admin/usuarios'                  => ['Usuarios', 'Todos los usuarios', 'Ingresó a Todos los usuarios'],
            'sb-admin/registros-usuarios'        => ['Usuarios', 'Registros de usuarios', 'Ingresó a Registros de usuarios'],
            'sb-admin/codificar'                 => ['Herramientas', 'Codificar base64', 'Ingresó a Codificar base64'],
            'sb-admin/perfil/accesos-rapidos'    => ['Perfil', 'Accesos frecuentes', 'Actualizó sus accesos frecuentes'],
        ];

        if (isset($paginas[$path])) {
            $p = $paginas[$path];
            return [
                'modulo'       => $p[0],
                'pantalla'     => $p[1],
                'descripcion'  => $p[2],
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }

        // 10. Rutas dinámicas con ID y enlaces directos
        if (preg_match('#^sb-admin/edita-cotizacion/(\d+)$#', $path, $m)) {
            $link = self::datosEnlaceCotizacion((int) $m[1]);
            return [
                'modulo'       => 'Cotizador',
                'pantalla'     => 'Editar cotización',
                'descripcion'  => 'Ingresó a editar cotización',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/seguimineto/(\d+)$#', $path, $m)) {
            $link = self::datosEnlaceSeguimiento((int) $m[1]);
            return [
                'modulo'       => 'Seguimiento',
                'pantalla'     => 'Seguimiento de venta',
                'descripcion'  => 'Ingresó a seguimiento',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/orden-taller/(\d+)$#', $path, $m)) {
            $link = self::datosEnlaceOrdenTaller((int) $m[1]);
            return [
                'modulo'       => 'Taller',
                'pantalla'     => 'Orden de Taller',
                'descripcion'  => 'Ingresó a Orden de Taller',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/entrega/(\d+)/actualizar$#', $path, $m)) {
            $link = self::datosEnlaceFormatoEntrega((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => 'Modificó formato de entrega',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/entrega/(\d+)/(?:ver|pdf)$#', $path, $m)) {
            $link = self::datosEnlaceFormatoEntrega((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => 'Consultó formato de entrega',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/entrega/(\d+)/eliminar$#', $path, $m)) {
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => 'Eliminó formato de entrega #' . (int) $m[1],
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }
        if (preg_match('#^sb-admin/formatos/entrega/(\d+)$#', $path, $m)) {
            if ($idFe > 0) {
                $linkFe = self::datosEnlaceFormatoEntrega($idFe);
                return [
                    'modulo'       => 'Formatos',
                    'pantalla'     => 'Formato de Entrega',
                    'descripcion'  => 'Ingresó a editar formato de entrega',
                    'enlace_texto' => $linkFe['texto'],
                    'enlace_url'   => $linkFe['url'],
                ];
            }
            $link = self::datosEnlaceCotizacion((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Formato de Entrega',
                'descripcion'  => 'Ingresó a Formato de Entrega de cotización',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/cambio-producto/(\d+)/actualizar$#', $path, $m)) {
            $link = self::datosEnlaceFormatoCambio((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => 'Modificó formato de cambio',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/cambio-producto/(\d+)/(?:ver|pdf)$#', $path, $m)) {
            $link = self::datosEnlaceFormatoCambio((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => 'Consultó formato de cambio',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/formatos/cambio-producto/(\d+)/eliminar$#', $path, $m)) {
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => 'Eliminó formato de cambio #' . (int) $m[1],
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }
        if (preg_match('#^sb-admin/formatos/cambio-producto/(\d+)$#', $path, $m)) {
            if ($idFc > 0) {
                $linkFc = self::datosEnlaceFormatoCambio($idFc);
                return [
                    'modulo'       => 'Formatos',
                    'pantalla'     => 'Cambio de Producto',
                    'descripcion'  => 'Ingresó a editar formato de cambio',
                    'enlace_texto' => $linkFc['texto'],
                    'enlace_url'   => $linkFc['url'],
                ];
            }
            $link = self::datosEnlaceCotizacion((int) $m[1]);
            return [
                'modulo'       => 'Formatos',
                'pantalla'     => 'Cambio de Producto',
                'descripcion'  => 'Ingresó a Cambio de Producto de cotización',
                'enlace_texto' => $link['texto'],
                'enlace_url'   => $link['url'],
            ];
        }
        if (preg_match('#^sb-admin/horas-extra/(\d+)/ver$#', $path, $m)) {
            return [
                'modulo'       => 'Horas extra',
                'pantalla'     => 'Solicitud #' . $m[1],
                'descripcion'  => 'Ingresó a Solicitud de Horas extra #' . $m[1],
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }
        if (preg_match('#^sb-admin/horas-extra/(\d+)/cancelar$#', $path, $m)) {
            return [
                'modulo'       => 'Horas extra',
                'pantalla'     => 'Horas extra',
                'descripcion'  => 'Canceló solicitud de Horas extra #' . $m[1],
                'enlace_texto' => null,
                'enlace_url'   => null,
            ];
        }

        // 11. Respaldo genérico sin URLs
        $limpio = preg_replace('#^sb-admin/#', '', $path);
        $limpio = trim(preg_replace('/[^A-Za-z0-9\s]+/', ' ', str_replace(['-', '_'], ' ', $limpio)));
        if ($limpio === '') {
            $limpio = 'Inicio';
        }
        $etiqueta = ucfirst(strtolower($limpio));

        return [
            'modulo'       => 'Sistema',
            'pantalla'     => $etiqueta,
            'descripcion'  => $metodo === 'GET'
                ? 'Ingresó a ' . $etiqueta
                : 'Realizó una acción en ' . $etiqueta,
            'enlace_texto' => null,
            'enlace_url'   => null,
        ];
    }
}
