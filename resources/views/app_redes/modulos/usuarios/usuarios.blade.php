@extends('layouts.app_redes')
@section('css')
@stop
@section('content')
    @include('app_redes.modulos.usuarios.contenido_usuarios')
@stop

@section('js')
<script>
    /*trabjando con paginado*/
    $(window).on('hashchange', function() {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getTablaUsuarios(page);
            }
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            getTablaUsuarios($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });

	function getTablaUsuarios(page){
        if(page == undefined){
            var page = 0;
            if($('ul.pagination').is(":visible")){
                if ($('ul.pagination li').hasClass("active") == true) {
                    page = $('ul.pagination .active').text();
                }else{
                    page = 1;
                }

            }else{
                page = 1;
            }
        }else{

        }
        var max_row = $('#change-page-size').val();
        
        var data_json = {
            "accion":"getTablaUsuarios",
            "page":page,
            "datos":{
                "max_row":max_row,
                
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_usuarios_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#tabla_usuarios").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    /*FUNCIONES USUARIOS*/

    $(document).on("click", "#open_edit_usr", openEditUser);
    $(document).on("click", "#edit_usuario", editUser);
    $(document).on("click", "#confirm_desactiva_usuario", openConfirmDesactiva);
    $(document).on("click", "#confirm_activa_cliente", openConfirmActiva);
    $(document).on("click", "#confirm_delete_usuario", openConfirmDelete);

    function openConfirmDelete () {
        var id_usuario = $(this).attr("data-id-usr");
        var name_usuario = $(this).attr("data-name-usr");

        swal({
          title: "¿Eliminar usuario?",
          text: "El usuario "+name_usuario+" se eliminará permanentemente",
          icon: "error",
          buttons: true,
          dangerMode: true,
          buttons: ["Cancelar", "Si, ELIMINAR ahora"],
        })
        .then((Activa) => {
          if (Activa) {
                ConfirmElimina(id_usuario);
          } else {
            
          }
        });
    }

    function ConfirmElimina (id_usuario) {
        var num_usuario = id_usuario;
        var data_json = {
            "accion":"ConfirmElimina",
            "datos":{
                num_usuario : num_usuario
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_usuarios_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                swal("Correcto!", "Usuario ELIMINADO Permanentemente", "success");
                getTablaUsuarios();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function openEditUser (e) {
        e.preventDefault();
        var accion_usr = "Editar"
        var id_usurio = $(this).attr("data-id-usr");
        var data_json = {
            "accion":"openModalUser",
            "datos":{
                accion_usr : accion_usr,
                id_usurio : id_usurio
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_usuarios_path") }}',
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

    function editUser () {
        var id_usuario = $(this).attr("data-id-usuario");
        var nombre_usuario = $("#nombre_usuario").val();
        var email_usr = $ ("#email_usr").val();
        var tipo_usuario = $ ("#tipo_usuario").val();
        var password = $ ("#pass_usr").val();
        var data_json = {
            "accion" : "editUser",
            "datos" : {
                id_usuario : id_usuario,
                nombre_usuario : nombre_usuario,
                email_usr : email_usr,
                tipo_usuario : tipo_usuario,
                password : password
            }
        };
        ajaxSetup();
            $.ajax({
                data:  data_json,
                url:   '{{ route("ajax_usuarios_path") }}',
                type:  'post',
                datatype:'html',
                beforeSend: function () {
                },
                success:  function (result) {
                    $("#modal_app_redes").modal('hide');
                    swal("Excelente!", "Usuario editado", "success");
                    getTablaUsuarios(1);
                },
                error: function(error){
                    $("#resultadodiv").html(result);
                }
            });
    }

    function openConfirmDesactiva () {
        var id_usuario = $(this).attr("data-id-usr");
        swal({
          title: "Se desactivará el usuario",
          text: "Si confirma el usuario se desactivará",
          icon: "warning",
          buttons: true,
          dangerMode: false,
          buttons: ["Cancelar", "Si, Desactivar ahora"],
        })
        .then((Desactiva) => {
          if (Desactiva) {
                ConfirmDesactiva(id_usuario);
          } else {
            
          }
        });
    }

    function openConfirmActiva () {
        var id_usuario = $(this).attr("data-id-usr");
        swal({
          title: "Se activará el usuario",
          text: "Si confirma el usuario se activará",
          icon: "info",
          buttons: true,
          dangerMode: false,
          buttons: ["Cancelar", "Si, Activar ahora"],
        })
        .then((Activa) => {
          if (Activa) {
                ConfirmActiva(id_usuario);
          } else {
            
          }
        });
    }

    function ConfirmDesactiva (id_usuario) {
        var num_usuario = id_usuario;
        var data_json = {
            "accion":"ConfirmDesactiva",
            "datos":{
                num_usuario : num_usuario
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_usuarios_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                swal("Excelente!", "Usuario desactivado", "success");
                getTablaUsuarios(1);
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    function ConfirmActiva (id_usuario) {
        var num_usuario = id_usuario;
        var data_json = {
            "accion":"ConfirmActiva",
            "datos":{
                num_usuario : num_usuario
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("ajax_usuarios_path") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                swal("Excelente!", "Usuario activado", "success");
                getTablaUsuarios(1);
            },
            error: function(error){
                console.log(error);
            }
        });
    }
    
</script>
@stop