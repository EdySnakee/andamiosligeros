@extends('layouts.web_andamios')
@section('css')
<!-- Title -->
<title>Políticas de pagos | Andamios Ligeros</title>
<meta name="description" content="">
<meta name="author" content="Eureka">
<meta name="keywords" content="">

<meta property="og:description" content="">
<meta property="og:title" content="Políticas de pagos | Andamios Ligeros">
<meta name="twitter:description" content="">
<meta name="twitter:title" content="Políticas de pagos | Andamios Ligeros">

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
					<h1 class="titulofondoverde">Políticas de pagos</h1>
					<div class="post"><p> Todas los precios mostrados en nuestro sitio web así como en nuestras sucursales son en Moneda Nacional (MXN) en curso (Pesos Mexicanos), por lo cual el pago sera en la Moneda Nacional en curso como forma principal de moneda. </p><p> En dado caso que desee pagar con alguna divisa esta se hará al cambio correspondiente que emita el Banco de México según la tasa de conversión. Andamios ligeros se reserva el derecho a aceptar ciertas divisas ya sea por su dificultad de cambio o por la tasa de conversión en cuestión, nuestros asesores le podrán brindar mas información al respecto. </p><p> Dentro de nuestro sitio web las formas de pagos es exclusivamente mediante paypal </p><p> En cualquiera de nuestras sucursales físicas u oficinas el tipo de pago podrá ser: </p><ol class="ol-style3"><li>Aceptamos todas las tarjetas de crédito y débito</li><li>Aceptamos transferencias bancarias</li><li>Deposito a cuenta bancaria en tiendas de autoservicio (OXXO)</li></ol><p> Todas los pagos deben ser completos según el monto estipulado en el articulo o según se le haya cotizado por escrito, para garantizar la compra. </p><p> Los pagos parciales se entenderán bajo el concepto de apartar un producto, es decir, que el producto queda reservado para usted y sera entregado hasta que sea cubierto el pago en su totalidad. </p><p> Se tendrá un plazo de 15 días naturales para realizar el pago completo del producto si usted ha dado un pago parcial, en caso de exceder la fecha señala y no realizar el pago completo, se le devolverá su pago parcial menos el 35% por concepto de almacenaje, retención y cancelación sin fundamentos. </p><p> podrá cancelar un producto si ha pagado completamente o parcialmente un producto sin perjuicio alguno devolviendole todo su dinero que ha pagado según lo estipulado en la sección políticas de cancelaciones, en caso opuesto si no hubiera incumplimiento de nuestra parte al cancelar Andamios ligeros se reserva el derecho de cobrar hasta el 10% del monto pagado por gastos de retención. </p><p> Usted podrá facturar sus productos a partir del momento de la compra y con un plazo no mayor a 15 días naturales, usted puede solicitar su facturación por vía telefónica o por escrito (email) proporcionándonos la información necesaria para generar su factura electrónica. </p><p> Podrá facturar de dos formas posibles según usted requiera: </p><ol class="ol-style3"><li> Facturación por pago completo.- Usted al pagar completamente el producto se le facturara por la cantidad que usted pago por el o los productos. </li><li> Facturación por pagos parciales.- Usted al pagar parcialmente sus productos puede facturar por la cantidad parcial que pago con respecto al o los productos y al finalizar el pago restaste podrá facturar la cantidad restante que pago. </li></ol><p> Para la facturación por pagos parciales no se podrá realizar mas de 3 facturas si el monto total a facturar es menor a 10 mil pesos (MXN), en caso de exceder el monto mínimo podrá facturar no mas de 5 facturas independientemente la cantidad total a facturar. </p></div>
				</div>
			</div>
		</div>
	</main>
@stop
@section('js')
	
@stop