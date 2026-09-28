@extends('layouts.app_redes')
@section('css')
@stop

@section('content')
    @include('app_redes.modulos.clientes_web.contenido_clientes_web')
@stop
	@include('app_redes.modulos.modales.modales')
@section('js')
	@include('app_redes.includes.script_clientes')
	<script>
	$( document ).ready(function() {
	    muestraTabla();
	});
	function muestraTabla () {
		var data_json = {
            "accion":"muestraTablaClientes"
        }
        ajaxSetup();
		var table = $('#dt_cliente').DataTable({
			"ajax":{
				"method":"POST",
				"data":  data_json,
				"url":"{{ route('ajax_clientesweb_path') }}"
			},
			"order": [[ 0, "desc" ]],
			"columns":[
				{"data":"idcl"},
				{"data":"nombrecl"},
				{"data":"rfccl"},
				{"data":"estado"},
				{"data":"ciudad"},
				{"data":"telefonocl"},
				{"data":"celularcl"},
				{"data":"emailcl"},
				{"data":'botonera'}
			]
		});

	}

	$(document).on("click","#open_edit", enviaIdEdit);
	$(document).on("click","#confirm_delete_cliente", enviaIdDel);
	
	function enviaIdEdit () {
		var id_cliente = $(this).attr('id-cliente');
		openEdit(id_cliente);
	}
	function enviaIdDel () {
		var id_cliente = $(this).attr('id-cliente');
		swal({
			title: "¿Estas seguro?",
			text: "Si confirma se eliminará permanentemente el cliente",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: ["Cancelar", "Si, ELIMINAR ahora"],
        })
        .then((willDelete) => {
			if (willDelete) {
			    confirmDesactivaClient(id_cliente);
			} else {

			}
        });
	}
	function confirmDesactivaClient (id_cliente) {
		var data_json = {
            "accion":"confirmDesactivaClient",
            "datos":{
                "id_cliente":id_cliente
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
                $('#dt_cliente').DataTable().destroy();
                muestraTabla();
            },
            error: function(error){
                console.log(error);
            }
        });
	}

	function divideLugares() {
		var data_json = {
            "accion":"dividirLugares",
            "datos":{
            }
        }
		ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientesweb_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
				console.log(result);
            },
            error: function(error){
                console.log(error);
            }
        });
	}
	</script>
@stop