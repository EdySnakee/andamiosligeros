@extends('layouts.web_andamios')
@section('css')
    <title>Gracias por contactanos</title>
    <meta name="description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />
    <?php /*
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-2.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/imgfacebook/redes-anticaidas-facebook-index-3.jpg')}}" />
    */
    ?>
    <meta property="og:title" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:site_name" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />

    <link rel="stylesheet" href="{{ url('web/owl/owlcarousel/assets/owl.carousel.min.css') }}">

    <link rel="canonical" href="{{ url('/thank-you') }}">
    <meta property="og:url" content="{{ url('/thank-you') }}" />
    <style>
        .thank-you {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: url("{{ url('web/img/img-banner-andamios-ligeros.webp') }}");
            background-size: cover;
            background-attachment: fixed;
            background-position: center center;
        }

        .cont-thnakyou {
            width: 50vw;
            background: white;
            padding: 6vw 5vw;
            position: relative;
        }

        .caja-btn {
            margin: 0 auto;
            left: 0;
            bottom: 1.5vw;
            right: 0;
        }

        @media (max-width: 767px) {
            .cont-thnakyou {
                width: 80vw;
                padding: 20vw 5vw;
            }
        }
    </style>
    <!-- Event snippet for Formulario de contacto - enviar conversion page -->
    <script>
        gtag('event', 'conversion', {
            'send_to': 'AW-969584070/fDmdCKqt85AYEMbbqs4D'
        });
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
                thanksBtn.addEventListener('click', () => {
                    localStorage.removeItem('landing');
                })
                document.querySelector('#navbar').remove()
                document.querySelector('footer').remove()
                document.querySelector('.social-whats-footer').remove()
            }
        })
    </script>
@stop

@section('content')
    <main class="page-normal">
        <section class="thank-you">
            <div class="cont-thnakyou text-center">
                <h2>GRACIAS POR CONTACTARNOS</h2>
                <p>En breve un asesor se pondra en contacto contigo para brindarte toda la información solicitada.</p>
                <div class="caja-btn">
                    <a class="thank-you-btn" href="{{ url('/') }}"
                        class="btn-open-modal-financial btn-financial"><span>Regresar al
                            inicio</span></a>
                </div>
            </div>
        </section>
    </main>

@stop
@section('js')

@stop
