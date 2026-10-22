@if(!$listado_usuarios->isEmpty())
  @foreach($listado_usuarios as $item_usuario)
  <tr>
    <td class="text-center font-weight-bold text-muted">{{ $item_usuario->id }}</td>
    <td>
      <div class="font-weight-bold text-gray-900">{{ $item_usuario->name }}</div>
      @if(\Auth::id() == $item_usuario->id)
        <small class="badge badge-light border text-primary"><i class="fas fa-user mr-1"></i> Mi cuenta</small>
      @endif
    </td>
    <td>
      <span class="text-gray-800">{{ $item_usuario->email }}</span>
    </td>
    <td class="text-center">
      @if($item_usuario->isAdmin())
        <span class="badge badge-primary px-2 py-1"><i class="fas fa-user-shield mr-1"></i> Administrador</span>
      @elseif($item_usuario->isVendedor())
        <span class="badge badge-info px-2 py-1"><i class="fas fa-briefcase mr-1"></i> Vendedor</span>
      @elseif($item_usuario->isTaller())
        <span class="badge badge-warning text-dark px-2 py-1"><i class="fas fa-tools mr-1"></i> Taller</span>
      @else
        <span class="badge badge-secondary px-2 py-1">{{ $item_usuario->nombre_rol }}</span>
      @endif
    </td>
    <td class="text-center">
      @if($item_usuario->isActivo())
        <span class="badge badge-success px-2 py-1"><i class="fas fa-check-circle mr-1"></i> Activo</span>
      @else
        <span class="badge badge-danger px-2 py-1"><i class="fas fa-ban mr-1"></i> Inactivo</span>
      @endif
    </td>
    <td class="text-center text-muted small">
      {{ $item_usuario->created_at ? $item_usuario->created_at->format('d/m/Y H:i') : '-' }}
    </td>
    <td class="text-center">
      <div class="dropdown">
        <button class="btn btn-sm btn-outline-primary dropdown-toggle shadow-sm" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-cog mr-1"></i> Opciones
        </button>
        <div class="dropdown-menu dropdown-menu-right shadow animated--fade-in py-1">
          <a class="dropdown-item btn-action-edit py-2" href="#" data-id-usr="{{ $item_usuario->id }}">
            <i class="fas fa-user-edit text-primary mr-2"></i> Editar Usuario
          </a>

          @if($item_usuario->isActivo())
            @if(\Auth::id() != $item_usuario->id)
              <a class="dropdown-item btn-action-desactiva py-2" href="#" data-id-usr="{{ $item_usuario->id }}" data-name-usr="{{ $item_usuario->name }}">
                <i class="fas fa-user-slash text-warning mr-2"></i> Desactivar
              </a>
            @endif
          @else
            <a class="dropdown-item btn-action-activa py-2" href="#" data-id-usr="{{ $item_usuario->id }}" data-name-usr="{{ $item_usuario->name }}">
              <i class="fas fa-user-check text-success mr-2"></i> Activar
            </a>
          @endif

          @if(\Auth::id() != $item_usuario->id)
            <div class="dropdown-divider my-1"></div>
            <a class="dropdown-item btn-action-delete text-danger py-2" href="#" data-id-usr="{{ $item_usuario->id }}" data-name-usr="{{ $item_usuario->name }}">
              <i class="fas fa-trash-alt text-danger mr-2"></i> Eliminar
            </a>
          @endif
        </div>
      </div>
    </td>
  </tr>
  @endforeach
@else
  <tr>
    <td colspan="7" class="text-center py-5 text-muted">
      <i class="fas fa-users-slash fa-3x mb-3 text-gray-300 d-block"></i>
      <h6 class="font-weight-bold text-gray-600 mb-1">No se encontraron usuarios</h6>
      <p class="small mb-0">No hay registros que coincidan con los criterios de búsqueda o filtros aplicados.</p>
    </td>
  </tr>
@endif

@if(!$listado_usuarios->isEmpty())
  <tr>
    <td colspan="3" class="align-middle text-muted small">
      Mostrando del {{ $listado_usuarios->firstItem() }} al {{ $listado_usuarios->lastItem() }} de un total de <strong>{{ $listado_usuarios->total() }}</strong> usuarios
    </td>
    <td colspan="4" class="text-right align-middle">
      <div class="float-right mb-0">
        {!! $listado_usuarios->links() !!}
      </div>
    </td>
  </tr>
@endif



