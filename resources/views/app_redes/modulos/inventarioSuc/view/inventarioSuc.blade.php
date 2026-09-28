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
        background-color: #f2f2f2;
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
@include('app_redes.modulos.inventarioSuc.view.contenido_inventarioSuc')
@stop

@section('js')
<script>
    // Modal SALIDA
    $(document).on("click", "#open_modal_salida", function(e) {
        openModal(e, 'salida');
    });

    // Modal ENTRADA
    $(document).on("click", "#open_modal_entrada", function(e) {
        openModal(e, 'entrada');
    });

    // Función openModal para entradas y salidas
    function openModal(e, tipo) {
        e.preventDefault();

        var data_json = {
            "accion": "openModal",
            "datos": {
                "tipo_movimiento": tipo // Enviamos el tipo (entrada/salida)
            }
        }
        ajaxSetup();
        $.ajax({
            data: data_json,
            url: '{{ route('ajax_inv_path') }}', // Ruta del InventarioSucController
            type: 'post',
            datatype: 'html',
            beforeSend: function() {},
            success: function(result) {
                $("#modal_large_redes").html(result);
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
            url: '{{ route('ajax_inv_path') }}',
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

    // Cambiar la sucursal
    function cambiarSucursal() {
        var selectElement = document.getElementById("change-page-size");
        var sucursalId = selectElement.value;

        // Obtener el nombre de la sucursal seleccionada usando el atributo data-nombre
        var sucursalNombre = selectElement.options[selectElement.selectedIndex].getAttribute('data-nombre');

        if (sucursalId) {
            // Mostrar el nombre de la sucursal en el HTML
            document.getElementById("nombre-sucursal").innerText = sucursalNombre;

            // Actualizar el inventario de la sucursal seleccionada
            actualizarInventario(sucursalId);

        }
    }

    function filtrarCategoria(categoria) {
        var id_sucursal = 3; // O mantén tu hardcode si así lo requieres por ahora

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
            url: '{{route('ajax_inv_path')}}',
            type: 'post',
            datatype: 'html',
            beforeSend: function() {},
            success: function(result) {
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