<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Productos</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 font-weight-bold text-primary">Todos los productos</h6>
    </div>
    <div class="card-body">
      <div class="table-responsive">
        <table class="table table-bordered" id="tablaProductos" width="100%" cellspacing="0">
          <thead>
            <tr>
              <th>ID</th>
              <th>Giro</th>
              <th>Nombre Producto</th>
              <th>Tipo de Cobro</th>
              <th>Precio</th>
              <th>Estatus</th>
              <th>Acción</th>
            </tr>
          </thead>
          <tbody id="tabla_productos">
            @include('app_redes.modulos.productos.tabla_listado_productos')
          </tbody>
        </table>
      </div>
    </div>
  </div>

</div>