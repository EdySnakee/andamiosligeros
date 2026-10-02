@extends('layouts.web_andamios')
@section('css')
	<title>Gracias por tu compra</title>
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
	
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '5243995428995951');
        fbq('track', 'Purchase');
      </script>
      
    @if (!empty($json_datos_sts_vta->articulo) && (is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['id_producto'] ?? 0) == 1 : ($json_datos_sts_vta->articulo->id_producto ?? 0) == 1))
        @php
            $art_id = is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['id_producto'] ?? '') : ($json_datos_sts_vta->articulo->id_producto ?? '');
            $art_tit = is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['titulo'] ?? '') : ($json_datos_sts_vta->articulo->titulo ?? '');
        @endphp
        <script>
            ttq.track('CompletePayment', {
                "contents": [{
                    "content_id": "{{ $art_id }}",
                    "content_type": "product",
                    "content_name": "{{ $art_tit }}"
                }],
                "value": {{ $json_datos_sts_vta->total_orden ?? 0 }},
                "currency": "MXN"
            });
        </script>
    @endif

	
	<link rel="canonical" href="{{url('/status_venta')}}">
	<meta property="og:url" content="{{url('/status_venta')}}" />
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
        padding: 6vw 5vw;
        position: relative;
        border-radius: 1em;
        box-shadow: 0 0.15rem 1.75rem 0 rgb(58 59 69) !important;
    }
    .caja-btn{
        margin: 0 auto;
        left: 0;
        bottom: 1.5vw;
        right: 0;
    }
    .confirm-orden p,
    .confirm-orden h2{
        color: white
    }
    .btn-ordenes {
        background: white;
        
        padding: 0.5em 1.5em;
        border-radius: 0.7em;
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
            <div class="cont-thnakyou text-center confirm-orden" style="background-color: {{$json_datos_sts_vta->color}}">
                <h2>{{$json_datos_sts_vta->titulo_orden}}</h2>
                <p>{{$json_datos_sts_vta->msj_orden}} <b>{{ $json_datos_sts_vta->num_orden}}</b></p>
                <p>Para mayor información acerca de su órden comuniquese con nosotros</p>
                <br>
                <a href="{{url('/')}}" class="btn-ordenes" style="color: {{$json_datos_sts_vta->color}}"><span>Regresar al inicio</span></a>
            </div>
        </section>
	</main>
    
@stop
@section('js')
    
@stop

