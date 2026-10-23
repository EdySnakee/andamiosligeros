@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.estadisticas.cotizaciones.view.contenido_est_cotizaciones')
@stop

@section('js')
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/locale/es.js"></script>

<script>
    let cotizacionesChart = null;

    moment.locale('es', {
        months: 'Enero_Febrero_Marzo_Abril_Mayo_Junio_Julio_Agosto_Septiembre_Octubre_Noviembre_Diciembre'.split('_'),
        monthsShort: 'Ene_Feb_Mar_Abr_May_Jun_Jul_Ago_Sep_Oct_Nov_Dic'.split('_'),
        weekdays: 'Domingo_Lunes_Martes_Miércoles_Jueves_Viernes_Sábado'.split('_'),
        weekdaysShort: 'Dom_Lun_Mar_Mié_Jue_Vie_Sáb'.split('_'),
        weekdaysMin: 'Do_Lu_Ma_Mi_Ju_Vi_Sá'.split('_')
    });
    moment.locale('es');

    // Configuración de Presets de Fecha
    function setCotiPreset(tipo, el) {
        $('.preset-pill').removeClass('active');
        if (el) $(el).addClass('active');

        const now = new Date();
        const formatDate = (d) => {
            const year = d.getFullYear();
            const month = String(d.getMonth() + 1).padStart(2, '0');
            const day = String(d.getDate()).padStart(2, '0');
            return `${year}-${month}-${day}`;
        };

        let start = '';
        let end = formatDate(now);

        switch (tipo) {
            case '15_dias':
                const past15 = new Date();
                past15.setDate(past15.getDate() - 15);
                start = formatDate(past15);
                break;
            case '30_dias':
                const past30 = new Date();
                past30.setDate(past30.getDate() - 30);
                start = formatDate(past30);
                break;
            case 'este_mes':
                const firstDayMonth = new Date(now.getFullYear(), now.getMonth(), 1);
                start = formatDate(firstDayMonth);
                break;
            case 'mes_pasado':
                const firstDayLastMonth = new Date(now.getFullYear(), now.getMonth() - 1, 1);
                const lastDayLastMonth = new Date(now.getFullYear(), now.getMonth(), 0);
                start = formatDate(firstDayLastMonth);
                end = formatDate(lastDayLastMonth);
                break;
            case 'este_ano':
                const firstDayYear = new Date(now.getFullYear(), 0, 1);
                start = formatDate(firstDayYear);
                break;
            case 'todo':
            default:
                start = '';
                end = '';
                break;
        }

        $('#chart_fecha_inicio').val(start);
        $('#chart_fecha_fin').val(end);
        actualizarGrafico();
    }

    // Cargar Sucursales para usuarios administradores
    function cargarSucursales() {
        const container = $('#sucursales_container');
        if (!container.length) return;

        $.ajax({
            url: '/getSucursales',
            method: 'GET',
            dataType: 'json',
            success: function(sucursales) {
                container.empty();

                if (!sucursales || sucursales.length === 0) {
                    container.html('<span class="text-muted small">No hay sucursales registradas.</span>');
                    return;
                }

                sucursales.forEach(sucursal => {
                    container.append(`
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input sucursal-checkbox" 
                                id="sucursal_${sucursal.id}" value="${sucursal.id}">
                            <label class="custom-control-label small font-weight-bold" for="sucursal_${sucursal.id}">
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
                        alert('Solo puedes seleccionar hasta 3 sucursales simultáneamente para comparar.');
                    } else {
                        actualizarGrafico();
                    }
                });
            },
            error: function(err) {
                console.error('Error al cargar sucursales:', err);
                container.html('<span class="text-danger small">Error al cargar sucursales.</span>');
            }
        });
    }

    // Actualizar Gráfico y Métricas de Cotizaciones
    function actualizarGrafico() {
        const fecha_inicio = $('#chart_fecha_inicio').val();
        const fecha_fin = $('#chart_fecha_fin').val();
        const sucursales_seleccionadas = $('.sucursal-checkbox:checked').map(function() {
            return $(this).val();
        }).get();

        const $btn = $('#aplicar_filtro_fechas');
        $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Filtrando...');

        $.ajax({
            url: '{{ route('ajax_est_cotizaciones') }}',
            method: 'POST',
            dataType: 'json',
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
                // 1. Actualizar KPIs Principales
                if (response.metricas) {
                    $('#coti_total_num').text(Number(response.metricas.totalCotizaciones || 0).toLocaleString());
                    $('#coti_total_importe').text('$' + response.metricas.totalImporte);
                    $('#coti_promedio_importe').text('$' + response.metricas.promedioImporte);
                    $('#coti_promedio_dia').html(`${response.metricas.promedioPorDia} <span class="small font-weight-normal text-muted">/ día</span>`);
                    $('#coti_dias_activos').text(Number(response.metricas.diasActivos || 0).toLocaleString());
                }

                // 2. Actualizar Tarjetas de Giros de Empresa
                if (response.giros) {
                    ['al', 'ra', 'rp', 'sg'].forEach(key => {
                        if (response.giros[key]) {
                            $(`#giro_total_${key}`).text(Number(response.giros[key].total || 0).toLocaleString());
                            $(`#giro_importe_${key}`).text('$' + response.giros[key].importe);
                        }
                    });
                }

                // 3. Renderizar Gráfico
                if (!response.cotizaciones || response.cotizaciones.length === 0) {
                    if (cotizacionesChart) cotizacionesChart.destroy();
                    return;
                }

                if (cotizacionesChart) {
                    cotizacionesChart.destroy();
                }

                const ctx = document.getElementById('cotizacionesChart').getContext('2d');
                const datasets = [];
                const paletaColores = [
                    { bg: 'rgba(8, 72, 175, 0.75)', border: '#0848af' },
                    { bg: 'rgba(16, 185, 129, 0.75)', border: '#10b981' },
                    { bg: 'rgba(245, 158, 11, 0.75)', border: '#f59e0b' },
                    { bg: 'rgba(139, 92, 246, 0.75)', border: '#8b5cf6' }
                ];
                const labels = [];

                // Extraer lista única de días ordenados
                response.cotizaciones.forEach(serie => {
                    (serie.datos || []).forEach(cotizacion => {
                        if (!labels.includes(cotizacion.dia)) {
                            labels.push(cotizacion.dia);
                        }
                    });
                });

                labels.sort((a, b) => new Date(a) - new Date(b));

                // Construir datasets alineados
                response.cotizaciones.forEach((serie, index) => {
                    const data = new Array(labels.length).fill(0);
                    const colorScheme = paletaColores[index % paletaColores.length];

                    (serie.datos || []).forEach(coti => {
                        const idx = labels.indexOf(coti.dia);
                        if (idx !== -1) {
                            data[idx] = parseInt(coti.total || 0);
                        }
                    });

                    datasets.push({
                        label: serie.nombre_sucursal || 'Cotizaciones',
                        data: data,
                        backgroundColor: colorScheme.bg,
                        borderColor: colorScheme.border,
                        borderWidth: 1.5,
                        borderRadius: 6,
                        hoverBackgroundColor: colorScheme.border,
                    });
                });

                cotizacionesChart = new Chart(ctx, {
                    type: 'bar',
                    data: {
                        labels: labels.map(f => moment(f).format('D MMM YYYY')),
                        datasets: datasets
                    },
                    options: {
                        responsive: true,
                        maintainAspectRatio: false,
                        interaction: {
                            mode: 'index',
                            intersect: false
                        },
                        scales: {
                            x: {
                                grid: { display: false },
                                ticks: {
                                    maxRotation: 45,
                                    minRotation: 0,
                                    autoSkip: true,
                                    maxTicksLimit: 20
                                }
                            },
                            y: {
                                beginAtZero: true,
                                title: {
                                    display: true,
                                    text: 'Número de Cotizaciones',
                                    color: '#64748b',
                                    font: { weight: 'bold', size: 12 }
                                },
                                ticks: {
                                    stepSize: 1
                                },
                                grid: { color: 'rgba(226, 232, 240, 0.7)' }
                            }
                        },
                        plugins: {
                            legend: {
                                position: 'top',
                                labels: {
                                    usePointStyle: true,
                                    boxWidth: 8,
                                    padding: 16,
                                    font: { weight: '600', size: 12 }
                                }
                            },
                            tooltip: {
                                backgroundColor: '#0f172a',
                                titleFont: { size: 13, weight: 'bold' },
                                bodyFont: { size: 12 },
                                padding: 12,
                                cornerRadius: 8
                            }
                        }
                    }
                });
            },
            error: function(err) {
                console.error('Error al actualizar gráfico de cotizaciones:', err);
            },
            complete: function() {
                $btn.prop('disabled', false).html('<i class="fas fa-filter mr-1"></i> Filtrar');
            }
        });
    }

    $(document).ready(function() {
        cargarSucursales();
        actualizarGrafico();

        $('#aplicar_filtro_fechas').click(function() {
            actualizarGrafico();
        });

        $('#limpiar_filtros').click(function() {
            $('.preset-pill').removeClass('active');
            $('.preset-pill:first').addClass('active');
            $('#chart_fecha_inicio').val('');
            $('#chart_fecha_fin').val('');
            $('.sucursal-checkbox').prop('checked', false);
            actualizarGrafico();
        });
    });
</script>
@stop