@extends('layouts.app_redes')
@include('app_redes.modulos.modales.modales')


@section('css')
<style>
    /* Estilo para la tabla */
    .caja-chica-table {
        border-collapse: collapse;
        border-radius: 0.5rem;
        overflow: hidden;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
    }

    .caja-chica-table th,
    .caja-chica-table td {
        padding: 0.5rem;
        vertical-align: middle;
    }

    /* Estilo para el encabezado */
    .caja-chica-table th {
        background-color: #007bff;
        color: #ffffff;
        font-weight: bold;
        border-bottom: 2px solid #00b33f;
    }

    /* Estilo para las filas */
    .caja-chica-table tbody tr:hover {
        background-color: #f1f1f1;
        /* cursor: pointer; */
    }

    /* Estilo para los tipos de movimiento */
    .caja-chica-table tbody tr td span.text-success {
        color: #28a745;
        font-weight: bold;
    }

    .caja-chica-table tbody tr td span.text-danger {
        color: #dc3545;
        font-weight: bold;
    }

    /* MODAL */
    .modal-header {
        background-color: #f8f9fc;
        border-bottom: 1px solid #e3e6f0;
    }

    .modal-title {
        color: #4e73df;
        font-weight: bold;
    }

    .modal-footer {
        border-top: 1px solid #e3e6f0;
    }

    /* Estilos según el tipo de movimiento */
    .ingreso .guardar-btn {
        background-color: #28a745;
        color: white;
    }

    .gasto .guardar-btn {
        background-color: #28a745;
        color: white;
    }

    /* Cambio de color del borde de monto según el tipo de movimiento */
    .ingreso #monto {
        border: 2px solid #28a745;
    }

    .gasto #monto {
        border: 2px solid #dc3545;
    }

    .editar-movimiento i {
        /* Un amarillo personalizado */
        color: #027bff;
        border: none;
    }

    .editar-movimiento:hover i {
        color: #2eb509f9;
    }
</style>
@stop


@section('content')
    @include('app_redes.modulos.caja_chica.view.contenido_caja_chica')
@stop

@section('js')
<script>
    // Abrir Modal ->
    $('#modalMovimiento').on('show.bs.modal', function(event) {

        var button = $(event.relatedTarget);
        var tipoMovimiento = button.data('tipo');

        var modal = $(this);

        // Agregar o remover clases según el tipo de movimiento
        if (tipoMovimiento === 'ingreso') {
            modal.addClass('ingreso').removeClass('gasto');
        } else {
            modal.addClass('gasto').removeClass('ingreso');
        }

        // Verifica si hay un id (modo edición)
        var isEditMode = button.data('id') !== undefined;

        // Mostrar u ocultar botones
        $('#btnGuardar').toggleClass('d-none', isEditMode);
        $('#btnActualizar').toggleClass('d-none', !isEditMode);
        $('#btnEliminar').toggleClass('d-none', !isEditMode);

        // Si estamos en edición, cargar los datos en el modal
        if (isEditMode) {
            $('#tipoMovimiento').val(tipoMovimiento);
            $('#monto').val(button.data('monto'));
            $('#descripcion').val(button.data('descripcion'));
            $('#modalMovimiento').data('id', button.data('id'));
            $('#id_usuario').val(button.data('id_usuario'));
            $('#comprobanteImage').attr('src', 'https://andamiosligeros.com/storage/comprobantes/' + button.data('comprobante'));
        } else {
            $('#tipoMovimiento').val('');
            $('#monto').val('');
            $('#descripcion').val('');
            $('#id_movimiento').val('');
            $('#modalMovimiento').removeData('id');
            $('#id_usuario').val('');
            $('#comprobanteImage').attr('src', '');
        }

        // Extraer datos del botón y asignarlos al modal
        var id = button.data('id');
        var fecha = button.data('fecha');
        var descripcion = button.data('descripcion');
        var monto = button.data('monto');
        var tipoMovimiento = button.data('tipo'); 
        var idUsuario = button.data('id_usuario');

        // Asignar datos a los campos del formulario
        modal.find('#tipoMovimiento').val(tipoMovimiento);
        modal.find('#monto').val(monto);
        modal.find('#descripcion').val(descripcion);
        modal.find('#tipoMovimiento').val(tipoMovimiento);
        modal.find('#id_movimiento').val(id);
        modal.find('#id_usuario').val(idUsuario)

        // Cambiar el título del modal según el tipo de movimiento
        modal.find('.modal-title').text(tipoMovimiento.charAt(0).toUpperCase() + tipoMovimiento.slice(1));
    });

    // -------- USO DE userCajaChica -------- //
    // Actualizamos caja chica por usuario ID
    function actualizarCajaChica() {
        var usuarioId = $('#usuarioSelect').val();
        if (usuarioId) {
            var data_json = {
                "accion": "userCajaChica",
                "datos": {
                    id: usuarioId,
                    fecha_inicio: '',
                    fecha_fin: '',
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_caja_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    // Validamos si la respuesta
                    if (result.status === 'success') {


                        // actualizar la tabla de historial
                        actualizarHistorial(result.historial);

                        // Actualizar ingresos
                        $('#ingresos').text('$' + (parseFloat(result.ingresos) || 0).toFixed(2));

                        // Actualizar gastos
                        $('#gastos').text('$' + (parseFloat(result.gastos) || 0).toFixed(2));

                        // Actualizar saldo
                        $('#saldo').text('$' + (parseFloat(result.saldo) || 0).toFixed(2));

                        // Actualizar movimientos recientes
                        $('#movRecientes').empty();
                        result.movRecientes.forEach(movimiento => {

                            let descripcionLimitada = movimiento.descripcion.length > 35 ?
                                movimiento.descripcion.substring(0, 40) + '...' :
                                movimiento.descripcion;

                            // Determinar clase y símbolo según tipo de movimiento
                            let badgeClass = movimiento.tipo_movimiento === 'ingreso' ?
                                'badge-success' : 'badge-danger';
                            let signo = movimiento.tipo_movimiento === 'ingreso' ? '+' : '-';

                            // Agregar el movimiento al contenedor
                            $('#movRecientes').append(
                                `<li class="list-group-item d-flex justify-content-between align-items-center">
                                ${descripcionLimitada}
                                <span class="badge badge-pill ${badgeClass}">
                                    ${signo}$${parseFloat(movimiento.monto).toFixed(2)} MXN
                                </span>
                            </li>`
                            );
                        });


                    } else {
                        alert('Ocurrió un error inesperado.');
                    }
                },
                error: function(error) {
                    console.log(error);
                    alert('Hubo un problema al guardar el movimiento. Por favor, intenta nuevamente.');
                }
            });
        }
    }

    //utilizamos el paginador
    function cargarPagina(url) {
        var data_json = {
            "accion": "userCajaChica",
            "datos": {
                id: $('#usuarioSelect').val() // Aquí selecciona el ID del usuario desde el select
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: url,
            type: 'post',
            datatype: 'json',
            success: function(result) {
                if (result.status === 'success') {
                    actualizarHistorial(result.historial);
                } else {
                    alert('Ocurrió un error inesperado.');
                }
            },
            error: function(error) {
                console.log(error);
                alert('Hubo un problema al cargar la página de historial.');
            }
        });
    }

        //Filtros de fechas -> 
    function filtrarPorFechas() {
        var fecha_inicio = $('#fechaInicio').val();
        var fecha_fin = $('#fechaFin').val();
        var id_usuario = $('#usuarioSelect').val();

        if (id_usuario == '' || id_usuario == null) {
            id_usuario = '{{ \Auth::User()->id }}';
        }
        // Enviamos los datos al controlador para filtrar
        var data_json = {
            "accion": "userCajaChica",
            "datos": {
                id: id_usuario,
                fecha_inicio: fecha_inicio,
                fecha_fin: fecha_fin,
            }
        };

        // console.log('$data_json :>> ', data_json);

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_caja_ajax') }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function() {},
            success: function(result) {
                // Validamos si la respuesta
                if (result.status === 'success') {


                    // actualizar la tabla de historial
                    actualizarHistorial(result.historial);

                    // Actualizar ingresos
                    $('#ingresos').text('$' + (parseFloat(result.ingresos) || 0).toFixed(2));

                    // Actualizar gastos
                    $('#gastos').text('$' + (parseFloat(result.gastos) || 0).toFixed(2));

                    // Actualizar saldo
                    $('#saldo').text('$' + (parseFloat(result.saldo) || 0).toFixed(2));

                    // Actualizar movimientos recientes
                    $('#movRecientes').empty();
                    result.movRecientes.forEach(movimiento => {

                        let descripcionLimitada = movimiento.descripcion.length > 35 ?
                            movimiento.descripcion.substring(0, 40) + '...' :
                            movimiento.descripcion;

                        // Determinar clase y símbolo según tipo de movimiento
                        let badgeClass = movimiento.tipo_movimiento === 'ingreso' ?
                            'badge-success' : 'badge-danger';
                        let signo = movimiento.tipo_movimiento === 'ingreso' ? '+' : '-';

                        // Agregar el movimiento al contenedor
                        $('#movRecientes').append(
                            `<li class="list-group-item d-flex justify-content-between align-items-center">
                                ${descripcionLimitada}
                                <span class="badge badge-pill ${badgeClass}">
                                    ${signo}$${parseFloat(movimiento.monto).toFixed(2)} MXN
                                </span>
                            </li>`
                        );
                    });


                } else {
                    alert('Ocurrió un error inesperado.');
                }
            },
            error: function(error) {
                console.log(error);
                alert('Hubo un problema al guardar el movimiento. Por favor, intenta nuevamente.');
            }
        });
    }
    // -------- TERMINA USO DE userCajaChica -------- //

    //actualizamos la tabla
    function actualizarHistorial(historial) {
        if (historial && Array.isArray(historial.data)) {
            // Limpiar el tbody
            $('#tabla_caja_chica').empty();

            // Generar las filas de movimientos
            historial.data.forEach(movimiento => {
                const tipoMovimientoClass = movimiento.tipo_movimiento === 'ingreso' ? 'text-success' :
                    'text-danger';
                const tipoMovimientoText = movimiento.tipo_movimiento.charAt(0).toUpperCase() + movimiento
                    .tipo_movimiento.slice(1);

                $('#tabla_caja_chica').append(`
                 <tr>
                    <td>${new Date(movimiento.fecha).toLocaleDateString()}</td>
                    <td style="text-transform: uppercase;">${movimiento.descripcion}</td>
                    <td><span class="font-weight-bold">$${parseFloat(movimiento.monto).toFixed(2)}</span></td>
                    <td><span style="text-transform: uppercase;" class="${tipoMovimientoClass}">${tipoMovimientoText}</span></td>
                     <td>
                         <button title="Editar" class="btn rounded-circle btn-sm editar-movimiento" data-toggle="modal"
                                 data-target="#modalMovimiento" data-id="${movimiento.id}"
                                 data-fecha="${movimiento.fecha}" data-descripcion="${movimiento.descripcion}"
                                 data-monto="${movimiento.monto}" data-comprobante="${movimiento.comprobante}" 
                                 data-tipo="${movimiento.tipo_movimiento}" data-id_usuario="${movimiento.user_id}"
                                 >
                             <i class="fas fa-edit"></i>
                         </button>
                     </td>
                 </tr>`);
            });

            // Generar paginación
            const paginationHtml =
                `
                <tr>
                 <td colspan="6" class="text-center">
                    ${historial.prev_page_url ? `<button onclick="cargarPagina('${historial.prev_page_url}')" class="btn btn-primary btn-sm">Anterior</button>` : ''}
                    ${historial.next_page_url ? `<button onclick="cargarPagina('${historial.next_page_url}')" class="btn btn-primary btn-sm">Siguiente</button>` : ''}
                 </td>
                </tr>
                `;
            $('#tabla_caja_chica').append(paginationHtml);
        } else {
            console.error('El historial no contiene un arreglo en data:', historial);
        }
    }

    // -------- USO DE guardarRegistro -------- //
    // validamos los datos ingresados en el modal
    function validarDatosModal() {
        var usuarioId = $('#usuarioSelect').val();
        var tipoMovimiento = $('#tipoMovimiento').val();
        var monto = $('#monto').val();
        var descripcion = $('#descripcion').val();
        var id = $('#id_movimiento').val();
        var idUsuarioRegistro = $('#id_usuario').val();

        // Validar que todos los campos estén completos
        if (!tipoMovimiento || tipoMovimiento === "") {
            alert('Por favor, selecciona un tipo de movimiento.');
            return;
        }

        if (!monto || monto <= 0) {
            swal("Error", "Por favor, ingresa un monto válido.", "error");
            return;
        }

        if (!descripcion || descripcion.trim() === "") {
            swal("Error", "Por favor, ingresa una descripción.", "error");
            return;
        }

        if (id === "") {
            if (usuarioId == null && id == "") {
                console.log('registro nuevo :>> ');
                // Crear un registro 
                guardarRegistro(tipoMovimiento, monto, descripcion);

            } else {
                console.log('registro para :>> ', usuarioId);
                // Crear un registro con usuario específico
                guardarRegistroUsuario(usuarioId, tipoMovimiento, monto, descripcion);
            }

        } else {
            // Actualizar el registro existente
            console.log('registro actualizado  :>>');
            actualizarRegistro(id, tipoMovimiento, monto, descripcion, idUsuarioRegistro);
        }
    }

    // Guardar registro con usuario  ->
    function guardarRegistroUsuario(id_user, t_movi, monto, desc) {
        var formData = new FormData();
        formData.append('accion', 'guardarRegistro');
        formData.append('id_user', id_user);
        formData.append('tipo_movimiento', t_movi);
        formData.append('monto', monto);
        formData.append('descripcion', desc);

        // Adjuntar el archivo del comprobante
        var comprobante = $('#comprobante')[0].files[0];
        if (comprobante) {
            formData.append('comprobante', comprobante);
        }

        ajaxSetup();
        $.ajax({
            url: '{{ route('path_caja_ajax') }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btnGuardar').text('Guardando...');
                $('#btnGuardar').attr('disabled', 'true');
            },
            success: function(result) {
                // Validamos si la respuesta
                if (result.status === 'success') {

                    // Limpiamos el formulario
                    $('#tipoMovimiento').val('');
                    $('#monto').val('');
                    $('#descripcion').val('');

                    // Cerramos el modal
                    $('#modalMovimiento').modal('hide');

                    // Mostramos alerta de éxito
                    swal({
                        title: result.message,
                        text: " ",
                        icon: "success",
                        timer: 1000,
                        buttons: false
                    }).then(() => {
                        // Actualizamos
                        location.reload();
                    });

                } else {
                    alert('Ocurrió un error inesperado.');
                }
            },
            error: function(error) {
                console.error(error);
                alert('Hubo un problema al guardar el movimiento. Por favor, intenta nuevamente.');
            }
        });
    }

    // Guardar registro  ->
    function guardarRegistro(t_movi, monto, desc) {
        var formData = new FormData();
        formData.append('accion', 'guardarRegistro');
        formData.append('id_user', 0);
        formData.append('tipo_movimiento', t_movi);
        formData.append('monto', monto);
        formData.append('descripcion', desc);

        // Adjuntar el archivo del comprobante
        var comprobante = $('#comprobante')[0].files[0];
        if (comprobante) {
            formData.append('comprobante', comprobante);
        }

        ajaxSetup();
        $.ajax({
            url: '{{ route('path_caja_ajax') }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btnGuardar').text('Guardando...');
                $('#btnGuardar').attr('disabled', 'true');
            },
            success: function(result) {
                // Validamos si la respuesta
                if (result.status === 'success') {

                    // Limpiamos el formulario
                    $('#tipoMovimiento').val('');
                    $('#monto').val('');
                    $('#descripcion').val('');

                    // Cerramos el modal
                    $('#modalMovimiento').modal('hide');

                    // Mostramos alerta de éxito
                    swal({
                        title: result.message,
                        text: " ",
                        icon: "success",
                        timer: 1000,
                        buttons: false
                    }).then(() => {
                        // Actualizamos
                        location.reload();
                    });

                } else {
                    console.log(result)
                    alert('Ocurrió un error inesperado.');
                }
            },
            error: function(error) {
                console.error(error);
                alert('Hubo un problema al guardar el movimiento. Por favor, intenta nuevamente.');
            }
        });
    }
    // -------- TERMINA USO DE guardarRegistro -------- //

    // -------- USO DE actualizarRegistro y eliminarRegistro -------- //
    // Actualizar registro  ->
    function actualizarRegistro(id, t_movi, monto, desc, id_usuario) {
        var formData = new FormData();
        formData.append('accion', 'actualizarRegistro');
        formData.append('id', id);
        formData.append('tipo_movimiento', t_movi);
        formData.append('monto', monto);
        formData.append('descripcion', desc);
        formData.append('id_user', id_usuario);

        // Adjuntar el archivo del comprobante
        var comprobante = $('#comprobante')[0].files[0];
        if (comprobante) {
            formData.append('comprobante', comprobante);
        }

        ajaxSetup();
        $.ajax({
            url: '{{ route('path_caja_ajax') }}',
            type: 'post',
            data: formData,
            contentType: false,
            processData: false,
            beforeSend: function () {
                $('#btnActualizar').text('Actualizando...');
                $('#btnActualizar').attr('disabled', 'true');
            },
            success: function(result) {
                // Validamos si la respuesta
                if (result.status === 'success') {

                    // Limpiamos el formulario
                    $('#tipoMovimiento').val('');
                    $('#monto').val('');
                    $('#descripcion').val('');

                    // Cerramos el modal
                    $('#modalMovimiento').modal('hide');

                    // Mostramos alerta de éxito
                    swal({
                        title: result.message,
                        text: " ",
                        icon: "success",
                        timer: 1200,
                        buttons: false
                    }).then(() => {
                        // Actualizamos
                        location.reload();
                    });

                } else {
                    alert('Ocurrió un error inesperado.');
                }
            },
            error: function(error) {
                console.error(error);
                alert('Hubo un problema al actualizar el movimiento. Por favor, intenta nuevamente.');
            }
        });
    }

    // Elimina registro  ->
    function eliminarRegistro() {

        // Obtenemos el id del registro a eliminar
        var id = $('#id_movimiento').val();

        // Mostramos la alerta de confirmación
        swal({
            title: "¿Estás seguro?",
            text: "Una vez eliminado, no podrás recuperar este registro.",
            icon: "warning",
            buttons: ["Cancelar", "Eliminar"],
            dangerMode: true,
        }).then((confirmDelete) => {
            // usuario confirma
            if (confirmDelete) {
                var data_json = {
                    "accion": "eliminarRegistro",
                    "datos": {
                        id: id,
                    }
                };

                ajaxSetup();
                $.ajax({
                    data: data_json,
                    url: '{{ route('path_caja_ajax') }}',
                    type: 'post',
                    datatype: 'html',
                    beforeSend: function () {
                        $('#btnEliminar').text('Eliminando...')
                        $('#btnEliminar').attr('disabled', 'true')
                      },
                    success: function(result) {
                        // Validamos si la respuesta fue exitosa
                        if (result.status === 'success') {

                            // Limpiamos el formulario
                            $('#tipoMovimiento').val('');
                            $('#monto').val('');
                            $('#descripcion').val('');

                            // Cerramos el modal
                            $('#modalMovimiento').modal('hide');

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
    // -------- TERMINA USO DE actualizarRegistro y eliminarRegistro -------- //
</script>
@stop