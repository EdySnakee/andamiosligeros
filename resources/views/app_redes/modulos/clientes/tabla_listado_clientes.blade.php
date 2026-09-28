@foreach($catalogo_proyectos as $result_proyectos)
<tr>
  <td>{{$result_proyectos->nombre_cliente}}</td>
  <td>{{$result_proyectos->nombre_proyecto}}</td>
  <td><a target="_blank" href="{{url('proyectos')}}/{{$result_proyectos->url_proyecto}}">../{{$result_proyectos->url_proyecto}}</a></td>
  <td><a target="_blank" href="{{url('obras')}}/{{$result_proyectos->url_cliente}}">../{{$result_proyectos->url_cliente}}</a></td>
  <td>
    <div class="btn-group">
        <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
        <ul class="dropdown-menu" id="prospecto-menu">
          <li>
            <form action="{{ route('app_redes_edit_clientes')}}" method="post" accept-charset="utf-8">
                {{csrf_field()}}
                <input type="hidden" name="id_cliente" id="id_cliente" value="{{$result_proyectos->id_cliente}}">
                <input type="submit" name="Editar" id="Editar" value="Editar" class="btn btn-default col-md-12 btn-dropdown-fix">
            </form>
          </li>
          <?php /*<li><input type="submit" name="ver_proyecto" id="ver_proyecto" value="Ver proyecto" class="btn btn-default col-md-12 btn-dropdown-fix"></li>*/ ?>
          <li class="divider"><hr></li>
          <li><input type="submit" name="confirm_delete_cliente" id="confirm_delete_cliente" data-id-cliente="{{$result_proyectos->id_cliente}}" value="Eliminar" class="btn btn-default col-md-12 btn-dropdown-fix"></li>
        </ul>
    </div>
  </td>
</tr>
@endforeach