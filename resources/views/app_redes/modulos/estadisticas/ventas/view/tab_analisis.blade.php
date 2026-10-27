{{-- ========================================================================= --}}
{{-- PESTAÑA: ANÁLISIS COMERCIAL (FASES 1, 2 Y 3)                              --}}
{{-- ========================================================================= --}}

<div class="mb-4">
    {{-- ALERTA AUTOMÁTICA DE PIPELINE ABIERTO (FASE 3 - Comentada temporalmente por solicitud del usuario) --}}
    {{--
    <div id="an_alertaPipelineContainer" class="alert alert-warning border-left-warning shadow-sm mb-4" style="{{ $analisis['alertaPipeline'] ? '' : 'display: none;' }}; border-radius: 12px; border-left: 5px solid #f59e0b !important;">
        <div class="d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center">
                <i class="fas fa-exclamation-triangle fa-2x text-warning mr-3"></i>
                <div>
                    <h6 class="font-weight-bold text-gray-800 mb-1">
                        Atención Comercial: Pipeline Abierto Elevado
                    </h6>
                    <p class="mb-0 text-muted small">
                        Existe un volumen de <strong class="text-dark" id="an_txtAlertPipelineVal">${{ $analisis['pipelineAbiertoValor'] }}</strong> en cotizaciones sin cerrar (<span id="an_txtAlertRatio" class="font-weight-bold text-warning">{{ $analisis['ratioPipelineVentas'] }}x</span> veces las ventas cerradas). Se recomienda reactivar el seguimiento comercial con los prospectos.
                    </p>
                </div>
            </div>
            <span class="badge badge-warning font-weight-bold px-3 py-2 mt-2 mt-md-0" style="font-size: 11px;">
                <i class="fas fa-bullhorn mr-1"></i> Seguimiento Requerido
            </span>
        </div>
    </div>
    --}}

    {{-- 1. HEADER DE LA SECCIÓN DE ANÁLISIS --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 pb-2 border-bottom">
        <div>
            <h5 class="font-weight-bold text-gray-800 mb-1">
                <i class="fas fa-chart-pie text-primary mr-2"></i>Análisis Comercial y Salud del Negocio
            </h5>
            <p class="text-muted small mb-0">
                Embudo de conversión, salud logística, proyección al cierre y comparativa histórica.
            </p>
        </div>
        <div class="mt-2 mt-md-0 d-flex align-items-center flex-wrap" style="gap: 6px;">
            <span class="badge badge-light border px-3 py-2 text-muted font-weight-bold small mr-1">
                <i class="fas fa-calendar-alt text-primary mr-1"></i> Período: <span id="an_badgeDias">{{ $analisis['dias'] }}</span> días
            </span>
            <button type="button" class="btn btn-sm btn-primary rounded-pill px-3 font-weight-bold mr-1" data-toggle="modal" data-target="#modalRegistroLeads">
                <i class="fas fa-bullhorn mr-1"></i> Registrar Leads
            </button>
            {{-- Botón Metas comentado temporalmente
            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill px-3 font-weight-bold mr-1" data-toggle="modal" data-target="#modalConfigUmbrales" title="Configurar metas y umbrales de semáforos">
                <i class="fas fa-sliders-h mr-1"></i> Metas
            </button>
            --}}
            <button type="button" class="btn btn-sm btn-outline-success rounded-pill px-3 font-weight-bold mr-1" onclick="exportarAnalisisExcel()" title="Descargar reporte en Excel">
                <i class="fas fa-file-excel mr-1"></i> Excel
            </button>
            <button type="button" class="btn btn-sm btn-outline-info rounded-pill px-3 font-weight-bold" onclick="window.print()" title="Imprimir reporte ejecutivo">
                <i class="fas fa-print mr-1"></i> Imprimir
            </button>
        </div>
    </div>

    {{-- BARRA RESUMEN DE SEMÁFOROS COMERCIALES (FASE 3 - Comentada temporalmente por solicitud del usuario) --}}
    {{--
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 14px; background: #ffffff;">
        <div class="card-body p-3">
            <div class="d-flex align-items-center justify-content-between flex-wrap pb-2 mb-2 border-bottom">
                <div class="d-flex align-items-center">
                    <span class="mr-2" style="font-size: 1.25rem;">🚦</span>
                    <div>
                        <strong class="text-gray-800" style="font-size: 0.95rem;">Semáforos de Desempeño Comercial</strong>
                        <span class="text-muted small ml-2 d-none d-md-inline">Monitoreo en tiempo real contra metas de conversión y rentabilidad.</span>
                    </div>
                </div>
                <button type="button" class="btn btn-sm btn-link text-primary font-weight-bold p-0" data-toggle="modal" data-target="#modalConfigUmbrales" style="font-size: 0.85rem; text-decoration: none;">
                    <i class="fas fa-sliders-h mr-1"></i> Configurar Metas
                </button>
            </div>
            <div class="row">
                <div class="col-md-4 mb-2 mb-md-0 border-right">
                    <div class="p-2 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold d-block">
                                <i class="fas fa-bullseye text-primary mr-1"></i> Cierre (Cotiz. → Venta)
                            </span>
                            <span class="h5 font-weight-bold mb-0 text-dark" id="an_semBarVentasVal">{{ $analisis['tasaConversion'] }}%</span>
                            <small class="text-muted ml-1" id="an_semBarVentasTarget">(Meta &ge; {{ $analisis['umbrales']['umb_conv_verde'] }}%)</small>
                        </div>
                        <div>
                            @php
                                $clsConv = $analisis['statusConversion'] == 'verde' ? 'badge-success' : ($analisis['statusConversion'] == 'amarillo' ? 'badge-warning' : 'badge-danger');
                            @endphp
                            <span class="badge {{ $clsConv }} px-2 py-1 font-weight-bold" id="an_semBarVentasBadge" style="font-size: 11px;">
                                {{ $analisis['badgeConversion'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4 mb-2 mb-md-0 border-right">
                    <div class="p-2 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold d-block">
                                <i class="fas fa-comments text-info mr-1"></i> Prospección (Leads → Cotiz.)
                            </span>
                            <span class="h5 font-weight-bold mb-0 text-dark" id="an_semBarLeadsVal">{{ $analisis['hasLeads'] ? $analisis['leadToCotizacion'] . '%' : '-' }}</span>
                            <small class="text-muted ml-1" id="an_semBarLeadsTarget">(Meta &ge; {{ $analisis['umbrales']['umb_lead_conv_verde'] }}%)</small>
                        </div>
                        <div>
                            @php
                                $clsLead = $analisis['statusLeadConversion'] == 'verde' ? 'badge-success' : ($analisis['statusLeadConversion'] == 'amarillo' ? 'badge-warning' : ($analisis['statusLeadConversion'] == 'rojo' ? 'badge-danger' : 'badge-light border text-muted'));
                            @endphp
                            <span class="badge {{ $clsLead }} px-2 py-1 font-weight-bold" id="an_semBarLeadsBadge" style="font-size: 11px;">
                                {{ $analisis['badgeLeadConversion'] }}
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="p-2 d-flex align-items-center justify-content-between">
                        <div>
                            <span class="text-muted small font-weight-bold d-block">
                                <i class="fas fa-truck-loading text-success mr-1"></i> Cobertura Logística
                            </span>
                            <span class="h5 font-weight-bold mb-0 text-dark" id="an_semBarCobVal">{{ $analisis['coberturaLogistica'] }}%</span>
                            <small class="text-muted ml-1" id="an_semBarCobTarget">(Meta &ge; {{ $analisis['umbrales']['umb_cobertura_verde'] }}%)</small>
                        </div>
                        <div>
                            @php
                                $clsCob = $analisis['statusCobertura'] == 'verde' ? 'badge-success' : ($analisis['statusCobertura'] == 'amarillo' ? 'badge-warning' : 'badge-danger');
                            @endphp
                            <span class="badge {{ $clsCob }} px-2 py-1 font-weight-bold" id="an_semBarCobBadge" style="font-size: 11px;">
                                {{ $analisis['badgeCobertura'] }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    --}}

    {{-- 2. TARJETAS KPI ESTRATÉGICAS (FILA 1) --}}
    <div class="row mb-4">
        {{-- KPI 1: Cotización -> Venta con Semáforo --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-primary h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <div class="d-flex align-items-center justify-content-between">
                            <p class="stat-label mb-0">Cotización → Venta</p>
                            {{-- Badge semáforo comentado temporalmente
                            @php
                                $badgeCls = $analisis['statusConversion'] == 'verde' ? 'badge-success' : ($analisis['statusConversion'] == 'amarillo' ? 'badge-warning' : 'badge-danger');
                            @endphp
                            <span class="badge {{ $badgeCls }} font-weight-bold" id="an_badgeSemConversion" style="font-size: 10px; border-radius: 999px;">
                                {{ $analisis['badgeConversion'] }}
                            </span>
                            --}}
                        </div>
                        <p id="an_tasaConversion" class="stat-value text-primary">{{ $analisis['tasaConversion'] }}%</p>
                        <p class="stat-sublabel" id="an_subConversion">
                            <span class="font-weight-bold text-dark" id="an_txtVentasNum">{{ number_format($analisis['numeroVentas']) }}</span> cerradas de <span id="an_txtCotisNum">{{ number_format($analisis['numCotizaciones']) }}</span> cotizadas
                        </p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-bullseye"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI 2: Ticket Promedio --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-warning h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Ticket Promedio</p>
                        <p id="an_ticketPromedio" class="stat-value text-warning">${{ $analisis['ticketPromedio'] }}</p>
                        <p class="stat-sublabel">Importe medio por venta cerrada</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-receipt"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI 3: Ritmo Diario de Ventas --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-success h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Ritmo de Ventas</p>
                        <p class="stat-value text-success">
                            <span id="an_ventasPorDia">{{ $analisis['ventasPorDia'] }}</span> <small style="font-size: 0.55em;" class="text-muted">vtas/día</small>
                        </p>
                        <p class="stat-sublabel" id="an_subRitmo">
                            Cotizando <span class="font-weight-bold text-dark" id="an_cotizacionesPorDia">{{ $analisis['cotizacionesPorDia'] }}</span> cotis/día
                        </p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                </div>
            </div>
        </div>

        {{-- KPI 4: Neto Diario Generado --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-hero h-100">
                <div class="card-body">
                    <div class="stat-meta">
                        <div class="d-flex align-items-center mb-1">
                            <span class="badge badge-light text-success font-weight-bold small px-2 py-0">
                                <i class="fas fa-bolt mr-1"></i>Generación Diaria
                            </span>
                        </div>
                        <p class="stat-label">Ingreso Neto Diario</p>
                        <p class="stat-value">
                            <span id="an_netoPorDia">${{ $analisis['netoPorDia'] }}</span> <small style="font-size: 0.5em;" class="text-white-50">/día</small>
                        </p>
                        <p class="stat-sublabel text-white-50" id="an_subNetoVenta">
                            $<span id="an_netoPorVenta">{{ $analisis['netoPorVenta'] }}</span> neto por venta
                        </p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 3. FILA 2: EMBUDO COMERCIAL Y SALUD LOGÍSTICA --}}
    <div class="row mb-4">
        {{-- Columna Izquierda: Embudo de Conversión Comercial --}}
        <div class="col-lg-6 mb-4 mb-lg-0">
            <div class="card shadow-sm border-0 rounded-lg h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-filter text-primary mr-2"></i>Embudo de Conversión Comercial
                    </h6>
                    <span class="badge badge-light border text-muted small">Paso a paso</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    <div>
                        {{-- Etapa 0: Leads / Conversaciones Recibidas (Fase 2 / Entrada inicial) --}}
                        <div class="mb-3" id="an_secLeadsContainer">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold text-gray-800 small">
                                    <i class="fas fa-comments text-info mr-1"></i> 0. Leads / Conversaciones Iniciadas
                                </span>
                                <span class="small font-weight-bold text-dark" id="an_funnelLeadsTxt">
                                    @if ($analisis['hasLeads'])
                                        <span id="an_funnelLeadsNum">{{ number_format($analisis['leads']) }}</span> prospectos
                                        <a href="#" class="text-primary ml-1" data-toggle="modal" data-target="#modalRegistroLeads" title="Editar leads"><i class="fas fa-edit"></i></a>
                                    @else
                                        <span class="text-muted font-weight-normal">No capturados en el mes</span>
                                        <button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 ml-1" data-toggle="modal" data-target="#modalRegistroLeads" style="font-size: 11px;">
                                            <i class="fas fa-plus"></i> Registrar
                                        </button>
                                    @endif
                                </span>
                            </div>
                            <div class="progress" style="height: 22px; border-radius: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-info" id="an_barLeads" role="progressbar" style="width: 100%; font-size: 11px; font-weight: bold;">
                                    <span id="an_barLeadsTxt">{{ $analisis['hasLeads'] ? number_format($analisis['leads']) . ' Leads (Base de Prospección)' : 'Sin captura de leads' }}</span>
                                </div>
                            </div>
                        </div>

                        {{-- Tasa intermedia 0: Lead -> Cotización --}}
                        <div class="d-flex align-items-center justify-content-center my-2 text-muted small flex-wrap" id="an_funnelLeadRates">
                            <i class="fas fa-arrow-down text-info mr-1"></i>
                            Conversión Lead → Cotización:
                            <strong class="ml-1 mr-2 text-dark" id="an_funnelLeadConvRate">
                                {{ $analisis['hasLeads'] ? $analisis['leadToCotizacion'] . '%' : '-' }}
                            </strong>
                            {{-- Badge semáforo comentado temporalmente
                            <span class="badge {{ $leadBadgeCls }}" id="an_badgeLeadSem" style="font-size: 9.5px; border-radius: 999px;">
                                {{ $analisis['badgeLeadConversion'] }}
                            </span>
                            --}}
                            <span class="mx-2">·</span>
                            Lead → Venta:
                            <strong class="text-dark ml-1" id="an_funnelLeadVtaRate">
                                {{ $analisis['hasLeads'] ? $analisis['leadToVenta'] . '%' : '-' }}
                            </strong>
                        </div>

                        {{-- Etapa 1: Cotizaciones --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold text-gray-800 small">
                                    <i class="fas fa-file-invoice text-primary mr-1"></i> 1. Cotizaciones Creadas
                                </span>
                                <span class="small font-weight-bold text-dark">
                                    <span id="an_funnelCotisNum">{{ number_format($analisis['numCotizaciones']) }}</span> cotizaciones (<span id="an_funnelCotisVal">${{ $analisis['totalCotizaciones'] }}</span>)
                                </span>
                            </div>
                            <div class="progress" style="height: 22px; border-radius: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-primary" role="progressbar" style="width: 100%; font-size: 11px; font-weight: bold;">
                                    100% Volumen Cotizado
                                </div>
                            </div>
                        </div>

                        {{-- Tasa intermedia 1: Cotización -> Venta --}}
                        <div class="d-flex align-items-center justify-content-center my-2 text-muted small flex-wrap">
                            <i class="fas fa-arrow-down text-primary mr-1"></i>
                            Tasa de éxito comercial: <strong class="text-primary ml-1" id="an_funnelConvRate">{{ $analisis['tasaConversion'] }}%</strong>
                            <span class="mx-2">·</span>
                            Conversión en valor ($): <strong class="text-success ml-1" id="an_funnelValRate">{{ $analisis['conversionValor'] }}%</strong>
                        </div>

                        {{-- Etapa 2: Ventas Concretadas --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold text-gray-800 small">
                                    <i class="fas fa-shopping-cart text-success mr-1"></i> 2. Ventas Concretadas (Facturación Bruta)
                                </span>
                                <span class="small font-weight-bold text-dark">
                                    <span id="an_funnelVentasNum">{{ number_format($analisis['numeroVentas']) }}</span> ventas (<span id="an_funnelVentasVal">${{ $analisis['totalVentas'] }}</span>)
                                </span>
                            </div>
                            @php
                                $wVtas = max(5, min(100, (float)$analisis['tasaConversion']));
                            @endphp
                            <div class="progress" style="height: 22px; border-radius: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar bg-success" id="an_barVentas" role="progressbar" style="width: {{ $wVtas }}%; font-size: 11px; font-weight: bold;">
                                    {{ $analisis['tasaConversion'] }}%
                                </div>
                            </div>
                        </div>

                        {{-- Tasa intermedia 2: Margen Neto y Deducciones --}}
                        <div class="d-flex align-items-center justify-content-center my-2 text-muted small flex-wrap">
                            <i class="fas fa-arrow-down text-success mr-1"></i>
                            Margen Neto de la Venta: <strong class="text-success ml-1" id="an_funnelMargenRate">{{ $analisis['margenNetoPct'] }}%</strong>
                            <span class="mx-2">·</span>
                            Deducciones (IVA + Paq): <strong class="text-danger ml-1" id="an_funnelDedRate">{{ round($analisis['ivaPct'] + $analisis['paqueteriaPct'], 1) }}%</strong>
                        </div>

                        {{-- Etapa 3: Venta Neta Disponible --}}
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span class="font-weight-bold text-gray-800 small">
                                    <i class="fas fa-wallet text-teal mr-1"></i> 3. Venta Neta Efectiva Disponible
                                </span>
                                <span class="small font-weight-bold text-success" id="an_funnelNetoVal">
                                    ${{ $analisis['totalNeto'] }}
                                </span>
                            </div>
                            @php
                                $wNeto = max(5, min(100, (float)$analisis['margenNetoPct']));
                            @endphp
                            <div class="progress" style="height: 22px; border-radius: 8px; background-color: #f1f5f9;">
                                <div class="progress-bar" id="an_barNeto" role="progressbar" style="width: {{ $wNeto }}%; font-size: 11px; font-weight: bold; background: linear-gradient(135deg, #059669 0%, #10b981 100%);">
                                    {{ $analisis['margenNetoPct'] }}% del bruto
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Pipeline Abierto Footer --}}
                    <div class="p-3 mt-2 rounded bg-light border d-flex align-items-center justify-content-between flex-wrap">
                        <div class="d-flex align-items-center">
                            <div class="mr-3 text-warning" style="font-size: 1.5rem;">
                                <i class="fas fa-hourglass-half"></i>
                            </div>
                            <div>
                                <span class="font-weight-bold text-dark small d-block">Pipeline Abierto por Cerrar</span>
                                <span class="text-muted small">Cotizaciones que aún no se han concretado en este periodo</span>
                            </div>
                        </div>
                        <div class="text-right mt-2 mt-sm-0">
                            <span class="h6 font-weight-bold text-gray-800 mb-0 d-block" id="an_pipelineVal">${{ $analisis['pipelineAbiertoValor'] }}</span>
                            <span class="small text-muted" id="an_pipelineCant">{{ number_format($analisis['pipelineAbiertoCant']) }} cotizaciones</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Columna Derecha: Control de Logística y Paquetería con Semáforos --}}
        <div class="col-lg-6">
            <div class="card shadow-sm border-0 rounded-lg h-100" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-truck-loading text-info mr-2"></i>Salud Logística (Cobro vs Costo Real)
                    </h6>
                    <span class="badge badge-light border text-muted small">Fletes y Paqueterías</span>
                </div>
                <div class="card-body p-4 d-flex flex-column justify-content-between">
                    {{-- Comparativa Mini Cards --}}
                    <div class="row mb-3">
                        <div class="col-6">
                            <div class="p-3 rounded border text-center" style="background: #f8fafc;">
                                <span class="text-muted small text-uppercase font-weight-bold d-block mb-1">
                                    <i class="fas fa-user-check text-primary mr-1"></i> Cobrado al Cliente
                                </span>
                                <h5 class="font-weight-bold text-primary mb-0" id="an_logEnvios">${{ $analisis['totalEnvios'] }}</h5>
                                <span class="text-muted" style="font-size: 0.75rem;">Flete facturado</span>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="p-3 rounded border text-center" style="background: #f8fafc;">
                                <span class="text-muted small text-uppercase font-weight-bold d-block mb-1">
                                    <i class="fas fa-boxes text-warning mr-1"></i> Pagado a Transportista
                                </span>
                                <h5 class="font-weight-bold text-warning mb-0" id="an_logPaq">${{ $analisis['totalEnviosPaqueteria'] }}</h5>
                                <span class="text-muted" style="font-size: 0.75rem;">Costo operativo real</span>
                            </div>
                        </div>
                    </div>

                    {{-- Indicadores Clave de Logística --}}
                    <div class="row mb-3">
                        {{-- Superávit Logístico --}}
                        <div class="col-md-6 mb-3 mb-md-0">
                            <div class="p-3 rounded border h-100 d-flex flex-column justify-content-between" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold text-success">
                                        <i class="fas fa-hand-holding-usd mr-1"></i> Superávit Logístico
                                    </span>
                                    @php
                                        $esSuperavit = (float)$analisis['superavitLogisticoRaw'] >= 0;
                                    @endphp
                                    <span class="badge {{ $esSuperavit ? 'badge-success' : 'badge-danger' }}" id="an_badgeSuperavit">
                                        {{ $esSuperavit ? 'Margen a favor' : 'Déficit logístico' }}
                                    </span>
                                </div>
                                <h4 class="font-weight-bold mb-1 {{ $esSuperavit ? 'text-success' : 'text-danger' }}" id="an_superavitLog">
                                    ${{ $analisis['superavitLogistico'] }}
                                </h4>
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    Diferencia neta entre lo cobrado al cliente y lo pagado a transportistas.
                                </small>
                            </div>
                        </div>

                        {{-- Cobertura Logística (Fase 1) --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded border h-100 d-flex flex-column justify-content-between" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold text-primary">
                                        <i class="fas fa-shield-alt mr-1"></i> Cobertura Logística
                                    </span>
                                    {{-- Badge semáforo comentado temporalmente
                                    @php
                                        $cobCls = $analisis['statusCobertura'] == 'verde' ? 'badge-success' : ($analisis['statusCobertura'] == 'amarillo' ? 'badge-warning' : 'badge-danger');
                                    @endphp
                                    <span class="badge {{ $cobCls }}" id="an_badgeCobertura">
                                        {{ $analisis['badgeCobertura'] }}
                                    </span>
                                    --}}
                                </div>
                                <h4 class="font-weight-bold text-primary mb-1" id="an_coberturaLog">
                                    {{ $analisis['coberturaLogistica'] }}%
                                </h4>
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    Relación entre lo cobrado al cliente y lo pagado a transportistas.
                                </small>
                            </div>
                        </div>
                    </div>

                    {{-- Explicación Operativa --}}
                    <div class="p-3 rounded bg-light border text-muted small">
                        <i class="fas fa-info-circle text-info mr-1"></i>
                        <strong>Regla de negocio:</strong> Los fletes cobrados al cliente forman parte de la facturación bruta. Cuando la cobertura supera el <strong>100%</strong>, el excedente se convierte en utilidad neta para la empresa.
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- 4. FILA 3: PROYECCIÓN LINEAL AL CIERRE DE MES --}}
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h6 class="m-0 font-weight-bold text-gray-800">
                    <i class="fas fa-magic text-purple mr-2" style="color: #8b5cf6;"></i>Proyección Lineal al Cierre de Mes
                </h6>
                <span class="small text-muted">Estimación proporcional basada en el ritmo diario actual (Días Mes / Días Transcurridos)</span>
            </div>
            <div class="mt-2 mt-md-0" id="an_proyeccionBadgeContainer">
                @if ($analisis['mostrarProyeccion'])
                    <span class="badge text-white px-3 py-2 font-weight-bold" style="background: #8b5cf6; border-radius: 20px;" id="an_proyBadge">
                        <i class="fas fa-calendar-day mr-1"></i> Día {{ $analisis['diasTranscurridos'] }} de {{ $analisis['diasMes'] }} · Factor: {{ $analisis['factorProyeccion'] }}x
                    </span>
                @else
                    <span class="badge badge-light border text-muted px-3 py-2" id="an_proyBadge">
                        <i class="fas fa-info-circle mr-1"></i> Requiere inicio en día 1 de mes
                    </span>
                @endif
            </div>
        </div>
        <div class="card-body p-4">
            <div id="an_proyeccionActiva" style="{{ $analisis['mostrarProyeccion'] ? '' : 'display: none;' }}">
                <div class="row">
                    {{-- Proyección 1: Ventas en Cantidad --}}
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="p-3 rounded border text-center h-100" style="background: #faf5ff; border-color: #e9d5ff !important;">
                            <span class="text-uppercase small font-weight-bold d-block mb-1" style="color: #7c3aed;">
                                <i class="fas fa-shopping-bag mr-1"></i> Ventas Proyectadas
                            </span>
                            <h3 class="font-weight-bold mb-1" style="color: #6d28d9;" id="an_proyVentas">
                                {{ $analisis['proyVentas'] }}
                            </h3>
                            <span class="small text-muted">
                                Acumulado actual: <strong class="text-dark" id="an_proyVentasActual">{{ $analisis['numeroVentas'] }}</strong> ventas
                            </span>
                        </div>
                    </div>

                    {{-- Proyección 2: Facturación Bruta --}}
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="p-3 rounded border text-center h-100" style="background: #eff6ff; border-color: #bfdbfe !important;">
                            <span class="text-uppercase small font-weight-bold text-primary d-block mb-1">
                                <i class="fas fa-dollar-sign mr-1"></i> Ventas Brutas Proyectadas
                            </span>
                            <h3 class="font-weight-bold text-primary mb-1" id="an_proyBruto">
                                ${{ $analisis['proyVentasBrutas'] }}
                            </h3>
                            <span class="small text-muted">
                                Acumulado actual: <strong class="text-dark" id="an_proyBrutoActual">${{ $analisis['totalVentas'] }}</strong>
                            </span>
                        </div>
                    </div>

                    {{-- Proyección 3: Venta Neta --}}
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="p-3 rounded border text-center h-100" style="background: #f0fdf4; border-color: #bbf7d0 !important;">
                            <span class="text-uppercase small font-weight-bold text-success d-block mb-1">
                                <i class="fas fa-coins mr-1"></i> Venta Neta Proyectada
                            </span>
                            <h3 class="font-weight-bold text-success mb-1" id="an_proyNeto">
                                ${{ $analisis['proyVentaNeta'] }}
                            </h3>
                            <span class="small text-muted">
                                Acumulado actual: <strong class="text-dark" id="an_proyNetoActual">${{ $analisis['totalNeto'] }}</strong>
                            </span>
                        </div>
                    </div>

                    {{-- Proyección 4: Cotizaciones Creadas --}}
                    <div class="col-xl-3 col-md-6 mb-3">
                        <div class="p-3 rounded border text-center h-100" style="background: #fffbeb; border-color: #fde68a !important;">
                            <span class="text-uppercase small font-weight-bold text-warning d-block mb-1">
                                <i class="fas fa-file-invoice mr-1"></i> Cotizaciones Proyectadas
                            </span>
                            <h3 class="font-weight-bold text-warning mb-1" id="an_proyCotis">
                                {{ $analisis['proyCotizaciones'] }}
                            </h3>
                            <span class="small text-muted">
                                Acumulado actual: <strong class="text-dark" id="an_proyCotisActual">{{ $analisis['numCotizaciones'] }}</strong> cotis
                            </span>
                        </div>
                    </div>
                </div>
                <div class="text-muted small mt-2">
                    <i class="fas fa-info-circle mr-1"></i>
                    <strong>Nota metodológica:</strong> La proyección supone un ritmo lineal constante hasta el último día del mes. No proyecta porcentajes de conversión ni ticket promedio, los cuales se conservan en su valor medio real.
                </div>
            </div>

            <div id="an_proyeccionDisabled" style="{{ $analisis['mostrarProyeccion'] ? 'display: none;' : '' }}">
                <div class="p-4 text-center rounded bg-light border">
                    <div class="text-muted mb-2" style="font-size: 2rem;">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <h6 class="font-weight-bold text-gray-800">Proyección disponible al filtrar mes en curso</h6>
                    <p class="text-muted small mb-3 max-w-md mx-auto" style="max-width: 500px;">
                        Para calcular la proyección lineal al cierre, el filtro de fechas debe iniciar el día <strong>1 del mes</strong> y encontrarse dentro del mismo mes antes de su conclusión.
                    </p>
                    <button type="button" class="btn btn-sm btn-outline-primary font-weight-bold" id="btnFiltrarEsteMesAnalisis">
                        <i class="fas fa-filter mr-1"></i> Filtrar este mes (Día 1 a hoy)
                    </button>
                </div>
            </div>
        </div>
    </div>

    {{-- 5. FILA 4: TABLA COMPARATIVA MENSUAL HISTÓRICA CON LEADS Y SEMÁFOROS (FASE 3) --}}
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h6 class="m-0 font-weight-bold text-gray-800">
                    <i class="fas fa-history text-primary mr-2"></i>Comparativa Mensual Histórica (Últimos 6 Meses)
                </h6>
                <span class="small text-muted">Auditoría con leads, semáforos de conversión y variaciones de ticket y venta neta</span>
            </div>
            <span class="badge badge-light border text-muted small mt-2 mt-md-0">Auditoría continua</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablaComparativaAnalisis">
                    <thead class="bg-light">
                        <tr class="small font-weight-bold text-muted text-uppercase">
                            <th>Mes</th>
                            <th class="text-center">Leads</th>
                            <th class="text-center">Cotizaciones</th>
                            <th class="text-center">Ventas</th>
                            <th class="text-center">Conversión</th>
                            <th class="text-right">Ticket Promedio</th>
                            <th class="text-right">Facturación Bruta</th>
                            <th class="text-right">Venta Neta</th>
                            <th class="text-right">Neto / Día</th>
                            <th class="text-center">Variación Neto</th>
                        </tr>
                    </thead>
                    <tbody id="an_tbodyComparativa">
                        @forelse ($analisis['comparativa'] as $fila)
                            <tr class="{{ $fila['es_mes_actual'] ? 'table-primary font-weight-bold' : '' }}">
                                <td>
                                    <strong>{{ $fila['nombre_mes'] }}</strong>
                                    @if ($fila['es_mes_actual'])
                                        <span class="badge badge-primary ml-1" style="font-size: 9.5px;">En curso</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    @if ($fila['leads_count'] > 0)
                                        <span class="font-weight-bold text-info">{{ number_format($fila['leads_count']) }}</span>
                                        @if ($fila['conv_leads_pct'] !== null)
                                            <small class="text-muted d-block">{{ $fila['conv_leads_pct'] }}% cotizan</small>
                                        @endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                                <td class="text-center">
                                    {{ number_format($fila['cotizaciones_count']) }}
                                    <small class="text-muted d-block">${{ $fila['total_cotizado'] }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success px-2 py-1">{{ number_format($fila['ventas_count']) }}</span>
                                </td>
                                <td class="text-center">
                                    @php
                                        $semCls = $fila['status_conversion'] == 'verde' ? 'text-success' : ($fila['status_conversion'] == 'amarillo' ? 'text-warning' : 'text-danger');
                                    @endphp
                                    <span class="font-weight-bold {{ $semCls }}">
                                        {{ $fila['conversion_pct'] }}%
                                    </span>
                                </td>
                                <td class="text-right">
                                    ${{ $fila['ticket_promedio'] }}
                                    @if ($fila['var_ticket'] !== null)
                                        <small class="d-block font-weight-bold {{ $fila['status_ticket_var'] == 'verde' ? 'text-success' : ($fila['status_ticket_var'] == 'amarillo' ? 'text-warning' : 'text-danger') }}">
                                            {{ $fila['var_ticket'] > 0 ? '+' : '' }}{{ $fila['var_ticket'] }}%
                                        </small>
                                    @endif
                                </td>
                                <td class="text-right font-weight-bold text-gray-800">${{ $fila['total_bruto'] }}</td>
                                <td class="text-right font-weight-bold text-success">${{ $fila['total_neto'] }}</td>
                                <td class="text-right text-muted">${{ $fila['neto_por_dia'] }}</td>
                                <td class="text-center">
                                    @if ($fila['var_neto'] !== null)
                                        @if ($fila['var_neto'] > 0)
                                            <span class="badge badge-success font-weight-bold">
                                                <i class="fas fa-arrow-up mr-1"></i>+{{ $fila['var_neto'] }}%
                                            </span>
                                        @elseif ($fila['var_neto'] < 0)
                                            <span class="badge badge-danger font-weight-bold">
                                                <i class="fas fa-arrow-down mr-1"></i>{{ $fila['var_neto'] }}%
                                            </span>
                                        @else
                                            <span class="badge badge-secondary">0.0%</span>
                                        @endif
                                    @else
                                        <span class="text-muted small">-</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="10" class="text-center py-4 text-muted">
                                    No hay registros históricos disponibles para el comparativo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 6. FILA 5: BANNER INFORMATIVO META ADS --}}
    <div class="card border-0 rounded-lg shadow-sm" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #3b82f6 !important; border-radius: 14px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3 text-primary" style="font-size: 2rem;">
                    <i class="fab fa-facebook-square"></i>
                </div>
                <div>
                    <h6 class="font-weight-bold text-gray-800 mb-1">
                        Próximamente: Atribución Automática con Meta Ads
                    </h6>
                    <p class="text-muted small mb-0">
                        Espacio preparado para sincronización automática de campañas, costo por lead (CPL), gasto publicitario diario en pesos y ROAS.
                    </p>
                </div>
            </div>
            <div>
                <span class="badge badge-primary px-3 py-2 font-weight-bold small">
                    <i class="fas fa-clock mr-1"></i> Próximamente
                </span>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 1: REGISTRO MANUAL DE LEADS POR MES                                 --}}
{{-- ========================================================================= --}}
<div class="modal fade" id="modalRegistroLeads" tabindex="-1" role="dialog" aria-labelledby="modalRegistroLeadsLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-gray-800" id="modalRegistroLeadsLabel">
                    <i class="fas fa-bullhorn text-primary mr-2"></i>Registrar Leads Mensuales (Conversaciones Iniciadas)
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4">
                    Ingresa el número total de personas que iniciaron conversación o solicitaron informes en el mes (Facebook, WhatsApp, llamadas, etc.). Este dato calcula automáticamente la <strong>Tasa Lead → Cotización</strong> y la <strong>Efectividad Comercial Global</strong>.
                </p>

                <form id="formRegistroLeads" onsubmit="guardarLeadsMensual(event)">
                    <div class="form-row align-items-end mb-4 p-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="small font-weight-bold text-gray-700 mb-1">Mes correspondiente:</label>
                            <input type="month" class="form-control" id="lead_mes" name="mes" value="{{ date('Y-m') }}" required>
                        </div>
                        <div class="col-md-4 mb-2 mb-md-0">
                            <label class="small font-weight-bold text-gray-700 mb-1">Cantidad de Leads:</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-white"><i class="fas fa-users text-primary"></i></span>
                                </div>
                                <input type="number" min="0" step="1" class="form-control font-weight-bold" id="lead_cantidad" name="leads" placeholder="Ej. 450" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <button type="submit" class="btn btn-primary btn-block font-weight-bold" id="btnGuardarLeads">
                                <i class="fas fa-save mr-1"></i> Guardar Leads
                            </button>
                        </div>
                        <div class="col-12 mt-2">
                            <input type="text" class="form-control form-control-sm" id="lead_notas" name="notas" placeholder="Notas u origen opcional (ej. Campañas FB Andamios Octubre)">
                        </div>
                    </div>
                </form>

                <h6 class="font-weight-bold text-gray-800 mb-2 small text-uppercase">
                    <i class="fas fa-list text-muted mr-1"></i> Historial de Leads Registrados
                </h6>
                <div class="table-responsive" style="max-height: 250px; overflow-y: auto;">
                    <table class="table table-sm table-hover mb-0">
                        <thead class="bg-light small font-weight-bold text-muted">
                            <tr>
                                <th>Mes</th>
                                <th class="text-center">Leads Registrados</th>
                                <th>Notas / Origen</th>
                                <th class="text-right">Acción</th>
                            </tr>
                        </thead>
                        <tbody id="tblHistorialLeads">
                            @forelse ($analisis['listaLeads'] as $l)
                                <tr id="row_lead_{{ $l->id }}">
                                    <td class="font-weight-bold">{{ $l->mes }}</td>
                                    <td class="text-center font-weight-bold text-primary">{{ number_format($l->leads) }}</td>
                                    <td class="small text-muted">{{ $l->notas ?: '-' }}</td>
                                    <td class="text-right">
                                        <button type="button" class="btn btn-xs btn-outline-danger py-0 px-2" onclick="eliminarLeadRegistro({{ $l->id }}, '{{ $l->mes }}')" title="Eliminar registro">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </td>
                                </tr>
                            @empty
                                <tr id="row_leads_vacio">
                                    <td colspan="4" class="text-center py-3 text-muted small">No hay meses registrados aún. Captura el primero arriba.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="modal-footer bg-light">
                <button type="button" class="btn btn-secondary rounded-pill px-4 font-weight-bold" data-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

{{-- ========================================================================= --}}
{{-- MODAL 2: CONFIGURACIÓN DE METAS Y UMBRALES (FASE 3 - Guardado pero comentado temporalmente) --}}
{{-- ========================================================================= --}}
{{--
<div class="modal fade" id="modalConfigUmbrales" tabindex="-1" role="dialog" aria-labelledby="modalConfigUmbralesLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content border-0 shadow-lg" style="border-radius: 16px;">
            <div class="modal-header bg-light">
                <h5 class="modal-title font-weight-bold text-gray-800" id="modalConfigUmbralesLabel">
                    <i class="fas fa-sliders-h text-primary mr-2"></i>Configuración de Metas y Semáforos Comerciales
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body p-4">
                <p class="text-muted small mb-4">
                    Ajusta los porcentajes que definen cuándo un indicador se pinta en <strong class="text-success">Verde (Meta)</strong>, <strong class="text-warning">Amarillo (Precaución)</strong> o <strong class="text-danger">Rojo (Alerta)</strong>. Estos valores se guardan en el sistema y recalculan el panel en tiempo real.
                </p>

                <form id="formConfigUmbrales" onsubmit="guardarUmbralesConfig(event)">
                    <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-gray-800 mb-1 small text-uppercase">
                            1. Tasa de Conversión (Cotización → Venta)
                        </h6>
                        <span class="text-muted small d-block mb-2">Porcentaje de cotizaciones que se concretan en venta cerrada.</span>
                        <div class="form-row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">🟢 Meta Verde (&ge; %):</label>
                                <input type="number" step="0.1" class="form-control" name="umb_conv_verde" id="conf_conv_verde" value="{{ $analisis['umbrales']['umb_conv_verde'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted font-weight-bold mb-1">🟡 Alerta Amarillo (&ge; %, menor es Rojo):</label>
                                <input type="number" step="0.1" class="form-control" name="umb_conv_amarillo" id="conf_conv_amarillo" value="{{ $analisis['umbrales']['umb_conv_amarillo'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-gray-800 mb-1 small text-uppercase">
                            2. Cobertura Logística (Fletes Cobrados / Paquetería Pagada)
                        </h6>
                        <span class="text-muted small d-block mb-2">Relación porcentual entre lo cobrado al cliente y lo pagado a transportistas.</span>
                        <div class="form-row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">🟢 Meta Verde (&ge; %):</label>
                                <input type="number" step="1" class="form-control" name="umb_cobertura_verde" id="conf_cob_verde" value="{{ $analisis['umbrales']['umb_cobertura_verde'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted font-weight-bold mb-1">🟡 Alerta Amarillo (&ge; %, menor es Rojo):</label>
                                <input type="number" step="1" class="form-control" name="umb_cobertura_amarillo" id="conf_cob_amarillo" value="{{ $analisis['umbrales']['umb_cobertura_amarillo'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-gray-800 mb-1 small text-uppercase">
                            3. Conversión de Prospección (Lead → Cotización)
                        </h6>
                        <span class="text-muted small d-block mb-2">Porcentaje de personas que solicitan cotización formal tras iniciar conversación.</span>
                        <div class="form-row">
                            <div class="col-md-6 mb-2 mb-md-0">
                                <label class="small text-muted font-weight-bold mb-1">🟢 Meta Verde (&ge; %):</label>
                                <input type="number" step="0.1" class="form-control" name="umb_lead_conv_verde" id="conf_lead_verde" value="{{ $analisis['umbrales']['umb_lead_conv_verde'] }}" required>
                            </div>
                            <div class="col-md-6">
                                <label class="small text-muted font-weight-bold mb-1">🟡 Alerta Amarillo (&ge; %, menor es Rojo):</label>
                                <input type="number" step="0.1" class="form-control" name="umb_lead_conv_amarillo" id="conf_lead_amarillo" value="{{ $analisis['umbrales']['umb_lead_conv_amarillo'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="p-3 mb-3 rounded" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                        <h6 class="font-weight-bold text-gray-800 mb-1 small text-uppercase">
                            4. Multiplicador de Alerta de Pipeline Abierto
                        </h6>
                        <span class="text-muted small d-block mb-2">Dispara el banner de aviso si el dinero en cotizaciones abiertas supera X veces las ventas del periodo.</span>
                        <div class="form-row">
                            <div class="col-md-6">
                                <label class="small text-muted font-weight-bold mb-1">⚠️ Factor multiplicador (ej. 1.5x):</label>
                                <input type="number" step="0.1" class="form-control" name="umb_pipeline_multiplicador" id="conf_pipeline_mult" value="{{ $analisis['umbrales']['umb_pipeline_multiplicador'] }}" required>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <button type="button" class="btn btn-outline-secondary font-weight-bold" onclick="restablecerUmbralesDefault()">
                            <i class="fas fa-undo mr-1"></i> Valores Sugeridos
                        </button>
                        <button type="submit" class="btn btn-primary px-4 font-weight-bold" id="btnGuardarUmbrales">
                            <i class="fas fa-save mr-1"></i> Guardar Metas
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
--}}
