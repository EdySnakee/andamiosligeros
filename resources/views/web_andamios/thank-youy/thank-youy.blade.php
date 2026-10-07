@extends('layouts.web_andamios')
@section('css')
    <title>¡Gracias por contactarnos! | Andamios Ligeros</title>
    <meta name="description"
        content="En Andamios Ligeros nos enfocamos en que tus andamios sean cada vez más ligeros, seguros y resistentes. ¡Un asesor se comunicará contigo pronto!" />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/img/AndamiosLigeros-Ft-Banner.webp') }}" />
    <meta property="og:image:secure_url" content="{{ url('web/img/AndamiosLigeros-Ft-Banner.webp') }}" />
    <meta property="og:title" content="¡Gracias por contactarnos! | Andamios Ligeros" />
    <meta property="og:site_name" content="Andamios Ligeros | Andamios Galvanizados" />
    <meta property="og:description"
        content="Hemos recibido tu solicitud con éxito. Un asesor especializado se comunicará contigo a la brevedad." />

    <link rel="canonical" href="{{ url('/thank-you') }}">
    <meta property="og:url" content="{{ url('/thank-you') }}" />

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
            padding: 2.2rem 2.25rem 1.6rem;
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
            background: #14a44d !important; /* Verde plano sólido */
            background-image: none !important;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff !important;
            font-size: 28px;
            box-shadow: 0 4px 14px rgba(20, 164, 77, 0.28) !important;
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
            font-size: clamp(1.45rem, 2.8vw, 1.95rem);
            color: #1a202c;
            line-height: 1.2;
            margin: 0 0 0.85rem;
            text-transform: uppercase;
            letter-spacing: -0.3px;
        }

        .ty-subtitle {
            font-family: "Montserrat", sans-serif;
            font-size: 0.94rem;
            line-height: 1.5;
            color: #4a5568;
            max-width: 580px;
            margin: 0 auto 1.35rem;
        }

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

        /* BOTONES INDUSTRIALES ESTILO ANDAMIOS LIGEROS (Slanted + Hard 3D Shadow) */
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
            padding: 10px 22px;
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

        /* Botón Amarillo Marca (Andamios Ligeros) */
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

        /* Botón Catálogo (Azul Marca / Blanco) */
        .al-btn-secondary {
            background: #ffffff;
            color: #0648d6 !important;
            border: 2px solid #0648d6;
            box-shadow: 3px 3px 0px #0648d6;
        }

        .al-btn-secondary:hover {
            background: #0648d6;
            color: #ffffff !important;
            transform: skewX(-12deg) translate(-2px, -2px);
            box-shadow: 5px 5px 0px #1a202c;
        }

        .al-btn-secondary:active {
            transform: skewX(-12deg) translate(2px, 2px);
            box-shadow: 2px 2px 0px #1a202c;
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

    <!-- Event snippet for Formulario de contacto - enviar conversion page -->
    <script>
        if (typeof gtag === 'function') {
            gtag('event', 'conversion', {
                'send_to': 'AW-969584070/fDmdCKqt85AYEMbbqs4D'
            });
        }
    </script>
    <script>
        // Obtener el valor de 'landing' desde el localStorage
        let landing = localStorage.getItem('landing');

        // Verificar si 'landing' es verdadero (no null o vacío)
        if (landing) {
            // Crear el script para el Meta Pixel
            let pixelScript = document.createElement('script');
            pixelScript.innerHTML = `
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '490946903886780');
        fbq('track', 'Purchase', {value: 2299.00, currency: 'MXN'});
    `;

            // Insertar el script en el head de la página
            document.head.appendChild(pixelScript);

            // Crear la etiqueta noscript para el seguimiento en caso de que no haya JavaScript habilitado
            let noScript = document.createElement('noscript');
            noScript.innerHTML = `
        <img height="1" width="1" style="display:none"
        src="https://www.facebook.com/tr?id=490946903886780&ev=PageView&noscript=1"
        />
    `;

            // Insertar el noscript en el body de la página
            document.head.appendChild(noScript);
        }

        document.addEventListener('DOMContentLoaded', function() {
            if (landing) {
                let thanksBtn = document.querySelector('.thank-you-btn');
                if (thanksBtn) {
                    thanksBtn.addEventListener('click', () => {
                        localStorage.removeItem('landing');
                    });
                }
                let navbarEl = document.querySelector('#navbar');
                if (navbarEl) navbarEl.remove();
                let footerEl = document.querySelector('footer');
                if (footerEl) footerEl.remove();
                let whatsFooterEl = document.querySelector('.social-whats-footer');
                if (whatsFooterEl) whatsFooterEl.remove();
            }
        });
    </script>
@stop

@section('content')
    <main class="page-normal">
        <section class="thank-you thank-you-section">
            <div class="thank-you-card cont-thnakyou">
                <div class="ty-accent-bar"></div>
                
                <div class="ty-card-body">
                    <div class="ty-icon-wrapper">
                        <div class="ty-icon-circle">
                            <i class="fa fa-check" aria-hidden="true"></i>
                        </div>
                    </div>

                    <div class="ty-kicker">
                        <i class="fa fa-shield" aria-hidden="true"></i> Solicitud Recibida Con Éxito
                    </div>

                    <h1 class="ty-title">¡Gracias por contactarnos!</h1>
                    
                    <p class="ty-subtitle">
                        Hemos recibido tus datos correctamente. Nuestro equipo de asesores técnicos ya está revisando tu solicitud para brindarte cotización preferencial y asesoría inmediata para tu obra o proyecto.
                    </p>

                    <div class="ty-steps-grid">
                        <div class="ty-step-item">
                            <div class="ty-step-header">
                                <span class="ty-step-num">1</span>
                                <h3 class="ty-step-title">Asesor Asignado</h3>
                            </div>
                            <p class="ty-step-text">Revisamos tus requerimientos técnicos para ofrecerte la configuración ideal de andamio.</p>
                        </div>
                        <div class="ty-step-item">
                            <div class="ty-step-header">
                                <span class="ty-step-num">2</span>
                                <h3 class="ty-step-title">Contacto Rápido</h3>
                            </div>
                            <p class="ty-step-text">Te contactamos por llamada o WhatsApp en breve para confirmar especificaciones.</p>
                        </div>
                        <div class="ty-step-item">
                            <div class="ty-step-header">
                                <span class="ty-step-num">3</span>
                                <h3 class="ty-step-title">Cotización y Envío</h3>
                            </div>
                            <p class="ty-step-text">Recibes tu propuesta formal con las mejores opciones de entrega a todo México.</p>
                        </div>
                    </div>

                    <div class="al-actions-group">
                        <a href="https://api.whatsapp.com/send?phone=+525519484708&text=Hola,%20acabo%20de%20enviar%20mis%20datos%20en%20el%20sitio%20web%20y%20me%20gustar%C3%ADa%20atenci%C3%B3n%20r%C3%A1pida" 
                           target="_blank" rel="noopener" class="al-btn al-btn-whatsapp">
                            <span class="al-btn-inner">
                                <i class="fa fa-whatsapp"></i>
                                <span>Atención por WhatsApp</span>
                            </span>
                        </a>

                        <a class="thank-you-btn al-btn al-btn-primary" href="{{ url('/') }}">
                            <span class="al-btn-inner">
                                <span>Regresar al inicio</span>
                                <i class="fa fa-arrow-right"></i>
                            </span>
                        </a>

                        <a class="al-btn al-btn-secondary" href="{{ url('/productos') }}">
                            <span class="al-btn-inner">
                                <i class="fa fa-th-large"></i>
                                <span>Ver Catálogo</span>
                            </span>
                        </a>
                    </div>

                    <div class="ty-trust-bar">
                        <div class="ty-trust-item">
                            <i class="fa fa-cube"></i>
                            <span>100% Galvanizado</span>
                        </div>
                        <div class="ty-trust-item">
                            <i class="fa fa-bolt"></i>
                            <span>50% Más Ligero</span>
                        </div>
                        <div class="ty-trust-item">
                            <i class="fa fa-truck"></i>
                            <span>Envíos Nacionales</span>
                        </div>
                        <div class="ty-trust-item">
                            <i class="fa fa-phone"></i>
                            <span>Ventas: <strong>55-1948-4708</strong></span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
@stop
@section('js')
@stop
