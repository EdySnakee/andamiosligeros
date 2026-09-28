@extends('layouts.web_redes')
@section('css')
	<title> {{$ObjBlog->post_titulo}} | Mallas anticaidas</title>
	<meta name="description" content="{{$ObjBlog->meta_descripcion}}" />
	<meta name="keywords" content="{{$ObjBlog->palabras_clave}}" />
	<meta property="og:image" content="{{url('storage/blog')}}/{{$ObjBlog->id_blog}}/{{$ObjBlog->img_portada}}" />
	<meta property="og:image:secure_url" content="{{url('storage/blog')}}/{{$ObjBlog->id_blog}}/{{$ObjBlog->img_portada}}" />
	<meta property="og:title" content="{{$ObjBlog->post_titulo}}" />
	<meta property="og:site_name" content="{{$ObjBlog->post_titulo}}" />
	<meta property="og:description" content="{{$ObjBlog->meta_descripcion}}" />

	<link rel="canonical" href="https://mallasanticaidas.com/blog/{{$ObjBlog->post_url}}">
@stop
@section('content')
    @include('web_redes.blog.detalle_blog.contenido_detalle_blog')
@stop

@section('js')
@stop