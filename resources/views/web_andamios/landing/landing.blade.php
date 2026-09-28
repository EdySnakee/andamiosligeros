@extends('layouts.web_andamios')
@section('css')
    <title>SBT-10</title>
    <meta name="description"
        content="Andamio Pasillero de cuatro peldaños, el más pequeño en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior, no se recomienda apilar más de 3 elementos, tambien es ideal para alturas que no se rebase los 4 metros." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/img/Andamio_SBT-10.png') }}" />
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:image:secure_url" content="{{ url('web/img/Andamio_SBT-10.png') }}" />
    <?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:title" content="Andamios Ligeros Banqueteros SBT-10 | Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios Ligeros Banqueteros SBT-10 | Andamios Galvanizados" />
    <meta property="og:description"
        content="Andamio Pasillero de cuatro peldaños, el más pequeño en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior, no se recomienda apilar más de 3 elementos, tambien es ideal para alturas que no se rebase los 4 metros." />

    <link rel="canonical" href="{{ route('web_sbt4') }}">
    <meta property="og:url" content="{{ route('web_sbt4') }}" />
    <script src="https://kit.fontawesome.com/ce8416f34e.js" crossorigin="anonymous"></script>
    <!-- Meta Pixel Code -->
    <script>
        ! function(f, b, e, v, n, t, s) {
            if (f.fbq) return;
            n = f.fbq = function() {
                n.callMethod ?
                    n.callMethod.apply(n, arguments) : n.queue.push(arguments)
            };
            if (!f._fbq) f._fbq = n;
            n.push = n;
            n.loaded = !0;
            n.version = '2.0';
            n.queue = [];
            t = b.createElement(e);
            t.async = !0;
            t.src = v;
            s = b.getElementsByTagName(e)[0];
            s.parentNode.insertBefore(t, s)
        }(window, document, 'script',
            'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '490946903886780');
        fbq('track', 'PageView');
    </script>
    <noscript><img height="1" width="1" style="display:none"
            src="https://www.facebook.com/tr?id=490946903886780&ev=PageView&noscript=1" /></noscript>
    <!-- End Meta Pixel Code -->

@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.landing.contenido_landing')
        @include('web_andamios.landing.landing_css_loco')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')

    @include('web_andamios.includes.scripts_landing')
    {{-- @include('web_andamios.includes.scripts_funciones') --}}
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop
