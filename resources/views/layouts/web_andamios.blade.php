<!DOCTYPE html>

<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
  <meta name="csrf-token" content="{{ csrf_token() }}">
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

  <link rel="shortcut icon" href="{{url('web/img/icono2.ico')}}" type="image/x-icon">
  {{-- Preload de recursos críticos para mejorar LCP --}}
  <link rel="preload" href="{{url('loco/css/bootstrap.css')}}" as="style">
  <link rel="preload" href="{{url('web/css/misestilos.css?v=0.7')}}" as="style">
  {{-- Preload de la imagen LCP (fondo CSS bg-items) --}}
  <link rel="preload" href="{{url('web/img/banner/bg-items-andamios.png')}}" as="image" fetchpriority="high">

  <link rel="stylesheet" href="{{url('web/css/misestilos.css?v=0.7')}}">

  {{-- font-awesome local: diferido para no bloquear el render inicial --}}
  <link rel="preload" href="{{url('web/font-awesome/css/font-awesome.css')}}" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="{{url('web/font-awesome/css/font-awesome.css')}}"></noscript>

  {{-- Google Fonts: carga asíncrona para no bloquear el render --}}
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&family=Pacifico&display=swap"
        rel="preload" as="style"
        onload="this.onload=null;this.rel='stylesheet'">
  <noscript>
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700;800;900&family=Poppins:wght@300;400;500;600;700;800;900&family=Pacifico&display=swap" rel="stylesheet">
  </noscript>

  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "name": "Andamios Ligeros",
      "url": "https://andamiosligeros.com/",
      "logo": "https://andamiosligeros.com/web/img/logo-google.jpg"
    }
  </script>
  <!-- Google Tag Manager -->
<script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
})(window,document,'script','dataLayer','GTM-5KTVSTL8');</script>
<!-- End Google Tag Manager -->
</head>

<body>
<!-- Google Tag Manager (noscript) -->
<noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-5KTVSTL8"
height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>
<!-- End Google Tag Manager (noscript) -->
  @include('web_andamios.includes.header.header')
  @yield('content')
  <footer>
    @include('web_andamios.includes.footer')
    @include('web_andamios.includes.redes_sociales_web')
    @include('web_andamios.includes.promo-emergente')
  </footer>

  <script src="{{url('web/js/jquery.min.js')}}"></script>
  <!-- Contact form JavaScript -->
  <script src="{{url('web/js/jqBootstrapValidation.js')}}"></script>
  <script src="{{url('web/js/custom.js')}}"></script>
  <?php /*<script src="{{url('web/js/contact_me.js')}}"></script>*/ ?>
  
  @yield('js')

  {{-- Scripts de tracking al final del body: no bloquean el FCP ni el renderizado --}}
  <script>
    var URL_BASE_WEB = '<?php echo url("/"); ?>';
  </script>
  @include('web_andamios.includes.scripts_seguimiento')
  <!-- Google Tag Manager -->
  <script>(function(w,d,s,l,i){w[l]=w[l]||[];w[l].push({'gtm.start':
  new Date().getTime(),event:'gtm.js'});var f=d.getElementsByTagName(s)[0],
  j=d.createElement(s),dl=l!='dataLayer'?'&l='+l:'';j.async=true;j.src=
  'https://www.googletagmanager.com/gtm.js?id='+i+dl;f.parentNode.insertBefore(j,f);
  })(window,document,'script','dataLayer','GTM-MSBBLNLQ');</script>
  <!-- End Google Tag Manager -->
  <!-- Microsoft Clarity -->
  <script type="text/javascript">
    (function(c,l,a,r,i,t,y){
      c[a]=c[a]||function(){(c[a].q=c[a].q||[]).push(arguments)};
      t=l.createElement(r);t.async=1;t.src="https://www.clarity.ms/tag/"+i;
      y=l.getElementsByTagName(r)[0];y.parentNode.insertBefore(t,y);
    })(window, document, "clarity", "script", "to5ad3fhs2");
  </script>
  {{-- FontAwesome Kit CDN — defer para no bloquear el LCP (cadena de dependencias reducida) --}}
  <script src="https://kit.fontawesome.com/ce8416f34e.js" crossorigin="anonymous" defer></script>
</body>

</html>
