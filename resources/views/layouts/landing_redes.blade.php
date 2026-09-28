<!DOCTYPE html>
<html lang="es">

<head>
  <meta charset="UTF-8">
  <!-- Responsive Meta -->
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  @if(!empty($Proyectos))
    <title>Mallas anticaidas - {{(!empty($Proyectos->nombre_proyecto)) ? $Proyectos->nombre_proyecto : ''}}</title>
  @else
    <title>Mallas anticaidas - {{(!empty($clientesRedes->nombre_cliente)) ? $clientesRedes->nombre_cliente : ''}}</title>
  @endif
  <!-- favicon & bookmark -->
  <meta name="csrf-token" content="{{ csrf_token() }}">
  <link href="https://fonts.googleapis.com/css?family=PT+Sans:400,700" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i,800,800i" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800" rel="stylesheet">

    <meta property="og:site" content="https://mallasanticaidas.com/" />
    

  @if(!empty($Proyectos))
    <meta property="og:url" content="https://mallasanticaidas.com/proyectos/{{(!empty($Proyectos->url_proyecto)) ? $Proyectos->url_proyecto : ''}}" />
    <meta name="keywords" content="{{(!empty($Proyectos->palabras_clave)) ? $Proyectos->palabras_clave : ''}}"/>
    <meta name="description" content="{{(!empty($Proyectos->descripcion)) ? $Proyectos->descripcion : ''}}"/>
    <meta property="og:title" content="{{(!empty($Proyectos->nombre_proyecto)) ? $Proyectos->nombre_proyecto : ''}}" />
    <meta property="og:site_name" content="{{(!empty($Proyectos->nombre_proyecto)) ? $Proyectos->nombre_proyecto : ''}}" />
    <!--Descripción al compartir-->
    <meta property="og:description" content="{{(!empty($Proyectos->descripcion)) ? $Proyectos->descripcion : ''}}" />
    <meta property="og:image" content="{{url('storage/proyectos')}}/{{$Proyectos->id_proyecto}}/{{$Proyectos->img_portada}}" />
  @else
    
    <meta property="og:url" content="https://mallasanticaidas.com/obras/{{(!empty($clientesRedes->url_cliente)) ? $clientesRedes->url_cliente : ''}}" />
    <meta name="keywords" content="{{(!empty($clientesRedes->palabras_clave)) ? $clientesRedes->palabras_clave : ''}}"/>
    <meta name="description" content="{{(!empty($clientesRedes->descripcion_pry)) ? $clientesRedes->descripcion_pry : ''}}"/>
    <meta name="og:description" content="{{(!empty($clientesRedes->descripcion_pry)) ? $clientesRedes->descripcion_pry : ''}}"/>
    <meta property="og:site_name" content="{{(!empty($clientesRedes->nombre_cliente)) ? $clientesRedes->nombre_cliente : ''}}" />
    <!--Descripción al compartir-->
    <meta property="og:image" content="{{url('storage/clientes/portadas')}}/{{$clientesRedes->id_proyecto}}/{{$clientesRedes->id_cliente}}/{{$clientesRedes->imagenp}}" />
  @endif
 

  <meta property="og:type" content="website" />

  <!-- Stylesheets Start -->
  <link rel="stylesheet" href="{{url('landing/fontawesome.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/bootstrap.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/animate.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/owl.carousel.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/estilos.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/responsivo.css')}}" type="text/css"/>
  <link rel="stylesheet" href="{{url('landing/quill.snow.css')}}" type="text/css"/>
  <link href="{{url('script/css/plugins.css')}}" rel="stylesheet">
  <script>
        var URL_BASE_WEB = '<?php echo url("/"); ?>';
    </script>
  @yield('css')
</head>

<body>
  <div class="wrapper" id="top">
    @include('web_redes.includes_landing.header')
    <!-- Content Section Start -->
    <div class="midd-container">
        @yield('content')
        @include('web_redes.includes_landing.seccionfija')
    </div>
    <!-- Content Section End -->
    <div class="clear"></div>
    <!--footer Start-->
    <footer class="footer-1">
        <div class="container">
            <div class="row">
                <div class="col-md-4 footer-box-1">
                    <div class="footer-logo">
                        <a href="{{url('/')}}" title=""><img src="{{url('landing/imagenes/redes-anticaidas-logitopo-cabecera.png')}}" alt="Cp Silver"></a>
                    </div>
                    <p>REDESANTICAIDAS.MX LE INVITAMOS A QUE COTICE CON NUESTROS ASESORES EXPERTOS, ELLOS TENDRAN LA OPCION MAS VIABLE PARA SU PROYECTO</p>
                </div>
                <div class="col-md-4 footer-box-2">
                    <div class="sec-title">
                        <h4 class="widget-title">Navegar</h4>
                    </div>
                    <ul class="footer-menu">
                        <li><a href="#top">Inicio</a></li>
                        <li><a href="#about">Obras</a></li>
                        <li><a href="#token">Nosotros</a></li>
                        <li><a href="#roadmap">Servicios</a></li>
                        <li><a href="#press">Productos</a></li>
                    </ul>
                    <div class="socials">
                        <ul>
                            <li><a href="http://www.facebook.com/redesanticaidas.mx/"><i class="fa fa-facebook-f"></i> facebook</a></li>
                            <li><a href="http://www.twitter.com/redanticaidas/"><i class="fa fa-twitter"></i> Twitter</a></li>
                            <li><a href="https://www.youtube.com/channel/UCKPFW_c-mNWegyfPddKsxng"><i class="fa fa-youtube"></i> Youtube</a></li>
                        </ul>
                    </div>
                </div>
                <div class="col-md-4 footer-box-3">
                    <div class="hero-right-btn">
                        <a class="btn btn-lg btn-block botonwhatsapp" href="https://api.whatsapp.com/send/?phone=525569328135&text=Quiero+informacion+sobre+las+Redes+Anticaidas&app_absent=0">
                            <svg aria-hidden="true" focusable="false" data-prefix="fab" data-icon="whatsapp" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512" class="svg-inline--fa fa-whatsapp fa-w-14">
                                <path fill="currentColor" d="M380.9 97.1C339 55.1 283.2 32 223.9 32c-122.4 0-222 99.6-222 222 0 39.1 10.2 77.3 29.6 111L0 480l117.7-30.9c32.4 17.7 68.9 27 106.1 27h.1c122.3 0 224.1-99.6 224.1-222 0-59.3-25.2-115-67.1-157zm-157 341.6c-33.2 0-65.7-8.9-94-25.7l-6.7-4-69.8 18.3L72 359.2l-4.4-7c-18.5-29.4-28.2-63.3-28.2-98.2 0-101.7 82.8-184.5 184.6-184.5 49.3 0 95.6 19.2 130.4 54.1 34.8 34.9 56.2 81.2 56.1 130.5 0 101.8-84.9 184.6-186.6 184.6zm101.2-138.2c-5.5-2.8-32.8-16.2-37.9-18-5.1-1.9-8.8-2.8-12.5 2.8-3.7 5.6-14.3 18-17.6 21.8-3.2 3.7-6.5 4.2-12 1.4-32.6-16.3-54-29.1-75.5-66-5.7-9.8 5.7-9.1 16.3-30.3 1.8-3.7.9-6.9-.5-9.7-1.4-2.8-12.5-30.1-17.1-41.2-4.5-10.8-9.1-9.3-12.5-9.5-3.2-.2-6.9-.2-10.6-.2-3.7 0-9.7 1.4-14.8 6.9-5.1 5.6-19.4 19-19.4 46.3 0 27.3 19.9 53.7 22.6 57.4 2.8 3.7 39.1 59.7 94.8 83.8 35.2 15.2 49 16.5 66.6 13.9 10.7-1.6 32.8-13.4 37.4-26.4 4.6-13 4.6-24.1 3.2-26.4-1.3-2.5-5-3.9-10.5-6.6z" class=""></path>
                            </svg> Cotice por Whatsapp
                        </a>
                    </div>
                   <div class="sec-title">
                        <h4 class="widget-title">Cotice nuestros productos</h4>
                    </div>
                    <div class="newsletter">
                        <form id="contactForm" name="sentMessage" novalidate="novalidate" enctype="multipart/form-data">
                          <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <input class="form-control" id="name" type="text" placeholder="Tu nombre *" required="required" data-validation-required-message="Necesitamos tu nombre.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="email" type="email" placeholder="Tu email *" required="required" data-validation-required-message="Necesitamos tu correo.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <input class="form-control" id="celular" type="number" placeholder="Tu celular *" maxlength="10" minlength="10" required="required" data-validation-required-message="Necesitamos tu numero decelular.">
                                    <p class="help-block text-danger"></p>
                                </div>
                                <div class="form-group">
                                    <textarea class="form-control" id="message" placeholder="Mensaje "></textarea>
                                    <p class="help-block text-danger"></p>
                                </div>
                            </div>
                            <div class="clearfix"></div>
                            <div class="col-md-12 text-center">
                              <div id="success"></div>
                              
                              <button id="sendMessageButton" class="btn btn-primary btn-xl text-uppercase" type="submit">Enviar mensaje</button>
                            </div>
                          </div>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-4">
                    <div class="copyrights style-1">
                        © 2021 Redesanticaidas.mx - Todos los derechos reservados
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!--footer end-->
  </div>
  <script src="{{url('landing/jquery-2.2.4.min.js')}}" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>

  <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDtTrroMJ-mYXu8IupnvruJTlpFE5foi4g"></script>
  <script src="{{url('landing/html5lightbox/html5lightbox.js')}}"></script>
  <script src="{{url('landing/wow.js')}}"></script>
  <script src="{{url('landing/owl.carousel.js')}}"></script>
  <script src="{{url('landing/ciudades.js')}}"></script>
   <script src="{{url('script/js/custom.js')}}"></script>
  @yield('js')
  <script>
  $( document ).ready(function() {
    if($(window).width() < 767){
      jQuery('.menu-icon').on("click", function() {
        jQuery(this).toggleClass('active');
        jQuery('nav').slideToggle();
        jQuery('nav ul li a').on("click", function(){
          jQuery('.menu-icon').removeClass('active');
          jQuery('nav').hide();
        });
      });
    }
  });
  </script>
</body>

</html>
