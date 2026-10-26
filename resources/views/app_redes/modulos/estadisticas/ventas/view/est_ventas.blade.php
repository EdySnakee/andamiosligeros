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
                        $('#totalCotizaciones').text('$' + result.totalCotizaciones);
                        $('#numeroVentas').text(Number(result.numeroVentas || 0).toLocaleString());
                        $('#tasaConversion').text((result.tasaConversion || 0) + '%');
                        $('#tasaConversionCard').text((result.tasaConversion || 0) + '%');
                        $('#promedioVentas').text('$' + result.promedioVentas);

                        // 2. Actualizar KPIs Financieros
                        $('#totalVentas').text('$' + result.totalVentas);
                        $('#totalIVA').text('-$' + result.totalIVA);
                        $('#totalEnvios').text('$' + result.totalEnvios);
                        $('#totalEnviosPaqueteria').text('-$' + result.totalEnviosPaqueteria);
                        $('#totalNeto').text('$' + result.totalNeto);

                        // Facturación bruta base para cálculo de porcentajes
                        const brutoVal = parseFloat(String(result.totalVentas).replace(/,/g, '')) || 0.01;
                        const netoVal  = parseFloat(String(result.totalNeto).replace(/,/g, '')) || 0;
                        const ivaVal   = parseFloat(String(result.totalIVA).replace(/,/g, '')) || 0;
                        const paqVal   = parseFloat(String(result.totalEnviosPaqueteria).replace(/,/g, '')) || 0;

                        // Actualizar Tabla y Barra Financiera
                        $('#tblTotalVentas').text('$' + result.totalVentas);
                        $('#tblTotalEnvios').text('$' + result.totalEnvios);
                        $('#tblTotalIVA').text('-$' + result.totalIVA);
                        $('#tblTotalPaq').text('-$' + result.totalEnviosPaqueteria);
                        $('#tblTotalNeto').text('$' + result.totalNeto);

                        const pctNeto = Math.max(0, Math.min(100, ((netoVal / brutoVal) * 100).toFixed(1)));
                        const pctIva  = Math.max(0, Math.min(100, ((ivaVal / brutoVal) * 100).toFixed(1)));
                        const pctPaq  = Math.max(0, Math.min(100, ((paqVal / brutoVal) * 100).toFixed(1)));

                        $('#barPctNeto').css('width', pctNeto + '%').attr('title', 'Venta Neta: ' + pctNeto + '%');
                        $('#barPctIva').css('width', pctIva + '%').attr('title', 'IVA: ' + pctIva + '%');
                        $('#barPctLog').css('width', pctPaq + '%').attr('title', 'Costo Paquetería: ' + pctPaq + '%');

                        $('#txtPctNeto').text(pctNeto + '%');
                        $('#txtPctIva').text(pctIva + '%');
                        $('#txtPctLog').text(pctPaq + '%');

                        // 3. Renderizar Top Productos en Leaderboard
                        renderProductos(result.productosMasVendidos);

                        // 4. Renderizar Vendedores
                        renderVendedores(result.vendedoresPrin);

                        // 5. Renderizar Análisis Comercial
                        if (result.analisis) {
                            renderAnalisis(result.analisis);
                        }

                        // 6. Sincronizar Gráfica Mensual
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

        // Renderizado dinámico de la pestaña de Análisis Comercial (Fases 1, 2 y 3)
        function renderAnalisis(an) {
            if (!an) return;

            // Días analizados
            $('#an_badgeDias').text(an.dias || 1);

            // Alerta de Pipeline Abierto (Fase 3)
            if (an.alertaPipeline) {
                $('#an_alertaPipelineContainer').show();
                $('#an_txtAlertPipelineVal').text('$' + (an.pipelineAbiertoValor || '0.00'));
                $('#an_txtAlertRatio').text((an.ratioPipelineVentas || 0) + 'x');
            } else {
                $('#an_alertaPipelineContainer').hide();
            }

            // 1. KPIs Fila 1
            $('#an_tasaConversion').text((an.tasaConversion || 0) + '%');
            $('#an_txtVentasNum').text(Number(an.numeroVentas || 0).toLocaleString());
            $('#an_txtCotisNum').text(Number(an.numCotizaciones || 0).toLocaleString());

            // Semáforo Cotización -> Venta
            const convCls = an.statusConversion === 'verde' ? 'badge-success' : (an.statusConversion === 'amarillo' ? 'badge-warning' : 'badge-danger');
            $('#an_badgeSemConversion').attr('class', 'badge ' + convCls + ' font-weight-bold').text(an.badgeConversion || 'Meta');

            $('#an_ticketPromedio').text('$' + (an.ticketPromedio || '0.00'));
            $('#an_ventasPorDia').text(an.ventasPorDia || 0);
            $('#an_cotizacionesPorDia').text(an.cotizacionesPorDia || 0);
            $('#an_netoPorDia').text('$' + (an.netoPorDia || '0.00'));
            $('#an_netoPorVenta').text(an.netoPorVenta || '0.00');

            // 2. Embudo Fila 2 (con Leads)
            if (an.hasLeads) {
                $('#an_funnelLeadsTxt').html(
                    '<span id="an_funnelLeadsNum">' + Number(an.leads).toLocaleString() + '</span> prospectos ' +
                    '<a href="#" class="text-primary ml-1" data-toggle="modal" data-target="#modalRegistroLeads" title="Editar leads"><i class="fas fa-edit"></i></a>'
                );
                $('#an_barLeadsTxt').text(Number(an.leads).toLocaleString() + ' Leads (Base de Prospección)');

                const leadCol = an.statusLeadConversion === 'verde' ? '#10b981' : (an.statusLeadConversion === 'amarillo' ? '#f59e0b' : '#ef4444');
                const leadCls = an.statusLeadConversion === 'verde' ? 'badge-success' : (an.statusLeadConversion === 'amarillo' ? 'badge-warning' : 'badge-danger');
                $('#an_funnelLeadConvRate').text((an.leadToCotizacion || 0) + '%').css('color', leadCol);
                $('#an_badgeLeadSem').attr('class', 'badge ' + leadCls).text(an.badgeLeadConversion || 'Prospección');
                $('#an_funnelLeadVtaRate').text((an.leadToVenta || 0) + '%');
            } else {
                $('#an_funnelLeadsTxt').html(
                    '<span class="text-muted font-weight-normal">No capturados en el mes</span> ' +
                    '<button type="button" class="btn btn-xs btn-outline-primary py-0 px-2 ml-1" data-toggle="modal" data-target="#modalRegistroLeads" style="font-size: 11px;">' +
                    '<i class="fas fa-plus"></i> Registrar</button>'
                );
                $('#an_barLeadsTxt').text('Sin captura de leads');
                $('#an_funnelLeadConvRate').text('-').css('color', '#64748b');
                $('#an_badgeLeadSem').attr('class', 'badge badge-light text-muted border').text('Sin captura');
                $('#an_funnelLeadVtaRate').text('-');
            }

            $('#an_funnelCotisNum').text(Number(an.numCotizaciones || 0).toLocaleString());
            $('#an_funnelCotisVal').text('$' + (an.totalCotizaciones || '0.00'));
            $('#an_funnelConvRate').text((an.tasaConversion || 0) + '%');
            $('#an_funnelValRate').text((an.conversionValor || 0) + '%');
            $('#an_funnelVentasNum').text(Number(an.numeroVentas || 0).toLocaleString());
            $('#an_funnelVentasVal').text('$' + (an.totalVentas || '0.00'));
            $('#an_funnelMargenRate').text((an.margenNetoPct || 0) + '%');

            const dedRate = Math.max(0, (parseFloat(an.ivaPct || 0) + parseFloat(an.paqueteriaPct || 0)).toFixed(1));
            $('#an_funnelDedRate').text(dedRate + '%');
            $('#an_funnelNetoVal').text('$' + (an.totalNeto || '0.00'));

            const wVtas = Math.max(5, Math.min(100, parseFloat(an.tasaConversion || 0)));
            $('#an_barVentas').css('width', wVtas + '%').text((an.tasaConversion || 0) + '%');
            const wNeto = Math.max(5, Math.min(100, parseFloat(an.margenNetoPct || 0)));
            $('#an_barNeto').css('width', wNeto + '%').text((an.margenNetoPct || 0) + '% del bruto');

            $('#an_pipelineVal').text('$' + (an.pipelineAbiertoValor || '0.00'));
            $('#an_pipelineCant').text(Number(an.pipelineAbiertoCant || 0).toLocaleString() + ' cotizaciones');

            // 3. Salud Logística
            $('#an_logEnvios').text('$' + (an.totalEnvios || '0.00'));
            $('#an_logPaq').text('$' + (an.totalEnviosPaqueteria || '0.00'));
            $('#an_superavitLog').text('$' + (an.superavitLogistico || '0.00'));

            const esSuperavit = parseFloat(an.superavitLogisticoRaw || 0) >= 0;
            if (esSuperavit) {
                $('#an_superavitLog').removeClass('text-danger').addClass('text-success');
                $('#an_badgeSuperavit').removeClass('badge-danger').addClass('badge-success').text('Margen a favor');
            } else {
                $('#an_superavitLog').removeClass('text-success').addClass('text-danger');
                $('#an_badgeSuperavit').removeClass('badge-success').addClass('badge-danger').text('Déficit logístico');
            }

            $('#an_coberturaLog').text((an.coberturaLogistica || 0) + '%');
            const cobCls = an.statusCobertura === 'verde' ? 'badge-success' : (an.statusCobertura === 'amarillo' ? 'badge-warning' : 'badge-danger');
            $('#an_badgeCobertura').attr('class', 'badge ' + cobCls).text(an.badgeCobertura || 'Autosustentable');

            // 4. Proyección al Cierre de Mes
            if (an.mostrarProyeccion) {
                $('#an_proyeccionActiva').show();
                $('#an_proyeccionDisabled').hide();
                $('#an_proyBadge').html('<i class="fas fa-calendar-day mr-1"></i> Día ' + an.diasTranscurridos + ' de ' + an.diasMes + ' · Factor: ' + an.factorProyeccion + 'x')
                    .removeClass('badge-light text-muted border').addClass('text-white').css('background', '#8b5cf6');

                $('#an_proyVentas').text(an.proyVentas);
                $('#an_proyVentasActual').text(Number(an.numeroVentas || 0).toLocaleString());
                $('#an_proyBruto').text('$' + an.proyVentasBrutas);
                $('#an_proyBrutoActual').text('$' + an.totalVentas);
                $('#an_proyNeto').text('$' + an.proyVentaNeta);
                $('#an_proyNetoActual').text('$' + an.totalNeto);
                $('#an_proyCotis').text(an.proyCotizaciones);
                $('#an_proyCotisActual').text(Number(an.numCotizaciones || 0).toLocaleString());
            } else {
                $('#an_proyeccionActiva').hide();
                $('#an_proyeccionDisabled').show();
                $('#an_proyBadge').html('<i class="fas fa-info-circle mr-1"></i> Requiere inicio en día 1 de mes')
                    .removeClass('text-white').addClass('badge-light text-muted border').css('background', '');
            }

            // 5. Tabla Comparativa Histórica (con leads y semáforos)
            if (an.comparativa && an.comparativa.length > 0) {
                let htmlComp = '';
                an.comparativa.forEach(function(row) {
                    const trClass = row.es_mes_actual ? 'table-primary font-weight-bold' : '';
                    const badgeEnCurso = row.es_mes_actual ? ' <span class="badge badge-primary ml-1" style="font-size: 9.5px;">En curso</span>' : '';

                    const semConvCls = row.status_conversion === 'verde' ? 'text-success' : (row.status_conversion === 'amarillo' ? 'text-warning' : 'text-danger');

                    let leadsTd = '<span class="text-muted small">-</span>';
                    if (row.leads_count > 0) {
                        leadsTd = '<span class="font-weight-bold text-info">' + Number(row.leads_count).toLocaleString() + '</span>' +
                            (row.conv_leads_pct !== null ? '<small class="text-muted d-block">' + row.conv_leads_pct + '% cotizan</small>' : '');
                    }

                    let ticketSub = '';
                    if (row.var_ticket !== null && row.var_ticket !== undefined) {
                        const tickCls = row.status_ticket_var === 'verde' ? 'text-success' : (row.status_ticket_var === 'amarillo' ? 'text-warning' : 'text-danger');
                        const sign = parseFloat(row.var_ticket) > 0 ? '+' : '';
                        ticketSub = '<small class="d-block font-weight-bold ' + tickCls + '">' + sign + row.var_ticket + '%</small>';
                    }

                    let varHtml = '<span class="text-muted small">-</span>';
                    if (row.var_neto !== null && row.var_neto !== undefined) {
                        if (parseFloat(row.var_neto) > 0) {
                            varHtml = '<span class="badge badge-success font-weight-bold"><i class="fas fa-arrow-up mr-1"></i>+' + row.var_neto + '%</span>';
                        } else if (parseFloat(row.var_neto) < 0) {
                            varHtml = '<span class="badge badge-danger font-weight-bold"><i class="fas fa-arrow-down mr-1"></i>' + row.var_neto + '%</span>';
                        } else {
                            varHtml = '<span class="badge badge-secondary">0.0%</span>';
                        }
                    }

                    htmlComp += '<tr class="' + trClass + '">' +
                        '<td><strong>' + row.nombre_mes + '</strong>' + badgeEnCurso + '</td>' +
                        '<td class="text-center">' + leadsTd + '</td>' +
                        '<td class="text-center">' + Number(row.cotizaciones_count).toLocaleString() + '<small class="text-muted d-block">$' + row.total_cotizado + '</small></td>' +
                        '<td class="text-center"><span class="badge badge-success px-2 py-1">' + Number(row.ventas_count).toLocaleString() + '</span></td>' +
                        '<td class="text-center"><span class="font-weight-bold ' + semConvCls + '">' + row.conversion_pct + '%</span></td>' +
                        '<td class="text-right">$' + row.ticket_promedio + ticketSub + '</td>' +
                        '<td class="text-right font-weight-bold text-gray-800">$' + row.total_bruto + '</td>' +
                        '<td class="text-right font-weight-bold text-success">$' + row.total_neto + '</td>' +
                        '<td class="text-right text-muted">$' + row.neto_por_dia + '</td>' +
                        '<td class="text-center">' + varHtml + '</td>' +
                    '</tr>';
                });
                $('#an_tbodyComparativa').html(htmlComp);
            }

            // 6. Actualizar Historial de Leads en el Modal
            if (an.listaLeads) {
                let htmlLeads = '';
                if (an.listaLeads.length > 0) {
                    an.listaLeads.forEach(function(l) {
                        htmlLeads += '<tr id="row_lead_' + l.id + '">' +
                            '<td class="font-weight-bold">' + l.mes + '</td>' +
                            '<td class="text-center font-weight-bold text-primary">' + Number(l.leads).toLocaleString() + '</td>' +
                            '<td class="small text-muted">' + (l.notas || '-') + '</td>' +
                            '<td class="text-right">' +
                                '<button type="button" class="btn btn-xs btn-outline-danger py-0 px-2" onclick="eliminarLeadRegistro(' + l.id + ', \'' + l.mes + '\')" title="Eliminar registro">' +
                                    '<i class="fas fa-trash"></i>' +
                                '</button>' +
                            '</td>' +
                        '</tr>';
                    });
                } else {
                    htmlLeads = '<tr id="row_leads_vacio"><td colspan="4" class="text-center py-3 text-muted small">No hay meses registrados aún. Captura el primero arriba.</td></tr>';
                }
                $('#tblHistorialLeads').html(htmlLeads);
            }
        }

        // =====================================================================
        // MANEJADORES DE ACCIONES FASE 3 (LEADS, UMBRALES, EXPORTACIÓN)
        // =====================================================================

        function guardarLeadsMensual(e) {
            e.preventDefault();
            const $btn = $('#btnGuardarLeads');
            const mes = $('#lead_mes').val();
            const leads = $('#lead_cantidad').val();
            const notas = $('#lead_notas').val();
            const fecha_inicio = $('#fecha_inicio').val();
            const fecha_fin = $('#fecha_fin').val();

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'guardarLeads',
                    datos: {
                        mes: mes,
                        leads: leads,
                        notas: notas,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(res) {
                    if (res.success) {
                        $('#modalRegistroLeads').modal('hide');
                        $('#lead_cantidad').val('');
                        $('#lead_notas').val('');
                        if (res.analisis) {
                            renderAnalisis(res.analisis);
                        }
                    } else {
                        alert(res.error || 'Error al guardar leads');
                    }
                },
                error: function() {
                    alert('Error de conexión al guardar los leads.');
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Leads');
                }
            });
        }

        function eliminarLeadRegistro(id, mes) {
            if (!confirm('¿Deseas eliminar el registro de leads del mes ' + mes + '?')) {
                return;
            }
            const fecha_inicio = $('#fecha_inicio').val();
            const fecha_fin = $('#fecha_fin').val();

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'eliminarLeads',
                    datos: {
                        id: id,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(res) {
                    if (res.success && res.analisis) {
                        renderAnalisis(res.analisis);
                    }
                }
            });
        }

        function guardarUmbralesConfig(e) {
            e.preventDefault();
            const $btn = $('#btnGuardarUmbrales');
            const fecha_inicio = $('#fecha_inicio').val();
            const fecha_fin = $('#fecha_fin').val();

            const umbrales = {
                umb_conv_verde: $('#conf_conv_verde').val(),
                umb_conv_amarillo: $('#conf_conv_amarillo').val(),
                umb_cobertura_verde: $('#conf_cob_verde').val(),
                umb_cobertura_amarillo: $('#conf_cob_amarillo').val(),
                umb_lead_conv_verde: $('#conf_lead_verde').val(),
                umb_lead_conv_amarillo: $('#conf_lead_amarillo').val(),
                umb_pipeline_multiplicador: $('#conf_pipeline_mult').val()
            };

            $btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin mr-1"></i> Guardando...');

            $.ajax({
                url: '{{ route('ajax_est_ventas') }}',
                type: 'POST',
                dataType: 'json',
                data: {
                    _token: $('meta[name="csrf-token"]').attr('content'),
                    accion: 'guardarUmbrales',
                    datos: {
                        umbrales: umbrales,
                        fecha_inicio: fecha_inicio,
                        fecha_fin: fecha_fin
                    }
                },
                success: function(res) {
                    if (res.success) {
                        $('#modalConfigUmbrales').modal('hide');
                        if (res.analisis) {
                            renderAnalisis(res.analisis);
                        }
                    }
                },
                complete: function() {
                    $btn.prop('disabled', false).html('<i class="fas fa-save mr-1"></i> Guardar Metas');
                }
            });
        }

        function restablecerUmbralesDefault() {
            $('#conf_conv_verde').val(40);
            $('#conf_conv_amarillo').val(30);
            $('#conf_cob_verde').val(100);
            $('#conf_cob_amarillo').val(90);
            $('#conf_lead_verde').val(2.5);
            $('#conf_lead_amarillo').val(1.8);
            $('#conf_pipeline_mult').val(1.5);
        }

        // Exportación de reporte ejecutivo en formato CSV (compatible Excel con BOM)
        function exportarAnalisisExcel() {
            let csv = '\uFEFF'; // UTF-8 BOM
            csv += 'REPORTE DE ANÁLISIS COMERCIAL - ANDAMIOS LIGEROS\n';
            csv += 'Generado el: ' + new Date().toLocaleDateString('es-MX') + '\n';
            csv += 'Período: ' + ($('#fecha_inicio').val() || 'Todo el historial') + ' al ' + ($('#fecha_fin').val() || 'Hoy') + '\n\n';

            csv += '1. RESUMEN DE KPIs ESTRATÉGICOS\n';
            csv += 'Métrica,Valor\n';
            csv += 'Tasa de Conversión (Cotización a Venta),' + $('#an_tasaConversion').text() + '\n';
            csv += 'Ticket Promedio,' + $('#an_ticketPromedio').text() + '\n';
            csv += 'Ritmo de Ventas por Día,' + $('#an_ventasPorDia').text() + ' vtas/día\n';
            csv += 'Cotizaciones por Día,' + $('#an_cotizacionesPorDia').text() + ' cotis/día\n';
            csv += 'Generación Neta Diaria,' + $('#an_netoPorDia').text() + '\n';
            csv += 'Ingreso Neto por Venta,' + $('#an_netoPorVenta').text() + '\n\n';

            csv += '2. SALUD LOGÍSTICA\n';
            csv += 'Concepto,Monto\n';
            csv += 'Fletes Cobrados al Cliente,' + $('#an_logEnvios').text() + '\n';
            csv += 'Paquetería Pagada a Transportistas,' + $('#an_logPaq').text() + '\n';
            csv += 'Superávit Logístico Net,' + $('#an_superavitLog').text() + '\n';
            csv += 'Cobertura Logística,' + $('#an_coberturaLog').text() + '\n\n';

            csv += '3. COMPARATIVA MENSUAL HISTÓRICA\n';
            csv += 'Mes,Leads,Cotizaciones,Ventas,Conversión %,Ticket Promedio,Facturación Bruta,Venta Neta,Neto por Día,Variación Neto\n';

            $('#an_tbodyComparativa tr').each(function() {
                const cols = [];
                $(this).find('td').each(function() {
                    let text = $(this).text().replace(/\n/g, ' ').replace(/\s+/g, ' ').trim();
                    text = '"' + text.replace(/"/g, '""') + '"';
                    cols.push(text);
                });
                if (cols.length > 0) {
                    csv += cols.join(',') + '\n';
                }
            });

            const blob = new Blob([csv], { type: 'text/csv;charset=utf-8;' });
            const url = URL.createObjectURL(blob);
            const a = document.createElement('a');
            a.href = url;
            a.download = 'analisis_comercial_' + (new Date().toISOString().slice(0, 10)) + '.csv';
            document.body.appendChild(a);
            a.click();
            document.body.removeChild(a);
            URL.revokeObjectURL(url);
        }

        $(document).ready(function() {
            actualizarGrafico();

            // Reajustar tamaño de la gráfica al cambiar de pestaña
            $('a[data-toggle="pill"], a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                if (ventasChart) {
                    ventasChart.resize();
                }
            });

            // Aplicar automáticamente filtro "Este Mes" al abrir la pestaña de Análisis Comercial si está en historial completo
            let analisisAutoFiltrado = false;
            $('#tab-analisis-link').on('shown.bs.tab', function (e) {
                if (!analisisAutoFiltrado && !$('#fecha_inicio').val()) {
                    analisisAutoFiltrado = true;
                    const pill = $('.preset-pill[data-preset="este_mes"]')[0];
                    setPreset('este_mes', pill);
                }
            });

            // Botón de filtro rápido de mes en la card de proyección
            $(document).on('click', '#btnFiltrarEsteMesAnalisis', function(e) {
                e.preventDefault();
                const pill = $('.preset-pill[data-preset="este_mes"]')[0];
                setPreset('este_mes', pill);
            });
        });
    </script>
@stop
