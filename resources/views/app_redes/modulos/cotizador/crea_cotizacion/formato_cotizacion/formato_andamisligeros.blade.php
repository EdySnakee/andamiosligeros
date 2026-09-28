@php
	use App\Utilidades;
	$fecha = Utilidades::fecha();
    
@endphp

<div class="row encabezado">
  <div class="col-md-6">
    @if($accion == "agregar")
    <b><h4>COTIZACIÓN (folio)</h4></b>
	@elseif($accion == "editar")
	<b><h4>COTIZACIÓN {{$info_cotizacion->cod_cotizacion}}</h4></b>
	@endif
    <span id="fecha_formato">{{$fecha}}</span>
    <div class="row txt-cliente">
	    <div class="col-md-3">
	    	<p class="text-bold">EN ATENCIÓN</p>
	    </div>
	    <div class="col-md-9">
	    	<ul id="info_cliente" class="info-cliente">
	    		@include('app_redes.modulos.cotizador.crea_cotizacion.formato_cotizacion.fieldset_info_cliente')
	    	</ul>
	    </div>
    </div>
  </div>
  <div class="col-md-6">
  	<div class="logo-coti">
  		<img src="{{url('script/img/andamios.png')}}" alt="">
  		<p>¿Sabías que el 80% de los siniestros en <br> construcción se deben a caídas?</p>
  	</div>
  </div>
</div>

<div class="row contenido">
	<div class="col-md-12">
		<table class="table table-bordered" id="tabla_productos" width="100%" cellspacing="0">
			<thead class="text-center">
				<tr>
				  <th>CANTIDAD</th>
				  <th>PRODUCTO</th>
				  <th>DESCRIPCIÓN</th>
				  <th>PRECIO UNITARIO</th>
				  <th>SUBTOTAL</th>
				  <th>ACCIÓN</th>
				</tr>
			</thead>

		  	@if($accion == "agregar")
		  	<tbody id="detalle_cotizacion" class="text-center">
		  	</tbody>
			@elseif($accion == "editar")
			<tbody id="detalle_cotizacion" class="text-center">
				@include('app_redes.modulos.cotizador.crea_cotizacion.formato_cotizacion.agrega_items')
		  	</tbody>
			@endif
	    </table>
	</div>
</div>

<div class="row btn-contenedor">
	<div class="col-md-12">
		@if($accion == "agregar")
	      <button type="submit" id="open_confirm_post_cotizacion" class="btn btn-success float-right">Guardar Cotización</button>
	    @elseif($accion == "editar")
	      <input type="hidden" value="{{(!empty($info_cotizacion->id_cotizacion))?$info_cotizacion->id_cotizacion:''}}" name="id_cotizacion" id="id_cotizacion">
	      <button type="submit" id="edit_cotizacion" class="btn btn-primary float-right">Editar Cotización</button>
	    @endif
	</div>

</div>
