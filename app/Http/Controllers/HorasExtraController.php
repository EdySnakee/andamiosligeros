<?php

namespace App\Http\Controllers;

use App\HoraExtraEvento;
use App\HoraExtraSolicitud;
use App\User;
use App\Utilidades;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use PDF;

class HorasExtraController extends Controller
{
    /**
     * Caché por petición del estado de las tablas del módulo.
     *
     * @var bool|null
     */
    protected static $tablasVerificadas = null;

    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Verifica si las tablas del módulo existen en la base de datos;
     * si aún no existen, intenta crearlas automáticamente de forma segura.
     *
     * @return bool
     */
    protected function moduloInstalado()
    {
        if (self::$tablasVerificadas === true) {
            return true;
        }

        try {
            $existen = Schema::hasTable('horas_extra_solicitudes')
                && Schema::hasTable('horas_extra_eventos');

            if (!$existen) {
                $this->asegurarTablas();
                $existen = Schema::hasTable('horas_extra_solicitudes')
                    && Schema::hasTable('horas_extra_eventos');
            }

            self::$tablasVerificadas = (bool) $existen;
            return self::$tablasVerificadas;
        } catch (\Throwable $e) {
            return false;
        }
    }

    /**
     * Crea automáticamente las tablas del módulo si el usuario MySQL tiene permisos DDL.
     *
     * @return void
     */
    protected function asegurarTablas()
    {
        try {
            DB::statement("CREATE TABLE IF NOT EXISTS `horas_extra_solicitudes` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `user_id` int(10) unsigned NOT NULL,
                `fecha` date NOT NULL,
                `hora_inicio_prevista` time DEFAULT NULL,
                `horas_estimadas` decimal(5,2) NOT NULL,
                `horas_autorizadas` decimal(5,2) DEFAULT NULL,
                `modalidad` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                `motivo` text COLLATE utf8mb4_unicode_ci NOT NULL,
                `entregable` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `referencia_tipo` varchar(30) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `referencia_folio` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `estatus` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'programada',
                `aprobada_por` int(10) unsigned DEFAULT NULL,
                `aprobada_at` datetime DEFAULT NULL,
                `comentario_aprobacion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `inicio_at` datetime DEFAULT NULL,
                `fin_at` datetime DEFAULT NULL,
                `cerrada_por` int(10) unsigned DEFAULT NULL,
                `resumen_trabajo` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `evidencias` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `minutos_declarados` int(11) DEFAULT NULL,
                `minutos_activos` int(11) DEFAULT NULL,
                `minutos_validados` int(11) DEFAULT NULL,
                `validada_por` int(10) unsigned DEFAULT NULL,
                `validada_at` datetime DEFAULT NULL,
                `comentario_validacion` text COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `acepta_aviso` tinyint(1) NOT NULL DEFAULT '0',
                `aviso_version` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `aviso_aceptado_at` datetime DEFAULT NULL,
                `created_at` timestamp NULL DEFAULT NULL,
                `updated_at` timestamp NULL DEFAULT NULL,
                PRIMARY KEY (`id`),
                KEY `horas_extra_solicitudes_user_id_index` (`user_id`),
                KEY `horas_extra_solicitudes_fecha_index` (`fecha`),
                KEY `horas_extra_solicitudes_estatus_index` (`estatus`),
                KEY `idx_he_sol_user_estatus` (`user_id`,`estatus`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");

            DB::statement("CREATE TABLE IF NOT EXISTS `horas_extra_eventos` (
                `id` int(10) unsigned NOT NULL AUTO_INCREMENT,
                `solicitud_id` int(10) unsigned NOT NULL,
                `user_id` int(10) unsigned NOT NULL,
                `tipo` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL,
                `ruta` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `ip` varchar(64) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `user_agent` varchar(255) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `latitud` decimal(10,7) DEFAULT NULL,
                `longitud` decimal(10,7) DEFAULT NULL,
                `precision_m` int(11) DEFAULT NULL,
                `ubicacion_estado` varchar(20) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
                `created_at` datetime NOT NULL,
                PRIMARY KEY (`id`),
                KEY `horas_extra_eventos_solicitud_id_index` (`solicitud_id`),
                KEY `horas_extra_eventos_user_id_index` (`user_id`),
                KEY `horas_extra_eventos_created_at_index` (`created_at`),
                KEY `idx_he_ev_sol_tipo_fecha` (`solicitud_id`,`tipo`,`created_at`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci");
        } catch (\Throwable $e) {
            // Si el usuario MySQL no tiene permisos CREATE, moduloInstalado() devolverá false
        }
    }

    /**
     * Respuesta estándar cuando el módulo aún no tiene sus tablas migradas.
     */
    protected function respuestaPendiente(Request $request)
    {
        $msg = 'El módulo de Horas Extra aún no está instalado en la base de datos. Ejecuta la migración correspondiente.';
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $msg], 503);
        }

        return redirect()->route('app_horas_extra')->with('error', $msg);
    }

    /**
     * Normaliza los filtros del historial/PDF respetando el rol del usuario.
     *
     * @param Request $request
     * @param User $user
     * @return array
     */
    protected function obtenerFiltros(Request $request, User $user)
    {
        $desdeDefault = Carbon::now()->startOfMonth()->toDateString();
        $hastaDefault = Carbon::today()->toDateString();

        $desde = $request->input('desde', $desdeDefault);
        $hasta = $request->input('hasta', $hastaDefault);

        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $desde)) {
            $desde = $desdeDefault;
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', (string) $hasta)) {
            $hasta = $hastaDefault;
        }
        if ($desde > $hasta) {
            $tmp = $desde;
            $desde = $hasta;
            $hasta = $tmp;
        }

        $estatusPermitidos = array_keys(HoraExtraSolicitud::etiquetasEstatus());
        $estatus = (string) $request->input('estatus', '');
        if ($estatus !== '' && !in_array($estatus, $estatusPermitidos)) {
            $estatus = '';
        }

        $usuarioId = $user->isAdmin()
            ? ($request->input('usuario_id') !== null && $request->input('usuario_id') !== '' ? (int) $request->input('usuario_id') : '')
            : (int) $user->id;

        return [
            'desde'      => $desde,
            'hasta'      => $hasta,
            'estatus'    => $estatus,
            'usuario_id' => $usuarioId,
        ];
    }

    /**
     * Construye el query de historial filtrado.
     *
     * @param array $filtros
     * @return \Illuminate\Database\Eloquent\Builder
     */
    protected function consultaHistorial(array $filtros)
    {
        $query = HoraExtraSolicitud::with(['usuario', 'aprobador', 'validador', 'eventos'])
            ->whereBetween('fecha', [$filtros['desde'], $filtros['hasta']]);

        if (!empty($filtros['usuario_id'])) {
            $query->where('user_id', (int) $filtros['usuario_id']);
        }
        if (!empty($filtros['estatus'])) {
            $query->where('estatus', $filtros['estatus']);
        }

        return $query->orderBy('fecha', 'desc')->orderBy('id', 'desc');
    }

    /**
     * Panel principal del módulo de Horas Extra.
     */
    public function index(Request $request)
    {
        $user = Auth::user();
        $esAdmin = $user->isAdmin();
        $filtros = $this->obtenerFiltros($request, $user);

        if (!$this->moduloInstalado()) {
            return view('app_redes.modulos.horas_extra.index', [
                'moduloPendiente'  => true,
                'esAdmin'          => $esAdmin,
                'filtros'          => $filtros,
                'misSolicitudes'   => collect([]),
                'enCurso'          => collect([]),
                'porValidar'       => collect([]),
                'historial'        => collect([]),
                'usuariosActivos'  => collect([]),
                'hoy'              => Carbon::today()->toDateString(),
                'avisoVersion'     => config('horas_extra.aviso_version'),
                'sesionActivaMia'  => null,
            ]);
        }

        $misSolicitudes = HoraExtraSolicitud::with(['validador', 'eventos'])
            ->where('user_id', $user->id)
            ->orderBy('id', 'desc')
            ->limit(100)
            ->get();

        $sesionActivaMia = null;
        foreach ($misSolicitudes as $s) {
            if ($s->estatus === HoraExtraSolicitud::ESTATUS_EN_CURSO) {
                $sesionActivaMia = $s;
                break;
            }
        }

        $enCurso = collect([]);
        $porValidar = collect([]);
        $historial = collect([]);
        $usuariosActivos = collect([]);

        if ($esAdmin) {
            $enCurso = HoraExtraSolicitud::with(['usuario', 'eventos'])
                ->where('estatus', HoraExtraSolicitud::ESTATUS_EN_CURSO)
                ->orderBy('inicio_at', 'asc')
                ->get();

            $porValidar = HoraExtraSolicitud::with(['usuario', 'eventos'])
                ->where('estatus', HoraExtraSolicitud::ESTATUS_POR_VALIDAR)
                ->where('user_id', '!=', $user->id)
                ->orderBy('fin_at', 'asc')
                ->get();

            $historial = $this->consultaHistorial($filtros)->limit(300)->get();
            $usuariosActivos = User::where('estatus', 1)->orderBy('name', 'asc')->get();
        }

        return view('app_redes.modulos.horas_extra.index', [
            'moduloPendiente' => false,
            'esAdmin'         => $esAdmin,
            'filtros'         => $filtros,
            'misSolicitudes'  => $misSolicitudes,
            'enCurso'         => $enCurso,
            'porValidar'      => $porValidar,
            'historial'       => $historial,
            'usuariosActivos' => $usuariosActivos,
            'hoy'             => Carbon::today()->toDateString(),
            'avisoVersion'    => config('horas_extra.aviso_version'),
            'sesionActivaMia' => $sesionActivaMia,
        ]);
    }

    /**
     * Registra una nueva solicitud de horas extra.
     */
    public function guardar(Request $request)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $mensajes = [
            'fecha.required'                   => 'La fecha es obligatoria.',
            'fecha.date'                       => 'Introduce una fecha válida.',
            'fecha.after'                      => 'La fecha no puede ser anterior al día de hoy.',
            'hora_inicio_prevista.date_format' => 'La hora prevista debe tener formato HH:MM.',
            'horas_estimadas.required'         => 'Las horas estimadas son obligatorias.',
            'horas_estimadas.numeric'          => 'Las horas estimadas deben ser numéricas.',
            'horas_estimadas.min'              => 'El mínimo por solicitud es 0.5 horas (30 min).',
            'horas_estimadas.max'              => 'El máximo por solicitud es 12 horas.',
            'modalidad.required'               => 'Selecciona una modalidad de trabajo.',
            'modalidad.in'                     => 'Modalidad inválida.',
            'motivo.required'                  => 'Describe el motivo de las horas extra.',
            'motivo.min'                       => 'El motivo debe tener al menos 10 caracteres.',
        ];

        $this->validate($request, [
            'fecha'                => 'required|date|after:yesterday',
            'hora_inicio_prevista' => 'date_format:H:i',
            'horas_estimadas'      => 'required|numeric|min:0.5|max:12',
            'modalidad'            => 'required|in:oficina,remoto',
            'motivo'               => 'required|string|min:10|max:1000',
        ], $mensajes);

        $user = Auth::user();
        $fechaYmd = Carbon::parse($request->input('fecha'))->toDateString();
        $horasEstimadas = (float) $request->input('horas_estimadas');

        HoraExtraSolicitud::create([
            'user_id'              => $user->id,
            'fecha'                => $fechaYmd,
            'hora_inicio_prevista' => $request->input('hora_inicio_prevista') ?: null,
            'horas_estimadas'      => $horasEstimadas,
            'modalidad'            => $request->input('modalidad'),
            'motivo'               => trim($request->input('motivo')),
            'entregable'           => null,
            'estatus'              => HoraExtraSolicitud::ESTATUS_PROGRAMADA,
        ]);

        $msgExito = $fechaYmd === Carbon::today()->toDateString()
            ? 'Registro guardado. Cuando comiences tus horas extra hoy, presiona «Iniciar» en tu fila.'
            : 'Registro de horas extra programado para el ' . $fechaYmd . '.';

        $redirect = redirect()->route('app_horas_extra')
            ->with('success', $msgExito);

        $lft = HoraExtraSolicitud::resumenLftUsuario($user->id, $fechaYmd);
        $limDia = (float) config('horas_extra.limite_horas_dia', 3);
        $limSem = (float) config('horas_extra.limite_horas_semana', 9);
        $avisos = [];
        if (($lft['horas_dia'] + $horasEstimadas) > $limDia) {
            $avisos[] = 'Con esta solicitud superarías ' . $limDia . ' h en el día (referencia LFT).';
        }
        if (($lft['horas_semana'] + $horasEstimadas) > $limSem) {
            $avisos[] = 'Con esta solicitud superarías ' . $limSem . ' h en la semana ISO (referencia LFT).';
        }
        if (!empty($avisos)) {
            $redirect->with('warning', implode(' ', $avisos));
        }

        return $redirect;
    }

    /**
     * Permite al solicitante cancelar una solicitud aún no iniciada.
     */
    public function cancelar(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::findOrFail((int) $id);
        $user = Auth::user();

        if (!$solicitud->esPropia($user)) {
            abort(403, 'Solo el solicitante puede cancelar su solicitud.');
        }

        if (!in_array($solicitud->estatus, [
            HoraExtraSolicitud::ESTATUS_PROGRAMADA,
            HoraExtraSolicitud::ESTATUS_APROBADA,
            HoraExtraSolicitud::ESTATUS_SOLICITADA,
        ])) {
            return redirect()->route('app_horas_extra')
                ->with('error', 'Solo se pueden cancelar solicitudes programadas que aún no han iniciado.');
        }

        $solicitud->estatus = HoraExtraSolicitud::ESTATUS_CANCELADA;
        $solicitud->save();

        return redirect()->route('app_horas_extra')
            ->with('success', 'Solicitud #' . $solicitud->id . ' cancelada.');
    }

    /**
     * Inicia una sesión de horas extra programada para hoy (AJAX JSON).
     */
    public function iniciar(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::find((int) $id);
        if (!$solicitud) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.'], 404);
        }

        $user = Auth::user();
        if (!$solicitud->esPropia($user)) {
            return response()->json(['success' => false, 'message' => 'Esta solicitud pertenece a otro usuario.'], 403);
        }

        if (!in_array($solicitud->estatus, [
            HoraExtraSolicitud::ESTATUS_PROGRAMADA,
            HoraExtraSolicitud::ESTATUS_APROBADA,
            HoraExtraSolicitud::ESTATUS_SOLICITADA,
        ])) {
            return response()->json(['success' => false, 'message' => 'La solicitud no está disponible para iniciar.'], 422);
        }

        $hoy = Carbon::today()->toDateString();
        if ($solicitud->fechaYmd() !== $hoy) {
            return response()->json([
                'success' => false,
                'message' => 'Solo puedes iniciar esta sesión en su fecha programada (' . $solicitud->fechaYmd() . ').',
            ], 422);
        }

        $otraActiva = HoraExtraSolicitud::where('user_id', $user->id)
            ->where('estatus', HoraExtraSolicitud::ESTATUS_EN_CURSO)
            ->where('id', '!=', $solicitud->id)
            ->exists();

        if ($otraActiva) {
            return response()->json(['success' => false, 'message' => 'Ya tienes otra sesión de horas extra en curso. Finalízala primero.'], 422);
        }

        $rules = [
            'acepta_aviso'     => 'required|accepted',
            'ubicacion_estado' => 'required|in:concedida,denegada,no_disponible',
        ];
        if ($request->input('ubicacion_estado') === HoraExtraEvento::UBICACION_CONCEDIDA) {
            $rules['latitud'] = 'required|numeric|between:-90,90';
            $rules['longitud'] = 'required|numeric|between:-180,180';
            $rules['precision_m'] = 'integer|min:0|max:1000000';
        }

        $this->validate($request, $rules, [
            'acepta_aviso.required'     => 'Debes aceptar el aviso de privacidad para iniciar.',
            'acepta_aviso.accepted'     => 'Debes aceptar el aviso de privacidad para iniciar.',
            'ubicacion_estado.required' => 'No se recibió el estado de ubicación.',
        ]);

        $ahora = Carbon::now();
        $ubicacionEstado = $request->input('ubicacion_estado');

        DB::transaction(function () use ($solicitud, $request, $ahora, $ubicacionEstado) {
            $solicitud->estatus = HoraExtraSolicitud::ESTATUS_EN_CURSO;
            $solicitud->inicio_at = $ahora;
            $solicitud->acepta_aviso = true;
            $solicitud->aviso_version = config('horas_extra.aviso_version', '2026-11');
            $solicitud->aviso_aceptado_at = $ahora;
            $solicitud->save();

            HoraExtraEvento::registrar($solicitud, HoraExtraEvento::TIPO_INICIO, $request, [
                'ruta'             => '/' . ltrim($request->path(), '/'),
                'ubicacion_estado' => $ubicacionEstado,
                'latitud'          => $ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA ? (float) $request->input('latitud') : null,
                'longitud'         => $ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA ? (float) $request->input('longitud') : null,
                'precision_m'      => ($ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA && $request->input('precision_m') !== null && $request->input('precision_m') !== '')
                    ? (int) $request->input('precision_m')
                    : null,
                'created_at'       => $ahora,
            ]);
        });

        return response()->json([
            'success' => true,
            'message' => 'Sesión de horas extra iniciada correctamente.',
        ]);
    }

    /**
     * Finaliza una sesión en curso guardando resumen, evidencias y ubicación final (AJAX FormData).
     */
    public function finalizar(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::find((int) $id);
        if (!$solicitud) {
            return response()->json(['success' => false, 'message' => 'Solicitud no encontrada.'], 404);
        }

        $user = Auth::user();
        if (!$solicitud->esPropia($user)) {
            return response()->json(['success' => false, 'message' => 'Esta solicitud pertenece a otro usuario.'], 403);
        }

        if ($solicitud->estatus !== HoraExtraSolicitud::ESTATUS_EN_CURSO) {
            return response()->json(['success' => false, 'message' => 'Esta sesión no se encuentra en curso.'], 422);
        }

        $rules = [
            'resumen_trabajo'  => 'required|string|min:20|max:3000',
            'ubicacion_estado' => 'required|in:concedida,denegada,no_disponible',
        ];
        if ($request->input('ubicacion_estado') === HoraExtraEvento::UBICACION_CONCEDIDA) {
            $rules['latitud'] = 'required|numeric|between:-90,90';
            $rules['longitud'] = 'required|numeric|between:-180,180';
            $rules['precision_m'] = 'integer|min:0|max:1000000';
        }

        $this->validate($request, $rules, [
            'resumen_trabajo.required' => 'Describe el trabajo realizado antes de finalizar.',
            'resumen_trabajo.min'      => 'El resumen debe tener al menos 20 caracteres.',
        ]);

        // Validar archivos adjuntos opcionales (máx. 5, JPG/PNG/PDF, 5 MB)
        $maxArchivos = (int) config('horas_extra.evidencias_max', 5);
        $maxKb = (int) config('horas_extra.evidencia_max_kb', 5120);
        $archivosRecibidos = $request->file('evidencias', []);
        if (!is_array($archivosRecibidos)) {
            $archivosRecibidos = $archivosRecibidos ? [$archivosRecibidos] : [];
        }
        $archivosValidos = array_values(array_filter($archivosRecibidos, function ($f) {
            return $f !== null;
        }));

        if (count($archivosValidos) > $maxArchivos) {
            return response()->json([
                'success' => false,
                'message' => 'Puedes adjuntar como máximo ' . $maxArchivos . ' archivos de evidencia.',
            ], 422);
        }

        if (count($archivosValidos) > 0) {
            $valArchivos = Validator::make(
                ['evidencias' => $archivosValidos],
                ['evidencias.*' => 'mimes:jpg,jpeg,png,pdf|max:' . $maxKb],
                [
                    'evidencias.*.mimes' => 'Cada evidencia debe ser JPG, PNG o PDF.',
                    'evidencias.*.max'   => 'Cada archivo no puede superar ' . ($maxKb / 1024) . ' MB.',
                ]
            );
            if ($valArchivos->fails()) {
                return response()->json([
                    'success' => false,
                    'message' => $valArchivos->errors()->first(),
                ], 422);
            }
        }

        $evidenciasGuardadas = [];
        $dirDestino = storage_path('app/horas_extra/' . $solicitud->id);
        if (count($archivosValidos) > 0 && !is_dir($dirDestino)) {
            @mkdir($dirDestino, 0755, true);
        }

        foreach ($archivosValidos as $archivo) {
            if (!$archivo->isValid()) {
                continue;
            }
            $ext = strtolower($archivo->getClientOriginalExtension() ?: 'bin');
            $nombreOriginal = basename((string) $archivo->getClientOriginalName());
            $nombreOriginal = preg_replace('/[^\w\.\-\s]/u', '_', $nombreOriginal);
            $nombreSeguro = uniqid('ev_', true) . '.' . $ext;
            $mime = $archivo->getMimeType();
            $kb = (int) max(1, ceil($archivo->getSize() / 1024));

            $archivo->move($dirDestino, $nombreSeguro);

            $evidenciasGuardadas[] = [
                'nombre' => $nombreOriginal ?: $nombreSeguro,
                'ruta'   => $solicitud->id . '/' . $nombreSeguro,
                'mime'   => $mime,
                'kb'     => $kb,
            ];
        }

        $ahora = Carbon::now();
        $ubicacionEstado = $request->input('ubicacion_estado');

        DB::transaction(function () use ($solicitud, $request, $ahora, $ubicacionEstado, $evidenciasGuardadas) {
            HoraExtraEvento::registrar($solicitud, HoraExtraEvento::TIPO_FIN, $request, [
                'ruta'             => '/' . ltrim($request->path(), '/'),
                'ubicacion_estado' => $ubicacionEstado,
                'latitud'          => $ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA ? (float) $request->input('latitud') : null,
                'longitud'         => $ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA ? (float) $request->input('longitud') : null,
                'precision_m'      => ($ubicacionEstado === HoraExtraEvento::UBICACION_CONCEDIDA && $request->input('precision_m') !== null && $request->input('precision_m') !== '')
                    ? (int) $request->input('precision_m')
                    : null,
                'created_at'       => $ahora,
            ]);

            $declarados = $solicitud->inicio_at ? max(0, (int) $solicitud->inicio_at->diffInMinutes($ahora)) : 0;

            $solicitud->fin_at = $ahora;
            $solicitud->resumen_trabajo = trim($request->input('resumen_trabajo'));
            $solicitud->evidencias = $evidenciasGuardadas;
            $solicitud->minutos_declarados = $declarados;
            $solicitud->minutos_activos = $solicitud->calcularMinutosActivos();
            $solicitud->estatus = HoraExtraSolicitud::ESTATUS_POR_VALIDAR;
            $solicitud->save();
        });

        return response()->json([
            'success' => true,
            'message' => 'Sesión finalizada y enviada para validación del administrador.',
        ]);
    }

    /**
     * Recibe latidos periódicos mientras la pestaña está visible y activa (AJAX JSON).
     */
    public function latido(Request $request)
    {
        if (!$this->moduloInstalado()) {
            return response()->json(['activa' => false]);
        }

        $userId = (int) Auth::id();
        $solicitud = HoraExtraSolicitud::where('user_id', $userId)
            ->where('estatus', HoraExtraSolicitud::ESTATUS_EN_CURSO)
            ->first();

        if (!$solicitud) {
            return response()->json(['activa' => false]);
        }

        $dedupeSeg = (int) config('horas_extra.dedupe_latido_seg', 40);
        $desde = Carbon::now()->subSeconds($dedupeSeg);
        $reciente = HoraExtraEvento::where('solicitud_id', $solicitud->id)
            ->where('tipo', HoraExtraEvento::TIPO_LATIDO)
            ->where('created_at', '>=', $desde)
            ->exists();

        if (!$reciente) {
            $ruta = substr((string) $request->input('ruta', '/'), 0, 255);
            HoraExtraEvento::registrar($solicitud, HoraExtraEvento::TIPO_LATIDO, $request, [
                'user_id' => $userId,
                'ruta'    => $ruta ?: '/',
            ]);
        }

        return response()->json([
            'activa'  => true,
            'minutos' => $solicitud->minutosTranscurridos(),
        ]);
    }

    /**
     * Vista detallada de auditoría, actividad, alertas y validación de una solicitud.
     */
    public function ver(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::with(['usuario', 'aprobador', 'validador', 'cerrador', 'eventos'])
            ->findOrFail((int) $id);

        $user = Auth::user();
        if (!$solicitud->esPropia($user) && !$user->isAdmin()) {
            abort(403, 'No tienes permiso para ver esta solicitud.');
        }

        $esAdmin = $user->isAdmin();

        $eventosClave = $solicitud->eventos->filter(function ($ev) {
            return in_array($ev->tipo, [
                HoraExtraEvento::TIPO_INICIO,
                HoraExtraEvento::TIPO_FIN,
                HoraExtraEvento::TIPO_CIERRE_ADMIN,
            ]);
        })->values();

        $lineaActividad = [];
        $totalLatidos = 0;
        $totalAcciones = 0;

        if ($esAdmin) {
            $eventosLimpios = [];
            $vistosExactos = [];
            $minutosConEvento = [];

            foreach ($solicitud->eventos as $ev) {
                $rutaStr = (string) ($ev->ruta ?: '');
                if ($ev->tipo === HoraExtraEvento::TIPO_ACCION
                    && preg_match('#/sb-admin/horas-extra/\d+/(iniciar|finalizar)(\?|$)#i', $rutaStr)
                ) {
                    continue;
                }

                $tsExacto = $ev->created_at ? $ev->created_at->format('Y-m-d H:i:s') : '';
                $firma = $ev->tipo . '|' . $rutaStr . '|' . $tsExacto;
                if (isset($vistosExactos[$firma])) {
                    continue;
                }
                $vistosExactos[$firma] = true;

                if ($ev->tipo !== HoraExtraEvento::TIPO_LATIDO && $ev->created_at) {
                    $minutosConEvento[$ev->created_at->format('Y-m-d H:i')] = true;
                }

                $eventosLimpios[] = $ev;
            }

            if (!empty($eventosLimpios)) {
                HoraExtraEvento::precargarParaEventos($eventosLimpios);
            }

            foreach ($eventosLimpios as $ev) {
                if ($ev->tipo === HoraExtraEvento::TIPO_LATIDO) {
                    if ($ev->created_at && isset($minutosConEvento[$ev->created_at->format('Y-m-d H:i')])) {
                        continue;
                    }
                    $totalLatidos++;
                    $desc = $ev->describirActividad();
                    $horaFmt = $ev->created_at ? $ev->created_at->format('h:i A') : '';
                    $ultimoIdx = count($lineaActividad) - 1;

                    if ($ultimoIdx >= 0
                        && $lineaActividad[$ultimoIdx]['tipo'] === HoraExtraEvento::TIPO_LATIDO
                        && $lineaActividad[$ultimoIdx]['modulo'] === $desc['modulo']
                        && $lineaActividad[$ultimoIdx]['descripcion'] === $desc['descripcion']
                    ) {
                        if ($horaFmt !== '' && $horaFmt !== $lineaActividad[$ultimoIdx]['hora_inicio']) {
                            $lineaActividad[$ultimoIdx]['hora'] = $lineaActividad[$ultimoIdx]['hora_inicio'] . ' – ' . $horaFmt;
                        }
                        continue;
                    }

                    $lineaActividad[] = [
                        'hora'         => $horaFmt,
                        'hora_inicio'  => $horaFmt,
                        'modulo'       => $desc['modulo'],
                        'descripcion'  => $desc['descripcion'],
                        'enlace_texto' => $desc['enlace_texto'],
                        'enlace_url'   => $desc['enlace_url'],
                        'es_hito'      => false,
                        'tipo'         => $ev->tipo,
                    ];
                    continue;
                }

                if ($ev->tipo === HoraExtraEvento::TIPO_ACCION) {
                    $totalAcciones++;
                }

                $desc = $ev->describirActividad();
                $horaFmt = $ev->created_at ? $ev->created_at->format('h:i:s A') : '';
                $lineaActividad[] = [
                    'hora'         => $horaFmt,
                    'hora_inicio'  => $horaFmt,
                    'modulo'       => $desc['modulo'],
                    'descripcion'  => $desc['descripcion'],
                    'enlace_texto' => $desc['enlace_texto'],
                    'enlace_url'   => $desc['enlace_url'],
                    'es_hito'      => $desc['es_hito'],
                    'tipo'         => $ev->tipo,
                ];
            }
        }

        $declaradosMin = $solicitud->minutos_declarados !== null
            ? (int) $solicitud->minutos_declarados
            : $solicitud->minutosTranscurridos();

        $activosMin = ($esAdmin)
            ? (($solicitud->fin_at && $solicitud->minutos_activos !== null)
                ? (int) $solicitud->minutos_activos
                : $solicitud->calcularMinutosActivos())
            : 0;

        return view('app_redes.modulos.horas_extra.ver', [
            'solicitud'      => $solicitud,
            'eventosClave'   => $eventosClave,
            'lineaActividad' => $lineaActividad,
            'totalLatidos'   => $totalLatidos,
            'totalAcciones'  => $totalAcciones,
            'declaradosMin'  => $declaradosMin,
            'activosMin'     => $activosMin,
            'respaldoPct'    => $esAdmin ? $solicitud->porcentajeRespaldo() : 0,
            'huecos'         => $esAdmin ? $solicitud->huecos() : [],
            'distanciaM'     => $solicitud->distanciaInicioFinM(),
            'alertas'        => $esAdmin ? $solicitud->alertas() : [],
            'evidencias'     => is_array($solicitud->evidencias) ? $solicitud->evidencias : [],
            'puedeGestionar' => $solicitud->puedeGestionar($user),
            'esAdmin'        => $esAdmin,
        ]);
    }

    /**
     * Valida o rechaza las horas trabajadas al cierre de sesión (solo admin distinto al usuario).
     */
    public function validar(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::findOrFail((int) $id);
        $user = Auth::user();

        if (!$solicitud->puedeGestionar($user)) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->with('error', 'No puedes validar tus propias horas extra.');
        }

        if ($solicitud->estatus !== HoraExtraSolicitud::ESTATUS_POR_VALIDAR) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->with('error', 'Esta solicitud no está pendiente de validación.');
        }

        $this->validate($request, [
            'decision'              => 'required|in:validar,rechazar',
            'comentario_validacion' => 'string|max:1000',
        ]);

        $decision = $request->input('decision');
        $comentario = trim((string) $request->input('comentario_validacion', ''));

        if ($decision === 'rechazar') {
            if (mb_strlen($comentario) < 5) {
                return redirect()->route('app_horas_extra_ver', $solicitud->id)
                    ->withInput()
                    ->with('error', 'Debes escribir un comentario (mínimo 5 caracteres) al rechazar las horas.');
            }

            $solicitud->estatus = HoraExtraSolicitud::ESTATUS_RECHAZADA;
            $solicitud->minutos_validados = 0;
            $solicitud->validada_por = $user->id;
            $solicitud->validada_at = Carbon::now();
            $solicitud->comentario_validacion = $comentario;
            $solicitud->save();

            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->with('success', 'Sesión rechazada en validación.');
        }

        $declarados = (int) ($solicitud->minutos_declarados ?: 0);

        $this->validate($request, [
            'val_horas'   => 'required|integer|min:0|max:24',
            'val_minutos' => 'required|integer|min:0|max:59',
        ], [
            'val_horas.required'   => 'Indica las horas a validar.',
            'val_horas.integer'    => 'Las horas deben ser un número entero.',
            'val_horas.min'        => 'Las horas no pueden ser negativas.',
            'val_horas.max'        => 'Las horas no pueden superar 24.',
            'val_minutos.required' => 'Indica los minutos a validar.',
            'val_minutos.integer'  => 'Los minutos deben ser un número entero.',
            'val_minutos.min'      => 'Los minutos no pueden ser negativos.',
            'val_minutos.max'      => 'Los minutos deben estar entre 0 y 59.',
        ]);

        $minutosValidados = ((int) $request->input('val_horas') * 60) + (int) $request->input('val_minutos');

        if ($minutosValidados > $declarados) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->withInput()
                ->with('error', 'No puedes validar más tiempo del declarado (' . HoraExtraSolicitud::formatearMinutos($declarados) . ').');
        }

        if ($minutosValidados !== $declarados && mb_strlen($comentario) < 5) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->withInput()
                ->with('error', 'Como el tiempo validado difiere de lo declarado, agrega un comentario explicativo (mínimo 5 caracteres).');
        }

        $solicitud->estatus = HoraExtraSolicitud::ESTATUS_VALIDADA;
        $solicitud->minutos_validados = $minutosValidados;
        $solicitud->validada_por = $user->id;
        $solicitud->validada_at = Carbon::now();
        $solicitud->comentario_validacion = $comentario ?: null;
        $solicitud->save();

        return redirect()->route('app_horas_extra_ver', $solicitud->id)
            ->with('success', 'Horas extra validadas: ' . HoraExtraSolicitud::formatearMinutos($minutosValidados) . '.');
    }

    /**
     * Cierra administrativamente una sesión que el usuario dejó abierta.
     */
    public function cerrar(Request $request, $id)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $solicitud = HoraExtraSolicitud::findOrFail((int) $id);
        $user = Auth::user();

        if (!$solicitud->puedeGestionar($user)) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->with('error', 'No tienes permiso para cerrar esta sesión.');
        }

        if ($solicitud->estatus !== HoraExtraSolicitud::ESTATUS_EN_CURSO) {
            return redirect()->route('app_horas_extra_ver', $solicitud->id)
                ->with('error', 'La sesión no está en curso.');
        }

        $ultimo = HoraExtraEvento::where('solicitud_id', $solicitud->id)
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->first();

        $finAt = ($ultimo && $ultimo->created_at) ? $ultimo->created_at : ($solicitud->inicio_at ?: Carbon::now());

        DB::transaction(function () use ($solicitud, $request, $user, $finAt) {
            HoraExtraEvento::registrar($solicitud, HoraExtraEvento::TIPO_CIERRE_ADMIN, $request, [
                'user_id'    => $user->id,
                'ruta'       => '/' . ltrim($request->path(), '/'),
                'created_at' => Carbon::now(),
            ]);

            $declarados = $solicitud->inicio_at
                ? max(0, (int) $solicitud->inicio_at->diffInMinutes($finAt))
                : 0;

            $solicitud->fin_at = $finAt;
            $solicitud->cerrada_por = $user->id;
            $solicitud->minutos_declarados = $declarados;
            $solicitud->minutos_activos = $solicitud->calcularMinutosActivos();
            $solicitud->estatus = HoraExtraSolicitud::ESTATUS_POR_VALIDAR;
            $solicitud->save();
        });

        return redirect()->route('app_horas_extra_ver', $solicitud->id)
            ->with('success', 'Sesión cerrada administrativamente hasta la última actividad (' . $finAt->format('d/m/Y H:i') . ') y enviada a validación.');
    }

    /**
     * Sirve un archivo de evidencia al dueño de la solicitud o a un administrador.
     */
    public function evidencia($id, $idx)
    {
        if (!$this->moduloInstalado()) {
            abort(404);
        }

        $solicitud = HoraExtraSolicitud::findOrFail((int) $id);
        $user = Auth::user();

        if (!$solicitud->esPropia($user) && !$user->isAdmin()) {
            abort(403);
        }

        $evidencias = is_array($solicitud->evidencias) ? $solicitud->evidencias : [];
        $indice = (int) $idx;
        if (!isset($evidencias[$indice]) || empty($evidencias[$indice]['ruta'])) {
            abort(404);
        }

        $baseDir = realpath(storage_path('app/horas_extra'));
        $rutaRelativa = ltrim((string) $evidencias[$indice]['ruta'], '/');
        $archivoPath = $baseDir ? realpath($baseDir . '/' . $rutaRelativa) : false;

        if (!$baseDir || !$archivoPath || strpos($archivoPath, $baseDir . DIRECTORY_SEPARATOR) !== 0 || !is_file($archivoPath)) {
            abort(404);
        }

        $nombre = isset($evidencias[$indice]['nombre']) ? $evidencias[$indice]['nombre'] : basename($archivoPath);
        $mime = isset($evidencias[$indice]['mime']) ? $evidencias[$indice]['mime'] : 'application/octet-stream';

        return response()->make(file_get_contents($archivoPath), 200, [
            'Content-Type'        => $mime,
            'Content-Disposition' => 'inline; filename="' . str_replace('"', '', $nombre) . '"',
        ]);
    }

    /**
     * Genera el reporte PDF de horas extra según filtros del historial.
     */
    public function pdf(Request $request)
    {
        if (!$this->moduloInstalado()) {
            return $this->respuestaPendiente($request);
        }

        $user = Auth::user();
        $filtros = $this->obtenerFiltros($request, $user);
        $registros = $this->consultaHistorial($filtros)->get();

        $totalesUsuario = [];
        $semanasEvaluadas = [];

        foreach ($registros as $reg) {
            $uid = (int) $reg->user_id;
            if (!isset($totalesUsuario[$uid])) {
                $totalesUsuario[$uid] = [
                    'usuario_nombre'     => $reg->usuario ? $reg->usuario->name : ('Usuario #' . $uid),
                    'usuario_rol'        => $reg->usuario ? $reg->usuario->nombre_rol : '',
                    'sesiones'           => 0,
                    'minutos_declarados' => 0,
                    'minutos_activos'    => 0,
                    'minutos_validados'  => 0,
                    'avisos_lft'         => [],
                ];
            }

            $totalesUsuario[$uid]['sesiones']++;
            $totalesUsuario[$uid]['minutos_declarados'] += (int) ($reg->minutos_declarados ?: 0);
            $totalesUsuario[$uid]['minutos_activos'] += (int) ($reg->minutos_activos ?: 0);
            if ($reg->estatus === HoraExtraSolicitud::ESTATUS_VALIDADA && $reg->minutos_validados !== null) {
                $totalesUsuario[$uid]['minutos_validados'] += (int) $reg->minutos_validados;
            }

            if (in_array($reg->estatus, [
                HoraExtraSolicitud::ESTATUS_EN_CURSO,
                HoraExtraSolicitud::ESTATUS_POR_VALIDAR,
                HoraExtraSolicitud::ESTATUS_VALIDADA,
            ])) {
                $fechaYmd = $reg->fechaYmd();
                $semKey = $uid . '|' . Carbon::parse($fechaYmd)->format('o-W');
                if (!isset($semanasEvaluadas[$semKey])) {
                    $semanasEvaluadas[$semKey] = true;
                    $lft = HoraExtraSolicitud::resumenLftUsuario($uid, $fechaYmd);
                    if ($lft['horas_semana'] > (float) config('horas_extra.limite_horas_semana', 9)) {
                        $totalesUsuario[$uid]['avisos_lft'][] = 'Semana ' . $lft['inicio_semana'] . ' al ' . $lft['fin_semana']
                            . ': ' . number_format($lft['horas_semana'], 2) . ' h (> ' . config('horas_extra.limite_horas_semana', 9) . ' h LFT)';
                    }
                    if ($lft['dias_semana'] > (int) config('horas_extra.limite_dias_semana', 3)) {
                        $totalesUsuario[$uid]['avisos_lft'][] = 'Semana ' . $lft['inicio_semana'] . ': '
                            . $lft['dias_semana'] . ' días (> ' . config('horas_extra.limite_dias_semana', 3) . ' días LFT)';
                    }
                }
            }
        }

        $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/andamios.jpg');
        if (empty($logo)) {
            $logo = Utilidades::obtenerImagenBase64('cotizaciones/img/andamios.png');
        }
        $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/Header-Cinta-de-Seguridad.jpg');
        if (empty($cinta)) {
            $cinta = Utilidades::obtenerImagenBase64('cotizaciones/img/Header-Cinta-de-Seguridad.png');
        }

        $usuarioFiltrado = !empty($filtros['usuario_id'])
            ? User::find((int) $filtros['usuario_id'])
            : null;

        $data = [
            'registros'       => $registros,
            'totalesUsuario'  => $totalesUsuario,
            'filtros'         => $filtros,
            'usuarioFiltrado' => $usuarioFiltrado,
            'generadoAt'      => Carbon::now(),
            'generadoPor'     => $user,
            'logoBase64'      => $logo,
            'cintaBase64'     => $cinta,
            'esAdmin'         => $user->isAdmin(),
        ];

        $pdf = PDF::loadView('app_redes.modulos.horas_extra.pdf', $data);
        $pdf->setPaper('letter', 'landscape');

        $filename = 'Horas_Extra_' . $filtros['desde'] . '_' . $filtros['hasta'] . '.pdf';
        return $pdf->stream($filename);
    }
}
