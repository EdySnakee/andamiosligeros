@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.proyectos.edit_proyecto.contenido_edit_proyectos')
@stop

@section('js')
<script src="{{url('script/dist/bootstrap-tagsinput.min.js')}}"></script>

<script>
	
	$(document).on("click", "#editar_proyecto", editaProyecto);
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

	function editaProyecto() {
		var id_proyecto = $(this).attr("data-id-proyecto");
		var nombre_proyecto = $('#nombre_proyecto').val();
		var estado = $('#estado').val();
		var palabras_clave = $("#palabras_clave").val();
		var descripcion = $("#descripcion_proyectos").val();
		
		/*SUBIR IMAGEN*/
		var archivos = document.getElementById("subida_imagen");
        var archivo = archivos.files;
        var archivos = new FormData();
        for(i=0; i<archivo.length; i++){
            archivos.append('archivo'+i,archivo[i]);
        }

		archivos.append('accion',"editaProyecto");
        archivos.append('datos[id_proyecto]', id_proyecto);
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
				  title: "Editando Proyecto...",
				  text: "Espere mientras termina el proeceso",
				  buttons: false
				});
	        },
	        success:  function (result) {
	        	if (result == 1) {
	        		swal({
						  title: "Felicidades",
						  text: "Se ha editado el proyecto correctamente",
						  icon: "success",
						  buttons: true,
						  buttons: ["Ver proyectos", "Agregar Clientes"],
						})
						.then((willDelete) => {
						  if (willDelete) {
						  	location.reload();
						  } else {
						    window.location.href = "{{url('sb-admin/proyectos')}}";
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

</script>
@stop