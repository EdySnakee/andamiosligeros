<style>
    :root {
        --color-primary: #0848af;
        --color-primary-light: #e8f0fe;
        --color-success: #10b981;
        --color-success-light: #ecfdf5;
        --color-warning: #f59e0b;
        --color-warning-light: #fffbeb;
        --color-danger: #ef4444;
        --color-danger-light: #fef2f2;
        --color-purple: #8b5cf6;
        --color-purple-light: #f5f3ff;
    }

    /* Pestañas de Navegación */
    .ventas-nav-container {
        margin-bottom: 24px;
    }

    .custom-pills {
        background: #ffffff;
        padding: 6px;
        border-radius: 16px;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        display: inline-flex;
        flex-wrap: wrap;
        gap: 6px;
        border: 1px solid #f1f5f9;
    }

    .custom-pills .nav-item {
        margin: 0;
    }

    .custom-pills .nav-link {
        border-radius: 12px;
        font-weight: 700;
        font-size: 13.5px;
        color: #64748b;
        padding: 10px 24px;
        transition: all 0.2s ease;
        border: 1px solid transparent;
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .custom-pills .nav-link:hover {
        color: #1e293b;
        background: #f8fafc;
    }

    .custom-pills .nav-link.active {
        background: #0848af;
        color: #ffffff;
        box-shadow: 0 4px 14px rgba(8, 72, 175, 0.25);
    }

    /* Tarjetas de Estadísticas */
    .stat-card {
        border: 1px solid #f1f5f9 !important;
        border-radius: 16px !important;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.04) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.08) !important;
    }

    .stat-card .card-body {
        padding: 18px 20px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 14px;
    }

    .stat-card-hero {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
        color: #ffffff !important;
        border: 0 !important;
        box-shadow: 0 8px 24px rgba(16, 185, 129, 0.22) !important;
    }

    .stat-card-hero .stat-label { color: rgba(255, 255, 255, 0.85) !important; }
    .stat-card-hero .stat-value { color: #ffffff !important; font-weight: 700; }
    .stat-card-hero .stat-icon { background: rgba(255, 255, 255, 0.2) !important; color: #ffffff !important; }

    .stat-accent {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 4px;
        background: var(--color-primary);
    }

    .stat-card-primary .stat-accent { background: var(--color-primary); }
    .stat-card-success .stat-accent { background: var(--color-success); }
    .stat-card-warning .stat-accent { background: var(--color-warning); }
    .stat-card-danger .stat-accent  { background: var(--color-danger); }
    .stat-card-purple .stat-accent  { background: var(--color-purple); }

    .stat-meta {
        display: flex;
        flex-direction: column;
        gap: 3px;
        min-width: 0;
    }

    .stat-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin: 0;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .stat-sublabel {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }

    .stat-icon {
        width: 44px;
        height: 44px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 18px;
    }

    .stat-card-primary .stat-icon { background: var(--color-primary-light); color: var(--color-primary); }
    .stat-card-success .stat-icon { background: var(--color-success-light); color: var(--color-success); }
    .stat-card-warning .stat-icon { background: var(--color-warning-light); color: var(--color-warning); }
    .stat-card-danger .stat-icon  { background: var(--color-danger-light); color: var(--color-danger); }
    .stat-card-purple .stat-icon  { background: var(--color-purple-light); color: var(--color-purple); }

    /* Barra de Filtros */
    .filter-card {
        border: 0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        padding: 20px 24px;
        margin-bottom: 24px;
        border: 1px solid #f1f5f9;
    }

    .preset-pills {
        display: flex;
        flex-wrap: wrap;
        gap: 8px;
        margin-bottom: 14px;
    }

    .preset-pill {
        font-size: 12px;
        font-weight: 600;
        padding: 6px 14px;
        border-radius: 30px;
        border: 1px solid #e2e8f0;
        background: #f8fafc;
        color: #475569;
        cursor: pointer;
        transition: all 0.15s ease;
    }

    .preset-pill:hover { background: #e2e8f0; color: #1e293b; }
    .preset-pill.active {
        background: #0848af;
        color: #ffffff;
        border-color: #0848af;
        box-shadow: 0 2px 8px rgba(8, 72, 175, 0.25);
    }

    /* Leaderboard de Productos Más Vendidos */
    .leaderboard-item {
        padding: 12px 16px;
        display: flex;
        align-items: center;
        gap: 12px;
        border-bottom: 1px solid #f1f5f9;
        transition: background 0.15s ease;
    }

    .leaderboard-item:last-child {
        border-bottom: none;
    }

    .leaderboard-item:hover {
        background: #f8fafc;
    }

    .leaderboard-rank {
        width: 30px;
        height: 30px;
        border-radius: 50%;
        display: grid;
        place-items: center;
        font-size: 12px;
        font-weight: 800;
        flex: 0 0 auto;
        background: #e2e8f0;
        color: #475569;
    }

    .leaderboard-rank.rank-1 { background: #fef3c7; color: #d97706; }
    .leaderboard-rank.rank-2 { background: #f1f5f9; color: #64748b; }
    .leaderboard-rank.rank-3 { background: #ffedd5; color: #c2410c; }

    .leaderboard-info {
        flex-grow: 1;
        min-width: 0;
    }

    .leaderboard-name {
        font-size: 13px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .leaderboard-progress {
        height: 5px;
        background: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 4px;
    }

    .leaderboard-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #0848af, #3b82f6);
        border-radius: 999px;
    }

    .leaderboard-meta {
        font-size: 11px;
        color: #94a3b8;
    }

    .leaderboard-total {
        text-align: right;
        flex: 0 0 auto;
    }

    .leaderboard-total-value {
        font-size: 14px;
        font-weight: 700;
        color: #0848af;
    }

    /* Tabla de Vendedores */
    .table-vendedores thead th {
        background: #f8fafc;
        color: #475569;
        font-size: 11px;
        font-weight: 700;
        text-transform: uppercase;
        letter-spacing: 0.06em;
        border-bottom: 2px solid #e2e8f0;
        padding: 14px 16px;
        vertical-align: middle;
    }

    .table-vendedores tbody td {
        padding: 14px 16px;
        vertical-align: middle;
        font-size: 13.5px;
        color: #334155;
    }

    .vendedor-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: #e0e7ff;
        color: #4338ca;
        font-weight: 700;
        font-size: 12px;
        display: inline-grid;
        place-items: center;
        margin-right: 8px;
    }

    .badge-tasa {
        font-weight: 700;
        font-size: 12px;
        padding: 4px 10px;
        border-radius: 999px;
    }

    /* Barra Visual Financiera */
    .finance-bar-container {
        height: 12px;
        border-radius: 999px;
        display: flex;
        overflow: hidden;
        background: #f1f5f9;
        margin-bottom: 12px;
    }

    .finance-segment-neto { background: #10b981; }
    .finance-segment-iva  { background: #ef4444; }
    .finance-segment-log  { background: #f59e0b; }
</style>

<div class="container-fluid py-2">
    <!-- Encabezado de Página -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
        <div>
            <h2 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1.65rem;">
                <i class="fas fa-chart-line text-primary mr-2"></i>Estadísticas de Ventas
            </h2>
            <p class="text-muted mb-0 small">Métricas de prospección comercial, ventas facturadas, finanzas y rendimiento de equipo.</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light border text-secondary px-3 py-2 font-weight-normal">
                <i class="fas fa-sync-alt mr-1 text-primary"></i> Sincronización en tiempo real
            </span>
        </div>
    </div>

    <!-- Barra de Filtros Inteligente -->
    <div class="filter-card">
        <div class="d-flex align-items-center justify-content-between mb-2 flex-wrap">
            <label class="font-weight-bold text-gray-700 small mb-0 text-uppercase">
                <i class="fas fa-calendar-alt text-primary mr-1"></i> Período de Análisis:
            </label>
            <div class="preset-pills">
                <button type="button" class="preset-pill active" onclick="setPreset('todo', this)">Todo el Historial</button>
                <button type="button" class="preset-pill" onclick="setPreset('este_mes', this)">Este Mes</button>
                <button type="button" class="preset-pill" onclick="setPreset('mes_pasado', this)">Mes Anterior</button>
                <button type="button" class="preset-pill" onclick="setPreset('30_dias', this)">Últimos 30 días</button>
                <button type="button" class="preset-pill" onclick="setPreset('este_ano', this)">Año en Curso</button>
            </div>
        </div>
        <div class="row align-items-end">
            <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                <label for="fecha_inicio" class="small text-muted font-weight-bold mb-1">Fecha Inicio:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-alt text-muted"></i></span>
                    </div>
                    <input type="date" id="fecha_inicio" class="form-control border-left-0">
                </div>
            </div>
            <div class="col-md-4 col-sm-6 mb-2 mb-md-0">
                <label for="fecha_fin" class="small text-muted font-weight-bold mb-1">Fecha Fin:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-alt text-muted"></i></span>
                    </div>
                    <input type="date" id="fecha_fin" class="form-control border-left-0">
                </div>
            </div>
            <div class="col-md-4 col-sm-12 d-flex">
                <button class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold flex-grow-1 shadow-sm"
                    id="btnFiltrarVentas" onclick="filtrarEstadisticas()">
                    <i class="fas fa-filter mr-1"></i> Filtrar
                </button>
                <button class="btn btn-outline-secondary rounded-pill px-3 py-2 font-weight-bold ml-2"
                    onclick="resetFiltros()" title="Restablecer">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- Pestañas Principales (Comercial + Financiero unificados / Detalle Vendedores) -->
    <div class="ventas-nav-container">
        <ul class="nav nav-pills custom-pills" id="ventasTabs" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="tab-general-link" data-toggle="pill" href="#tab-general" role="tab" aria-controls="tab-general" aria-selected="true">
                    <i class="fas fa-chart-pie"></i> Resumen Comercial y Financiero
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="tab-vendedores-link" data-toggle="pill" href="#tab-vendedores" role="tab" aria-controls="tab-vendedores" aria-selected="false">
                    <i class="fas fa-users"></i> Detalle de Vendedores
                </a>
            </li>
        </ul>
    </div>

    <!-- Contenido de Pestañas -->
    <div class="tab-content" id="ventasTabsContent">

        <!-- ============================================================== -->
        <!-- PESTAÑA UNIFICADA: RESUMEN COMERCIAL Y FINANCIERO               -->
        <!-- ============================================================== -->
        <div class="tab-pane fade show active" id="tab-general" role="tabpanel" aria-labelledby="tab-general-link">

            <!-- 1. BLOQUE DE DESEMPEÑO COMERCIAL -->
            <div class="d-flex align-items-center mb-3 mt-1">
                <span class="badge badge-primary px-3 py-1 font-weight-bold" style="font-size: 11.5px; border-radius: 20px;">
                    <i class="fas fa-bullseye mr-1"></i> Desempeño Comercial
                </span>
                <div class="flex-grow-1 border-bottom ml-3"></div>
            </div>

            <div class="row mb-4">
                <!-- Cotizaciones -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-primary h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Cotizaciones Creadas</p>
                                <p id="numCotizaciones" class="stat-value">{{ number_format($numCotizaciones) }}</p>
                                <p class="stat-sublabel">
                                    <span class="text-primary font-weight-bold" id="totalCotizaciones">${{ $totalCotizaciones }}</span> cotizado
                                </p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ventas Concretadas -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-success h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Ventas Concretadas</p>
                                <p id="numeroVentas" class="stat-value">{{ number_format($numeroVentas) }}</p>
                                <p class="stat-sublabel text-success font-weight-bold">
                                    <i class="fas fa-check-circle"></i> Estatus 3 (Cerradas)
                                </p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-shopping-cart"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tasa de Conversión -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-purple h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Tasa de Conversión</p>
                                <p id="tasaConversion" class="stat-value">{{ $tasaConversion }}%</p>
                                <p class="stat-sublabel">Efectividad de cierre</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-percentage"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Ticket Promedio -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-warning h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Ticket Promedio</p>
                                <p id="promedioVentas" class="stat-value">${{ $promedioVentas }}</p>
                                <p class="stat-sublabel">Importe medio por venta</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-receipt"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 2. BLOQUE DE RESUMEN FINANCIERO -->
            <div class="d-flex align-items-center mb-3 mt-1">
                <span class="badge text-white px-3 py-1 font-weight-bold" style="font-size: 11.5px; border-radius: 20px; background: #059669;">
                    <i class="fas fa-wallet mr-1"></i> Balance Financiero
                </span>
                <div class="flex-grow-1 border-bottom ml-3"></div>
            </div>

            <div class="row mb-4">
                <!-- Ventas Brutas -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-primary h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Ventas Brutas</p>
                                <p id="totalVentas" class="stat-value">${{ $totalVentas }}</p>
                                <p class="stat-sublabel">Facturación total acumulada</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-dollar-sign"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Impuesto IVA -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-danger h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Impuesto IVA</p>
                                <p id="totalIVA" class="stat-value text-danger">${{ $totalIVA }}</p>
                                <p class="stat-sublabel">Acumulado en ventas facturadas</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-file-invoice-dollar"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gastos Logística -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-warning h-100">
                        <span class="stat-accent"></span>
                        <div class="card-body">
                            <div class="stat-meta">
                                <p class="stat-label">Gastos Logística</p>
                                <p id="totalLogistica" class="stat-value">
                                    ${{ number_format((float) str_replace(',', '', $totalEnvios) + (float) str_replace(',', '', $totalEnviosPaqueteria), 2) }}
                                </p>
                                <p class="stat-sublabel">
                                    Envío: <span id="totalEnvios" class="font-weight-bold">${{ $totalEnvios }}</span> |
                                    Paq: <span id="totalEnviosPaqueteria" class="font-weight-bold">${{ $totalEnviosPaqueteria }}</span>
                                </p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-shipping-fast"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- HERO CARD: Venta Neta -->
                <div class="col-xl-3 col-md-6 mb-3">
                    <div class="card stat-card stat-card-hero h-100">
                        <div class="card-body">
                            <div class="stat-meta">
                                <div class="d-flex align-items-center mb-1">
                                    <span class="badge badge-light text-success font-weight-bold small px-2 py-1">
                                        <i class="fas fa-shield-alt mr-1"></i>Ingreso Efectivo
                                    </span>
                                </div>
                                <p class="stat-label">Venta Neta</p>
                                <p id="totalNeto" class="stat-value">${{ $totalNeto }}</p>
                                <p class="stat-sublabel text-white-50">Ventas - IVA - Logística</p>
                            </div>
                            <div class="stat-icon">
                                <i class="fas fa-coins"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 3. BLOQUE GRÁFICA MENSUAL Y TOP PRODUCTOS -->
            <div class="row mb-4">
                <!-- Columna Izquierda (7-8 cols): Gráfica Mensual -->
                <div class="col-lg-7 col-xl-8 mb-4 mb-lg-0">
                    <div class="card shadow-sm border-0 rounded-lg h-100" style="border-radius: 16px;">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
                            <h6 class="m-0 font-weight-bold text-gray-800">
                                <i class="fas fa-chart-area text-primary mr-2"></i>Evolución Mensual de Ventas vs Cotizaciones
                            </h6>
                            <span class="small text-muted">Doble eje: Volumen y Monto facturado ($)</span>
                        </div>
                        <div class="card-body">
                            <div style="position: relative; min-height: 380px; width: 100%;">
                                <canvas id="ventasChart"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Columna Derecha (4-5 cols): Leaderboard de Productos Más Vendidos -->
                <div class="col-lg-5 col-xl-4">
                    <div class="card shadow-sm border-0 rounded-lg h-100" style="border-radius: 16px;">
                        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                            <h6 class="m-0 font-weight-bold text-gray-800">
                                <i class="fas fa-trophy text-warning mr-2"></i>Top Productos Más Vendidos
                            </h6>
                            <span class="badge badge-light border text-muted small">Por volumen e importe</span>
                        </div>
                        <div class="card-body p-0" style="max-height: 440px; overflow-y: auto;">
                            <div id="productosMasVendidos">
                                @forelse ($productosMasVendidos as $index => $producto)
                                    @php
                                        $rank = $index + 1;
                                        $rankClass = $rank <= 3 ? 'rank-' . $rank : '';
                                        $medal = $rank === 1 ? '🥇' : ($rank === 2 ? '🥈' : ($rank === 3 ? '🥉' : '#' . $rank));
                                    @endphp
                                    <div class="leaderboard-item">
                                        <div class="leaderboard-rank {{ $rankClass }}">{{ $medal }}</div>
                                        <div class="leaderboard-info">
                                            <p class="leaderboard-name" title="{{ $producto->nombre }}">{{ $producto->nombre }}</p>
                                            <div class="leaderboard-progress">
                                                <div class="leaderboard-progress-bar" style="width: {{ $producto->porcentaje }}%;"></div>
                                            </div>
                                            <span class="leaderboard-meta">
                                                <strong>{{ number_format($producto->cantidad_vendida) }}</strong> unidades vendidas
                                            </span>
                                        </div>
                                        <div class="leaderboard-total">
                                            <div class="leaderboard-total-value">${{ $producto->total_vendido }}</div>
                                            <span class="small text-muted">Total</span>
                                        </div>
                                    </div>
                                @empty
                                    <div class="p-4 text-center text-muted">
                                        <i class="fas fa-box-open fa-2x mb-2 text-gray-300"></i>
                                        <p class="small mb-0">No hay productos registrados en este período.</p>
                                    </div>
                                @endforelse
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- 4. BLOQUE DE DESGLOSE Y AUDITORÍA FINANCIERA -->
            <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-balance-scale text-primary mr-2"></i>Estructura del Ingreso y Auditoría Contable
                    </h6>
                    <span class="small text-muted">Desglose de deducciones sobre el ingreso bruto</span>
                </div>
                <div class="card-body p-4">
                    <p class="text-muted small mb-3">
                        Composición porcentual de deducciones (IVA y logística) respecto al total bruto facturado:
                    </p>

                    @php
                        $brutoNum = max(0.01, (float) str_replace(',', '', $totalVentas));
                        $netoNum  = max(0, (float) str_replace(',', '', $totalNeto));
                        $ivaNum   = max(0, (float) str_replace(',', '', $totalIVA));
                        $logNum   = max(0, (float) str_replace(',', '', $totalEnvios) + (float) str_replace(',', '', $totalEnviosPaqueteria));

                        $pctNeto = round(($netoNum / $brutoNum) * 100, 1);
                        $pctIva  = round(($ivaNum / $brutoNum) * 100, 1);
                        $pctLog  = round(($logNum / $brutoNum) * 100, 1);
                    @endphp

                    <!-- Barra de Composición Visual -->
                    <div class="finance-bar-container" id="financeBarContainer">
                        <div class="finance-segment-neto" id="barPctNeto" style="width: {{ $pctNeto }}%;" title="Venta Neta: {{ $pctNeto }}%"></div>
                        <div class="finance-segment-iva" id="barPctIva" style="width: {{ $pctIva }}%;" title="IVA: {{ $pctIva }}%"></div>
                        <div class="finance-segment-log" id="barPctLog" style="width: {{ $pctLog }}%;" title="Logística: {{ $pctLog }}%"></div>
                    </div>

                    <div class="d-flex justify-content-between flex-wrap text-muted small mb-4">
                        <span class="d-flex align-items-center mb-1">
                            <span class="d-inline-block rounded-circle mr-1" style="width: 10px; height: 10px; background: #10b981;"></span>
                            Venta Neta (<span id="txtPctNeto">{{ $pctNeto }}%</span>)
                        </span>
                        <span class="d-flex align-items-center mb-1">
                            <span class="d-inline-block rounded-circle mr-1" style="width: 10px; height: 10px; background: #ef4444;"></span>
                            IVA Facturado (<span id="txtPctIva">{{ $pctIva }}%</span>)
                        </span>
                        <span class="d-flex align-items-center mb-1">
                            <span class="d-inline-block rounded-circle mr-1" style="width: 10px; height: 10px; background: #f59e0b;"></span>
                            Logística y Paquetería (<span id="txtPctLog">{{ $pctLog }}%</span>)
                        </span>
                    </div>

                    <!-- Tabla de Auditoría Contable -->
                    <div class="table-responsive">
                        <table class="table table-bordered mb-0">
                            <thead class="bg-light">
                                <tr>
                                    <th>Concepto Financiero</th>
                                    <th>Naturaleza</th>
                                    <th class="text-right">Monto</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td class="font-weight-bold">Facturación Bruta (Total Ventas)</td>
                                    <td><span class="badge badge-primary">Ingreso Bruto</span></td>
                                    <td class="text-right font-weight-bold text-primary" id="tblTotalVentas">${{ $totalVentas }}</td>
                                </tr>
                                <tr>
                                    <td>Menos: Impuesto al Valor Agregado (IVA cobrado en facturas)</td>
                                    <td><span class="badge badge-danger">Deducción Fiscal</span></td>
                                    <td class="text-right text-danger" id="tblTotalIVA">-${{ $totalIVA }}</td>
                                </tr>
                                <tr>
                                    <td>Menos: Fletes Locales y Logística Directa</td>
                                    <td><span class="badge badge-warning">Costo Operativo</span></td>
                                    <td class="text-right text-warning" id="tblTotalEnvios">-${{ $totalEnvios }}</td>
                                </tr>
                                <tr>
                                    <td>Menos: Envíos por Paquetería Foránea</td>
                                    <td><span class="badge badge-warning">Costo Operativo</span></td>
                                    <td class="text-right text-warning" id="tblTotalPaq">-${{ $totalEnviosPaqueteria }}</td>
                                </tr>
                                <tr class="bg-light font-weight-bold">
                                    <td class="text-success h6 mb-0">Total Venta Neta Disponible</td>
                                    <td><span class="badge badge-success">Utilidad Bruta Efectiva</span></td>
                                    <td class="text-right text-success h6 mb-0" id="tblTotalNeto">${{ $totalNeto }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

        </div>

        <!-- ============================================================== -->
        <!-- PESTAÑA 2: DETALLE DE VENDEDORES                               -->
        <!-- ============================================================== -->
        <div class="tab-pane fade" id="tab-vendedores" role="tabpanel" aria-labelledby="tab-vendedores-link">
            <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
                <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
                    <h6 class="m-0 font-weight-bold text-gray-800">
                        <i class="fas fa-users text-primary mr-2"></i>Rendimiento por Vendedor
                    </h6>
                    <span class="badge badge-light border text-muted">Ordenados por monto facturado</span>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-vendedores table-hover mb-0">
                            <thead>
                                <tr>
                                    <th>Vendedor</th>
                                    <th class="text-center"># Cotizaciones</th>
                                    <th class="text-center"># Ventas</th>
                                    <th class="text-right">Total Cotizado</th>
                                    <th class="text-right">Total Vendido</th>
                                    <th class="text-center">Tasa Éxito</th>
                                    <th>Cliente Estrella ⭐</th>
                                </tr>
                            </thead>
                            <tbody id="vendedoresPrincipales">
                                @forelse ($vendedoresPrin as $vendedor)
                                    @php
                                        $inicial = strtoupper(substr($vendedor->nombre, 0, 1));
                                        $tasa = (float) $vendedor->promedio_exito;
                                        $tasaClass = $tasa >= 25 ? 'badge-success' : ($tasa >= 15 ? 'badge-warning' : 'badge-secondary');
                                    @endphp
                                    <tr>
                                        <td class="font-weight-bold">
                                            <span class="vendedor-avatar">{{ $inicial }}</span>
                                            {{ $vendedor->nombre }}
                                        </td>
                                        <td class="text-center">{{ number_format($vendedor->numero_cotizaciones) }}</td>
                                        <td class="text-center font-weight-bold text-success">{{ number_format($vendedor->numero_ventas) }}</td>
                                        <td class="text-right text-muted">${{ $vendedor->total_cotizado }}</td>
                                        <td class="text-right font-weight-bold text-primary">${{ $vendedor->total_generado }}</td>
                                        <td class="text-center">
                                            <span class="badge {{ $tasaClass }} badge-tasa">{{ $vendedor->promedio_exito }}%</span>
                                        </td>
                                        <td>
                                            @if ($vendedor->cliente_estrella !== 'N/A')
                                                <i class="fas fa-star text-warning mr-1"></i><strong>{{ $vendedor->cliente_estrella }}</strong>
                                            @else
                                                <span class="text-muted">N/A</span>
                                            @endif
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center py-4 text-muted">
                                            No hay registros de vendedores para el período seleccionado.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

    </div>
</div>
