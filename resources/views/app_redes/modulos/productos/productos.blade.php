@extends('layouts.app_redes')
@section('css')
@stop
@section('content')
    @include('app_redes.modulos.productos.contenido_listado_productos')
@stop

@section('js')
<script>
	$( document ).ready(function() {
	    $("#tablaProductos").dataTable();
	});
	$(document).on("click", "#confirm_delete_producto", openConfirmElimina);

	function openConfirmElimina(e) {
		var id_product = $(this).attr("data-id-producto")
		swal({
			title: "¿Estas seguro?",
			text: "Si confirma se ELIMINARÁ permantentemente el producto: ",
			icon: "warning",
			buttons: true,
			dangerMode: true,
			buttons: ["Cancelar", "Si, ELIMINAR ahora"],
		})
		.then((willDelete) => {
			if (willDelete) {
				confirmElimina(id_product);
			} else {
			
			}
		});
	}

	function confirmElimina (id_product) {
        var data_json = {
            "accion":"confirmElimina",
            "datos":{
                "id_product":id_product
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_productos_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
                location.reload();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
</script>
@stop