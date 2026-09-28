<?php 
  use App\SeguimientoTrabajo;
  use App\SeguimientoBitacora;
?>
@if(!$listado_cotizaciones->isEmpty())
  @foreach($listado_cotizaciones as $result_coti)
  <?php 
    $datosSeguimientoTrabajo = SeguimientoTrabajo::where("id_cotizacion", $result_coti->id_cotizacion)->first();
  ?>
  <tr
  @if($result_coti->giro_empresa == "ra")
  style="background: #d4b2d387; color: black;"
  @elseif($result_coti->giro_empresa == "al")
  style="background: #7ea7ff6e; color: black;"
  @elseif($result_coti->giro_empresa == "sg")
  style="background: #7ec25c80; color: black;"
  @elseif($result_coti->giro_empresa == "rp")
  style="background: #ddddddad; color: black;"
  @endif
  >
    <td style="text-align: center;"> 
      @if($result_coti->qr_status == 1)
      <a href="{{url('storage/qrs_cotizaciones')}}/{{$result_coti->id_cotizacion}}.png" target="_blank" style="border: 1px #cacaca solid; width: 35px; height: 35px; position: relative; display: flex; align-items: center; justify-content: center; margin: 0 auto; border-radius: 5px; background: #e0dede; box-shadow: 0px 0px 3px #cacaca;">
        <img style="width:25px; height:25px" src="{{url('storage/qrs_cotizaciones')}}/{{$result_coti->id_cotizacion}}.png" alt="">
      </a>
      @elseif($result_coti->qr_status == 0)
      <div style="border: 1px #cacaca solid; width: 35px; height: 35px; position: relative; display: flex; align-items: center; justify-content: center; margin: 0 auto; border-radius: 5px; background: #e0dede; box-shadow: 0px 0px 3px #cacaca;">
        <img style="width:25px; height:25px" src="{{url('script/img/unnamed.png')}}" data-toggle="tooltip" data-placement="top" alt="QR no disponible" title="QR no disponible">
      </div>
      @endif
    </td>
    <td>{{$result_coti->cod_cotizacion}}</td>
    <td style="text-align:left;" >{{$result_coti->nombrecl}}</td>
    <td>{{$result_coti->fecha_formato}}</td>
    <td>
      @if($result_coti->porcentaje_descuento != 0)
        Si
      @else
        No
      @endif
    </td>
    <td><?php echo "$".number_format($result_coti->total, 2, '.', ',') ?></td>
    <td>
      @if($result_coti->status == 1)
        <span class="status bg-gradient-info text-white shadow">
          Activo
        </span>
      @elseif($result_coti->status == 3)
        <span class="status bg-gradient-success text-white shadow">
          Aceptada
        </span>
      @else
        <span class="status bg-secondary text-white shadow">
          Inactivo
        </span>
      @endif
    </td>
    <td>
      @if(!empty($datosSeguimientoTrabajo))
        <?php 
        $datosSeguimientoBitacora = SeguimientoBitacora::where("id_seguimiento", $datosSeguimientoTrabajo->id_seguimiento)->get();
        ?>
        <span class="status bg-light shadow">
          <small>
            <span style="background: #0c0c0c;color: white;padding: 0px 4px;border-radius: 50%;"><?php echo count($datosSeguimientoBitacora); ?></span>
            Iniciado
          </small>
        </span>
      @else
        <span class="status bg-warning shadow">
          <small>
            Pendiente
          </small>
        </span>
      @endif
    </td>
    <td>
      {{$result_coti->name}}
    </td>
    <td>
      @if($result_coti->giro_empresa == "ra")
      <a target="_blank" href="{{url('cotizaciones/redes-anticaidas/')}}/{{$result_coti->ruta_encrypt}}">../{{$result_coti->cod_cotizacion}}</a>
      @elseif($result_coti->giro_empresa == "rp")
      <a target="_blank" href="{{url('cotizaciones/redes-perimetrales/')}}/{{$result_coti->ruta_encrypt}}">../{{$result_coti->cod_cotizacion}}</a>
      @elseif($result_coti->giro_empresa == "sg")
      <a target="_blank" href="{{url('cotizaciones/score-gol/')}}/{{$result_coti->ruta_encrypt}}">../{{$result_coti->cod_cotizacion}}</a>
      @elseif($result_coti->giro_empresa == "al")
      <a target="_blank" href="{{url('cotizaciones/andamios-ligeros/')}}/{{$result_coti->ruta_encrypt}}">../{{$result_coti->cod_cotizacion}}</a>
      @endif
    </td>
    <td>
      <div class="btn-group">
          <a href="#" class="btn btn-facebook dropdown-toggle" data-toggle="dropdown" aria-expanded="false">Acción <span class="caret"></span></a>
          <ul class="dropdown-menu" id="prospecto-menu">
              @if($result_coti->status == 1)
                <li><a class="btn btn-primary col-md-12 btn-dropdown-fix" href="{{ route('app_redes_edita_cotizaciones', $result_coti->id_cotizacion)}}" >Editar</a></li>
                <li><a id="open_confirm_venta" data-id-coti="{{$result_coti->id_cotizacion}}" class="btn btn-success col-md-12 btn-dropdown-fix" href="#" >Realizar Venta</a></li>
                @if($result_coti->qr_status == 1)
                @elseif($result_coti->qr_status == 0)
                <li><a id="genera_qr" class="btn btn-info col-md-12 btn-dropdown-fix" href="#"  data-id-coti="{{$result_coti->id_cotizacion}}">Generar QR</a></li>
                @endif
              @elseif($result_coti->status == 3)
                <li>
                  <a class="btn col-md-12 btn-dropdown-fix" href="{{url('sb-admin/seguimineto')}}/{{$result_coti->id_cotizacion}}"> Realizar seguimiento</a>
                </li>
              @endif

              @if($result_coti->status == 1 or $result_coti->status == 3)
                <li>
                  @if($result_coti->giro_empresa == "ra")
                  <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="{{url('pdf/redes-anticaidas/')}}/{{$result_coti->ruta_encrypt}}"> Descargar PDF</a>
                  @elseif($result_coti->giro_empresa == "rp")
                  <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="{{url('pdf/redes-perimetrales/')}}/{{$result_coti->ruta_encrypt}}"> Descargar PDF</a>
                  @elseif($result_coti->giro_empresa == "sg")
                  <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="{{url('pdf/score-gol/')}}/{{$result_coti->ruta_encrypt}}"> Descargar PDF</a>
                  @elseif($result_coti->giro_empresa == "al")
                  <a class="btn btn-info col-md-12 btn-dropdown-fix" target="_blank" href="{{url('pdf/andamios-ligeros/')}}/{{$result_coti->ruta_encrypt}}"> Descargar PDF</a>
                  @endif
                </li>
                <li class="divider"><hr></li>
                <li>
                  <input type="submit" name="confirm_desactiva_cliente" id="confirm_desactiva_cliente" data-id-coti="{{$result_coti->id_cotizacion}}" value="Desactivar" class="btn btn-warning col-md-12 btn-dropdown-fix">
                </li>
              @else
              <li>
                  <input type="submit" name="confirm_activa_cliente" id="confirm_activa_cliente" data-id-coti="{{$result_coti->id_cotizacion}}" value="Activar" class="btn btn-success col-md-12 btn-dropdown-fix">
                </li>
                <li class="divider"><hr></li>
                <li>
                  <input type="submit" name="confirm_elimina_cliente" id="confirm_elimina_cliente" data-id-coti="{{$result_coti->id_cotizacion}}" value="Eliminar" class="btn btn-danger col-md-12 btn-dropdown-fix">
                </li>
              @endif
          </ul>
      </div>
    </td>
  </tr>
  @endforeach
@else
<tr><td colspan="10" class="text-center"><h2>Lo sentimos pero no existen cotizaciones</h2></td></tr>
@endif
<tr>
    <td colspan="3">
        Total de cotizaciones: {!! $listado_cotizaciones->total() !!}
    </td>
    <td colspan="7" class="text-right">{!! $listado_cotizaciones->links() !!}</td>
</tr>


