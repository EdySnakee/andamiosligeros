@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.estadisticas.cotizaciones.view.contenido_est_cotizaciones')
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.js"></script>

<script>
    let cotizacionesChart = null; // Variable global para el gráfico
    moment.locale('es', {
        months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
        monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
        weekdays: 'Domingo_Lunes_Martes_Miércoles_Jueves_Viernes_Sábado'.split('_'),
        weekdaysShort: 'Dom_Lun_Mar_Mié_Jue_Vie_Sáb'.split('_'),
        weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sá'.split('_')
    });
    moment.locale('es');

    // Función para cargar sucursales
    function cargarSucursales() {
        $.ajax({
            url: '/getSucursales',
            method: 'GET',
            success: function(sucursales) {
                const container = $('#sucursales_container');
                container.empty();
                
                sucursales.forEach(sucursal => {
                    container.append(`
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input sucursal-checkbox" 
                                id="sucursal_${sucursal.id}" value="${sucursal.id}">
                            <label class="custom-control-label" for="sucursal_${sucursal.id}">
                                ${sucursal.nombre}
                            </label>
                        </div>
                    `);
                });

                // Limitar selección a 3 sucursales
                $('.sucursal-checkbox').on('change', function() {
                    const checkedBoxes = $('.sucursal-checkbox:checked');
                    if (checkedBoxes.length > 3) {
                        this.checked = false;
                        alert('Solo puedes seleccionar hasta 3 sucursales.');
                    }
                });
            }
        });
    }

    // Función para actualizar el gráfico
    function actualizarGrafico() {
        const fecha_inicio = $('#chart_fecha_inicio').val();
        const fecha_fin = $('#chart_fecha_fin').val();
        const sucursales_seleccionadas = $('.sucursal-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        $.ajax({
            url: '{{ route('ajax_est_cotizaciones') }}',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                accion: 'getCotizacionesPorDia',
                datos: {
                    fecha_inicio: fecha_inicio,
                    fecha_fin: fecha_fin,
                    sucursales: sucursales_seleccionadas
                }
            },
            success: function(response) {
                if (!response.cotizaciones || response.cotizaciones.length === 0) {
                    alert('No hay datos disponibles para generar el gráfico.');
                    return;
                }

                if (cotizacionesChart) {
                    cotizacionesChart.destroy();
                }

                const ctx = document.getElementById('cotizacionesChart').getContext('2d');
                const datasets = [];
                const colores = ['#0848af', '#ffbb00', '#F58702'];
                const labels = [];

                // Construir lista única de días
                response.cotizaciones.forEach(serie => {
                    serie.datos.forEach(cotizacion => {
                        if (!labels.includes(cotizacion.dia)) {
                            labels.push(cotizacion.dia);
                        }
                    });
                });

                // Ordenar los días cronológicamente
                labels.sort((a, b) => new Date(a) - new Date(b));

                // Crear datasets alineados con los días
                response.cotizaciones.forEach((serie, index) => {
                    const data = new Array(labels.length).fill(0);

                    serie.datos.forEach(cotizacion => {
                        const labelIndex = labels.indexOf(cotizacion.dia);
                        if (labelIndex !== -1) {
                            data[labelIndex] = cotizacion.total;
                        }
                    });

                    datasets.push({
                        label: serie.nombre_sucursal,
                        data: data,
                        backgroundColor: response.tipo_grafica === 'bar' ? colores[index % colores.length] : 'transparent',
                        borderColor: colores[index % colores.length],
                        borderWidth: 2,
                        pointRadius: 3,
                        pointBackgroundColor: colores[index % colores.length],
                        pointBorderColor: '#fff',
                        pointHoverRadius: 5
                    });
                });

                // Crear el gráfico
                cotizacionesChart = new Chart(ctx, {
                    type: response.tipo_grafica,
                    data: {
                        labels: labels.map(fecha => {
                            return moment(fecha).format('D MMMM YYYY');
                        }),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        scales: {
                            x: {
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 45
                                }
                            },
                            y: {
                                beginAtZero: true,
                                ticks: {
                                    stepSize: 1
                                }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top'
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
        cargarSucursales();
        actualizarGrafico();
        
        $('#aplicar_filtro_fechas').click(function() {
            actualizarGrafico();
        });

        $('#limpiar_filtros').click(function() {
            $('#chart_fecha_inicio').val('');
            $('#chart_fecha_fin').val('');
            $('.sucursal-checkbox').prop('checked', false);
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

.graficas-cotizaciones-container {
    display: flex;
    align-items: center;
    justify-content: center;
    max-height: 700px;
    width: 100%;
}
</style>