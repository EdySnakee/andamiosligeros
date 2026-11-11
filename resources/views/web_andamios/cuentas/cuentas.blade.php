@extends('layouts.web_andamios')
@section('css')
    <title>Cuenta Oficial BBVA | Andamios Ligeros</title>
    <meta name="description"
        content="Consulta la cuenta bancaria oficial BBVA de Redes Anticaídas / Andamios Ligeros para realizar tus pagos y transferencias de forma segura." />
    <meta name="keywords" content="cuenta oficial, bbva, pagos, transferencia, andamios ligeros, redes anticaidas" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <meta property="og:title" content="Cuenta Oficial BBVA | Andamios Ligeros" />
    <meta property="og:site_name" content="Andamios Ligeros" />
    <meta property="og:description"
        content="Única cuenta bancaria autorizada para depósitos y transferencias de Andamios Ligeros." />

    <link rel="canonical" href="{{ url('/cuentas-oficiales') }}">
    <meta property="og:url" content="{{ url('/cuentas-oficiales') }}" />

    <style>
        html, body {
            overflow-x: hidden !important;
            max-width: 100vw !important;
        }

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

        .cuentas-page {
            min-height: calc(100vh - 120px);
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(160deg, #f8fafc 0%, #eef2f7 100%);
            padding: 135px 1.25rem 4rem;
            box-sizing: border-box;
        }

        @media (max-width: 1024px) {
            .cuentas-page {
                padding: 105px 1rem 3rem;
            }
        }

        @media (max-width: 767px) {
            .cuentas-page {
                padding: 90px 1rem 2.5rem;
            }
        }

        .cuentas-card {
            width: 100%;
            max-width: 540px;
            background: #ffffff;
            border-radius: 16px;
            box-shadow: 0 20px 50px -12px rgba(15, 23, 42, 0.12), 0 0 0 1px rgba(15, 23, 42, 0.05);
            overflow: hidden;
        }

        .cuentas-accent {
            height: 5px;
            width: 100%;
            background: linear-gradient(90deg, #ffbb01 0%, #ffbb01 45%, #1a4189 100%);
        }

        .cuentas-body {
            padding: 2.25rem 2rem 2.25rem;
            text-align: center;
        }

        @media (max-width: 576px) {
            .cuentas-body {
                padding: 1.75rem 1.25rem 1.85rem;
            }
        }

        .cuentas-badge {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #ecfdf5;
            color: #047857;
            border: 1px solid #a7f3d0;
            font-family: "Poppins", sans-serif;
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 0.9px;
            text-transform: uppercase;
            padding: 5px 14px;
            border-radius: 999px;
            margin-bottom: 1rem;
        }

        .cuentas-title {
            font-family: "Montserrat", sans-serif;
            font-weight: 800;
            font-size: clamp(1.35rem, 2.5vw, 1.75rem);
            color: #0f172a;
            line-height: 1.2;
            margin: 0 0 0.5rem;
        }

        .cuentas-subtitle {
            font-family: "Poppins", sans-serif;
            font-size: 0.92rem;
            line-height: 1.5;
            color: #64748b;
            margin: 0 auto 1.6rem;
            max-width: 420px;
        }

        .bank-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 1.35rem 1.4rem;
            text-align: left;
            margin-bottom: 1.65rem;
        }

        .bank-box-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #e2e8f0;
        }

        .bank-logo {
            height: 28px;
            width: auto;
            object-fit: contain;
        }

        .bank-tag {
            font-family: "Poppins", sans-serif;
            font-size: 0.75rem;
            font-weight: 600;
            color: #1a4189;
            background: #e0ecff;
            padding: 4px 10px;
            border-radius: 6px;
            white-space: nowrap;
        }

        .bank-row {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 12px;
            padding: 0.65rem 0;
        }

        .bank-row + .bank-row {
            border-top: 1px dashed #e2e8f0;
        }

        .bank-label {
            display: block;
            font-family: "Poppins", sans-serif;
            font-size: 0.72rem;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.6px;
            color: #64748b;
            margin-bottom: 2px;
        }

        .bank-value {
            font-family: "Montserrat", sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: #0f172a;
            letter-spacing: 0.3px;
            word-break: break-word;
        }

        .copy-btn {
            flex-shrink: 0;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            background: #ffffff;
            color: #1a4189;
            border: 1px solid #cbd5e1;
            border-radius: 8px;
            padding: 6px 12px;
            font-family: "Poppins", sans-serif;
            font-size: 0.76rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s ease;
        }

        .copy-btn:hover {
            border-color: #1a4189;
            background: #eff6ff;
        }

        .copy-btn.copied {
            background: #ecfdf5;
            border-color: #10b981;
            color: #047857;
        }

        .cuentas-help {
            font-family: "Poppins", sans-serif;
            font-size: 0.85rem;
            color: #64748b;
            margin: 0 0 0.85rem;
        }

        .btn-whatsapp-asesor {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            width: 100%;
            background: #25d366;
            color: #ffffff !important;
            text-decoration: none !important;
            font-family: "Poppins", sans-serif;
            font-size: 0.96rem;
            font-weight: 700;
            padding: 14px 24px;
            border-radius: 10px;
            box-shadow: 0 8px 20px -6px rgba(37, 211, 102, 0.55);
            transition: background-color 0.2s ease, transform 0.2s ease, box-shadow 0.2s ease;
            box-sizing: border-box;
        }

        .btn-whatsapp-asesor:hover {
            background: #1ebe5d;
            color: #ffffff !important;
            transform: translateY(-1px);
            box-shadow: 0 12px 24px -6px rgba(37, 211, 102, 0.65);
        }

        .btn-whatsapp-asesor i {
            font-size: 1.25rem;
        }
    </style>
@stop

@section('content')
    <main class="page-normal cuentas-page">
        <div class="cuentas-card">
            <div class="cuentas-accent"></div>
            <div class="cuentas-body">
                <div class="cuentas-badge">
                    <i class="fa fa-shield" aria-hidden="true"></i>
                    <span>Cuenta Oficial Verificada</span>
                </div>

                <h1 class="cuentas-title">Cuenta Bancaria Oficial</h1>
                <p class="cuentas-subtitle">
                    Única cuenta autorizada para depósitos y transferencias SPEI.
                </p>

                <div class="bank-box">
                    <div class="bank-box-header">
                        <img src="{{ url('cotizaciones/img/logo-bbva.png') }}" alt="BBVA" class="bank-logo">
                        <span class="bank-tag">BBVA México · SPEI</span>
                    </div>

                    <div class="bank-row">
                        <div>
                            <span class="bank-label">Titular</span>
                            <span class="bank-value">REDES ANTICAÍDAS</span>
                        </div>
                    </div>

                    <div class="bank-row">
                        <div>
                            <span class="bank-label">Número de Cuenta</span>
                            <span class="bank-value">012 059 1289</span>
                        </div>
                        <button type="button" class="copy-btn" data-copy="0120591289">
                            <i class="fa fa-clone" aria-hidden="true"></i>
                            <span>Copiar</span>
                        </button>
                    </div>

                    <div class="bank-row">
                        <div>
                            <span class="bank-label">CLABE Interbancaria</span>
                            <span class="bank-value">012 91000120591289 2</span>
                        </div>
                        <button type="button" class="copy-btn" data-copy="012910001205912892">
                            <i class="fa fa-clone" aria-hidden="true"></i>
                            <span>Copiar</span>
                        </button>
                    </div>
                </div>

                <p class="cuentas-help">¿Tienes dudas o deseas enviar tu comprobante de pago?</p>
                <a href="https://api.whatsapp.com/send?phone=525519484708&text=Hola%2C%20me%20gustar%C3%ADa%20contactar%20a%20un%20asesor%20respecto%20a%20la%20cuenta%20oficial%20de%20pago%20de%20Andamios%20Ligeros"
                   onclick="if (typeof gtag === 'function') { gtag('event', 'conversion', {'send_to': 'AW-969584070/0xtZCKSM85AYEMbbqs4D'}); }"
                   target="_blank"
                   rel="noopener"
                   class="btn-whatsapp-asesor">
                    <i class="fa fa-whatsapp" aria-hidden="true"></i>
                    <span>Contactar a un asesor por WhatsApp</span>
                </a>
            </div>
        </div>
    </main>
@stop

@section('js')
    @include('web_andamios.includes.scripts_funciones')
    <script>
        (function () {
            function copiarTexto(texto, btn) {
                function marcarCopiado() {
                    var label = btn.querySelector('span');
                    var icon = btn.querySelector('i');
                    if (btn.classList.contains('copied')) return;
                    btn.classList.add('copied');
                    if (icon) icon.className = 'fa fa-check';
                    if (label) label.textContent = 'Copiado';
                    setTimeout(function () {
                        btn.classList.remove('copied');
                        if (icon) icon.className = 'fa fa-clone';
                        if (label) label.textContent = 'Copiar';
                    }, 1800);
                }

                if (navigator.clipboard && navigator.clipboard.writeText) {
                    navigator.clipboard.writeText(texto).then(marcarCopiado).catch(function () {
                        fallbackCopiar(texto, marcarCopiado);
                    });
                } else {
                    fallbackCopiar(texto, marcarCopiado);
                }
            }

            function fallbackCopiar(texto, onSuccess) {
                var input = document.createElement('textarea');
                input.value = texto;
                input.setAttribute('readonly', '');
                input.style.position = 'fixed';
                input.style.opacity = '0';
                document.body.appendChild(input);
                input.select();
                try {
                    if (document.execCommand('copy')) onSuccess();
                } finally {
                    document.body.removeChild(input);
                }
            }

            document.querySelectorAll('.copy-btn[data-copy]').forEach(function (btn) {
                btn.addEventListener('click', function () {
                    copiarTexto(btn.getAttribute('data-copy'), btn);
                });
            });
        })();
    </script>
@stop
