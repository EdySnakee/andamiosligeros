<style>
    /* Estilos Premium para Dashboard de Ventas */
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

    .stat-card {
        border: 0 !important;
        border-radius: 16px !important;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12) !important;
    }

    .stat-card .card-body {
        padding: 20px 22px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .stat-card-hero {
        background: linear-gradient(135deg, #059669 0%, #10b981 100%) !important;
        color: #ffffff !important;
        box-shadow: 0 8px 25px rgba(16, 185, 129, 0.28) !important;
    }

    .stat-card-hero .stat-label {
        color: rgba(255, 255, 255, 0.85) !important;
    }

    .stat-card-hero .stat-value {
        color: #ffffff !important;
        font-weight: 700;
    }

    .stat-card-hero .stat-icon {
        background: rgba(255, 255, 255, 0.2) !important;
        color: #ffffff !important;
    }

    .stat-accent {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--color-primary);
    }

    .stat-card-success .stat-accent { background: var(--color-success); }
    .stat-card-warning .stat-accent { background: var(--color-warning); }
    .stat-card-danger .stat-accent  { background: var(--color-danger); }
    .stat-card-purple .stat-accent  { background: var(--color-purple); }

    .stat-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
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
        font-size: 24px;
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
        display: flex;
        align-items: center;
        gap: 4px;
    }

    .stat-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 20px;
    }

    .stat-card-primary .stat-icon { background: var(--color-primary-light); color: var(--color-primary); }
    .stat-card-success .stat-icon { background: var(--color-success-light); color: var(--color-success); }
    .stat-card-warning .stat-icon { background: var(--color-warning-light); color: var(--color-warning); }
    .stat-card-danger .stat-icon  { background: var(--color-danger-light); color: var(--color-danger); }
    .stat-card-purple .stat-icon  { background: var(--color-purple-light); color: var(--color-purple); }

    /* Barra de Filtros Premium */
    .filter-card {
        border: 0;
        border-radius: 16px;
        background: #ffffff;
        box-shadow: 0 4px 18px rgba(15, 23, 42, 0.05);
        padding: 20px 24px;
        margin-bottom: 24px;
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

    .preset-pill:hover {
        background: #e2e8f0;
        color: #1e293b;
    }

    .preset-pill.active {
        background: #0848af;
        color: #ffffff;
        border-color: #0848af;
        box-shadow: 0 2px 8px rgba(8, 72, 175, 0.25);
    }

    /* Cards de Productos Más Vendidos */
    .producto-card {
        border: 0 !important;
        border-radius: 14px !important;
        background: #ffffff;
        box-shadow: 0 4px 16px rgba(15, 23, 42, 0.05) !important;
        transition: transform 0.15s ease, box-shadow 0.15s ease;
        overflow: hidden;
    }

    .producto-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 10px 24px rgba(15, 23, 42, 0.1) !important;
    }

    .producto-card .card-body {
        padding: 16px !important;
        position: relative;
    }

    .producto-rank-badge {
        position: absolute;
        top: 14px;
        right: 14px;
        font-size: 11px;
        font-weight: 800;
        padding: 3px 9px;
        border-radius: 999px;
        color: #ffffff;
        background: #94a3b8;
    }

    .producto-rank-badge.rank-1 { background: linear-gradient(135deg, #f59e0b, #d97706); }
    .producto-rank-badge.rank-2 { background: linear-gradient(135deg, #94a3b8, #64748b); }
    .producto-rank-badge.rank-3 { background: linear-gradient(135deg, #c2703d, #9a5227); }

    .producto-nombre {
        font-size: 13.5px;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 10px 0;
        padding-right: 40px;
        line-height: 1.35;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
        min-height: 36px;
    }

    .producto-progress-container {
        height: 6px;
        background: #f1f5f9;
        border-radius: 999px;
        overflow: hidden;
        margin-bottom: 12px;
    }

    .producto-progress-bar {
        height: 100%;
        background: linear-gradient(90deg, #0848af, #3b82f6);
        border-radius: 999px;
    }

    .producto-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        border-top: 1px solid #f1f5f9;
        padding-top: 10px;
    }

    .producto-stat-value {
        font-size: 15px;
        font-weight: 700;
        color: #0f172a;
    }

    .producto-stat-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #94a3b8;
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
        padding: 12px 14px;
        vertical-align: middle;
    }

    .table-vendedores tbody td {
        padding: 12px 14px;
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
</style>

<div class="container-fluid py-2">
    <!-- Encabezado de Página -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
        <div>
            <h2 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1.65rem;">
                <i class="fas fa-chart-line text-primary mr-2"></i>Estadísticas de Ventas
            </h2>
            <p class="text-muted mb-0 small">Métricas de desempeño comercial, volumen facturado e ingresos netos.</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light border text-secondary px-3 py-2 font-weight-normal">
                <i class="fas fa-sync-alt mr-1 text-primary"></i> Datos sincronizados en tiempo real
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
            <div class="col-md-4 col-sm-12 d-flex gap-2">
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

    <!-- SECCIÓN 1: Desempeño Comercial (4 Tarjetas Equilibradas) -->
    <div class="d-flex align-items-center mb-3">
        <h6 class="font-weight-bold text-uppercase text-secondary small mb-0 tracking-wider">
            <i class="fas fa-bullseye text-primary mr-1"></i> Desempeño Comercial
        </h6>
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
                            <span class="text-primary font-weight-bold">${{ $totalCotizaciones }}</span> cotizado
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
                        <p class="stat-sublabel">Éxito cotización a venta</p>
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

    <!-- SECCIÓN 2: Métricas Financieras (4 Tarjetas con Hero Card) -->
    <div class="d-flex align-items-center mb-3">
        <h6 class="font-weight-bold text-uppercase text-secondary small mb-0 tracking-wider">
            <i class="fas fa-wallet text-success mr-1"></i> Resumen Financiero
        </h6>
        <div class="flex-grow-1 border-bottom ml-3"></div>
    </div>

    <div class="row mb-4">
        <!-- Venta Bruta -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-primary h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Ventas Brutas Totales</p>
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
                        <p class="stat-label">Impuesto IVA (16%)</p>
                        <p id="totalIVA" class="stat-value text-danger">${{ $totalIVA }}</p>
                        <p class="stat-sublabel">Carga tributaria acumulada</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-file-invoice-dollar"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Logística y Envíos Combinados -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card stat-card stat-card-warning h-100">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Envíos y Paquetería</p>
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
                            <span class="badge badge-light text-success font-weight-bold small px-2 py-1 mr-2">
                                <i class="fas fa-shield-alt"></i> Ingreso Efectivo
                            </span>
                        </div>
                        <p class="stat-label">Venta Neta</p>
                        <p id="totalNeto" class="stat-value">${{ $totalNeto }}</p>
                        <p class="stat-sublabel text-white-50">Venta - IVA - Logística</p>
                    </div>
                    <div class="stat-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 3: Productos Más Vendidos -->
    <div class="d-flex align-items-center justify-content-between mb-3">
        <h6 class="font-weight-bold text-uppercase text-secondary small mb-0 tracking-wider">
            <i class="fas fa-trophy text-warning mr-1"></i> Top Productos Más Vendidos
        </h6>
        <div class="flex-grow-1 border-bottom ml-3"></div>
    </div>

    <div class="row producto-cards-grid mb-4" id="productosMasVendidos">
        @forelse ($productosMasVendidos as $index => $producto)
            @php
                $rank = $index + 1;
                $rankClass = $rank <= 3 ? 'rank-' . $rank : '';
            @endphp
            <div class="col-xl-3 col-lg-4 col-md-6 mb-3">
                <div class="card producto-card h-100">
                    <div class="card-body">
                        <span class="producto-rank-badge {{ $rankClass }}">
                            @if ($rank === 1) 🥇 @elseif ($rank === 2) 🥈 @elseif ($rank === 3) 🥉 @endif#{{ $rank }}
                        </span>
                        <p class="producto-nombre" title="{{ $producto->nombre }}">{{ $producto->nombre }}</p>
                        <div class="producto-progress-container">
                            <div class="producto-progress-bar" style="width: {{ $producto->porcentaje }}%;"></div>
                        </div>
                        <div class="producto-stats">
                            <div>
                                <span class="producto-stat-value">{{ number_format($producto->cantidad_vendida) }}</span>
                                <div class="producto-stat-label">Unidades</div>
                            </div>
                            <div class="text-right">
                                <span class="producto-stat-value text-primary">${{ $producto->total_vendido }}</span>
                                <div class="producto-stat-label">Total Vendido</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="alert alert-light text-center border py-4 text-muted">
                    <i class="fas fa-box-open fa-2x mb-2 text-gray-400"></i>
                    <p class="mb-0">No se encontraron productos vendidos en este período.</p>
                </div>
            </div>
        @endforelse
    </div>

    <!-- SECCIÓN 4: Estadísticas de Vendedores -->
    <div class="card shadow-sm border-0 rounded-lg mb-4 overflow-hidden" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-gray-800">
                <i class="fas fa-users text-primary mr-2"></i>Rendimiento por Vendedor
            </h6>
            <span class="badge badge-light border text-muted">Rankings ordenados por monto vendido</span>
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

    <!-- SECCIÓN 5: Gráfica Histórica Mensual -->
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
            <h6 class="m-0 font-weight-bold text-gray-800">
                <i class="fas fa-chart-area text-primary mr-2"></i>Evolución de Ventas vs Cotizaciones por Mes
            </h6>
            <span class="small text-muted">Doble eje Y: Volumen (barras) e Importe en pesos (línea dorada)</span>
        </div>
        <div class="card-body">
            <div style="position: relative; min-height: 380px; max-height: 480px; width: 100%;">
                <canvas id="ventasChart"></canvas>
            </div>
        </div>
    </div>
</div>
