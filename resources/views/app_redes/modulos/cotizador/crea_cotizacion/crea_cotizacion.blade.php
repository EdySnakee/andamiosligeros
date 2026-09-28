<?php
session_destroy();
?>
@extends('layouts.app_redes')
@section('css')
    <link href="{{ url('script/css/components.css') }}" rel="stylesheet">
    {{-- QUILL --}}
    <link href="https://cdn.quilljs.com/1.3.6/quill.snow.css" rel="stylesheet">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/styles/default.min.css">
    <style>
        div#search-results {
            position: absolute;
            width: 94%;
            background: white;
            z-index: 1;
            padding: 1em;
            height: auto;
            max-height: 200px;
            overflow-y: scroll;
            border: 1px #9b9b9b solid;
            border-radius: 10px;
            display: none;
        }

        div#search-results p:hover {
            background: #ffbb00;
            color: white;
        }

        div#search-results p {
            cursor: pointer;
            padding: 0.5em;
            margin: 0;
        }

        #tabla_productos td,
        #tabla_productos th {
            padding: 0.3rem;
        }

        #tabla_productos th {
            font-size: 0.8rem;
            background: #2a2a2a;
            color: white;
        }

        #tabla_productos td {
            font-size: 0.9rem;
        }

        ul.opc-desc li {
            display: inline-block;
            margin-right: 1em;
        }

        .mb-10 {
            margin-bottom: 15px;
        }

        ul.opc-desc {
            padding: 0;
        }
    </style>
@stop
@section('content')
    @include('app_redes.modulos.cotizador.crea_cotizacion.contenido_crea_cotizacion')
@stop
@include('app_redes.modulos.modales.modales')
@section('js')
    @include('app_redes.includes.script_clientes')
    <script src="{{ url('select2/dist/js/select2.js') }}"></script>
    {{-- QUILL --}}
    <script src="//cdnjs.cloudflare.com/ajax/libs/highlight.js/10.5.0/highlight.min.js"></script>
    <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>

    <script>
        var quill = null;

        $(document).ready(function() {
            $('.js-example-basic-single').select2();
            buscadorCliente();
            quillCondicionesPlano();
        });

        $(document).on("click", "#edit_cotizacion", confirmEditCotizacion);
        $(document).on("click", "#add_concepto", agregarConcepto);
        $(document).on("click", "#add_descuento", addDescuento);
        $(document).on("click", ".del_descuento", delDescuento);
        $(document).on("click", ".del_envio", delEnvio);
        $(document).on("click", ".eliminar_servicio", eliminarConcepto);
        $(document).on("click", "#open_confirm_post_cotizacion", confirmCotizacion);
        $(document).on("change", "#activa_iva", agregaImpuesto);
        $(document).on("change", "#activa_envio", validaEnvio);
        $(document).on("change", ".t_descuento", tipoDescuento);
        $(document).on("click", "#add_envio", addEnvio);

        // Condiciones
        $(document).on("click", "#open_edit_condiciones", agregarCondicion);
        $(document).on("click", "#save_condiciones", saveCondicion);

        function addEnvio(e) {
            e.preventDefault();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var descuento_aplicado = $("#descuento").val();
            var activa_iva = $("#activa_iva").is(":checked");
            var envio = $("#precio_envio").val();
            var data_json = {
                "accion": "addEnvio",
                "datos": {
                    'descuento_aplicado': descuento_aplicado,
                    't_descuento': t_descuento,
                    'activa_iva': activa_iva,
                    'envio': envio
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                },
                error: function(error) {}
            });
        }

        function delEnvio(e) {
            e.preventDefault();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var descuento_aplicado = $("#descuento").val();
            var envio = 0;
            var activa_iva = $("#activa_iva").is(":checked");
            var data_json = {
                "accion": "delEnvio",
                "datos": {
                    't_descuento': t_descuento,
                    'descuento_aplicado': descuento_aplicado,
                    'activa_iva': activa_iva,
                    'envio': envio
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                    $("#precio_envio").val(false);
                },
                error: function(error) {}
            });
        }

        function buscadorCliente() {
            $('#search_cliente').select2({
                ajax: {
                    url: '{{ route('buscar_cliente') }}',
                    type: 'get',
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        //console.log(params.term);
                        return {
                            searchItem: params.term,
                            page: params.page
                        };
                    },
                    processResults: function(data, params) {
                        //console.log(data);
                        params.page = params.page || 1;
                        return {
                            results: data.data,
                            pagination: {
                                more: data.last_page != params.page
                            }
                        };

                    },
                    cache: true
                },
                placeholder: "Selecciona un cliente",
                allowClear: true,
                templateResult: templateResult,
                templateSelection: templateSelection,
            })
        }

        function templateResult(data) {

            //console.log(data)
            if (data.loading) {
                return data.nombrecl
            }
            return data.nombrecl
        }

        function templateSelection(data) {
            if (data.id === '') { // adjust for custom placeholder values
                return 'Selecciona un cliente para iniciar';
            }
            return data.nombrecl
        }

        $("#search_cliente").change(function() {
            var cliente = $("#search_cliente").val();
            var accion = $("#accion").attr("data-accion");

            var data_json = {
                "accion": "seleccionaCliente",
                "datos": {
                    'cliente': cliente
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#tipo_producto").removeAttr("disabled")
                    $("#info_cliente").html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function tipoDescuento() {
            tipo_descuento = $(this).val();
            if (tipo_descuento == "Porcentual") {
                $("#simbolo_desc").html("%")
                $("#descuento").removeAttr("disabled")
                $("#add_descuento").removeAttr("disabled")
            }
            if (tipo_descuento == "Fijo") {
                $("#simbolo_desc").html("$")
                $("#descuento").removeAttr("disabled")
                $("#add_descuento").removeAttr("disabled")

            }
        }

        function agregaImpuesto() {
            var descuento_aplicado = $("#descuento").val();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var envio = $("#precio_envio").val();
            var activa_iva = $("#activa_iva").is(":checked");

            if ($(this).is(":checked")) {
                var data_json = {
                    "accion": "agregaImpuesto",
                    "datos": {
                        'descuento_aplicado': descuento_aplicado,
                        't_descuento': t_descuento,
                        'activa_iva': activa_iva,
                        'envio': envio
                    }
                }

            } else {
                var data_json = {
                    "accion": "eliminaImpuesto",
                    "datos": {
                        't_descuento': t_descuento,
                        'descuento_aplicado': descuento_aplicado,
                        'activa_iva': activa_iva,
                        'envio': envio
                    }
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                    //$("#result_detalle_pago").html("");
                    //$("#tipo-pago").val("sn");
                },
                error: function(error) {}
            });
        }

        function validaEnvio() {
            var descuento_aplicado = $("#descuento").val();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var activa_envio = $("#activa_envio").is(":checked");
            var activa_iva = $("#activa_iva").is(":checked");
            var data_json = {
                "accion": "validaEnvio",
                "datos": {
                    'descuento_aplicado': descuento_aplicado,
                    't_descuento': t_descuento,
                    'activa_iva': activa_iva,
                    'activa_envio': activa_envio
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                    //$("#result_detalle_pago").html("");
                    //$("#tipo-pago").val("sn");
                },
                error: function(error) {}
            });
        }

        function addDescuento(e) {
            e.preventDefault();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var descuento_aplicado = $("#descuento").val();
            var activa_iva = $("#activa_iva").is(":checked");
            var envio = $("#precio_envio").val();
            var data_json = {
                "accion": "addDescuento",
                "datos": {
                    'descuento_aplicado': descuento_aplicado,
                    't_descuento': t_descuento,
                    'activa_iva': activa_iva,
                    'envio': envio
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                },
                error: function(error) {}
            });
        }

        function delDescuento(params) {
            var descuento = 0;
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var envio = $("#precio_envio").val();
            var activa_iva = $("#activa_iva").is(":checked");
            var data_json = {
                "accion": "addDescuento",
                "datos": {
                    't_descuento': t_descuento,
                    'descuento': descuento,
                    'activa_iva': activa_iva,
                    'envio': envio
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                    $("#descuento").val(false);
                },
                error: function(error) {}
            });
        }

        $("#cliente").change(function() {
            var cliente = $("#cliente").val();
            var accion = $("#accion").attr("data-accion");

            var data_json = {
                "accion": "seleccionaCliente",
                "datos": {
                    'cliente': cliente
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#info_cliente").html(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function confirmCotizacion() {
            var id_sucursal = $('#suc_origen').val();
            var cliente = $("#search_cliente").val();
            if (cliente != null && id_sucursal != null) {
                swal({
                        title: "Confirma para guardar la cotizacion",
                        text: "Valida que todos los datos esten correctos",
                        icon: "warning",
                        buttons: true,
                        dangerMode: false,
                        buttons: ["Cancelar", "Si, Guardar ahora"],
                    })
                    .then((willDelete) => {
                        if (willDelete) {
                            postCotizacion();
                        } else {

                        }
                    });
            } else {
                swal({
                    title: "Error!",
                    text: "Por favor selecciona una SUCRUSAL y un CLIENTE",
                    icon: "error",
                    dangerMode: true,
                })
            };
        }

        function confirmEditCotizacion() {
            swal({
                    title: "Editar cotizacion",
                    text: "Seguro que deseas editar la cotización",
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                    buttons: ["Cancelar", "Si, Editar ahora"],
                })
                .then((willEdit) => {
                    if (willEdit) {
                        editCotizacion();
                    } else {

                    }
                });
        }

        function editCotizacion() {
            var id_cotizacion = $("#id_cotizacion").val();
            var porcentaje_descuento = $("#descuento").val();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val();
            var tipo_cotizacion = $('input:radio[name=tipo_cotizacion]:checked').val();
            var descuento_aplicado = $("#nuevo_descuento").attr("data-nuevo-descuento");
            var subtotal = $("#subtotal_global").attr("data-subtotal-global");
            var iva = $("#iva").val();
            var envio = $("#envio").attr("data-costo-envio");
            var total = $("#total").attr("data-total");
            var configuracion = $('#datos_condicion > .ql-editor').html();

            var nFilas = $(".fila-det-servicio").length;

            var detalle_coti = []

            for (var i = 0; i < nFilas; i++) {
                var suma = (i + 1);

                var cantidad = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(1)").html();
                var nombre_producto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(2)").html();
                var id_producto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(2)").attr(
                    "data-id-producto");
                var titulo_descripcion = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(3)").html();
                var precio_unit = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr(
                    "data-punit");
                var alto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr("data-alto");
                var largo = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr("data-largo");
                var total_ind = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(5)").attr(
                    "data-total-ind");
                var dimensiones = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(6)").attr(
                    "dimensiones");
                var tipo_cobro = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(6)").attr(
                    "data-tipo-cobro");

                detalle_coti.push({
                    cantidad: cantidad,
                    nombre_producto: nombre_producto,
                    id_producto: id_producto,
                    titulo_descripcion: titulo_descripcion,
                    precio_unit: precio_unit,
                    alto: alto,
                    largo: largo,
                    total_ind: total_ind,
                    dimensiones: dimensiones,
                    tipo_cobro: tipo_cobro
                });
            };

            //console.log(info_coti);
            //console.log(detalle_coti);

            var data_json = {
                "accion": "editCotizacion",
                "datos": {
                    'id_cotizacion': id_cotizacion,
                    't_descuento': t_descuento,
                    'tipo_cotizacion': tipo_cotizacion,
                    'porcentaje_descuento': porcentaje_descuento,
                    'descuento_aplicado': descuento_aplicado,
                    'subtotal': subtotal,
                    'iva': iva,
                    'envio': envio,
                    'total': total,
                    'detalle_coti': detalle_coti,
                    'configuracion': configuracion,
                }
            }
            //console.log(data_json);

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    swal({
                            title: "Felicidades",
                            text: "Se ha editado la cotizacion correctamente",
                            icon: "success",
                            buttons: true,
                            buttons: ["Seguir editando", "Ver cotizacion"],
                        })
                        .then((willDelete) => {
                            if (willDelete) {
                                window.open("{{ url('cotizaciones') }}" + "/" + result, '_blank');
                                location.reload();
                            } else {
                                location.reload();
                            }
                        });
                },
                error: function(error) {}
            });
        }

        function postCotizacion() {
            var giro_empresa = $("#tipo_cotizacion").val();
            var id_cliente = $("#search_cliente").val();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val();
            var tipo_cotizacion = $('input:radio[name=tipo_cotizacion]:checked').val();
            var subtotal_sin_descuento = $("#subtotal_sin_descuento").val()
            var porcentaje_descuento = $("#descuento").val();
            var descuento_aplicado = $("#nuevo_descuento").attr("data-nuevo-descuento");
            var envio = $("#envio").attr("data-costo-envio");
            var subtotal = $("#subtotal_global").attr("data-subtotal-global");
            var iva = $("#iva").val();
            var total = $("#total").attr("data-total");
            var fecha_formato = $("#fecha_formato").html();
            var configuracion = $('#datos_condicion > .ql-editor').html();
            var id_sucursal = $('#suc_origen').val();

            var nFilas = $(".fila-det-servicio").length;

            var detalle_coti = []

            for (var i = 0; i < nFilas; i++) {
                var suma = (i + 1);
                var cantidad = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(1)").html();
                var nombre_producto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(2)").html();
                var id_producto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(2)").attr(
                    "data-id-producto");
                var titulo_descripcion = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(3)").html();
                var precio_unit = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr(
                    "data-punit");
                var alto = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr("data-alto");
                var largo = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(4)").attr("data-largo");
                var total_ind = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(5)").attr(
                    "data-total-ind");
                var dimensiones = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(6)").attr(
                    "dimensiones");
                var tipo_cobro = $("#detalle_cotizacion > tr:nth-child(" + suma + ") > td:nth-child(6)").attr(
                    "data-tipo-cobro");

                detalle_coti.push({
                    cantidad: cantidad,
                    nombre_producto: nombre_producto,
                    id_producto: id_producto,
                    titulo_descripcion: titulo_descripcion,
                    precio_unit: precio_unit,
                    alto: alto,
                    largo: largo,
                    total_ind: total_ind,
                    dimensiones: dimensiones,
                    tipo_cobro: tipo_cobro,
                    clave_prod_serv: "51212505",
                    clave_unidad: "05",
                    unidad: "PIEZA"
                });
            };

            //console.log(info_coti);
            //console.log(detalle_coti);

            var data_json = {
                "accion": "postCotizacion",
                "datos": {
                    'giro_empresa': giro_empresa,
                    'id_cliente': id_cliente,
                    't_descuento': t_descuento,
                    'tipo_cotizacion': tipo_cotizacion,
                    'subtotal_sin_descuento': subtotal_sin_descuento,
                    'porcentaje_descuento': porcentaje_descuento,
                    'descuento_aplicado': descuento_aplicado,
                    'envio': envio,
                    'subtotal': subtotal,
                    'iva': iva,
                    'total': total,
                    'fecha_formato': fecha_formato,
                    'detalle_coti': detalle_coti,
                    'configuracion': configuracion,
                    'id_sucursal': id_sucursal,
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    swal("Se ha guardado la cotizacion correctamente", {
                            buttons: {
                                cancel: "Listado de cotizaciones!",
                                catch: {
                                    text: "Ver cotización",
                                    value: "catch",
                                },
                                defeat: {
                                    text: "Enviar cotización al " + result.num_cliente + "",
                                    value: "whats",
                                }
                            },
                        })
                        .then((value) => {
                            switch (value) {
                                case "whats":
                                    swal("Write something here:", {
                                            content: "input",
                                            attributes: {
                                                placeholder: 'Thank You',
                                            }
                                        })
                                        .then((valueW) => {
                                            swal(`You typed: ${valueW}`);
                                        });
                                    break;
                                case "catch":
                                    window.open("{{ url('cotizaciones') }}" + "/" + result.ruta_coti,
                                        '_blank');
                                    window.location.href = "{{ url('sb-admin/cotizaciones') }}";
                                    break;
                                default:
                                    window.location.href = "{{ url('sb-admin/cotizaciones') }}";
                            }
                        });
                },
                error: function(error) {}
            });
        }

        function agregarConcepto(e) {
            e.preventDefault();
            var activa_iva = $("#activa_iva").is(":checked");
            var id_producto = $("#tipo_producto").val();
            var cantidad = $("#cantidad").val();
            var largo = $("#largo").val();
            var alto = $("#alto").val();
            var descuento_aplicado = $("#descuento").val();
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var precio = $("#precio").val();
            var envio = $("#precio_envio").val();

            var data_json = {
                "accion": "agregarConcepto",
                "datos": {
                    'activa_iva': activa_iva,
                    'id_producto': id_producto,
                    'cantidad': cantidad,
                    'largo': largo,
                    'alto': alto,
                    'descuento_aplicado': descuento_aplicado,
                    't_descuento': t_descuento,
                    'precio': precio,
                    'envio': envio
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                dataType: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                },
                error: function(error) {
                    alert("Ocurrio un error");
                }
            });
        }

        function eliminarConcepto(e) {
            e.preventDefault();
            var activa_iva = $("#activa_iva").is(":checked");
            var t_descuento = $('input:radio[name=t_descuento]:checked').val()
            var descuento = $("#descuento").val();
            var id = $(this).data('id');
            var iva = $("#iva").val();
            var envio = $("#precio_envio").val();
            var data_json = {
                "accion": "eliminarConcepto",
                "datos": {
                    'iva': iva,
                    'descuento': descuento,
                    't_descuento': t_descuento,
                    'id': id,
                    'envio': envio,
                    'activa_iva': activa_iva
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                dataType: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#detalle_cotizacion").html(result);
                },
                error: function(error) {
                    alert("Ocurrio un error");
                }
            });
        }

        function seleccionaCliente(cliente) {
            var data_json = {
                "accion": "seleccionaCliente",
                "datos": {
                    'cliente': cliente
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#info_cliente").html(result);
                    $("#tipo_producto").removeAttr("disabled")
                    $("#add_concepto").removeAttr("disabled")

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $("#tipo_cotizacion").change(function() {
            var tipo_cotizacion = $("#tipo_cotizacion").val();
            var accion = $("#accion").attr("data-accion");

            var data_json = {
                "accion": "obtieneTipoCotizacion",
                "datos": {
                    'tipo_cotizacion': tipo_cotizacion,
                    'accion': accion
                }
            }
            muestraProductos(tipo_cotizacion);
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#plantilla_cotizacion").html(result);
                    $("#tipo_cotizacion").attr('disabled', 'disabled');


                    //$("#result-seleccion-servicio").html("");
                    //$("#result-tabla-servicios").html("");
                    //$("#tipo_servicio").removeAttr("disabled");
                    //$("#open_confirm_post_cotizacion").attr("disabled", "disabled");

                    //console.log(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        function calcularRenta() {
            var cantidad = $("#cantidad").val()
            var precio_comercial = $("#precio_comercial").val()
            var porcentaje_renta = $("#porcentaje_renta").val()
            var dias_renta = $("#dias_renta").val()

            // Verificar si los valores son números válidos
            if (isNaN(precio_comercial) || isNaN(porcentaje_renta) || isNaN(dias_renta)) {
                alert("Por favor, ingresa valores numéricos válidos.");
                return;
            }

            // Calcular el precio de renta
            var precio_renta = precio_comercial * (porcentaje_renta / 100) * dias_renta;
            $("#precio").val(precio_renta)

        }

        function muestraProductos(tipo_cotizacion) {
            var data_json = {
                "accion": "muestraProductos",
                "datos": {
                    'tipo_cotizacion': tipo_cotizacion
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#tipo_producto").html(result);
                    //console.log(result);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        $("#tipo_producto").change(function() {
            var id_producto = $("#tipo_producto").val();
            var tipo_cotizacion = $('input:radio[name=tipo_cotizacion]:checked').val()
            var data_json = {
                "accion": "detallarProducto",
                "datos": {
                    'id_producto': id_producto,
                    'tipo_cotizacion': tipo_cotizacion
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#info_detalle_producto").html(result);
                    $("#add_concepto").removeAttr("disabled");

                    verificarProductoTarima();

                    if (window.cantidadCoronasPendiente && id_producto == 111) {
                        $("#cantidad").val(window.cantidadCoronasPendiente);
                        
                        // Efecto visual para indicar que se rellenó
                        $("#cantidad").css("background-color", "#ffeeba"); // Amarillo suave
                        setTimeout(function(){ $("#cantidad").css("background-color", ""); }, 1000);
                        
                        // Limpiamos la variable para que no afecte futuros cambios
                        window.cantidadCoronasPendiente = null;
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        });

        // get condiciones
        function agregarCondicion(e) {
            e.preventDefault();
            var accion_condicion = $(this).attr("data-accion-condicion");
            var condicion = $('#datos_condicion > .ql-editor').html();
            var data_json = {
                "accion": "openAddCondicion",
                "datos": {
                    accion_condicion: accion_condicion,
                    condicion: condicion
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_cotizador') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    $("#modal_large_redes").html(result);
                    $('#modal_large_redes').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    quillCondiciones(condicion);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        // editando y guardando condiciones
        function saveCondicion(e) {
            // e.preventDefault();
            // var condicion = $('#descripcion_condicion').val();
            var condicion = $('#editor_condicion > .ql-editor').html();

            // Validar que no esté vacío
            if (condicion.trim() === "") {
                alert('La descripción de las condiciones no puede estar vacía.');
                return;
            }

            // Actualizar el contenido de la sección "Condiciones de cotización"
            $('#datos_condicion > .ql-editor').html(condicion);

            // Cerrar el modal
            $('#modal_large_redes').modal('hide');

        }
        
          // Al cargar la p��gina, revisa si hay una sucursal guardada en localStorage
        document.addEventListener("DOMContentLoaded", function() {
            const sucursalGuardada = localStorage.getItem("sucursalSeleccionada");
            const checkbox = document.getElementById("guardarSucursal");
            const selectSucursal = document.getElementById("suc_origen");

            // Si existe una sucursal guardada, selecciona la opci��n correspondiente en el select
            if (sucursalGuardada) {
                selectSucursal.value = sucursalGuardada;
                checkbox.checked = true;
            }

            // Escucha cambios en el select y en el checkbox
            selectSucursal.addEventListener("change", function() {
                if (checkbox.checked) {
                    localStorage.setItem("sucursalSeleccionada", selectSucursal.value);
                }
            });

            checkbox.addEventListener("change", function() {
                if (!checkbox.checked) {
                    localStorage.removeItem("sucursalSeleccionada");
                } else if (selectSucursal.value) {
                    localStorage.setItem("sucursalSeleccionada", selectSucursal.value);
                }
            });
        });

        var toolbarOptions = [
            ['bold', 'italic', 'underline', 'strike'], // toggled buttons
            ['blockquote', 'code-block'],
            [{
                'header': [2, 3, 4, 5, 6, false]
            }],
            [{
                'list': 'ordered'
            }, {
                'list': 'bullet'
            }],
            [{
                'script': 'sub'
            }, {
                'script': 'super'
            }], // superscript/subscript
            [{
                'indent': '-1'
            }, {
                'indent': '+1'
            }], // outdent/indent
            [{
                'direction': 'rtl'
            }], // text direction
            [{
                'size': ['small', false, 'large', 'huge']
            }], // custom dropdown
            [{
                'color': []
            }, {
                'background': []
            }], // dropdown with defaults from theme
            [{
                'font': []
            }],
            [{
                'align': []
            }],
            ['link', 'image'], // add's image support
            ['clean']
        ];

        function quillCondiciones(condiciones) {
            console.log(condiciones)
            quill = new Quill('#editor_condicion', {
                modules: {
                    syntax: true,
                    toolbar: toolbarOptions
                },
                theme: 'snow'
            });
            $('#editor_condicion > .ql-editor').html(condiciones)
            quill.on('text-change', function(delta, oldDelta, source) {
                $('#descripcion_condicion').text($("#editor_condicion > .ql-editor").html());
            });
        }

        function quillCondicionesPlano() {
            var quillCondicionesPlano = new Quill('#datos_condicion', {
                modules: {
                    syntax: true,
                    toolbar: false,
                },
                theme: 'snow'
            });

            quillCondicionesPlano.enable(false)
        }

    // --- LÓGICA CALCULADORA DE TARIMAS Y CORONAS (Versión Final) ---

    // 1. Detectar cambio de producto
    $(document).on("change", "#tipo_producto", function() {
        // Recuerda llamar a esto también en el success del ajax de 'muestraProductos'
        verificarProductoTarima();
    });

    function verificarProductoTarima() {
        var idProducto = $("#tipo_producto").val();
        
        // Validamos ID 101 (Tarima)
        if (idProducto == 101) {
            if ($("#link_abrir_calc").length === 0) {
                $("#info_detalle_producto").append('<br><div class="col-md-12"><a href="#" id="link_abrir_calc" style="margin-left: 2px; font-size: 0.9em; font-weight: bold; color: #28a745;"><i class="fas fa-calculator"></i> Calcular cantidad necesaria</a></div>');
            }
        } else {
            $("#link_abrir_calc").remove();
            $("#container_calculadora_tarimas").slideUp();
            $(".calc-input").val('');
            $("#res_tarimas_final, #res_coronas_final").text('0');
        }
    }

    // 2. Abrir/Cerrar Calculadora
    $(document).on("click", "#link_abrir_calc", function(e) { e.preventDefault(); $("#container_calculadora_tarimas").slideDown(); });
    $(document).on("click", "#btn_cerrar_calc", function() { $("#container_calculadora_tarimas").slideUp(); });

    // 3. Eventos de cálculo
    $(document).on("change", "#calc_forma", function() {
        var forma = $(this).val();
        $(".grupo-input").hide();
        $(".shape-" + forma).show();
        
        // Si es manual, deshabilitar botón de coronas (no se puede calcular)
        if(forma === 'manual') {
            $("#btn_usar_coronas").prop('disabled', true);
            $("#res_coronas_final").text('N/A');
        } else {
            $("#btn_usar_coronas").prop('disabled', false);
        }
        calcularMateriales();
    });

    $(document).on("keyup change", ".calc-input", function() {
        calcularMateriales();
    });

    // 4. FUNCIÓN MATEMÁTICA
    // --- FUNCIÓN DE CÁLCULO: REJILLA ESTRICTA ---
// Todo se calcula por filas y columnas. Se descartan sobrantes menores a 0.4 tarimas.

function calcularMateriales() {
    var forma = $("#calc_forma").val();
    var cantidadTarimas = 0;
    var cantidadCoronas = 0;
    var areaTotal = 0;

    // Función para obtener valor numérico
    var getVal = function(id) { return parseFloat($("#" + id).val()) || 0; };
    
    // --- REGLA DE ORO DEL .4 ---
    // Aplica a filas y columnas individualmente.
    var redondearDimension = function(metros) {
        if (metros <= 0) return 0;
        var tarimas = metros / 1.22;
        var entero = Math.floor(tarimas);
        var decimal = tarimas - entero;
        
        // Si el pedazo sobrante es 40% o más de una tarima, agrega una más.
        // Si es menos, se queda con las que caben completas.
        return (decimal >= 0.4) ? entero + 1 : entero;
    };

    // --- CÁLCULO POR SECCIÓN ---
    var calcularSeccion = function(largo, ancho) {
        var cols = redondearDimension(largo); // Filas reales
        var rows = redondearDimension(ancho); // Columnas reales
        
        var t = cols * rows;               // Tarimas (8 * 13 = 104)
        var c = (cols + 1) * (rows + 1);   // Coronas (9 * 14 = 126)
        
        return {
            tarimas: t,
            coronas: c,
            area: largo * ancho
        };
    };

    if (forma === 'rectangulo') {
        var res = calcularSeccion(getVal('calc_largo_1'), getVal('calc_ancho_1'));
        
        cantidadTarimas = res.tarimas;
        cantidadCoronas = res.coronas;
        areaTotal = res.area;
    } 
    else if (forma === 'compuesta') {
        // Sumamos dos secciones independientes
        var res1 = calcularSeccion(getVal('calc_largo_a'), getVal('calc_ancho_a'));
        var res2 = calcularSeccion(getVal('calc_largo_b'), getVal('calc_ancho_b'));
        
        cantidadTarimas = res1.tarimas + res2.tarimas;
        cantidadCoronas = res1.coronas + res2.coronas; 
        areaTotal = res1.area + res2.area;
    }
    else if (forma === 'manual') {
        // En manual no tenemos dimensiones, así que usamos la lógica de área pura
        // como aproximación, aplicando la misma regla de redondeo al total.
        var areaManual = getVal('calc_area_manual');
        areaTotal = areaManual;
        
        var bruto = areaManual / 1.4884;
        var entero = Math.floor(bruto);
        var decimal = bruto - entero;
        
        cantidadTarimas = (decimal >= 0.4) ? entero + 1 : entero;
        if(cantidadTarimas === 0 && areaTotal > 0) cantidadTarimas = 1;
        
        cantidadCoronas = 0; // No disponible
    }

    // --- MOSTRAR RESULTADOS ---
    $("#res_area_total").text(areaTotal.toFixed(2));
    $("#res_tarimas_final").text(cantidadTarimas);
    
    // Guardar datos en botones
    $("#btn_usar_cantidad").data("cantidad", cantidadTarimas);

    if(forma !== 'manual'){
        $("#res_coronas_final").text(cantidadCoronas);
        $("#btn_usar_coronas").data("cantidad", cantidadCoronas);
    } else {
        $("#res_coronas_final").text("N/A");
        $("#btn_usar_coronas").data("cantidad", 0);
    }
}
        // 5. Botón USAR TARIMAS (Rellena el campo)
        $(document).on("click", "#btn_usar_cantidad", function() {
            var cant = $(this).data("cantidad");
            if (cant > 0) {
                $("#cantidad").val(cant).trigger("change");
                $("#cantidad").css("background-color", "#d4edda");
                setTimeout(function(){ $("#cantidad").css("background-color", ""); }, 1000);
            }
        });

        // 6. Botón AGREGAR CORONAS (Añade producto a la lista)
        $(document).on("click", "#btn_usar_coronas", function() {
            var cantCoronas = $(this).data("cantidad");
            // Obtenemos la cantidad de tarimas calculada leyendo el dato del otro botón
            var cantTarimas = $("#btn_usar_cantidad").data("cantidad"); 

            if (cantCoronas > 0) {
                swal({
                    title: "¿Deseas continuar?",
                    text: "Esta acción guardará las " + cantTarimas + " tarimas calculadas para evitar conflictos.",
                    icon: "warning",
                    buttons: ["Cancelar", "Sí, continuar"],
                    dangerMode: false,
                })
                .then((willContinue) => {
                    if (willContinue) {
                        // PASO 1: Asignar cantidad de Tarimas al input actual
                        $("#cantidad").val(cantTarimas);

                        // PASO 2: Guardar las Tarimas en la cotización
                        // Invocamos manualmente la función agregarConcepto. 
                        // Como esta función lee los valores actuales del DOM (que ahorita son ID 101 y Cantidad Tarimas),
                        // funcionará correctamente antes de que hagamos el cambio de producto.
                        var e = { preventDefault: function(){} }; // Simular evento
                        agregarConcepto(e);

                        // PASO 3: Preparar el cambio a Coronas
                        // Guardamos la cantidad en una variable global temporal
                        window.cantidadCoronasPendiente = cantCoronas;

                        // PASO 4: Cambiar el selector de producto al ID 111 (Coronas)
                        // Usamos un pequeño timeout para dar tiempo a que el AJAX de agregarConcepto inicie
                        setTimeout(function() {
                            // Cambiamos el valor del Select2 y disparamos el evento 'change'
                            // Esto ejecutará la llamada AJAX que carga los detalles del producto 111
                            // y gracias al cambio que hicimos en el paso 1, se rellenará la cantidad sola.
                            $('#tipo_producto').val(111).trigger('change');
                            
                            // La calculadora se ocultará sola por la función verificarProductoTarima
                        }, 500); 
                    }
                });
            } else {
                swal("Atención", "Cantidad de coronas es 0", "warning");
            }
        });
</script>

@stop
