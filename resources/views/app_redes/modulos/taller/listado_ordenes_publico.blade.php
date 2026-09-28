@extends('layouts.app_redes_public')

@section('css')
<style>
    /* Acento principal — solo donde importa */
    .accent-border {
        border-left: 4px solid #0948AF;
    }

    .btn-ver-orden {
        background: #fac800;
        color: #1d1919ff;
        border: none;
        padding: 4px 12px;
        font-size: 0.8rem;
        border-radius: 4px;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }

    .btn-ver-orden:hover {
        background: #073a8c;
        color: #fff;
        text-decoration: none;
    }

    .badge-cod {
        background: #042251ff;
        color: #fff;
        font-size: 0.76rem;
        padding: 3px 8px;
        border-radius: 10px;
    }

    .filter-bar {
        background: #fff;
        border-radius: 8px;
        padding: 20px 24px;
        margin-bottom: 24px;
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.15rem 1.75rem 0 rgba(58, 59, 69, 0.1);
    }

    .filter-bar label {
        font-size: 0.78rem;
        font-weight: 600;
        color: #495057;
        margin-bottom: 2px;
    }

    #tabla-ordenes-taller thead tr {
        background: #195dcc;
        color: #fff;
        border: none;
    }

    #tabla-ordenes-taller tbody tr:hover {
        background: #f0f4ff;
    }

    /* Estilos daterangepicker */
    .daterangepicker .ranges li.active {
        background-color: #0948AF;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover {
        background-color: #0948AF;
    }

    /* COMPRESIÓN PARA PANTALLAS PEQUEÑAS (Laptops) */
    #tabla-ordenes-taller th, #tabla-ordenes-taller td {
        padding: 0.6rem;
        vertical-align: middle;
        font-size: 0.95rem;
    }
    h1.text-gray-800 {
        font-size: 1.5rem !important;
    }

    /* ESTILOS DASHBOARD TV GIGANTE (Solo en pantallas anchas >= 1400px) */
    @media (min-width: 1400px) {
        html {
            font-size: max(16px, 0.9vw) !important;
        }
        h1.text-gray-800 {
            font-size: 2rem !important;
        }
        #tabla-ordenes-taller {
            font-size: 1.25rem;
        }
        #tabla-ordenes-taller th, #tabla-ordenes-taller td {
            padding: 1rem;
        }
        .badge {
            font-size: 1.1rem !important;
            padding: 0.5em 0.8em !important;
        }
        .progress {
            height: 22px !important;
            border-radius: 11px !important;
            background-color: #e9ecef !important;
        }
        .progress-bar {
            font-size: 1rem !important;
            line-height: 22px !important;
        }
        .text-center.align-middle small {
            font-size: 1.15rem;
        }
        .btn-ver-orden, .badge-cod {
            font-size: 1.1rem;
            padding: 6px 14px;
        }
    }
    /* ESTILOS DE TARJETAS DE RESUMEN */
    .summary-card {
        background: #fff;
        border-radius: 12px;
        padding: 16px;
        border: 1px solid #e3e6f0;
        box-shadow: 0 0.15rem 1.15rem 0 rgba(58, 59, 69, 0.08);
        transition: transform 0.2s ease-in-out, box-shadow 0.2s ease-in-out;
        display: flex;
        align-items: center;
        gap: 12px;
        height: 100%;
    }

    .summary-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 0.3rem 1.5rem 0 rgba(58, 59, 69, 0.15);
    }

    .icon-box {
        width: 42px;
        height: 42px;
        border-radius: 10px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.2rem;
        flex-shrink: 0;
    }

    .icon-pendiente { background: #f8f9fc; color: #858796; }
    .icon-iniciado { background: #fff9e6; color: #f6c23e; }
    .icon-terminado { background: #e6fffa; color: #1cc88a; }
    .icon-enviado { background: #eef2ff; color: #4e73df; }

    .summary-info .count {
        font-size: 1.4rem;
        font-weight: 700;
        color: #2e3b4e;
        line-height: 1.2;
    }

    .summary-info .label {
        font-size: 0.72rem;
        font-weight: 600;
        color: #858796;
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    /* Ajuste para pantallas grandes (TV) */
    @media (min-width: 1400px) {
        .summary-card { padding: 20px 24px; gap: 18px; }
        .icon-box { width: 56px; height: 56px; font-size: 1.6rem; }
        .summary-info .count { font-size: 2rem; }
        .summary-info .label { font-size: 0.85rem; }
    }
</style>
{{-- DateRangePicker CSS --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('content')
<div class="container-fluid p-2 p-md-3">

    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800 font-weight-bold" style="font-size: 2rem;">
            <i class="fas fa-cube mr-2" style="color:#0948AF"></i> Órdenes de Taller
        </h1>
    </div>

    {{-- FILAS DE RESUMEN --}}
    <div class="row mb-4">
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="summary-card">
                <div class="icon-box icon-pendiente" style="background: #f8f9fc; color: #858796;">
                    <i class="fas fa-clock"></i>
                </div>
                <div class="summary-info">
                    <div class="count">{{ $counts['pendientes'] }}</div>
                    <div class="label">Pendientes</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="summary-card">
                <div class="icon-box icon-iniciado" style="background: #fff9e6; color: #f6c23e;">
                    <i class="fas fa-play-circle"></i>
                </div>
                <div class="summary-info">
                    <div class="count">{{ $counts['iniciadas'] }}</div>
                    <div class="label">Iniciadas</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6 mb-3 mb-md-0">
            <div class="summary-card">
                <div class="icon-box icon-terminado" style="background: #e6fffa; color: #1cc88a;">
                    <i class="fas fa-check-circle"></i>
                </div>
                <div class="summary-info">
                    <div class="count">{{ $counts['terminadas'] }}</div>
                    <div class="label">Terminadas</div>
                </div>
            </div>
        </div>
        <div class="col-md-3 col-sm-6">
            <div class="summary-card">
                <div class="icon-box icon-enviado" style="background: #eef2ff; color: #4e73df;">
                    <i class="fas fa-truck-loading"></i>
                </div>
                <div class="summary-info">
                    <div class="count">{{ $counts['enviadas'] }}</div>
                    <div class="label">Enviadas</div>
                </div>
            </div>
        </div>
    </div>

    {{-- FILTROS DE FECHA (Ocultos temporalmente por petición) 
    <form method="GET" action="{{ url('ordenes-taller') }}" class="filter-bar" id="form-filtros">
        <div class="row align-items-end">
            <div class="col-md-5 col-sm-6 mb-2 mb-md-0">
                <label>Periodo de fecha</label>
                <div id="reportrange" class="form-control form-control-sm border-0 d-flex align-items-center justify-content-between" style="cursor: pointer; background: #fff; box-shadow: 0 1px 2px rgba(0,0,0,0.05);">
                    <span></span> <i class="fa fa-calendar ml-2 text-muted"></i>
                </div>
                <input type="hidden" name="fecha_inicio" id="fecha_inicio" value="{{ $fecha_inicio }}">
                <input type="hidden" name="fecha_fin" id="fecha_fin" value="{{ $fecha_fin }}">
                <input type="hidden" name="orden" id="input_orden" value="{{ $orden ?? 'DESC' }}">
            </div>
            <div class="col-md-3 mb-2 mb-md-0">
                <label>&nbsp;</label>
                <div>
                    <button type="submit" class="btn btn-success btn-sm">
                        <i class="fas fa-filter mr-1"></i> Actualizar
                    </button>
                    <a href="{{ url('ordenes-taller') }}" class="btn btn-outline-secondary btn-sm ml-1">
                        <i class="fas fa-undo mr-1"></i> Reset
                    </a>
                </div>
            </div>
            <div class="col-md-4">
                <label>Buscar</label>
                <input type="text" id="buscar_orden" class="form-control form-control-sm"
                    placeholder="Cliente o código de venta...">
            </div>
        </div>
    </form>
    --}}

    {{-- TARJETA PRINCIPAL --}}
    <div class="card shadow-sm mb-4" style="border-radius: 8px; border: 1px solid #e3e6f0;">
        <div class="card-header py-3 d-flex justify-content-between align-items-center accent-border"
            style="background:#fff; border-top-left-radius: 8px; border-top-right-radius: 8px; border-bottom: 1px solid #e3e6f0;">
            <h6 class="m-0 font-weight-bold text-dark">
                Taller
                {{ $ordenes->count() }} ordenes
            </h6>
            <span class="text-muted small">
                {{ $ordenes->count() }} orden(es)
            </span>
        </div>

        <div class="card-body p-0">
            @if($ordenes->isEmpty())
            <div class="alert alert-info m-3">
                <i class="fas fa-info-circle mr-2"></i>
                No hay ordenes de taller en el rango de fechas seleccionado.
            </div>
            @else
            <div class="table-responsive">
                <table class="table table-bordered table-hover mb-0" id="tabla-ordenes-taller">
                    <thead>
                        <tr>
                            <th class="text-center">#</th>
                            <th>Código Venta</th>
                            <th>Cotización</th>
                            <th>Cliente</th>
                            <th>Vendedor</th>
                            <th>
                                Fecha Venta
                            </th>
                            <th class="text-center">Estatus</th>
                            <th>Guía</th>
                            <th class="text-center" style="width: 15%">Progreso</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($ordenes as $orden)
                        <tr class="fila-orden"
                            data-buscar="{{ strtolower($orden->nombrecl) }} {{ strtolower($orden->cod_venta) }} {{ strtolower($orden->cod_cotizacion) }}">
                            <td class="text-center text-muted small">
                                @if(isset($orden->impreso) && $orden->impreso == 1)
                                    <i class="fas fa-print text-primary mr-1" title="Orden Impresa"></i>
                                @else
                                    <i class="fas fa-print text-gray-300 mr-1" title="Pendiente de Imprimir"></i>
                                @endif
                                {{ $orden->id_cotizacion }}
                            </td>
                            <td>
                                <span class="">{{ $orden->cod_venta ?? '—' }}</span>
                            </td>
                            <td><small class="text-muted">{{ $orden->cod_cotizacion }}</small></td>
                            <td><strong>{{ $orden->nombrecl }}</strong></td>
                            <td>{{ $orden->nombre_vendedor ?? '—' }}</td>
                            <td>{{ $orden->fecha_venta_formato ?? $orden->fecha_venta }}</td>
                            <td class="text-center">
                                @if(!isset($orden->estatus_taller) || $orden->estatus_taller == 0)
                                    <span class="badge badge-secondary">Pendiente</span>
                                @elseif($orden->estatus_taller == 1)
                                    <span class="badge badge-warning">Iniciado</span>
                                @elseif($orden->estatus_taller == 2)
                                    <span class="badge badge-success">Terminado</span>
                                @elseif($orden->estatus_taller == 3)
                                    <span class="badge badge-primary">Enviado</span>
                                @endif
                            </td>
                            <td>
                                @if(!empty($orden->numero_guia))
                                    @if(!empty($orden->enlace_guia))
                                        <a href="{{ $orden->enlace_guia }}" target="_blank" title="Seguir envío">
                                            <i class="fas fa-truck mr-1 text-primary"></i> {{ $orden->numero_guia }}
                                        </a>
                                    @else
                                        <span title="Sin enlace de rastreo">
                                            <i class="fas fa-truck mr-1 text-muted"></i> {{ $orden->numero_guia }}
                                        </span>
                                    @endif
                                @else
                                    <span class="text-muted small">Sin guía</span>
                                @endif
                            </td>
                            <td class="text-center align-middle">
                                <div class="progress" style="height: 12px; border-radius: 6px;">
                                    <div class="progress-bar {{ $orden->porcentaje == 100 ? 'bg-success' : 'bg-warning' }}" role="progressbar" style="width: {{ $orden->porcentaje }}%;" aria-valuenow="{{ $orden->porcentaje }}" aria-valuemin="0" aria-valuemax="100"></div>
                                </div>
                                <small class="text-muted font-weight-bold">{{ $orden->porcentaje }}%</small>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-3 py-2 text-muted small" id="contador-visible">
                Mostrando {{ $ordenes->count() }} orden(es)
            </div>
            @endif
        </div>
    </div>

</div>
@stop

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    /* Oculto temporalmente porque el input buscar_orden también está oculto
    document.getElementById('buscar_orden').addEventListener('keyup', function () {
        var filtro = this.value.toLowerCase().trim();
        var filas = document.querySelectorAll('.fila-orden');
        var visibles = 0;
        filas.forEach(function (fila) {
            var matched = fila.getAttribute('data-buscar').indexOf(filtro) !== -1;
            fila.style.display = matched ? '' : 'none';
            if (matched) visibles++;
        });
        var c = document.getElementById('contador-visible');
        if (c) c.textContent = 'Mostrando ' + visibles + ' orden(es)';
    });
    */

    $(document).ready(function() {
        
        // Auto-refresh cada 3 minutos (180,000 milisegundos)
        setTimeout(function(){
            window.location.reload();
        }, 180000);

        if ($.fn.DataTable.isDataTable('#tabla-ordenes-taller')) {
            $('#tabla-ordenes-taller').DataTable().destroy();
        }
        $('#tabla-ordenes-taller').DataTable({
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false
        });

        /* Configuración de DateRangePicker (Oculto temporalmente)
        var start = moment('');
        var end = moment('');

        function cb(start, end) {
            $('#reportrange span').html(start.format('D [de] MMMM YYYY') + ' - ' + end.format('D [de] MMMM YYYY'));
            $('#fecha_inicio').val(start.format('YYYY-MM-DD'));
            $('#fecha_fin').val(end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({ ... }, cb);
        cb(start, end);
        */
    });

    /* Funciones ocultas temporalmente
    function toggleOrden() { ... }
    */
</script>
@stop