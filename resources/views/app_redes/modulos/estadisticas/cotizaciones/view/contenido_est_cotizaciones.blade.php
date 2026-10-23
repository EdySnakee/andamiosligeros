<style>
    :root {
        --color-primary: #0848af;
        --color-primary-light: #e8f0fe;
        --color-success: #10b981;
        --color-success-light: #ecfdf5;
        --color-warning: #f59e0b;
        --color-warning-light: #fffbeb;
        --color-purple: #8b5cf6;
        --color-purple-light: #f5f3ff;
        --color-cyan: #06b6d4;
        --color-cyan-light: #ecfeff;
    }

    .coti-stat-card {
        border: 0 !important;
        border-radius: 16px !important;
        overflow: hidden;
        background: #ffffff;
        box-shadow: 0 4px 20px rgba(15, 23, 42, 0.06) !important;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
    }

    .coti-stat-card:hover {
        transform: translateY(-3px);
        box-shadow: 0 12px 28px rgba(15, 23, 42, 0.12) !important;
    }

    .coti-stat-card .card-body {
        padding: 20px 22px !important;
        display: flex;
        align-items: center;
        justify-content: space-between;
        gap: 16px;
    }

    .coti-accent {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 5px;
        background: var(--color-primary);
    }

    .coti-card-primary .coti-accent { background: var(--color-primary); }
    .coti-card-success .coti-accent { background: var(--color-success); }
    .coti-card-warning .coti-accent { background: var(--color-warning); }
    .coti-card-purple .coti-accent  { background: var(--color-purple); }
    .coti-card-cyan .coti-accent    { background: var(--color-cyan); }

    .coti-meta {
        display: flex;
        flex-direction: column;
        gap: 4px;
        min-width: 0;
    }

    .coti-label {
        font-size: 11px;
        font-weight: 700;
        letter-spacing: 0.08em;
        text-transform: uppercase;
        color: #64748b;
        margin: 0;
    }

    .coti-value {
        font-size: 24px;
        font-weight: 700;
        color: #0f172a;
        margin: 0;
        line-height: 1.15;
        letter-spacing: -0.02em;
    }

    .coti-sublabel {
        font-size: 11px;
        color: #94a3b8;
        margin: 0;
    }

    .coti-icon {
        width: 48px;
        height: 48px;
        border-radius: 14px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        font-size: 20px;
    }

    .coti-card-primary .coti-icon { background: var(--color-primary-light); color: var(--color-primary); }
    .coti-card-success .coti-icon { background: var(--color-success-light); color: var(--color-success); }
    .coti-card-warning .coti-icon { background: var(--color-warning-light); color: var(--color-warning); }
    .coti-card-purple .coti-icon  { background: var(--color-purple-light); color: var(--color-purple); }
    .coti-card-cyan .coti-icon    { background: var(--color-cyan-light); color: var(--color-cyan); }

    /* Barra de Filtros */
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

    .sucursales-box {
        border: 1px solid #e2e8f0;
        border-radius: 10px;
        padding: 8px 12px;
        background: #f8fafc;
        max-height: 120px;
        overflow-y: auto;
    }

    .sucursales-box .custom-control {
        margin-bottom: 4px;
    }
</style>

<div class="container-fluid py-2">
    <!-- Encabezado de Página -->
    <div class="d-flex align-items-center justify-content-between mb-4 flex-wrap">
        <div>
            <h2 class="font-weight-bold text-gray-800 mb-1" style="font-size: 1.65rem;">
                <i class="fas fa-file-invoice text-primary mr-2"></i>Estadísticas de Cotizaciones
            </h2>
            <p class="text-muted mb-0 small">Análisis de prospección comercial, volumen cotizado y actividad por división.</p>
        </div>
        <div class="mt-2 mt-sm-0">
            <span class="badge badge-light border text-secondary px-3 py-2 font-weight-normal">
                <i class="fas fa-chart-bar mr-1 text-primary"></i> Tendencias de prospección
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
                <button type="button" class="preset-pill active" onclick="setCotiPreset('todo', this)">Todo el Historial</button>
                <button type="button" class="preset-pill" onclick="setCotiPreset('este_mes', this)">Este Mes</button>
                <button type="button" class="preset-pill" onclick="setCotiPreset('mes_pasado', this)">Mes Anterior</button>
                <button type="button" class="preset-pill" onclick="setCotiPreset('30_dias', this)">Últimos 30 días</button>
                <button type="button" class="preset-pill" onclick="setCotiPreset('15_dias', this)">Últimos 15 días</button>
                <button type="button" class="preset-pill" onclick="setCotiPreset('este_ano', this)">Año en Curso</button>
            </div>
        </div>
        <div class="row align-items-end">
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label for="chart_fecha_inicio" class="small text-muted font-weight-bold mb-1">Fecha Inicio:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-alt text-muted"></i></span>
                    </div>
                    <input type="date" id="chart_fecha_inicio" class="form-control border-left-0">
                </div>
            </div>
            <div class="col-md-3 col-sm-6 mb-2 mb-md-0">
                <label for="chart_fecha_fin" class="small text-muted font-weight-bold mb-1">Fecha Fin:</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-white border-right-0"><i class="far fa-calendar-alt text-muted"></i></span>
                    </div>
                    <input type="date" id="chart_fecha_fin" class="form-control border-left-0">
                </div>
            </div>

            @if (\Auth::check() && (\Auth::user()->isAdmin() || in_array(\Auth::user()->id, [2, 14])))
                <div class="col-md-4 col-sm-12 mb-2 mb-md-0">
                    <label class="small text-muted font-weight-bold mb-1">
                        Comparar Sucursales (máx. 3):
                    </label>
                    <div id="sucursales_container" class="sucursales-box">
                        <span class="text-muted small"><i class="fas fa-spinner fa-spin mr-1"></i> Cargando sucursales...</span>
                    </div>
                </div>
                <div class="col-md-2 col-sm-12 d-flex">
            @else
                <div class="col-md-6 col-sm-12 d-flex">
            @endif
                <button id="aplicar_filtro_fechas" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold flex-grow-1 shadow-sm">
                    <i class="fas fa-filter mr-1"></i> Filtrar
                </button>
                <button id="limpiar_filtros" class="btn btn-outline-secondary rounded-pill px-3 py-2 font-weight-bold ml-2" title="Restablecer">
                    <i class="fas fa-redo-alt"></i>
                </button>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 1: Métricas Generales (4 Tarjetas) -->
    <div class="d-flex align-items-center mb-3">
        <h6 class="font-weight-bold text-uppercase text-secondary small mb-0 tracking-wider">
            <i class="fas fa-chart-pie text-primary mr-1"></i> Resumen de Cotizaciones
        </h6>
        <div class="flex-grow-1 border-bottom ml-3"></div>
    </div>

    <div class="row mb-4">
        <!-- Total Cotizaciones -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-primary h-100">
                <span class="coti-accent"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label">Total Cotizaciones</p>
                        <p id="coti_total_num" class="coti-value">{{ number_format($metricas['totalCotizaciones']) }}</p>
                        <p class="coti-sublabel">Propuestas emitidas</p>
                    </div>
                    <div class="coti-icon">
                        <i class="fas fa-file-invoice"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Importe Total Cotizado -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-success h-100">
                <span class="coti-accent"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label">Importe Cotizado</p>
                        <p id="coti_total_importe" class="coti-value text-success">${{ $metricas['totalImporte'] }}</p>
                        <p class="coti-sublabel">Volumen total estimado</p>
                    </div>
                    <div class="coti-icon">
                        <i class="fas fa-coins"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Ticket Promedio Cotizado -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-warning h-100">
                <span class="coti-accent"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label">Promedio por Cotización</p>
                        <p id="coti_promedio_importe" class="coti-value">${{ $metricas['promedioImporte'] }}</p>
                        <p class="coti-sublabel">Ticket medio cotizado</p>
                    </div>
                    <div class="coti-icon">
                        <i class="fas fa-calculator"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Promedio por Día Activo -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-purple h-100">
                <span class="coti-accent"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label">Ritmo de Emisión</p>
                        <p id="coti_promedio_dia" class="coti-value">{{ $metricas['promedioPorDia'] }} <span class="small font-weight-normal text-muted">/ día</span></p>
                        <p class="coti-sublabel">En <span id="coti_dias_activos" class="font-weight-bold">{{ number_format($metricas['diasActivos']) }}</span> días activos</p>
                    </div>
                    <div class="coti-icon">
                        <i class="fas fa-bolt"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 2: Desglose por División Comercial / Giro de Empresa (4 Tarjetas) -->
    <div class="d-flex align-items-center mb-3">
        <h6 class="font-weight-bold text-uppercase text-secondary small mb-0 tracking-wider">
            <i class="fas fa-building text-info mr-1"></i> Desglose por División Comercial
        </h6>
        <div class="flex-grow-1 border-bottom ml-3"></div>
    </div>

    <div class="row mb-4" id="giros_container">
        <!-- Andamios Ligeros -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-primary h-100">
                <span class="coti-accent" style="background: #0848af;"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label" style="color: #0848af;">Andamios Ligeros</p>
                        <p id="giro_total_al" class="coti-value">{{ number_format($giros['al']['total'] ?? 0) }}</p>
                        <p class="coti-sublabel">
                            Total: <strong id="giro_importe_al" class="text-primary">${{ $giros['al']['importe'] ?? '0.00' }}</strong>
                        </p>
                    </div>
                    <div class="coti-icon" style="background: rgba(8, 72, 175, 0.12); color: #0848af;">
                        <i class="fas fa-cubes"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Redes Anticaídas -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-success h-100">
                <span class="coti-accent" style="background: #10b981;"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label" style="color: #10b981;">Redes Anticaídas</p>
                        <p id="giro_total_ra" class="coti-value">{{ number_format($giros['ra']['total'] ?? 0) }}</p>
                        <p class="coti-sublabel">
                            Total: <strong id="giro_importe_ra" class="text-success">${{ $giros['ra']['importe'] ?? '0.00' }}</strong>
                        </p>
                    </div>
                    <div class="coti-icon" style="background: rgba(16, 185, 129, 0.12); color: #10b981;">
                        <i class="fas fa-shield-alt"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Redes Perimetrales -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-warning h-100">
                <span class="coti-accent" style="background: #f59e0b;"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label" style="color: #d97706;">Redes Perimetrales</p>
                        <p id="giro_total_rp" class="coti-value">{{ number_format($giros['rp']['total'] ?? 0) }}</p>
                        <p class="coti-sublabel">
                            Total: <strong id="giro_importe_rp" class="text-warning">${{ $giros['rp']['importe'] ?? '0.00' }}</strong>
                        </p>
                    </div>
                    <div class="coti-icon" style="background: rgba(245, 158, 11, 0.12); color: #d97706;">
                        <i class="fas fa-border-all"></i>
                    </div>
                </div>
            </div>
        </div>

        <!-- Scoregol -->
        <div class="col-xl-3 col-md-6 mb-3">
            <div class="card coti-stat-card coti-card-cyan h-100">
                <span class="coti-accent" style="background: #06b6d4;"></span>
                <div class="card-body">
                    <div class="coti-meta">
                        <p class="coti-label" style="color: #0891b2;">Scoregol</p>
                        <p id="giro_total_sg" class="coti-value">{{ number_format($giros['sg']['total'] ?? 0) }}</p>
                        <p class="coti-sublabel">
                            Total: <strong id="giro_importe_sg" style="color: #0891b2;">${{ $giros['sg']['importe'] ?? '0.00' }}</strong>
                        </p>
                    </div>
                    <div class="coti-icon" style="background: rgba(6, 182, 212, 0.12); color: #0891b2;">
                        <i class="fas fa-futbol"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- SECCIÓN 3: Gráfica de Cotizaciones por Día -->
    <div class="card shadow-sm border-0 rounded-lg mb-4" style="border-radius: 16px;">
        <div class="card-header bg-white py-3 border-bottom d-flex align-items-center justify-content-between flex-wrap">
            <h6 class="m-0 font-weight-bold text-gray-800">
                <i class="fas fa-chart-bar text-primary mr-2"></i>Cotizaciones Realizadas por Día
            </h6>
            <span class="small text-muted">Distribución cronológica del volumen diario</span>
        </div>
        <div class="card-body">
            <div style="position: relative; min-height: 380px; max-height: 480px; width: 100%;">
                <canvas id="cotizacionesChart"></canvas>
            </div>
        </div>
    </div>
</div>