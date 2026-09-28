@extends('layouts.app_redes')
@section('css')
@stop

@section('content')
    @include('app_redes.modulos.blog.contenido_blog')
@stop

@section('js')
<script>
    $(document).on("click", "#confirm_delete_cliente", openConfirmDelete);

    function openConfirmDelete (e) {
        e.preventDefault();
        var id_cliente = $(this).attr("data-id-cliente");
        var data_json = {
            "accion":"openConfirmDelete",
            "datos":{
                "id_cliente":id_cliente
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientes_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                var id_cliente = result.id_cliente;
                var nombre_cliente = result.nombre_cliente;
                swal({
                      title: "¿Estas seguro?",
                      text: "Si confirma perdera los datos del proyecto: "+nombre_cliente,
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                      buttons: ["Cancelar", "Si, Borrar ahora"],
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            confirmDelete(id_cliente);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function confirmDelete (cliente) {
        var id_cliente = cliente;
        var data_json = {
            "accion":"confirmDelete",
            "datos":{
                "id_cliente":id_cliente
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientes_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha borrado correctamente!", "success");
                actualizaClientes();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function actualizaClientes() {
        var data_json = {
            "accion":"actualizaClientes",
            "datos":{
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_clientes_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                //console.log(result);
                $("#tabla_clientes").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });

    }

</script>
@stop