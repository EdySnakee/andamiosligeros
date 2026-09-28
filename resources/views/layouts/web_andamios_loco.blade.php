<!DOCTYPE html>
<html class="is-smooth-scroll-compatible is-loading" lang="es">
<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{url('web/img/icono2.ico')}}" type="image/x-icon">
    <!--SEO PARA CADA PÁGINA-->
    @yield('css')
    <!--FIN SEO PARA CADA PÁGINA-->
    <meta name="robots" content="index, follow" />
    <meta name="geo.region" content="MX-YUC" />
    <meta name="geo.placename" content="Mérida" />
    <meta name="geo.position" content="20.98655;-89.658598" />
    <meta name="ICBM" content="20.98655, -89.658598" />
    <meta property="og:type" content="website" />
    <meta property="og:locale" content="es_LA" />
    <meta name="dc.language" content="ES" />
    
    <link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
	<link href="{{url('light/css/plugins.css')}}" rel="stylesheet">
    <link href="{{url('light/css/style.css')}}" rel="stylesheet">
    {{--
    <link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
    <link rel='stylesheet' href='https://use.typekit.net/skn8ash.css'>
    <link rel="stylesheet" href="{{url('loco/css/style-loco.css')}}">
	<link rel="stylesheet" href="{{url('loco/css/main.css')}}">
	--}}
    <link rel="stylesheet" href="{{url('loco/css/style-loco.css')}}">
    <link rel="stylesheet" href="{{url('loco/css/main.css')}}">
    <!-- font awesome CSS -->
    <link href="{{url('web/font-awesome/css/font-awesome.css')}}" rel="stylesheet">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&family=Pacifico&display=swap" rel="stylesheet">
    @include('web_andamios.includes.scripts_seguimiento')
    <style>
        .cont-form-cotiza {
position: fixed;
top: 0;
right: 0;
width: 50vw;
height: 100%;
padding: 5vw;
background: url("{{url('web/img/default_pattern.png')}}"), #ffbb01;
z-index: 99999;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
box-shadow: -0.1vw 0vw 2vw #333;
display: flex;
align-items: center;
justify-content: center;
}
.cont-form-ficha {
position: fixed;
top: 0;
right: 0;
width: 100%;
height: 100%;
padding: 5vw;
background: #1c1c1c40;
z-index: 9999999;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
display: flex;
align-items: center;
justify-content: center;
}
.body-form {
background: white;
padding: 4vw;
position: relative;
}
.btn-send-coti{
border: 0;
cursor: pointer;
padding: 0.5vw 1.5vw;
font-size: 1vw;
border-radius: 0;
background: #0648d6;
color: white;
}
.cont-form-cotiza h1 {
line-height: 1;
margin-bottom: 1vw;
text-transform: uppercase;
color: white;
}
.cerrar {
position: absolute;
top: 4vw;
right: 4vw;
background: white;
padding: 0.5vw 1vw;
border-radius: 0.5vw;
color: #ffbb01;
font-weight: bold;
}
.cerrado {
right: -52vw;
-webkit-transition: all 0.5s ease;
-moz-transition: all 0.5s ease;
-ms-transition: all 0.5s ease;
-o-transition: all 0.5s ease;
transition: all 0.5s ease;
}
.cerrado2 {
top: -100vw;

}
.social-whats-footer {
position: fixed;
z-index: 8;
right: 30px;
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
display: flex;
align-items: center;
justify-content: center;
}

#icon_whatsapp_widget {
width: 50px;
height: 50px;
}
form > div {
    display: block !important;
}
form#cotizaForm {
    width: 80%;
}
    </style>
<script type="application/ld+json">
    {
      "@context":"https://schema.org",
      "@graph":[
        {
          "@type":"Organization",
          "url":"https://andamiosligeros.com/andamios-ligeros-galvanizados-en-merida",
          "logo": "https://andamiosligeros.com/web/img/logo-andamios-merida.webp",
          "name":"Andamios ligeros en Mérida",
          "telephone": "+529996461314",
          "image": [
				"https://andamiosligeros.com/web/img/andamios/andamios-plegables-multiusos-galvanizados.webp",
				"https://andamiosligeros.com/web/img/andamios/andamio-ligero-galvanizado-banquetero-sbt-4.webp",
				"https://andamiosligeros.com/web/img/andamios/andamio-ligero-galvanizado-tradicional-stp2.webp",
				"https://andamiosligeros.com/web/img/andamios/plataforna-para-andamios.webp"
		    ],
          "description":"Obtén Andamios en Mérida al mejor precio, calidad y resistencia a tu alcance. ¡LLAMA AHORA Y COMPRA ANDAMIOS LIGEROS EN MÉRIDA CON NOSOTROS!",
          "inLanguage":"es",
          "address": {
            "@type": "PostalAddress",
            "streetAddress": "colonia, 29b x54, san juan bautista, 97314 Mérida, Yuc.",
            "addressLocality": "Mérida, Yuc.",
            "addressRegion": "MX",
            "postalCode": "97314",
            "addressCountry": "MX"
          }
        }
      ]
    }
  </script>
</head>
<body data-barba="wrapper" data-cursor="true" data-header-sticky="true" data-menu-style="overlay" data-page-layout="light" data-header-layout="dark" data-menu-layout="light" data-footer-layout="light">
    @yield('content')
    
    <script src="{{url('light/js/jquery.min.js')}}"></script>
    <script src="{{url('light/js/plugins.js')}}"></script>
    <script src="{{url('light/js/barba.js')}}"></script>
    <script src="{{url('light/js/gsap.js')}}"></script>
    <script src="{{url('light/js/scripts.js')}}"></script>
    <!-- Contact form JavaScript -->
    <script src="{{url('web/js/jqBootstrapValidation.js')}}"></script>
    <script src="{{url('web/js/custom.js')}}"></script>

    {{--
        <script src='https://unpkg.com/gsap@3/dist/ScrollTrigger.min.js'></script>
        <script src="{{url('loco/js/barba.js')}}"></script>
        <script src="{{url('loco/js/gsap.js')}}"></script>
        <script src="{{url('loco/js/plugins.js')}}"></script>
        <script src="{{url('loco/js/main.js')}}"></script>
    --}}
    
    @yield('js')
    @include('web_andamios.andamios_ubicacion.scripts')
    <script>
  
    </script>
</body>
</html>