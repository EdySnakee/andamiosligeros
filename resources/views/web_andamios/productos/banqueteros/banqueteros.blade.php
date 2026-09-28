@extends('layouts.web_andamios')
@section('css')
    <title>Andamios Ligeros Banqueteros | Andamios ligeros| Andamios Galvanizados</title>
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
    <meta property="og:title" content="Andamios ligeros Banqueteros| Andamios Galvanizados | Andamios" />
    <meta property="og:site_name" content="Andamios ligeros Banqueteros| Andamios Galvanizados | Andamios" />
    <meta property="og:description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />

    <link rel="stylesheet" href="{{url('web/css/prod-page.css')}}">
    <link rel="canonical" href="{{route('web_banqueteros')}}">
    <meta property="og:url" content="{{route('web_banqueteros')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.banqueteros.contenido_banqueteros')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop

