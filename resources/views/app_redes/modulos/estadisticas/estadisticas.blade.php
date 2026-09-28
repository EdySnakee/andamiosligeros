@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.estadisticas.contenido_estd')
@stop

@section('js')
    <script>
        // INICIAL
        var cotizacionesPorStatus = {!! $cotizacionesData !!};

        $(document).ready(function() {
            updateChart(cotizacionesPorStatus);
        });

       // Función para formatear importe
function formatCurrency(value) {
    // Convertir a número si el valor es una cadena
    const numericValue = parseFloat(value);
    
    // Verificar si la conversión fue exitosa
    if (isNaN(numericValue)) {
        console.error('Valor no numérico:', value);
        return value; // Retorna el valor original si no se puede convertir
    }
    
    console.log('entro: ', numericValue);
    return numericValue.toLocaleString('es-MX', {
        style: 'currency',
        currency: 'MXN',
        minimumFractionDigits: 2,
        maximumFractionDigits: 2 // Para asegurarnos de que siempre se muestren dos decimales
    });
}

        // Función para actualizar los elementos del DOM
        function updateElement(id, value) {
            document.getElementById(id).innerText = value;
        }

        // Mapeo de estados a funciones
        const statusHandlers = {
            1: (item) => { // ACTIVAS
                updateElement('totalCotMID', formatCurrency(item.totalImporte));
                updateElement('numCotMID', item.total);
            },
            3: (item) => { // VENTAS
                updateElement('totalVentMID', formatCurrency(item.totalImporte));
                updateElement('numVentMID', item.total);
            },
            5: (item) => { // VENCIDAS
                // No actualizamos elementos aquí
                console.log('VENCIDAS: ', item);
            },
            // Otros
        };

        // Actualiza Mérida
        function updateChart(cotizaciones) {
            cotizaciones.forEach(function(item) {
                const handler = statusHandlers[item.status];
                if (handler) {
                    handler(item);
                } else {
                    console.warn(`No handler for status: ${item.status}`);
                }
            });
        }

        // Filtrado por fechas MERIDA
        $(document).on("change", "#fecha_inicio, #fecha_fin", function(e) {
            var fechaInicio = $("#fecha_inicio").val();
            var fechaFin = $("#fecha_fin").val();

            if (fechaInicio && fechaFin) {
                getEstadisticasMID();
            } else {
                console.log("Por favor, completa ambos campos de fecha.");
            }
        });

        // Traer estadísticas
        function getEstadisticasMID() {
            var myChart;

            var fecha_inicio = $('#fecha_inicio').val();
            var fecha_fin = $('#fecha_fin').val();
            var data_json = {
                "accion": "getEstadisticasMID",
                "datos": {
                    "fecha_inicio": fecha_inicio,
                    "fecha_fin": fecha_fin,
                }
            }
            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_estadisticas_path') }}',
                type: 'post',
                datatype: 'json',
                beforeSend: function() {},
                success: function(result) {
                    var cotizacionesPorStatus = result.cotizacionesData;
                    actualizarGrafica(cotizacionesPorStatus);
                },
                error: function(error) {
                    console.log(error);
                }
            });
        }

        // Función para actualizar la gráfica
        function actualizarGrafica(cotizacionesPorStatus) {
            cotizacionesPorStatus.forEach(function(item) {
                const handler = statusHandlers[item.status];
                if (handler) {
                    handler(item);
                } else {
                    console.warn(`No handler for status: ${item.status}`);
                }
            });
        }
    </script>
@stop