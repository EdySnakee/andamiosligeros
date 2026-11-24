@extends('layouts.app_redes')

@section('css')
<style>
    .he-detail-card {
        border: 1px solid rgba(15, 23, 42, .10);
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
        margin-bottom: 18px;
    }
    .he-stat-box {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 12px 14px;
        background: #f8fafc;
    }
    .he-stat-label {
        font-size: 11px;
        text-transform: uppercase;
        letter-spacing: .06em;
        color: #64748b;
        font-weight: 700;
    }
    .he-stat-val {
        font-size: 20px;
        font-weight: 800;
        color: #0f172a;
    }
</style>
@stop

@section('content')
<div class="container-fluid pt-2 pb-5">

    @php $infoEst = $solicitud->infoEstatus(); @endphp

    <div class="d-flex flex-wrap align-items-center justify-content-between mb-3" style="gap: 10px;">
        <div>
            <a href="{{ route('app_horas_extra') }}" class="btn btn-sm btn-outline-secondary mb-2">
                <i class="fas fa-arrow-left mr-1"></i> Volver a Horas Extra
            </a>
            <h1 class="h3 mb-0 text-gray-800">
                Solicitud #{{ $solicitud->id }}
                <span class="badge {{ $infoEst['clase'] }} ml-2" style="font-size: 13px;">{{ $infoEst['texto'] }}</span>
            </h1>
            <div class="small text-muted mt-1">
                <strong>{{ $solicitud->usuario ? $solicitud->usuario->name : 'Usuario #' . $solicitud->user_id }}</strong>
                @if ($solicitud->usuario) ({{ $solicitud->usuario->nombre_rol }}) @endif
                &middot; Fecha: <strong>{{ $solicitud->fechaYmd() }}</strong>
                &middot; Modalidad: <strong>{{ $solicitud->nombreModalidad() }}</strong>
            </div>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0 pl-3">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    {{-- ALERTAS DE AUDITORÍA Y LFT (Solo administradores) --}}
    @if ($esAdmin && count($alertas))
        <div class="mb-3">
            @foreach ($alertas as $al)
                <div class="alert alert-{{ $al['nivel'] }} py-2 mb-2">
                    <i class="fas fa-exclamation-triangle mr-1"></i> {{ $al['texto'] }}
                </div>
            @endforeach
        </div>
    @endif

    {{-- ACCIONES DE ADMINISTRADOR (Solo otro admin distinto al solicitante) --}}
    @if ($puedeGestionar)
        @if ($solicitud->estatus === \App\HoraExtraSolicitud::ESTATUS_EN_CURSO)
            <div class="he-detail-card p-3 border-left-danger">
                <div class="d-flex flex-wrap align-items-center justify-content-between" style="gap: 10px;">
                    <div>
                        <h6 class="font-weight-bold text-danger mb-1"><i class="fas fa-power-off mr-1"></i> Sesión actualmente en curso</h6>
                        <p class="small text-muted mb-0">Si el colaborador olvidó cerrar la sesión, puedes cerrarla administrativamente tomando su última actividad registrada.</p>
                    </div>
                    <form method="POST" action="{{ route('app_horas_extra_cerrar', $solicitud->id) }}"
                          onsubmit="return confirm('¿Cerrar administrativamente esta sesión y enviarla a validación?');">
                        {{ csrf_field() }}
                        <button type="submit" class="btn btn-danger btn-sm">Cerrar sesión administrativamente</button>
                    </form>
                </div>
            </div>
        @endif

        @if ($solicitud->estatus === \App\HoraExtraSolicitud::ESTATUS_POR_VALIDAR)
            @php
                $defaultValH = (int) floor($declaradosMin / 60);
                $defaultValM = $declaradosMin % 60;
            @endphp
            <div class="he-detail-card p-3 border-left-primary">
                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-clipboard-check mr-1"></i> Validar horas trabajadas</h6>
                <form method="POST" action="{{ route('app_horas_extra_validar', $solicitud->id) }}" id="he-form-validar" data-declarados-min="{{ $declaradosMin }}">
                    {{ csrf_field() }}
                    <div class="form-row">
                        <div class="form-group col-md-3">
                            <label class="small font-weight-bold">Decisión</label>
                            <select name="decision" id="he-select-decision" class="form-control form-control-sm">
                                <option value="validar" {{ old('decision', 'validar') === 'validar' ? 'selected' : '' }}>Validar tiempo</option>
                                <option value="rechazar" {{ old('decision') === 'rechazar' ? 'selected' : '' }}>Rechazar sesión</option>
                            </select>
                        </div>
                        <div class="form-group col-md-4" id="he-grupo-horas-val">
                            <label class="small font-weight-bold">
                                Tiempo a validar <span class="text-muted">(máximo declarado: {{ \App\HoraExtraSolicitud::formatearMinutos($declaradosMin) }})</span>
                            </label>
                            <div class="input-group input-group-sm">
                                <input type="number" name="val_horas" id="he-input-val-horas" class="form-control"
                                    min="0" max="24" step="1" value="{{ old('val_horas', $defaultValH) }}" required>
                                <div class="input-group-append"><span class="input-group-text">h</span></div>
                                <input type="number" name="val_minutos" id="he-input-val-minutos" class="form-control"
                                    min="0" max="59" step="1" value="{{ old('val_minutos', $defaultValM) }}" required>
                                <div class="input-group-append"><span class="input-group-text">min</span></div>
                            </div>
                        </div>
                        <div class="form-group col-md-5">
                            <label class="small font-weight-bold">
                                Comentario de validación <span id="he-req-comentario" class="text-danger d-none">*</span>
                                <span class="text-muted">(obligatorio si ajustas o rechazas)</span>
                            </label>
                            <input type="text" name="comentario_validacion" id="he-input-comentario-val" class="form-control form-control-sm"
                                value="{{ old('comentario_validacion') }}" placeholder="Observaciones sobre evidencia o ajuste...">
                        </div>
                    </div>
                    <button type="submit" class="btn btn-primary btn-sm">
                        <i class="fas fa-save mr-1"></i> Guardar validación
                    </button>
                </form>
            </div>
        @endif
    @endif

    {{-- MÉTRICAS DE ACTIVIDAD --}}
    @php $colMetric = $esAdmin ? 'col-md-3' : 'col-md-4'; @endphp
    <div class="row mb-3">
        <div class="{{ $colMetric }} col-sm-6 mb-2">
            <div class="he-stat-box">
                <div class="he-stat-label">Tiempo estimado</div>
                <div class="he-stat-val">
                    {{ \App\HoraExtraSolicitud::formatearHoras($solicitud->horas_estimadas) }}
                </div>
            </div>
        </div>
        <div class="{{ $colMetric }} col-sm-6 mb-2">
            <div class="he-stat-box">
                <div class="he-stat-label">Tiempo declarado</div>
                <div class="he-stat-val">{{ \App\HoraExtraSolicitud::formatearMinutos($declaradosMin) }}</div>
            </div>
        </div>
        @if ($esAdmin)
        <div class="col-md-3 col-sm-6 mb-2">
            <div class="he-stat-box">
                <div class="he-stat-label">Actividad en sistema</div>
                <div class="he-stat-val">
                    {{ \App\HoraExtraSolicitud::formatearMinutos($activosMin) }}
                    <small class="text-muted" style="font-size: 13px;">({{ $respaldoPct }}%)</small>
                </div>
            </div>
        </div>
        @endif
        <div class="{{ $colMetric }} col-sm-6 mb-2">
            <div class="he-stat-box">
                <div class="he-stat-label">Validadas para nómina</div>
                <div class="he-stat-val text-success">
                    {{ $solicitud->minutos_validados !== null ? \App\HoraExtraSolicitud::formatearMinutos($solicitud->minutos_validados) : 'Pendiente' }}
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        {{-- DATOS GENERALES Y EVIDENCIAS --}}
        <div class="col-lg-6">
            <div class="he-detail-card p-3">
                <h6 class="font-weight-bold text-primary mb-3"><i class="fas fa-info-circle mr-1"></i> Información de la solicitud</h6>
                <table class="table table-sm table-borderless mb-0 small">
                    @if ($solicitud->horaPrevistaFormateada())
                    <tr>
                        <th style="width: 34%;">Hora prevista:</th>
                        <td>{{ $solicitud->horaPrevistaFormateada() }}</td>
                    </tr>
                    @endif
                    <tr>
                        <th style="width: 34%;">Motivo:</th>
                        <td>{{ $solicitud->motivo }}</td>
                    </tr>
                    <tr>
                        <th>Consentimiento aviso:</th>
                        <td>
                            @if ($solicitud->acepta_aviso)
                                Aceptado (v{{ $solicitud->aviso_version }}) el {{ $solicitud->aviso_aceptado_at ? $solicitud->aviso_aceptado_at->format('d/m/Y H:i') : '' }}
                            @else
                                <span class="text-muted">No iniciado aún</span>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>Validación final:</th>
                        <td>
                            @if ($solicitud->validador)
                                {{ $solicitud->validador->name }} ({{ $solicitud->validada_at ? $solicitud->validada_at->format('d/m/Y H:i') : '' }})
                                @if ($solicitud->comentario_validacion)
                                    <div class="text-muted">Nota: {{ $solicitud->comentario_validacion }}</div>
                                @endif
                            @else
                                <span class="text-muted">Pendiente</span>
                            @endif
                        </td>
                    </tr>
                </table>
            </div>

            <div class="he-detail-card p-3">
                <h6 class="font-weight-bold text-primary mb-2"><i class="fas fa-file-alt mr-1"></i> Resumen y evidencias de cierre</h6>
                @if ($solicitud->resumen_trabajo)
                    <div class="p-2 bg-light border rounded small mb-3" style="white-space: pre-line;">{{ $solicitud->resumen_trabajo }}</div>
                @else
                    <p class="small text-muted mb-3">Aún no se ha registrado resumen de cierre.</p>
                @endif

                <strong class="small d-block mb-1">Archivos adjuntos ({{ count($evidencias) }}):</strong>
                @if (count($evidencias))
                    <ul class="list-group list-group-flush small">
                        @foreach ($evidencias as $idx => $ev)
                            <li class="list-group-item px-0 py-1 d-flex justify-content-between align-items-center">
                                <span><i class="fas fa-paperclip mr-1 text-secondary"></i> {{ $ev['nombre'] ?? 'Archivo' }} ({{ $ev['kb'] ?? 0 }} KB)</span>
                                <a href="{{ route('app_horas_extra_evidencia', [$solicitud->id, $idx]) }}" target="_blank" class="btn btn-xs btn-outline-primary py-0 px-2">Abrir</a>
                            </li>
                        @endforeach
                    </ul>
                @else
                    <span class="small text-muted">Sin archivos adjuntos.</span>
                @endif
            </div>
        </div>

        {{-- EVENTOS DE SESIÓN, UBICACIÓN Y ACTIVIDAD --}}
        <div class="col-lg-6">
            <div class="he-detail-card p-3">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <h6 class="font-weight-bold text-primary mb-0"><i class="fas fa-map-marker-alt mr-1"></i> Inicio, cierre y ubicación</h6>
                    @if ($distanciaM !== null)
                        <span class="badge badge-light border">Distancia inicio-fin: {{ number_format($distanciaM) }} m</span>
                    @endif
                </div>

                @if ($eventosClave->isEmpty())
                    <p class="small text-muted mb-0">Sin eventos de inicio o cierre registrados.</p>
                @else
                    <div class="table-responsive">
                        <table class="table table-sm small mb-0">
                            <thead>
                                <tr>
                                    <th>Evento</th>
                                    <th>Fecha/Hora</th>
                                    <th>IP / Dispositivo</th>
                                    <th>Ubicación</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($eventosClave as $ev)
                                    <tr>
                                        <td class="text-uppercase font-weight-bold">{{ $ev->tipo }}</td>
                                        <td class="text-nowrap">{{ $ev->created_at ? $ev->created_at->format('d/m/Y H:i:s') : '' }}</td>
                                        <td>
                                            <div>{{ $ev->ip ?: '—' }}</div>
                                            <div class="text-muted text-truncate" style="max-width: 170px;" title="{{ $ev->user_agent }}">{{ $ev->user_agent }}</div>
                                        </td>
                                        <td>
                                            @if ($ev->ubicacion_estado === 'concedida' && $ev->latitud !== null && $ev->longitud !== null)
                                                <a href="https://www.google.com/maps?q={{ $ev->latitud }},{{ $ev->longitud }}" target="_blank" rel="noopener">
                                                    <i class="fas fa-external-link-alt mr-1"></i>Ver mapa
                                                </a>
                                                @if ($ev->precision_m !== null)
                                                    <div class="text-muted">&plusmn;{{ $ev->precision_m }} m</div>
                                                @endif
                                            @elseif ($ev->ubicacion_estado)
                                                <span class="text-muted">{{ $ev->ubicacion_estado }}</span>
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if ($esAdmin)
            <div class="he-detail-card p-3">
                <div class="d-flex flex-wrap justify-content-between align-items-center mb-2" style="gap: 6px;">
                    <h6 class="font-weight-bold text-primary mb-0">
                        <i class="fas fa-heartbeat mr-1"></i> Actividad dentro del sistema
                    </h6>
                    <span class="badge badge-light border text-muted">Solo visible para administradores</span>
                </div>
                <div class="small text-muted mb-2">
                    Minutos con actividad: <strong>{{ \App\HoraExtraSolicitud::formatearMinutos($activosMin) }}</strong> ({{ $respaldoPct }}%) &middot;
                    Eventos registrados: <strong>{{ $totalAcciones + $totalLatidos }}</strong> &middot;
                    Periodos sin actividad (&gt; {{ config('horas_extra.hueco_alerta_min', 30) }} min): <strong>{{ count($huecos) }}</strong>
                </div>

                @if (count($huecos))
                    <div class="alert alert-warning py-2 small">
                        <strong>Periodos sin actividad detectados:</strong>
                        <ul class="mb-0 pl-3">
                            @foreach ($huecos as $h)
                                <li>{{ $h['desde']->format('h:i A') }} a {{ $h['hasta']->format('h:i A') }} ({{ $h['minutos'] }} min sin actividad)</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                @if (count($lineaActividad))
                    <div class="table-responsive" style="max-height: 360px; overflow-y: auto;">
                        <table class="table table-sm table-hover small mb-0">
                            <thead>
                                <tr>
                                    <th style="width: 110px;">Hora</th>
                                    <th style="width: 115px;">Módulo</th>
                                    <th>Actividad realizada</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($lineaActividad as $item)
                                    <tr class="{{ !empty($item['es_hito']) ? 'table-active font-weight-bold' : '' }}">
                                        <td class="text-nowrap text-muted">{{ $item['hora'] }}</td>
                                        <td class="text-nowrap">
                                            <span class="badge {{ !empty($item['es_hito']) ? 'badge-primary' : 'badge-light border text-dark' }}">
                                                {{ $item['modulo'] }}
                                            </span>
                                        </td>
                                        <td>
                                            {{ $item['descripcion'] }}
                                            @if (!empty($item['enlace_url']) && !empty($item['enlace_texto']))
                                                <a href="{{ $item['enlace_url'] }}" target="_blank" rel="noopener" class="font-weight-bold ml-1">
                                                    {{ $item['enlace_texto'] }} <i class="fas fa-external-link-alt fa-xs"></i>
                                                </a>
                                            @elseif (!empty($item['enlace_texto']))
                                                <strong class="ml-1">{{ $item['enlace_texto'] }}</strong>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <p class="small text-muted mb-0">No se registraron actividades en esta sesión.</p>
                @endif
            </div>
            @endif
        </div>
    </div>

</div>
@stop

@section('js')
<script>
(function($) {
    if (!$) { return; }
    var $form = $('#he-form-validar');
    var $sel = $('#he-select-decision');
    if (!$sel.length || !$form.length) { return; }

    var declaradosMin = parseInt($form.attr('data-declarados-min'), 10) || 0;
    var $hInput = $('#he-input-val-horas');
    var $mInput = $('#he-input-val-minutos');
    var $comInput = $('#he-input-comentario-val');
    var $reqAst = $('#he-req-comentario');

    function minutosIngresados() {
        var h = parseInt($hInput.val(), 10);
        var m = parseInt($mInput.val(), 10);
        if (isNaN(h)) { h = 0; }
        if (isNaN(m)) { m = 0; }
        return (h * 60) + m;
    }

    function actualizarRequisitoComentario() {
        var esRechazar = $sel.val() === 'rechazar';
        var distinto = minutosIngresados() !== declaradosMin;
        $reqAst.toggleClass('d-none', !(esRechazar || distinto));
    }

    function toggleHoras() {
        var esValidar = $sel.val() === 'validar';
        $('#he-grupo-horas-val').toggle(esValidar);
        $('#he-input-val-horas, #he-input-val-minutos').prop('disabled', !esValidar);
        actualizarRequisitoComentario();
    }

    $sel.on('change', toggleHoras);
    $hInput.on('input change', actualizarRequisitoComentario);
    $mInput.on('input change', actualizarRequisitoComentario);
    toggleHoras();

    $form.on('submit', function(e) {
        var decision = $sel.val();
        var comentario = $.trim($comInput.val() || '');

        if (decision === 'rechazar') {
            if (comentario.length < 5) {
                e.preventDefault();
                swal('Comentario requerido', 'Debes escribir el motivo del rechazo (mínimo 5 caracteres).', 'warning');
                $comInput.focus();
                return false;
            }
            return true;
        }

        var totalMin = minutosIngresados();
        if (totalMin > declaradosMin) {
            e.preventDefault();
            swal('Tiempo inválido', 'No puedes validar más tiempo del declarado.', 'warning');
            $hInput.focus();
            return false;
        }

        if (totalMin !== declaradosMin && comentario.length < 5) {
            e.preventDefault();
            swal('Comentario requerido', 'Como ajustaste el tiempo respecto a lo declarado, escribe un comentario explicativo (mínimo 5 caracteres).', 'warning');
            $comInput.focus();
            return false;
        }

        return true;
    });
})(window.jQuery);
</script>
@stop
