@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.proyectos.contenido_proyectos')
@stop

@section('js')

<script>
	$(document).on("click", "#confirm_delate", openConfirmDelete);

	function openConfirmDelete (e) {
		e.preventDefault();
        var id_proyecto = $(this).attr("data-id-proyecto");
        var data_json = {
            "accion":"openConfirmDelete",
            "datos":{
                "id_proyecto":id_proyecto
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_proyectos_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	var id_proyecto = result.id_proyecto;
            	var nombre_proyecto = result.nombre_proyecto;
            	swal({
					  title: "¿Estas seguro?",
					  text: "Si confirma perdera los datos del estado: "+nombre_proyecto,
					  icon: "warning",
					  buttons: true,
					  dangerMode: true,
					  buttons: ["Cancelar", "Si, Borrar ahora"],
					})
					.then((willDelete) => {
					  if (willDelete) {
						    confirmDelete(id_proyecto);
					  } else {
					    
					  }
					});
            },
            error: function(error){
                console.log(error);
            }
        });
	}

	function actualizaProyectos() {
		var data_json = {
            "accion":"actualizaProyectos",
            "datos":{
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_proyectos_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	//console.log(result);
            	$("#items-proyectos").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });

	}

	function confirmDelete (proyecto) {
		var id_proyecto = proyecto;
		var data_json = {
            "accion":"confirmDelete",
            "datos":{
                "id_proyecto":id_proyecto
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_proyectos_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	console.log(result);
            	swal("Éxito!", "Se ha borrado correctamente!", "success");
            	actualizaProyectos();
            },
            error: function(error){
                console.log(error);
            }
        });
	}
</script>

@stop
