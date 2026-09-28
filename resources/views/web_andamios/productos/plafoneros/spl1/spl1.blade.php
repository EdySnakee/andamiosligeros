@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros Plafoneros SPL-1| Andamios Galvanizados</title>
    <meta name="description" content="Andamio Pasillero de cuatro peldaños, el más práctico y cómodo en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior, no se recomienda apilar más de 3 elementos, tambien es ideal para alturas que no se rebase los 4 metros." />
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
    <meta property="og:title" content="Andamios ligeros Plafoneros SPL-1| Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios ligeros Plafoneros SPL-1| Andamios Galvanizados" />
    <meta property="og:description" content="Andamio Pasillero de cuatro peldaños, el más práctico y cómodo en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior, no se recomienda apilar más de 3 elementos, tambien es ideal para alturas que no se rebase los 4 metros." />

    <link rel="canonical" href="{{route('web_spl1')}}">
    <meta property="og:url" content="{{route('web_spl1')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.plafoneros.spl1.contenido_spl1')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop

