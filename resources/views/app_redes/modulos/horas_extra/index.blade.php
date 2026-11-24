@extends('layouts.app_redes')

@section('css')
<style>
    .he-header {
        display: flex;
        flex-wrap: wrap;
        align-items: center;
        justify-content: space-between;
        gap: 12px;
        margin-bottom: 16px;
    }
    .he-card {
        border: 1px solid rgba(15, 23, 42, .10);
        border-radius: 12px;
        background: #fff;
        box-shadow: 0 6px 18px rgba(15, 23, 42, .05);
    }
    .he-table thead th {
        background: #f8fafc;
        color: #0f172a;
        font-size: 11px;
        letter-spacing: .08em;
        text-transform: uppercase;
        font-weight: 800;
        white-space: nowrap;
    }
    .he-table tbody td {
        vertical-align: middle;
        font-size: 13px;
    }
    .he-nav-tabs .nav-link {
        font-weight: 600;
        color: #475569;
    }
    .he-nav-tabs .nav-link.active {
        color: #1a4189;
        border-bottom: 2px solid #1a4189;
    }
</style>
@stop

@section('content')
<div class="container-fluid pt-2 pb-5">

    <div class="he-header">
        <div>
            <h1 class="h3 mb-1 text-gray-800">
                <i class="fas fa-business-time text-primary mr-2"></i>Horas Extra
            </h1>
            <p class="mb-0 text-muted small">
                <i class="fas fa-shield-alt mr-1 text-info"></i>
                La actividad solo se registra dentro del sistema mientras tu sesión de horas extra está activa.
                <a href="#" data-toggle="modal" data-target="#modalAvisoPrivacidad" class="ml-1 font-weight-bold">Ver aviso de privacidad</a>
            </p>
        </div>

        @if (empty($moduloPendiente))
        <div class="d-flex flex-wrap align-items-center" style="gap: 8px;">
            @if (!$esAdmin)
                <a href="{{ route('app_horas_extra_pdf', ['desde' => $filtros['desde'], 'hasta' => $filtros['hasta'], 'estatus' => $filtros['estatus']]) }}"
                   target="_blank" class="btn btn-outline-secondary btn-sm">
                    <i class="fas fa-file-pdf text-danger mr-1"></i> Exportar mis horas (PDF)
                </a>
            @endif
            <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#modalNuevaSolicitud">
                <i class="fas fa-plus mr-1"></i> Nueva solicitud
            </button>
        </div>
        @endif
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (session('warning'))
        <div class="alert alert-warning alert-dismissible fade show" role="alert">
            <i class="fas fa-exclamation-triangle mr-1"></i> {{ session('warning') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (session('error'))
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <i class="fas fa-times-circle mr-1"></i> {{ session('error') }}
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif
    @if (isset($errors) && $errors->any())
        <div class="alert alert-danger alert-dismissible fade show" role="alert">
            <strong>Revisa los siguientes datos:</strong>
            <ul class="mb-0 mt-1 pl-3">
                @foreach ($errors->all() as $err)
                    <li>{{ $err }}</li>
                @endforeach
            </ul>
            <button type="button" class="close" data-dismiss="alert" aria-label="Cerrar"><span aria-hidden="true">&times;</span></button>
        </div>
    @endif

    @if (!empty($moduloPendiente))
        <div class="alert alert-warning">
            <strong>Módulo pendiente de instalar en base de datos.</strong> Ejecuta las migraciones o importa <code>database/sql/2026_11_21_horas_extra.sql</code> para habilitar Horas Extra.
        </div>
    @else

    @php
        $abrirHistorial = $esAdmin && (
            request()->input('tab') === 'historial'
            || request()->has('desde')
            || request()->has('hasta')
            || request()->has('usuario_id')
            || request()->has('estatus')
        );
    @endphp

    <div class="he-card p-3">
        <ul class="nav nav-tabs he-nav-tabs mb-3" id="heTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link {{ !$abrirHistorial ? 'active' : '' }}" id="tab-mias-link" data-toggle="tab" href="#tab-mias" role="tab">
                    Mis horas extra <span class="badge badge-light border ml-1">{{ $misSolicitudes->count() }}</span>
                </a>
            </li>
            @if ($esAdmin)
                <li class="nav-item">
                    <a class="nav-link" id="tab-en-curso-link" data-toggle="tab" href="#tab-en-curso" role="tab">
                        En curso
                        <span class="badge {{ $enCurso->count() ? 'badge-primary' : 'badge-light border' }} ml-1">{{ $enCurso->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" id="tab-por-validar-link" data-toggle="tab" href="#tab-por-validar" role="tab">
                        Por validar
                        <span class="badge {{ $porValidar->count() ? 'badge-info' : 'badge-light border' }} ml-1">{{ $porValidar->count() }}</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link {{ $abrirHistorial ? 'active' : '' }}" id="tab-historial-link" data-toggle="tab" href="#tab-historial" role="tab">
                        Historial <span class="badge badge-light border ml-1">{{ $historial->count() }}</span>
                    </a>
                </li>
            @endif
        </ul>

        <div class="tab-content" id="heTabsContent">

            {{-- TAB 1: MIS HORAS EXTRA --}}
            <div class="tab-pane fade {{ !$abrirHistorial ? 'show active' : '' }}" id="tab-mias" role="tabpanel">
                @if ($misSolicitudes->isEmpty())
                    <div class="text-center text-muted py-4">
                        No has registrado solicitudes de horas extra todavía. Usa el botón <strong>Nueva solicitud</strong> para crear una.
                    </div>
                @else
                    <div class="table-responsive">
                        <table class="table table-hover he-table mb-0">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Fecha</th>
                                    <th>Modalidad</th>
                                    <th>Motivo</th>
                                    <th>Estimadas</th>
                                    <th>{{ $esAdmin ? 'Tiempo (Dec. / Act. / Val.)' : 'Tiempo (Dec. / Val.)' }}</th>
                                    <th>Estatus</th>
                                    <th class="text-right">Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($misSolicitudes as $sol)
                                    @php
                                        $infoEst = $sol->infoEstatus();
                                        $puedeIniciar = in_array($sol->estatus, [
                                            \App\HoraExtraSolicitud::ESTATUS_PROGRAMADA,
                                            \App\HoraExtraSolicitud::ESTATUS_APROBADA,
                                            \App\HoraExtraSolicitud::ESTATUS_SOLICITADA,
                                        ]);
                                    @endphp
                                    <tr>
                                        <td><strong>#{{ $sol->id }}</strong></td>
                                        <td class="text-nowrap">
                                            {{ $sol->fechaYmd() }}
                                            @if ($sol->horaPrevistaFormateada())
                                                <div class="small text-muted">{{ $sol->horaPrevistaFormateada() }}</div>
                                            @endif
                                        </td>
                                        <td>{{ $sol->nombreModalidad() }}</td>
                                        <td style="max-width: 280px;">
                                            <div class="font-weight-bold text-dark text-truncate" title="{{ $sol->motivo }}">{{ $sol->motivo }}</div>
                                        </td>
                                        <td class="text-nowrap">
                                            {{ \App\HoraExtraSolicitud::formatearHoras($sol->horas_estimadas) }}
                                        </td>
                                        <td class="text-nowrap small">
                                            @if ($sol->inicio_at)
                                                <div>Dec: {{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_declarados !== null ? $sol->minutos_declarados : $sol->minutosTranscurridos()) }}</div>
                                                @if ($esAdmin)
                                                    <div>Act: {{ \App\HoraExtraSolicitud::formatearMinutos($sol->fin_at && $sol->minutos_activos !== null ? $sol->minutos_activos : $sol->calcularMinutosActivos()) }} ({{ $sol->porcentajeRespaldo() }}%)</div>
                                                @endif
                                                @if ($sol->minutos_validados !== null)
                                                    <div class="text-success font-weight-bold">Val: {{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_validados) }}</div>
                                                @endif
                                            @else
                                                <span class="text-muted">—</span>
                                            @endif
                                        </td>
                                        <td>
                                            <span class="badge {{ $infoEst['clase'] }} px-2 py-1">{{ $infoEst['texto'] }}</span>
                                        </td>
                                        <td class="text-right text-nowrap">
                                            @if ($puedeIniciar && $sol->fechaYmd() === $hoy)
                                                <button type="button"
                                                    class="btn btn-success btn-sm btn-iniciar-he"
                                                    data-id="{{ $sol->id }}"
                                                    data-url="{{ route('app_horas_extra_iniciar', $sol->id) }}"
                                                    data-horas="{{ \App\HoraExtraSolicitud::formatearHoras($sol->horas_estimadas) }}"
                                                    data-modalidad="{{ $sol->nombreModalidad() }}"
                                                    data-motivo="{{ $sol->motivo }}"
                                                    {{ $sesionActivaMia ? 'disabled title="Ya tienes una sesión en curso"' : '' }}>
                                                    <i class="fas fa-play mr-1"></i> Iniciar
                                                </button>
                                            @elseif ($puedeIniciar && $sol->fechaYmd() !== $hoy)
                                                <span class="small text-muted mr-1" title="Disponible el {{ $sol->fechaYmd() }}">Prog: {{ $sol->fechaYmd() }}</span>
                                            @endif

                                            @if ($sol->estatus === \App\HoraExtraSolicitud::ESTATUS_EN_CURSO)
                                                <button type="button"
                                                    class="btn btn-danger btn-sm btn-finalizar-he"
                                                    data-id="{{ $sol->id }}"
                                                    data-url="{{ route('app_horas_extra_finalizar', $sol->id) }}">
                                                    <i class="fas fa-stop mr-1"></i> Finalizar
                                                </button>
                                            @endif

                                            @if ($puedeIniciar)
                                                <form method="POST" action="{{ route('app_horas_extra_cancelar', $sol->id) }}" class="d-inline"
                                                      onsubmit="return confirm('¿Seguro que deseas cancelar la solicitud #{{ $sol->id }}?');">
                                                    {{ csrf_field() }}
                                                    <button type="submit" class="btn btn-outline-secondary btn-sm">Cancelar</button>
                                                </form>
                                            @endif

                                            <a href="{{ route('app_horas_extra_ver', $sol->id) }}" class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye"></i> Ver
                                            </a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endif
            </div>

            @if ($esAdmin)
                {{-- TAB 2: EN CURSO --}}
                <div class="tab-pane fade" id="tab-en-curso" role="tabpanel">
                    @if ($enCurso->isEmpty())
                        <div class="text-center text-muted py-4">No hay sesiones de horas extra en curso en este momento.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover he-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Colaborador</th>
                                        <th>Inicio</th>
                                        <th>Transcurrido / Activo</th>
                                        <th>Respaldo</th>
                                        <th>Alertas</th>
                                        <th class="text-right">Acciones</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($enCurso as $sol)
                                        @php
                                            $alertasSol = $sol->alertas();
                                            $pctSol = $sol->porcentajeRespaldo();
                                        @endphp
                                        <tr>
                                            <td><strong>#{{ $sol->id }}</strong></td>
                                            <td>
                                                <div class="font-weight-bold">{{ $sol->usuario ? $sol->usuario->name : 'Usuario #' . $sol->user_id }}</div>
                                                <div class="small text-muted">{{ $sol->nombreModalidad() }}</div>
                                            </td>
                                            <td class="text-nowrap">{{ $sol->inicio_at ? $sol->inicio_at->format('d/m/Y H:i') : '—' }}</td>
                                            <td class="text-nowrap">
                                                {{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutosTranscurridos()) }} /
                                                {{ \App\HoraExtraSolicitud::formatearMinutos($sol->calcularMinutosActivos()) }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $pctSol >= config('horas_extra.respaldo_minimo_pct', 50) ? 'badge-success' : 'badge-warning text-dark' }}">{{ $pctSol }}%</span>
                                            </td>
                                            <td>
                                                @if (count($alertasSol))
                                                    <span class="badge badge-warning text-dark">{{ count($alertasSol) }} alerta(s)</span>
                                                @else
                                                    <span class="badge badge-light border text-success">Sin alertas</span>
                                                @endif
                                            </td>
                                            <td class="text-right text-nowrap">
                                                <a href="{{ route('app_horas_extra_ver', $sol->id) }}" class="btn btn-outline-primary btn-sm">Ver detalle</a>
                                                @if ($sol->puedeGestionar(Auth::user()))
                                                    <form method="POST" action="{{ route('app_horas_extra_cerrar', $sol->id) }}" class="d-inline"
                                                          onsubmit="return confirm('¿Cerrar administrativamente la sesión #{{ $sol->id }} usando su última actividad registrada?');">
                                                        {{ csrf_field() }}
                                                        <button type="submit" class="btn btn-outline-danger btn-sm">Cerrar sesión</button>
                                                    </form>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- TAB 3: POR VALIDAR --}}
                <div class="tab-pane fade" id="tab-por-validar" role="tabpanel">
                    @if ($porValidar->isEmpty())
                        <div class="text-center text-muted py-4">No hay sesiones pendientes de validación.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover he-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Colaborador</th>
                                        <th>Fecha</th>
                                        <th>Declarado vs Activo</th>
                                        <th>Respaldo</th>
                                        <th>Alertas</th>
                                        <th class="text-right">Validación</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($porValidar as $sol)
                                        @php
                                            $alertasSol = $sol->alertas();
                                            $pctSol = $sol->porcentajeRespaldo();
                                        @endphp
                                        <tr>
                                            <td><strong>#{{ $sol->id }}</strong></td>
                                            <td>
                                                <div class="font-weight-bold">{{ $sol->usuario ? $sol->usuario->name : 'Usuario #' . $sol->user_id }}</div>
                                                <div class="small text-muted">{{ $sol->nombreModalidad() }}</div>
                                            </td>
                                            <td class="text-nowrap">{{ $sol->fechaYmd() }}</td>
                                            <td class="text-nowrap">
                                                Dec: <strong>{{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_declarados) }}</strong> |
                                                Act: {{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_activos) }}
                                            </td>
                                            <td>
                                                <span class="badge {{ $pctSol >= config('horas_extra.respaldo_minimo_pct', 50) ? 'badge-success' : 'badge-warning text-dark' }}">{{ $pctSol }}%</span>
                                            </td>
                                            <td>
                                                @if (count($alertasSol))
                                                    <span class="badge badge-danger">{{ count($alertasSol) }} alerta(s)</span>
                                                @else
                                                    <span class="badge badge-success">Limpio</span>
                                                @endif
                                            </td>
                                            <td class="text-right">
                                                <a href="{{ route('app_horas_extra_ver', $sol->id) }}" class="btn btn-primary btn-sm">
                                                    <i class="fas fa-clipboard-check mr-1"></i> Revisar y validar
                                                </a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>

                {{-- TAB 4: HISTORIAL Y EXPORTACIÓN PDF --}}
                <div class="tab-pane fade {{ $abrirHistorial ? 'show active' : '' }}" id="tab-historial" role="tabpanel">
                    <form method="GET" action="{{ route('app_horas_extra') }}" class="form-row align-items-end mb-3">
                        <input type="hidden" name="tab" value="historial">
                        <div class="col-md-3 mb-2">
                            <label class="small font-weight-bold mb-1">Colaborador</label>
                            <select name="usuario_id" class="form-control form-control-sm">
                                <option value="">Todos los usuarios</option>
                                @foreach ($usuariosActivos as $u)
                                    <option value="{{ $u->id }}" {{ (string)$filtros['usuario_id'] === (string)$u->id ? 'selected' : '' }}>
                                        {{ $u->name }} ({{ $u->nombre_rol }})
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold mb-1">Desde</label>
                            <input type="date" name="desde" value="{{ $filtros['desde'] }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold mb-1">Hasta</label>
                            <input type="date" name="hasta" value="{{ $filtros['hasta'] }}" class="form-control form-control-sm">
                        </div>
                        <div class="col-md-2 mb-2">
                            <label class="small font-weight-bold mb-1">Estatus</label>
                            <select name="estatus" class="form-control form-control-sm">
                                <option value="">Todos</option>
                                @foreach (\App\HoraExtraSolicitud::etiquetasEstatus() as $clave => $meta)
                                    <option value="{{ $clave }}" {{ $filtros['estatus'] === $clave ? 'selected' : '' }}>{{ $meta['texto'] }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="col-md-3 mb-2 d-flex" style="gap: 6px;">
                            <button type="submit" class="btn btn-primary btn-sm">
                                <i class="fas fa-filter mr-1"></i> Filtrar
                            </button>
                            <a href="{{ route('app_horas_extra_pdf', $filtros) }}" target="_blank" class="btn btn-outline-danger btn-sm">
                                <i class="fas fa-file-pdf mr-1"></i> Exportar PDF
                            </a>
                        </div>
                    </form>

                    @if ($historial->isEmpty())
                        <div class="text-center text-muted py-4">No se encontraron registros con los filtros seleccionados.</div>
                    @else
                        <div class="table-responsive">
                            <table class="table table-hover he-table mb-0">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Fecha</th>
                                        <th>Colaborador</th>
                                        <th>Modalidad</th>
                                        <th>Est.</th>
                                        <th>Dec.</th>
                                        <th>Act.</th>
                                        <th>Val.</th>
                                        <th>Estatus</th>
                                        <th class="text-right">Detalle</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($historial as $sol)
                                        @php $infoEst = $sol->infoEstatus(); @endphp
                                        <tr>
                                            <td>#{{ $sol->id }}</td>
                                            <td class="text-nowrap">{{ $sol->fechaYmd() }}</td>
                                            <td>{{ $sol->usuario ? $sol->usuario->name : 'Usuario #' . $sol->user_id }}</td>
                                            <td>{{ $sol->nombreModalidad() }}</td>
                                            <td>{{ \App\HoraExtraSolicitud::formatearHoras($sol->horas_estimadas) }}</td>
                                            <td>{{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_declarados) }}</td>
                                            <td>{{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_activos) }}</td>
                                            <td class="font-weight-bold text-success">{{ \App\HoraExtraSolicitud::formatearMinutos($sol->minutos_validados) }}</td>
                                            <td><span class="badge {{ $infoEst['clase'] }} px-2 py-1">{{ $infoEst['texto'] }}</span></td>
                                            <td class="text-right">
                                                <a href="{{ route('app_horas_extra_ver', $sol->id) }}" class="btn btn-outline-primary btn-sm">Ver</a>
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    @endif
                </div>
            @endif

        </div>
    </div>

    {{-- MODAL: NUEVA SOLICITUD --}}
    <div class="modal fade" id="modalNuevaSolicitud" tabindex="-1" role="dialog" aria-labelledby="modalNuevaSolicitudLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <form method="POST" action="{{ route('app_horas_extra_guardar') }}" class="modal-content">
                {{ csrf_field() }}
                <div class="modal-header bg-primary text-white">
                    <h5 class="modal-title" id="modalNuevaSolicitudLabel">
                        <i class="fas fa-plus-circle mr-1"></i> Solicitar horas extra
                    </h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-row">
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Fecha <span class="text-danger">*</span></label>
                            <input type="date" name="fecha" class="form-control" min="{{ $hoy }}" value="{{ old('fecha', $hoy) }}" required>
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Hora prevista de inicio</label>
                            <input type="time" name="hora_inicio_prevista" class="form-control" step="60" value="{{ old('hora_inicio_prevista', '17:00') }}">
                        </div>
                        <div class="form-group col-md-4">
                            <label class="font-weight-bold">Horas estimadas <span class="text-danger">*</span></label>
                            <input type="number" name="horas_estimadas" class="form-control" step="0.5" min="0.5" max="12" value="{{ old('horas_estimadas', '2') }}" required>
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="font-weight-bold">Modalidad <span class="text-danger">*</span></label>
                        <select name="modalidad" class="form-control" required>
                            @foreach (\App\HoraExtraSolicitud::etiquetasModalidad() as $val => $txt)
                                <option value="{{ $val }}" {{ old('modalidad', 'remoto') === $val ? 'selected' : '' }}>{{ $txt }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group mb-0">
                        <label class="font-weight-bold">Motivo de las horas extra <span class="text-danger">*</span></label>
                        <textarea name="motivo" class="form-control" rows="3" required minlength="10" maxlength="1000" placeholder="Explica por qué se requiere el tiempo extraordinario...">{{ old('motivo') }}</textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-paper-plane mr-1"></i> Enviar solicitud
                    </button>
                </div>
            </form>
        </div>
    </div>

    {{-- MODAL: AVISO DE PRIVACIDAD --}}
    <div class="modal fade" id="modalAvisoPrivacidad" tabindex="-1" role="dialog" aria-labelledby="modalAvisoPrivacidadLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="modalAvisoPrivacidadLabel">
                        <i class="fas fa-user-shield text-primary mr-1"></i> Aviso de Privacidad — Horas Extra
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    @include('app_redes.modulos.horas_extra.partials.aviso_privacidad')
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                </div>
            </div>
        </div>
    </div>

    @include('app_redes.modulos.horas_extra.partials.modal_inicio')
    @include('app_redes.modulos.horas_extra.partials.modal_fin')

    @endif
</div>
@stop

@section('js')
<script>
(function($) {
    if (!$) { return; }

    var csrfToken = $('meta[name="csrf-token"]').attr('content') || '';
    var urlInicioActual = '';
    var urlFinActual = '';

    function heObtenerUbicacion(cb) {
        if (!navigator.geolocation || (typeof window.isSecureContext !== 'undefined' && !window.isSecureContext)) {
            cb({ ubicacion_estado: 'no_disponible', latitud: '', longitud: '', precision_m: '' });
            return;
        }
        navigator.geolocation.getCurrentPosition(
            function(pos) {
                cb({
                    ubicacion_estado: 'concedida',
                    latitud: pos.coords.latitude,
                    longitud: pos.coords.longitude,
                    precision_m: pos.coords.accuracy ? Math.round(pos.coords.accuracy) : ''
                });
            },
            function(err) {
                var estado = (err && err.code === 1) ? 'denegada' : 'no_disponible';
                cb({ ubicacion_estado: estado, latitud: '', longitud: '', precision_m: '' });
            },
            { enableHighAccuracy: true, timeout: 10000, maximumAge: 0 }
        );
    }

    function heExtraerErrorAjax(xhr, fallback) {
        if (xhr && xhr.responseJSON) {
            if (xhr.responseJSON.message) { return xhr.responseJSON.message; }
            for (var k in xhr.responseJSON) {
                if (Object.prototype.hasOwnProperty.call(xhr.responseJSON, k) && $.isArray(xhr.responseJSON[k]) && xhr.responseJSON[k].length) {
                    return xhr.responseJSON[k][0];
                }
            }
        }
        return fallback || 'No se pudo completar la operación.';
    }

    $(document).on('click', '.btn-iniciar-he', function() {
        var $btn = $(this);
        urlInicioActual = $btn.data('url');
        $('#he-ini-id').text($btn.data('id'));
        $('#he-ini-horas').text($btn.data('horas'));
        $('#he-ini-modalidad').text($btn.data('modalidad'));
        $('#he-ini-motivo').text($btn.data('motivo'));
        $('#chkAceptaAviso').prop('checked', false);
        $('#estadoGeoInicio').addClass('d-none');
        $('#btnConfirmarInicio').prop('disabled', false);
        $('#modalInicioHorasExtra').modal('show');
    });

    $('#btnConfirmarInicio').on('click', function() {
        if (!$('#chkAceptaAviso').is(':checked')) {
            swal('Consentimiento requerido', 'Debes aceptar el aviso de privacidad antes de iniciar la sesión.', 'warning');
            return;
        }
        var $btn = $(this);
        $btn.prop('disabled', true);
        $('#estadoGeoInicio').removeClass('d-none');

        heObtenerUbicacion(function(geo) {
            $.ajax({
                url: urlInicioActual,
                type: 'POST',
                data: {
                    _token: csrfToken,
                    acepta_aviso: 1,
                    ubicacion_estado: geo.ubicacion_estado,
                    latitud: geo.latitud,
                    longitud: geo.longitud,
                    precision_m: geo.precision_m
                }
            }).done(function(resp) {
                $('#modalInicioHorasExtra').modal('hide');
                swal({
                    title: 'Sesión iniciada',
                    text: (resp && resp.message) ? resp.message : 'Tu sesión de horas extra está activa.',
                    icon: 'success'
                }).then(function() {
                    window.location.reload();
                });
            }).fail(function(xhr) {
                $btn.prop('disabled', false);
                $('#estadoGeoInicio').addClass('d-none');
                swal('No se pudo iniciar', heExtraerErrorAjax(xhr), 'error');
            });
        });
    });

    $(document).on('click', '.btn-finalizar-he', function() {
        urlFinActual = $(this).data('url');
        $('#txtResumenTrabajo').val('');
        $('#he-fin-chars').text('0');
        $('#inpEvidenciasFin').val('');
        $('#estadoGeoFin').addClass('d-none');
        $('#btnConfirmarFin').prop('disabled', false);
        $('#modalFinHorasExtra').modal('show');
    });

    $('#txtResumenTrabajo').on('input', function() {
        $('#he-fin-chars').text($(this).val().length);
    });

    $('#btnConfirmarFin').on('click', function() {
        var resumen = $.trim($('#txtResumenTrabajo').val() || '');
        if (resumen.length < 20) {
            swal('Resumen incompleto', 'Describe el trabajo realizado con al menos 20 caracteres.', 'warning');
            return;
        }
        var inputFiles = document.getElementById('inpEvidenciasFin');
        var maxFiles = {{ (int) config('horas_extra.evidencias_max', 5) }};
        if (inputFiles && inputFiles.files && inputFiles.files.length > maxFiles) {
            swal('Demasiados archivos', 'Puedes adjuntar máximo ' + maxFiles + ' archivos.', 'warning');
            return;
        }

        var $btn = $(this);
        $btn.prop('disabled', true);
        $('#estadoGeoFin').removeClass('d-none');

        heObtenerUbicacion(function(geo) {
            var fd = new FormData();
            fd.append('_token', csrfToken);
            fd.append('resumen_trabajo', resumen);
            fd.append('ubicacion_estado', geo.ubicacion_estado);
            fd.append('latitud', geo.latitud);
            fd.append('longitud', geo.longitud);
            fd.append('precision_m', geo.precision_m);

            if (inputFiles && inputFiles.files) {
                for (var i = 0; i < inputFiles.files.length; i++) {
                    fd.append('evidencias[]', inputFiles.files[i]);
                }
            }

            $.ajax({
                url: urlFinActual,
                type: 'POST',
                data: fd,
                processData: false,
                contentType: false
            }).done(function(resp) {
                $('#modalFinHorasExtra').modal('hide');
                swal({
                    title: 'Sesión finalizada',
                    text: (resp && resp.message) ? resp.message : 'Sesión enviada a validación.',
                    icon: 'success'
                }).then(function() {
                    window.location.reload();
                });
            }).fail(function(xhr) {
                $btn.prop('disabled', false);
                $('#estadoGeoFin').addClass('d-none');
                swal('Error al finalizar', heExtraerErrorAjax(xhr), 'error');
            });
        });
    });
})(window.jQuery);
</script>
@stop
