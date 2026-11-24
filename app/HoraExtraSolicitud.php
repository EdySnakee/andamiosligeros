<?php

namespace App;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class HoraExtraSolicitud extends Model
{
    protected $table = 'horas_extra_solicitudes';

    const ESTATUS_PROGRAMADA  = 'programada';
    const ESTATUS_SOLICITADA  = 'solicitada';
    const ESTATUS_APROBADA    = 'aprobada';
    const ESTATUS_RECHAZADA   = 'rechazada';
    const ESTATUS_CANCELADA   = 'cancelada';
    const ESTATUS_EN_CURSO    = 'en_curso';
    const ESTATUS_POR_VALIDAR = 'por_validar';
    const ESTATUS_VALIDADA    = 'validada';

    const MODALIDAD_OFICINA = 'oficina';
    const MODALIDAD_REMOTO  = 'remoto';

    protected $fillable = [
        'user_id',
        'fecha',
        'hora_inicio_prevista',
        'horas_estimadas',
        'horas_autorizadas',
        'modalidad',
        'motivo',
        'entregable',
        'referencia_tipo',
        'referencia_folio',
        'estatus',
        'aprobada_por',
        'aprobada_at',
        'comentario_aprobacion',
        'inicio_at',
        'fin_at',
        'cerrada_por',
        'resumen_trabajo',
        'evidencias',
        'minutos_declarados',
        'minutos_activos',
        'minutos_validados',
        'validada_por',
        'validada_at',
        'comentario_validacion',
        'acepta_aviso',
        'aviso_version',
        'aviso_aceptado_at',
    ];

    protected $casts = [
        'evidencias'        => 'array',
        'acepta_aviso'      => 'boolean',
        'horas_estimadas'   => 'float',
        'horas_autorizadas' => 'float',
    ];

    protected $dates = [
        'inicio_at',
        'fin_at',
        'aprobada_at',
        'validada_at',
        'aviso_aceptado_at',
    ];

    /**
     * Catálogo de estatus con texto y clase CSS de badge Bootstrap.
     *
     * @return array
     */
    public static function etiquetasEstatus()
    {
        return [
            self::ESTATUS_PROGRAMADA  => ['texto' => 'Programada',  'clase' => 'badge-info'],
            self::ESTATUS_EN_CURSO    => ['texto' => 'En curso',    'clase' => 'badge-primary'],
            self::ESTATUS_POR_VALIDAR => ['texto' => 'Por validar', 'clase' => 'badge-secondary'],
            self::ESTATUS_VALIDADA    => ['texto' => 'Validada',    'clase' => 'badge-success'],
            self::ESTATUS_RECHAZADA   => ['texto' => 'Rechazada',   'clase' => 'badge-danger'],
            self::ESTATUS_CANCELADA   => ['texto' => 'Cancelada',   'clase' => 'badge-light border text-muted'],
        ];
    }

    /**
     * Catálogo legible de modalidades.
     *
     * @return array
     */
    public static function etiquetasModalidad()
    {
        return [
            self::MODALIDAD_REMOTO  => 'Remoto / Casa',
            self::MODALIDAD_OFICINA => 'Oficina / Sucursal',
        ];
    }

    /**
     * Catálogo legible de tipos de referencia.
     *
     * @return array
     */
    public static function etiquetasReferencia()
    {
        return [
            'cotizacion'   => 'Cotización',
            'venta'        => 'Venta',
            'orden_taller' => 'Orden de taller',
            'otro'         => 'Otro',
        ];
    }

    /**
     * Usuario solicitante.
     */
    public function usuario()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Administrador que aprobó o rechazó la solicitud.
     */
    public function aprobador()
    {
        return $this->belongsTo(User::class, 'aprobada_por');
    }

    /**
     * Administrador que validó las horas finales.
     */
    public function validador()
    {
        return $this->belongsTo(User::class, 'validada_por');
    }

    /**
     * Administrador que cerró administrativamente la sesión, si aplica.
     */
    public function cerrador()
    {
        return $this->belongsTo(User::class, 'cerrada_por');
    }

    /**
     * Eventos de sesión y actividad ligados a esta solicitud.
     */
    public function eventos()
    {
        return $this->hasMany(HoraExtraEvento::class, 'solicitud_id')
            ->orderBy('created_at', 'asc')
            ->orderBy('id', 'asc');
    }

    /**
     * Determina si un usuario administrador puede aprobar, rechazar, validar o cerrar esta solicitud.
     * Nunca permite auto-autorizarse ni auto-validarse.
     *
     * @param User|null $usuario
     * @return bool
     */
    public function puedeGestionar(User $usuario = null)
    {
        if (!$usuario) {
            return false;
        }

        return $usuario->isAdmin() && (int) $usuario->id !== (int) $this->user_id;
    }

    /**
     * Determina si la solicitud pertenece al usuario indicado.
     *
     * @param User|null $usuario
     * @return bool
     */
    public function esPropia(User $usuario = null)
    {
        if (!$usuario) {
            return false;
        }

        return (int) $usuario->id === (int) $this->user_id;
    }

    /**
     * Devuelve la fecha de la solicitud normalizada en formato Y-m-d.
     *
     * @return string
     */
    public function fechaYmd()
    {
        if ($this->fecha instanceof Carbon) {
            return $this->fecha->toDateString();
        }

        return substr((string) $this->fecha, 0, 10);
    }

    /**
     * Información de badge para el estatus actual.
     *
     * @return array
     */
    public function infoEstatus()
    {
        $mapa = self::etiquetasEstatus();
        $mapa[self::ESTATUS_SOLICITADA] = ['texto' => 'Programada', 'clase' => 'badge-info'];
        $mapa[self::ESTATUS_APROBADA]   = ['texto' => 'Programada', 'clase' => 'badge-info'];

        return isset($mapa[$this->estatus])
            ? $mapa[$this->estatus]
            : ['texto' => ucfirst((string) $this->estatus), 'clase' => 'badge-light'];
    }

    /**
     * Nombre legible de la modalidad actual.
     *
     * @return string
     */
    public function nombreModalidad()
    {
        $mapa = self::etiquetasModalidad();
        if (isset($mapa[$this->modalidad])) {
            return $mapa[$this->modalidad];
        }
        if ($this->modalidad === 'campo') {
            return 'Campo / Obra';
        }
        return ucfirst((string) $this->modalidad);
    }

    /**
     * Formatea minutos enteros en texto legible (ej. "8 min", "1 h", "1 h 30 min").
     *
     * @param int|null $minutos
     * @return string
     */
    public static function formatearMinutos($minutos)
    {
        if ($minutos === null) {
            return '—';
        }
        $m = max(0, (int) $minutos);
        if ($m === 0) {
            return '0 min';
        }
        if ($m < 60) {
            return $m . ' min';
        }
        $horas = (int) floor($m / 60);
        $resto = $m % 60;
        if ($resto === 0) {
            return $horas . ' h';
        }
        return $horas . ' h ' . $resto . ' min';
    }

    /**
     * Formatea una cantidad de horas decimales en texto legible (ej. 1.5 -> "1 h 30 min").
     *
     * @param float|int|null $horas
     * @return string
     */
    public static function formatearHoras($horas)
    {
        if ($horas === null || $horas === '') {
            return '—';
        }
        return self::formatearMinutos((int) round(((float) $horas) * 60));
    }

    /**
     * Devuelve la hora prevista formateada en 12 horas (ej. "05:00 PM"), o null si no tiene.
     *
     * @return string|null
     */
    public function horaPrevistaFormateada()
    {
        if (empty($this->hora_inicio_prevista)) {
            return null;
        }
        $hhmm = substr((string) $this->hora_inicio_prevista, 0, 5);
        try {
            return Carbon::createFromFormat('H:i', $hhmm)->format('h:i A');
        } catch (\Throwable $e) {
            return $hhmm;
        }
    }

    /**
     * Minutos transcurridos desde inicio_at hasta fin_at (o ahora si sigue en curso).
     *
     * @return int
     */
    public function minutosTranscurridos()
    {
        if (!$this->inicio_at) {
            return 0;
        }

        $fin = $this->fin_at ?: Carbon::now();
        if ($fin->lt($this->inicio_at)) {
            return 0;
        }

        return (int) $this->inicio_at->diffInMinutes($fin);
    }

    /**
     * Calcula los minutos con actividad registrada (minutos distintos con evento inicio/fin/latido/accion).
     *
     * @return int
     */
    public function calcularMinutosActivos()
    {
        if (!$this->inicio_at) {
            return 0;
        }

        $fin = $this->fin_at ?: Carbon::now();

        $fila = DB::table('horas_extra_eventos')
            ->select(DB::raw("COUNT(DISTINCT DATE_FORMAT(created_at, '%Y-%m-%d %H:%i')) as mins"))
            ->where('solicitud_id', $this->id)
            ->whereIn('tipo', [
                HoraExtraEvento::TIPO_INICIO,
                HoraExtraEvento::TIPO_FIN,
                HoraExtraEvento::TIPO_LATIDO,
                HoraExtraEvento::TIPO_ACCION,
            ])
            ->where('created_at', '>=', $this->inicio_at->toDateTimeString())
            ->where('created_at', '<=', $fin->toDateTimeString())
            ->first();

        $activos = $fila ? (int) $fila->mins : 0;
        $techo = $this->minutos_declarados !== null
            ? (int) $this->minutos_declarados
            : $this->minutosTranscurridos();

        return min($activos, max(0, $techo));
    }

    /**
     * Devuelve los intervalos de inactividad mayores al umbral configurado.
     *
     * @return array
     */
    public function huecos()
    {
        if (!$this->inicio_at) {
            return [];
        }

        $fin = $this->fin_at ?: Carbon::now();
        $umbral = (int) config('horas_extra.hueco_alerta_min', 30);

        $timestamps = [$this->inicio_at->copy()];

        if ($this->relationLoaded('eventos')) {
            foreach ($this->eventos as $ev) {
                if (!in_array($ev->tipo, [
                    HoraExtraEvento::TIPO_INICIO,
                    HoraExtraEvento::TIPO_FIN,
                    HoraExtraEvento::TIPO_LATIDO,
                    HoraExtraEvento::TIPO_ACCION,
                ])) {
                    continue;
                }
                if ($ev->created_at && $ev->created_at->gte($this->inicio_at) && $ev->created_at->lte($fin)) {
                    $timestamps[] = $ev->created_at->copy();
                }
            }
        } else {
            $eventos = HoraExtraEvento::where('solicitud_id', $this->id)
                ->whereIn('tipo', [
                    HoraExtraEvento::TIPO_INICIO,
                    HoraExtraEvento::TIPO_FIN,
                    HoraExtraEvento::TIPO_LATIDO,
                    HoraExtraEvento::TIPO_ACCION,
                ])
                ->where('created_at', '>=', $this->inicio_at->toDateTimeString())
                ->where('created_at', '<=', $fin->toDateTimeString())
                ->orderBy('created_at', 'asc')
                ->get(['created_at']);

            foreach ($eventos as $ev) {
                if ($ev->created_at) {
                    $timestamps[] = $ev->created_at->copy();
                }
            }
        }

        $timestamps[] = $fin->copy();

        usort($timestamps, function (Carbon $a, Carbon $b) {
            return $a->timestamp <=> $b->timestamp;
        });

        $huecos = [];
        $total = count($timestamps);
        for ($i = 1; $i < $total; $i++) {
            $prev = $timestamps[$i - 1];
            $curr = $timestamps[$i];
            $diff = (int) $prev->diffInMinutes($curr);
            if ($diff > $umbral) {
                $huecos[] = [
                    'desde'   => $prev->copy(),
                    'hasta'   => $curr->copy(),
                    'minutos' => $diff,
                ];
            }
        }

        return $huecos;
    }

    /**
     * Porcentaje de tiempo activo respecto al tiempo declarado/transcurrido.
     *
     * @return int
     */
    public function porcentajeRespaldo()
    {
        $declarados = $this->minutos_declarados !== null
            ? (int) $this->minutos_declarados
            : $this->minutosTranscurridos();

        if ($declarados <= 0) {
            return 0;
        }

        $activos = ($this->fin_at && $this->minutos_activos !== null)
            ? (int) $this->minutos_activos
            : $this->calcularMinutosActivos();

        return (int) min(100, round(($activos / $declarados) * 100));
    }

    /**
     * Devuelve el evento de inicio de la sesión.
     *
     * @return HoraExtraEvento|null
     */
    public function eventoInicio()
    {
        if ($this->relationLoaded('eventos')) {
            foreach ($this->eventos as $ev) {
                if ($ev->tipo === HoraExtraEvento::TIPO_INICIO) {
                    return $ev;
                }
            }
            return null;
        }

        return HoraExtraEvento::where('solicitud_id', $this->id)
            ->where('tipo', HoraExtraEvento::TIPO_INICIO)
            ->orderBy('id', 'asc')
            ->first();
    }

    /**
     * Devuelve el evento de fin de la sesión.
     *
     * @return HoraExtraEvento|null
     */
    public function eventoFin()
    {
        if ($this->relationLoaded('eventos')) {
            $ultimo = null;
            foreach ($this->eventos as $ev) {
                if ($ev->tipo === HoraExtraEvento::TIPO_FIN) {
                    $ultimo = $ev;
                }
            }
            return $ultimo;
        }

        return HoraExtraEvento::where('solicitud_id', $this->id)
            ->where('tipo', HoraExtraEvento::TIPO_FIN)
            ->orderBy('id', 'desc')
            ->first();
    }

    /**
     * Calcula la distancia Haversine en metros entre el evento de inicio y el de fin.
     *
     * @return int|null
     */
    public function distanciaInicioFinM()
    {
        $inicio = $this->eventoInicio();
        $fin = $this->eventoFin();

        if (!$inicio || !$fin) {
            return null;
        }
        if ($inicio->latitud === null || $inicio->longitud === null || $fin->latitud === null || $fin->longitud === null) {
            return null;
        }

        $lat1 = deg2rad((float) $inicio->latitud);
        $lon1 = deg2rad((float) $inicio->longitud);
        $lat2 = deg2rad((float) $fin->latitud);
        $lon2 = deg2rad((float) $fin->longitud);

        $dLat = $lat2 - $lat1;
        $dLon = $lon2 - $lon1;

        $a = sin($dLat / 2) * sin($dLat / 2)
            + cos($lat1) * cos($lat2) * sin($dLon / 2) * sin($dLon / 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));

        return (int) round(6371000 * $c);
    }

    /**
     * Calcula el acumulado de horas extra (día y semana ISO) según LFT para un usuario en una fecha.
     *
     * @param int $userId
     * @param string $fechaYmd
     * @return array
     */
    public static function resumenLftUsuario($userId, $fechaYmd)
    {
        $ref = Carbon::parse($fechaYmd);
        $inicioSemana = $ref->copy()->startOfWeek()->toDateString();
        $finSemana = $ref->copy()->endOfWeek()->toDateString();

        $registros = self::where('user_id', (int) $userId)
            ->whereIn('estatus', [
                self::ESTATUS_EN_CURSO,
                self::ESTATUS_POR_VALIDAR,
                self::ESTATUS_VALIDADA,
            ])
            ->whereBetween('fecha', [$inicioSemana, $finSemana])
            ->get();

        $horasSemana = 0.0;
        $horasDia = 0.0;
        $diasConHoras = [];

        foreach ($registros as $reg) {
            if ($reg->minutos_validados !== null) {
                $h = ((int) $reg->minutos_validados) / 60;
            } elseif ($reg->minutos_declarados !== null) {
                $h = ((int) $reg->minutos_declarados) / 60;
            } elseif ($reg->estatus === self::ESTATUS_EN_CURSO && $reg->inicio_at) {
                $h = max(
                    (float) $reg->horas_estimadas,
                    $reg->minutosTranscurridos() / 60
                );
            } else {
                $h = (float) $reg->horas_estimadas;
            }

            if ($h > 0) {
                $diasConHoras[$reg->fechaYmd()] = true;
            }
            $horasSemana += $h;
            if ($reg->fechaYmd() === $fechaYmd) {
                $horasDia += $h;
            }
        }

        return [
            'horas_dia'    => round($horasDia, 2),
            'dias_semana'  => count($diasConHoras),
            'horas_semana' => round($horasSemana, 2),
            'inicio_semana' => $inicioSemana,
            'fin_semana'    => $finSemana,
        ];
    }

    /**
     * Genera la lista de alertas de verificación y cumplimiento LFT para esta solicitud.
     *
     * @return array
     */
    public function alertas()
    {
        $alertas = [];
        $inicio = $this->eventoInicio();
        $fin = $this->eventoFin();

        if ($inicio && $inicio->ubicacion_estado !== HoraExtraEvento::UBICACION_CONCEDIDA) {
            $alertas[] = [
                'nivel' => $inicio->ubicacion_estado === HoraExtraEvento::UBICACION_DENEGADA ? 'danger' : 'warning',
                'texto' => $inicio->ubicacion_estado === HoraExtraEvento::UBICACION_DENEGADA
                    ? 'Ubicación denegada por el usuario al iniciar la sesión.'
                    : 'Ubicación no disponible al iniciar la sesión (requiere permiso o conexión HTTPS).',
            ];
        }

        if ($fin && $fin->ubicacion_estado !== HoraExtraEvento::UBICACION_CONCEDIDA) {
            $alertas[] = [
                'nivel' => $fin->ubicacion_estado === HoraExtraEvento::UBICACION_DENEGADA ? 'danger' : 'warning',
                'texto' => $fin->ubicacion_estado === HoraExtraEvento::UBICACION_DENEGADA
                    ? 'Ubicación denegada por el usuario al finalizar la sesión.'
                    : 'Ubicación no disponible al finalizar la sesión.',
            ];
        }

        $dist = $this->distanciaInicioFinM();
        $maxDist = (int) config('horas_extra.distancia_alerta_m', 1000);
        if ($dist !== null && $dist > $maxDist) {
            $alertas[] = [
                'nivel' => 'warning',
                'texto' => 'Distancia entre inicio y fin de ' . number_format($dist) . ' m (supera ' . number_format($maxDist) . ' m).',
            ];
        }

        if ($inicio && $fin && !empty($inicio->ip) && !empty($fin->ip) && $inicio->ip !== $fin->ip) {
            $alertas[] = [
                'nivel' => 'warning',
                'texto' => 'Cambio de IP durante la sesión (inicio: ' . $inicio->ip . ', fin: ' . $fin->ip . ').',
            ];
        }

        $declarados = $this->minutos_declarados !== null
            ? (int) $this->minutos_declarados
            : $this->minutosTranscurridos();
        $minRespaldo = (int) config('horas_extra.respaldo_minimo_pct', 50);

        if ($this->inicio_at && $declarados > 0) {
            $pct = $this->porcentajeRespaldo();
            if ($pct < $minRespaldo) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'texto' => 'Respaldo de actividad en sistema bajo: ' . $pct . '% (mínimo sugerido: ' . $minRespaldo . '%).',
                ];
            }
        }

        foreach ($this->huecos() as $hueco) {
            $alertas[] = [
                'nivel' => 'warning',
                'texto' => 'Hueco sin actividad de ' . $hueco['minutos'] . ' min (' . $hueco['desde']->format('H:i') . ' a ' . $hueco['hasta']->format('H:i') . ').',
            ];
        }

        $horasRef = (float) $this->horas_estimadas;
        if ($horasRef > 0 && $declarados > (int) round($horasRef * 60)) {
            $alertas[] = [
                'nivel' => 'warning',
                'texto' => 'Tiempo declarado (' . self::formatearMinutos($declarados) . ') supera las horas estimadas (' . self::formatearHoras($horasRef) . ').',
            ];
        }

        if (!empty($this->cerrada_por)) {
            $alertas[] = [
                'nivel' => 'info',
                'texto' => 'Sesión cerrada administrativamente por un administrador.',
            ];
        }

        if ($this->estatus === self::ESTATUS_EN_CURSO && $this->inicio_at) {
            $horasBase = (float) $this->horas_estimadas;
            $limiteMin = (int) round(($horasBase + 2) * 60);
            if ($this->minutosTranscurridos() > $limiteMin) {
                $alertas[] = [
                    'nivel' => 'danger',
                    'texto' => 'Sesión abierta por más de ' . number_format($horasBase + 2, 1) . ' h (supera estimadas + 2 h).',
                ];
            }
        }

        if (in_array($this->estatus, [self::ESTATUS_EN_CURSO, self::ESTATUS_POR_VALIDAR, self::ESTATUS_VALIDADA])) {
            $lft = self::resumenLftUsuario($this->user_id, $this->fechaYmd());
            $limDia = (float) config('horas_extra.limite_horas_dia', 3);
            $limDiasSem = (int) config('horas_extra.limite_dias_semana', 3);
            $limHorSem = (float) config('horas_extra.limite_horas_semana', 9);

            if ($lft['horas_dia'] > $limDia) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'texto' => 'LFT: acumula ' . number_format($lft['horas_dia'], 2) . ' h en este día (referencia ordinaria: ' . $limDia . ' h/día).',
                ];
            }
            if ($lft['dias_semana'] > $limDiasSem) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'texto' => 'LFT: acumula ' . $lft['dias_semana'] . ' días con horas extra en la semana ISO (referencia ordinaria: ' . $limDiasSem . ' días/semana).',
                ];
            }
            if ($lft['horas_semana'] > $limHorSem) {
                $alertas[] = [
                    'nivel' => 'warning',
                    'texto' => 'LFT: acumula ' . number_format($lft['horas_semana'], 2) . ' h en la semana ISO (referencia ordinaria: ' . $limHorSem . ' h/semana; excedente puede causar pago triple).',
                ];
            }
        }

        return $alertas;
    }
}
