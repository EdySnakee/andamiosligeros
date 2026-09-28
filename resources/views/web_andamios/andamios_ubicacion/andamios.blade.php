@extends('layouts.web_andamios_loco')
@section('css')
	<title>Andamios Ligeros en {{$location}} | Venta de andamios galvanizados</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
	<?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */ ?>
	<meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
	<?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */ ?>
	<meta property="og:title" content="Andamios Ligeros en {{$location}} | Andamios Galvanizados" />
	<meta property="og:site_name" content="Andamios Ligeros en {{$location}} | Andamios Galvanizados" />
	<meta property="og:description" content="Andamios Ligeros {{$location}}, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	
	<link rel="canonical" href="{{url('/')}}">
	<meta property="og:url" content="{{url('/')}}" />
    <style>
   
    </style>
@stop

@section('content')
    @include('web_andamios.andamios_ubicacion.contenido_andamios')
    <div id="modal-andamios" class="cont-form-cotiza cerrado">
		<a class="cerrar" href="#" id="cerrar"><i class="fa fa-close"></i> Cerrar</a>
		<form id="cotizaForm" name="sentMessage" novalidate="novalidate" enctype="multipart/form-data">
			<div class="row">
				<h1><span class="border-title-secc">Cotiza</span> <br>andamios ligeros</h1>
				<div class="twelve columns">
					<div class="form-group">
						<input autocomplete="off" class="form-control" id="nombre" type="text" placeholder="Tu nombre *" required="required" data-validation-required-message="Necesitamos tu nombre.">
						<p class="help-block text-danger"></p>
					</div>
					<div class="form-group">
						<input autocomplete="off" class="form-control" id="andamio_interes" type="text" placeholder="Andamio de interes" required="required" data-validation-required-message="Selecciona un producto.">
						<p class="help-block text-danger"></p>
					</div>
					<div class="form-group">
						<input autocomplete="off" class="form-control" id="correo" type="email" placeholder="Tu email *" required="required" data-validation-required-message="Necesitamos tu correo.">
						<p class="help-block text-danger"></p>
					</div>
					<div class="form-group">
						<input autocomplete="off" class="form-control" id="celular_cli" type="number" placeholder="Tu celular *" maxlength="10" minlength="10" required="required" data-validation-required-message="Necesitamos tu numero de celular.">
						<p class="help-block text-danger"></p>
					</div>
					<div class="form-group">
						<textarea class="form-control" id="mensaje" placeholder="Mensaje "></textarea>
						<p class="help-block text-danger"></p>
					</div>
				</div>
				<div class="twelve columns text-center">
					 <div id="success_cli"></div>
					 <button id="sendMessageButtonCotiza" class="btn-send-coti" type="submit">Enviar mensaje</button>
				</div>
			</div>
		</form>
	</div>
	
@stop
@section('js')

@stop

