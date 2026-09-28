@extends('layouts.app_redes')


@section('css')
    <style>

    </style>
@stop


@section('content')
    @include('app_redes.modulos.ordenes_embarque.view.contenido_ordenes_emb')
@stop

@section('js')
    <script>
        //.->Filtros para ordenesa
        $('#filtrosOrdenes').on('submit', function(e) {
            e.preventDefault();

            let data_json = {
                "accion": "filtrarOrdenEm",
                "datos": {
                    fecha: $('#fecha_f').val(),
                    sucursal_destino: $('#sucursal_destino').val(),
                    sucursal_origen: $('#sucursal_origen').val(),
                    estado: $('#estado').val()
                }
            };
 
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_or_emb') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {

                    $('#tarjetas_ordenes_embarque').html(result);


                },
                error: function(error) {
                    console.log(error);
                    swal("Error",
                        "Hubo un problema... Por favor, intenta nuevamente.", "error"); }
            });
        });

        //.->
        function openModal() {

            // Activar los campos del formulario
            $('#responsable').prop('disabled', false);
            $('#fecha').prop('disabled', false);
            $('#suc_origen').prop('disabled', false);
            $('#suc_destino').prop('disabled', false);
            $('#conducto').prop('disabled', false);

            document.getElementById("formOrdenEmbarque").reset();
            $('#listaProductos').empty();
            $('#modalOrdenEmd').modal('show');

            document.getElementById("eliminarOrden").style.display = "none";
            document.getElementById("actualizarOrden").style.display = "none";
            document.getElementById("editarOrden").style.display = "none";
            document.getElementById("guardarOrden").style.display = "inline-block";
            document.getElementById("agregarAndamio").style.display = "inline-block";
            document.getElementById("agregarAccesorio").style.display = "inline-block";
        }

        //-> autorizar orden
        function autorizarOrden(idOrden) {

            // Obtenemos el id del registro
            var id = idOrden;

            // Mostramos la alerta de confirmación
            swal({
                title: "¿Autorizar Orden de Embarque?",
                text: " ",
                icon: "info",
                buttons: ["Cancelar", "Confirmar"],
                dangerMode: false,
            }).then((confirmDelete) => {

                if (confirmDelete) {
                    var data_json = {
                        "accion": "autorizarOrden",
                        "datos": {
                            id: id,
                            status: 'autorizada',
                        }
                    };

                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('ajax_or_emb') }}',
                        type: 'post',
                        datatype: 'html',
                        beforeSend: function() {},
                        success: function(result) {

                            // Validamos si la respuesta fue exitosa
                            if (result.status === 'success') {

                                // Mostramos alerta de éxito
                                swal({
                                    title: result.message,
                                    text: " ",
                                    icon: "success",
                                    timer: 1200,
                                    buttons: false
                                }).then(() => {

                                    // Actualizamos la página
                                    location.reload();
                                });

                            } else {
                                swal("Error", "Ocurrió un error inesperado.", "error");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error",
                                "Hubo un problema al eliminar el movimiento. Por favor, intenta nuevamente.",
                                "error");
                        }
                    });
                }
            });
        }

        //-> pasarAtransito orden
        function pasarAtransito(idOrden) {
            // Obtenemos el id del registro 
            var id = idOrden;

            swal({
                title: "¿Pasar Orden a tránsito?",
                text: "Por favor, ingresa el número de guía para continuar:",
                content: {
                    element: "input",
                    attributes: {
                        placeholder: "Número de guía",
                        type: "text",
                    },
                },
                icon: "info",
                buttons: ["Cancelar", "Confirmar"],
                dangerMode: false,
            }).then((numeroGuia) => {
                if (numeroGuia) {
                    if (numeroGuia.trim() === "") {
                        swal("Error", "El número de guía es obligatorio.", "error");
                        return;
                    }

                    var data_json = {
                        accion: "autorizarOrden",
                        datos: {
                            id: id,
                            status: "transito",
                            numero_guia: numeroGuia,
                        },
                    };

                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('ajax_or_emb') }}',
                        type: 'post',
                        datatype: 'html',
                        beforeSend: function() {},
                        success: function(result) {

                            // Validamos si la respuesta fue exitosa
                            if (result.status === 'success') {

                                // Mostramos alerta de éxito
                                swal({
                                    title: result.message,
                                    text: " ",
                                    icon: "success",
                                    timer: 1500,
                                    buttons: false
                                }).then(() => {

                                    // Actualizamos la página
                                    location.reload();
                                });

                            } else {
                                swal("Error", "Ocurrió un error inesperado.", "error");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error",
                                "Hubo un problema. Por favor, intenta nuevamente.",
                                "error");
                        }
                    });
                }
            });
        }

        //-> recibir orden
        function recibirOrden(idOrden) {

            // Obtenemos el id del registro 
            var id = idOrden;

            // Mostramos la alerta
            swal({
                title: "¿Recibir Orden de Embarque?",
                text: " ",
                icon: "info",
                buttons: ["Cancelar", "Confirmar"],
                dangerMode: false,
            }).then((confirmDelete) => {

                if (confirmDelete) {
                    var data_json = {
                        "accion": "autorizarOrden",
                        "datos": {
                            id: id,
                            status: 'recibido',
                        }
                    };

                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('ajax_or_emb') }}',
                        type: 'post',
                        datatype: 'html',
                        beforeSend: function() {},
                        success: function(result) {

                            // Validamos si la respuesta fue exitosa
                            if (result.status === 'success') {

                                // Mostramos alerta de éxito
                                swal({
                                    title: result.message,
                                    text: " ",
                                    icon: "success",
                                    timer: 1500,
                                    buttons: false
                                }).then(() => {

                                    // Actualizamos la página
                                    location.reload();
                                });

                            } else {
                                swal("Error", "Ocurrió un error inesperado.", "error");
                            }
                        },
                        error: function(error) {
                            console.log(error);
                            swal("Error",
                                "Hubo un problema. Por favor, intenta nuevamente.",
                                "error");
                        }
                    });
                }
            });
        }

        //-> completar orden
        function completarOrden(idOrden) {

            // Obtenemos el id del registro
            var id = idOrden;

            // Mostramos la alerta 
            swal({
                title: "¿La orden de embarque está completa?",
                text: "Por favor, confirma si el contenido de la orden de embarque está completo. Si es necesario, agrega una nota con los detalles.",
                icon: "warning",
                buttons: {
                    cancel: "Cancelar",
                    completa: {
                        text: "Sí, está completa",
                        value: "completa",
                    },
                    incompleta: {
                        text: "No, agregar una nota",
                        value: "incompleta",
                    },
                },
            }).then((respuesta) => {
                if (respuesta === "completa") {

                    // Confirmar recepción sin nota
                    const data_json = {
                        accion: "completarOrden",
                        datos: {
                            id: idOrden,
                            status: 'completada',
                            nota: null,
                        },
                    };
                    ajaxSetup();
                    $.ajax({
                        data: data_json,
                        url: '{{ route('ajax_or_emb') }}',
                        type: 'post',
                        datatype: 'html',
                        beforeSend: function() {},
                        success: function(result) {

                            // Mostramos alerta de éxito
                            swal({
                                title: result.message,
                                text: " ",
                                icon: "success",
                                timer: 1500,
                                buttons: false
                            }).then(() => {

                                // Actualizamos la página
                                location.reload();
                            });
                        },
                        error: function(error) {
                            let errorMessage = "Hubo un problema. Por favor, intenta nuevamente.";
                            // error
                            swal("Error", errorMessage, "error");
                        }
                    });
                } else if (respuesta === "incompleta") {
                    // Crear el textarea
                    const textarea = document.createElement("textarea");
                    textarea.placeholder = "Escribe tu nota aquí...";
                    textarea.style.width = "100%";
                    textarea.style.height = "100px";
                    textarea.style.resize = "none";

                    swal({
                        title: "Agrega una nota",
                        text: "Explica por qué la orden no está completa:",
                        content: textarea,
                        buttons: ["Cancelar", "Guardar nota y recibir"],
                    }).then(() => {
                        const nota = textarea.value.trim();
                        if (nota) {

                            const data_json = {
                                accion: "completarOrden",
                                datos: {
                                    id: idOrden,
                                    status: 'completada',
                                    nota: nota,
                                },
                            };

                            ajaxSetup();
                            $.ajax({
                                data: data_json,
                                url: '{{ route('ajax_or_emb') }}',
                                type: 'post',
                                datatype: 'html',
                                beforeSend: function() {},
                                success: function(result) {

                                    // Validamos si la respuesta fue exitosa
                                    if (result.status === 'success') {

                                        // Mostramos alerta de éxito
                                        swal({
                                            title: result.message,
                                            text: " ",
                                            icon: "success",
                                            timer: 1500,
                                            buttons: false
                                        }).then(() => {

                                            // Actualizamos la página
                                            location.reload();
                                        });

                                    } else {
                                        swal("Error",
                                            "Ocurrió un error inesperado.",
                                            "error");
                                    }
                                },
                                error: function(error) {
                                    console.log(error);
                                    swal("Error",
                                        "Hubo un problema. Por favor, intenta nuevamente.",
                                        "error");
                                }
                            });
                        }
                    });
                }
            });
        }

        //-> ver orden para editar
        function editarOrden(idOrden, estadoOrden) {

            console.log('estadoOrden :>> ', estadoOrden);

            if (estadoOrden == 'pendiente') {
                document.getElementById("editarOrden").style.display = "inline-block";
            } else {
                document.getElementById("editarOrden").style.display = "none";
            }

            // Mostrar/Ocualtar botones ->
            // document.getElementById("editarOrden").style.display = "inline-block";
            document.getElementById("eliminarOrden").style.display = "none";
            document.getElementById("actualizarOrden").style.display = "none";
            document.getElementById("guardarOrden").style.display = "none";
            document.getElementById("agregarAndamio").style.display = "none";
            document.getElementById("agregarAccesorio").style.display = "none";

            if (idOrden) {
                var data_json = {
                    "accion": "getOrdenID",
                    "datos": {
                        id: idOrden,
                    }
                };

                ajaxSetup();
                $.ajax({
                    data: data_json,
                    url: '{{ route('ajax_or_emb') }}',
                    type: 'post',
                    datatype: 'json',
                    beforeSend: function() {},
                    success: function(result) {
                        // Validamos si la respuesta fue exitosa
                        if (200) {
                            const orden = result.orden;
                            const productos = result.productos;

                            // Asignando datos de la orden al formulario del modal
                            $('#responsable').val(orden.responsable).prop('disabled', true);
                            $('#fecha').val(orden.fecha).prop('disabled', true);
                            $('#suc_origen').val(orden.id_origen).prop('disabled', true);
                            $('#suc_destino').val(orden.id_destino).prop('disabled', true);
                            $('#conducto').val(orden.conducto).prop('disabled', true);
                            $('#id').val(orden.id);

                            // Limpiar productos anteriores en la lista
                            $('#listaProductos').empty();

                            // Iterar sobre los productos y agregarlos al modal
                            productos.forEach(producto => {
                                $('#listaProductos').append(`
                            <div class="form-row align-items-center mb-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" value="${producto.producto}" disabled>
                                </div>
                                <div class="col-md-2">
                                    <input type="number" class="form-control" value="${producto.cantidad}" disabled>
                                </div>
                            </div>`);

                            });

                            // Mostrar el modal de edición
                            $('#modalOrdenEmd').modal('show');

                        } else {
                            swal("Error", "No se pudo obtener la información de la orden.", "error");
                        }
                    },
                    error: function(error) {
                        console.log(error);
                        swal("Error",
                            "Hubo un problema al obtener la información. Por favor, intenta nuevamente.",
                            "error");
                    }
                });
            }
        }
    </script>
@stop
