@extends('layouts.app_redes')
@section('css')
<style>
    ul.pagination {
        padding: 0 !important;
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

    .info-cotizacion:hover {
        background: #76aaff !important;
        color: white !important;
    }

    .aceptada {
        cursor: no-drop;
    }

    .table td,
    .table th {
        padding: 0.3rem;
    }

    #tabla_cotizaciones>tbody>tr>td:nth-child(6) {
        display: flex;
        align-items: center;
        justify-content: center;
        padding-top: 1em;
    }

    #tabla_cotizaciones>tbody>tr>td:nth-child(7) label {
        margin: 0 auto;
    }
</style>
@stop
@section('content')
@include('app_redes.modulos.cotizador.contenido_listado_cotizaciones')
@include('app_redes.modulos.modales.modales')
@stop

@section('js')
<script src="https://cdn.sheetjs.com/xlsx-0.20.3/package/dist/xlsx.full.min.js"></script>
<script>
    $(document).ready(function () {
        $("#exportarExcel").click(function () {
            exportarCotizacionesExcel();
        });
    });

    function exportarCotizacionesExcel() {
        var headers = ['Código', 'Cliente', 'Lead', 'Sucursal', 'Fecha', 'Total', 'Estatus', 'Cotizó'];
        var data = [headers];

        // Only iterate the main summary rows (skip .info-det-coti detail rows)
        $('#tblPrincCoti tbody tr.info-cotizacion').each(function () {
            var cells = $(this).children('td');

            // COD: text from the first <a> in col 1
            var cod = cells.eq(1).find('a').first().text().trim();

            // Cliente: clone the cell, remove child elements (icon), get remaining text
            var clienteCell = cells.eq(2).clone();
            clienteCell.find('a, i').remove();
            var cliente = clienteCell.text().trim().replace(/\s+/g, ' ');

            // Lead: plain text from the link
            var lead = cells.eq(3).text().trim();

            // Sucursal: text of the span badge
            var sucursal = cells.eq(4).find('span').text().trim();

            // Fecha
            var fecha = cells.eq(5).text().trim();

            // Total: get the bold text, strip $ and commas to store as number
            var totalRaw = cells.eq(6).find('b.text-black').text().replace('$', '').replace(/,/g, '').trim();
            var total = parseFloat(totalRaw) || 0;

            // Estatus: text of the span badge
            var estatus = cells.eq(7).find('span').text().trim();

            // Cotizó: col 9 plain text
            var cotizo = cells.eq(9).text().trim();

            data.push([cod, cliente, lead, sucursal, fecha, total, estatus, cotizo]);
        });

        // Build worksheet from array of arrays
        var ws = XLSX.utils.aoa_to_sheet(data);

        // Column widths (characters)
        ws['!cols'] = [
            { wch: 18 },  // Código
            { wch: 32 },  // Cliente
            { wch: 14 },  // Lead
            { wch: 10 },  // Sucursal
            { wch: 14 },  // Fecha
            { wch: 14 },  // Total
            { wch: 12 },  // Estatus
            { wch: 24 },  // Cotizó
        ];

        // Format the Total column (F) as currency for every data row
        var range = XLSX.utils.decode_range(ws['!ref']);
        for (var R = 1; R <= range.e.r; R++) {
            var cellRef = XLSX.utils.encode_cell({ r: R, c: 5 }); // column F = index 5
            if (ws[cellRef] && typeof ws[cellRef].v === 'number') {
                ws[cellRef].z = '$#,##0.00';
            }
        }

        // Create workbook and write file
        var wb = XLSX.utils.book_new();
        XLSX.utils.book_append_sheet(wb, ws, 'Cotizaciones');

        var today = new Date();
        var dateStr = today.getFullYear() + '-' +
            String(today.getMonth() + 1).padStart(2, '0') + '-' +
            String(today.getDate()).padStart(2, '0');

        XLSX.writeFile(wb, 'Cotizaciones_' + dateStr + '.xlsx');
    }

    /*trabjando con paginado*/
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
        $(document).on('click', '.pagination a', function (e) {
            getTablaCotizaciones($(this).attr('href').split('page=')[1]);
            e.preventDefault();
        });
    });

    $(document).on("change", "#change-page-size", function () {
        //numero de datos
        getTablaCotizaciones();
    });

    $(document).on("keyup", "#filtrar_busqueda_venta", function (e) {
        //busqueda por venta
        getTablaCotizaciones();
    });

    $(document).on("keyup", "#filtrar_busqueda", function (e) {
        //busqueda por nombre de cliente
        getTablaCotizaciones();
    });

    // Filtrar por vendedor
    $(document).on("keyup", "#filtro_usuario", function (e) {
        //busqueda por nombre de cliente
        getTablaCotizaciones();
    });

    $(document).on("change", "#fecha_inicio, #fecha_fin", function (e) {
        // Obtener el valor de fecha de inicio y fecha fin
        var fechaInicio = $("#fecha_inicio").val();
        var fechaFin = $("#fecha_fin").val();

        // Validar si ambos campos tienen valores
        if (fechaInicio && fechaFin) {
            // Ambos campos tienen valores, puedes ejecutar la función
            getTablaCotizaciones();
        } else {
            // Si alguno de los campos está vacío, puedes mostrar un mensaje de error o realizar otra acción
            console.log("Por favor, completa ambos campos de fecha.");
        }
    });
    /*
    $(document).on("change","#giro_empresa",function(e){
        // busqueda por giro empresarial
        getTablaCotizaciones();
    });
    */

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
            var st_mp = "si"
        }
        else {
            var st_mp = "no"
        }
        var data_json = {
            "accion": "activaMercadoPago",
            "datos": {
                "id_cotizacion": id_cotizacion,
                "st_mp": st_mp
            }
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
                $(".activado" + id_cotizacion).attr("disabled", "disabled")
            },
            success: function (result) {
                getTablaCotizaciones();
                // $('#tabla_cotizaciones').DataTable().ajax.reload();
                //$(".activado"+id_cotizacion).removeAttr("disabled")
            },
            error: function (error) {
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
            var page = 0;
            if ($('ul.pagination').is(":visible")) {
                if ($('ul.pagination li').hasClass("active") == true) {
                    page = $('ul.pagination .active').text();
                } else {
                    page = 1;
                }

            } else {
                page = 1;
            }
        } else {

        }
        var max_row = $('#change-page-size').val();
        var filtro_status_ventas = $('#change-satus-vtas').val();
        var filtrar_busqueda = $('#filtrar_busqueda').val();
        var filtro_usuario = $('#filtro_usuario').val();
        var fecha_inicio = $('#fecha_inicio').val();
        var fecha_fin = $('#fecha_fin').val();
        var data_json = {
            "accion": "getTablaCotizaciones",
            "page": page,
            "datos": {
                "max_row": max_row,
                "filtro_status_ventas": filtro_status_ventas,
                "filtrar_busqueda": filtrar_busqueda,
                "filtro_usuario": filtro_usuario,
                "fecha_inicio": fecha_inicio,
                "fecha_fin": fecha_fin,
            }
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                $("#tabla_cotizaciones").html(result);
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // Abre confirmacion de venta ->init
    function OpenConfirmVenta(e) {
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
            url: '{{ route('path_ajax_cotizador') }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estas seguro?",
                    text: "Se realizará la venta de la cotización: " + cod_cotizacion,
                    icon: "info",
                    buttons: true,
                    successMode: true,
                    buttons: ["Cancelar", "Si, Vender ahora"],
                })
                    .then((willVende) => {
                        if (willVende) {
                            // Traemos los metodos de pago
                            getMetodosPago(id_coti);
                        } else {

                        }
                    });
            },
            error: function (error) {
                console.log(error);
            }
        });
    }

    // GET metodos pago
    function getMetodosPago(id) {
        let id_coti = id
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
                selectMetodosPago(result, id_coti)
            },
            error: function (error) {
                console.log(error);
            }
        });


    }

    // filtramos y mostramos el select
    function selectMetodosPago(m, id) {
        var id_coti = id
        var metodosPago = m.filter(function (metodo) {
            return metodo.estatus == 1;
        });

        // Tipos de pagos de ejemplo
        let paymentMethods = metodosPago;

        // Select para la alert
        const select = document.createElement('select');
        select.className = 'styled-select';
        paymentMethods.forEach(method => {
            const option = document.createElement('option');
            option.value = method.cod_tipo_cobro;
            option.textContent = method.nombre;
            select.appendChild(option);
        });

        // alerta con el select de metodos de pagos
        swal({
            title: "Selecciona el método de pago : ",
            icon: "info",
            content: select,
            buttons: ["Cancelar", "Aceptar"],
        }).then((value) => {
            if (value) {
                const id_metodo_pago = select.options[select.selectedIndex].value;

                // -> finaliza la compra
                confirmVende(id_coti, id_metodo_pago);
            } else {
                // swal("Selección cancelada.");
            }
        });
    }

    // Confirmamos venta
    function confirmVende(id_coti, id_metodo) {
        var id_coti = id_coti;
        var id_met = id_metodo;
        var data_json = {
            "accion": "confirmVende",
            "datos": {
                "id_coti": id_coti,
                "cod_met": id_met,
            }
        }
        // console.log('object :>> ', data_json);
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('path_ajax_cotizador') }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () { },
            success: function (result) {
                swal("Éxito!", "Se generó la venta correctamente!", "success");
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
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estas seguro?",
                    text: "Si confirma se desactivará la cotización para el cliente: " + cod_cotizacion,
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
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "Se generará código QR de " + cod_cotizacion,
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
            error: function (error) {
                console.log(error);
            }
        });
    }

    function generaQR(id_coti) {
        var id_coti = id_coti;
        var data_json = {
            "accion": "generaQR",
            "datos": {
                "id_coti": id_coti
            }
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                swal("Éxito!", "Se ha generado el QR correctamente!", "success");
                getTablaCotizaciones();
            },
            error: function (error) {
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
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                swal("Éxito!", "Se ha desactivado correctamente!", "success");
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
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estas seguro?",
                    text: "Si confirma se avtivará la cotización para el cliente: " + cod_cotizacion,
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
            error: function (error) {
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
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                swal("Éxito!", "Se ha Activado correctamente!", "success");
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
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                var id_coti = result.id_cotizacion;
                var cod_cotizacion = result.cod_cotizacion;
                swal({
                    title: "¿Estas seguro?",
                    text: "Si confirma se ELIMINARÁ permantentemente la cotización: " + cod_cotizacion,
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
            error: function (error) {
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
            url: '{{ route("path_ajax_cotizador") }}',
            type: 'post',
            datatype: 'html',
            beforeSend: function () {
            },
            success: function (result) {
                console.log(result);
                swal("Éxito!", "Se ha Eliminado permantentemente!", "success");
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