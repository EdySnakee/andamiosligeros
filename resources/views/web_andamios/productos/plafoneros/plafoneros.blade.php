@extends('layouts.web_andamios')
@section('css')
    <title>Andamios Ligeros Plafoneros | Andamios ligeros| Andamios Galvanizados</title>
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
    <meta property="og:title" content="Andamios ligeros Plafoneros| Andamios Galvanizados | Andamios" />
    <meta property="og:site_name" content="Andamios ligeros Plafoneros| Andamios Galvanizados | Andamios" />
    <meta property="og:description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />

    <link rel="canonical" href="{{route('web_plafoneros')}}">
    <meta property="og:url" content="{{route('web_plafoneros')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.plafoneros.contenido_plafoneros')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop

