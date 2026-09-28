@php
    use App\DetalleProducto;
    $info_det_producto = DetalleProducto::where('id_producto', $idsproducts_unicos[0])->first();

    // Restauramos todos tus giros originales
    if ($cotizacionesRedes->giro_empresa == 'ra') {
        $bg_color = '#d4b2d3';
        $ruta_logo = url('cotizaciones/img/logo-redes.png');
    } elseif ($cotizacionesRedes->giro_empresa == 'rp') {
        $bg_color = '#ddd';
        $ruta_logo = url('cotizaciones/img/redes-perimetrales-logotipo-cotizaion.jpeg');
    } elseif ($cotizacionesRedes->giro_empresa == 'sg') {
        $bg_color = '#7ec25c';
        $ruta_logo = url('cotizaciones/img/logo-scoregol-largo.svg');
    } elseif ($cotizacionesRedes->giro_empresa == 'al') {
        $bg_color = '#7ea7ff !important';
        $ruta_logo = url('cotizaciones/img/andamios.png');
    }
@endphp

@extends('layouts.vista_cotizador')

@section('css')
    <title>📋 Cotización {{ $cotizacionesRedes->cod_cotizacion }} | ANDAMIOS LIGEROS</title>
    <meta property="og:image"
        content="{{ url('storage/productos') }}/{{ $info_det_producto->id_producto }}/{{ $info_det_producto->imagen }}" />

    <meta property="og:image:secure_url"
        content="{{ url('storage/productos') }}/{{ $info_det_producto->id_producto }}/{{ $info_det_producto->imagen }}" />

    <meta property="og:title"
        content="📋✅ Cotización {{ !empty($cotizacionesRedes->tipo_cotizacion) ? $cotizacionesRedes->tipo_cotizacion : '' }} - {{ !empty($cotizacionesRedes->cod_cotizacion) ? $cotizacionesRedes->cod_cotizacion : '' }} | ANDAMIOS LIGEROS" />


    <style>
        /* Ajustes de legibilidad y estructura */
        .cont-secciones-cotizaciones::after,
        .cont-secciones-cotizaciones::before {
            display: none !important;
        }

        .coti-container {
            background: white;
            padding: 0;
            margin-bottom: 20px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            max-width: 900px;
            margin-right: auto !important;
            margin-left: auto !important;
        }

        .coti-body {
            padding: 20px;
        }

        .blue-title {
            color: #1a4189;
            border-bottom: 2px solid #f2bc1c;
            display: inline-block;
            width: 100%;
            margin: 0;
            margin-bottom: 5px;
        }

        .text-blue {
            color: #1a4189;
            font-weight: bold;
        }

        /* Tabla estilizada */
        .table-coti thead {
            background-color: #f8f9fa;
            color: #1a4189;
            font-weight: bold;
        }

        .table-coti tbody tr {
            border-bottom: 1px solid #eee;
        }

        /* Columnas de condiciones */
        .condiciones-wrapper {
            column-count: 2;
            column-gap: 30px;
            font-size: 13px;
            line-height: 1.4;
        }

        @media (max-width: 767px) {
            .coti-body {
                padding: 15px;
            }

            .condiciones-wrapper {
                column-count: 1;
            }

            .res-center {
                text-align: center !important;
            }

            .res-mt {
                margin-top: 15px;
            }
        }

        /* SECCIÓN ESTILOS LOADER */

        #pdf-loader-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-color: #1a418957;
            backdrop-filter: blur(4px);
            z-index: 999999;
            display: none;
            justify-content: center;
            align-items: center;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Tarjeta Blanca */
        .loader-modal {
            background: white;
            width: 90%;
            max-width: 480px;
            padding: 40px 30px;
            border-radius: 8px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2);
            text-align: center;
            position: relative;
            animation: slideUp 0.3s ease-out;
        }

        /* Botón cerrar */
        .loader-close {
            position: absolute;
            top: 15px;
            right: 20px;
            font-size: 24px;
            color: #999;
            cursor: pointer;
        }

        .loader-close:hover {
            color: #555;
        }

        /* Texto */
        .loader-title {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
            margin-bottom: 30px;
            margin-top: 0;
        }

        .loader-desc {
            color: #555;
            font-size: 16px;
            margin-bottom: 10px;
            line-height: 1.4;
        }

        .loader-subtext {
            color: #888;
            font-size: 14px;
        }

        /* Spinner Gradiente (Azul a Verde) */
        .spinner-gradient {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            margin: 30px auto;
            position: relative;
            /* Degradado cónico igual a la imagen */
            background: conic-gradient(#f2bc1c 50%, #1a4189 50%);
            /* Máscara para hacer el anillo */
            -webkit-mask: radial-gradient(farthest-side, transparent calc(100% - 5px), #fff 0);
            mask: radial-gradient(farthest-side, transparent calc(100% - 5px), #fff 0);
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
@stop

@section('content')
    <div id="pdf-loader-overlay">
        <div class="loader-modal">
            <div class="loader-close" id="btn-close-loader">&times;</div>
            <img width="220px" src="{{ $ruta_logo }}" alt="Logo">
            <div class="spinner-gradient"></div>
            <div class="loader-desc">Estamos generando tu cotización para ser descargada.</div>
            <div class="loader-subtext">Esto puede tomar 5-10 segundos aproximadamente.</div>
        </div>
    </div>
    <div class="row-flex">
        <div class="cont-cotizacion">
            <div class="coti-container row">
                <div class="coti-body">
                    <div class="row">
                        <div class="col-md-8 col-xs-12">
                            <h2 class="blue-title"><b>COTIZACIÓN {{ $cotizacionesRedes->cod_cotizacion }}</b></h2>

                            <div class="row" style="font-size: 15px;">
                                <div class="col-md-6">
                                    <p><b>FECHA:</b> {{ $cotizacionesRedes->fecha_formato }}</p>
                                    <p><b>EN ATENCIÓN:</b> {{ $infoCliente->nombrecl ?? 'PUBLICO GENERAL' }}</p>
                                </div>
                                <div class="col-md-6">
                                    <p><b>VENDEDOR:</b> {{ $vendedor->name ?? 'N/A' }}</p>
                                    <p><b>CONSTRUCTORA:</b> {{ $cotizacionesRedes->constructora ?? 'N/A' }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 col-xs-12 text-left res-center res-mt">
                            <img width="220px" src="{{ $ruta_logo }}" alt="Logo">
                            <p style="font-weight: bold; color: #666; margin-top: 5px;">50% mas ligero, misma resistencia.
                            </p>
                        </div>
                    </div>

                    <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="img-responsive"
                        style="width: 100%;">
                    <div class="row" style="margin: 0; margin-bottom:10px">
                        <div class="text-center">
                            @if (!empty($info_det_producto->banner))
                                <img src="{{ url('storage/productos/banners/' . $info_det_producto->banner) }}"
                                    alt="banner" class="cotizacion-banner">
                            @else
                                <img src="{{ url('cotizaciones/img/Banner-Andamios-Ligeros.png') }}"
                                    alt="Banner Andamios Ligeros" class="cotizacion-banner">
                            @endif
                        </div>
                    </div>


                    <div class="row">
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table class="table table-coti text-center">
                                    <thead>
                                        <tr>
                                            <td>CANTIDAD</td>
                                            <td>PRODUCTO</td>
                                            <td>DESCRIPCIÓN</td>
                                            <td>PRECIO UNITARIO</td>
                                            <td>TOTAL</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($DetalleCotizaciones as $result_det_coti)
                                            <tr>
                                                <td>{{ $result_det_coti->cantidad }}</td>
                                                <td>
                                                    <b>{{ $result_det_coti->nombre_p }}</b>
                                                    @if ($result_det_coti->tipo_cobro == 'm2')
                                                        <br><small>{{ $result_det_coti->alto }} x
                                                            {{ $result_det_coti->largo }}</small>
                                                    @endif
                                                </td>
                                                <td><a href="#{{ $result_det_coti->SKU }}" style="color: #007bff;">ANEXO
                                                        {{ $result_det_coti->SKU }}</a></td>
                                                <td>${{ number_format($result_det_coti->precio_unit, 2) }}</td>
                                                <td><b>${{ number_format($result_det_coti->total_ind, 2) }}</b></td>
                                            </tr>
                                        @empty
                                            <tr>
                                                <td colspan="5">No existen productos en esta cotización.</td>
                                            </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>

                    <img src="{{ url('cotizaciones/img/Header-Cinta-de-Seguridad.png') }}" class="img-responsive"
                        style="width: 100%; border-radius: 0 16px 0 0">
                    <div class="row" style="margin-top: 20px;">
                        <div class="col-md-2 col-xs-4">
                            <img src="{{ url('cotizaciones/img/logo-bbva.png') }}" alt="BBVA" class="coti-bbva"
                                style="margin-top: 10px; width:min(100%, 140px);">
                        </div>
                     <div class="col-md-3 col-xs-8">
    <div style="
        font-family: Arial, Helvetica, sans-serif;
        margin-top: 8px;
        color: #333;
        line-height: 1.5;
    ">
        <p style="
            margin: 0 0 7px;
            font-size: 16px;
            font-weight: bold;
            color: #222;
            letter-spacing: 0.3px;
        ">
            REDES ANTICAÍDAS
        </p>

        <p style="
            margin: 0 0 4px;
            font-size: 13px;
            color: #333;
        ">
            <strong>CUENTA:</strong>
            <span style="font-weight: bold; margin-left: 4px;">
                012 059 1289
            </span>
        </p>

        <p style="
            margin: 0;
            font-size: 13px;
            color: #444;
        ">
            <strong>CLABE:</strong>
            <span style="font-weight: bold; margin-left: 4px;">
                012 91000120591289 2
            </span>
        </p>
    </div>
</div>
                        <div class="col-md-2 col-xs-6" style="padding:0;">
                            <img src="{{ url('cotizaciones/img/mercadopago-logo.png') }}" alt="Mercado Pago"
                                class="coti-mp">
                        </div>
                        <div class="col-md-2 col-xs-6 text-right">
                            <img src="{{ url('cotizaciones/img/QR-Andamios.png') }}" alt="QR Andamios Ligeros"
                                class="coti-qr">
                        </div>

                        <div class="col-md-3 col-xs-12 tabla-total-container">
                            <div class="tabla-total">
                                <table class="table table-condensed" style="margin-bottom: 0;">
                                    <tr>
                                        <td>ENVÍO</td>
                                        <td class="text-right">${{ number_format($cotizacionesRedes->envio, 2) }}</td>
                                    </tr>
                                    <tr>
                                        <td>SUBTOTAL</td>
                                        <td class="text-right">${{ number_format($cotizacionesRedes->subtotal, 2) }}</td>
                                    </tr>
                                    @if ($cotizacionesRedes->descuento != 0)
                                        <tr>
                                            <td>DESCUENTO</td>
                                            <td class="text-right">
                                                -${{ number_format($cotizacionesRedes->descuento_aplicado, 2) }}</td>
                                        </tr>
                                    @endif
                                    <tr>
                                        <td>IVA</td>
                                        <td class="text-right">${{ number_format($cotizacionesRedes->iva, 2) }}</td>
                                    </tr>
                                    <tr style="font-size: 1.2em; color: #1a4189;">
                                        <td><b>TOTAL</b></td>
                                        <td class="text-right"><b>${{ number_format($cotizacionesRedes->total, 2) }}</b>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>

                    <div class="row coti-condiciones footer-content">
                        <div class="col-md-8 col-xs-12">
                            <h4 class="text-blue" style="padding: 5px 0;">CONDICIONES</h5>
                                <div class="condiciones-wrapper">
                                    @if (!empty($cotizacionesRedes->configuracion))
                                        {!! $cotizacionesRedes->configuracion !!}
                                    @else
                                        <p>• Pago en una sola exhibición</p>
                                        <p>• Saldo para su liberación y/o envío</p>
                                        <p>• Tiempo de entrega a convenir</p>
                                        <p>• Precios vigentes para el mes en curso</p>
                                        <p>• Verifica cobertura</p>
                                        <p>• Aplican restricciones</p>
                                    @endif
                                </div>
                        </div>
                        <img class="footer-img"
                            src="{{ url('cotizaciones/img/COTIZACION-Cinta-Seguridad-Hecho-En-Mexico.png') }}">
                    </div>

                </div>

            </div>

            @if (!empty($cotizacionesRedes->tipo_cotizacion) && $cotizacionesRedes->tipo_cotizacion == 'Renta')
                @include('app_redes.modulos.cotizador.ver_cotizacion.detalle_renta')
            @else
                @include('app_redes.modulos.cotizador.ver_cotizacion.detalle_productos')
            @endif
            {{-- Barra de Pago de Mercado Pago Suspendida por fraude--}}
            @if ($cotizacionesRedes->mp_status == 'si' and $cotizacionesRedes->status == 1)
                <div class="cont-pago">
                    @include('app_redes.modulos.cotizador.ver_cotizacion.barra_pago')
                </div>
            @endif
        </div>
    </div>

    @if ($tipo_vista == 'Cotizaciones')
        <div class="cont-btn-descarga">
            @if ($cotizacionesRedes->status == 1)
                @if ($cotizacionesRedes->giro_empresa == 'ra')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'rp')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'sg')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}"
                        class="btn-pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'al')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}"
                        class="btn-pdf"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @endif
            @endif
        </div>
    @endif

    @if ($cotizacionesRedes->status == 5)
        <style>
            a:focus,
            a:hover {
                text-decoration: none !important;
            }

            @-webkit-keyframes zcwmini2 {
                0% {
                    box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 0 rgba(0, 0, 0, 0), 0 0 0 0 rgba(207, 8, 8, 0);
                }

                10% {
                    box-shadow: 0 0 8px 6px, 0 0 12px 10px rgba(0, 0, 0, 0), 0 0 12px 14px;
                }

                100% {
                    box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 40px rgba(0, 0, 0, 0), 0 0 0 40px rgba(207, 8, 8, 0);
                }
            }

            .social-whats-footer {
                position: fixed;
                z-index: 8;
                left: 30px;
                bottom: 30px;
            }

            #whatsapp_widget {
                border: 2px #fff solid;
                border-radius: 50%;
                background-color: #00bc5c;
                padding: 7px;
                color: rgba(31, 173, 83, 0.3);
                box-shadow: 2px 2px 3px rgb(0 0 0 / 66%);
                -webkit-animation: zcwmini2 1.5s 0s ease-out infinite;
                -moz-animation: zcwmini2 1.5s 0s ease-out infinite;
                animation: zcwmini2 1.5s 0s ease-out infinite;
            }

            #whatsapp_widget img {
                margin-left: 2px;
                margin-top: -1px;
            }

            #icon_whatsapp_widget {
                width: 80%;
            }

            .social-whats-footer a {
                display: inline-block !important;
            }

            .text-whats {
                background: #f5791f;
                color: white;
                padding: 5px 10px;
                border-radius: 15px;
                border: 0 !important;
            }
        </style>
        <div class="social-whats-footer">
            <a href="https://api.whatsapp.com/send?phone=+529996461314&amp;text=Hola,%20me%20interesa%20actualizar%20los%20precios%20de%20mi%20cotización%20{{ $cotizacionesRedes->cod_cotizacion }}"
                id="whatsapp_widget" class="whatsapp_widget_big" style="width:43px; height:43px; " target="_blank">
                <img src="{{ url('web/img/icon_whatsApp.png') }}" alt="whatsapp icon" id="icon_whatsapp_widget">
            </a>
            <a href="https://api.whatsapp.com/send?phone=+529996461314&amp;text=Hola,%20me%20interesa%20actualizar%20los%20precios%20de%20mi%20cotización%20{{ $cotizacionesRedes->cod_cotizacion }}"
                target="_blank">
                <span class="text-whats">Solicitar nueva Cotización</span>
            </a>
        </div>
    @endif

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const botonesPdf = document.querySelectorAll('.btn-pdf');
            const loader = document.getElementById('pdf-loader-overlay');
            const closeBtn = document.getElementById('btn-close-loader');

            // Función para ocultar loader
            function hideLoader() {
                loader.style.display = 'none';
            }
            if (closeBtn) closeBtn.addEventListener('click', hideLoader);

            botonesPdf.forEach(function(btn) {
                btn.addEventListener('click', function(e) {
                    e.preventDefault();
                    loader.style.display = 'flex'; // Mostrar loader

                    const url = this.getAttribute('href');

                    fetch(url)
                        .then(response => {
                            if (response.status !== 200) throw new Error('Error en descarga');

                            // INTELIGENCIA: Extraer el nombre real que envió el servidor
                            let filename = 'cotizacion.pdf'; // Nombre por defecto porsiaca
                            const disposition = response.headers.get('Content-Disposition');

                            if (disposition && disposition.indexOf('attachment') !== -1) {
                                // Regex para sacar lo que está entre comillas en filename="nombre.pdf"
                                var filenameRegex = /filename[^;=\n]*=((['"]).*?\2|[^;\n]*)/;
                                var matches = filenameRegex.exec(disposition);
                                if (matches != null && matches[1]) {
                                    filename = matches[1].replace(/['"]/g, '');
                                }
                            }

                            return response.blob().then(blob => ({
                                blob,
                                filename
                            }));
                        })
                        .then(({
                            blob,
                            filename
                        }) => {
                            // Crear descarga con el nombre obtenido
                            const downloadUrl = window.URL.createObjectURL(blob);
                            const link = document.createElement('a');
                            link.href = downloadUrl;
                            link.setAttribute('download',
                                filename); // Usamos el nombre del server
                            document.body.appendChild(link);
                            link.click();

                            // Limpiar y cerrar loader
                            link.parentNode.removeChild(link);
                            window.URL.revokeObjectURL(downloadUrl);
                            hideLoader();
                        })
                        .catch(error => {
                            console.error(error);
                            hideLoader();
                            alert('Hubo un error al generar la cotización.');
                        });
                });
            });
        });
    </script>
@stop
