@extends('layouts.web_andamios')
@section('css')
	<title> {{$ObjBlog->post_titulo}} | Andamios Ligeros Galvanizados</title>
	<meta name="description" content="{{$ObjBlog->meta_descripcion}}" />
	<meta name="keywords" content="{{$ObjBlog->palabras_clave}}" />
	<meta property="og:image" content="{{url('storage/blog')}}/{{$ObjBlog->id_blog}}/{{$ObjBlog->img_portada}}" />
	<meta property="og:image:secure_url" content="{{url('storage/blog')}}/{{$ObjBlog->id_blog}}/{{$ObjBlog->img_portada}}" />
	<meta property="og:title" content="{{$ObjBlog->post_titulo}}" />
	<meta property="og:site_name" content="{{$ObjBlog->post_titulo}}" />
	<meta property="og:description" content="{{$ObjBlog->meta_descripcion}}" />

	<link rel="canonical" href="https://andamiosligeros.com/blog/{{$ObjBlog->post_url}}">
	@include('web_andamios.includes.css_extra_loco')
	<link rel="stylesheet" href="{{url('web/owl/owlcarousel/assets/owl.carousel.min.css')}}">
	<style>
			.eti-vencida {
		position: absolute;
		z-index: 2;
		background: #cb0c0c;
		padding: 8px 19px;
		color: white;
		top: 15px;
		right: 30px;
		border-radius: 15px;
		box-shadow: 0px 0px 5px #333;
	}
	.prod-vencido {
		/* filter: blur(2px); */
		opacity: 0.5;
	}
	.eti-vencida:before {
		content: '';
		position: absolute;
		top: 5px;
		left: 5px;
		right: 5px;
		bottom: 5px;
		border-radius: 15px;
		border: 2px white solid;
	}
	.cont-item-product h2 {
		font-size: 14px;
		margin-bottom: 5px;
	}
	.modelo {
		color: #232323;
		font-weight: lighter;
	}
	.form-cate {
		border: 2px #0648d6 solid !important;
		color: #0648d6 !important;
		padding: 5px !important;
		border-radius: 10px;
	}
	.datos-filtro {
		display: flex;
		padding-bottom: 2vw;
	}
	.pdr1{
		padding-right: 1vw;
	}
	.cont-prod-int .col-md-4 {
    width: 33.33%;
    float: left;
}
img.img-fluid {
    max-width: 100%;
}
.mas-info-det {
    display: flex;
}
.cont-prod-int {
    width: 80vw;
}
.blogs-relacionados li a {
    font-size: 12px;
    color: #1a1a1a;
}

.mt-3 {
    margin-top: 3vw;
}
@media (max-width:767px) {
	.mas-info-det {
		display: block;
	}
	.cont-prod-int .col-md-4 {
		width: 100%;
	}
}

	</style>
@stop
@section('content')
	<main class="blog">
	    @include('web_andamios.blog.detalle_blog.contenido_detalle_blog')
	    @include('web_andamios.includes.redes_sociales_web')
	</main>
@stop

@section('js')
	<script src="{{url('web/owl/owlcarousel/owl.carousel.min.js')}}"></script>
	@include('web_andamios.includes.scripts_funciones')
@stop