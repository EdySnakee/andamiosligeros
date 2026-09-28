<div class="container-fluid">
    {{-- Contenedor estadisticas --}}
    <div class="row">

        {{-- ESTADISTICAS MERIDA --}}
        <div class="col-lg-6 mb-4">
            <div class="card shadow mb-4">
                <div class="card-header d-flex justify-content-center">
                    <h4 class="m-0 font-weight-bold text-primary">ESTADISTICAS MÉRIDA</h4>
                </div>
                <div class="container">

                    {{-- FECHAS --}}
                    <div class="row d-flex align-items-center g-3 my-4">
                        <!-- Campo de fecha de inicio -->
                        <div class="col-md-6 col-sm-6">
                            <label for="fecha_inicio" class="form-label tfh-label">Fecha Inicio:</label>
                            <input type="date" id="fecha_inicio" class="form-control" />
                        </div>

                        <!-- Campo de fecha de fin -->
                        <div class="col-md-6 col-sm-6">
                            <label for="fecha_fin" class="form-label tfh-label">Fecha Fin:</label>
                            <input type="date" id="fecha_fin" class="form-control" />
                        </div>
                    </div>

                    <!-- Cotizaciones y Ventas -->
                    <div class="col-xl-12 col-md-12 my-2">
                        <div class="card border-left-warning shadow h-100">
                            <div class="card-body">
                                <div class="row">

                                    <!-- Cotizaciones -->
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <!-- Número de Cotizaciones -->
                                            <div class="col-6 d-flex align-items-center">
                                                <div>
                                                    <div
                                                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Cotizaciones
                                                    </div>
                                                    <div class="h4 mb-0 font-weight-bold text-gray-800" id="numCotMID">0
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Total Cotizaciones -->
                                            <div class="col-6 d-flex align-items-center">
                                                <div>
                                                    <div
                                                        class="text-xs font-weight-bold text-primary text-uppercase mb-1">
                                                        Total Cotizado
                                                    </div>
                                                    <div
                                                        class="h4 mb-0 font-weight-bold text-gray-800 text-nowrap"id="totalCotMID">
                                                        0</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Ventas Aceptadas -->
                                    <div class="col-md-6">
                                        <div class="row mb-3">
                                            <!-- Cotizaciones Aceptadas -->
                                            <div class="col-6 d-flex align-items-center">
                                                <div>
                                                    <div
                                                        class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Aceptadas
                                                    </div>
                                                    <div class="h4 mb-0 font-weight-bold text-gray-800" id="numVentMID">
                                                        0</div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <!-- Total Aceptado -->
                                            <div class="col-6 d-flex align-items-center">
                                                <div>
                                                    <div
                                                        class="text-xs font-weight-bold text-success text-uppercase mb-1">
                                                        Total Aceptado
                                                    </div>
                                                    <div class="h4 mb-0 font-weight-bold text-gray-800 text-nowrap"
                                                        id="totalVentMID">0</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>
