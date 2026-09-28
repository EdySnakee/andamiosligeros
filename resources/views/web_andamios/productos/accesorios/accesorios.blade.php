@extends('layouts.web_andamios')
@section('css')
	<title>Accesorios para Andamios Ligeros Galvanizados | Venta de Andamios en México</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />

	<meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />

	<meta property="og:title" content="Accesorios para Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:site_name" content="Accesorios para Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	<link rel="canonical" href="{{url('/accesorios-para-andamios')}}">
	<meta property="og:url" content="{{url('/accesorios-para-andamios')}}" />
    @include('web_andamios.includes.css_extra_loco')
	<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
    <link rel="stylesheet" href="{{url('web/css/prod-page.css')}}">
	

@stop

@section('content')
	<main class="page-normal">
	    @include('web_andamios.productos.accesorios.contenido_accesorios')
	</main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop

