@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros STP-1| Andamios Galvanizados</title>
    <meta name="description"
        content="Andamio ligero, medida estándar con 5 peldaños es ideal obra de altura y manipular elementos pesados ya que con sus dimensiones brinda estabilidad con sus 3mt2 de área que abarca." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:title" content="Andamios ligeros STP-1| Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios ligeros STP-1| Andamios Galvanizados" />
    <meta property="og:description"
        content="Andamio ligero, medida estándar con 5 peldaños es ideal obra de altura y manipular elementos pesados ya que con sus dimensiones brinda estabilidad con sus 3mt2 de área que abarca." />

    <link rel="stylesheet" href="{{ url('loco/css/bootstrap.css') }}">
    <link rel="canonical" href="{{ route('web_stp1') }}">
    <link rel="stylesheet" href="{{ url('web/owl/owlcarousel/assets/owl.carousel.min.css') }}">

    <meta property="og:url" content="{{ route('web_stp1') }}" />


@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.tradicional.stp1.contenido_stp1')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
        integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous">
    </script>
    <script src="{{ url('web/owl/owlcarousel/owl.carousel.min.js') }}"></script>
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    <script>
        AOS.init();
    </script>
    <script>
        $(document).ready(function() {
            $("#carrousel-andamios").owlCarousel({
                items: 1,
                loop: true,
                nav: true,
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
