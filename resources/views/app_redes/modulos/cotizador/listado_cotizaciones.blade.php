@extends('layouts.app_redes')
@section('css')
<style>
    ul.pagination {
        padding: 0 !important;
        margin: 0 !important;
    }

    .info-det-coti>td {
        padding: 0 !important;
        border: 0 !important;
    }

    .text-black {
        color: black;
    }

    .j-forms .radio-toggle,
    .checkbox-toggle,
    .j-forms .inline-group .radio-toggle,
    .checkbox-toggle {
        padding: 0px 0 0px 20px !important;
    }

    .relative {
        position: relative;
        display: block !important;
    }

    .porcent {
        font-size: 9px;
        width: auto;
        background: #ffa200;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: bold;
        padding: 1px 5px;
        margin: 0 5px;
        border-radius: 4px;
    }

    .btn-md {
        border-radius: 0.2rem;
    }

    table.dataTable tbody tr.selected>* {
        box-shadow: inset 0 0 0 9999px rgb(13 110 253 / 90%);
        color: white;
    }

    .btn-success {
        color: #fff !important;
        background-color: #1cc88a !important;
        border-color: #1cc88a !important;
    }

    .btn-info {
        color: #fff !important;
        background-color: #36b9cc !important;
        border-color: #36b9cc !important;
    }

    .checkbox-toggle i {
        border: 2px solid rgb(51 122 183);
    }

    .disabled i:before {
        background: #bdbdbd;
    }

    .disabled input:checked+i {
        border: 2px solid #bdbdbd;
    }

    .aceptada i:before {
        background: #1cc88a;
    }

    .aceptada input:checked+i {
        border: 2px solid #1cc88a;
    }

    .pendiente i:before {
        background: #f6c23e;
    }

    .pendiente input:checked+i {
        border: 2px solid #f6c23e;
    }

    .info-cotizacion {
        transition: background-color 0.15s ease-in-out;
    }

    .info-cotizacion:hover {
        background-color: #f1f5f9 !important;
    }

    .aceptada {
        cursor: no-drop;
    }

    .table td,
    .table th {
        padding: 0.5rem 0.4rem;
        vertical-align: middle;
    }

    /* Botón desplegable circular de productos */
    .btn-toggle-det {
        transition: all 0.2s ease-in-out;
        box-shadow: 0 1px 2px rgba(0,0,0,0.06);
    }

    .btn-toggle-det:hover,
    .btn-toggle-det.active {
        background-color: #0948AF !important;
        color: #fff !important;
        border-color: #0948AF !important;
        transform: scale(1.08);
    }

    /* DateRangePicker personalización */
    .daterangepicker .ranges li.active {
        background-color: #0948AF !important;
    }
    .daterangepicker td.active, .daterangepicker td.active:hover {
        background-color: #0948AF !important;
    }
    .daterangepicker .applyBtn {
        background-color: #0948AF !important;
        border-color: #0948AF !important;
    }

    /* Dropdown menú mejoras */
    .btn-dropdown-fix {
        text-align: left;
        padding: 6px 14px;
        font-size: 0.82rem;
        border-radius: 4px;
        margin-bottom: 2px;
    }

    #tabla_cotizaciones>tbody>tr>td:nth-child(7) label {
        margin: 0 auto;
    }
</style>
<link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.css" />
@stop
@section('content')
@include('app_redes.modulos.cotizador.contenido_listado_cotizaciones')
@include('app_redes.modulos.modales.modales')
@stop

@section('js')
<script type="text/javascript" src="https://cdn.jsdelivr.net/momentjs/latest/moment.min.js"></script>
<script type="text/javascript" src="https://cdn.jsdelivr.net/npm/daterangepicker/daterangepicker.min.js"></script>
<script>
    /* Utilidad debounce */
    function debounce(func, wait) {
        var timeout;
        return function() {
            var context = this, args = arguments;
            clearTimeout(timeout);
            timeout = setTimeout(function() {
                func.apply(context, args);
            }, wait);
        };
    }

    /* Trabajando con paginado vía hash */
    $(window).on('hashchange', function () {
        if (window.location.hash) {
            var page = window.location.hash.replace('#', '');
            if (page == Number.NaN || page <= 0) {
                return false;
            } else {
                getTablaCotizaciones(page);
            }
        }
    });

    $(document).ready(function () {
        // Inicialización de DateRangePicker único
        $('#filtro_rango_fechas').daterangepicker({
            autoUpdateInput: false,
            opens: 'left',
            maxDate: moment(),
            ranges: {
                'Hoy': [moment(), moment()],
                'Ayer': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                'Últimos 7 días': [moment().subtract(6, 'days'), moment()],
                'Últimos 30 días': [moment().subtract(29, 'days'), moment()],
                'Este mes': [moment().startOf('month'), moment()],
                'Mes anterior': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            locale: {
                format: 'YYYY-MM-DD',
                separator: ' al ',
                applyLabel: 'Aplicar',
                cancelLabel: 'Limpiar',
                fromLabel: 'Desde',
                toLabel: 'Hasta',
                customRangeLabel: 'Personalizado',
                daysOfWeek: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
                monthNames: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre', 'Noviembre', 'Diciembre'],
                firstDay: 1
            }
        });

        // Aplicar rango de fechas seleccionado
        $('#filtro_rango_fechas').on('apply.daterangepicker', function(ev, picker) {
            $(this).val(picker.startDate.format('YYYY-MM-DD') + ' al ' + picker.endDate.format('YYYY-MM-DD'));
            $('#fecha_inicio').val(picker.startDate.format('YYYY-MM-DD'));
            $('#fecha_fin').val(picker.endDate.format('YYYY-MM-DD'));
            getTablaCotizaciones(1);
        });

        // Limpiar rango de fechas
        $('#filtro_rango_fechas').on('cancel.daterangepicker', function(ev, picker) {
            $(this).val('');
            $('#fecha_inicio').val('');
            $('#fecha_fin').val('');
            getTablaCotizaciones(1);
        });

        // Click en icono de calendario para abrir picker
        $(document).on('click', '#btn-icono-calendario', function() {
            $('#filtro_rango_fechas').trigger('click');
        });

        // Paginación click
        $(document).on('click', '.pagination a', function (e) {
            e.preventDefault();
            var href = $(this).attr('href');
            if (href && href.indexOf('page=') !== -1) {
                getTablaCotizaciones(href.split('page=')[1]);
            }
        });

        // Cambio de tamaño de página
        $(document).on("change", "#change-page-size", function () {
            getTablaCotizaciones(1);
        });

        // Cambio de filtro estatus
        $(document).on("change", "#filtro_status", function () {
            getTablaCotizaciones(1);
        });

        // Búsqueda general con debounce
        $(document).on("input", "#filtrar_busqueda", debounce(function () {
            getTablaCotizaciones(1);
        }, 300));

        // Filtrar por vendedor con debounce
        $(document).on("input", "#filtro_usuario", debounce(function () {
            getTablaCotizaciones(1);
        }, 300));

        // Botón Limpiar Filtros
        $(document).on("click", "#btn-limpiar-filtros", function (e) {
            e.preventDefault();
            $('#filtrar_busqueda').val('');
            $('#filtro_usuario').val('');
            $('#filtro_status').val('');
            $('#filtro_rango_fechas').val('');
            $('#fecha_inicio').val('');
            $('#fecha_fin').val('');
            $('#change-page-size').val('10');
            getTablaCotizaciones(1);
        });

        // Botón Exportar Excel (servidor con dataset completo)
        $(document).on("click", "#exportarExcel", function (e) {
            e.preventDefault();
            var params = $.param({
                filtrar_busqueda: $('#filtrar_busqueda').val(),
                filtro_usuario: $('#filtro_usuario').val(),
                filtro_status: $('#filtro_status').val(),
                fecha_inicio: $('#fecha_inicio').val(),
                fecha_fin: $('#fecha_fin').val()
            });
            window.location.href = '{{ route("path_exportar_cotizaciones") }}?' + params;
        });

        // Indicador de colapso de productos (+ / -)
        $(document).on('show.bs.collapse', '.collapse', function () {
            var id = $(this).attr('id');
            $('button[data-target="#' + id + '"]').addClass('active').find('i').removeClass('fa-plus').addClass('fa-minus');
        });

        $(document).on('hide.bs.collapse', '.collapse', function () {
            var id = $(this).attr('id');
            $('button[data-target="#' + id + '"]').removeClass('active').find('i').removeClass('fa-minus').addClass('fa-plus');
        });
    });

    $(document).on("click", "#confirm_desactiva_cliente", openConfirmDelete);
    $(document).on("click", "#confirm_activa_cliente", openConfirmActiva);
    $(document).on("click", "#confirm_elimina_cliente", openConfirmElimina);
    $(document).on("click", "#genera_qr", openGeneraQR);
    $(document).on("click", "#open_confirm_venta", OpenConfirmVenta);
    $(document).on("click", "#open_edit", enviaIdEdit);
    $(document).on("click", "#activa_mp", activaMercadoPago);

    function activaMercadoPago() {
        var id_cotizacion = $(this).attr("data-id-coti");
        if ($(this).is(":checked")) {
            var st_mp = "si";
        } else {
            var st_mp = "no";
        }
        var data_json = {
            "accion": "activaMercadoPago",
            "datos": {
                "id_cotizacion": id_cotizacion,
                "st_mp": st_mp
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
                $(".activado" + id_cotizacion).attr("disabled", "disabled");
            },
            success: function (result) {
                getTablaCotizaciones();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function enviaIdEdit(e) {
        e.preventDefault();
        var id_cliente = $(this).attr('id-cliente');
        openEdit(id_cliente);
    }

    function getTablaCotizaciones(page) {
        if (page == undefined) {
            var page = 1;
            if ($('ul.pagination').is(":visible")) {
                if ($('ul.pagination li').hasClass("active") == true) {
                    page = $('ul.pagination .active').text();
                }
            }
        }

        var max_row = $('#change-page-size').val();
        var filtro_status = $('#filtro_status').val();
        var filtrar_busqueda = $('#filtrar_busqueda').val();
        var filtro_usuario = $('#filtro_usuario').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();

        var data_json = {
            "accion": "getTablaCotizaciones",
            "page": page,
            "datos": {
                "max_row": max_row,
                "filtro_status": filtro_status,
                "filtrar_busqueda": filtrar_busqueda,
                "filtro_usuario": filtro_usuario,
                "fecha_inicio": fecha_inicio,
                "fecha_fin": fecha_fin,
            }
        };

        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
                $("#tabla_cotizaciones").css('opacity', '0.4');
            },
            success: function (result) {
                $("#tabla_cotizaciones").css('opacity', '1').html(result);
                var newTotal = $("#hidden-coti-total").text();
                if (newTotal !== undefined && newTotal !== "") {
                    $("#counter-val").text(newTotal);
                }
            },
            error: function (error) {
                $("#tabla_cotizaciones").css('opacity', '1');
                console.log(error);
            }
        });
    }

    // Abre confirmación de venta -> init
    function OpenConfirmVenta(e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion": "openConfirmInfo",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_ajax_cotizador') }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estás seguro?",
                    text: "Se realizará la venta de la cotización: " + cod_cotizacion,
                    icon: "info",
                    buttons: true,
                    successMode: true,
                    buttons: ["Cancelar", "Sí, Vender ahora"],
                })
                .then((willVende) => {
                    if (willVende) {
                        getMetodosPago(id_coti);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // GET métodos pago
    function getMetodosPago(id) {
        let id_coti = id;
        var data_json = {
            "accion": "getMetodosPago"
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_ajax_cotizador') }}',
            type: 'post',
            datatype: 'json',
            beforeSend: function () { },
            success: function (result) {
                selectMetodosPago(result, id_coti);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Filtramos y mostramos el select de métodos de pago
    function selectMetodosPago(m, id) {
        var id_coti = id;
        var metodosPago = m.filter(function (metodo) {
            return metodo.estatus == 1;
        });

        const select = document.createElement('select');
        select.className = 'styled-select';
        metodosPago.forEach(method => {
            const option = document.createElement('option');
            option.value = method.cod_tipo_cobro;
            option.textContent = method.nombre;
            select.appendChild(option);
        });

        swal({
            title: "Selecciona el método de pago : ",
            icon: "info",
            content: select,
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                const id_metodo_pago = select.options[select.selectedIndex].value;
                confirmVende(id_coti, id_metodo_pago);
            }
        });
    }

    // Confirmamos venta
    function confirmVende(id_coti, id_metodo) {
        var data_json = {
            "accion": "confirmVende",
            "datos": {
                "id_coti": id_coti,
                "cod_met": id_metodo,
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_ajax_cotizador') }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("¡Éxito!", "¡Se generó la venta correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
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
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estás seguro?",
                    text: "Si confirma se desactivará la cotización para el cliente: " + cod_cotizacion,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Sí, Desactivar ahora"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        confirmDesactiva(id_coti);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function openGeneraQR(e) {
        e.preventDefault();
        var id_coti = $(this).attr("data-id-coti");
        var data_json = {
            "accion": "openConfirmInfo",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "Se generará código QR de " + cod_cotizacion,
                    text: "Podrá verlo al descargar la cotización como PDF",
                    icon: "info",
                    buttons: true,
                    dangerMode: false,
                    buttons: ["Cancelar", "Sí, Generar QR ahora"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        generaQR(id_coti);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function generaQR(id_coti) {
        var data_json = {
            "accion": "generaQR",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("¡Éxito!", "¡Se ha generado el QR correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function confirmDesactiva(id_coti) {
        var data_json = {
            "accion": "confirmDesactiva",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("¡Éxito!", "¡Se ha desactivado correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
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
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estás seguro?",
                    text: "Si confirma se activará la cotización para el cliente: " + cod_cotizacion,
                    icon: "warning",
                    buttons: true,
                    dangerMode: false,
                    buttons: ["Cancelar", "Sí, Activar ahora"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        confirmActiva(id_coti);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function confirmActiva(id_coti) {
        var data_json = {
            "accion": "confirmActiva",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("¡Éxito!", "¡Se ha activado correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
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
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estás seguro?",
                    text: "Si confirma se ELIMINARÁ permanentemente la cotización: " + cod_cotizacion,
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                    buttons: ["Cancelar", "Sí, ELIMINAR ahora"],
                })
                .then((willDelete) => {
                    if (willDelete) {
                        confirmElimina(id_coti);
                    }
                });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    function confirmElimina(id_coti) {
        var data_json = {
            "accion": "confirmElimina",
            "datos": {
                "id_coti": id_coti
            }
        };
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("¡Éxito!", "¡Se ha eliminado permanentemente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
                console.log(error);
            }
        });
    }
</script>
@include('app_redes.includes.script_clientes')
@stop