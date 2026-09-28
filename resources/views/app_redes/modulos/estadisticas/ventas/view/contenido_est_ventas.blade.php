<style>
    /* Dashboard stats cards (más pro) */
    .stats-grid {
        margin-bottom: 1rem;
    }

    .stat-card {
        border: 0 !important;
        border-radius: 14px !important;
        overflow: hidden;
        background: #fff;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .08) !important;
        transition: transform .15s ease, box-shadow .15s ease;
    }

    .stat-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, .12) !important;
    }

    .stat-card .card-body {
        padding: 16px 16px 14px !important;
        display: flex;
        align-items: flex-start;
        justify-content: space-between;
        gap: 12px;
    }

    .stat-meta {
        display: flex;
        flex-direction: column;
        gap: 6px;
        min-width: 0;
    }

    .stat-label {
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .12em;
        text-transform: uppercase;
        color: #6b7280;
        margin: 0;
        line-height: 1.2;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        max-width: 100%;
    }

    .stat-value {
        font-size: 22px;
        font-weight: 600;
        color: #111827;
        margin: 0;
        line-height: 1.1;
        letter-spacing: -.02em;
    }

    .stat-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        flex: 0 0 auto;
        background: rgba(59, 130, 246, .10);
        color: #2563eb;
    }

    .stat-icon svg {
        width: 18px;
        height: 18px;
    }

    .stat-accent {
        position: absolute;
        left: 0;
        top: 0;
        bottom: 0;
        width: 6px;
        background: #2563eb;
    }

    /* Variantes por tipo */
    .stat-success .stat-accent {
        background: #16a34a;
    }

    .stat-success .stat-icon {
        background: rgba(22, 163, 74, .12);
        color: #16a34a;
    }

    .stat-primary .stat-accent {
        background: #2563eb;
    }

    .stat-primary .stat-icon {
        background: rgba(37, 99, 235, .12);
        color: #2563eb;
    }

    .stat-warning .stat-accent {
        background: #f59e0b;
    }

    .stat-warning .stat-icon {
        background: rgba(245, 158, 11, .14);
        color: #b45309;
    }

    .stat-danger .stat-accent {
        background: #ef4444;
    }

    .stat-danger .stat-icon {
        background: rgba(239, 68, 68, .14);
        color: #ef4444;
    }

    /* Responsivo: separación más limpia */
    @media (max-width: 575px) {
        .stat-value {
            font-size: 20px;
        }

        .stat-icon {
            width: 38px;
            height: 38px;
            border-radius: 12px;
        }
    }

    /* Cards de Productos Más Vendidos */
    .producto-card {
        border: 0 !important;
        border-radius: 14px !important;
        background: #fff;
        box-shadow: 0 10px 26px rgba(15, 23, 42, .08) !important;
        transition: transform .15s ease, box-shadow .15s ease;
        overflow: hidden;
    }

    .producto-card:hover {
        transform: translateY(-2px);
        box-shadow: 0 14px 34px rgba(15, 23, 42, .12) !important;
    }

    .producto-card .card-body {
        padding: 18px 16px 16px !important;
    }

    .producto-rank-badge {
        position: absolute;
        top: 12px;
        right: 12px;
        font-size: 11px;
        font-weight: 800;
        letter-spacing: .04em;
        padding: 3px 9px;
        border-radius: 999px;
        color: #fff;
        background: #94a3b8;
        z-index: 1;
    }

    .producto-rank-badge.rank-1 {
        background: linear-gradient(135deg, #f59e0b, #d97706);
    }

    .producto-rank-badge.rank-2 {
        background: linear-gradient(135deg, #94a3b8, #64748b);
    }

    .producto-rank-badge.rank-3 {
        background: linear-gradient(135deg, #c2703d, #9a5227);
    }

    .producto-icon {
        width: 40px;
        height: 40px;
        border-radius: 12px;
        display: grid;
        place-items: center;
        background: rgba(37, 99, 235, .10);
        color: #2563eb;
        margin-bottom: 12px;
    }

    .producto-icon svg {
        width: 18px;
        height: 18px;
    }

    .producto-nombre {
        font-size: 14px;
        font-weight: 700;
        color: #111827;
        margin: 0 0 12px;
        line-height: 1.3;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .producto-stats {
        display: flex;
        gap: 18px;
        border-top: 1px solid #f1f5f9;
        padding-top: 10px;
    }

    .producto-stat {
        display: flex;
        flex-direction: column;
        gap: 2px;
    }

    .producto-stat-value {
        font-size: 16px;
        font-weight: 600;
        color: #111827;
        letter-spacing: -.01em;
    }

    .producto-stat-label {
        font-size: 10px;
        font-weight: 700;
        letter-spacing: .08em;
        text-transform: uppercase;
        color: #9ca3af;
    }

    @media (max-width: 575px) {
        .producto-nombre {
            font-size: 13px;
        }

        .producto-stat-value {
            font-size: 15px;
        }
    }
</style>



<div class="container-fluid">
    <!-- Título Principal -->
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="font-weight-bold text-primary">Estadísticas de Ventas</h2>
        </div>
    </div>


    <!-- Filtros -->
    <div class="row mb-4 mt-5">
        <div class="col-lg-3">
            <label for="fecha_inicio" class="form-label">Fecha Inicio:</label>
            <input type="date" id="fecha_inicio" class="form-control">
        </div>
        <div class="col-lg-3">
            <label for="fecha_fin" class="form-label">Fecha Fin:</label>
            <input type="date" id="fecha_fin" class="form-control">
        </div>
        <div class="col-lg-4 d-flex align-items-end">
            <button class="btn btn-primary ml-3 rounded-pill px-4 py-2 font-weight-bold"
                onclick="filtrarEstadisticas()">
                <i class="fas fa-filter mr-2"></i>Filtrar</button>
        </div>
    </div>

    <!-- Resumen de Estadísticas (pro) -->
    <div class="row stats-grid">

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-success h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Cotizaciones</p>
                        <p id="numCotizaciones" class="stat-value">{{ $numCotizaciones }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: doc -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M6 2h9l5 5v15a2 2 0 0 1-2 2H6a2 2 0 0 1-2-2V4a2 2 0 0 1 2-2zm8 1.5V8h4.5L14 3.5z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-success h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Ventas</p>
                        <p id="numeroVentas" class="stat-value">{{ $numeroVentas }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: cart -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M7 4h-2l-1 2v2h2l3.6 7.59-1.35 2.44A1 1 0 0 0 9.12 22H19v-2H9.42a.25.25 0 0 1-.22-.37L10 18h7a1 1 0 0 0 .9-.55L21 9H6.21L5.27 7H7V4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-primary h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Total cotizado</p>
                        <p id="totalCotizaciones" class="stat-value">${{ $totalCotizaciones }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: chart -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M4 19h16v2H2V3h2v16zm3-2V9h3v8H7zm5 0V5h3v12h-3zm5 0v-6h3v6h-3z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-primary h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Total vendido</p>
                        <p id="totalVentas" class="stat-value">${{ $totalVentas }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: money -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M3 6h18a2 2 0 0 1 2 2v8a2 2 0 0 1-2 2H3a2 2 0 0 1-2-2V8a2 2 0 0 1 2-2zm0 2v8h18V8H3zm9 1a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-danger h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Impuesto (IVA)</p>
                        <p id="totalIVA" class="stat-value">${{ $totalIVA }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: receipt -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path d="M7 2h10v20l-2-1-2 1-2-1-2 1-2-1-2 1V2zm2 4h6v2H9V6zm0 4h6v2H9v-2zm0 4h5v2H9v-2z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-danger h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Envíos</p>
                        <p id="totalEnvios" class="stat-value">${{ $totalEnvios }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: truck -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M3 6h11v9H3V6zm12 3h3l3 3v3h-6V9zm-9 9a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-danger h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Paquetería</p>
                        <p id="totalEnviosPaqueteria" class="stat-value">${{ $totalEnviosPaqueteria }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: truck -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M3 6h11v9H3V6zm12 3h3l3 3v3h-6V9zm-9 9a2 2 0 1 0 0 4 2 2 0 0 0 0-4zm12 0a2 2 0 1 0 0 4 2 2 0 0 0 0-4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-warning h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Ticket promedio</p>
                        <p id="promedioVentas" class="stat-value">${{ $promedioVentas }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: target -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2a10 10 0 1 1 0 20 10 10 0 0 1 0-20zm0 4a6 6 0 1 0 0 12 6 6 0 0 0 0-12zm0 3a3 3 0 1 1 0 6 3 3 0 0 1 0-6z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card stat-card stat-success h-100 position-relative">
                <span class="stat-accent"></span>
                <div class="card-body">
                    <div class="stat-meta">
                        <p class="stat-label">Total Neto</p>
                        <p id="totalNeto" class="stat-value">${{ $totalNeto }}</p>
                    </div>
                    <div class="stat-icon" aria-hidden="true">
                        <!-- icon: shield/check -->
                        <svg viewBox="0 0 24 24" fill="currentColor">
                            <path
                                d="M12 2l8 4v6c0 5-3.4 9.4-8 10-4.6-.6-8-5-8-10V6l8-4zm-1 13l6-6-1.4-1.4L11 12.2 8.4 9.6 7 11l4 4z" />
                        </svg>
                    </div>
                </div>
            </div>
        </div>



    </div>

    {{-- Productos Más Vendidos --}}
    <div class="row">
        <div class="col">
            <h6 class="text-primary font-weight-bold mb-3">Productos Más Vendidos</h6>
        </div>
    </div>

    <div class="row producto-cards-grid mb-4" id="productosMasVendidos">
        @foreach ($productosMasVendidos as $index => $producto)
            <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
                <div class="card producto-card h-100 position-relative">
                    <span class="producto-rank-badge rank-{{ $index + 1 }}">#{{ $index + 1 }}</span>
                    <div class="card-body">
                        <p class="producto-nombre">{{ $producto->nombre }}</p>
                        <div class="producto-stats">
                            <div class="producto-stat">
                                <span class="producto-stat-value">{{ $producto->cantidad_vendida }}</span>
                                <span class="producto-stat-label">Unidades</span>
                            </div>
                            <div class="producto-stat">
                                <span class="producto-stat-value">${{ $producto->total_vendido }}</span>
                                <span class="producto-stat-label">Total</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- Vendedores Principales -->
    <div class="row mb-4">
        <div class="col">
            <div class="card shadow">
                <div class="card-header text-center">
                    <h5 class="text-uppercase text-primary font-weight-bold">Estadisticas Vendedores</h5>
                </div>
                <div class="card-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th class="estadisticas-titulos">Vendedor</th>
                                <th class="estadisticas-titulos"># Cotizaciones</th>
                                <th class="estadisticas-titulos"># Ventas</th>
                                <th class="estadisticas-titulos">Total Cotizado</th>
                                <th class="estadisticas-titulos">Total Vendido</th>
                                <th class="estadisticas-titulos">Promedio de exito</th>
                                <th class="estadisticas-titulos">Cliente estrella⭐</th>
                            </tr>
                        </thead>
                        <tbody id="vendedoresPrincipales">
                            @foreach ($vendedoresPrin as $vendedor)
                                <tr>
                                    <td>{{ $vendedor->nombre }}</td>
                                    <td>{{ $vendedor->numero_cotizaciones }}</td>
                                    <td>{{ $vendedor->numero_ventas }}</td>
                                    <td>${{ $vendedor->total_cotizado }}</td>
                                    <td>${{ $vendedor->total_generado }}</td>
                                    <td>{{ $vendedor->promedio_exito }}%</td>
                                    <td>{{ $vendedor->cliente_estrella }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    {{-- Grafica ventas por mes --}}
    <h6 class="text-primary font-weight-bold">Ventas por mes</h6>
    <div class="row mb-3">
        <div class="col-md-3">
            <div class="form-group">
                <label for="chart_fecha_inicio">Fecha inicio:</label>
                <input type="date" id="chart_fecha_inicio" class="form-control">
            </div>
        </div>
        <div class="col-md-3">
            <div class="form-group">
                <label for="chart_fecha_fin">Fecha fin:</label>
                <input type="date" id="chart_fecha_fin" class="form-control">
            </div>
        </div>
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="d-flex flex-wrap">
                    <button id="aplicar_filtro_fechas"
                        class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold mb-2">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <button id="limpiar_filtros"
                        class="btn btn-secondary rounded-pill px-4 py-2 font-weight-bold mb-2">
                        <i class="fas fa-broom mr-2"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="graficas-ventas-container">
        <canvas id="ventasChart"></canvas>
    </div>

</div>
