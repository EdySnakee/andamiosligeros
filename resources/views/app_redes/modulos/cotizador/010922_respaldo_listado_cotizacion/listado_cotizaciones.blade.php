@extends('layouts.app_redes')
@section('css')
@stop
@section('content')
    @include('app_redes.modulos.cotizador.contenido_listado_cotizaciones')
    
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
                getTablaCotizaciones(page);
            }
        }
    });

    $(document).ready(function() {
        $(document).on('click', '.pagination a', function (e) {
            getTablaCotizaciones($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });

    $(document).on("change","#change-page-size", function(){
        //numero de datos
        getTablaCotizaciones(1);
    });

    $(document).on("keyup","#filtrar_busqueda_venta",function(e){
        //busqueda por venta
        getTablaCotizaciones(1);
    }); 

    $(document).on("keyup","#filtrar_busqueda",function(e){
        //busqueda por nombre de cliente
        getTablaCotizaciones(1); 
    });
    $(document).on("change","#filtrar_busqueda_fecha",function(e){
        // busqueda por fecha
        getTablaCotizaciones(1);
    });

    $(document).on("change","#giro_empresa",function(e){
        // busqueda por giro empresarial
        getTablaCotizaciones(1);
    });

	$(document).on("click", "#confirm_desactiva_cliente", openConfirmDelete);
	$(document).on("click", "#confirm_activa_cliente", openConfirmActiva);
    $(document).on("click", "#confirm_elimina_cliente", openConfirmElimina);
    $(document).on("click", "#genera_qr", openGeneraQR);
	$(document).on("click", "#open_confirm_venta", OpenConfirmVenta);


	function getTablaCotizaciones(page){
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
        var filtro_status_ventas = $('#change-satus-vtas').val();
        var filtrar_busqueda = $('#filtrar_busqueda').val();
        var filtrar_busqueda_venta = $('#filtrar_busqueda_venta').val();
        var filtrar_busqueda_fecha = $('#filtrar_busqueda_fecha').val();
        var filtrar_giro_empresa = $('#giro_empresa').val();
        var data_json = {
            "accion":"getTablaCotizaciones",
            "page":page,
            "datos":{
                "max_row":max_row,
                "filtro_status_ventas":filtro_status_ventas,
                "filtrar_busqueda":filtrar_busqueda,
                "filtrar_busqueda_venta": filtrar_busqueda_venta,
                "filtrar_busqueda_fecha": filtrar_busqueda_fecha,
                "filtrar_giro_empresa": filtrar_giro_empresa,
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                $("#tabla_cotizaciones").html(result);
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function OpenConfirmVenta (e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion":"openConfirmInfo",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                      title: "¿Estas seguro?",
                      text: "Se realizará la venta de la cotización: "+cod_cotizacion,
                      icon: "info",
                      buttons: true,
                      successMode: true,
                      buttons: ["Cancelar", "Si, Vender ahora"],
                    })
                    .then((willVende) => {
                      if (willVende) {
                            confirmVende(id_coti);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function confirmVende (id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion":"confirmVende",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se generó la venta correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

	function openConfirmDelete (e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion":"openConfirmInfo",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	 console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                      title: "¿Estas seguro?",
                      text: "Si confirma se desactivará la cotización para el cliente: "+cod_cotizacion,
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                      buttons: ["Cancelar", "Si, Desactivar ahora"],
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            confirmDesactiva(id_coti);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function openGeneraQR (e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion":"openConfirmInfo",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                 console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                      title: "Se generará código QR de "+cod_cotizacion,
                      text: "Podrá verlo al descargar la cotización como PDF",
                      icon: "info",
                      buttons: true,
                      dangerMode: false,
                      buttons: ["Cancelar", "Si, Generar QR ahora"],
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            generaQR(id_coti);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function generaQR (id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion":"generaQR",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha generado el QR correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function confirmDesactiva (id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion":"confirmDesactiva",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha desactivado correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function openConfirmActiva (e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion":"openConfirmInfo",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	 console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                      title: "¿Estas seguro?",
                      text: "Si confirma se avtivará la cotización para el cliente: "+cod_cotizacion,
                      icon: "warning",
                      buttons: true,
                      dangerMode: false,
                      buttons: ["Cancelar", "Si, Activar ahora"],
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            confirmActiva(id_coti);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function confirmActiva (id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion":"confirmActiva",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha Activado correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function openConfirmElimina (e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion":"openConfirmInfo",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
            	 console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                      title: "¿Estas seguro?",
                      text: "Si confirma se ELIMINARÁ permantentemente la cotización: "+cod_cotizacion,
                      icon: "warning",
                      buttons: true,
                      dangerMode: true,
                      buttons: ["Cancelar", "Si, ELIMINAR ahora"],
                    })
                    .then((willDelete) => {
                      if (willDelete) {
                            confirmElimina(id_coti);
                      } else {
                        
                      }
                    });
            },
            error: function(error){
                console.log(error);
            }
        });
    }

    function confirmElimina (id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion":"confirmElimina",
            "datos":{
                "id_coti":id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_cotizador") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
            },
            success:  function (result) {
                console.log(result);
                swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
                getTablaCotizaciones();
            },
            error: function(error){
                console.log(error);
            }
        });
    }

</script>
@stop