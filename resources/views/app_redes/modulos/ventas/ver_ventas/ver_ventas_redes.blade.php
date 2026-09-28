<?php 
use App\Productos;
?>
@extends('layouts.vista_cotizador')
@section('css')
<title>Venta {{(!empty($ventasRedes->cod_venta))?$ventasRedes->cod_venta:''}}</title>
@stop
@section('content')
    <div class="container">
    	<div class="row">
    		<div class="col-md-12 cont-secciones-cotizaciones">
			    <div class="row">
			    	<div class="col-md-6">
			    		<h2><b>VENTA  {{(!empty($ventasRedes->cod_venta))?$ventasRedes->cod_venta:''}}</b> </h2>
			    		<p>{{(!empty($ventasRedes->fecha_venta_formato))?$ventasRedes->fecha_venta_formato:''}} </p>
			    		<div class="row">
			    			<div class="col-md-3">
			    				<b>EN ATENCIÓN:</b> 
			    			</div>
			    			<div class="col-md-9">
			    				<p>{{(!empty($infoCliente->nombrecl))?$infoCliente->nombrecl:''}}</p>
			    				<p>{{(!empty($infoCliente->rfccl))?$infoCliente->rfccl:''}}</p>
			    				<p>{{(!empty($infoCliente->direccioncl))?$infoCliente->direccioncl:''}}</p>
			    				<p>{{(!empty($infoCliente->lugarcl))?$infoCliente->lugarcl:''}} {{(!empty($infoCliente->cpcl))?$infoCliente->cpcl:''}}</p>
			    				<p>{{(!empty($infoCliente->telefonocl))?$infoCliente->telefonocl:''}}</p>
			    			</div>
			    		</div>
			    	</div>
			    	<div class="col-md-6 text-center">
			    		<img width="120px" src="{{url('cotizaciones/img/logo-redes.png')}}" alt="">
		  				<p class="text-img">¿Sabías que el 80% de los siniestros en <br> construcción se deben a caídas?</p>
			    	</div>
			    </div>
			    <div class="row tabla-precios">
			    	<div class="col-md-12" style="z-index: 100; background: white;">
			    		<table class="table-responsive table text-center">
						  <thead class="text-center">
						    <tr>
						      <td scope="col">CANTIDAD</td>
						      <td scope="col">PRODUCTO</td>
						      <td scope="col">DESCRIPCIÓN</td>
						      <td scope="col">PRECIO UNITARIO</td>
						      <td scope="col">SUBTOTAL</td>
						    </tr>
						  </thead>
						  <tbody>
						  	@if(!$DetalleCotizaciones->isEmpty())
							@foreach($DetalleCotizaciones as $result_det_coti)
							    <tr class="fila-con-bordes">
							      <td>{{$result_det_coti->cantidad}}</td>
							      <td>{{$result_det_coti->nombre_producto}} 
							      	@if($result_det_coti->tipo_cobro == "m2")
							      		{{$result_det_coti->alto}} x {{$result_det_coti->largo}} 
							      	@endif
							      </td>
							      <td>{{$result_det_coti->titulo_descripcion}}</td>
							      <td><?php echo "$".number_format($result_det_coti->precio_unit, 2, '.', ',') ?></td>
							      <td><?php echo "$".number_format($result_det_coti->total_ind, 2, '.', ',') ?></td>
							    </tr>
							@endforeach
							@else
							<tr><td colspan="5" class="text-center"><h2>Lo sentimos pero no existen cotizaciones</h2></td></tr>
							@endif

								<tr class="fila-sin-bordes"><td colspan="5"></td></tr>
								<tr class="fila-sin-bordes"><td colspan="5"></td></tr>
								<tr class="fila-sin-bordes"><td colspan="5"></td></tr>
								<tr class="fila-sin-bordes"><td colspan="5"></td></tr>
								<tr class="fila-sin-bordes">
								    <td colspan="3" class="text-left fila-informacion">
								    	<h5>CONDICIONES</h5>
								    	<p><small> Anticipo del 60%</small></p>
										<p><small> Saldo para su liberación y/o envío</small></p>
										<p><small> Tiempo de entrega a convertir</small></p>
										<p><small> Precios vigentes para el mes de curso</small></p>
										<p><small> Descuento por pronto pago vigencia 10 días</small></p>
										<p><small> Envío gratuito solo aplica para tránsito terrestre *verifica cobertura</small></p>
								    </td>
								    <td class="contenedor-totales" colspan="2">
								    	<table class="table">
											@if($ventasRedes->descuento_aplicado != 0)
									    	<tr>
										    	<td class="text-center con-bordes">DESCUENTO</td>
										    	<td class="text-center con-bordes"><?php echo "-$".number_format($ventasRedes->descuento_aplicado, 2, '.', ',') ?></td>
									    	</tr>
											@endif
									    	<tr class="fila-sin-bordes">
											    <td class="text-center con-bordes">SUBTOTAL</td>
											    <td class="text-center con-bordes"><?php echo "$".number_format($ventasRedes->subtotal, 2, '.', ',') ?></td>
											</tr>
											@if($ventasRedes->iva != 0)
											<tr class="fila-sin-bordes">
											    <td class="text-center con-bordes">IMPUESTOS</td>
											    <td class="text-center con-bordes"><?php echo "$".number_format($ventasRedes->iva, 2, '.', ',') ?></td>
											</tr>
											 @else
											 @endif
											<tr class="fila-sin-bordes">
											    <td class="text-center con-bordes">TOTAL</td>
											    <td class="text-center con-bordes"><?php echo "$".number_format($ventasRedes->total, 2, '.', ',') ?></td>
											</tr>
								    	</table>
								    </td>
								</tr>
							

						  </tbody>
						</table>
			    	</div>
			    </div>
			    <div class="row footer-content">
			    	<div class="col-md-6 footer-info">
			    		
			    	</div>
			    	<div class="col-md-6 text-center footer-info">
			    		<img width="150px" src="{{url('cotizaciones/img/logosantander.png')}}" alt="">
			    		<p>REDES ANTICAIDAS S.A DE C.V</p>
						<p>CUENTA: 65-50656173-4</p>
						<p>CLABE: 014910655065617341</p>
			    	</div>
			    </div>
    		</div>
    	</div>

		@foreach($idsproducts_unicos as $ids_productos)
			<?php 
			$objProductos = new Productos();
			$infoProducto = $objProductos
							->select("*")
                            ->from("productos AS pro")
                            ->join("detalle_producto AS dp", "dp.id_producto", "=", "pro.id_producto")
							->where("pro.id_producto", $ids_productos)
							->first();
			 ?>
	    	<div id="{{$infoProducto->SKU}}" class="row cont-secciones-cotizaciones mt-20">
	    		<div class="row">
			    	<div class="col-md-6">
			    		<h2><b>FICHA TÉCNICA</b> </h2>
			    		<h3>{{$infoProducto->nombre_p}}</h3>
			    	</div>
			    	<div class="col-md-6 text-center">
			    		<img width="120px" src="{{url('cotizaciones/img/logo-redes.png')}}" alt="">
		  				<p class="text-img">¿Sabías que el 80% de los siniestros en <br> construcción se deben a caídas?</p>
			    	</div>
			    </div>
			    <div class="row">
			    	<div class="col-md-12">
			    		<h5>DESCRIPCIÓN</h5>
			    		<?php 
			    		echo $infoProducto->descripcion_producto;
			    		 ?>
			    	</div>
			    </div>
			    @if($infoProducto->num_plantilla == 1)
				    <div class="row cont-plantilla">
				    	<div style="z-index: 10;" class="col-md-6">
				    		<h5>CARACTERISTICAS</h5>
				    		<?php 
				    		echo $infoProducto->caracteristicas_producto;
				    		 ?>
				    	</div>
				    	<div style="z-index: 10; text-align: center;" class="col-md-6">
				    		<img width="400px" src="{{url('storage/productos')}}/{{$infoProducto->id_producto}}/{{$infoProducto->imagen}}" alt="">
				    	</div>
				    </div>
			    @elseif($infoProducto->num_plantilla == 2)
				    <div class="row cont-plantilla">
				    	<div style="z-index: 10;" class="col-md-12">
				    		<h5>CARACTERISTICAS</h5>
				    		<?php 
				    		echo $infoProducto->caracteristicas_producto;
				    		 ?>
				    	</div>
				    </div>
				    <div class="row cont-plantilla">
				    	<div style="z-index: 10; text-align: center;" class="col-md-12">
				    		<img width="400px" src="{{url('storage/productos')}}/{{$infoProducto->id_producto}}/{{$infoProducto->imagen}}" alt="">
				    	</div>
				    </div>
			    @endif
			    <div class="row">
			    	<div style="z-index: 10;" class="col-md-12">
			    		<?php 
			    		echo $infoProducto->extra_info_producto;
			    		 ?>
			    	</div>
			    </div>
			    <div class="row footer-content">
			    	<div class="col-md-6 footer-info">
			    		
			    	</div>
			    	<div class="col-md-6 text-center footer-info">
			    		<img width="150px" src="{{url('cotizaciones/img/logosantander.png')}}" alt="">
			    		<p>REDES ANTICAIDAS S.A DE C.V</p>
						<p>CUENTA: 65-50656173-4</p>
						<p>CLABE: 014910655065617341</p>
			    	</div>
			    </div>
			</div>
		@endforeach

	</div>
@stop