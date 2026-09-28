@extends('layouts.app_redes')

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
        background: #f8f9fa;
        border-radius: 6px;
        padding: 12px 16px;
        margin-bottom: 16px;
        border: 1px solid #dee2e6;
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
</style>
{{-- DateRangePicker CSS --}}
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop

@section('content')
<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-3">
        <h1 class="h3 mb-0 text-gray-800">
            <i class="fas fa-cube mr-2" style="color:#0948AF"></i> Órdenes de Taller
        </h1>
    </div>

    {{-- FILTROS DE FECHA --}}
    <form method="GET" action="{{ url('sb-admin/ordenes-taller') }}" class="filter-bar" id="form-filtros">
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
                    <a href="{{ url('sb-admin/ordenes-taller') }}" class="btn btn-outline-secondary btn-sm ml-1">
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

    {{-- TARJETA PRINCIPAL --}}
    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center accent-border"
            style="background:#fff;">
            <h6 class="m-0 font-weight-bold text-dark">
                Taller
                {{ $ordenes->count() }} ordenes
            </h6>
            <span class="text-muted small">
                {{ $ordenes->count() }} orden(es)
                &nbsp;|&nbsp; {{ $fecha_inicio }} al {{ $fecha_fin }}
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
                                <a href="javascript:void(0)" onclick="toggleOrden()" style="color: #fff; text-decoration: none; margin-left: 5px;" title="Ordenar fecha">
                                    <i class="fas fa-sort-{{ (isset($orden) && $orden == 'ASC') ? 'up' : 'down' }}"></i>
                                </a>
                            </th>
                            <th class="text-center">Estatus</th>
                            <th>Guía</th>
                            <th class="text-center" style="width: 15%">Progreso</th>
                            <th class="text-center">Orden</th>
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
                                <a href="{{ url('sb-admin/seguimineto/'.$orden->id_cotizacion) }}" target="_blank" class="font-weight-bold ml-1 text-primary">
                                    {{ $orden->cod_venta ?? '—' }}
                                </a>
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
                            <td class="text-center align-middle">
                                <a target="_blank" href="{{ url('sb-admin/orden-taller/'.$orden->id_cotizacion) }}"
                                    class="btn-ver-orden">
                                    <i class="fas fa-clipboard-list"></i> Ver Orden
                                </a>
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

    $(document).ready(function() {
        if ($.fn.DataTable.isDataTable('#tabla-ordenes-taller')) {
            $('#tabla-ordenes-taller').DataTable().destroy();
        }
        $('#tabla-ordenes-taller').DataTable({
            "ordering": false,
            "paging": false,
            "info": false,
            "searching": false
        });

        // Configuración de DateRangePicker
        var start = moment('{{ $fecha_inicio }}');
        var end = moment('{{ $fecha_fin }}');

        function cb(start, end) {
            $('#reportrange span').html(start.format('D [de] MMMM YYYY') + ' - ' + end.format('D [de] MMMM YYYY'));
            $('#fecha_inicio').val(start.format('YYYY-MM-DD'));
            $('#fecha_fin').val(end.format('YYYY-MM-DD'));
        }

        $('#reportrange').daterangepicker({
            startDate: start,
            endDate: end,
            ranges: {
               'Hoy': [moment(), moment()],
               'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
               'Últimos 15 días': [moment().subtract(14, 'days'), moment()],
               'Últimos 30 días': [moment().subtract(29, 'days'), moment()]
            },
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' - ',
                applyLabel: 'Actualizar',
                cancelLabel: 'Cancelar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }
        }, cb);

        cb(start, end);
    });

    function toggleOrden() {
        var form = document.getElementById('form-filtros');
        var inputOrden = document.getElementById('input_orden');
        
        if(inputOrden.value === 'DESC') {
            inputOrden.value = 'ASC';
        } else {
            inputOrden.value = 'DESC';
        }
        
        form.submit();
    }
</script>
@stop