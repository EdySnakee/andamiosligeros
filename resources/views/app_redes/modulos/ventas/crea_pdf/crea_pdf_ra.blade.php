@php
    $color_azul = "#1a4189";
    $color_amarillo = "#ffbb01";
    $nombre_empresa = "REDES ANTICAÍDAS";
    $slogan_empresa = "Seguridad en las alturas para tu proyecto.";
    $desc_empresa_1 = "REDES ANTICAÍDAS DE MÉXICO";
    $desc_empresa_2 = "Especialistas en Redes de Seguridad y Protección en Alturas";
    $desc_empresa_3 = "Venta, Instalación y Asesoría Técnica a Nivel Nacional";
    $beneficiario_banco = "REDES ANTICAÍDAS / ANDAMIOS LIGEROS";
    $cuenta_banco = "012 059 1289";
    $clabe_banco = "012 91000120591289 2";
    $ruta_giro_slug = "redes-anticaidas";

    // Carga de imágenes en Base64 para Dompdf
    $logo_path    = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/logo-redes.jpg');
    $cinta_header = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/Header-Cinta-de-Seguridad.jpg');
    $cinta_footer = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/COTIZACION-Cinta-Seguridad-Hecho-En-Mexico.jpg');
    $logo_bbva    = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/logo-bbva.jpg');
    $logo_mp      = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/mercadopago-logo.jpg');

    $qr_venta = "";
    if (!empty($ventasRedes->id_venta)) {
        $qr_venta = \App\Utilidades::obtenerImagenBase64('storage/qrs_ventas/' . $ventasRedes->id_venta . '.png');
    }
    if (empty($qr_venta)) {
        $qr_venta = \App\Utilidades::obtenerImagenBase64('cotizaciones/img/version-pdf/QR-Andamios.jpg');
    }

    $statusId = $ventasRedes->status ?? 2;
    $statusLabels = [
        2 => ['label' => 'INICIADO', 'bg' => '#0284c7'],
        3 => ['label' => 'PENDIENTE DE LIBERACIÓN', 'bg' => '#f59e0b'],
        4 => ['label' => 'TERMINADO / ENTREGADO', 'bg' => '#10b981'],
        5 => ['label' => 'ENVIADO / EN TRÁNSITO', 'bg' => '#06b6d4'],
    ];
    $statusInfo = $statusLabels[$statusId] ?? ['label' => 'ESTATUS ' . $statusId, 'bg' => '#64748b'];

    $tieneLogistica = !empty($ventasRedes->paqueteria) || !empty($ventasRedes->destino) || !empty($ventasRedes->envio) || !empty($ventasRedes->fecha_envio_paqueteria);
@endphp
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="utf-8">
    <title>Nota de Venta {{ !empty($ventasRedes->cod_venta) ? $ventasRedes->cod_venta : '' }}</title>
    <style>
        @page { margin: 8mm 9mm 8mm 9mm; }
        * { box-sizing: border-box; }
        body {
            font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif;
            margin: 0;
            padding: 0;
            font-size: 10.2px;
            color: #334155;
            line-height: 1.32;
        }
        table { width: 100%; border-collapse: collapse; border-spacing: 0; }
        td { vertical-align: top; padding: 0; }

        .w-100 { width: 100%; }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }

        .cinta-top { width: 100%; height: 5px; display: block; margin-bottom: 6px; }
        .cinta-divider { width: 100%; height: 3px; display: block; margin: 5px 0; }

        /* HEADER */
        .header-table { width: 100%; margin-bottom: 10px; }
        .brand-logo { max-width: 165px; max-height: 56px; }
        .brand-slogan { font-size: 10.5px; font-weight: bold; color: #475569; margin-top: 2px; }
        .brand-company-info { font-size: 9.2px; color: #64748b; line-height: 1.35; margin-top: 3px; }

        /* FOLIO BOX (EXACT WEB DESIGN) */
        .nota-box-folio {
            background-color: #f8fafc;
            border: 2px solid {{ $color_azul }};
            border-radius: 6px;
            padding: 7px 12px;
            text-align: right;
        }
        .nota-title {
            color: {{ $color_azul }};
            font-size: 19px;
            font-weight: 900;
            letter-spacing: 0.6px;
            text-transform: uppercase;
            margin: 0 0 3px 0;
            text-align: right;
        }
        .nota-folio-pill {
            background-color: #e2e8f0;
            color: #0f172a;
            font-size: 14px;
            font-weight: 800;
            padding: 3px 12px;
            border-radius: 4px;
            letter-spacing: 0.5px;
            margin-bottom: 4px;
        }
        .nota-meta-item {
            font-size: 9.6px;
            color: #475569;
            margin-bottom: 2.5px;
            line-height: 1.35;
            text-align: right;
        }
        .tag-cotizacion {
            background-color: #dbeafe;
            color: #1e40af;
            padding: 1.5px 6px;
            border-radius: 3px;
            font-weight: bold;
            font-size: 9.2px;
        }
        .status-pill {
            color: #ffffff;
            padding: 2.5px 8px;
            border-radius: 8px;
            font-weight: bold;
            font-size: 9px;
            text-transform: uppercase;
        }

        /* 3 CARDS TABLE (EXACT WEB DESIGN) */
        .cards-table { width: 100%; margin-bottom: 10px; }
        .info-card {
            background-color: #f8fafc;
            border: 1px solid #cbd5e1;
            border-radius: 6px;
            padding: 7px 9px;
            border-top: 3.5px solid {{ $color_azul }};
            font-size: 9.4px;
            line-height: 1.35;
        }
        .info-card.card-logistica {
            border-top-color: #f59e0b;
        }
        .info-card-header {
            font-size: 10.5px;
            font-weight: 800;
            color: {{ $color_azul }};
            text-transform: uppercase;
            letter-spacing: 0.4px;
            margin-bottom: 5px;
            padding-bottom: 3px;
            border-bottom: 1px dashed #cbd5e1;
        }
        .info-card.card-logistica .info-card-header {
            color: #b45309;
        }
        .info-card-client-name {
            font-size: 11.5px;
            font-weight: 800;
            color: #0f172a;
            margin-bottom: 3px;
        }
        .info-card-row {
            margin-bottom: 2.5px;
            color: #334155;
            font-size: 9.4px;
        }
        .info-card-row strong {
            color: #0f172a;
        }

        /* HEADING BLUE */
        .section-heading-blue {
            color: {{ $color_azul }};
            font-size: 11px;
            font-weight: 800;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #f2bc1c;
            padding-bottom: 3px;
            margin-bottom: 6px;
        }

        /* TABLA DE PRODUCTOS (EXACT WEB DESIGN: SOLID NAVY HEADER + WHITE TEXT) */
        .table-nota-container {
            border: 1px solid #cbd5e1;
            border-radius: 5px;
            overflow: hidden;
            margin-bottom: 10px;
        }
        .table-nota { width: 100%; border-collapse: collapse; }
        .table-nota thead tr {
            background-color: {{ $color_azul }};
            color: #ffffff;
        }
        .table-nota thead th {
            font-size: 9.8px;
            font-weight: 800;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            padding: 6px 6px;
            color: #ffffff;
            border: none;
            vertical-align: middle;
        }
        .table-nota tbody tr {
            border-bottom: 1px solid #e2e8f0;
        }
        .table-nota tbody tr.even {
            background-color: #f8fafc;
        }
        .table-nota tbody td {
            padding: 6.5px 6px;
            font-size: 9.8px;
            color: #1e293b;
            vertical-align: middle;
            border: none;
        }
        .item-sku-badge {
            background-color: #e2e8f0;
            color: #0f172a;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 9.2px;
            font-weight: 700;
            font-family: monospace;
            display: inline-block;
        }
        .item-title {
            font-weight: 700;
            color: #0f172a;
            font-size: 10.8px;
            margin-bottom: 2px;
        }
        .item-subtitle {
            font-size: 9px;
            color: #64748b;
            line-height: 1.3;
        }
        .item-dim-badge {
            display: inline-block;
            background-color: #fef3c7;
            color: #92400e;
            font-size: 8.6px;
            padding: 1.5px 5px;
            border-radius: 3px;
            font-weight: 600;
            margin-top: 2px;
        }

        /* BOTTOM FINANCIAL: BANK + TOTALS (EXACT WEB DESIGN) */
        .bottom-table { width: 100%; margin-top: 4px; margin-bottom: 9px; }
        .bank-details-card {
            background-color: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 6px;
            padding: 7px 10px;
            font-size: 9.4px;
        }
        .bank-logos-table { width: 100%; border-bottom: 1px solid #e2e8f0; padding-bottom: 5px; margin-bottom: 5px; }
        .bank-bbva-img { max-height: 22px; max-width: 76px; }
        .bank-mp-img { max-height: 19px; max-width: 76px; }
        .bank-qr-img { width: 44px; height: 44px; border: 1px solid #cbd5e1; padding: 1px; background: #fff; border-radius: 3px; }
        .bank-info-content { font-size: 9.2px; line-height: 1.45; color: #334155; }
        .bank-info-content strong { color: #0f172a; }
        .bank-security-note {
            font-size: 8.4px;
            color: #64748b;
            margin-top: 5px;
            border-top: 1px dashed #e2e8f0;
            padding-top: 3px;
        }

        .totals-card {
            background-color: {{ $color_amarillo }};
            border-radius: 6px;
            padding: 7px 12px;
        }
        .totals-table { width: 100%; }
        .totals-table td {
            padding: 2.5px 0;
            font-size: 10.5px;
            color: #1e293b;
            font-weight: 600;
            border: none;
        }
        .totals-divider {
            border-top: 1.5px dashed rgba(26, 65, 137, 0.4);
            margin: 3.5px 0;
        }
        .totals-main-row td {
            font-size: 16.5px !important;
            font-weight: 900 !important;
            color: {{ $color_azul }} !important;
            padding-top: 3.5px;
            padding-bottom: 2px;
        }
        .totals-currency-note {
            font-size: 8.4px;
            font-weight: 700;
            color: #1e293b;
            text-align: right;
            margin-top: 2px;
            text-transform: uppercase;
        }

        /* CONDICIONES */
        .condiciones-box {
            border-top: 1px solid #e2e8f0;
            padding-top: 5px;
            margin-top: 4px;
        }
        .condiciones-table { width: 100%; }
        .condiciones-table td {
            width: 50%;
            font-size: 8.4px;
            line-height: 1.38;
            color: #475569;
            padding-right: 8px;
        }
        .cinta-footer { width: 100%; height: 18px; display: block; margin-top: 5px; }
    </style>
</head>
<body>

    <!-- CINTA DE SEGURIDAD TOP -->
    @if($cinta_header) <img src="{{ $cinta_header }}" class="cinta-top"> @endif

    <!-- HEADER: LOGO + NOTA BOX FOLIO -->
    <table class="header-table">
        <tr>
            <td style="width: 55%; vertical-align: middle;">
                @if($logo_path)
                    <img src="{{ $logo_path }}" class="brand-logo"><br>
                @else
                    <div style="font-size: 14px; font-weight: bold; color: {{ $color_azul }};">{{ $nombre_empresa }}</div>
                @endif
                <div class="brand-slogan">{{ $slogan_empresa }}</div>
                <div class="brand-company-info">
                    <strong>{{ $desc_empresa_1 }}</strong><br>
                    {{ $desc_empresa_2 }}<br>
                    {{ $desc_empresa_3 }}
                </div>
            </td>
            <td style="width: 3%;"></td>
            <td style="width: 42%; vertical-align: top;">
                <div class="nota-box-folio">
                    <div class="nota-title">NOTA DE VENTA</div>
                    <table style="width: 100%; margin-bottom: 3px;">
                        <tr>
                            <td style="text-align: right;">
                                <span class="nota-folio-pill">{{ !empty($ventasRedes->cod_venta) ? $ventasRedes->cod_venta : 'SIN FOLIO' }}</span>
                            </td>
                        </tr>
                    </table>
                    <div class="nota-meta-item">
                        <strong>Fecha:</strong> {{ !empty($ventasRedes->fecha_venta_formato) ? $ventasRedes->fecha_venta_formato : (!empty($ventasRedes->fecha_venta) ? date('d/m/Y', strtotime($ventasRedes->fecha_venta)) : date('d/m/Y')) }}
                    </div>
                    @if(!empty($ventasRedes->hora_venta))
                        <div class="nota-meta-item">
                            <strong>Hora:</strong> {{ date('g:i A', strtotime($ventasRedes->hora_venta)) }}
                        </div>
                    @endif
                    @if(!empty($cotizacionesRedes) && !empty($cotizacionesRedes->cod_cotizacion))
                        <div class="nota-meta-item">
                            <strong>Cotización Ref:</strong> <span class="tag-cotizacion">{{ $cotizacionesRedes->cod_cotizacion }}</span>
                        </div>
                    @endif
                    <div class="nota-meta-item" style="margin-top: 2px;">
                        <strong>Estatus:</strong> <span class="status-pill" style="background-color: {{ $statusInfo['bg'] }};">{{ $statusInfo['label'] }}</span>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <!-- LAS 3 CARDS DE INFORMACIÓN COMERCIAL -->
    <table class="cards-table">
        <tr>
            <!-- CARD 1: CLIENTE -->
            <td style="width: {{ $tieneLogistica ? '38%' : '49%' }};">
                <div class="info-card">
                    <div class="info-card-header">Datos del Cliente</div>
                    <div class="info-card-client-name">{{ !empty($infoCliente->nombrecl) ? $infoCliente->nombrecl : 'PÚBLICO GENERAL' }}</div>
                    <div class="info-card-row"><strong>RFC:</strong> {{ !empty($infoCliente->rfccl) ? $infoCliente->rfccl : 'No proporcionado' }}</div>
                    <div class="info-card-row"><strong>Tel:</strong> {{ !empty($infoCliente->telefonocl) ? $infoCliente->telefonocl : 'No registrado' }}</div>
                    @if(!empty($infoCliente->emailcl) || !empty($infoCliente->correocl))
                        <div class="info-card-row"><strong>Correo:</strong> {{ $infoCliente->emailcl ?? $infoCliente->correocl }}</div>
                    @endif
                    <div class="info-card-row"><strong>Dirección:</strong> {{ !empty($infoCliente->direccioncl) ? $infoCliente->direccioncl : 'Domicilio conocido' }}</div>
                    @if(!empty($infoCliente->lugarcl) || !empty($infoCliente->cpcl))
                        <div class="info-card-row"><strong>Ubicación:</strong> {{ $infoCliente->lugarcl ?? '' }} {{ !empty($infoCliente->cpcl) ? 'C.P. ' . $infoCliente->cpcl : '' }}</div>
                    @endif
                </div>
            </td>

            <td style="width: 2%;"></td>

            <!-- CARD 2: ATENCIÓN Y OPERACIÓN -->
            <td style="width: {{ $tieneLogistica ? '32%' : '49%' }};">
                <div class="info-card">
                    <div class="info-card-header">Atención y Operación</div>
                    <div class="info-card-row"><strong>Atendido por:</strong> <span style="font-weight: 700; color: {{ $color_azul }};">{{ !empty($vendedor->name) ? $vendedor->name : 'Asesor Comercial' }}</span></div>
                    @if(!empty($vendedor->email))
                        <div class="info-card-row"><strong>Contacto:</strong> {{ $vendedor->email }}</div>
                    @endif
                    @if(!empty($cotizacionesRedes->constructora))
                        <div class="info-card-row"><strong>Constructora / Obra:</strong> {{ $cotizacionesRedes->constructora }}</div>
                    @endif
                    <div class="info-card-row"><strong>Tipo de Documento:</strong> Nota de Venta en Firme</div>
                    <div class="info-card-row"><strong>Moneda:</strong> Pesos Mexicanos (MXN)</div>
                </div>
            </td>

            @if($tieneLogistica)
                <td style="width: 2%;"></td>

                <!-- CARD 3: LOGÍSTICA Y ENVÍO -->
                <td style="width: 26%;">
                    <div class="info-card card-logistica">
                        <div class="info-card-header">Logística y Envío</div>
                        <div class="info-card-row"><strong>Paquetería:</strong> {{ !empty($ventasRedes->paqueteria) ? $ventasRedes->paqueteria : 'Entrega local' }}</div>
                        @if(!empty($ventasRedes->fecha_envio_paqueteria))
                            <div class="info-card-row"><strong>Fecha de Envío:</strong> {{ date('d/m/Y', strtotime($ventasRedes->fecha_envio_paqueteria)) }}</div>
                        @endif
                        @if(!empty($ventasRedes->origen) || !empty($ventasRedes->destino))
                            <div class="info-card-row"><strong>Ruta:</strong> {{ $ventasRedes->origen ?? 'Planta' }} &rarr; {{ $ventasRedes->destino ?? 'Destino' }}</div>
                        @endif
                        @if(!empty($ventasRedes->paqueteria_2))
                            <div class="info-card-row"><strong>Envío 2:</strong> {{ $ventasRedes->paqueteria_2 }}</div>
                        @endif
                    </div>
                </td>
            @endif
        </tr>
    </table>

    <!-- HEADING PARTIDAS -->
    <div class="section-heading-blue">Detalle de Productos y Partidas</div>

    <!-- TABLA DE PARTIDAS (SOLID NAVY THEAD) -->
    <div class="table-nota-container">
        <table class="table-nota">
            <thead>
                <tr>
                    <th class="text-center" style="width: 5%;">#</th>
                    <th class="text-center" style="width: 8%;">Cant.</th>
                    <th class="text-center" style="width: 14%;">SKU / Código</th>
                    <th class="text-left" style="width: 45%;">Descripción del Producto</th>
                    <th class="text-right" style="width: 14%;">P. Unitario</th>
                    <th class="text-right" style="width: 14%;">Importe</th>
                </tr>
            </thead>
            <tbody>
                @if(!$DetalleCotizaciones->isEmpty())
                    @foreach($DetalleCotizaciones as $index => $item)
                        <tr class="{{ $index % 2 != 0 ? 'even' : '' }}">
                            <td class="text-center" style="font-weight: bold; color: #64748b;">{{ $index + 1 }}</td>
                            <td class="text-center"><span style="font-size: 9.8px; font-weight: 800; color: {{ $color_azul }};">{{ $item->cantidad }}</span></td>
                            <td class="text-center"><span class="item-sku-badge">{{ $item->SKU ?? '-' }}</span></td>
                            <td>
                                <div class="item-title">{{ !empty($item->nombre_producto) ? $item->nombre_producto : (!empty($item->nombre_p) ? $item->nombre_p : 'Producto') }}</div>
                                @if($item->tipo_cobro == 'm2')
                                    <span class="item-dim-badge">Medidas: {{ $item->alto }} m &times; {{ $item->largo }} m</span>
                                @endif
                                @if(!empty($item->titulo_descripcion))
                                    <div class="item-subtitle">{{ $item->titulo_descripcion }}</div>
                                @endif
                            </td>
                            <td class="text-right">${{ number_format($item->precio_unit, 2, '.', ',') }}</td>
                            <td class="text-right" style="font-weight: 800; color: #0f172a;">${{ number_format($item->total_ind, 2, '.', ',') }}</td>
                        </tr>
                    @endforeach
                @else
                    <tr>
                        <td colspan="6" class="text-center" style="padding: 10px; color: #64748b;">No hay partidas registradas en esta nota de venta.</td>
                    </tr>
                @endif
            </tbody>
        </table>
    </div>

    <!-- CINTA INTERMEDIA -->
    @if($cinta_header) <img src="{{ $cinta_header }}" class="cinta-divider"> @endif

    <!-- BLOQUE INFERIOR: BANCO + TOTALES -->
    <table class="bottom-table">
        <tr>
            <!-- BANCO CARD -->
            <td style="width: 58%; vertical-align: top;">
                <div class="bank-details-card">
                    <table class="bank-logos-table">
                        <tr>
                            <td style="vertical-align: middle; width: 35%;">
                                @if($logo_bbva) <img src="{{ $logo_bbva }}" class="bank-bbva-img"> @endif
                            </td>
                            <td style="vertical-align: middle; width: 35%; text-align: center;">
                                @if($logo_mp) <img src="{{ $logo_mp }}" class="bank-mp-img"> @endif
                            </td>
                            <td style="vertical-align: middle; width: 30%; text-align: right;">
                                @if($qr_venta) <img src="{{ $qr_venta }}" class="bank-qr-img"> @endif
                            </td>
                        </tr>
                    </table>
                    <div class="bank-info-content">
                        <strong style="color: {{ $color_azul }};">DATOS PARA PAGO / TRANSFERENCIA (BBVA):</strong><br>
                        <strong>Beneficiario:</strong> {{ $beneficiario_banco }}<br>
                        <strong>Cuenta:</strong> <span style="font-weight: 800; letter-spacing: 0.4px;">{{ $cuenta_banco }}</span><br>
                        <strong>CLABE Interbancaria:</strong> <span style="font-weight: 800; letter-spacing: 0.4px;">{{ $clabe_banco }}</span><br>
                        <strong>Banco:</strong> BBVA México (Moneda Nacional MXN)
                    </div>
                    <div class="bank-security-note">
                        Operación registrada y protegida. Aceptamos transferencias SPEI, depósitos y tarjetas.
                    </div>
                </div>
            </td>

            <td style="width: 2%;"></td>

            <!-- TOTALES CARD -->
            <td style="width: 40%; vertical-align: top;">
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
                                <td class="text-right" style="color: #b91c1c;">-${{ number_format($ventasRedes->descuento_aplicado, 2, '.', ',') }}</td>
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
                            <td>I.V.A. (16%):</td>
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
                    <div class="totals-currency-note">Pesos Mexicanos (M.N.)</div>
                </div>
            </td>
        </tr>
    </table>

    <!-- CONDICIONES Y POLÍTICAS DE ENTREGA -->
    <div class="condiciones-box">
        <div class="section-heading-blue" style="margin-top: 0; margin-bottom: 3px; font-size: 9px;">Condiciones y Políticas de Entrega</div>
        <table class="condiciones-table">
            <tr>
                <td>
                    &bull; <strong>Liberación y entrega:</strong> El despacho se efectúa al acreditarse el saldo total.<br>
                    &bull; <strong>Inspección física:</strong> Verificar cantidades y modelos al recibir el material.<br>
                    &bull; <strong>Garantía de calidad:</strong> Rigurosos controles de resistencia estructural.<br>
                    &bull; <strong>Fichas y normatividad:</strong> Redes de seguridad conforme a especificaciones de obra.
                </td>
                <td>
                    &bull; <strong>Envíos por paquetería:</strong> Tiempos de tránsito sujetos a la empresa transportista.<br>
                    &bull; <strong>Comprobantes fiscales:</strong> Remitir Constancia Fiscal en el mes de compra.<br>
                    &bull; <strong>Aclaraciones:</strong> Notificar con su asesor comercial o departamento logístico.<br>
                    &bull; <strong>Moneda y pagos:</strong> Precios en MXN, entrega sujeta a confirmación bancaria.
                </td>
            </tr>
        </table>
        @if($cinta_footer) <img src="{{ $cinta_footer }}" class="cinta-footer"> @endif
    </div>

</body>
</html>