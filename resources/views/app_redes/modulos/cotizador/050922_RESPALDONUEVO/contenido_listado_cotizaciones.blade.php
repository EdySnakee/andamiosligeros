<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Cotizaciones</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Todas las cotizaciones</h6>
      <br>
      <div class="row">
            <div class="col-md-3 col-sm-3">
                <span class="tfh-label">Giro empresarial: </span>
                <select class="form-control js-example-basic-single" id="giro_empresa" placeholder="Giro" >
                  <option value="" selected>Todos</option>
                  <option value="ra">Redes Anticaidas</option>
                  <option value="rp">Redes perimetrales</option>
                  <option value="sg">Scoregol</option>
                  <option value="al">Andamios Ligeros</option>
                </select>
            </div>
            <div class="col-md-6">
              <div class="input-daterange row">
                <div class="col-md-6">
                    <span class="tfh-label"><b>Buscar por rango de fechas</b> </span>
                    <input class="form-control" id="fecha_inicio" type="text" placeholder="Fecha inicio"  autocomplete="off"/>
                </div>
                <div class="col-md-6">
                    <span class="tfh-label">&nbsp</span><br>
                    <input class="form-control" id="fecha_fin" type="text"  placeholder="Fecha fin" autocomplete="off"/>
                </div>
              </div>
            </div>
              <div class="col-md-3">
                  <span class="tfh-label">&nbsp</span><br>
                  <input type="button" name="search" id="search" value="Buscar fecha" class="btn btn-md btn-primary" />
              </div>
          </div>
      <span id="limpia_filtros" style="position: absolute;top: 15px;right: 15px;"><a href="">Limpiar filtros</a></span>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tabla_cotizaciones" width="100%" cellspacing="0" style="text-align:center;">
          <thead>
            <tr >
              <th>ID</th>
              <th>COD Cotización</th>
              <th>Cliente</th>
              <th>Teléfono</th>
              <th>Fecha</th>
              <th>Total</th>
              <th>Estatus Coti</th>
              <th>Cotizó</th>
              <th>URL cotización</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody >
            
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>