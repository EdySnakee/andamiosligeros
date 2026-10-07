@php
    use App\Productos;
    use App\DetalleProducto;
    use App\Cotizaciones;
    use App\User;

    // Respaldo por si las variables no vienen del controlador
    $cotizacionesRedes = $cotizacionesRedes ?? (isset($ventasRedes->id_cotizacion) ? Cotizaciones::find($ventasRedes->id_cotizacion) : null);
    $vendedor = $vendedor ?? (isset($ventasRedes->id_usuario_genera) ? User::find($ventasRedes->id_usuario_genera) : null);
    if (!$vendedor && $cotizacionesRedes && !empty($cotizacionesRedes->id_usuario_genera)) {
        $vendedor = User::find($cotizacionesRedes->id_usuario_genera);
    }

    // Identidad y branding dinámico según giro
    $giro = $ventasRedes->giro_empresa ?? 'al';
    if ($giro == 'ra') {
        $bg_color = '#d4b2d3';
        $ruta_logo = url('cotizaciones/img/logo-redes.png');
        $nombre_empresa = 'REDES ANTICAÍDAS';
        $slogan_empresa = 'Seguridad en las alturas para tu proyecto';
        $ruta_giro_slug = 'redes-anticaidas';
    } elseif ($giro == 'rp') {
        $bg_color = '#ddd';
        $ruta_logo = url('cotizaciones/img/redes-perimetrales-logotipo-cotizaion.jpeg');
        $nombre_empresa = 'REDES PERIMETRALES';
        $slogan_empresa = 'Protección perimetral y delimitación segura';
        $ruta_giro_slug = 'redes-perimetrales';
    } elseif ($giro == 'sg') {
        $bg_color = '#7ec25c';
        $ruta_logo = url('cotizaciones/img/logo-scoregol-largo.svg');
        $nombre_empresa = 'SCOREGOL';
        $slogan_empresa = 'Especialistas en redes deportivas y protección';
        $ruta_giro_slug = 'score-gol';
    } else {
        $bg_color = '#7ea7ff';
        $ruta_logo = url('cotizaciones/img/andamios.png');
        $nombre_empresa = 'ANDAMIOS LIGEROS';
        $slogan_empresa = '50% más ligero, misma resistencia.';
        $ruta_giro_slug = 'andamios-ligeros';
    }

    // Mapeo amigable de estatus de venta
    $statusId = $ventasRedes->status ?? 2;
    $statusLabels = [
        2 => ['label' => 'Iniciado', 'class' => 'st-iniciado', 'icon' => 'fa-play-circle'],
        3 => ['label' => 'Pendiente de Liberación', 'class' => 'st-pendiente', 'icon' => 'fa-clock-o'],
        4 => ['label' => 'Terminado / Entregado', 'class' => 'st-terminado', 'icon' => 'fa-check-circle'],
        5 => ['label' => 'Enviado / En Tránsito', 'class' => 'st-enviado', 'icon' => 'fa-truck'],
    ];
    $statusInfo = $statusLabels[$statusId] ?? ['label' => 'Estatus ' . $statusId, 'class' => 'st-default', 'icon' => 'fa-info-circle'];
@endphp

@extends('layouts.vista_cotizador')

@section('css')
    <title>📄 Nota de Venta {{ !empty($ventasRedes->cod_venta) ? $ventasRedes->cod_venta : '' }} | {{ $nombre_empresa }}</title>

    <style>
        /* Desactivar fondos diagonales antiguos */
        .cont-secciones-cotizaciones::after,
        .cont-secciones-cotizaciones::before,
        .cont-secciones-cotizaciones-andamios::after,
        .cont-secciones-cotizaciones-andamios::before {
            display: none !important;
        }

        body#app-layout {
            background: #2b303a !important;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif !important;
            color: #334155;
        }

        /* BARRA SUPERIOR DE HERRAMIENTAS PARA VENDEDORES (NO PRINT) */
        .top-seller-toolbar {
            position: sticky;
            top: 0;
            z-index: 9999;
            background: #111827;
            border-bottom: 2px solid #ffbb01;
            padding: 10px 20px;
            box-shadow: 0 4px 15px rgba(0,0,0,0.3);
        }

        .toolbar-inner {
            max-width: 960px;
            margin: 0 auto;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
            gap: 10px;
        }

        .toolbar-left {
            display: flex;
            align-items: center;
            gap: 12px;
            flex-wrap: wrap;
        }

        .toolbar-right {
            display: flex;
            align-items: center;
            gap: 8px;
            flex-wrap: wrap;
        }

        .tb-tag {
            font-size: 13px;
            font-weight: 700;
            color: #f8fafc;
            display: inline-flex;
            align-items: center;
            gap: 6px;
        }

        .tb-badge-status {
            padding: 4px 10px;
            border-radius: 20px;
            font-size: 12px;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            gap: 5px;
        }

        .st-iniciado { background: #0284c7; color: #fff; }
        .st-pendiente { background: #f59e0b; color: #fff; }
        .st-terminado { background: #10b981; color: #fff; }
        .st-enviado { background: #06b6d4; color: #fff; }
        .st-default { background: #64748b; color: #fff; }

        .btn-tb {
            border: none;
            outline: none;
            cursor: pointer;
            padding: 7px 14px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            text-decoration: none !important;
            transition: all 0.2s ease;
        }

        .btn-tb-primary {
            background: #ffbb01;
            color: #111827 !important;
        }
        .btn-tb-primary:hover {
            background: #f2bc1c;
            transform: translateY(-1px);
        }

        .btn-tb-secondary {
            background: #1e293b;
            color: #f8fafc !important;
            border: 1px solid #334155;
        }
        .btn-tb-secondary:hover {
            background: #334155;
            color: #fff !important;
        }

        .btn-tb-ghost {
            background: transparent;
            color: #cbd5e1 !important;
            border: 1px solid rgba(255,255,255,0.2);
        }
        .btn-tb-ghost:hover {
            background: rgba(255,255,255,0.1);
            color: #fff !important;
        }

        /* HOJA / CONTENEDOR PRINCIPAL DE LA NOTA DE VENTA */
        .nota-wrapper {
            padding: 20px 10px 50px;
            display: flex;
            justify-content: center;
        }

        .nota-card {
            background: #ffffff;
            width: 100%;
            max-width: 920px;
            border-radius: 12px;
            box-shadow: 0 15px 35px rgba(0,0,0,0.25);
            overflow: hidden;
            position: relative;
        }

        .nota-ribbon-top {
            width: 100%;
            display: block;
            height: auto;
        }

        .nota-body {
            padding: 25px 30px;
        }

        /* HEADER DE LA NOTA */
        .nota-header-row {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            gap: 20px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .nota-brand-col {
            flex: 1 1 380px;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .nota-logo-img {
            max-height: 70px;
            max-width: 230px;
            object-fit: contain;
            margin-bottom: 6px;
        }

        .nota-slogan {
            font-size: 13px;
            font-weight: 700;
            color: #475569;
            margin-bottom: 8px;
        }

        .nota-company-info {
            font-size: 12px;
            line-height: 1.5;
            color: #64748b;
        }

        .nota-company-info strong {
            color: #1e293b;
        }

        .nota-box-folio {
            flex: 0 1 320px;
            background: #f8fafc;
            border: 2px solid #1a4189;
            border-radius: 10px;
            padding: 16px 20px;
            text-align: right;
            box-shadow: 0 2px 8px rgba(26, 65, 137, 0.08);
        }

        .nota-title {
            color: #1a4189;
            font-size: 24px;
            font-weight: 900;
            letter-spacing: 0.8px;
            margin: 0 0 4px 0;
            text-transform: uppercase;
        }

        .nota-folio-number {
            font-size: 18px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 8px;
            background: #e2e8f0;
            display: inline-block;
            padding: 3px 12px;
            border-radius: 6px;
            letter-spacing: 0.5px;
        }

        .nota-meta-item {
            font-size: 12px;
            color: #475569;
            margin-bottom: 3px;
            line-height: 1.4;
        }

        .nota-meta-item strong {
            color: #1e293b;
        }

        .tag-cotizacion {
            background: #dbeafe;
            color: #1e40af;
            padding: 2px 7px;
            border-radius: 4px;
            font-weight: 700;
            font-size: 11px;
            text-decoration: none;
        }

        /* GRID DE DATOS COMERCIALES */
        .info-cards-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
            gap: 15px;
            margin-bottom: 25px;
        }

        .info-card {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 14px 16px;
            border-top: 3px solid #1a4189;
        }

        .info-card.card-logistica {
            border-top-color: #f59e0b;
        }

        .info-card-header {
            font-size: 12px;
            font-weight: 800;
            color: #1a4189;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 10px;
            padding-bottom: 6px;
            border-bottom: 1px dashed #cbd5e1;
            display: flex;
            align-items: center;
            gap: 6px;
        }

        .info-card.card-logistica .info-card-header {
            color: #b45309;
        }

        .info-card-row {
            font-size: 12.5px;
            margin-bottom: 5px;
            line-height: 1.45;
            color: #334155;
        }

        .info-card-row strong {
            color: #0f172a;
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.3px;
        }

        .info-card-client-name {
            font-size: 14px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 4px;
        }

        /* TABLA DE PRODUCTOS */
        .section-heading-blue {
            color: #1a4189;
            font-size: 15px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f2bc1c;
            padding-bottom: 6px;
            margin-top: 10px;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .table-nota-container {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            overflow: hidden;
            margin-bottom: 25px;
            background: #fff;
        }

        .table-nota {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .table-nota thead tr {
            background: #1a4189;
            color: #ffffff;
        }

        .table-nota thead th {
            font-size: 12px;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            padding: 12px 10px;
            border: none;
            vertical-align: middle;
        }

        .table-nota tbody tr {
            border-bottom: 1px solid #f1f5f9;
            transition: background 0.15s ease;
        }

        .table-nota tbody tr:nth-child(even) {
            background: #f8fafc;
        }

        .table-nota tbody tr:hover {
            background: #f1f5f9;
        }

        .table-nota tbody td {
            padding: 12px 10px;
            font-size: 13px;
            color: #1e293b;
            vertical-align: middle;
            border: none;
        }

        .item-sku-badge {
            font-family: monospace;
            background: #e2e8f0;
            color: #0f172a;
            padding: 3px 6px;
            border-radius: 4px;
            font-size: 11px;
            font-weight: 700;
            display: inline-block;
        }

        .item-title {
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 2px;
        }

        .item-subtitle {
            font-size: 12px;
            color: #64748b;
        }

        .item-dim-badge {
            display: inline-block;
            background: #fef3c7;
            color: #92400e;
            font-size: 11px;
            padding: 1px 6px;
            border-radius: 4px;
            font-weight: 600;
            margin-top: 3px;
        }

        .cell-mono {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, monospace;
            font-size: 13px;
        }

        /* BLOQUE INFERIOR: BANCO + TOTALES */
        .bottom-financial-row {
            display: flex;
            justify-content: space-between;
            align-items: stretch;
            gap: 20px;
            margin-top: 15px;
            margin-bottom: 25px;
            flex-wrap: wrap;
        }

        .bank-details-card {
            flex: 1 1 420px;
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 10px;
            padding: 18px 20px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
        }

        .bank-logos-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
            margin-bottom: 14px;
            padding-bottom: 10px;
            border-bottom: 1px solid #e2e8f0;
        }

        .bank-bbva-img {
            max-height: 28px;
            width: auto;
        }

        .bank-mp-img {
            max-height: 24px;
            width: auto;
        }

        .bank-qr-img {
            max-height: 65px;
            width: auto;
            border: 1px solid #cbd5e1;
            padding: 3px;
            background: #fff;
            border-radius: 4px;
        }

        .bank-info-content {
            font-size: 12.5px;
            line-height: 1.6;
            color: #334155;
        }

        .bank-info-content strong {
            color: #0f172a;
        }

        .totals-card {
            flex: 0 1 360px;
            background: #ffbb01;
            border-radius: 10px;
            padding: 18px 22px;
            box-shadow: 0 4px 12px rgba(242, 188, 28, 0.25);
            display: flex;
            flex-direction: column;
            justify-content: center;
        }

        .totals-table {
            width: 100%;
            margin-bottom: 0;
            border-collapse: collapse;
        }

        .totals-table td {
            padding: 5px 0;
            font-size: 13.5px;
            color: #1e293b;
            font-weight: 600;
            border: none;
        }

        .totals-table td.text-right {
            text-align: right;
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, monospace;
        }

        .totals-divider {
            border-top: 2px dashed rgba(26, 65, 137, 0.4);
            margin: 8px 0;
        }

        .totals-main-row td {
            font-size: 18px !important;
            font-weight: 900 !important;
            color: #1a4189 !important;
            padding-top: 8px;
        }

        .totals-currency-note {
            font-size: 11px;
            font-weight: 700;
            color: #1e293b;
            text-align: right;
            margin-top: 2px;
            text-transform: uppercase;
        }

        /* CONDICIONES */
        .coti-condiciones-box {
            background: #ffffff;
            border-top: 1px solid #e2e8f0;
            padding-top: 20px;
            margin-top: 10px;
            position: relative;
        }

        .condiciones-grid-2col {
            column-count: 2;
            column-gap: 30px;
            font-size: 12px;
            line-height: 1.5;
            color: #475569;
            margin-bottom: 20px;
        }

        .condiciones-grid-2col p {
            margin: 0 0 7px 0;
        }

        .footer-ribbon-img {
            width: 100%;
            display: block;
            margin-top: 15px;
        }

        /* NOTIFICACIÓN COPIAR */
        #toastNotif {
            position: fixed;
            bottom: 25px;
            right: 25px;
            background: #10b981;
            color: #fff;
            padding: 12px 20px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 700;
            box-shadow: 0 6px 20px rgba(0,0,0,0.25);
            display: none;
            z-index: 99999;
            align-items: center;
            gap: 8px;
        }

        /* ESTILOS DE IMPRESIÓN (PRINT READY) */
        @media print {
            body#app-layout {
                background: #ffffff !important;
                color: #000000 !important;
            }

            .top-seller-toolbar,
            #toastNotif,
            .cont-btn-descarga,
            .cont-pago,
            .botonera-mp {
                display: none !important;
            }

            .nota-wrapper {
                padding: 0 !important;
                margin: 0 !important;
            }

            .nota-card {
                max-width: 100% !important;
                box-shadow: none !important;
                border: none !important;
                border-radius: 0 !important;
            }

            .nota-body {
                padding: 10px 15px !important;
            }

            .table-nota-container {
                border: 1px solid #ccc !important;
            }

            .table-nota thead tr {
                background: #1a4189 !important;
                color: #fff !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .totals-card {
                background: #ffbb01 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .info-card {
                border: 1px solid #ccc !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .nota-box-folio {
                border: 2px solid #1a4189 !important;
                -webkit-print-color-adjust: exact;
                print-color-adjust: exact;
            }

            .page-break {
                page-break-after: always;
            }
        }

        /* RESPONSIVE MÓVIL */
        @media (max-width: 767px) {
            .nota-body {
                padding: 18px 15px;
            }

            .nota-header-row {
                flex-direction: column;
            }

            .nota-box-folio {
                text-align: left;
                flex: 1 1 100%;
            }

            .bottom-financial-row {
                flex-direction: column;
            }

            .totals-card,
            .bank-details-card {
                flex: 1 1 100%;
            }

            .condiciones-grid-2col {
                column-count: 1;
            }

            .toolbar-inner {
                flex-direction: column;
                align-items: flex-start;
            }

            .toolbar-right {
                width: 100%;
                justify-content: flex-start;
            }
        }
    </style>
@stop

@section('content')
    <!-- BARRA SUPERIOR PARA VENDEDORES -->
    <div class="top-seller-toolbar">
        <div class="toolbar-inner">
            <div class="toolbar-left">
                <a href="{{ url('sb-admin/ventas') }}" class="btn-tb btn-tb-ghost">
                    <i class="fa fa-arrow-left"></i> Lista de Ventas
                </a>
                <span class="tb-tag">
                    <i class="fa fa-file-text-o"></i> Nota: <strong>{{ !empty($ventasRedes->cod_venta) ? $ventasRedes->cod_venta : '' }}</strong>
                </span>
                <span class="tb-badge-status {{ $statusInfo['class'] }}">
                    <i class="fa {{ $statusInfo['icon'] }}"></i> {{ $statusInfo['label'] }}
                </span>
            </div>
            <div class="toolbar-right">
                <button type="button" onclick="window.print()" class="btn-tb btn-tb-primary" title="Imprimir Nota de Venta">
                    <i class="fa fa-print"></i> Imprimir Nota
                </button>
                <a href="{{ url('pdfv/' . $ruta_giro_slug . '/' . $ventasRedes->ruta_encrypt) }}" target="_blank" class="btn-tb btn-tb-secondary" title="Descargar como archivo PDF">
                    <i class="fa fa-file-pdf-o"></i> Descargar PDF
                </a>
                <button type="button" id="btnCopiarUrl" class="btn-tb btn-tb-ghost" title="Copiar enlace directo de esta nota">
                    <i class="fa fa-link"></i> Copiar Enlace
                </button>
                @if(!empty($cotizacionesRedes) && !empty($cotizacionesRedes->ruta_encrypt))
                    <a href="{{ url('cotizaciones/' . $ruta_giro_slug . '/' . $cotizacionesRedes->ruta_encrypt) }}" target="_blank" class="btn-tb btn-tb-ghost" title="Consultar cotización origen">
                        <i class="fa fa-external-link"></i> Cotización {{ $cotizacionesRedes->cod_cotizacion }}
                    </a>
                @endif
            </div>
        </div>
    </div>

    <!-- CONTENEDOR PRINCIPAL: NOTA DE VENTA -->
    <div class="nota-wrapper">
        <div class="nota-card">
            <!-- Cinta decorativa superior -->
            <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="nota-ribbon-top" alt="Cinta de Seguridad">

            <div class="nota-body">
                <!-- ENCABEZADO: LOGO + DATOS DE LA NOTA -->
                <div class="nota-header-row">
                    <div class="nota-brand-col">
                        <img src="{{ $ruta_logo }}" alt="{{ $nombre_empresa }}" class="nota-logo-img">
                        <div class="nota-slogan">{{ $slogan_empresa }}</div>
                        <div class="nota-company-info">
                            <strong>{{ $nombre_empresa }} DE MÉXICO</strong><br>
                            Especialistas en Andamiaje y Seguridad en Construcción<br>
                            Venta, Renta y Asesoría Técnica a Nivel Nacional
                        </div>
                    </div>

                    <div class="nota-box-folio">
                        <div class="nota-title">NOTA DE VENTA</div>
                        <div class="nota-folio-number">{{ !empty($ventasRedes->cod_venta) ? $ventasRedes->cod_venta : 'SIN FOLIO' }}</div>
                        
                        <div class="nota-meta-item">
                            <strong>Fecha:</strong> {{ !empty($ventasRedes->fecha_venta_formato) ? $ventasRedes->fecha_venta_formato : $ventasRedes->fecha_venta }}
                        </div>
                        @if(!empty($ventasRedes->hora_venta))
                            <div class="nota-meta-item">
                                <strong>Hora:</strong> {{ date('g:i A', strtotime($ventasRedes->hora_venta)) }}
                            </div>
                        @endif
                        @if(!empty($cotizacionesRedes) && !empty($cotizacionesRedes->cod_cotizacion))
                            <div class="nota-meta-item">
                                <strong>Cotización Ref:</strong>
                                <a href="{{ url('cotizaciones/' . $ruta_giro_slug . '/' . $cotizacionesRedes->ruta_encrypt) }}" target="_blank" class="tag-cotizacion">
                                    {{ $cotizacionesRedes->cod_cotizacion }} <i class="fa fa-external-link"></i>
                                </a>
                            </div>
                        @endif
                        <div class="nota-meta-item" style="margin-top: 6px;">
                            <strong>Estatus:</strong>
                            <span class="tb-badge-status {{ $statusInfo['class'] }}" style="padding: 2px 8px; font-size: 11px;">
                                <i class="fa {{ $statusInfo['icon'] }}"></i> {{ $statusInfo['label'] }}
                            </span>
                        </div>
                    </div>
                </div>

                <!-- TARJETAS DE INFORMACIÓN COMERCIAL -->
                <div class="info-cards-grid">
                    <!-- Tarjeta 1: Datos del Cliente -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fa fa-user"></i> Datos del Cliente
                        </div>
                        <div class="info-card-client-name">
                            {{ !empty($infoCliente->nombrecl) ? $infoCliente->nombrecl : 'PÚBLICO GENERAL' }}
                        </div>
                        <div class="info-card-row">
                            <strong>RFC:</strong> {{ !empty($infoCliente->rfccl) ? $infoCliente->rfccl : 'No proporcionado' }}
                        </div>
                        <div class="info-card-row">
                            <strong>Teléfono:</strong> {{ !empty($infoCliente->telefonocl) ? $infoCliente->telefonocl : 'No registrado' }}
                        </div>
                        @if(!empty($infoCliente->emailcl) || !empty($infoCliente->correocl))
                            <div class="info-card-row">
                                <strong>Correo:</strong> {{ $infoCliente->emailcl ?? $infoCliente->correocl }}
                            </div>
                        @endif
                        <div class="info-card-row">
                            <strong>Dirección:</strong> {{ !empty($infoCliente->direccioncl) ? $infoCliente->direccioncl : 'Domicilio conocido' }}
                        </div>
                        @if(!empty($infoCliente->lugarcl) || !empty($infoCliente->cpcl))
                            <div class="info-card-row">
                                <strong>Ubicación:</strong> {{ $infoCliente->lugarcl ?? '' }} {{ !empty($infoCliente->cpcl) ? 'C.P. ' . $infoCliente->cpcl : '' }}
                            </div>
                        @endif
                    </div>

                    <!-- Tarjeta 2: Atención y Venta -->
                    <div class="info-card">
                        <div class="info-card-header">
                            <i class="fa fa-handshake-o"></i> Atención y Operación
                        </div>
                        <div class="info-card-row">
                            <strong>Atendido por:</strong>
                            <span style="font-weight: 700; color: #1a4189;">{{ !empty($vendedor->name) ? $vendedor->name : 'Asesor Comercial' }}</span>
                        </div>
                        @if(!empty($vendedor->email))
                            <div class="info-card-row">
                                <strong>Contacto Asesor:</strong> {{ $vendedor->email }}
                            </div>
                        @endif
                        @if(!empty($cotizacionesRedes->constructora))
                            <div class="info-card-row">
                                <strong>Constructora / Obra:</strong> {{ $cotizacionesRedes->constructora }}
                            </div>
                        @endif
                        <div class="info-card-row">
                            <strong>Tipo de Documento:</strong> Nota de Venta en Firme
                        </div>
                        <div class="info-card-row">
                            <strong>Moneda:</strong> Pesos Mexicanos (MXN)
                        </div>
                    </div>

                    <!-- Tarjeta 3: Logística y Envío (si aplica) -->
                    @php
                        $tieneLogistica = !empty($ventasRedes->paqueteria) || !empty($ventasRedes->destino) || !empty($ventasRedes->envio) || !empty($ventasRedes->fecha_envio_paqueteria);
                    @endphp
                    @if($tieneLogistica)
                        <div class="info-card card-logistica">
                            <div class="info-card-header">
                                <i class="fa fa-truck"></i> Logística y Envío
                            </div>
                            <div class="info-card-row">
                                <strong>Paquetería:</strong> {{ !empty($ventasRedes->paqueteria) ? $ventasRedes->paqueteria : 'Entrega local / Por convenir' }}
                            </div>
                            @if(!empty($ventasRedes->fecha_envio_paqueteria))
                                <div class="info-card-row">
                                    <strong>Fecha de Envío:</strong> {{ date('d/m/Y', strtotime($ventasRedes->fecha_envio_paqueteria)) }}
                                </div>
                            @endif
                            @if(!empty($ventasRedes->origen) || !empty($ventasRedes->destino))
                                <div class="info-card-row">
                                    <strong>Ruta:</strong> {{ $ventasRedes->origen ?? 'Planta' }} &rarr; {{ $ventasRedes->destino ?? 'Destino Cliente' }}
                                </div>
                            @endif
                            @if(!empty($ventasRedes->paqueteria_2))
                                <div class="info-card-row" style="margin-top: 6px; padding-top: 4px; border-top: 1px dashed #cbd5e1;">
                                    <strong>Segundo Envío:</strong> {{ $ventasRedes->paqueteria_2 }}
                                    @if(!empty($ventasRedes->fecha_envio_paqueteria_2))
                                        ({{ date('d/m/Y', strtotime($ventasRedes->fecha_envio_paqueteria_2)) }})
                                    @endif
                                </div>
                            @endif
                        </div>
                    @endif
                </div>

                <!-- TABLA DE PARTIDAS / PRODUCTOS -->
                <div class="section-heading-blue">
                    <i class="fa fa-cubes"></i> Detalle de Productos y Partidas
                </div>

                <div class="table-nota-container">
                    <div class="table-responsive" style="margin-bottom: 0;">
                        <table class="table table-nota">
                            <thead>
                                <tr>
                                    <th class="text-center" style="width: 45px;">#</th>
                                    <th class="text-center" style="width: 70px;">Cant.</th>
                                    <th class="text-center" style="width: 120px;">SKU / Código</th>
                                    <th>Descripción del Producto</th>
                                    <th class="text-right" style="width: 135px;">P. Unitario</th>
                                    <th class="text-right" style="width: 135px;">Importe</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($DetalleCotizaciones as $index => $item)
                                    <tr>
                                        <td class="text-center text-muted" style="font-weight: 600;">
                                            {{ $index + 1 }}
                                        </td>
                                        <td class="text-center">
                                            <span style="font-size: 14px; font-weight: 800; color: #1a4189;">
                                                {{ $item->cantidad }}
                                            </span>
                                        </td>
                                        <td class="text-center">
                                            @if(!empty($item->SKU))
                                                <span class="item-sku-badge">
                                                    {{ $item->SKU }}
                                                </span>
                                            @else
                                                <span class="text-muted">-</span>
                                            @endif
                                        </td>
                                        <td>
                                            <div class="item-title">
                                                {{ !empty($item->nombre_producto) ? $item->nombre_producto : (!empty($item->nombre_p) ? $item->nombre_p : 'Producto') }}
                                            </div>
                                            @if($item->tipo_cobro == 'm2')
                                                <span class="item-dim-badge">
                                                    <i class="fa fa-arrows-alt"></i> Medidas: {{ $item->alto }} m &times; {{ $item->largo }} m
                                                </span>
                                            @endif
                                            @if(!empty($item->titulo_descripcion))
                                                <div class="item-subtitle">
                                                    {{ $item->titulo_descripcion }}
                                                </div>
                                            @endif
                                        </td>
                                        <td class="text-right cell-mono">
                                            ${{ number_format($item->precio_unit, 2, '.', ',') }}
                                        </td>
                                        <td class="text-right cell-mono" style="font-weight: 800; color: #0f172a;">
                                            ${{ number_format($item->total_ind, 2, '.', ',') }}
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center" style="padding: 30px; color: #64748b;">
                                            <i class="fa fa-inbox fa-2x" style="display:block; margin-bottom: 8px;"></i>
                                            No se encontraron partidas registradas en esta nota de venta.
                                        </td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

                <!-- CINTA INTERMEDIA -->
                <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="nota-ribbon-top" style="border-radius: 0 16px 0 0;" alt="Cinta">

                <!-- BLOQUE INFERIOR: BANCO + TOTALES -->
                <div class="bottom-financial-row">
                    <!-- Columna Izquierda: Datos Bancarios Oficiales -->
                    <div class="bank-details-card">
                        <div>
                            <div class="bank-logos-header">
                                <img src="{{ url('cotizaciones/img/logo-bbva.png') }}" alt="BBVA" class="bank-bbva-img">
                                <img src="{{ url('cotizaciones/img/mercadopago-logo.png') }}" alt="Mercado Pago" class="bank-mp-img">
                                <img src="{{ url('cotizaciones/img/QR-Andamios.png') }}" alt="QR Autenticidad" class="bank-qr-img">
                            </div>
                            <div class="bank-info-content">
                                <strong>DATOS PARA PAGO / TRANSFERENCIA (BBVA):</strong><br>
                                <strong>Beneficiario:</strong> REDES ANTICAÍDAS / ANDAMIOS LIGEROS<br>
                                <strong>Cuenta:</strong> <span style="font-weight: 800; letter-spacing: 0.5px;">012 059 1289</span><br>
                                <strong>CLABE Interbancaria:</strong> <span style="font-weight: 800; letter-spacing: 0.5px;">012 91000120591289 2</span><br>
                                <strong>Banco:</strong> BBVA México (Moneda Nacional MXN)
                            </div>
                        </div>
                        <div style="font-size: 11px; color: #64748b; margin-top: 10px; border-top: 1px dashed #e2e8f0; padding-top: 6px;">
                            <i class="fa fa-shield"></i> Operación registrada y protegida. Aceptamos transferencias SPEI, depósitos y tarjetas.
                        </div>
                    </div>

                    <!-- Columna Derecha: Totales Financieros -->
                    <div class="totals-card">
                        <table class="totals-table">
                            <tr>
                                <td>SUBTOTAL:</td>
                                <td class="text-right">${{ number_format($ventasRedes->subtotal, 2, '.', ',') }}</td>
                            </tr>
                            @if(!empty($ventasRedes->descuento_aplicado) && $ventasRedes->descuento_aplicado > 0)
                                <tr>
                                    <td>
                                        DESCUENTO
                                        @if(!empty($ventasRedes->porcentaje_descuento) && $ventasRedes->porcentaje_descuento > 0)
                                            ({{ $ventasRedes->porcentaje_descuento }}%):
                                        @else
                                            :
                                        @endif
                                    </td>
                                    <td class="text-right" style="color: #b91c1c;">
                                        -${{ number_format($ventasRedes->descuento_aplicado, 2, '.', ',') }}
                                    </td>
                                </tr>
                            @endif
                            @if(!empty($ventasRedes->envio) && $ventasRedes->envio > 0)
                                <tr>
                                    <td>COSTO DE ENVÍO:</td>
                                    <td class="text-right">+${{ number_format($ventasRedes->envio, 2, '.', ',') }}</td>
                                </tr>
                            @endif
                            @if(!empty($ventasRedes->envio_2) && $ventasRedes->envio_2 > 0)
                                <tr>
                                    <td>ENVÍO ADICIONAL:</td>
                                    <td class="text-right">+${{ number_format($ventasRedes->envio_2, 2, '.', ',') }}</td>
                                </tr>
                            @endif
                            <tr>
                                <td>
                                    I.V.A. (16%):
                                </td>
                                <td class="text-right">
                                    @if(!empty($ventasRedes->iva) && $ventasRedes->iva > 0)
                                        ${{ number_format($ventasRedes->iva, 2, '.', ',') }}
                                    @else
                                        $0.00
                                    @endif
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><div class="totals-divider"></div></td>
                            </tr>
                            <tr class="totals-main-row">
                                <td>TOTAL:</td>
                                <td class="text-right">${{ number_format($ventasRedes->total, 2, '.', ',') }}</td>
                            </tr>
                        </table>
                        <div class="totals-currency-note">
                            Pesos Mexicanos (M.N.)
                        </div>
                    </div>
                </div>

                <!-- CONDICIONES Y POLÍTICAS DE VENTA -->
                <div class="coti-condiciones-box">
                    <div class="section-heading-blue" style="margin-top: 0;">
                        <i class="fa fa-info-circle"></i> Condiciones y Políticas de Entrega
                    </div>
                    <div class="condiciones-grid-2col">
                        <p>&bull; <strong>Liberación y entrega:</strong> El despacho de la mercancía se efectúa una vez acreditado y liquidado el saldo total de la presente nota.</p>
                        <p>&bull; <strong>Inspección física:</strong> El cliente o receptor debe verificar cantidades, modelos y estado físico del material en el momento de la entrega.</p>
                        <p>&bull; <strong>Envíos por paquetería externa:</strong> Los tiempos de tránsito y maniobras de descarga quedan sujetos a la logística del transportista.</p>
                        <p>&bull; <strong>Comprobantes fiscales:</strong> Para emisión de factura (CFDI), favor de remitir su Constancia de Situación Fiscal actualizada dentro del mes de compra.</p>
                        <p>&bull; <strong>Garantía de calidad:</strong> Nuestros andamios y sistemas cuentan con rigurosos controles de resistencia, soldadura y estabilidad estructural.</p>
                        <p>&bull; <strong>Aclaraciones:</strong> Cualquier duda o notificación sobre el pedido puede consultarse con su asesor comercial o al departamento de logística.</p>
                    </div>

                    <!-- Cinta decorativa inferior Hecho en México -->
                    <img class="footer-ribbon-img" src="{{ url('cotizaciones/img/COTIZACION-Cinta-Seguridad-Hecho-En-Mexico.png') }}" alt="Cinta Seguridad Hecho en México">
                </div>
            </div>
        </div>
    </div>

    <!-- NOTIFICACIÓN TOAST PARA COPIAR ENLACE -->
    <div id="toastNotif">
        <i class="fa fa-check-circle"></i> ¡Enlace copiado al portapapeles!
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var btnCopiar = document.getElementById('btnCopiarUrl');
            var toast = document.getElementById('toastNotif');

            if (btnCopiar) {
                btnCopiar.addEventListener('click', function() {
                    var currentUrl = window.location.href;
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(currentUrl).then(mostrarToast);
                    } else {
                        // Fallback tradicional
                        var tempInput = document.createElement('input');
                        tempInput.value = currentUrl;
                        document.body.appendChild(tempInput);
                        tempInput.select();
                        try {
                            document.execCommand('copy');
                            mostrarToast();
                        } catch (err) {
                            alert('Enlace: ' + currentUrl);
                        }
                        document.body.removeChild(tempInput);
                    }
                });
            }

            function mostrarToast() {
                if (!toast) return;
                toast.style.display = 'inline-flex';
                setTimeout(function() {
                    toast.style.display = 'none';
                }, 3000);
            }
        });
    </script>
@stop