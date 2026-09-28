@extends('layouts.web_andamios')
@section('css')
    <title> Blog 📰| Andamios Ligeros | Andamios Galvanizados</title>
    <meta name="description" content="Blog de andamios ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta name="keywords" content="construccion, malla de seguridad, norma oficial mexicana nom-009-stps-2011, nom-009-stps-2011, perimetrales, perimetral, proteccion, Mallas anticaidas, red, Mallas perimetrales" />
    
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */ ?>
    
    <meta property="og:title" content="nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta property="og:site_name" content="Blog 📰| Andamios Ligeros | Andamios Galvanizados" />
    <meta property="og:description" content="nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />

    <link rel="canonical" href="{{url('/blog')}}">
    <meta property="og:url" content="{{url('/blog')}}" />
@stop
@section('content')
    <main class="blog">
        @include('web_andamios.blog.contenido_blog')
        @include('web_andamios.includes.redes_sociales_web')
    </main>
    
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
@stop
