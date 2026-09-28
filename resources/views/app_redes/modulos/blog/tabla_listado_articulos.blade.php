@foreach($listado_blog as $result_blog)
<tr>
  <td class="cont-img">
    <div class="img_tabla">
      @if($result_blog->img_portada != "")
        <img src="{{url('storage/blog')}}/{{$result_blog->id_blog}}/{{$result_blog->img_portada}}" alt="">
      @else
        <img src="{{url('script/img/unnamed.png')}}" alt="">
      @endif
    </div>
  </td>
  <td>{{$result_blog->post_titulo}}</td>
  <td>{{$result_blog->name}}</td>
  <td>{{$result_blog->post_fecha}}</td>
  <td>
    @if($result_blog->post_estatus == "activo")
      <span class="status bg-success text-white shadow">
        {{$result_blog->post_estatus}}
      </span>
    @else
      <span class="status bg-secondary text-white shadow">
        {{$result_blog->post_estatus}}
      </span>
    @endif

  </td>
  <td><a target="_blank" href="{{url('blog')}}/{{$result_blog->post_url}}">{{$result_blog->post_url}}</a></td>
  <td>
    <div class="btn-group">
        <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
        <ul class="dropdown-menu" id="prospecto-menu">
          <li>
            <form action="{{ route('app_redes_edit_blog')}}" method="post" accept-charset="utf-8">
                {{csrf_field()}}
                <input type="hidden" name="id_blog" id="id_blog" value="{{$result_blog->id_blog}}">
                <input type="submit" name="Editar" id="Editar" value="Editar" class="btn btn-default col-md-12 btn-dropdown-fix">
            </form>
          </li>
          <li class="divider"><hr></li>
          <li><input type="submit" name="confirm_delete_cliente" id="confirm_delete_cliente" data-id-cliente="{{$result_blog->id_blog}}" value="Eliminar" class="btn btn-default col-md-12 btn-dropdown-fix"></li>
        </ul>
    </div>
  </td>
</tr>
@endforeach