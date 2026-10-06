<div class="container-fluid">
    <div class="card shadow-sm border-0 mb-4" style="border-radius: 12px; overflow: hidden;">
        
        {{-- HEADER DEL PANEL --}}
        <div class="card-header py-3 bg-white border-bottom d-flex flex-wrap align-items-center justify-content-between" style="border-color: #edf2f9;">
            <div class="d-flex align-items-center">
                <h4 class="m-0 font-weight-bold" style="color: #0948AF; font-size: 1.35rem;">
                    <i class="fas fa-calculator mr-2" style="opacity: 0.85;"></i>Cotizaciones
                </h4>
                <span id="cotizaciones-counter" class="badge badge-light border ml-3 text-secondary shadow-sm" style="font-size: 0.82rem; font-weight: 600; padding: 6px 12px; border-radius: 20px;">
                    <i class="fas fa-file-invoice text-muted mr-1"></i> <span id="counter-val">{{ $listado_cotizaciones->total() }}</span> registros
                </span>
            </div>
            <div class="d-flex align-items-center mt-2 mt-md-0" style="gap: 8px;">
                <button type="button" class="btn btn-outline-secondary btn-sm px-3" id="btn-limpiar-filtros" title="Restablecer todos los filtros" style="border-radius: 6px; font-weight: 500;">
                    <i class="fas fa-undo mr-1"></i> Limpiar filtros
                </button>
                <button type="button" class="btn btn-success btn-sm px-3 shadow-sm" id="exportarExcel" title="Exportar cotizaciones filtradas a Excel" style="border-radius: 6px; font-weight: 600; background-color: #1cc88a; border-color: #1cc88a;">
                    <i class="fas fa-file-excel mr-1"></i> Exportar Excel
                </button>
            </div>
        </div>

        {{-- BARRA DE FILTROS AVANZADOS --}}
        <div class="card-body p-3 p-md-4" style="background-color: #f8fafc; border-bottom: 1px solid #edf2f9;">
            <div class="row align-items-end">
                {{-- Búsqueda avanzada --}}
                <div class="col-lg-4 col-md-6 mb-3 mb-lg-0">
                    <label class="small font-weight-bold text-muted mb-1 d-flex align-items-center" style="white-space: nowrap;">
                        <i class="fas fa-search text-primary mr-1" style="font-size: 0.78rem;"></i> Búsqueda general
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="filtrar_busqueda" class="form-control" placeholder="Cliente, teléfono, código o lead..." style="border-radius: 6px 0 0 6px;">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white text-muted" style="border-radius: 0 6px 6px 0; border-left: 0;">
                                <i class="fas fa-search fa-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Buscar Vendedor --}}
                <div class="col-lg-2 col-md-3 mb-3 mb-lg-0">
                    <label class="small font-weight-bold text-muted mb-1 d-flex align-items-center" style="white-space: nowrap;">
                        <i class="fas fa-user-tie text-primary mr-1" style="font-size: 0.78rem;"></i> Vendedor
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="filtro_usuario" class="form-control" placeholder="Nombre vendedor..." style="border-radius: 6px 0 0 6px;">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white text-muted" style="border-radius: 0 6px 6px 0; border-left: 0;">
                                <i class="fas fa-user fa-xs"></i>
                            </span>
                        </div>
                    </div>
                </div>

                {{-- Filtro Estatus --}}
                <div class="col-lg-2 col-md-3 mb-3 mb-lg-0">
                    <label class="small font-weight-bold text-muted mb-1 d-flex align-items-center" style="white-space: nowrap;">
                        <i class="fas fa-tag text-primary mr-1" style="font-size: 0.78rem;"></i> Estatus
                    </label>
                    <select id="filtro_status" class="form-control form-control-sm" style="border-radius: 6px; cursor: pointer;">
                        <option value="">Todos los estatus</option>
                        <option value="1">Activo</option>
                        <option value="3">Aceptada</option>
                        <option value="4">Pendiente</option>
                        <option value="5">Vencida</option>
                        <option value="6">Facturado</option>
                        <option value="2">Inactivo</option>
                    </select>
                </div>

                {{-- Rango de Fechas Único --}}
                <div class="col-lg-3 col-md-6 mb-3 mb-lg-0">
                    <label class="small font-weight-bold text-muted mb-1 d-flex align-items-center" style="white-space: nowrap;">
                        <i class="fas fa-calendar-alt text-primary mr-1" style="font-size: 0.78rem;"></i> Rango de fechas
                    </label>
                    <div class="input-group input-group-sm">
                        <input type="text" id="filtro_rango_fechas" class="form-control bg-white" placeholder="Todas las fechas" readonly style="cursor: pointer; border-radius: 6px 0 0 6px;">
                        <div class="input-group-append">
                            <span class="input-group-text bg-white text-muted" style="border-radius: 0 6px 6px 0; border-left: 0; cursor: pointer;" id="btn-icono-calendario">
                                <i class="fas fa-calendar-alt fa-xs"></i>
                            </span>
                        </div>
                    </div>
                    <input type="hidden" id="fecha_inicio" value="">
                    <input type="hidden" id="fecha_fin" value="">
                </div>

                {{-- Número de filas --}}
                <div class="col-lg-1 col-md-6 mb-3 mb-lg-0">
                    <label class="small font-weight-bold text-muted mb-1 d-flex align-items-center" style="white-space: nowrap;">
                        <i class="fas fa-list-ol text-primary mr-1" style="font-size: 0.78rem;"></i> Filas
                    </label>
                    <select id="change-page-size" class="form-control form-control-sm" style="border-radius: 6px; cursor: pointer;">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                    </select>
                </div>
            </div>
        </div>

        {{-- TABLA DE COTIZACIONES --}}
        <div class="card-body p-0">
            <div class="table-responsive">
                <table id="tblPrincCoti" class="table table-hover table-striped mb-0" width="100%" cellspacing="0" style="text-align:center;">
                    <thead class="bg-light text-secondary font-weight-bold" style="font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.5px; border-bottom: 2px solid #edf2f9;">
                        <tr>
                            <th style="width: 45px;"></th>
                            <th>COD</th>
                            <th style="text-align:left;">Cliente</th>
                            <th>Lead</th>
                            <th>Sucursal</th>
                            <th>Fecha</th>
                            <th>Total</th>
                            <th>Estatus</th>
                            <th>Mercado Pago</th>
                            <th>Cotizó</th>
                            <th style="display:none;">URL COTIZACION</th>
                            <th>Acción</th>
                        </tr>
                    </thead>
                    <tbody id="tabla_cotizaciones">
                        @include('app_redes.modulos.cotizador.tabla_listado_cotizaciones')
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
