@extends('layouts.app_redes')
@include('app_redes.modulos.modales.modales')


@section('css')
    <style>
        /* Estilos para mejorar la apariencia de la tabla */
        .inventory-table {
            cursor: pointer;
            width: 100%;
            border-collapse: collapse;
            background-color: #f9f9f9;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 10px;
            overflow: hidden;
        }

        .inventory-table thead {
            background-color: #2870db;
            color: white;
            text-transform: uppercase;
            letter-spacing: 0.05em;
        }

        .inventory-table thead th {
            justify-content: center;
            padding: 10px 10px;
            font-weight: bold;
            font-size: 15px;
            text-align: center;
        }

        .inventory-table tbody tr {
            transition: all 0.2s ease;
        }

        .inventory-table tbody tr:hover {
            background-color: #f1f1f1;
        }

        .inventory-table tbody td {
            justify-content: center;
            text-align: center;
            border-bottom: 1px solid #ddd;
            padding: 0;
            vertical-align: middle;
        }

        /* Estilo para celdas de stock bajo */
        .low-stock {
            color: red;
            font-weight: bold;
        }

        /* Colorear filas alternadas para darle un efecto visual moderno */
        .inventory-table tbody tr:nth-child(even) {
            background-color: #e8e9f1;
        }

        .progress-wrapper {
            text-align: center;
            margin: 5px 0;
            padding: 0px 18px;

        }

        .progress-label {
            font-weight: bold;
            margin-bottom: 5px;
        }

        .progress {
            height: 13px;
            background-color: #e9ecef;
            border-radius: 10px;
            overflow: hidden;
            position: relative;
            box-shadow: 0 1px 3px rgba(0, 0, 0, 0.1);
        }

        .progress-bar {
            height: 100%;
            background: linear-gradient(90deg, #4cadba, #5bc85e);
            color: white;
            font-weight: bold;
            display: flex;
            justify-content: center;
            align-items: center;
            border-radius: 10px;
            transition: width 0.4s ease;
            box-shadow: inset 0 1px 3px rgba(0, 0, 0, 0.2);
        }

        /* Set the color for very low stock */
        .progress-bar.low-stock {
            background: linear-gradient(90deg, #FFA726, #FF7043);
        }

        /* Set the color for out of stock */
        .progress-bar.no-stock {
            background: linear-gradient(90deg, #E57373, #F44336);
        }

        /* Estilo para modal de entrada */
        .modal-entrada .modal-content {
            background-color: #c9e4d0;
            border-color: #9ccda7;
        }

        /* Estilo para modal de salida */
        .modal-salida .modal-content {
            background-color: #ecbec1;
            border-color: #dca0a6;
        }

        /* Estilo por defecto */
        .modal-default .modal-content {
            background-color: #ffffff;
            border-color: #dee2e6;
        }

        .table-responsive {
            max-height: 500px;
            overflow-y: auto;
        }

        .card {
            width: 100%;
        }

        /* Responsividad para dispositivos pequeños */
        @media screen and (max-width: 768px) {
            .inventory-table thead {
                display: none;
                /* Ocultar encabezado en pantallas pequeñas */
            }

            .inventory-table tbody tr {
                display: block;
                margin-bottom: 10px;
            }

            .inventory-table tbody td {
                display: block;
                text-align: center;
                padding-left: 50%;
                position: relative;
                border-bottom: 1px solid #ddd;
            }

            .inventory-table tbody td:before {
                content: attr(data-label);
                position: absolute;
                left: 10px;
                font-weight: bold;
                text-transform: uppercase;
            }
        }
    </style>
@stop



@section('content')
    @include('app_redes.modulos.inventario.admin_dash.contenido_admin')
@stop

@section('js')
    <script>

        // Open modal ->
        function openModal(tipoTransferencia) {
            tipo = tipoTransferencia;
            var condicion = 'condicion'
            var data_json = {
                "accion": "openModalTransferencia",
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_inv_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {

                    $("#modal_large_redes").html(result);

                    // Removemos clases previas del modal
                    $('#modal_large_redes').removeClass('modal-entrada modal-salida modal-default');

                    // Asignamos una clase según el tipo de transferencia
                    if (tipoTransferencia === 'entrada') {
                        $('#modal_large_redes').addClass('modal-entrada');
                    } else if (tipoTransferencia === 'salida') {
                        $('#modal_large_redes').addClass('modal-salida');
                    } else {
                        $('#modal_large_redes').addClass('modal-default');
                    }

                    $('#modal_large_redes').modal({
                        backdrop: 'static',
                        keyboard: false
                    });

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Actualizar el inventario
        function actualizarInventario(id_sucursal) {
            var data_json = {
                "accion": "actualizarInv",
                "datos": {
                    "id_sucursal": id_sucursal
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_inv_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {

                    // Actualizamos la vista
                    document.getElementById("tabla_inventario").innerHTML = result;


                    swal({
                        title: "Inventario actualizado!",
                        text: " ",
                        icon: "success",
                        timer: 700,
                        buttons: false
                    });
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Actualizar ENTRADAS Y SALIDAS
        function actualizarMov(id_sucursal) {
            var data_json = {
                "accion": "actualizarMov",
                "datos": {
                    "id_sucursal": id_sucursal
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_inv_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {

                    // Actualizamos la vista de entradas y salidas
                    document.getElementById("tab_entradas").innerHTML = $(result).find('#tab_entradas').html();
                     document.getElementById("tab_salidas").innerHTML = $(result).find('#tab_salidas').html();

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }
        
        // Actualizar TOTALES
        function actualizarTotales(id_sucursal) {
            var data_json = {
                "accion": "actualizarTotales",
                "datos": {
                    "id_sucursal": id_sucursal
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_inv_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {

                    // Actualizamos los totales inventario
                    document.getElementById("totales_inv").innerHTML = result

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Cambiar la sucursal
        function cambiarSucursal() {
            var selectElement = document.getElementById("change-sucursal");
            var sucursalId = selectElement.value;

            // Obtener el nombre de la sucursal seleccionada usando el atributo data-nombre
            var sucursalNombre = selectElement.options[selectElement.selectedIndex].getAttribute('data-nombre');

            if (sucursalId) {

                // Mostrar el nombre de la sucursal en el HTML
                document.getElementById("nombre-sucursal").innerText = sucursalNombre;

                // Actualizar el inventario de la sucursal seleccionada
                actualizarInventario(sucursalId);

                // Actualizar movimientos de inventario 'Entradas y salidas'
                actualizarMov(sucursalId);

                // Actualizar los totales inventario
                actualizarTotales(sucursalId);

            }
        }

        // Filtrar categoria
        function filtrarCategoria(categoria) {
            id_sucursal = document.getElementById("change-sucursal").value;

            var data_json = {
                "accion": "filtrarCategoria",
                "datos": {
                    "categoria": categoria,
                    "id_sucursal": id_sucursal
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_inv_ajax') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    // Actualizamos la vista
                    document.getElementById("tabla_inventario").innerHTML = result;
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // filtrar Categorias 
        function filtroCategoria() {
            var selectElement = document.getElementById("change-category");
            var categoria = selectElement.value;


            if (categoria !== "") {
                filtrarCategoria(categoria);
            } else {
                swal({
                    title: "Seleccione una categoria",
                    text: " ",
                    icon: "warning",
                    timer: 777,
                    buttons: false
                });
            }

        }
    </script>
@stop
