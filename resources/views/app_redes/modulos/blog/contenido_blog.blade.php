<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Blog</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Todos los artículos</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>IMG portada</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Fecha</th>
              <th>Estatus</th>
              <th>URL artículo</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tfoot>
            <tr>
              <th>IMG portada</th>
              <th>Título</th>
              <th>Autor</th>
              <th>Fecha</th>
              <th>Estatus</th>
              <th>URL artículo</th>
              <th>Acción</th>
            </tr>
          </tfoot>
          <tbody id="tabla_blog">
            @include('app_redes.modulos.blog.tabla_listado_articulos')
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>