@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros Plegable SBT-8 | Andamios Galvanizados</title>
    <meta name="description" content="ANDAMIOS PLEGABLES MULTIUSOS GALVANIZADOS , Ideal para espacios pequeños, en interior o exterior, fácil de llevar y muy practico a la hora de usarse." />
    <meta name="keywords" content="andamios, andamios ligeros, andamios galvanizados, andamios plegables, andamios multiusos, andamios certificados, andamios amarillos, andamios amarillos monterrey, andamios amarillos guadalajara, andamios méxico, andamios banqueteros, andamios en venta, andamios para construcción, andamios precios" />
    <meta property="og:image" content="{{url('web/img/social/social-plegable2.jpg')}}" />
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */ ?>
    <meta property="og:image:secure_url" content="{{url('web/img/social/social-plegable2.jpg')}}" />
    <?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */ ?>
    <meta property="og:title" content="Andamios ligeros Plegable SBT-8 | Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios ligeros Plegable SBT-8 | Andamios Galvanizados" />
    <meta property="og:description" content="ANDAMIOS PLEGABLES MULTIUSOS GALVANIZADOS , Ideal para espacios pequeños, en interior o exterior, fácil de llevar y muy practico a la hora de usarse." />
    @include('web_andamios.includes.css_extra_loco')
    <link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
    <link rel="canonical" href="{{route('web_sbt8')}}">
    <meta property="og:url" content="{{route('web_sbt8')}}" />
    <style>
    .cont-flex {
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .resp-video {
        width: 100%;
        height: 100vh;
    }
    .cont-img-medidas {
        width: 50vw;
        margin: 0 auto;
    }
    .cont-img-medidas img {
        width: 100%;
    }
    </style>
@stop

@section('content')
    <main class="page-normal page-landung-andamiosbt8">
        @include('web_andamios.productos.banqueteros.sbt8.contenido_sbt8')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
    <script>
        /*
        $(function() {
            const video = $('.resp-video')[0];

            const observer = new IntersectionObserver(entries => {
                entries.forEach(entry => {
                if (entry.isIntersecting) {
                    video.play();
                } else {
                    video.pause();
                }
                });
            });
            observer.observe($('.video-container')[0]);
        });
        */
    </script>
@stop

