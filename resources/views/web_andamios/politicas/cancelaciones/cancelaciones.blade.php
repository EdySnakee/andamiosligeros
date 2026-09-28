@extends('layouts.web_andamios')
@section('css')
<!-- Title -->
<title>Políticas de cancelación | Andamios Ligeros</title>
<meta name="description" content="">
<meta name="author" content="Eureka">
<meta name="keywords" content="">

<meta property="og:description" content="">
<meta property="og:title" content="Políticas de cancelación | Andamios Ligeros">
<meta name="twitter:description" content="">
<meta name="twitter:title" content="Políticas de cancelación | Andamios Ligeros">

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
					<h1 class="titulofondoverde">Políticas de cancelación</h1>
					<div class="post"><p> Podrá efectuar la cancelación total o parcial de una compra y el cual se le devolverá el monto pagado, bajo los siguientes términos: </p><ol class="ol-style3"><li>Si el tiempo de producción que nuestro asesor de ventas le dio ha pasado, sin importar si ha sido notificado por un asesor</li><li>Si nuestro asesor se comunica con usted para decirle que la tiempo de producción será mayor de lo esperado</li><li>Si nuestro asesor le informa que el producto dejo de estar en existencia y/o nos es imposible otorgarle el producto</li></ol><h4>Condiciones</h4><p> Se entenderá como tiempo de producción la fecha que nuestro asesor le dio y empezara a contar desde el momento que verifiquemos el pago del producto (no más de 48 horas) hasta el momento que se le expida la guía de envió de su producto. </p><p> Tanto en el punto 1 y punto 2 tendrá 72 horas para notificarnos por escrito (e-mail) que desea cancelar el producto, pasado el tiempo se entenderá tácitamente que usted esperara el nuevo tiempo de producción, el cual se le hará saber. </p><p> Para el punto 3, un asesor se comunicara haciéndole saber que no es imposible elaborar el producto y por ende no se podrá entregar, usted tendrá 10 días naturales para solicitar la devolución de su dinero de manera íntegra, en caso que no se solicite en los términos señalados se le expedirá un cupón con el valor del monto para futuras compras. </p><p>En caso de cancelaciones parciales, solo se reembolsará el precio de la mercancía y no los gastos de envío.</p></div>
				</div>
			</div>
		</div>

	</main>
	
@stop
@section('js')
	
@stop