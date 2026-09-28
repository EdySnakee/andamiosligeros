<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Usuarios</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Listado de usuarios</h6>

      <span id="limpia_filtros" style="position: absolute;top: 15px;right: 15px;"><a href="">Limpiar filtros</a></span>
    </div>
    <div class="card-body">
      <div class="table-filter-header">
        <div class="row">
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  <div class="col-md-4 col-sm-4">
                      <a href="#" class="btn btn-primary" style="margin-top: 1em; margin-left: 1em;"><i class="fas fa-user-plus"></i> Agregar Usuario</a>
                  </div>
                </div>
            </div>
            <div class="col-md-6 col-sm-6">
                <div class="row">
                  <div class="col-md-4 col-sm-4 offset-8">
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
              <th>ID</th>
              <th>Nombre</th>
              <th>Email</th>
              <th>Fecha de creación</th>
              <th>Estatus</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody id="tabla_usuarios">
            @include('app_redes.modulos.usuarios.tabla_listado_usuarios')
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>