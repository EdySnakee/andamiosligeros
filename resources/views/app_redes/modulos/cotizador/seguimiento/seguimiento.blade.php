@extends('layouts.app_redes')
@section('css')
    <style>
        div#item_bitacora {
            position: relative;
        }
    </style>
@stop
@section('content')
    @include('app_redes.modulos.cotizador.seguimiento.contenido_seguimiento')
@stop
@section('js')
<script>
    $(document).on("click", "#openmodal_seguimiento", openIniciaProyecto);
    $(document).on("click", "#openmodal_bitacora", openModalBitacora);
    $(document).on("click", "#open_editar_bitacora", openModalEditBitacora);
    $(document).on("click", "#add_proyecto", postSeguimientoProyecto);
    $(document).on("click", "#add_bitacora", postBitacora);
	$(document).on("click", "#edit_bitacora", editBitacora);
    $(document).on("click", "#confirm_delate_bitacora", confirmEliminaBitacora);

    function confirmEliminaBitacora (e) {
        e.preventDefault();
        var id_bitacora = $(this).attr('data-id-bitacora');
        swal({
          title: "Eliminar Bitacora",
          text: "Se eliminará permanentemente la bitacora",
          icon: "warning",
          buttons: true,
          dangerMode: true,
          buttons: ["Cancelar", "Si, eliminar ahora"],
        })
        .then((willAcept) => {
          if (willAcept) {
            eliminaBitacora(id_bitacora);
          } else {
            
          }
        });
    }

    function eliminaBitacora(id_bitacora) {
        var id_bitacora = id_bitacora;
        var data_json = {
            "accion":"eliminaBitacora",
            "datos":{
                'id_bitacora' : id_bitacora
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            dataType:'html',
            beforeSend: function () {
                swal({
                  title: "Eliminando bitacora...",
                  text: "Espere mientras termina el proceso",
                  buttons: false,
                  closeOnClickOutside: false
                });
            },
            success:  function (result) {
                swal("Excelente!", "Se ha eliminado la bitacora", "success");
                actualizaContBitacora ()
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    
	function openIniciaProyecto (e) {
        e.preventDefault();
        var accion_usr = "Iniciar"
        var id_cotizacion = $(this).attr("data-id-coti");
        var nom_cotizacion = $("#nom_cotizacion").val();
        var data_json = {
            "accion":"openModalProyecto",
            "datos":{
                accion_usr : accion_usr,
                id_cotizacion : id_cotizacion,
                nom_cotizacion : nom_cotizacion
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#modal_app_redes").html(result);
                $('#modal_app_redes').modal({backdrop: 'static',keyboard:false})
                //asignaTarea();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function openModalBitacora (e) {
        e.preventDefault();
        var id_proyecto = $(this).attr("data-id-proyecto");
        var id_cotizacion = $(this).attr("data-id-coti");

        var data_json = {
            "accion":"openModalBitacora",
            "datos":{
                id_proyecto : id_proyecto,
                id_cotizacion: id_cotizacion
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#modal_app_redes").html(result);
                $('#modal_app_redes').modal({backdrop: 'static',keyboard:false})
                iniciaDropify ();
                //asignaTarea();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function openModalEditBitacora (e) {
        e.preventDefault();
        var id_bitacora = $(this).attr("data-id-bitacora");
        var id_proyecto = $("#id_proyecto").val();
        var id_seguimiento = $(this).attr("data-id-seguimiento");

        var data_json = {
            "accion":"openModalEditBitacora",
            "datos":{
                id_bitacora : id_bitacora,
                id_proyecto : id_proyecto,
                id_seguimiento: id_seguimiento
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#modal_app_redes").html(result.html);
                $('#modal_app_redes').modal({backdrop: 'static',keyboard:false})
                var nameImage = "{{url('storage/bitacoras')}}"+result.archivo;
                $("#archivo_proyecto").attr("data-default-file", nameImage);
                $('.dropify').dropify({
                    messages: {
                        default: 'Arrastra y suelta una imagen o da click',
                        replace: 'Arrastra y suelta una imagen o da click para reemplazar imagen',
                        remove:  'Eliminar',
                        error:   'El archivo no cuenta con el formato solicitado'
                    }
                });
                //asignaTarea();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function postSeguimientoProyecto (e) {
        e.preventDefault();
        var id_cotizacion = $(this).attr("data-id-coti");
        var titulo_trabajo = $("#titulo_trabajo").val();
        var personal_labora = $("#personal_labora").val();
        var fecha_elaboracion = $("#fecha_elaboracion").val();
        var comentario = $("#comentario").val();

        var data_json = {
            "accion":"postSeguimientoProyecto",
            "datos":{
                id_cotizacion : id_cotizacion,
                titulo_trabajo : titulo_trabajo,
                personal_labora : personal_labora,
                fecha_elaboracion : fecha_elaboracion,
                comentario : comentario
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                if (result == 1) {
                    swal ( "Campos vacios" , "Llena los campos requeridos" ,  "error" );
                    return false;
                }else{
                    $("#modal_app_redes").modal('hide');
                    swal("Excelente!", "Se ha iniciado el proyecto", "success");
                    $("#seguimiento_trabajo").html(result);
                }
                //asignaTarea();
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function postBitacora (e) {
        var id_cotizacion = $(this).attr("data-id-coti");
        var id_proyecto = $(this).attr("data-id-proyect");
        var descrip_archivo = $("#descrip_archivo").val();
        /*SUBIR IMAGEN*/
        var archivos = document.getElementById("archivo_proyecto");
        var archivo = archivos.files;
        var archivos = new FormData();
        for(i=0; i<archivo.length; i++){
            archivos.append('archivo'+i,archivo[i]);
        }

        archivos.append('accion',"postBitacora");
        archivos.append('datos[id_proyecto]', id_proyecto);
        archivos.append('datos[id_cotizacion]', id_cotizacion);
        archivos.append('datos[descrip_archivo]', descrip_archivo);

        ajaxSetup();

        $.ajax({
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:'POST',
            contentType:false,
            data:archivos,
            processData:false,
            cache:false,
            beforeSend: function () {
                swal({
                  title: "Subiendo bitacora...",
                  text: "Espere mientras termina el proeceso",
                  buttons: false
                });
            },
            success:  function (result) {
                if (result == 1) {
                    swal ( "Selecciona al menos una imagen" , "Llena los campos requeridos o selecciona un archivo válido" ,  "error" );
                    return false;
                }else{
                    $("#modal_app_redes").modal('hide');
                    swal("Excelente!", "Se ha agregado a la bitacora", "success");
                    $("#seguimiento_trabajo").html(result);
                }

            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function editBitacora () {
        var id_cotizacion = $('#id_cotizacion').val();
        var id_bitacora = $(this).attr("data-id-bitacora");
        var id_proyecto = $(this).attr("data-id-proyect");
        var id_seguimiento = $(this).attr("data-id-seguimiento");
        var descrip_archivo = $("#descrip_archivo").val();
        var archivos = document.getElementById("archivo_proyecto");
        var archivo = archivos.files;
        var archivos = new FormData();
        for(i=0; i<archivo.length; i++){
            archivos.append('archivo'+i,archivo[i]);
        }

        archivos.append('accion',"editBitacora");
        archivos.append('datos[id_bitacora]', id_bitacora);
        archivos.append('datos[id_proyecto]', id_proyecto);
        archivos.append('datos[id_seguimiento]', id_seguimiento);
        archivos.append('datos[descrip_archivo]', descrip_archivo);
        archivos.append('datos[id_cotizacion]', id_cotizacion);

        ajaxSetup();

        $.ajax({
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:'POST',
            contentType:false,
            data:archivos,
            processData:false,
            cache:false,
            beforeSend: function () {
                swal({
                  title: "Editando bitacora...",
                  text: "Espere mientras termina el proceso",
                  buttons: false
                });
            },
            success:  function (result) {
                if (result == 1) {
                    swal ( "Selecciona al menos una imagen" , "Llena los campos requeridos o selecciona un archivo válido" ,  "error" );
                    return false;
                }else{
                    $("#modal_app_redes").modal('hide');
                    swal("Excelente!", "Se ha editado a la bitacora", "success");
                    actualizaContBitacora();
                }

            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function iniciaDropify () {
        $('.dropify').dropify({
            messages: {
                default: 'Arrastra y suelta una imagen o da click',
                replace: 'Arrastra y suelta una imagen o da click para reemplazar imagen',
                remove:  'Eliminar',
                error:   'El archivo no cuenta con el formato solicitado'
            }
        });
    }
    function actualizaContBitacora () {
        var id_cotizacion = $("#id_cotizacion").val()
        var data_json = {
            "accion":"actualizaContBitacora",
            "datos":{
                'id_cotizacion' : id_cotizacion
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_seguimiento_path") }}',
            type:  'post',
            dataType:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#seguimiento_trabajo").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }
</script>
@stop