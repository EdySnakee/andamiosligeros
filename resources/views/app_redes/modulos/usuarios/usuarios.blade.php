@extends('layouts.app_redes')
@section('css')
<style>
  .btn-action-desactiva:hover { background-color: #fdf2e9; color: #d35400; }
  .btn-action-activa:hover { background-color: #eafaf1; color: #27ae60; }
  .btn-action-delete:hover { background-color: #fdedec; color: #c0392b; }
  .table-hover tbody tr:hover { background-color: rgba(78, 115, 223, 0.04); }
  .table td, .table th { vertical-align: middle; }
</style>
@stop
@section('content')
    @include('app_redes.modulos.usuarios.contenido_usuarios')
@stop

@section('js')
<script>
    var currentPage = 1;
    var searchTimer = null;

    $(document).ready(function() {
        // Paginación por clic
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            if (href && href.indexOf('page=') !== -1) {
                var page = href.split('page=')[1];
                currentPage = page;
                getTablaUsuarios(page);
            }
        });

        // Buscador con debounce
        $(document).on('input', '#buscar_usuario', function () {
            clearTimeout(searchTimer);
            searchTimer = setTimeout(function () {
                currentPage = 1;
                getTablaUsuarios(1);
            }, 350);
        });

        $(document).on('keypress', '#buscar_usuario', function (e) {
            if (e.which === 13) {
                e.preventDefault();
                clearTimeout(searchTimer);
                currentPage = 1;
                getTablaUsuarios(1);
            }
        });

        // Filtro por Rol, Estatus y Tamaño de Página
        $(document).on('change', '#filtro_rol, #filtro_estatus, #change-page-size', function () {
            currentPage = 1;
            getTablaUsuarios(1);
        });

        // Botón Limpiar Filtros
        $(document).on('click', '#btn_limpiar_filtros', function () {
            $('#buscar_usuario').val('');
            $('#filtro_rol').val('todos');
            $('#filtro_estatus').val('todos');
            $('#change-page-size').val('10');
            currentPage = 1;
            getTablaUsuarios(1);
        });

        // Abrir Modal Agregar Usuario
        $(document).on('click', '#btn_open_add_user', function (e) {
            e.preventDefault();
            openModalUser('agregar');
        });

        // Cambio de rol en el modal para previsualización dinámica
        $(document).on('change', '#tipo_usuario', function () {
            actualizarPreviewPermisos($(this).val());
        });

        // Abrir Modal Editar Usuario
        $(document).on('click', '.btn-action-edit', function (e) {
            e.preventDefault();
            var id_usuario = $(this).attr('data-id-usr');
            openModalUser('editar', id_usuario);
        });

        // Guardar Usuario (Nuevo)
        $(document).on('click', '#btn_guardar_usuario', function (e) {
            e.preventDefault();
            guardarUsuario();
        });

        // Actualizar Usuario (Existente)
        $(document).on('click', '#btn_actualizar_usuario', function (e) {
            e.preventDefault();
            var id_usuario = $(this).attr('data-id-usuario');
            actualizarUsuario(id_usuario);
        });

        // Desactivar Usuario
        $(document).on('click', '.btn-action-desactiva', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id-usr');
            var name = $(this).attr('data-name-usr');
            confirmDesactiva(id, name);
        });

        // Activar Usuario
        $(document).on('click', '.btn-action-activa', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id-usr');
            var name = $(this).attr('data-name-usr');
            confirmActiva(id, name);
        });

        // Eliminar Usuario
        $(document).on('click', '.btn-action-delete', function (e) {
            e.preventDefault();
            var id = $(this).attr('data-id-usr');
            var name = $(this).attr('data-name-usr');
            confirmElimina(id, name);
        });
    });

    /**
     * Obtiene el listado de usuarios vía AJAX y actualiza la tabla.
     */
    function getTablaUsuarios(page) {
        if (page === undefined || page === null) {
            page = currentPage || 1;
        } else {
            currentPage = page;
        }

        var buscar = $('#buscar_usuario').val();
        var rol = $('#filtro_rol').val();
        var estatus = $('#filtro_estatus').val();
        var max_row = $('#change-page-size').val();

        var data_json = {
            "accion": "getTablaUsuarios",
            "page": page,
            "datos": {
                "buscar": buscar,
                "rol": rol,
                "estatus": estatus,
                "max_row": max_row,
                "page": page
            }
        };

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("ajax_usuarios_path") }}',
            type: 'post',
            dataType: 'html',
            beforeSend: function () {
                $('#tabla_usuarios').css('opacity', '0.5');
            },
            success: function (result) {
                $('#tabla_usuarios').css('opacity', '1');
                $('#tabla_usuarios').html(result);
            },
            error: function (xhr) {
                $('#tabla_usuarios').css('opacity', '1');
                console.error("Error al cargar la tabla de usuarios:", xhr);
            }
        });
    }

    /**
     * Abre el modal para crear o editar un usuario.
     */
    function openModalUser(accion, id_usuario) {
        var data_json = {
            "accion": "openModalUser",
            "datos": {
                "accion_usr": accion,
                "id_usuario": id_usuario || 0
            }
        };

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("ajax_usuarios_path") }}',
            type: 'post',
            dataType: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                $('#modal_app_redes').html(result);
                $('#modal_app_redes').modal({ backdrop: 'static', keyboard: false });
                actualizarPreviewPermisos($('#tipo_usuario').val());
            },
            error: function (xhr) {
                console.error("Error al abrir modal:", xhr);
                swal("Error", "No se pudo cargar el formulario de usuario.", "error");
            }
        });
    }

    /**
     * Valida y envía la petición para registrar un nuevo usuario.
     */
    function guardarUsuario() {
        var nombre = $.trim($('#nombre_usuario').val());
        var email = $.trim($('#email_usr').val());
        var tipo_usuario = $('#tipo_usuario').val();
        var password = $('#pass_usr').val();
        var pass_confirm = $('#pass_confirm').val();
        var alertBox = $('#modal_user_alert');

        if (alertBox.length) {
            alertBox.addClass('d-none').text('');
        }

        if (nombre === '') {
            mostrarErrorModal('Por favor ingresa el nombre completo del usuario.');
            $('#nombre_usuario').focus();
            return;
        }

        if (email === '' || !validarEmail(email)) {
            mostrarErrorModal('Por favor ingresa un correo electrónico válido.');
            $('#email_usr').focus();
            return;
        }

        if (password === '' || password.length < 6) {
            mostrarErrorModal('La contraseña debe tener al menos 6 caracteres.');
            $('#pass_usr').focus();
            return;
        }

        if (password !== pass_confirm) {
            mostrarErrorModal('Las contraseñas no coinciden. Por favor verifícalas.');
            $('#pass_confirm').focus();
            return;
        }

        var btn = $('#btn_guardar_usuario');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

        var data_json = {
            "accion": "addUser",
            "datos": {
                "nombre_usuario": nombre,
                "email_usr": email,
                "tipo_usuario": tipo_usuario,
                "password": password
            }
        };

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("ajax_usuarios_path") }}',
            type: 'post',
            dataType: 'json',
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Crear Usuario');
                if (res.success) {
                    $('#modal_app_redes').modal('hide');
                    swal("¡Excelente!", res.message || "Usuario creado exitosamente.", "success");
                    getTablaUsuarios(1);
                } else {
                    mostrarErrorModal(res.message || "Ocurrió un error al crear el usuario.");
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-check mr-1"></i> Crear Usuario');
                var msg = "Error al procesar la solicitud.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                mostrarErrorModal(msg);
            }
        });
    }

    /**
     * Valida y envía la petición para actualizar un usuario existente.
     */
    function actualizarUsuario(id_usuario) {
        var nombre = $.trim($('#nombre_usuario').val());
        var email = $.trim($('#email_usr').val());
        var tipo_usuario = $('#tipo_usuario').val();
        var password = $('#pass_usr').val();
        var pass_confirm = $('#pass_confirm').val();
        var alertBox = $('#modal_user_alert');

        if (alertBox.length) {
            alertBox.addClass('d-none').text('');
        }

        if (nombre === '') {
            mostrarErrorModal('Por favor ingresa el nombre completo del usuario.');
            $('#nombre_usuario').focus();
            return;
        }

        if (email === '' || !validarEmail(email)) {
            mostrarErrorModal('Por favor ingresa un correo electrónico válido.');
            $('#email_usr').focus();
            return;
        }

        if (password !== '' && password.length < 6) {
            mostrarErrorModal('Si deseas cambiar la contraseña, debe contener al menos 6 caracteres.');
            $('#pass_usr').focus();
            return;
        }

        if (password !== '' && password !== pass_confirm) {
            mostrarErrorModal('Las contraseñas no coinciden. Por favor verifícalas.');
            $('#pass_confirm').focus();
            return;
        }

        var btn = $('#btn_actualizar_usuario');
        btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

        var data_json = {
            "accion": "editUser",
            "datos": {
                "id_usuario": id_usuario,
                "nombre_usuario": nombre,
                "email_usr": email,
                "tipo_usuario": tipo_usuario,
                "password": password
            }
        };

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("ajax_usuarios_path") }}',
            type: 'post',
            dataType: 'json',
            success: function (res) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Cambios');
                if (res.success) {
                    $('#modal_app_redes').modal('hide');
                    swal("¡Actualizado!", res.message || "Usuario actualizado exitosamente.", "success");
                    getTablaUsuarios(currentPage);
                } else {
                    mostrarErrorModal(res.message || "Ocurrió un error al actualizar el usuario.");
                }
            },
            error: function (xhr) {
                btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Cambios');
                var msg = "Error al procesar la solicitud.";
                if (xhr.responseJSON && xhr.responseJSON.message) {
                    msg = xhr.responseJSON.message;
                }
                mostrarErrorModal(msg);
            }
        });
    }

    /**
     * Confirmación para desactivar usuario.
     */
    function confirmDesactiva(id_usuario, nombre) {
        swal({
            title: "¿Desactivar usuario?",
            text: "El usuario " + (nombre ? '"' + nombre + '"' : '') + " no podrá iniciar sesión en el panel mientras esté inactivo.",
            icon: "warning",
            buttons: ["Cancelar", "Sí, desactivar"],
            dangerMode: true,
        }).then(function (confirmar) {
            if (confirmar) {
                ajaxSetup();
                $.ajax({
                    data: {
                        "accion": "ConfirmDesactiva",
                        "datos": { "num_usuario": id_usuario }
                    },
                    url: '{{ route("ajax_usuarios_path") }}',
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            swal("¡Desactivado!", res.message || "Usuario desactivado.", "success");
                            getTablaUsuarios(currentPage);
                        } else {
                            swal("Aviso", res.message || "No se pudo desactivar.", "warning");
                        }
                    },
                    error: function (xhr) {
                        var msg = "No fue posible desactivar al usuario.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        swal("Error", msg, "error");
                    }
                });
            }
        });
    }

    /**
     * Confirmación para activar usuario.
     */
    function confirmActiva(id_usuario, nombre) {
        swal({
            title: "¿Activar usuario?",
            text: "El usuario " + (nombre ? '"' + nombre + '"' : '') + " podrá volver a ingresar al panel con sus credenciales.",
            icon: "info",
            buttons: ["Cancelar", "Sí, activar"],
        }).then(function (confirmar) {
            if (confirmar) {
                ajaxSetup();
                $.ajax({
                    data: {
                        "accion": "ConfirmActiva",
                        "datos": { "num_usuario": id_usuario }
                    },
                    url: '{{ route("ajax_usuarios_path") }}',
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            swal("¡Activado!", res.message || "Usuario activado.", "success");
                            getTablaUsuarios(currentPage);
                        } else {
                            swal("Aviso", res.message || "No se pudo activar.", "warning");
                        }
                    },
                    error: function (xhr) {
                        var msg = "No fue posible activar al usuario.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        swal("Error", msg, "error");
                    }
                });
            }
        });
    }

    /**
     * Confirmación para eliminar usuario permanentemente.
     */
    function confirmElimina(id_usuario, nombre) {
        swal({
            title: "¿Eliminar usuario permanentemente?",
            text: "¡Esta acción no se puede deshacer! El usuario " + (nombre ? '"' + nombre + '"' : '') + " será eliminado por completo.",
            icon: "error",
            buttons: ["Cancelar", "Sí, eliminar definitivamente"],
            dangerMode: true,
        }).then(function (confirmar) {
            if (confirmar) {
                ajaxSetup();
                $.ajax({
                    data: {
                        "accion": "ConfirmElimina",
                        "datos": { "num_usuario": id_usuario }
                    },
                    url: '{{ route("ajax_usuarios_path") }}',
                    type: 'post',
                    dataType: 'json',
                    success: function (res) {
                        if (res.success) {
                            swal("¡Eliminado!", res.message || "Usuario eliminado.", "success");
                            getTablaUsuarios(currentPage);
                        } else {
                            swal("Aviso", res.message || "No se pudo eliminar.", "warning");
                        }
                    },
                    error: function (xhr) {
                        var msg = "No fue posible eliminar al usuario.";
                        if (xhr.responseJSON && xhr.responseJSON.message) {
                            msg = xhr.responseJSON.message;
                        }
                        swal("Error", msg, "error");
                    }
                });
            }
        });
    }

    function mostrarErrorModal(msg) {
        $('#modal_user_alert').removeClass('d-none').html('<i class="fas fa-exclamation-triangle mr-1"></i> ' + msg);
    }

    /**
     * Actualiza la previsualización de permisos según el rol seleccionado.
     */
    function actualizarPreviewPermisos(rol) {
        var badgesContainer = $('#preview_permisos_badges');
        var resumenContainer = $('#preview_permisos_resumen');
        if (!badgesContainer.length) return;

        badgesContainer.empty();
        rol = (rol || '').toLowerCase();

        var modulos = [];
        var resumen = '';

        if (rol === 'admin') {
            modulos = [
                { nombre: 'Acceso Total', icono: 'fas fa-star', clase: 'badge-primary' },
                { nombre: 'Dashboard', icono: 'fas fa-tachometer-alt', clase: 'badge-light border' },
                { nombre: 'Producción / Taller', icono: 'fas fa-tools', clase: 'badge-light border' },
                { nombre: 'Cotizaciones', icono: 'fas fa-calculator', clase: 'badge-light border' },
                { nombre: 'Ventas', icono: 'fas fa-dollar-sign', clase: 'badge-light border' },
                { nombre: 'Inventario y Embarques', icono: 'fas fa-boxes', clase: 'badge-light border' },
                { nombre: 'Clientes', icono: 'fas fa-users', clase: 'badge-light border' },
                { nombre: 'Tienda en Línea', icono: 'fas fa-store', clase: 'badge-light border' },
                { nombre: 'Blog', icono: 'far fa-newspaper', clase: 'badge-light border' },
                { nombre: 'Promociones', icono: 'fa fa-percent', clase: 'badge-light border' },
                { nombre: 'Estadísticas', icono: 'fas fa-chart-bar', clase: 'badge-light border' },
                { nombre: 'Caja Chica', icono: 'fas fa-cash-register', clase: 'badge-light border' },
                { nombre: 'Usuarios', icono: 'fas fa-users-cog', clase: 'badge-light border' },
                { nombre: 'Herramientas', icono: 'fas fa-toolbox', clase: 'badge-light border' }
            ];
            resumen = 'Control total y acceso irrestricto a todos los módulos y configuraciones del panel.';
        } else if (rol === 'v1' || rol === 'vendedor' || rol === 'f1' || rol === 'n2') {
            modulos = [
                { nombre: 'Dashboard', icono: 'fas fa-tachometer-alt', clase: 'badge-info' },
                { nombre: 'Clientes', icono: 'fas fa-users', clase: 'badge-info' },
                { nombre: 'Cotizador', icono: 'fas fa-calculator', clase: 'badge-info' },
                { nombre: 'Ventas', icono: 'fas fa-dollar-sign', clase: 'badge-info' },
                { nombre: 'Taller (Seguimiento)', icono: 'fas fa-tools', clase: 'badge-info' }
            ];
            resumen = 'Orientado a ventas: cotización, cierre de órdenes, consulta de clientes y seguimiento en taller.';
        } else if (rol === 't1' || rol === 'taller') {
            modulos = [
                { nombre: 'Órdenes de Taller', icono: 'fas fa-tools', clase: 'badge-warning text-dark' },
                { nombre: 'Rastreo de Guías', icono: 'fas fa-truck', clase: 'badge-warning text-dark' },
                { nombre: 'Inventario', icono: 'fas fa-boxes', clase: 'badge-warning text-dark' },
                { nombre: 'Órdenes de Embarque', icono: 'fas fa-truck-loading', clase: 'badge-warning text-dark' },
                { nombre: 'Cotizaciones', icono: 'fas fa-calculator', clase: 'badge-warning text-dark' },
                { nombre: 'Ventas', icono: 'fas fa-dollar-sign', clase: 'badge-warning text-dark' }
            ];
            resumen = 'Aterriza directo en Taller. Control de producción, inventario matriz y consulta completa de ventas/cotizaciones.';
        } else {
            modulos = [
                { nombre: 'Sin módulos predefinidos', icono: 'fas fa-info-circle', clase: 'badge-secondary' }
            ];
            resumen = 'Perfil personalizado.';
        }

        $.each(modulos, function(i, mod) {
            var badgeHtml = '<span class="badge ' + mod.clase + ' mr-1 mb-1 px-2 py-1"><i class="' + mod.icono + ' mr-1"></i>' + mod.nombre + '</span>';
            badgesContainer.append(badgeHtml);
        });

        resumenContainer.html('<i class="fas fa-info-circle mr-1 text-primary"></i>' + resumen);
    }

    function validarEmail(email) {
        var re = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return re.test(email);
    }
</script>
@stop