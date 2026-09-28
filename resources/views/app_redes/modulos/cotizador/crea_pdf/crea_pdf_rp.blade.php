<?php 
use App\Productos;
?>
@extends('layouts.pdf_layout')
@section('css')
<title>Cotizacion {{(!empty($cotizacionesRedes->cod_cotizacion))?$cotizacionesRedes->cod_cotizacion:''}}</title>
<style>
    @font-face {
      font-family: "CenturyGothic";
      font-style: normal;
      font-weight: normal;
      src: url("storage/fonts/CenturyGothic.ttf");
    }
    @font-face {
      font-family: "BoldFont";
      font-style: normal;
      font-weight: normal;
      src: url("storage/fonts/CenturyGothicBold.ttf");
    }
    @page{
       margin: 0;
    }
    body {
        font-family: "CenturyGothic";
        margin: 0cm 0cm 0cm;
        background: url(storage/img/bg-coti-rp.jpg);
        background-size: 100%;
        background-repeat: no-repeat;
        background-position: center;
        /*background-color: #2a0927;*/
    }
    table {
        border-spacing: 0;
        border-collapse: collapse;
    }
           
    .fila-sin-bordes{
        border: 0px;
    }
    .tit-princ{
        font-size: 25px;
    }
    .tit-second{
        font-size: 20px;   
    }
    .font-bold{
        font-family: "BoldFont";
    }
    .cont-secciones-cotizaciones{
        padding: 50px;
    }
    .page-break {
        page-break-after: always;
    }
    .separacion-5px{
        line-height: 5px;
    }
    .separacion-8px{
        line-height: 8px;
    }
    .separacion-8px p{
        line-height: 8px;
    }
    .separacion-5px p{
        line-height: 5px;
    }
    .separacion-0px{
        line-height: 0px;
    }
    .txt-small {
        font-size: 10px;
    }
    .txt-medium p{
        font-size: 12px;   
    }
    .txt-medium{
        font-size: 12px;   
    }
    table{
        width: 100%
    }
    p.text-img {
        line-height: 15px;
    }
    .text-center {
        text-align: center;
    }
    .text-left {
        text-align: left;
    }

    .footer-content {
        position: fixed;
        bottom: 3.5cm;
        left: 1cm;
        right: 0cm;
        height: 2cm;
        text-align: center;
    }
    .footer-content-ficha {
        position: fixed;
        bottom: 2cm;
        left: 1cm;
        right: 0cm;
        height: 2cm;
        text-align: center;
    }
        
</style>
@stop
@section('content')
    <div class="container" >

		<div class="col-md-12 cont-secciones-cotizaciones">
		    <table>
		    	<tr>
			    	<td style="width: 50%" class="col-md-6">
			    		<p class="tit-princ font-bold separacion-5px">COTIZACIÓN  {{(!empty($cotizacionesRedes->cod_cotizacion))?$cotizacionesRedes->cod_cotizacion:''}} </p>
			    		<p class="txt-medium">{{(!empty($cotizacionesRedes->fecha_formato))?$cotizacionesRedes->fecha_formato:''}} </p>
			    		<table class="row">
			    			<tr>
				    			<td class="col-md-3 txt-medium">
				    				<p class="separacion-0px font-bold ">EN ATENCIÓN:</p> 
				    			</td>
				    			<td class="col-md-9 txt-medium separacion-8px">
				    				{{(!empty($infoCliente->nombrecl))?$infoCliente->nombrecl:''}} <br>
				    				{{(!empty($infoCliente->rfccl))?$infoCliente->rfccl:''}} <br>
				    				{{(!empty($infoCliente->direccioncl))?$infoCliente->direccioncl:''}} <br>
				    				{{(!empty($infoCliente->lugarcl))?$infoCliente->lugarcl:''}} {{(!empty($infoCliente->cpcl))?$infoCliente->cpcl:''}} <br>
				    				{{(!empty($infoCliente->telefonocl))?$infoCliente->telefonocl:''}} <br>
				    			</td>
			    			</tr>
			    		</table>
			    	</td>
			    	<td style="width: 50%" class="col-md-6 text-center">
			    		<img width="200px" src="{{url('cotizaciones/img/redes-perimetrales-logotipo-cotizaion.jpeg')}}" alt="">
		  				<p class="text-img txt-medium">¿Sabías que el 80% de los siniestros en construcción se deben a caídas?</p>
			    	</td>
		    	</tr>
		    </table >
		    <div class="row tabla-precios" style="padding-top:50px">
		    	<div class="col-md-12" style="z-index: 100;">
		    		<table class="table-responsive table text-center" style="width: 100%; border-collapse: collapse;">
					  <thead class="text-center">
					    <tr>
					      <td class="txt-medium" scope="col">CANTIDAD</td>
					      <td class="txt-medium" scope="col">PRODUCTO</td>
					      <td class="txt-medium" scope="col">DESCRIPCIÓN</td>
					      <td class="txt-medium" scope="col">PRECIO UNITARIO</td>
					      <td class="txt-medium" scope="col">SUBTOTAL</td>
					    </tr>
					  </thead>
					  <tbody>
					  	@if(!$DetalleCotizaciones->isEmpty())
						@foreach($DetalleCotizaciones as $result_det_coti)
						    <tr class="fila-con-bordes">
						      <td class="txt-medium">{{$result_det_coti->cantidad}}</td>
						      <td class="txt-medium">{{$result_det_coti->nombre_producto}} 
						      	@if($result_det_coti->tipo_cobro == "m2")
						      		{{$result_det_coti->alto}} x {{$result_det_coti->largo}} 
						      	@endif
						      </td>
						      <td class="txt-medium">{{$result_det_coti->titulo_descripcion}}</td>
						      <td class="txt-medium"><?php echo "$".number_format($result_det_coti->precio_unit, 2, '.', ',') ?></td>
						      <td class="txt-medium"><?php echo "$".number_format($result_det_coti->total_ind, 2, '.', ',') ?></td>
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
							    	<p class="txt-medium font-bold">CONDICIONES</p>
							    	<p class="separacion-5px txt-small"> Anticipo del 60</p>
									<p class="separacion-5px txt-small"> Saldo para su liberación y/o envío</p>
									<p class="separacion-5px txt-small"> Tiempo de entrega a convenir</p>
									<p class="separacion-5px txt-small"> Precios vigentes para el mes de curso</p>
									<p class="separacion-5px txt-small"> Descuento por pronto pago vigencia 10 días</p>
									<p class="separacion-5px txt-small"> Envío gratuito solo aplica para tránsito terrestre *verifica cobertura</p>
							    </td>
							    <td class="contenedor-totales" colspan="2">
							    	<table class="table">
										@if($cotizacionesRedes->descuento_aplicado != 0)
								    	<tr>
									    	<td class="txt-medium text-left con-bordes">DESCUENTO</td>
									    	<td class="txt-medium text-center con-bordes"><?php echo "-$".number_format($cotizacionesRedes->descuento_aplicado, 2, '.', ',') ?></td>
								    	</tr>
										@endif
								    	<tr class="fila-sin-bordes">
										    <td class="txt-medium text-left con-bordes">SUBTOTAL</td>
										    <td class="txt-medium text-center con-bordes"><?php echo "$".number_format($cotizacionesRedes->subtotal, 2, '.', ',') ?></td>
										</tr>
										<tr class="fila-sin-bordes">
										    <td class="txt-medium text-left con-bordes">IMPUESTOS</td>
										    <td class="txt-medium text-center con-bordes"><?php echo "$".number_format($cotizacionesRedes->iva, 2, '.', ',') ?></td>
										</tr>
										<tr class="fila-sin-bordes">
										    <td class="txt-medium text-left con-bordes">TOTAL</td>
										    <td class="txt-medium text-center con-bordes"><?php echo "$".number_format($cotizacionesRedes->total, 2, '.', ',') ?></td>
										</tr>
							    	</table>
							    </td>
							</tr>
						

					  </tbody>
					</table>
		    	</div>
		    </div>
		    <table class="row footer-content">
		    	<tr>
			    	<td colspan="3" class="col-md-6 footer-info" style="width: 50%">
			    		<img style="padding-bottom: 50px;" src="{{url('storage/qrs_cotizaciones/')}}/{{$cotizacionesRedes->id_cotizacion}}.png" alt="">
			    	</td>
			    	<td class="col-md-6 text-center footer-info"  style="width: 50%">
						<img width="150px" src="{{url('cotizaciones/img/logosantander.png')}}" alt="">
			    		<p class="txt-medium separacion-5px">REDES ANTICAIDAS S.A DE C.V</p>
						<p class="txt-medium separacion-5px">CUENTA: 65-50656173-4</p>
						<p class="txt-medium separacion-5px">CLABE: 014910655065617341</p>
			    	</td>
		    	</tr>
		    </table>
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
			<div class="page-break"></div>
	    	<div id="{{$infoProducto->SKU}}" class="row cont-secciones-cotizaciones mt-20">
	    		<table>
	    			<tr>
				    	<td style="width: 50%" class="col-md-6">
				    		<p class="tit-princ font-bold separacion-5px">FICHA TÉCNICA </p>
				    		<p class="tit-second font-bold separacion-5px">{{$infoProducto->nombre_p}}</p>
				    	</td>
				    	<td style="width: 50%" class="col-md-6 text-center">
				    		<img width="200px" src="{{url('cotizaciones/img/redes-perimetrales-logotipo-cotizaion.jpeg')}}" alt="">
			  				<p class="text-img txt-medium">¿Sabías que el 80% de los siniestros en construcción se deben a caídas?</p>
				    	</td>
	    			</tr>
			    </table>
			    <div class="row">
			    	<div class="txt-medium">
			    		<p class="font-bold">DESCRIPCIÓN</p>
			    		<?php 
			    		echo $infoProducto->descripcion_producto;
			    		 ?>
			    	</div>
			    </div>
			    @if($infoProducto->num_plantilla == 1)
				    <table class="row cont-plantilla">
				    	<tr>
					    	<td style="width: 50% z-index: 10;" class="separacion-8px txt-medium">
					    		<p class="font-bold">CARACTERISTICAS</p>
					    		<?php 
					    		echo $infoProducto->caracteristicas_producto;
					    		 ?>
					    	</td>
					    	<td style="width: 50% z-index: 10; text-align: center;" class="col-md-6">
					    		<img width="300px" src="{{ \App\Utilidades::obtenerImagenBase64('storage/productos/' . $infoProducto->id_producto . '/' . $infoProducto->imagen) }}" alt="">
					    	</td>
				    	</tr>
				    </table>
			    @elseif($infoProducto->num_plantilla == 2)
				    <div class="row cont-plantilla">
				    	<div style="z-index: 10;" class="separacion-8px  txt-medium">
				    		<p class="font-bold">CARACTERISTICAS</p>
				    		<?php 
				    		echo $infoProducto->caracteristicas_producto;
				    		 ?>
				    	</div>
				    </div>
				    <div class="row cont-plantilla">
				    	<div style="z-index: 10; text-align: center;" class="col-md-12">
				    		<img width="300px" src="{{ \App\Utilidades::obtenerImagenBase64('storage/productos/' . $infoProducto->id_producto . '/' . $infoProducto->imagen) }}" alt="">
				    	</div>
				    </div>
			    @endif
			    <div class="row">
			    	<div style="z-index: 10;" class="txt-medium">
			    		<?php 
			    		echo $infoProducto->extra_info_producto;
			    		 ?>
			    	</div>
			    </div>
			    <table class="row footer-content-ficha">
			    	<tr>
				    	<td colspan="3" class="col-md-6 footer-info" style="width: 50%">
				    		
				    	</td>
				    	<td class="col-md-6 text-center footer-info"  style="width: 50%">
				    		<img width="150px" src="{{url('cotizaciones/img/logosantander.png')}}" alt="">
			    		<p class="txt-medium separacion-5px">REDES ANTICAIDAS S.A DE C.V</p>
						<p class="txt-medium separacion-5px">CUENTA: 65-50656173-4</p>
						<p class="txt-medium separacion-5px">CLABE: 014910655065617341</p>
				    	</td>
			    	</tr>
			    </table>
			</div>
		@endforeach

	</div>
@stop