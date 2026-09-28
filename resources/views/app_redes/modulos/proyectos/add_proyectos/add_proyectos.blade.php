@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.proyectos.add_proyectos.contenido_add_proyectos')
@stop

@section('js')
<script src="{{url('script/dist/bootstrap-tagsinput.min.js')}}"></script>

<script>
	$(document).ready(function(){
		$('.dropify').dropify({
            messages: {
                default: 'Arrastra y suelta una imagen o da click',
                replace: 'Arrastra y suelta una imagen o da click para reemplazar imagen',
                remove:  'Eliminar',
                error:   'El archivo no cuenta con el formato solicitado'
            }
        });
	});
	$(document).on("change", "#estado", getMunicipios);
	$(document).on("click", "#guarda_proyecto", guardaProyecto);
	$(document).on("keyup", "#nombre_proyecto", escribeURL);

	function escribeURL () {
		var nombre_proyecto = $('#nombre_proyecto').val();
		var data_json = {
	        "accion":"escribeURL",
	        "datos":{
	            'nombre_proyecto' : nombre_proyecto
	        }
	    }
	    ajaxSetup();
	    $.ajax({
	        data:  data_json,
	        url:   '{{ route("ajax_proyectos_path") }}',
	        type:  'post',
	        dataType:'html',
	        beforeSend: function () {
	        },
	        success:  function (result) {
	            $("#pinta_url").html(result);
	        },
	        error: function(error){
	            console.log(error);
	        }
	    });
	}

	function guardaProyecto() {
		var nombre_proyecto = $('#nombre_proyecto').val();
		var estado = $('#valor-estado').val();
		var palabras_clave = $("#palabras_clave").val();
		var descripcion = $("#descripcion_proyectos").val();
		
		/*SUBIR IMAGEN*/
		var archivos = document.getElementById("subida_imagen");
        var archivo = archivos.files;
        var archivos = new FormData();
        for(i=0; i<archivo.length; i++){
            archivos.append('archivo'+i,archivo[i]);
        }

		archivos.append('accion',"guardaProyecto");
        archivos.append('datos[nombre_proyecto]', nombre_proyecto);
        archivos.append('datos[estado]', estado);
        archivos.append('datos[palabras_clave]', palabras_clave);
        archivos.append('datos[descripcion]', descripcion);

	    ajaxSetup();
	    $.ajax({
	        url:   '{{ route("ajax_proyectos_path") }}',
	        type:'POST',
            contentType:false,
            data:archivos,
            processData:false,
            cache:false,
	        beforeSend: function () {
	        	swal({
				  title: "Creando Proyecto...",
				  text: "Espere mientras termina el proeceso",
				  buttons: false
				});
	        },
	        success:  function (result) {
	        	if (result == 1) {
	        		swal({
						  title: "Felicidades",
						  text: "Se ha guardado el proyecto correctamente",
						  icon: "success",
						  buttons: true,
						  buttons: ["Ver estados", "Agregar Estados"],
						})
						.then((willDelete) => {
						  if (willDelete) {
						  	location.reload();
						  } else {
						    window.location.href = "{{url('sb-admin/estados')}}";
						  }
						});
	        	};
	        	if (result == 2) {
	        		swal("Ups!", "Llena los campos requeridos!", "error");
	        	};
	            
	        },
	        error: function(error){
	            console.log(error);
	        }
	    });
	}

	function getMunicipios(){
	    var id_estado = $(this).val();

	    var data_json = {
	        "accion":"getMunicipios",
	        "datos":{
	            'id_estado':id_estado,
	        }
	    }
	    ajaxSetup();
	    $.ajax({
	        data:  data_json,
	        url:   '{{ route("ajax_utilidades_path") }}',
	        type:  'post',
	        dataType:'html',
	        beforeSend: function () {
	        },
	        success:  function (result) {
	        	//console.log(result);
	            $("#resultado_proyecto").html(result);
	        },
	        error: function(error){
	            console.log(error);
	        }
	    });
	}
</script>
@stop