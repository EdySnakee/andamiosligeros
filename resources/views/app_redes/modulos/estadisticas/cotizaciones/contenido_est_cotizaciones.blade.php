<div class="container-fluid">
    <!-- Título Principal -->
    <div class="row mb-4">
        <div class="col text-center">
            <h2 class="font-weight-bold text-primary">Estadísticas de Cotizaciones</h2>
        </div>
    </div>

    <h6 class="text-primary font-weight-bold">Cotizaciones por día</h6>
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
        @if (\Auth::User()->id == 2 || \Auth::User()->id == 14)
        <div class="col-md-4">
            <div class="form-group">
                <label>Filtrar por sucursales (máx. 3):</label>
                <div id="sucursales_container" class="border p-2 rounded" style="max-height: 150px; overflow-y: auto;">
                    <!-- Los checkboxes se agregarán aquí dinámicamente -->
                </div>
            </div>
        </div>
        @endif
        <div class="col-md-2">
            <div class="form-group">
                <label>&nbsp;</label>
                <div class="d-flex flex-wrap">
                    <button id="aplicar_filtro_fechas" class="btn btn-primary rounded-pill px-4 py-2 font-weight-bold mb-2">
                        <i class="fas fa-filter mr-2"></i>Filtrar
                    </button>
                    <button id="limpiar_filtros" class="btn btn-secondary rounded-pill px-4 py-2 font-weight-bold mb-2">
                        <i class="fas fa-broom mr-2"></i>Limpiar
                    </button>
                </div>
            </div>
        </div>
    </div>
    <div class="graficas-cotizaciones-container mb-5">
        <canvas id="cotizacionesChart"></canvas>
    </div>
</div>