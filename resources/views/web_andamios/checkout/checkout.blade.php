@extends('layouts.web_andamios')
@section('css')
    <title>Checkout</title>
    <meta name="description"
        content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
    <meta name="keywords"
        content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />

    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />

    <meta property="og:title" content="Checkout" />
    <meta property="og:site_name" content="Checkout" />
    <meta property="og:description"
        content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />

    <script>
        let landing = localStorage.getItem('landing');

        if (landing) {
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('#navbar').remove();
                document.querySelector('footer').remove();
                document.querySelector('.remove-from-cart').remove();
                document.querySelector('.clear-cart').remove();
                document.querySelector('.continuar-compra').remove();
            });
        }

        // Obtener el valor de 'landing' desde el localStorage

        // Verificar si 'landing' es verdadero (no null o vacío)
        if (landing) {
            // Crear el script para el Meta Pixel
            let pixelScript = document.createElement('script');
            pixelScript.innerHTML = `
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '490946903886780');
        fbq('track', 'InitiateCheckout');
    `;

            // Insertar el script en el head de la página
            document.head.appendChild(pixelScript);

            // Crear la etiqueta noscript para el seguimiento en caso de que no haya JavaScript habilitado
            let noScript = document.createElement('noscript');
            noScript.innerHTML = `
        <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=490946903886780&ev=PageView&noscript=1"
        />
    `;

            // Insertar el noscript en el body de la página
            document.head.appendChild(noScript);
        }
    </script>

    <link rel="canonical" href="{{ url('/checkout') }}">
    <meta property="og:url" content="{{ url('/checkout') }}" />
    @include('web_andamios.includes.css_extra_loco')
    <link rel="stylesheet" href="{{ url('loco/css/bootstrap.css') }}">
    <style>

    </style>
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.checkout.contenido_checkout')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')

@stop
