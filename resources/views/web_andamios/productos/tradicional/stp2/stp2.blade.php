@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros STP-2| Andamios Galvanizados</title>
    <meta name="description" content="Andamio ligero constituido con tubería galvanizada de 1,1/2 pulgadas de grosor. medidas: 2 de alto x 1.5 de ancho x 2 mts entre crucetas. " />
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
    <meta property="og:title" content="Andamios ligeros STP-2| Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios ligeros STP-2| Andamios Galvanizados" />
    <meta property="og:description" content="Andamio ligero constituido con tubería galvanizada de 1,1/2 pulgadas de grosor. medidas: 2 de alto x 1.5 de ancho x 2 mts entre crucetas. " />

    <link rel="canonical" href="{{route('web_stp2')}}">
    <meta property="og:url" content="{{route('web_stp2')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.tradicional.stp2.contenido_stp2')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop

