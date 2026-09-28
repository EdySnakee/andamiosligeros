    @extends('layouts.web_andamios')
    @section('css')
    <title>Formulario de Distribuidor | Andamios Ligeros</title>
    <meta name="description"
        content="Únete a nuestra red de distribuidores de Andamios Ligeros. Equipos seguros, galvanizados y de alta resistencia para la construcción." />
    <meta name="keywords" content="distribuidor, construccion, Andamios, galvanizados, monterrey, merida, mexico, negocio" />
    <meta property="og:site_name" content="Andamios Ligeros" />
    <meta property="og:description"
        content="Buscamos socios estratégicos. Completa el formulario y descubre los beneficios de distribuir Andamios Ligeros." />

    <link rel="stylesheet" href="{{ url('web/owl/owlcarousel/assets/owl.carousel.min.css') }}">

    <link rel="canonical" href="{{ url('/formulario-distribuidor') }}">
    <meta property="og:url" content="{{ url('/formulario-distribuidor') }}" />


    <style>
        :root {
            --brand-blue: #0948AF;
            --brand-dark: #052c6d;
            --brand-accent: #00bcd4;
            --white: #ffffff;
            --gray-light: #f4f7f6;
            --text-main: #333333;
            --text-muted: #6c757d;
        }

        .formulario-section {
            padding: 80px 0;
            background: linear-gradient(135deg, #fdfbfb 0%, #ebedee 100%);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: flex-start;
            position: relative;
            overflow: hidden;
        }

        /* Decorative Background Elements */
        .formulario-section::before {
            content: "";
            position: absolute;
            top: -10%;
            right: -10%;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle, rgba(9, 72, 175, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .formulario-section::after {
            content: "";
            position: absolute;
            bottom: -5%;
            left: -5%;
            width: 300px;
            height: 300px;
            background: radial-gradient(circle, rgba(0, 188, 212, 0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: 0;
        }

        .form-container {
            width: 100%;
            max-width: 1200px;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            padding: 50px;
            border-radius: 24px;
            box-shadow: 0 20px 50px rgba(0, 0, 0, 0.08);
            margin: 0 auto;
            position: relative;
            z-index: 1;
            border: 1px solid rgba(255, 255, 255, 0.3);
            border-top: 6px solid var(--brand-blue);
            animation: slideUp 0.8s cubic-bezier(0.16, 1, 0.3, 1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .form-container:hover {
            transform: translateY(-5px);
            box-shadow: 0 25px 60px rgba(0, 0, 0, 0.12);
        }

        @keyframes slideUp {
            from {
                opacity: 0;
                transform: translateY(40px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .form-header {
            text-align: center;
            margin-bottom: 50px;
        }

        .form-header h1 {
            color: var(--brand-blue);
            font-family: 'Montserrat', sans-serif;
            font-weight: 900;
            font-size: 3rem;
            margin-bottom: 20px;
            letter-spacing: -1px;
            text-transform: uppercase;
        }

        .form-header .divider {
            width: 80px;
            height: 4px;
            background: var(--brand-accent);
            margin: 0 auto 20px;
            border-radius: 2px;
        }

        .form-header p {
            color: var(--text-muted);
            font-size: 1.2rem;
            max-width: 800px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* Iframe Container Optimization */
        .google-form-wrapper {
            position: relative;
            width: 100%;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: inset 0 2px 10px rgba(0, 0, 0, 0.02);
            /* We use a large min-height for long forms, but the actual iframe height will dictate display */
            min-height: 800px;
        }

        .google-form-wrapper iframe {
            width: 100%;
            display: block;
            border: none;
        }

        @media (max-width: 991px) {
            .form-header h1 {
                font-size: 2.5rem;
            }

            .form-container {
                padding: 40px;
            }
        }

        @media (max-width: 767px) {
            .formulario-section {
                padding: 40px 0;
            }

            .form-container {
                padding: 30px 20px;
                width: 92%;
                border-radius: 16px;
            }

            .form-header h1 {
                font-size: 1.8rem;
            }

            .form-header p {
                font-size: 1rem;
            }
        }

        /* Privacy Download Buttons */
        .download-wrapper {
            text-align: center;
            width: 100%;
        }

        .privacy-download {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            background: var(--brand-blue);
            color: white !important;
            padding: 12px 25px;
            border-radius: 50px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(9, 72, 175, 0.2);
            font-size: 0.95rem;
        }

        .privacy-download:hover {
            background: var(--brand-dark);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(9, 72, 175, 0.3);
            color: white !important;
        }

        .privacy-download i {
            font-size: 1.2rem;
        }
    </style>
    @stop

    @section('content')
    <main class="page-normal">
        <section class="formulario-section">
            <div class="container">
                <div class="form-container">
                    <div class="form-header">
                        <h1>Conviértete en Distribuidor</h1>
                        <div class="divider"></div>
                        <p>Únete a nuestra red nacional y crece con la marca líder en andamios galvanizados de alta resistencia.</p>

                        <div class="download-wrapper">
                            <a href="{{ url('aviso_privacidad/ACUERDO-DE-CONFIDENCIALIDAD-ANDAMIOS-LIGEROS.pdf') }}" target="_blank" class="privacy-download">
                                <i class="fa fa-file-pdf-o"></i> Descargar Acuerdo de Confidencialidad
                            </a>
                        </div>
                    </div>
                    <div class="google-form-wrapper">
                        <!-- El iframe de Google Forms con la altura especificada por el usuario -->
                        <iframe src="https://docs.google.com/forms/d/e/1FAIpQLSf1bTrisRtRTpSJORkDnUO0aauPcKv3-hbHzoSuPDpsGs6WYw/viewform?embedded=true"
                            width="100%"
                            height="6743"
                            frameborder="0"
                            marginheight="0"
                            marginwidth="0">Cargando…</iframe>
                    </div>

                    <div class="download-wrapper">
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 15px;">Antes de enviar, asegúrate de leer nuestro acuerdo de confidencialidad.</p>
                        <a href="{{ url('aviso_privacidad/ACUERDO-DE-CONFIDENCIALIDAD-ANDAMIOS-LIGEROS.pdf') }}" target="_blank" class="privacy-download">
                            <i class="fa fa-file-pdf-o"></i> Descargar Acuerdo de Confidencialidad
                        </a>
                    </div>
                </div>
            </div>
        </section>
    </main>
    @stop

    @section('js')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Scroll logic or interactions if needed
        });
    </script>
    @stop