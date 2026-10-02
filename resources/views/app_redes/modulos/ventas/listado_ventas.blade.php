@extends('layouts.app_redes')
@section('css')
@stop
@section('content')
    @include('app_redes.modulos.ventas.contenido_listado_ventas')
    @include('app_redes.modulos.ventas.modal_logistica')
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
                    getTablaVentas(page);
                }
            }
        });

        $(document).ready(function() {
            $(document).on('click', '.pagination a', function(e) {
                getTablaVentas($(this).attr('href').split('page=')[1]);
                e.preventDefault();
            });
            // Carga inicial para mostrar el total desde el principio
            getTablaVentas(1);
        });

        $(document).on("change", "#change-page-size", function() {
            //numero de datos
            getTablaVentas(1);
        });
        $(document).on("change", "#estatus_venta", function() {
            //numero de datos
            getTablaVentas(1);
        });

        $(document).on("keyup", "#filtrar_busqueda_venta", function(e) {
            //busqueda por venta
            getTablaVentas(1);
        });

        $(document).on("keyup", "#filtrar_busqueda", function(e) {
            //busqueda por nombre de cliente
            getTablaVentas(1);
        });

        $(document).on("keyup", "#filtrar_busqueda_usuario", function(e) {
            //busqueda por nombre de cliente
            getTablaVentas(1);
        });
        $(document).on("change", "#filtrar_busqueda_fecha_final", function(e) {
            // busqueda por fecha
            getTablaVentas(1);
        });

        $(document).on("change", "#giro_empresa", function(e) {
            // busqueda por giro empresarial
            getTablaVentas(1);
        });

        $(document).on("click", "#confirm_desactiva_cliente", openConfirmDelete);
        $(document).on("click", "#confirm_activa_cliente", openConfirmActiva);
        $(document).on("click", "#confirm_elimina_cliente", openConfirmElimina);
        $(document).on("click", "#open_finaliza_venta", OpenFinalizaVenta);
        $(document).on("click", "#open_add_envio", OpenAddEnvio);
        $(document).on("click", "#open_add_envio_paqueteria", OpenAddEnvioPaqueteria);
        $(document).on("click", "#open_add_paqueteria", OpenAddPaqueteria);
        $(document).on("click", "#open_add_origen", OpenAddOrigen);
        $(document).on("click", "#open_add_destino", OpenAddDestino);

        $(document).on("click", "#filtrar-total", function() {
            // Obtener el valor actual de los atributos
            let uso = $("#filtrar-total").attr("uso");
            let orden = $("#filtrar-total").attr("orden");

            // Cambiar los atributos de acuerdo con la cantidad de clics
            if (uso == "false") {
                // Primer clic: "uso" = true y "orden" = "desc"
                $("#filtrar-total").attr("uso", "true");
                $("#filtrar-total").attr("orden", "desc");
                $("#filtrar-total").text("Total ↓")
            } else if (orden === "desc") {
                // Segundo clic: "uso" = true y "orden" = "asc"
                $("#filtrar-total").attr("orden", "asc");
                $("#filtrar-total").text("Total ↑")
            } else if (orden === "asc") {
                // Tercer clic: "uso" = false y "orden" permanece en "asc"
                $("#filtrar-total").attr("uso", "false");
                $("#filtrar-total").text("Total ↑↓")
            }

            getTablaVentas(1)
        });

        function getTablaVentas(page) {
            if (page == undefined) {
                page = 1;
            }

            var max_row = $('#change-page-size').val();
            var filtro_status_ventas = $('#estatus_venta').val();
            var filtrar_busqueda = $('#filtrar_busqueda').val();
            var filtrar_busqueda_usuario = $('#filtrar_busqueda_usuario').val();
            var filtrar_busqueda_venta = $('#filtrar_busqueda_venta').val();
            var filtrar_busqueda_fecha_inicio = $('#filtrar_busqueda_fecha_inicio').val();
            var filtrar_busqueda_fecha_final = $('#filtrar_busqueda_fecha_final').val();
            var filtrar_giro_empresa = $('#giro_empresa').val();
            if( $('#filtrar-total').attr("uso") == "true") {
                var filtrar_por = 'vet.total';
                var orden_por_total = $('#filtrar-total').attr("orden")
            } else {
                var filtrar_por = null;
                var orden_por_total = null;
            }

            var data_json = {
                "accion": "getTablaVentas",
                "page": page,
                "datos": {
                    "max_row": max_row,
                    "filtro_status_ventas": filtro_status_ventas,
                    "filtrar_busqueda": filtrar_busqueda,
                    "filtrar_busqueda_usuario": filtrar_busqueda_usuario,
                    "filtrar_busqueda_venta": filtrar_busqueda_venta,
                    "filtrar_busqueda_fecha_inicio": filtrar_busqueda_fecha_inicio,
                    "filtrar_busqueda_fecha_final": filtrar_busqueda_fecha_final,
                    "filtrar_giro_empresa": filtrar_giro_empresa,
                    "columna_orden": filtrar_por,  
                    "orden": orden_por_total,
                }
            }

            ajaxSetup();
            console.log('object :>> ', data_json);
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                success: function(result) {
                    $("#tabla_cotizaciones").html(result);
                    // Actualizar el contador de ventas en el header
                    var total = $("#hidden-ventas-total").text().trim();
                    if (total !== '') {
                        $("#ventas-total-count").text('(' + total + ' registros)');
                    }
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Exportar a Excel: construye URL con filtros actuales
        $(document).on('click', '#btn-exportar-ventas', function() {
            var params = new URLSearchParams({
                filtro_status_ventas:          $('#estatus_venta').val() || '',
                filtrar_busqueda:              $('#filtrar_busqueda').val() || '',
                filtrar_busqueda_venta:        $('#filtrar_busqueda_venta').val() || '',
                filtrar_busqueda_fecha_inicio: $('#filtrar_busqueda_fecha_inicio').val() || '',
                filtrar_busqueda_fecha_final:  $('#filtrar_busqueda_fecha_final').val() || '',
                filtrar_giro_empresa:          $('#giro_empresa').val() || '',
            });
            window.location.href = '{{ route('path_exportar_ventas') }}?' + params.toString();
        });

        function OpenFinalizaVenta(e) {
            e.preventDefault();
            var id_vta = $(this).attr("data-id-vta");
            var cod_venta = $(this).attr("data-cod-venta");
            swal({
                    title: "¿Estas seguro?",
                    text: "Se finalizará la venta: " + cod_venta,
                    icon: "warning",
                    buttons: true,
                    successMode: true,
                    buttons: ["Cancelar", "Si, Terminar ahora"],
                })
                .then((willTermina) => {
                    if (willTermina) {
                        confirmTerminaVta(id_vta);
                    } else {}
                });
        }

        function confirmTerminaVta(id_vta) {
            var id_vta = id_vta;
            var data_json = {
                "accion": "confirmTerminaVta",
                "datos": {
                    "id_vta": id_vta
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    swal("Éxito!", "Se finalizó el proyecto correctamente!", "success");
                    getTablaVentas();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function openConfirmDelete(e) {
            e.preventDefault();
            var id_coti = $(this).attr("data-id-coti");
            var data_json = {
                "accion": "openConfirmInfo",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    var id_coti = result.id_cotizacion;
                    var cod_cotizacion = result.cod_cotizacion;
                    swal({
                            title: "¿Estas seguro?",
                            text: "Si confirma se desactivará la cotización para el cliente: " +
                                cod_cotizacion,
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
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function confirmDesactiva(id_coti) {
            var id_coti = id_coti;
            var data_json = {
                "accion": "confirmDesactiva",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    swal("Éxito!", "Se ha desactivado correctamente!", "success");
                    getTablaVentas();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function openConfirmActiva(e) {
            e.preventDefault();
            var id_coti = $(this).attr("data-id-coti");
            var data_json = {
                "accion": "openConfirmInfo",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    var id_coti = result.id_cotizacion;
                    var cod_cotizacion = result.cod_cotizacion;
                    swal({
                            title: "¿Estas seguro?",
                            text: "Si confirma se avtivará la cotización para el cliente: " +
                                cod_cotizacion,
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
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function confirmActiva(id_coti) {
            var id_coti = id_coti;
            var data_json = {
                "accion": "confirmActiva",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    swal("Éxito!", "Se ha Activado correctamente!", "success");
                    getTablaVentas();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function openConfirmElimina(e) {
            e.preventDefault();
            var id_coti = $(this).attr("data-id-coti");
            var data_json = {
                "accion": "openConfirmInfo",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    var id_coti = result.id_cotizacion;
                    var cod_cotizacion = result.cod_cotizacion;
                    swal({
                            title: "¿Estas seguro?",
                            text: "Si confirma se ELIMINARÁ permantentemente la cotización: " +
                                cod_cotizacion,
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
                error: function(error) {
                    console.log(error);
                }
            });
        }

        function confirmElimina(id_coti) {
            var id_coti = id_coti;
            var data_json = {
                "accion": "confirmElimina",
                "datos": {
                    "id_coti": id_coti
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    console.log(result);
                    swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
                    getTablaVentas();
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Agregamos envio
        function OpenAddEnvio(e) {
            // e.preventDefault();
            var id_coti = $(this).attr("data-id-vent");
            swal({
                title: "Agregar costo de envío",
                text: "Ingresa el costo de envío de esta venta:",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "$$$",
                        type: "number",
                        min: "0",
                        className: "form-control",
                        id: "costoEnvioInput"
                    },
                },
                icon: "info",
                buttons: ["Cancelar", "Agregar"],
            }).then((value) => {
                if (value) {
                    var costoEnvio = document.getElementById("costoEnvioInput").value;
                    if (costoEnvio === "") {
                        swal("Error", "Debes ingresar un monto válido para el envío.", "error");
                        return;
                    }

                    var data_json = {
                        "accion": "addEnvio",
                        "datos": {
                            "id_vta": id_coti,
                            "envio": parseFloat(costoEnvio)
                        }
                    };

                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('path_ajax_ventas') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(response) {
                            swal("¡Éxito!", "El costo de envío ha sido registrado correctamente.",
                                    "success")
                                .then(() => {
                                    getTablaVentas();
                                });
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error", "Hubo un problema al registrar el costo de envío.", "error");
                        }
                    });
                }
            });
        }

        // Agregar / Editar Envío Paquetería
        function OpenAddEnvioPaqueteria(e) {
            var id_vent = $(this).attr("data-id-vent");
            swal({
                title: "Costo de Envío Paquetería",
                text: "Ingresa el costo de envío vía paquetería:",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "$$$",
                        type: "number",
                        min: "0",
                        className: "form-control",
                        id: "costoEnvioPaqInput"
                    },
                },
                icon: "info",
                buttons: ["Cancelar", "Guardar"],
            }).then((value) => {
                if (value) {
                    var costo = document.getElementById("costoEnvioPaqInput").value;
                    if (costo === "") {
                        swal("Error", "Debes ingresar un monto válido.", "error");
                        return;
                    }
                    var data_json = {
                        "accion": "addEnvioPaqueteria",
                        "datos": {
                            "id_vta": id_vent,
                            "envio_paqueteria": parseFloat(costo)
                        }
                    };
                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('path_ajax_ventas') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(response) {
                            swal("¡Éxito!", "El costo de envío paquetería ha sido guardado.", "success")
                                .then(() => { getTablaVentas(); });
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error", "Hubo un problema al guardar el dato.", "error");
                        }
                    });
                }
            });
        }

        // Agregar / Editar Paquetería (selector con opción "Otros" manual)
        function OpenAddPaqueteria(e) {
            var id_vent = $(this).attr("data-id-vent");
            var current = $(this).attr("data-paqueteria") || "";

            // Construir el contenido HTML del modal
            var wrapper = document.createElement("div");
            wrapper.style.textAlign = "left";

            var selectLabel = document.createElement("label");
            selectLabel.textContent = "Selecciona la paquetería:";
            selectLabel.style.display = "block";
            selectLabel.style.marginBottom = "5px";

            var select = document.createElement("select");
            select.id = "paqueteriaSelect";
            select.className = "form-control";
            select.style.marginBottom = "8px";

            var opciones = ["Paquetexpress", "Pitic", "Otros"];
            opciones.forEach(function(op) {
                var opt = document.createElement("option");
                opt.value = op;
                opt.textContent = op;
                if (current === op) opt.selected = true;
                select.appendChild(opt);
            });
            // Si el valor actual no está en las opciones predefinidas, selecciona "Otros"
            if (current && !opciones.includes(current)) {
                select.value = "Otros";
            }

            var inputOtros = document.createElement("input");
            inputOtros.type = "text";
            inputOtros.id = "paqueteriaOtrosInput";
            inputOtros.className = "form-control";
            inputOtros.placeholder = "Nombre de la paquetería";
            inputOtros.style.display = (select.value === "Otros") ? "block" : "none";
            if (current && !opciones.includes(current)) {
                inputOtros.value = current;
            }

            select.addEventListener("change", function() {
                inputOtros.style.display = (this.value === "Otros") ? "block" : "none";
            });

            wrapper.appendChild(selectLabel);
            wrapper.appendChild(select);
            wrapper.appendChild(inputOtros);

            swal({
                title: "Paquetería",
                content: wrapper,
                icon: "info",
                buttons: ["Cancelar", "Guardar"],
            }).then((value) => {
                if (value) {
                    var selectEl = document.getElementById("paqueteriaSelect");
                    var inputEl = document.getElementById("paqueteriaOtrosInput");
                    var paqueteria = selectEl.value === "Otros" ? inputEl.value.trim() : selectEl.value;
                    if (!paqueteria) {
                        swal("Error", "Debes indicar la paquetería.", "error");
                        return;
                    }
                    var data_json = {
                        "accion": "addPaqueteria",
                        "datos": {
                            "id_vta": id_vent,
                            "paqueteria": paqueteria
                        }
                    };
                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('path_ajax_ventas') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(response) {
                            swal("¡Éxito!", "La paquetería ha sido guardada.", "success")
                                .then(() => { getTablaVentas(); });
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error", "Hubo un problema al guardar el dato.", "error");
                        }
                    });
                }
            });
        }

        // Agregar / Editar Origen
        function OpenAddOrigen(e) {
            var id_vent = $(this).attr("data-id-vent");
            var current = $(this).attr("data-valor") || "";
            swal({
                title: "Origen de la venta",
                text: "Ingresa la entidad de origen:",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Origen",
                        type: "text",
                        className: "form-control",
                        id: "origenInput",
                        value: current
                    },
                },
                icon: "info",
                buttons: ["Cancelar", "Guardar"],
            }).then((value) => {
                if (value) {
                    var origen = document.getElementById("origenInput").value.trim();
                    var data_json = {
                        "accion": "addOrigen",
                        "datos": {
                            "id_vta": id_vent,
                            "origen": origen
                        }
                    };
                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('path_ajax_ventas') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(response) {
                            swal("¡Éxito!", "El origen ha sido guardado.", "success")
                                .then(() => { getTablaVentas(); });
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error", "Hubo un problema al guardar el dato.", "error");
                        }
                    });
                }
            });
        }

        // Agregar / Editar Destino
        function OpenAddDestino(e) {
            var id_vent = $(this).attr("data-id-vent");
            var current = $(this).attr("data-valor") || "";
            swal({
                title: "Destino de la venta",
                text: "Ingresa la entidad de destino:",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Destino",
                        type: "text",
                        className: "form-control",
                        id: "destinoInput",
                        value: current
                    },
                },
                icon: "info",
                buttons: ["Cancelar", "Guardar"],
            }).then((value) => {
                if (value) {
                    var destino = document.getElementById("destinoInput").value.trim();
                    var data_json = {
                        "accion": "addDestino",
                        "datos": {
                            "id_vta": id_vent,
                            "destino": destino
                        }
                    };
                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('path_ajax_ventas') }}',
                        type: 'post',
                        datatype: 'json',
                        success: function(response) {
                            swal("¡Éxito!", "El destino ha sido guardado.", "success")
                                .then(() => { getTablaVentas(); });
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error", "Hubo un problema al guardar el dato.", "error");
                        }
                    });
                }
            });
        }

        // ==========================================
        // GESTIÓN UNIFICADA DE LOGÍSTICA Y ENVÍOS
        // ==========================================
        var listaPaqueterias = ["Paquetexpress", "Pitic", "Tresguerras", "Castores", "DHL", "FedEx", "Estafeta", "Flecha Amarilla", "Transporte Propio / Local"];

        $(document).on("click", ".open-modal-logistica", function(e) {
            e.preventDefault();
            var btn = $(this);
            var idVta = btn.attr("data-id-vent");
            var codVenta = btn.attr("data-cod-venta") || "—";
            var cliente = btn.attr("data-cliente") || "—";
            var envio = btn.attr("data-envio") || "";
            var envioPaq = btn.attr("data-envio-paqueteria") || "";
            var paqueteria = btn.attr("data-paqueteria") || "";
            var fechaEnvio = btn.attr("data-fecha-envio") || "";
            var origen = btn.attr("data-origen") || "";
            var destino = btn.attr("data-destino") || "";

            // Datos segundo envío
            var envio2 = btn.attr("data-envio-2") || "";
            var origen2 = btn.attr("data-origen-2") || "";
            var destino2 = btn.attr("data-destino-2") || "";
            var envioPaq2 = btn.attr("data-envio-paqueteria-2") || "";
            var paqueteria2 = btn.attr("data-paqueteria-2") || "";
            var fechaEnvio2 = btn.attr("data-fecha-envio-2") || "";

            // Llenar datos principales
            $("#modal_log_id_venta").val(idVta);
            $("#modal_log_cod_venta").text(codVenta);
            $("#modal_log_cliente").text(cliente);
            $("#modal_log_envio").val((envio !== "" && parseFloat(envio) > 0) ? parseFloat(envio) : "");
            $("#modal_log_origen").val(origen);
            $("#modal_log_destino").val(destino);

            // Primer envío paquetería
            $("#modal_log_envio_paqueteria").val((envioPaq !== "" && parseFloat(envioPaq) > 0) ? parseFloat(envioPaq) : "");
            $("#modal_log_fecha_envio").val(fechaEnvio);
            if (paqueteria && listaPaqueterias.includes(paqueteria)) {
                $("#modal_log_paqueteria_select").val(paqueteria);
                $("#modal_log_paqueteria_otra").val("").hide();
            } else if (paqueteria) {
                $("#modal_log_paqueteria_select").val("Otros");
                $("#modal_log_paqueteria_otra").val(paqueteria).show();
            } else {
                $("#modal_log_paqueteria_select").val("");
                $("#modal_log_paqueteria_otra").val("").hide();
            }

            // Segundo envío completo
            var tieneSegundoEnvio = (envioPaq2 !== "" && parseFloat(envioPaq2) > 0) || 
                                    (paqueteria2 !== "") || 
                                    (fechaEnvio2 !== "") || 
                                    (envio2 !== "" && parseFloat(envio2) > 0) || 
                                    (origen2 !== "") || 
                                    (destino2 !== "");

            if (tieneSegundoEnvio) {
                $("#check_segundo_envio").prop("checked", true);
                $("#seccion_segundo_envio").show();
                $("#modal_log_envio_2").val((envio2 !== "" && parseFloat(envio2) > 0) ? parseFloat(envio2) : "");
                $("#modal_log_origen_2").val(origen2);
                $("#modal_log_destino_2").val(destino2);
                $("#modal_log_envio_paqueteria_2").val((envioPaq2 !== "" && parseFloat(envioPaq2) > 0) ? parseFloat(envioPaq2) : "");
                $("#modal_log_fecha_envio_2").val(fechaEnvio2);
                if (paqueteria2 && listaPaqueterias.includes(paqueteria2)) {
                    $("#modal_log_paqueteria_select_2").val(paqueteria2);
                    $("#modal_log_paqueteria_otra_2").val("").hide();
                } else if (paqueteria2) {
                    $("#modal_log_paqueteria_select_2").val("Otros");
                    $("#modal_log_paqueteria_otra_2").val(paqueteria2).show();
                } else {
                    $("#modal_log_paqueteria_select_2").val("");
                    $("#modal_log_paqueteria_otra_2").val("").hide();
                }
            } else {
                $("#check_segundo_envio").prop("checked", false);
                $("#seccion_segundo_envio").hide();
                $("#modal_log_envio_2").val("");
                $("#modal_log_origen_2").val("");
                $("#modal_log_destino_2").val("");
                $("#modal_log_envio_paqueteria_2").val("");
                $("#modal_log_fecha_envio_2").val("");
                $("#modal_log_paqueteria_select_2").val("");
                $("#modal_log_paqueteria_otra_2").val("").hide();
            }

            $("#modalLogisticaEnvio").modal("show");
        });

        // Copiar dirección del destino 1 al destino 2
        $(document).on("click", "#btn_copiar_destino", function(e) {
            e.preventDefault();
            var dirPrincipal = $("#modal_log_destino").val();
            $("#modal_log_destino_2").val(dirPrincipal).focus();
        });

        // Alternar select "Otros" para paquetería 1
        $(document).on("change", "#modal_log_paqueteria_select", function() {
            if ($(this).val() === "Otros") {
                $("#modal_log_paqueteria_otra").show().focus();
            } else {
                $("#modal_log_paqueteria_otra").hide().val("");
            }
        });

        // Alternar select "Otros" para paquetería 2
        $(document).on("change", "#modal_log_paqueteria_select_2", function() {
            if ($(this).val() === "Otros") {
                $("#modal_log_paqueteria_otra_2").show().focus();
            } else {
                $("#modal_log_paqueteria_otra_2").hide().val("");
            }
        });

        // Checkbox segundo envío
        $(document).on("change", "#check_segundo_envio", function() {
            if ($(this).is(":checked")) {
                $("#seccion_segundo_envio").slideDown(200);
            } else {
                $("#seccion_segundo_envio").slideUp(200);
            }
        });

        // Guardar logística unificada
        $(document).on("click", "#btn_guardar_logistica", function(e) {
            e.preventDefault();
            var idVta = $("#modal_log_id_venta").val();
            if (!idVta) return;

            var envio = $("#modal_log_envio").val();
            var origen = $("#modal_log_origen").val();
            var destino = $("#modal_log_destino").val();

            // Paquetería 1
            var selPaq = $("#modal_log_paqueteria_select").val();
            var paqueteria = selPaq === "Otros" ? $("#modal_log_paqueteria_otra").val().trim() : selPaq;
            var envioPaq = $("#modal_log_envio_paqueteria").val();
            var fechaEnvio = $("#modal_log_fecha_envio").val();

            // Segundo envío
            var habilitarSegundo = $("#check_segundo_envio").is(":checked") ? 1 : 0;
            var envio2 = $("#modal_log_envio_2").val();
            var origen2 = $("#modal_log_origen_2").val();
            var destino2 = $("#modal_log_destino_2").val();
            var selPaq2 = $("#modal_log_paqueteria_select_2").val();
            var paqueteria2 = selPaq2 === "Otros" ? $("#modal_log_paqueteria_otra_2").val().trim() : selPaq2;
            var envioPaq2 = $("#modal_log_envio_paqueteria_2").val();
            var fechaEnvio2 = $("#modal_log_fecha_envio_2").val();

            var dataJson = {
                "accion": "guardarLogisticaEnvio",
                "datos": {
                    "id_vta": idVta,
                    "envio": envio,
                    "origen": origen,
                    "destino": destino,
                    "paqueteria": paqueteria,
                    "envio_paqueteria": envioPaq,
                    "fecha_envio_paqueteria": fechaEnvio,
                    "habilitar_segundo_envio": habilitarSegundo,
                    "envio_2": envio2,
                    "origen_2": origen2,
                    "destino_2": destino2,
                    "paqueteria_2": paqueteria2,
                    "envio_paqueteria_2": envioPaq2,
                    "fecha_envio_paqueteria_2": fechaEnvio2
                }
            };

            var btn = $(this);
            btn.prop("disabled", true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            ajaxSetup();
            $.ajax({
                data: dataJson,
                url: '{{ route('path_ajax_ventas') }}',
                type: 'post',
                dataType: 'json',
                success: function(response) {
                    btn.prop("disabled", false).html('<i class="fas fa-save mr-1"></i> Guardar Cambios');
                    $("#modalLogisticaEnvio").modal("hide");
                    swal("¡Éxito!", "La información de envío y logística ha sido actualizada correctamente.", "success")
                        .then(() => {
                            getTablaVentas();
                        });
                },
                error: function(err) {
                    btn.prop("disabled", false).html('<i class="fas fa-save mr-1"></i> Guardar Cambios');
                    console.log(err);
                    swal("Error", "Ocurrió un problema al guardar la información de logística.", "error");
                }
            });
        });
    </script>
@stop
