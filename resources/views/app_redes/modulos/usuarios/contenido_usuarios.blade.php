<div class="container-fluid">
  <!-- Page Heading -->
  <div class="d-sm-flex align-items-center justify-content-between mb-4">
    <div>
      <h1 class="h3 mb-1 text-gray-800 font-weight-bold">Administración de Usuarios</h1>
      <p class="text-muted mb-0 small">Administra los usuarios con acceso al panel, asigna sus roles y controla su estatus.</p>
    </div>
    <button type="button" class="btn btn-primary shadow-sm" id="btn_open_add_user">
      <i class="fas fa-user-plus fa-sm text-white-50 mr-1"></i> Agregar Nuevo Usuario
    </button>
  </div>

  <!-- Card Principal -->
  <div class="card shadow mb-4 border-0">
    <div class="card-header py-3 bg-white d-flex flex-wrap align-items-center justify-content-between border-bottom">
      <h6 class="m-0 font-weight-bold text-primary">
        <i class="fas fa-users-cog mr-1"></i> Directorio de Usuarios
      </h6>
      <button type="button" class="btn btn-sm btn-outline-secondary" id="btn_limpiar_filtros">
        <i class="fas fa-undo fa-xs mr-1"></i> Limpiar Filtros
      </button>
    </div>

    <div class="card-body">
      <!-- Filtros y Búsqueda -->
      <div class="row mb-3 align-items-center">
        <!-- Buscador -->
        <div class="col-lg-4 col-md-6 mb-2">
          <div class="input-group">
            <div class="input-group-prepend">
              <span class="input-group-text bg-light border-right-0"><i class="fas fa-search text-gray-400"></i></span>
            </div>
            <input type="text" id="buscar_usuario" class="form-control bg-light border-left-0" placeholder="Buscar por nombre, email o ID...">
          </div>
        </div>

        <!-- Filtro por Rol -->
        <div class="col-lg-3 col-md-6 mb-2">
          <select id="filtro_rol" class="form-control">
            <option value="todos">Todos los roles</option>
            <option value="admin">Administrador</option>
            <option value="v1">Vendedor</option>
            <option value="t1">Taller</option>
          </select>
        </div>

        <!-- Filtro por Estatus -->
        <div class="col-lg-3 col-md-6 mb-2">
          <select id="filtro_estatus" class="form-control">
            <option value="todos">Todos los estatus</option>
            <option value="1">Activos</option>
            <option value="0">Inactivos</option>
          </select>
        </div>

        <!-- Paginación / Registros por página -->
        <div class="col-lg-2 col-md-6 mb-2 text-right">
          <div class="d-flex align-items-center justify-content-end">
            <small class="text-muted mr-2 font-weight-bold">Mostrar:</small>
            <select id="change-page-size" class="form-control form-control-sm" style="width: auto;">
              <option value="10">10</option>
              <option value="25">25</option>
              <option value="50">50</option>
              <option value="100">100</option>
            </select>
          </div>
        </div>
      </div>

      <!-- Tabla Responsive -->
      <div class="table-responsive">
        <table class="table table-hover table-striped align-middle mb-0" width="100%" cellspacing="0">
          <thead class="thead-light">
            <tr>
              <th style="width: 70px;" class="text-center">ID</th>
              <th>Usuario</th>
              <th>Correo Electrónico</th>
              <th class="text-center">Rol</th>
              <th class="text-center">Estatus</th>
              <th class="text-center">Fecha de Alta</th>
              <th class="text-center" style="width: 140px;">Acciones</th>
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