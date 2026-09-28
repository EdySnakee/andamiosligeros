
@extends('layouts.web_andamios')
@section('css')
	<title>Página no encontrada Andamios en México</title>
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
	<meta property="og:title" content="Página no encontrada Andamios en México" />
	<meta property="og:site_name" content="Página no encontrada Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
    
    <style>
        .error404 {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .error404 h1 {
            font-size: 20vw;
            line-height: 1;
        }
    </style>

@stop

@section('content')
	<main class="page-normal">
	    <div class="error404">
            <div>
                <h1>404</h1>
                <h2>¡Lo sentimos, la página que estás buscando no existe!</h2>
            </div>
        </div>
	</main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')

@stop

