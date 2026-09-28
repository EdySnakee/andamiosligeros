@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros Plafoneros SPL-4 | Barandal para andamios</title>
    <meta name="description" content="Andamio pasillero , el más angosto en su tipo , peldaños de 60 cm se adapta perfectamente a los espacios más ajustados , sus dimensiones, lo hace el más practico para trabajos en interiores." />
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
    <meta property="og:title" content="Andamios ligeros Plafoneros SPL-4 | Barandal para andamios" />
    <meta property="og:site_name" content="Andamios ligeros Plafoneros SPL-4 | Barandal para andamios" />
    <meta property="og:description" content="Andamio pasillero , el más angosto en su tipo , peldaños de 60 cm se adapta perfectamente a los espacios más ajustados , sus dimensiones, lo hace el más practico para trabajos en interiores." />

    <link rel="canonical" href="{{route('web_spl4')}}">
    <meta property="og:url" content="{{route('web_spl4')}}" />
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.productos.plafoneros.spl4.contenido_spl4')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop

