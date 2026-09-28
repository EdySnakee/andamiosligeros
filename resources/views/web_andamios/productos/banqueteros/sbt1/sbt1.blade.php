@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros Banqueteros SBT-1| Andamios Galvanizados</title>
    <meta name="description" content="Andamio banquetero de cinco peldaños, es ideal para obras ligeras, trabajos en interior y espacios reducidos, con sus cinco peldaños permite subir con seguridad y comodidad por la escalerilla." />
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
    <meta property="og:title" content="Andamios ligeros Banqueteros SBT-1| Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios ligeros Banqueteros SBT-1| Andamios Galvanizados" />
    <meta property="og:description" content="Andamio banquetero de cinco peldaños, es ideal para obras ligeras, trabajos en interior y espacios reducidos, con sus cinco peldaños permite subir con seguridad y comodidad por la escalerilla." />

    <link rel="canonical" href="{{route('web_sbt1')}}">
    <meta property="og:url" content="{{route('web_sbt1')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.banqueteros.sbt1.contenido_sbt1')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop

