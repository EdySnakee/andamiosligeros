@extends('layouts.web_andamios')
@section('css')
    <title>Andamios Ligeros Tradicionales | Andamios ligeros | Andamios Galvanizados</title>
    <meta name="description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{url('web/img/andamios/portada-andamios-ligeros-estandar.webp')}}" />
    <meta property="og:image:secure_url" content="{{url('web/img/andamios/portada-andamios-ligeros-estandar.webp')}}" />
    <meta property="og:title" content="Andamios Ligeros Tradicionales | Andamios ligeros | Andamios Galvanizados" />
    <meta property="og:site_name" content="Andamios Ligeros Tradicionales | Andamios ligeros | Andamios Galvanizados" />
    <meta property="og:description" content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />

    <link rel="stylesheet" href="{{url('web/css/prod-page.css')}}">
    <link rel="canonical" href="{{route('web_escenarios')}}">
    <meta property="og:url" content="{{route('web_escenarios')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.escenarios.contenido_escenarios')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop

