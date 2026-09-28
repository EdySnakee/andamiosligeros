@extends('layouts.web_andamios')
@section('css')
<!-- Title -->
<title>Políticas de compras | Andamios Ligeros</title>
<meta name="description" content="">
<meta name="author" content="Eureka">
<meta name="keywords" content="">

<meta property="og:description" content="">
<meta property="og:title" content="Políticas de compras | Andamios Ligeros">
<meta name="twitter:description" content="">
<meta name="twitter:title" content="Políticas de compras | Andamios Ligeros">

<meta name="twitter:card" content="summary">
<meta property="og:type" content="website" />
@include('web_andamios.includes.css_extra_loco')
<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
<script>
	var URL_BASE_WEB = '<?php echo url("/"); ?>';
</script>
@stop
@section('content')
	<main class="page-normal">
		<div class="container-md cont-princ-product text-justify">
			<div class="row content">
				<div class="col-md-12">
					<h1 class="titulofondoverde">Políticas de compras</h1>
					<div class="post"><p> El número de orden que se asigna al realizar la transacción en el sitio de Internet de Andamios Ligeros no implica la aceptación de la transacción. En caso de tener algún problema con tu orden te será comunicado por correo electrónico o vía telefónica. </p><p></p><p>La mercancía está sujeta a disponibilidad. Si no hay existencias, le avisaremos oportunamente.</p><p>Es posible que la imagen no corresponda al producto publicado.</p><p>Los tiempos de entrega varían en función del destino y ocurren en cualquier momento del día.</p><p>necesario que la persona registrada como destinatario sea quien recibe la mercancía.</p><p>Consulte la sección de políticas para ver la mercancía aceptable en devolución.</p><p>En ciertas compras, Andamios Ligeros se reserva el derecho de realizar solicitud adicional de documentos y firmas.</p></div>
				</div>
			</div>
		</div>
	</main>
@stop
@section('js')
	
@stop