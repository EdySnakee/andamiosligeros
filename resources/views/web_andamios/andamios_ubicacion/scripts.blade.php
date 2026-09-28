<script>
    $(document).on("click", "#cotizar", openCotizar);
    $(document).on("click", "#cerrar", cerrarCotizar);
    function openCotizar (e) {
      e.preventDefault();
      var andamio_interes = $(this).attr("data-product");
      $('#modal-andamios').removeClass('cerrado');
      $("#andamio_interes").val(andamio_interes)
    }
    function cerrarCotizar (e) {
      e.preventDefault();
      $('#modal-andamios').addClass('cerrado');
      $("#andamio_interes").val();
    }
    /*INICIA FORMULARIO*/
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
            $this = $("#sendMessageButtonContacto");
            $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
            ajaxSetup();
            $.ajax({
              url: "{{ route('path_ajax_web') }}",
              type: "POST",
              data: data_json,
              cache: false,
              beforeSend: function () {
                $("#sendMessageButtonContacto").attr("disabled", "disabled");
                $("#sendMessageButtonContacto").html("Enviando...");
              },
              success: function() {
                // Success message
                window.location.href = "{{url('/thank-you')}}";
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
    /*FIN FORMULARIO*/

    /*INICIA FORMULARIO COTIZADOR*/
    $(function() {
        $("#cotizaForm input,#cotizaForm textarea").jqBootstrapValidation({
          preventSubmit: true,
          submitError: function($form, event, errors) {
            // additional error messages or events
          },
          submitSuccess: function($form, event) {
            event.preventDefault(); // prevent default submit behaviour
            // get values from FORM
            var name = $("input#nombre").val();
            var email = $("input#correo").val();
            var andamio_interes = $("input#andamio_interes").val();
            var celular = $("input#celular_cli").val();
            var message = $("textarea#mensaje").val();
            var url_contacto = window.location.href;
            var firstName = name; // For Success/Failure Message
            // Check for white space in name for Success/Fail message
            if (firstName.indexOf(' ') >= 0) {
              firstName = name.split(' ').slice(0, -1).join(' ');
            }
            var data_json = {
                "accion":"enviaCotizacion",
                "datos":{
                    'url_contacto': url_contacto,
                    'name': name,
                    'email': email,
                    'andamio_interes' : andamio_interes,
                    'celular' : celular,
                    'message': message
                }
            }
            $this = $("#sendMessageButtonCotiza");
            $this.prop("disabled", true); // Disable submit button until AJAX call is complete to prevent duplicate messages
            ajaxSetup();
            $.ajax({
              url: "{{ route('path_ajax_web') }}",
              type: "POST",
              data: data_json,
              cache: false,
              beforeSend: function () {
                $("#sendMessageButtonCotiza").attr("disabled", "disabled");
                $("#sendMessageButtonCotiza").html("Solicitando...");
              },
              success: function() {
                // Success message
                window.location.href = "{{url('/thank-you')}}";
              },
              error: function() {
                // Fail message
                $('#success_cli').html("<div class='alert alert-danger'>");
                $('#success_cli > .alert-danger').html("<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;")
                  .append("</button>");
                $('#success_cli > .alert-danger').append($("<strong>").text("Ups " + firstName + ", tenemos problemas con el servidor de correos!"));
                $('#success_cli > .alert-danger').append('</div>');
                //clear all fields
                $('#cotizaForm').trigger("reset");
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
    /*FIN FORMULARIO COTIZADOR*/
</script>