{{-- ========================================================================= --}}
{{-- PESTAÑA: ANÁLISIS COMERCIAL (FASE 1)                                       --}}
{{-- ========================================================================= --}}

<div class="mb-4">
    {{-- 1. HEADER DE LA SECCIÓN DE ANÁLISIS --}}
    <div class="d-flex align-items-center justify-content-between flex-wrap mb-4 pb-2 border-bottom">
        <div>
            <h5 class="font-weight-bold text-gray-800 mb-1">
                <i class="fas fa-chart-pie text-primary mr-2"></i>Análisis Comercial y Salud del Negocio
            </h5>
            <p class="text-muted small mb-0">
                Embudo de conversión, rentabilidad logística, proyección al cierre y comparativa histórica de resultados.
            </p>
        </div>
        <div class="mt-2 mt-md-0">
            <span class="badge badge-light border px-3 py-2 text-muted font-weight-bold small">
                <i class="fas fa-calendar-alt text-primary mr-1"></i> Período: <span id="an_badgeDias">{{ $analisis['dias'] }}</span> días analizados
            </span>
        </div>
    </div>

    {{-- 2. TARJETAS KPI ESTRATÉGICAS (FILA 1) --}}
    <div class="row mb-4">
        {{-- KPI 1: Cotización -> Venta --}}
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-primary h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Cotización → Venta</p>
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
                                    100% Volumen Base
                                </div>
                            </div>
                        </div>

                        {{-- Tasa intermedia 1 --}}
                        <div class="d-flex align-items-center justify-content-center my-2 text-muted small">
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

                        {{-- Tasa intermedia 2 --}}
                        <div class="d-flex align-items-center justify-content-center my-2 text-muted small">
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

        {{-- Columna Derecha: Control de Logística y Paquetería --}}
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
                                <span class="text-muted" style="font-size: 0.75rem;">Flete pagado por cliente</span>
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
                                    Diferencia entre lo cobrado al cliente y lo pagado a transportistas.
                                </small>
                            </div>
                        </div>

                        {{-- Cobertura Logística --}}
                        <div class="col-md-6">
                            <div class="p-3 rounded border h-100 d-flex flex-column justify-content-between" style="background: #eff6ff; border-color: #bfdbfe !important;">
                                <div class="d-flex justify-content-between align-items-center mb-1">
                                    <span class="small font-weight-bold text-primary">
                                        <i class="fas fa-shield-alt mr-1"></i> Cobertura Logística
                                    </span>
                                    <span class="badge {{ (float)$analisis['coberturaLogistica'] >= 100 ? 'badge-primary' : 'badge-warning' }}" id="an_badgeCobertura">
                                        {{ (float)$analisis['coberturaLogistica'] >= 100 ? 'Autosustentable' : 'Parcial' }}
                                    </span>
                                </div>
                                <h4 class="font-weight-bold text-primary mb-1" id="an_coberturaLog">
                                    {{ $analisis['coberturaLogistica'] }}%
                                </h4>
                                <small class="text-muted" style="font-size: 0.72rem;">
                                    Si es mayor a 100%, los fletes cobrados no solo cubren el costo sino que aportan utilidad.
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

    {{-- 5. FILA 4: TABLA COMPARATIVA MENSUAL HISTÓRICA --}}
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
            <div>
                <h6 class="m-0 font-weight-bold text-gray-800">
                    <i class="fas fa-history text-primary mr-2"></i>Comparativa Mensual Histórica (Últimos 6 Meses)
                </h6>
                <span class="small text-muted">Evolución mes a mes con variación porcentual de venta neta</span>
            </div>
            <span class="badge badge-light border text-muted small mt-2 mt-md-0">Auditoría continua</span>
        </div>
        <div class="card-body p-0">
            <div class="table-responsive">
                <table class="table table-hover mb-0" id="tablaComparativaAnalisis">
                    <thead class="bg-light">
                        <tr class="small font-weight-bold text-muted text-uppercase">
                            <th>Mes</th>
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
                                    {{ number_format($fila['cotizaciones_count']) }}
                                    <small class="text-muted d-block">${{ $fila['total_cotizado'] }}</small>
                                </td>
                                <td class="text-center">
                                    <span class="badge badge-success px-2 py-1">{{ number_format($fila['ventas_count']) }}</span>
                                </td>
                                <td class="text-center">
                                    <span class="font-weight-bold {{ $fila['conversion_pct'] >= 30 ? 'text-success' : 'text-primary' }}">
                                        {{ $fila['conversion_pct'] }}%
                                    </span>
                                </td>
                                <td class="text-right">${{ $fila['ticket_promedio'] }}</td>
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
                                <td colspan="9" class="text-center py-4 text-muted">
                                    No hay registros históricos disponibles para el comparativo.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    {{-- 6. FILA 5: BANNER FASE 2 (PUBLICIDAD Y LEADS META ADS) --}}
    <div class="card border-0 rounded-lg shadow-sm" style="background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%); border-left: 5px solid #3b82f6 !important; border-radius: 14px;">
        <div class="card-body p-4 d-flex align-items-center justify-content-between flex-wrap">
            <div class="d-flex align-items-center mb-2 mb-md-0">
                <div class="mr-3 text-primary" style="font-size: 2rem;">
                    <i class="fab fa-facebook-square"></i>
                </div>
                <div>
                    <h6 class="font-weight-bold text-gray-800 mb-1">
                        Fase 2: Publicidad y Atribución Comercial (Meta Ads & Leads)
                    </h6>
                    <p class="text-muted small mb-0">
                        Espacio preparado para integrar leads por campaña, costo por lead (CPL), gasto publicitario diario y ROAS.
                    </p>
                </div>
            </div>
            <div>
                <span class="badge badge-primary px-3 py-2 font-weight-bold small">
                    <i class="fas fa-clock mr-1"></i> Próxima Fase
                </span>
            </div>
        </div>
    </div>
</div>
