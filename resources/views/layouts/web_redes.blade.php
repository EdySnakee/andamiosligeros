<!DOCTYPE html>
<html lang="es">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
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
 
  <link rel="shortcut icon" type="image/x-icon" href="{{url('web/img/favicon.ico')}}" />
  <link rel="stylesheet" href="{{url('web/css/estilos.css')}}">
  <link rel="stylesheet" href="https://kit-pro.fontawesome.com/releases/v5.15.2/css/pro.min.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
  <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>

  <script>
        var URL_BASE_WEB = '<?php echo url("/"); ?>';
  </script>
  <script type="application/ld+json">
    {
      "@context": "https://schema.org",
      "@type": "Organization",
      "url": "https://mallasanticaidas.com/",
      "logo": "https://mallasanticaidas.com/script/img/logo/redes-anticaidas-logo.png/script/img/logo/redes-anticaidas-logo.png"
    }
    </script>
</head>

<body>
    @if($tipo_menu == "principal")
      @include('web_redes.includes.header')
    @elseif($tipo_menu == "proyectos")
      @include('web_redes.includes.header-landing')
    @else
      @include('web_redes.includes.header-sistemas')
    @endif
  

  <main>
    @yield('content')
  </main>
  <footer>
    @include('web_redes.includes.footer')
  </footer>
  <script src="{{url('web/ajax/libs/Swiper/4.5.0/js/swiper.min.js')}}"></script>
  <script src="{{url('web/js/jquery-3.4.1.min.js')}}" integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>
  <script src="{{url('web/js/indexb1ed.js?ve12')}}"></script>
  
  <!-- Contact form JavaScript -->
  <script src="{{url('web/js/jqBootstrapValidation.js')}}"></script>
  <script src="{{url('script/js/custom.js')}}"></script>
  <?php /*<script src="{{url('web/js/contact_me.js')}}"></script>*/ ?>
  <script>

  $(function() {
    $("#contactForm input,#contactForm textarea").jqBootstrapValidation({
      preventSubmit: true,
      submitError: function($form, event, errors) {
        // additional error messages or events
      },
      submitSuccess: function($form, event) {
        event.preventDefault(); // prevent default submit behaviour
        // get values from FORM
        var name = $("input#name").val();
        var email = $("input#email").val();
        var telefono = $("input#telefono").val();
        var celular = $("input#celular").val();
        var message = $("textarea#message").val();
        var url_contacto = window.location.href;
        var firstName = name; // For Success/Failure Message
        // Check for white space in name for Success/Fail message
        if (firstName.indexOf(' ') >= 0) {
          firstName = name.split(' ').slice(0, -1).join(' ');
        }
        var data_json = {
            "accion":"enviaFormulario",
            "datos":{
                'url_contacto': url_contacto,
                'name': name,
                'email': email,
                'telefono' : telefono,
                'celular' : celular,
                'message': message
            }
        }
        $this = $("#sendMessageButton");
        $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
        ajaxSetup();
        $.ajax({
          //url: "../contacto/contact_me.php",
          url: "{{ route('ajax_utilidades_landing') }}",
          type: "POST",
          data: data_json,
          cache: false,
          beforeSend: function () {
            $("#sendMessageButton").attr("disabled", "disabled");
            swal("Enviando mensaje", {
              buttons: false,
            });
          },
          success: function() {
            // Success message
            swal("Mensaje enviado!", "Muy pronto nos contactaremos", "success");
            $('#success').html("<div class='alert alert-success'>");
            $('#success > .alert-success').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#success > .alert-success')
              .append("<strong>Gracias, muy pronto te contactaremos. </strong>");
            $('#success > .alert-success')
              .append('</div>');
            //clear all fields
            $('#contactForm').trigger("reset");
          },
          error: function() {
            // Fail message
            $('#success').html("<div class='alert alert-danger'>");
            $('#success > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
              .append("</button>");
            $('#success > .alert-danger').append($("<strong>").text("Ups " + firstName + ", tenemos problemas con el servidor de correos!"));
            $('#success > .alert-danger').append('</div>');
            //clear all fields
            $('#contactForm').trigger("reset");
          },
          complete: function() {
            setTimeout(function() {
              $this.prop("disabled", false); // Re-enable submit button when AJAX call is complete
            }, 1000);
          }
        });
      },
      filter: function() {
        return $(this).is(":visible");
      },
    });

    $("a[data-toggle=\"tab\"]").click(function(e) {
      e.preventDefault();
      $(this).tab("show");
    });
  });

  /*When clicking on Full hide fail/success boxes */
  $('#name').focus(function() {
    $('#success').html('');
  });

  </script>
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
  <script>
  window.onscroll = function() {stickymenu()};

  var navbar = document.getElementById("menu-principal");

  var sticky = navbar.offsetTop;

  function stickymenu() {
    if (window.pageYOffset >= sticky) {
      navbar.classList.add("fixed")
    } else {
      navbar.classList.remove("fixed");
    }
  }
  </script>
  @yield('js')
</body>

</html>
