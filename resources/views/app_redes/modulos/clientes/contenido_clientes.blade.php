<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Proyectos</h1>
  <p class="mb-4">Listado de proyectos asignados a Estados</p>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Listado de proyectos</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>Nombre de proyecto</th>
              <th>Titulo de estado</th>
              <th>URL principal</th>
              <th>URL secundario</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>Nombre de proyecto</th>
              <th>Titulo de estado</th>
              <th>URL principal</th>
              <th>URL secundario</th>
              <th>Acción</th>
            </tr>
          </tfoot>
          <tbody id="tabla_clientes">
            @include('app_redes.modulos.clientes.tabla_listado_clientes')
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>