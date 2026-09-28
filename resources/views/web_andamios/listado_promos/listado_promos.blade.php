@extends('layouts.web_andamios')

@section('css')
	<title>Promociones | Venta de Andamios en México</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />

	<meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />

	<meta property="og:title" content="Promociones | Venta de Andamios en México" />
	<meta property="og:site_name" content="Promociones | Venta de Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	<link rel="canonical" href="{{url('/tienda-de-andamios-ligeros-galvanizados')}}">
	<meta property="og:url" content="{{url('/tienda-de-andamios-ligeros-galvanizados')}}" />
    @include('web_andamios.includes.css_extra_loco')
	<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
	
    <style>
	.info-item-promo {
		position: relative;
		padding: 1em;
	}
	.img-item-promo{
		padding: 1em;
	}

	.cont-promo {
		border: 1px #cbcbcb solid;
		padding: 10px;
		border-radius: 10px;
	}
	.cont-promo-txt {
		height: 50vh;
	}
	
.item-vencido {
    opacity: 0.5;
}
.eti{
	position: absolute;
	padding: 10px;
	border-radius: 10px;
	color: white;
	font-weight: bold;
	top: 15px;
    box-shadow: 0px 0px 5px #333;
	right: 30px;
}
.eti-vencida {
	background: #ca0303;
}
.eti-success {
	background: #03ae4a;
}

    </style>
@stop

@section('content')
	<main class="page-normal">
	    @include('web_andamios.listado_promos.contenido_listado_promos')
	</main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
	<script>
		
	</script>
@stop

