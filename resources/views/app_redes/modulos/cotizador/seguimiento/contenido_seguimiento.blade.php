<div class="container-fluid">
  <!-- Page Heading -->
  <h1 class="h3 mb-2 text-gray-800">Seguimiento de proyecto</h1>

  <!-- DataTales Example -->
  <div class="card shadow mb-4">
    <div class="card-header py-3">
      <h6 class="m-0 text-primary">Seguimiento de proyecto <b>{{$info_cotizacion->cod_venta}}</b> </h6>
      <h6 class="m-0 text-primary">
        Giro empresa: 
        <b>
        @if($info_cotizacion->giro_empresa == "ra")
          Redes Anticaidas
        @elseif($info_cotizacion->giro_empresa == "rp")
          Redes perimetrales
        @elseif($info_cotizacion->giro_empresa == "sg")
          Scoregol
        @elseif($info_cotizacion->giro_empresa == "al")
          Andamios Ligeros
        @endif
        </b>
      </h6>
      <h6 class="m-0 text-primary">Cliente: <b>{{$datosCliente->nombrecl}}</b></h6>

      <span id="" style="position: absolute;top: 15px;right: 15px;"><a href="{{url('sb-admin/ventas')}}">Regresar</a></span>
    </div>
    <div class="card-body">
      <div class="row">
        <div id="seguimiento_trabajo" class="col-md-12">
          @if(!empty($datosSeguimientoTrabajo))
            @include('app_redes.modulos.cotizador.seguimiento.contenido_bitacoras')
          @else
          <div class="text-center">
            <h2>Aun no ha iniciado el proyecto</h2>
            <input type="hidden" value="{{$info_cotizacion->cod_venta}}" id="nom_cotizacion">
            <a id="openmodal_seguimiento" href="#" class="btn btn-success btn-lg" data-id-coti = "{{$info_cotizacion->id_cotizacion}}"><i class="fas fa-plus"></i> Iniciar Proyecto</a>
          </div>
          @endif
        </div>
      </div>
    </div>
  </div>

</div>