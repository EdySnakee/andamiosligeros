@extends('layouts.web_andamios')
@section('css')
	<title>Gracias por descargar</title>
	<meta name="description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
	<meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
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
	<meta property="og:title" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
	<meta property="og:site_name" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
	<meta property="og:description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />
	
	<link rel="stylesheet" href="{{url('web/owl/owlcarousel/assets/owl.carousel.min.css')}}">
	
	<link rel="canonical" href="{{url('/thank-you-descargar')}}">
	<meta property="og:url" content="{{url('/thank-you-descargar')}}" />
    <style>
    .thank-you {
        height: 100vh;
        display: flex;
        align-items: center;
        justify-content: center;
        background: url("{{url('web/img/img-banner-andamios-ligeros.webp')}}");
        background-size: cover;
        background-attachment: fixed;
        background-position: center center;
    }
    .cont-thnakyou {
        width: 50vw;
        background: white;
        padding: 6vw 5vw;
        position: relative;
    }
    .caja-btn{
        margin: 0 auto;
        left: 0;
        bottom: 1.5vw;
        right: 0;
    }
    @media (max-width: 767px) {
        .cont-thnakyou {
            width: 80vw;
            padding: 20vw 5vw;
        }
    }
    </style>
@stop

@section('content')
	<main class="page-normal">
	    <section class="thank-you">
            <div class="cont-thnakyou text-center">
                <h2>¡GRACIAS!</h2>   
                <p>Te enviamos un email con el archivo adjunto.</p>
                <div class="caja-btn">
                    <a href="{{url('/')}}" class="btn-open-modal-financial btn-financial"><span>Regresar al inicio</span></a>
                </div>
            </div>
        </section>
	</main>
    
@stop
@section('js')
    
@stop

