@foreach($listado_productos as $result_product)
<tr>
  <td>{{$result_product->SKU}}</td>
  <td>
    @if($result_product->giro_producto == "ra")
    Redes Anticaidas
    @elseif($result_product->giro_producto == "rp")
    Redes perimetrales
    @elseif($result_product->giro_producto == "sg")
    Score Gol
    @elseif($result_product->giro_producto == "al")
    Andamios Ligeros
    @endif
  </td>
  <td>{{$result_product->nombre_p}}</td>
  <td>{{$result_product->tipo_cobro}}</td>
  <td>
    @if(Auth::User()->tipo_usuario == "mayorista")
    <?php echo "$".number_format($result_product->precio_m, 2, '.', ',') ?>
    @else
    <?php echo "$".number_format($result_product->precio, 2, '.', ',') ?>
    @endif
  </td>
  <td>
    @if($result_product->status_p == 1)
      <span class="status bg-gradient-success text-white shadow">
        Activo
      </span>
    @else
      <span class="status bg-secondary text-white shadow">
        Inactio
      </span>
    @endif

  </td>
  <td>
    <div class="btn-group">
        <a href="#" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
        <ul class="dropdown-menu" id="prospecto-menu">
          <li><input type="submit" name="open_ver_detalle" id="open_ver_detalle" data-id-producto="{{$result_product->id_producto}}" value="Ver detalle" class="btn btn-default col-md-12 btn-dropdown-fix"></li>
          <li>
            <form action="{{ route('app_edit_productos')}}" method="post" accept-charset="utf-8">
                {{csrf_field()}}
                <input type="hidden" name="id_producto" id="id_producto" value="{{$result_product->id_producto}}">
                <input type="submit" name="Editar" id="Editar" value="Editar" class="btn btn-default col-md-12 btn-dropdown-fix">
            </form>
          </li>
          <li>
            <form action="{{route('app_add_tienda_productos')}}" method="get" accept-charset="utf-8">
                {{csrf_field()}}
                <input type="hidden" name="id_producto" id="id_producto" value="{{$result_product->id_producto}}">
                <input type="submit" id="Publicar producto" value="Publicar producto" class="btn btn-default col-md-12 btn-dropdown-fix">
            </form>
          </li>
          <li class="divider"><hr></li>
          <li><input type="submit" name="confirm_delete_producto" id="confirm_delete_producto" data-id-producto="{{$result_product->id_producto}}" value="Eliminar" class="btn btn-default col-md-12 btn-dropdown-fix"></li>
        </ul>
    </div>
  </td>
</tr>
@endforeach