
@extends('layouts.web_andamios')
@section('css')
	<title>Andamios Ligeros | Andamios Galvanizados | Andamios en México</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{url('web/img/AndamiosLigeros-Ft-Banner.webp')}}" />
	<meta property="og:image:secure_url" content="{{url('web/img/AndamiosLigeros-Ft-Banner.webp')}}" />
	<meta property="og:title" content="Andamios Ligeros | Andamios Galvanizados | Andamios en México" />
	<meta property="og:site_name" content="Andamios Ligeros | Andamios Galvanizados | Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	{{-- owl.carousel.min.css y prod-page.css diferidos: no bloquean el render inicial --}}
	<link rel="preload" href="{{url('web/owl/owlcarousel/assets/owl.carousel.min.css')}}" as="style"
	      onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="{{url('web/owl/owlcarousel/assets/owl.carousel.min.css')}}"></noscript>

	<link rel="preload" href="{{url('web/css/prod-page.css')}}" as="style"
	      onload="this.onload=null;this.rel='stylesheet'">
	<noscript><link rel="stylesheet" href="{{url('web/css/prod-page.css')}}"></noscript>

	<link rel="stylesheet" href="{{ url('loco/css/bootstrap.css') }}">

    <style>
        .col-4, .col-5, .col-7, .col-8 {
            max-width: 100%;
        }

        .row {
            margin: 0;
        }

        .px-4 {
            padding: 0 !important;
        }

        h1, h2, h3, h4, h5, h6 {
            font-weight: bold !important;
        }

        #paquete-pr4, #paquete-pr5, #paquete-pr6 {
            display: none !important;
        }
    </style>
@stop

@section('content')
	<main class="page-normal">
	    @include('web_andamios.index.contenido_index')
	</main>
    
@stop
@section('js')
    <script src="{{url('web/owl/owlcarousel/owl.carousel.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" defer></script>
    @include('web_andamios.includes.scripts_funciones')
    <script>
    $(document).ready(function(){
      $("#carrousel-andamios").owlCarousel({
        items:1,
        loop:true,
        nav:true,
        navText: [
              "<i class='fa fa-angle-left'></i>",
              "<i class='fa fa-angle-right'></i>"
          ]
      });

      $('#brand-logos').owlCarousel({
        loop: true,
        autoplay: true,
        autoplayTimeout: 2500,
        responsiveClass: true,
        responsive: {
            0: {
                items: 3
            },
            
            600: {
                items: 4
            },
            1000: {
                items: 9
            }
        }
      });
    });
    </script>
@stop

