@extends('layouts.web_buen_fin')

@section('css')
	<title>El Buen Fin 2023 en Andamios Ligeros | Venta de Andamios en México</title>
	<meta name="description" content="Conoce nuestras promociones vigentes para este Buen Fin 2023, Los andamios más chingones de méxico están aquí" />
	<meta name="keywords" content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
	<meta property="og:image" content="{{url('web/buen_fin/post-bf.png')}}" />

	<meta property="og:image:secure_url" content="{{url('web/buen_fin/post-bf.png')}}" />

	<meta property="og:title" content="El Buen Fin 2023 en Andamios Ligeros | Venta de Andamios en México" />
	<meta property="og:site_name" content="El Buen Fin 2023 en Andamios Ligeros | Venta de Andamios en México" />
	<meta property="og:description" content="Conoce nuestras promociones vigentes para este Buen Fin 2023, Los andamios más chingones de méxico están aquí" />
	
	<link rel="canonical" href="{{url('/promociones-buen-fin-2023')}}">
	<meta property="og:url" content="{{url('/promociones-buen-fin-2023')}}" />
    <style>
		.info-item-promo {
			position: relative;
			padding: 1em;
		}
		.img-item-promo{
			padding: 1em;
		}
	
		.cont-promo {
			border: 1px #cbcbcb solid;
			padding: 10px;
			border-radius: 10px;
		}
		.cont-promo-txt {
			height: 50vh;
		}
		
	.item-vencido {
		opacity: 0.5;
	}
	.eti{
		position: absolute;
		padding: 10px;
		border-radius: 10px;
		color: white;
		font-weight: bold;
		top: 15px;
		box-shadow: 0px 0px 5px #333;
		right: 30px;
	}
	.eti-vencida {
		background: #ca0303;
	}
	.eti-success {
		background: #03ae4a;
	}
	.desc-promo {
    margin-bottom: 2em;
}
.btn-cotizar-s,
.btn-vermas {
    border: 2px solid #0648d6;
    cursor: pointer
}
.cont-item-product {
    position: relative;
}
.cont-item-product p, .cont-item-product h2 {
    color: white;
}
		</style>
@stop

@section('content')
	     @include('web_andamios.buen_fin_2023.cont_buen_fin') 
	    {{-- @include('web_andamios.listado_promos.contenido_listado_promos') --}}

@stop
@section('js')
   {{--  @include('web_andamios.includes.scripts_funciones') --}}
	<script>
		
	</script>
@stop

