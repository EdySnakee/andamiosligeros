@extends('layouts.web_andamios')
@section('css')
	<title>Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México</title>
	<meta name="description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{ url('web/img/andamios-plegables.jpg') }}" />

	<meta property="og:image:secure_url" content="{{ url('web/img/andamios-plegables.jpg') }}" />

	<meta property="og:title" content="Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:site_name" content="Tienda de Andamios Ligeros Galvanizados | Venta de Andamios en México" />
	<meta property="og:description" content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
	
	<link rel="canonical" href="{{url('/tienda')}}">
	<meta property="og:url" content="{{url('/tienda')}}" />
    @include('web_andamios.includes.css_extra_loco')
	<link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
	<style>
	.p-right{
		position: absolute;
		top: 10px;
		right: 10px;	
		left: inherit !important;
	}
	.banner-promo button {
    display: block !important;
    position: absolute;
    top: 10px;
    right: 30px;
}
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
	</style>

@stop

@section('content')
	<main class="page-normal">
	    @include('web_andamios.tienda.contenido_tienda')
	</main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
	<script>
		$(document).ready(function() {
			hoverCard()
			actualizaProductos();
		});
		

		$(document).on("click", "#close_banner", closeBanner);
		$(document).on("change", "#filter_categoria", filtraCate);
		$(document).on("change", "#filter_model", filtraModel);

		function closeBanner() {
			$(".banner-promo").html("")
		}

		function hoverCard() {
			$( ".card-product" ).hover(
				function() {
					$(this).addClass('shadow').css('cursor', 'pointer'); 
				}, function() {
					$(this).removeClass('shadow');
				}
			);
		}
		function filtraCate() {
			var categoria =  $(this).val()
			$("#filter_categoria").attr('data-active-cate', categoria)
			$("#active_cate > span").removeClass('activo')
			$("span", this).addClass('activo')

			var categoria_activa = $("#filter_categoria").attr('data-active-cate')
			var modelo_activo = $("#filter_model").attr('data-active-model')

			actualizaProductos(categoria_activa, modelo_activo)
		}
		function filtraModel() {
			var model =  $(this).val()
			$("#filter_model").attr('data-active-model', model)

			$("#active_model > span").removeClass('activo')
			$("span", this).addClass('activo')

			var categoria_activa = $("#filter_categoria").attr('data-active-cate')
			var modelo_activo = $("#filter_model").attr('data-active-model')

			actualizaProductos(categoria_activa, modelo_activo)
		}

		function actualizaProductos(categoria_activa, modelo_activo) {
			var data_json = {
				"accion":"actualizaProductos",
				"datos":{
					"categoria_activa": categoria_activa,
					"modelo_activo": modelo_activo
				}
			}
			ajaxSetup();
			$.ajax({
				data:  data_json,
				url:   '{{ route("path_ajax_tienda_web") }}',
				type:  'post',
				datatype:'html',
				beforeSend: function () {
					$("#list-products").html('<div class="col-md-12 text-center"><div><i class="fa fa-spinner fa-spin fa-3x fa-fw"></i></div></div>');
				},
				success:  function (result) {
					$("#list-products").html(result);
					hoverCard()
				},
				error: function(error){
					console.log(error);
				}
			});
		}
	</script>
@stop

