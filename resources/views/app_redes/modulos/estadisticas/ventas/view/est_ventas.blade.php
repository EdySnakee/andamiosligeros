@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.estadisticas.ventas.view.contenido_est_ventas');
@stop

@section('js')
    <script>
        function filtrarEstadisticas() {
            var fecha_inicio = $('#fecha_inicio').val();
            var fecha_fin = $('#fecha_fin').val();
            var data_json = {
                "accion": "estVentas",
                "datos": {
                    "fecha_inicio": fecha_inicio,
                    "fecha_fin": fecha_fin,
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('ajax_est_ventas') }}',
                type: 'post',
                datatype: 'json',
                beforeSend: function() {},
                success: function(result) {
                    console.log('result :>> ', result);
                    //aui actualizamos la vista
                    if (result.success) {

                        $('#totalVentas').text('$' + result.totalVentas);
                        $('#numCotizaciones').text(result.numCotizaciones);
                        $('#totalCotizaciones').text('$' + result.totalCotizaciones);
                        $('#numeroVentas').text(result.numeroVentas);
                        $('#promedioVentas').text('$' + result.promedioVentas);

                        // NUEVOS 
                        $('#totalIVA').text('$' + result.totalIVA);
                        $('#totalEnvios').text('$' + result.totalEnvios);
                        $('#totalEnviosPaqueteria').text('$' + result.totalEnviosPaqueteria);
                        $('#totalNeto').text('$' + result.totalNeto);

                        let vendedoresHtml = '';
                        console.log(result.vendedoresPrin);
                        result.vendedoresPrin.forEach(vendedor => {
                            vendedoresHtml += `
                                        <tr>
                                            <td>${vendedor.nombre}</td>
                                            <td>${vendedor.numero_cotizaciones}</td>
                                            <td>${vendedor.numero_ventas}</td>
                                            <td>$${vendedor.total_cotizado}</td>
                                            <td>$${vendedor.total_generado}</td>
                                            <td>${vendedor.promedio_exito}%</td>
                                            <td>${vendedor.cliente_estrella}</td>
                                        </tr>
                                    `;
                        });
                        $('#vendedoresPrincipales').html(vendedoresHtml);

                        let productosHtml = '';
                        console.log(result.productosMasVendidos);
                        result.productosMasVendidos.forEach((producto, index) => {
                            const rank = index + 1;
                            const rankClass = rank <= 3 ? 'rank-' + rank : '';

                            productosHtml += `
        <div class="col-xl-3 col-lg-4 col-md-6 mb-4">
            <div class="card producto-card h-100 position-relative">
                <span class="producto-rank-badge ${rankClass}">#${rank}</span>
                <div class="card-body">
                    <p class="producto-nombre">${producto.nombre}</p>
                    <div class="producto-stats">
                        <div class="producto-stat">
                            <span class="producto-stat-value">${producto.cantidad_vendida}</span>
                            <span class="producto-stat-label">Unidades</span>
                        </div>
                        <div class="producto-stat">
                            <span class="producto-stat-value">$${producto.total_vendido}</span>
                            <span class="producto-stat-label">Total</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
                        });
                        $('#productosMasVendidos').html(productosHtml);
                    } else {
                        alert('Error al procesar las estadísticas.');
                    }

                },
                error: function(error) {
                    console.log(error);
                }
            });
        }


        // Función para actualizar el gráfico
        let ventasChart = null;

        function actualizarGrafico() {
            const fecha_inicio = $('#chart_fecha_inicio').val();
            const fecha_fin = $('#chart_fecha_fin').val();

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                method: 'POST',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'getVentasPorMes',
                    datos: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(response) {
                    console.log("Response:", response);

                    // Verifica si hay datos en la respuesta
                    if (!response.datos || response.datos.length === 0) {
                        alert('No hay datos disponibles para generar el gráfico.');
                        return;
                    }

                    if (ventasChart) {
                        ventasChart.destroy();
                    }

                    // Ordenar cronológicamente por mes
                    response.datos.sort((a, b) => new Date(a.mes) - new Date(b.mes));

                    const labels = response.datos.map(d => d.mes);
                    const cantidadesCotizaciones = response.datos.map(d => parseInt(d.cantidad_cotizaciones ||
                        0));
                    const cantidadesVentas = response.datos.map(d => parseInt(d.cantidad_ventas || 0));
                    const importesVentas = response.datos.map(d => parseFloat(d.importe_ventas || 0));

                    const ctx = document.getElementById('ventasChart').getContext('2d');

                    // Crear el gráfico con doble eje Y y diseño premium
                    ventasChart = new Chart(ctx, {
                        type: 'bar', // Tipo principal (las cantidades se mostrarán como barras)
                        data: {
                            labels: labels,
                            datasets: [{
                                    label: 'Cotizaciones Creadas',
                                    data: cantidadesCotizaciones,
                                    backgroundColor: 'rgba(108, 117, 125, 0.6)', // Gris elegante
                                    borderColor: '#6c757d',
                                    borderWidth: 2,
                                    yAxisID: 'y', // Eje izquierdo
                                    order: 3
                                },
                                {
                                    label: 'Ventas Realizadas (Estatus 3)',
                                    data: cantidadesVentas,
                                    backgroundColor: 'rgba(40, 167, 69, 0.6)', // Verde éxito
                                    borderColor: '#28a745',
                                    borderWidth: 2,
                                    yAxisID: 'y', // Eje izquierdo
                                    order: 2
                                },
                                {
                                    label: 'Importe Vendido ($)',
                                    data: importesVentas,
                                    type: 'line', // Tipo línea para destacar importes
                                    borderColor: '#ffbb00', // Amarillo/Naranja
                                    backgroundColor: function(context) {
                                        const chart = context.chart;
                                        const {
                                            ctx,
                                            chartArea
                                        } = chart;
                                        if (!chartArea) return null;
                                        const gradient = ctx.createLinearGradient(0, chartArea
                                            .top, 0, chartArea.bottom);
                                        gradient.addColorStop(0, 'rgba(255, 187, 0, 0.3)');
                                        gradient.addColorStop(1, 'rgba(255, 187, 0, 0)');
                                        return gradient;
                                    },
                                    fill: true,
                                    borderWidth: 3,
                                    pointRadius: 4,
                                    pointBackgroundColor: '#ffbb00',
                                    pointHoverRadius: 6,
                                    yAxisID: 'y1', // Eje derecho
                                    order: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    display: true,
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Cantidad (Cotizaciones / Ventas)',
                                        color: '#495057',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        stepSize: 1
                                    }
                                },
                                y1: {
                                    type: 'linear',
                                    display: true,
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Importe Vendido ($)',
                                        color: '#ffbb00',
                                        font: {
                                            weight: 'bold'
                                        }
                                    },
                                    grid: {
                                        drawOnChartArea: false // Evita encimar las cuadrículas
                                    },
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(value) {
                                            return '$' + parseFloat(value).toLocaleString('es-MX', {
                                                minimumFractionDigits: 2,
                                                maximumFractionDigits: 2
                                            });
                                        }
                                    }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(context) {
                                            let label = context.dataset.label || '';
                                            if (label) {
                                                label += ': ';
                                            }
                                            if (context.dataset.yAxisID === 'y1') { // Importe
                                                label += '$' + parseFloat(context.parsed.y)
                                                    .toLocaleString('es-MX', {
                                                        minimumFractionDigits: 2,
                                                        maximumFractionDigits: 2
                                                    });
                                            } else {
                                                label += context.parsed.y;
                                            }
                                            return label;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(error) {
                    console.error("Error al obtener los datos:", error);
                }
            });
        }

        // Event listeners
        $(document).ready(function() {
            actualizarGrafico();

            $('#aplicar_filtro_fechas').click(function() {
                actualizarGrafico();
            });

            $('#limpiar_filtros').click(function() {
                $('#chart_fecha_inicio').val('');
                $('#chart_fecha_fin').val('');
                actualizarGrafico();
            });
        });
    </script>
@stop
<style>
    .estadisticas-titulos {
        background-color: #0848af;
        color: white;
    }

    .graficas-ventas-container {
        max-height: 600px;
        display: flex;
        align-items: center;
        justify-content: center;
    }
</style>
