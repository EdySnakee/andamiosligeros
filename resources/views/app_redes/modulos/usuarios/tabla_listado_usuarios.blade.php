@if(!$listado_usuarios->isEmpty())
  @foreach($listado_usuarios as $item_usuario)
  <tr>
    <td>{{$item_usuario->id}}</td>
    <td style="text-align:left;" >{{$item_usuario->name}}</td>
    <td>{{$item_usuario->email}}</td>
    <td>{{$item_usuario->created_at}}</td>
    <td>
      @if($item_usuario->estatus == 1)
        <span class="status bg-gradient-success text-white shadow">
          Activo
        </span>
      @elseif($item_usuario->estatus == 0)
        <span class="status bg-gradient-info text-white shadow">
          Inactivo
        </span>
      @else
        <span class="status bg-secondary text-white shadow">
          Inactivo
        </span>
      @endif
    </td>
    <td>
      <div class="btn-group">
          <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
          <ul class="dropdown-menu" id="prospecto-menu">
              @if($item_usuario->estatus == 1)
              <li><a id="open_edit_usr" class="btn btn-primary col-md-12 btn-dropdown-fix" href="#" data-id-usr="{{$item_usuario->id}}">Editar password</a></li>
              <li class="divider"><hr></li>
              <li>
                <input type="submit" name="confirm_desactiva_usuario" id="confirm_desactiva_usuario" data-id-usr="{{$item_usuario->id}}" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix">
              </li>
              @elseif($item_usuario->estatus == 0)
              <li><a id="open_edit_usr" class="btn btn-primary col-md-12 btn-dropdown-fix" href="#" data-id-usr="{{$item_usuario->id}}">Editar password</a></li>
                <li>
                  <input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente" data-id-usr="{{$item_usuario->id}}" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix">
                </li>
                <li class="divider"><hr></li>
                <li>
                  <input type="submit" name="confirm_delete_usuario" id="confirm_delete_usuario" data-id-usr="{{$item_usuario->id}}" data-name-usr="{{$item_usuario->name}}" value="Eliminar" class="btn btn-danger col-md-12 btn-dropdown-fix">
                </li>
              @else
              @endif
          </ul>
      </div>
    </td>
  </tr>
  @endforeach
@else
<tr><td colspan="10" class="text-center"><h2>Lo sentimos pero no existen usuarios</h2></td></tr>
@endif
<tr>
    <td colspan="3">
        Total de usuarios: {!! $listado_usuarios->total() !!}
    </td>
    <td colspan="7" class="text-right">{!! $listado_usuarios->links() !!}</td>
</tr>


