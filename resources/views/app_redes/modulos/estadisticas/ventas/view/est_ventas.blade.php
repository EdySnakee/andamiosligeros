@extends('layouts.app_redes')

@section('content')
    @include('app_redes.modulos.estadisticas.ventas.view.contenido_est_ventas')
@stop

@section('js')
    <script>
        let ventasChart = null;

        // Formateador de moneda para tooltips y etiquetas
        const moneyFormatter = new Intl.NumberFormat('es-MX', {
            style: 'currency',
            currency: 'MXN',
            minimumFractionDigits: 2
        });

        // Configuración de Presets de Fecha
        function setPreset(tipo, el) {
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
                case '30_dias':
                    const past30 = new Date();
                    past30.setDate(past30.getDate() - 30);
                    start = formatDate(past30);
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

            $('#fecha_inicio').val(start);
            $('#fecha_fin').val(end);
            filtrarEstadisticas();
        }

        function resetFiltros() {
            $('.preset-pill').removeClass('active');
            $('.preset-pill:first').addClass('active');
            $('#fecha_inicio').val('');
            $('#fecha_fin').val('');
            filtrarEstadisticas();
        }

        // Filtro Principal de Estadísticas (KPIs, Ranking, Vendedores y Gráfica)
        function filtrarEstadisticas() {
            const fecha_inicio = $('#fecha_inicio').val();
            const fecha_fin = $('#fecha_fin').val();
            const $btn = $('#btnFiltrarVentas');

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Filtrando...');

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'estVentas',
                    datos: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(result) {
                    if (result.success) {
                        // 1. Actualizar KPIs Comerciales
                        $('#numCotizaciones').text(Number(result.numCotizaciones || 0).toLocaleString());
                        $('#numeroVentas').text(Number(result.numeroVentas || 0).toLocaleString());
                        $('#tasaConversion').text((result.tasaConversion || 0) + '%');
                        $('#promedioVentas').text('$' + result.promedioVentas);

                        // 2. Actualizar KPIs Financieros
                        $('#totalVentas').text('$' + result.totalVentas);
                        $('#totalIVA').text('$' + result.totalIVA);
                        $('#totalEnvios').text('$' + result.totalEnvios);
                        $('#totalEnviosPaqueteria').text('$' + result.totalEnviosPaqueteria);
                        $('#totalNeto').text('$' + result.totalNeto);

                        // Logística calculada
                        const brutoVal = parseFloat(String(result.totalVentas).replace(/,/g, '')) || 0.01;
                        const netoVal = parseFloat(String(result.totalNeto).replace(/,/g, '')) || 0;
                        const ivaVal = parseFloat(String(result.totalIVA).replace(/,/g, '')) || 0;
                        const enviosVal = parseFloat(String(result.totalEnvios).replace(/,/g, '')) || 0;
                        const paqVal = parseFloat(String(result.totalEnviosPaqueteria).replace(/,/g, '')) || 0;
                        const logVal = enviosVal + paqVal;

                        $('#totalLogistica').text('$' + logVal.toLocaleString('es-MX', { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                        // Actualizar Tabla y Barra Financiera
                        $('#tblTotalVentas').text('$' + result.totalVentas);
                        $('#tblTotalIVA').text('-$' + result.totalIVA);
                        $('#tblTotalEnvios').text('-$' + result.totalEnvios);
                        $('#tblTotalPaq').text('-$' + result.totalEnviosPaqueteria);
                        $('#tblTotalNeto').text('$' + result.totalNeto);

                        const pctNeto = Math.max(0, Math.min(100, ((netoVal / brutoVal) * 100).toFixed(1)));
                        const pctIva = Math.max(0, Math.min(100, ((ivaVal / brutoVal) * 100).toFixed(1)));
                        const pctLog = Math.max(0, Math.min(100, ((logVal / brutoVal) * 100).toFixed(1)));

                        $('#barPctNeto').css('width', pctNeto + '%').attr('title', 'Venta Neta: ' + pctNeto + '%');
                        $('#barPctIva').css('width', pctIva + '%').attr('title', 'IVA: ' + pctIva + '%');
                        $('#barPctLog').css('width', pctLog + '%').attr('title', 'Logística: ' + pctLog + '%');

                        $('#txtPctNeto').text(pctNeto + '%');
                        $('#txtPctIva').text(pctIva + '%');
                        $('#txtPctLog').text(pctLog + '%');

                        // 3. Renderizar Top Productos en Leaderboard
                        renderProductos(result.productosMasVendidos);

                        // 4. Renderizar Vendedores
                        renderVendedores(result.vendedoresPrin);

                        // 5. Sincronizar Gráfica Mensual
                        actualizarGrafico(fecha_inicio, fecha_fin);
                    } else {
                        alert('No fue posible procesar las estadísticas.');
                    }
                },
                error: function(err) {
                    console.error('Error al filtrar estadísticas:', err);
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-filter mr-1"></i> Filtrar');
                }
            });
        }

        // Renderizado dinámico de Productos Más Vendidos (Leaderboard)
        function renderProductos(productos) {
            const container = $('#productosMasVendidos');
            container.empty();

            if (!productos || productos.length === 0) {
                container.html(`
                    <div class="p-4 text-center text-muted">
                        <i class="fas fa-box-open fa-2x mb-2 text-gray-300"></i>
                        <p class="small mb-0">No hay productos registrados en este período.</p>
                    </div>
                `);
                return;
            }

            productos.forEach((p, index) => {
                const rank = index + 1;
                let rankClass = '';
                let rankMedal = `#${rank}`;
                if (rank === 1) { rankClass = 'rank-1'; rankMedal = '🥇'; }
                else if (rank === 2) { rankClass = 'rank-2'; rankMedal = '🥈'; }
                else if (rank === 3) { rankClass = 'rank-3'; rankMedal = '🥉'; }

                container.append(`
                    <div class="leaderboard-item">
                        <div class="leaderboard-rank ${rankClass}">${rankMedal}</div>
                        <div class="leaderboard-info">
                            <p class="leaderboard-name" title="${p.nombre}">${p.nombre}</p>
                            <div class="leaderboard-progress">
                                <div class="leaderboard-progress-bar" style="width: ${p.porcentaje}%;"></div>
                            </div>
                            <span class="leaderboard-meta">
                                <strong>${Number(p.cantidad_vendida).toLocaleString()}</strong> unidades vendidas
                            </span>
                        </div>
                        <div class="leaderboard-total">
                            <div class="leaderboard-total-value">$${p.total_vendido}</div>
                            <span class="small text-muted">Total</span>
                        </div>
                    </div>
                `);
            });
        }

        // Renderizado dinámico de Vendedores Principales
        function renderVendedores(vendedores) {
            const tbody = $('#vendedoresPrincipales');
            tbody.empty();

            if (!vendedores || vendedores.length === 0) {
                tbody.html(`
                    <tr>
                        <td colspan="7" class="text-center py-4 text-muted">
                            No hay vendedores con actividad en este rango de fechas.
                        </td>
                    </tr>
                `);
                return;
            }

            vendedores.forEach(v => {
                const inicial = (v.nombre || 'V').charAt(0).toUpperCase();
                const tasa = parseFloat(v.promedio_exito) || 0;
                let badgeClass = 'badge-secondary';
                if (tasa >= 25) badgeClass = 'badge-success';
                else if (tasa >= 15) badgeClass = 'badge-warning';

                const clienteEstrella = (v.cliente_estrella && v.cliente_estrella !== 'N/A')
                    ? `<i class="fas fa-star text-warning mr-1"></i><strong>${v.cliente_estrella}</strong>`
                    : `<span class="text-muted">N/A</span>`;

                tbody.append(`
                    <tr>
                        <td class="font-weight-bold">
                            <span class="vendedor-avatar">${inicial}</span>
                            ${v.nombre}
                        </td>
                        <td class="text-center">${Number(v.numero_cotizaciones || 0).toLocaleString()}</td>
                        <td class="text-center font-weight-bold text-success">${Number(v.numero_ventas || 0).toLocaleString()}</td>
                        <td class="text-right text-muted">$${v.total_cotizado}</td>
                        <td class="text-right font-weight-bold text-primary">$${v.total_generado}</td>
                        <td class="text-center">
                            <span class="badge ${badgeClass} badge-tasa">${v.promedio_exito}%</span>
                        </td>
                        <td>${clienteEstrella}</td>
                    </tr>
                `);
            });
        }

        // Renderizado / Actualización del Gráfico Mensual
        function actualizarGrafico(fInicio, fFin) {
            const fecha_inicio = fInicio !== undefined ? fInicio : $('#fecha_inicio').val();
            const fecha_fin = fFin !== undefined ? fFin : $('#fecha_fin').val();

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                method: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'getVentasPorMes',
                    datos: {
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(response) {
                    if (!response.datos || response.datos.length === 0) {
                        return;
                    }

                    if (ventasChart) {
                        ventasChart.destroy();
                    }

                    response.datos.sort((a, b) => new Date(a.mes + '-01') - new Date(b.mes + '-01'));

                    const labels = response.datos.map(d => {
                        const partes = d.mes.split('-');
                        const fecha = new Date(partes[0], partes[1] - 1, 1);
                        return fecha.toLocaleDateString('es-MX', { month: 'short', year: 'numeric' });
                    });

                    const cotizaciones = response.datos.map(d => parseInt(d.cantidad_cotizaciones || 0));
                    const ventas = response.datos.map(d => parseInt(d.cantidad_ventas || 0));
                    const importes = response.datos.map(d => parseFloat(d.importe_ventas || 0));

                    const ctx = document.getElementById('ventasChart').getContext('2d');

                    ventasChart = new Chart(ctx, {
                        data: {
                            labels: labels,
                            datasets: [
                                {
                                    type: 'bar',
                                    label: 'Cotizaciones',
                                    data: cotizaciones,
                                    backgroundColor: 'rgba(100, 116, 139, 0.45)',
                                    borderColor: '#64748b',
                                    borderWidth: 1.5,
                                    borderRadius: 6,
                                    yAxisID: 'y',
                                    order: 3
                                },
                                {
                                    type: 'bar',
                                    label: 'Ventas Concretadas',
                                    data: ventas,
                                    backgroundColor: 'rgba(16, 185, 129, 0.75)',
                                    borderColor: '#10b981',
                                    borderWidth: 1.5,
                                    borderRadius: 6,
                                    yAxisID: 'y',
                                    order: 2
                                },
                                {
                                    type: 'line',
                                    label: 'Importe Vendido ($)',
                                    data: importes,
                                    borderColor: '#f59e0b',
                                    backgroundColor: 'rgba(245, 158, 11, 0.12)',
                                    borderWidth: 3,
                                    pointBackgroundColor: '#f59e0b',
                                    pointBorderColor: '#ffffff',
                                    pointBorderWidth: 2,
                                    pointRadius: 4,
                                    pointHoverRadius: 6,
                                    tension: 0.35,
                                    fill: true,
                                    yAxisID: 'y1',
                                    order: 1
                                }
                            ]
                        },
                        options: {
                            responsive: true,
                            maintainAspectRatio: false,
                            interaction: {
                                mode: 'index',
                                intersect: false
                            },
                            scales: {
                                y: {
                                    type: 'linear',
                                    position: 'left',
                                    title: {
                                        display: true,
                                        text: 'Cantidad (Cotizaciones / Ventas)',
                                        color: '#64748b',
                                        font: { weight: 'bold', size: 12 }
                                    },
                                    ticks: { beginAtZero: true, stepSize: 1 },
                                    grid: { color: 'rgba(226, 232, 240, 0.7)' }
                                },
                                y1: {
                                    type: 'linear',
                                    position: 'right',
                                    title: {
                                        display: true,
                                        text: 'Importe Facturado ($)',
                                        color: '#f59e0b',
                                        font: { weight: 'bold', size: 12 }
                                    },
                                    grid: { drawOnChartArea: false },
                                    ticks: {
                                        beginAtZero: true,
                                        callback: function(v) {
                                            return '$' + Number(v).toLocaleString('es-MX', { maximumFractionDigits: 0 });
                                        }
                                    }
                                },
                                x: {
                                    grid: { display: false }
                                }
                            },
                            plugins: {
                                legend: {
                                    position: 'top',
                                    labels: {
                                        usePointStyle: true,
                                        boxWidth: 8,
                                        padding: 18,
                                        font: { weight: '600', size: 12 }
                                    }
                                },
                                tooltip: {
                                    backgroundColor: '#0f172a',
                                    titleFont: { size: 13, weight: 'bold' },
                                    bodyFont: { size: 12 },
                                    padding: 12,
                                    cornerRadius: 8,
                                    callbacks: {
                                        label: function(ctx) {
                                            if (ctx.dataset.yAxisID === 'y1') {
                                                return `${ctx.dataset.label}: ${moneyFormatter.format(ctx.parsed.y)}`;
                                            }
                                            return `${ctx.dataset.label}: ${ctx.parsed.y}`;
                                        }
                                    }
                                }
                            }
                        }
                    });
                },
                error: function(err) {
                    console.error('Error al actualizar gráfico de ventas:', err);
                }
            });
        }

        $(document).ready(function() {
            actualizarGrafico();

            // Reajustar tamaño de la gráfica al cambiar de pestaña
            $('a[data-toggle="pill"], a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if (ventasChart) {
                    ventasChart.resize();
                }
            });
        });
    </script>
@stop
