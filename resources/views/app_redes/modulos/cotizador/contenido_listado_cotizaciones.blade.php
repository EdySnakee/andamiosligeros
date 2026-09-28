<div class="container-fluid">
    <div class="card shadow mb-4">
        <div class="card-header py-3">
            <h3 class="m-0 font-weight-bold text-primary">Cotizaciones</h3>
            <br>
            <span id="limpia_filtros" style="position: absolute;top: 15px;right: 15px;"><a href="">Limpiar
                    filtros</a></span>
            <div class="row">
                <div class="col-md-3 col-sm-3">
                    <span class="tfh-label">Busqueda avanzada: </span>
                    <div class="input-group">
                        <input type="text" id="filtrar_busqueda" class="form-control small"
                            placeholder="Busqueda por cliente, teléfono, o num cotización" aria-label="Search"
                            aria-describedby="basic-addon2">
                        <div class="input-group-append">
                            <button class="btn btn-primary btn-sm" type="button" disabled>
                                <i class="fas fa-search fa-sm"></i>
                            </button>
                        </div>
                    </div>
                </div>
                <div class="col-md-2 col-sm-2">
                    <span class="tfh-label">Buscar vendedor: </span>
                    <input class="form-control" id="filtro_usuario" type="text" />
                </div>
                <div class="col-md-1 col-sm-1">
                    <span class="tfh-label"># filas: </span>
                    <select id="change-page-size" class="form-control">
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="50">50</option>
                        <option value="100">100</option>
                        <option value="200">200</option>
                        <option value="500">500</option>
                    </select>
                </div>
                <div class="col-md-2 col-sm-2">
                    <span class="tfh-label">Fecha Inicio: </span>
                    <input class="form-control" id="fecha_inicio" type="date" />
                </div>
                <div class="col-md-2 col-sm-2">
                    <span class="tfh-label">Fecha Fin: </span>
                    <input class="form-control" id="fecha_fin" type="date" />
                </div>
                <div class="col-md-2 col-sm-2" style="display: flex; align-items: flex-end;">
                    <button class="btn btn-primary btn-md" id="exportarExcel"> <i class="fas fa-file-excel"></i>
                        Exportar Excel</button>
                </div>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table id="tblPrincCoti" class="table table-bordered" width="100%" cellspacing="0"
                    style="text-align:center;">
                    <thead>
                        <tr>
                            <th>+</th>
                            <th>COD</th>
                            <th>Cliente</th>
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
