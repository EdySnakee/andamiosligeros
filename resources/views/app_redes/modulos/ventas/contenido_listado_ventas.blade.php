<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Ventas</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3" style="display:flex; align-items:center; justify-content:space-between;">
      <div style="display:flex; align-items:center; gap:12px;">
        <h6 class="m-0 font-weight-bold text-primary">Todas las ventas</h6>
        <span id="ventas-total-count" style="color:#999; font-size:0.82em; font-weight:normal;"></span>
      </div>
      <div style="display:flex; align-items:center; gap:8px;">
        <button id="btn-exportar-ventas" class="btn btn-sm btn-outline-success">
          <i class="fas fa-file-excel"></i> Exportar Excel
        </button>
        <span id="limpia_filtros"><a href="">Limpiar filtros</a></span>
      </div>
    </div>
    <div class="card-body">
      <div class="table-filter-header">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  {{-- Giro empresarial oculto visualmente (lógica JS intacta) --}}
                  {{-- <div class="col-md-3 col-sm-4">
                      <span class="tfh-label">Giro empresarial: </span>
                      <select class="form-control js-example-basic-single" id="giro_empresa" placeholder="Giro" >
                        <option value="" selected>Todos</option>
                        <option value="ra">Redes Anticaidas</option>
                        <option value="rp">Redes perimetrales</option>
                        <option value="sg">Scoregol</option>
                        <option value="al">Andamios Ligeros</option>
                      </select>
                  </div> --}}
                  <select class="d-none" id="giro_empresa"><option value="" selected></option></select>
                  <div class="col-md-3 col-sm-4 pl-4">
                      <span class="tfh-label">Buscar por cliente: </span>
                      <input class="form-control" id="filtrar_busqueda" type="text" />
                  </div>
                  <div class="col-md-3 col-sm-4">
                      <span class="tfh-label">Buscar por venta: </span>
                      <input class="form-control" id="filtrar_busqueda_venta" type="number" />
                  </div>
                  {{-- <div class="col-md-3 col-sm-4">
                      <span class="tfh-label">Buscar por usuario: </span>
                      <input class="form-control" id="filtrar_busqueda_usuario" type="text" />
                  </div> --}}
                  <div class="col-md-3 col-sm-4">
                    <span class="tfh-label">Fecha inicio: </span>
                    <input class="form-control" id="filtrar_busqueda_fecha_inicio" type="date" />
                  </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  <div class="col-md-3 col-sm-4">
                    <span class="tfh-label">Fecha final: </span>
                    <input class="form-control" id="filtrar_busqueda_fecha_final" type="date" />
                  </div>
                  <div class="col-md-4 col-sm-4">
                      <span class="tfh-label">Estatus: </span>
                      <select id="estatus_venta" class="form-control">
                          <option value="" selected>Todos</option>
                          <option value="3">Pendiente</option>
                          <option value="2">Iniciado</option>
                          <option value="5">Enviado</option>
                          <option value="4">Terminado</option>
                      </select>
                  </div>
                  <div class="col-md-4 col-sm-4">
                      <span class="tfh-label">Numero de datos: </span>
                      <select id="change-page-size" class="form-control">
                          <option value="10">10</option>
                          <option value="20">20</option>
                          <option value="50">50</option>
                          <option value="100">100</option>
                          <option value="200">200</option>
                          <option value="500">500</option>
                      </select>
                  </div>
                </div>
            </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table table-bordered" width="100%" cellspacing="0" style="text-align:center;">
          <thead>
            <tr >
              {{-- <th>QR</th> --}}
              <th>COD Venta</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>Impuesto (IVA)</th>
              <th>-%</th>
              <th id="filtrar-total" orden="asc" uso=false style="color: blue; cursor: pointer">Total ↑↓</th>
              <th>Envio</th>
              <th style="width:200px">Estatus Proyecto</th>
              <th>Envío Paquetería</th>
              <th>Paquetería</th>
              <th>Fecha Env. Paq.</th>
              <th>Origen</th>
              <th>Destino</th>
              <th>Vendió</th>
              <th>URL venta</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody id="tabla_cotizaciones">
            @include('app_redes.modulos.ventas.tabla_listado_ventas')
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>