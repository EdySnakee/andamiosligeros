@extends('layouts.web_andamios')
@section('css')
    <title>Estatus de tu Compra | Andamios Ligeros</title>
    <meta name="description" content="Confirmación y detalles de tu pedido en Andamios Ligeros." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/img/AndamiosLigeros-Ft-Banner.webp') }}" />
    <meta property="og:image:secure_url" content="{{ url('web/img/AndamiosLigeros-Ft-Banner.webp') }}" />
    <meta property="og:title" content="Estatus de tu Compra | Andamios Ligeros" />
    <meta property="og:site_name" content="Andamios Ligeros | Andamios Galvanizados" />
    <meta property="og:description" content="Confirmación y seguimiento de tu orden en Andamios Ligeros." />

    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '5243995428995951');
        fbq('track', 'Purchase');
    </script>
      
    @if (!empty($json_datos_sts_vta->articulo) && (is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['id_producto'] ?? 0) == 1 : ($json_datos_sts_vta->articulo->id_producto ?? 0) == 1))
        @php
            $art_id = is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['id_producto'] ?? '') : ($json_datos_sts_vta->articulo->id_producto ?? '');
            $art_tit = is_array($json_datos_sts_vta->articulo) ? ($json_datos_sts_vta->articulo['titulo'] ?? '') : ($json_datos_sts_vta->articulo->titulo ?? '');
        @endphp
        <script>
            if (typeof ttq !== 'undefined') {
                ttq.track('CompletePayment', {
                    "contents": [{
                        "content_id": "{{ $art_id }}",
                        "content_type": "product",
                        "content_name": "{{ $art_tit }}"
                    }],
                    "value": {{ $json_datos_sts_vta->total_orden ?? 0 }},
                    "currency": "MXN"
                });
            }
        </script>
    @endif

    <link rel="canonical" href="{{ url('/status_venta') }}">
    <meta property="og:url" content="{{ url('/status_venta') }}" />

    <style>
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

        /* HEADER CON FONDO BLANCO SÓLIDO (RESPETANDO POSICIÓN FIJA PARA EL SÚPER MENÚ) */
        body header.andamios-header,
        header.andamios-header,
        .andamios-header {
            background: #ffffff !important;
            background-color: #ffffff !important;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.08) !important;
            z-index: 1000 !important;
        }

        @media (min-width: 1025px) {
            body header.andamios-header,
            header.andamios-header,
            .andamios-header {
                position: fixed !important;
                top: 0 !important;
                left: 0 !important;
                width: 100% !important;
            }
        }

        .page-normal {
            margin-top: 0 !important;
            padding-top: 0 !important;
        }

        .thank-you-section {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            background: linear-gradient(135deg, rgba(17, 24, 39, 0.94) 0%, rgba(13, 31, 56, 0.92) 100%),
                        url("{{ url('web/img/img-banner-andamios-ligeros.webp') }}");
            background-size: cover;
            background-attachment: fixed;
            background-position: center center;
            padding: 130px 1.25rem 2.5rem !important;
            position: relative;
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            .thank-you-section {
                padding: 105px 1rem 2.5rem !important;
            }
        }

        @media (max-width: 767px) {
            .thank-you-section {
                padding: 90px 1rem 2rem !important;
            }
        }

        .thank-you-card {
            width: 100%;
            max-width: 720px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 25px 60px -15px rgba(0, 0, 0, 0.4), 0 0 0 1px rgba(255, 255, 255, 0.1);
            position: relative;
            overflow: hidden;
            animation: tyFadeInUp 0.6s ease-out;
        }

        .ty-accent-bar {
            height: 5px;
            width: 100%;
            background: linear-gradient(90deg, #ffbb01 0%, #ffbb01 45%, #0648d6 100%);
        }

        .ty-card-body {
            padding: 2rem 2.25rem 1.6rem;
            text-align: center;
        }

        .ty-icon-wrapper {
            margin: 0 auto 0.85rem;
            display: inline-flex;
            position: relative;
        }

        /* PALOMITA SIN DEGRADADO (COLOR PLANO SÓLIDO) */
        .ty-icon-circle {
            width: 64px;
            height: 64px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            font-size: 28px;
            background: #14a44d !important;
            background-image: none !important;
            box-shadow: 0 4px 14px rgba(20, 164, 77, 0.28);
        }

        .ty-icon-circle.status-success {
            background: #14a44d !important;
            background-image: none !important;
            box-shadow: 0 4px 14px rgba(20, 164, 77, 0.28);
        }

        .ty-icon-circle.status-pending {
            background: #f59e0b !important;
            background-image: none !important;
            box-shadow: 0 4px 14px rgba(245, 158, 11, 0.28);
        }

        .ty-icon-circle.status-error {
            background: #ef4444 !important;
            background-image: none !important;
            box-shadow: 0 4px 14px rgba(239, 68, 68, 0.28);
        }

        .ty-kicker {
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #eef4ff;
            color: #0648d6;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.2px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 20px;
            margin-bottom: 0.65rem;
            font-family: "Poppins", sans-serif;
        }

        .ty-title {
            font-family: "Montserrat", sans-serif;
            font-weight: 800;
            font-size: clamp(1.4rem, 2.5vw, 1.85rem);
            color: #1a202c;
            line-height: 1.2;
            margin: 0 0 0.9rem;
            text-transform: uppercase;
            letter-spacing: -0.3px;
        }

        /* Badge de Orden Destacada */
        .order-highlight-box {
            background: #f8fafc;
            border: 2px dashed #cbd5e1;
            border-radius: 10px;
            padding: 0.75rem 1.25rem;
            max-width: 440px;
            margin: 0 auto 1.1rem;
            display: flex;
            flex-direction: column;
            gap: 3px;
            align-items: center;
        }

        .order-highlight-label {
            font-family: "Poppins", sans-serif;
            font-size: 0.7rem;
            font-weight: 700;
            letter-spacing: 1.1px;
            color: #64748b;
            text-transform: uppercase;
        }

        .order-highlight-num {
            font-family: "Montserrat", monospace, sans-serif;
            font-size: 1.6rem;
            font-weight: 900;
            color: #0648d6;
            letter-spacing: 1px;
            line-height: 1.1;
        }

        .order-highlight-total {
            font-family: "Montserrat", sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            color: #1e293b;
        }

        .ty-subtitle {
            font-family: "Montserrat", sans-serif;
            font-size: 0.92rem;
            line-height: 1.5;
            color: #4a5568;
            max-width: 580px;
            margin: 0 auto 1.25rem;
        }

        /* 3 Pasos de Seguimiento */
        .ty-steps-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 0.75rem;
            margin-bottom: 1.35rem;
            text-align: left;
        }

        .ty-step-item {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 0.85rem 0.8rem;
            transition: transform 0.25s ease, box-shadow 0.25s ease;
        }

        .ty-step-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 16px -4px rgba(0, 0, 0, 0.08);
            border-color: #cbd5e1;
        }

        .ty-step-header {
            display: flex;
            align-items: center;
            gap: 6px;
            margin-bottom: 0.35rem;
        }

        .ty-step-num {
            width: 22px;
            height: 22px;
            background: #ffbb01;
            color: #1a202c;
            font-size: 0.7rem;
            font-weight: 800;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
            font-family: "Poppins", sans-serif;
        }

        .ty-step-title {
            font-family: "Poppins", sans-serif;
            font-weight: 700;
            font-size: 0.82rem;
            color: #1e293b;
            margin: 0;
        }

        .ty-step-text {
            font-family: "Montserrat", sans-serif;
            font-size: 0.75rem;
            line-height: 1.38;
            color: #64748b;
            margin: 0;
        }

        /* BOTONES INDUSTRIALES ESTILO ANDAMIOS LIGEROS */
        .al-actions-group {
            display: flex;
            flex-wrap: wrap;
            gap: 14px;
            justify-content: center;
            align-items: center;
            margin: 1.35rem 0 1.15rem;
        }

        .al-btn {
            display: inline-block;
            padding: 10px 24px;
            text-decoration: none !important;
            font-family: "Poppins", sans-serif;
            font-size: 0.88rem;
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            transform: skewX(-12deg);
            border: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
        }

        .al-btn-inner {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transform: skewX(12deg);
        }

        /* Botón Amarillo Marca */
        .al-btn-primary {
            background: #ffbb01;
            color: #111827 !important;
            box-shadow: 3px 3px 0px #1a202c;
        }

        .al-btn-primary:hover {
            background: #ffcc22;
            transform: skewX(-12deg) translate(-2px, -2px);
            box-shadow: 5px 5px 0px #1a202c;
            color: #111827 !important;
        }

        .al-btn-primary:active {
            transform: skewX(-12deg) translate(2px, 2px);
            box-shadow: 2px 2px 0px #1a202c;
        }

        /* Botón WhatsApp */
        .al-btn-whatsapp {
            background: #25d366;
            color: #ffffff !important;
            box-shadow: 3px 3px 0px #0b4f26;
        }

        .al-btn-whatsapp:hover {
            background: #2ee271;
            transform: skewX(-12deg) translate(-2px, -2px);
            box-shadow: 5px 5px 0px #0b4f26;
            color: #ffffff !important;
        }

        .al-btn-whatsapp:active {
            transform: skewX(-12deg) translate(2px, 2px);
            box-shadow: 2px 2px 0px #0b4f26;
        }

        /* Barra de Confianza */
        .ty-trust-bar {
            border-top: 1px solid #f1f5f9;
            padding-top: 1.1rem;
            display: flex;
            align-items: center;
            justify-content: space-around;
            flex-wrap: wrap;
            gap: 0.85rem;
        }

        .ty-trust-item {
            display: flex;
            align-items: center;
            gap: 6px;
            font-family: "Montserrat", sans-serif;
            font-size: 0.78rem;
            font-weight: 600;
            color: #64748b;
        }

        .ty-trust-item i {
            color: #ffbb01;
            font-size: 0.9rem;
        }

        .ty-trust-item strong {
            color: #1e293b;
        }

        @keyframes tyFadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @media (max-width: 767px) {
            .thank-you-section {
                padding: 90px 1rem 2rem !important;
            }
            .ty-card-body {
                padding: 1.8rem 1.15rem 1.4rem;
            }
            .order-highlight-num {
                font-size: 1.5rem;
            }
            .ty-steps-grid {
                grid-template-columns: 1fr;
                gap: 0.75rem;
            }
            .al-actions-group {
                flex-direction: column;
                width: 100%;
            }
            .al-btn {
                width: 100%;
                text-align: center;
            }
            .al-btn-inner {
                justify-content: center;
            }
            .ty-trust-bar {
                flex-direction: column;
                gap: 0.65rem;
            }
        }
    </style>
@stop

@section('content')
    @php
        $rawTitulo = $json_datos_sts_vta->titulo_orden ?? 'GRACIAS POR TU COMPRA';
        $cleanTitulo = trim(str_replace(['🌟', '⚠', '❌'], '', $rawTitulo));
        $colorSts = $json_datos_sts_vta->color ?? '#14a44d';
        $numOrden = $json_datos_sts_vta->num_orden ?? '';
        $totalOrden = !empty($json_datos_sts_vta->total_orden) ? (float)$json_datos_sts_vta->total_orden : null;

        $isSuccess = ($colorSts === '#14a44d' || stripos($cleanTitulo, 'GRACIAS') !== false);
        $isPending = ($colorSts === '#e4a11b' || stripos($cleanTitulo, 'PENDIENTE') !== false);
    @endphp

    <main class="page-normal">
        <section class="thank-you-section">
            <div class="thank-you-card">
                <div class="ty-accent-bar" style="{{ $isPending ? 'background: #f59e0b;' : (!$isSuccess ? 'background: #ef4444;' : '') }}"></div>
                
                <div class="ty-card-body">
                    <div class="ty-icon-wrapper">
                        @if($isSuccess)
                            <div class="ty-icon-circle status-success">
                                <i class="fa fa-check" aria-hidden="true"></i>
                            </div>
                        @elseif($isPending)
                            <div class="ty-icon-circle status-pending">
                                <i class="fa fa-clock-o" aria-hidden="true"></i>
                            </div>
                        @else
                            <div class="ty-icon-circle status-error">
                                <i class="fa fa-exclamation" aria-hidden="true"></i>
                            </div>
                        @endif
                    </div>

                    <div class="ty-kicker">
                        <i class="fa fa-shield" aria-hidden="true"></i>
                        @if($isSuccess)
                            COMPRA PROCESADA CON ÉXITO
                        @elseif($isPending)
                            TRANSACCIÓN PENDIENTE
                        @else
                            ACLARACIÓN DE PAGO
                        @endif
                    </div>

                    <h1 class="ty-title">{{ $cleanTitulo }}</h1>

                    @if(!empty($numOrden))
                        <div class="order-highlight-box">
                            <span class="order-highlight-label">Folio de Orden</span>
                            <span class="order-highlight-num">{{ $numOrden }}</span>
                            @if($totalOrden)
                                <span class="order-highlight-total">Total: ${{ number_format($totalOrden, 2) }} MXN</span>
                            @endif
                        </div>
                    @endif

                    <p class="ty-subtitle">
                        @if($isSuccess)
                            Tu compra se ha registrado y confirmado correctamente. Nuestro equipo logístico comenzará la preparación de tu pedido y te mantendremos informado en cada etapa.
                        @elseif($isPending)
                            Tu pago se encuentra en proceso de validación por parte del procesador de pagos. En cuanto sea confirmado, actualizaremos el estatus de tu orden.
                        @else
                            Hubo un inconveniente con el método de pago seleccionado. No te preocupes, con tu número de orden podemos brindarte asistencia directa.
                        @endif
                    </p>

                    @if($isSuccess)
                        <div class="ty-steps-grid">
                            <div class="ty-step-item">
                                <div class="ty-step-header">
                                    <span class="ty-step-num">1</span>
                                    <h3 class="ty-step-title">Orden Confirmada</h3>
                                </div>
                                <p class="ty-step-text">El pago ha sido acreditado y la orden ingresó al sistema de ventas.</p>
                            </div>
                            <div class="ty-step-item">
                                <div class="ty-step-header">
                                    <span class="ty-step-num">2</span>
                                    <h3 class="ty-step-title">Almacén y Embarque</h3>
                                </div>
                                <p class="ty-step-text">Revisión de inventario y preparación técnica del equipo para envío.</p>
                            </div>
                            <div class="ty-step-item">
                                <div class="ty-step-header">
                                    <span class="ty-step-num">3</span>
                                    <h3 class="ty-step-title">Envío y Entrega</h3>
                                </div>
                                <p class="ty-step-text">Coordinamos el despacho y traslado seguro de tu equipo hasta tu destino.</p>
                            </div>
                        </div>
                    @endif

                    <div class="al-actions-group">
                        <a href="https://api.whatsapp.com/send?phone=+525519484708&text=Hola,%20acabo%20de%20realizar%20mi%20compra%20con%20folio%20{{ urlencode($numOrden) }}%20y%20me%20gustar%C3%ADa%20dar%20seguimiento" 
                           target="_blank" rel="noopener" class="al-btn al-btn-whatsapp">
                            <span class="al-btn-inner">
                                <i class="fa fa-whatsapp"></i>
                                <span>Seguimiento por WhatsApp</span>
                            </span>
                        </a>

                        <a href="{{ url('/') }}" class="al-btn al-btn-primary">
                            <span class="al-btn-inner">
                                <span>Regresar al inicio</span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </a>
                    </div>

                    <div class="ty-trust-bar">
                        <div class="ty-trust-item">
                            <i class="fa fa-cube"></i>
                            <span>100% Galvanizado</span>
                        </div>
                        <div class="ty-trust-item">
                            <i class="fa fa-truck"></i>
                            <span>Envíos a Todo México</span>
                        </div>
                        <div class="ty-trust-item">
                            <i class="fa fa-phone"></i>
                            <span>Atención: <strong>55-1948-4708</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
@section('js')
@stop
