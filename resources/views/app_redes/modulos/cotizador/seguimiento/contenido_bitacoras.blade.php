<?php 
use App\SeguimientoBitacora;

$datosSeguimientoBitacora = SeguimientoBitacora::where("id_seguimiento", $datosSeguimientoTrabajo->id_seguimiento)->get();

//dd($datosSeguimientoBitacora);
?>
<style>
	.opciones {
	    position: absolute;
	    top: 10px;
	    right: 12px;
	    display: none;
	}
	.opciones ul {
	    background: white;
	    padding: 0;
	}
	.opciones li {
	    display: inline-block;
	    list-style: none;
	    margin: -2px;
	}
	.opciones a {
	    padding: 10px 20px;
	    background: white;
	    color: #1b74e3;
	    text-decoration: none;
	    font-weight: bold;
		border: 1px black solid;
	}
	#item_bitacora:hover .opciones {
	    display: block;
	}
</style>
<h4>Bitacora de proyecto {{$datosSeguimientoTrabajo->titulo_trabajo}}</h4>
<a id="openmodal_bitacora" href="#" class="btn btn-success btn-sm" data-id-proyecto="{{$datosSeguimientoTrabajo->id_seguimiento}}"  data-id-coti="{{$datosSeguimientoTrabajo->id_cotizacion}}"><i class="fas fa-plus"></i> Agregar bitacora</a>
<input type="hidden" value="{{$datosSeguimientoTrabajo->id_cotizacion}}" id="id_cotizacion">
<input type="hidden" value="{{$datosSeguimientoTrabajo->id_seguimiento}}" id="id_proyecto">
<div class="row">
	<div class="col-md-12">
		<div id="seguimiento_bitacora" >
			@if(!$datosSeguimientoBitacora->isEmpty())
				@foreach($datosSeguimientoBitacora as $item_bitacora)
					<div id="item_bitacora" class="row" style="margin-top: 10px;">
						<div class="col-md-8">
							
							@if(!empty($item_bitacora->tipo_archivo) and $item_bitacora->tipo_archivo == "jpeg" or $item_bitacora->tipo_archivo == "png" or $item_bitacora->tipo_archivo == "jpg")
								<img style="width:100%;" src="{{url('storage/bitacoras')}}/{{$datosSeguimientoTrabajo->id_seguimiento}}/{{$item_bitacora->archivo}}" alt="">
							@elseif(!empty($item_bitacora->tipo_archivo) and $item_bitacora->tipo_archivo == "pdf")
								<embed src="{{url('storage/bitacoras')}}/{{$datosSeguimientoTrabajo->id_seguimiento}}/{{$item_bitacora->archivo}}" type="application/pdf" width="100%" height="450px" />
							@else
								<img style="width:100%;" src="{{url('storage/bitacoras')}}/{{$datosSeguimientoTrabajo->id_seguimiento}}/{{$item_bitacora->archivo}}" alt="">
							@endif
						</div>
						<div class="col-md-4">
							<b>DESCRIPCIÓN:</b> <br>
							{{$item_bitacora->comentario}}
						</div>
						<div class="opciones">
							<ul>
								<li><a style="border-right: 1px #1b6ed8 solid;" href="#" id="open_editar_bitacora" data-id-bitacora="{{$item_bitacora->id_bitracora}}" data-id-seguimiento="{{$item_bitacora->id_seguimiento}}" >Editar</a></li>
								<li><a href="#" id="confirm_delate_bitacora" data-id-bitacora="{{$item_bitacora->id_bitracora}}" data-id-seguimiento="{{$item_bitacora->id_seguimiento}}" >Eliminar</a></li>
							</ul>
						</div>
					</div>
				@endforeach
			@else
				<h3 class="text-center">Aun no existen archivos</h3>
			@endif
		</div>
	</div>
</div>