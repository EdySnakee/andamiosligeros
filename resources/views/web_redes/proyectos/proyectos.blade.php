@extends('layouts.web_redes')
@section('css')
    <title>Proyectos 🚧| Mallas anticaidas | Mallas perimetrales</title>
    <meta name="description" content="Mallas anticaidas y Mallas de seguridad para trabajos en altura, fabricamos y distribuimos a toda la republica mexicana. Llamenos 01 800 837 1544" />
    <meta name="keywords" content="construccion, malla de seguridad, norma oficial mexicana nom-009-stps-2011, nom-009-stps-2011, perimetrales, perimetral, proteccion, Mallas anticaidas, red, Mallas perimetrales" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    <meta property="og:title" content="Mallas anticaidas para la construccion | Mallas perimetrales" />
    <meta property="og:site_name" content="Mallas anticaidas - Mallas perimetrales" />
    <meta property="og:description" content="Mallas anticaidas y Mallas de seguridad para trabajos en altura y en la construccion, fabricamos y distribuimos a toda la republica mexicana. Llamenos 01 800 837 1544" />
    
    <link rel="canonical" href="https://mallasanticaidas.com/proyectos">
    <meta property="og:url" content="https://mallasanticaidas.com/proyectos" />
@stop
@section('content')
	@include('web_redes.proyectos.proyectos_contenido')
@stop

@section('js')
	<script>
	$( document ).ready(function() {
	    $(".proyectos-estados > li:nth-child(1) a").addClass("pr-menu-active");
	});
	$(document).on("click", "#select_estado", selectEstado);
	function selectEstado (e) {
		e.preventDefault();
		$(".select_estado").removeClass("pr-menu-active");
		$(this).addClass("pr-menu-active");
		var id_proyecto = $(this).attr("data-id-proyecto");
        cambiaURLproyecto(id_proyecto);
        var data_json = {
            "accion":"selectEstado",
            "datos":{
                "id_proyecto":id_proyecto
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_utilidades_landing") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
                $("#cont_proyectos").html('<div></div><div class="fa-3x text-center"><i class="fas fa-spinner fa-spin"></i></div>');
            },
            success:  function (result) {

            	$("#cont_proyectos").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
	}
    function cambiaURLproyecto(id_proyecto){
        var id_proyecto = id_proyecto;
        var data_json = {
            "accion":"cambiaURLproyecto",
            "datos":{
                "id_proyecto":id_proyecto
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_utilidades_landing") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#urlproyectos").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }
	</script>
@stop