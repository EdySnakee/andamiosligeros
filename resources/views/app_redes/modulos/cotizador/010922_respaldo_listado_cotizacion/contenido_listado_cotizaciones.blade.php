<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Cotizaciones</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Todas las cotizaciones</h6>

      <span id="limpia_filtros" style="position: absolute;top: 15px;right: 15px;"><a href="">Limpiar filtros</a></span>
    </div>
    <div class="card-body">
      <div class="table-filter-header">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                      <span class="tfh-label">Giro empresarial: </span>
                      <select class="form-control js-example-basic-single" id="giro_empresa" placeholder="Giro" >
                        <option value="" selected>Todos</option>
                        <option value="ra">Redes Anticaidas</option>
                        <option value="rp">Redes perimetrales</option>
                        <option value="sg">Scoregol</option>
                        <option value="al">Andamios Ligeros</option>
                      </select>
                  </div>
                  <div class="col-md-4 col-sm-4">
                      <span class="tfh-label">Buscar por cliente: </span>
                      <input class="form-control" id="filtrar_busqueda" type="text" />
                  </div>
                  <div class="col-md-4 col-sm-4">
                      <span class="tfh-label">Buscar por cotización: </span>
                      <input class="form-control" id="filtrar_busqueda_venta" type="number" />
                  </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  <div class="col-md-4 col-sm-4 offset-4">
                    <span class="tfh-label">Buscar por fecha: </span>
                    <input class="form-control" id="filtrar_busqueda_fecha" type="date" />
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
              <th>QR</th>
              <th>COD Cotización</th>
              <th>Cliente</th>
              <th>Fecha</th>
              <th>-%</th>
              <th>Total</th>
              <th>Estatus Coti</th>
              <th>Estatus Proyecto</th>
              <th>Cotizó</th>
              <th>URL cotización</th>
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