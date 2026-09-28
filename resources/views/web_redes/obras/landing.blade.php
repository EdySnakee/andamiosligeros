@extends('layouts.landing_redes')
@section('css')
<script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
<link rel="canonical" href="{{url('/')}}/obras/{{$clientesRedes->url_cliente}}">
<style>
	.html5-prev-inside .mh-icon-left, .html5-next-inside .mh-icon-right {
	    font-size: 41px !important;
	    line-height: 67px !important;
	    width: 67px !important;
	    height: 67px !important;
	}
</style>
@stop
@section('content')
	@include('web_redes.obras.contenido-landing')
@stop

@section('js')
<script src="{{url('web/js/jqBootstrapValidation.js')}}"></script>
<script src="{{url('script/js/custom.js')}}"></script>
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
	        "accion":"enviaFormularioLandings",
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
$(document).ready(function() { 
   	$("#owl-slider").owlCarousel({
   		autoplay:true,
    	loop:true,
	    autoplayTimeout:2000,
	    autoplayHoverPause:true,
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true,
        // Navigation
        navigationText : ["Anterior","Siguiente"],
        rewindNav : true,
        scrollPerPage : true,
        //Pagination
        pagination : true,
        paginationNumbers: false,
        responsive:{
	        0:{
	            items:1,
	            nav:true,
	            loop:true
	        },
	        600:{
	            items:1,
	            nav:false,
	            loop:true
	        },
	        1000:{
	            items:3,
	            nav:false,
	            loop:true
	        }
	    }
    });

    $("#galeria").owlCarousel({
    	autoplay:true,
    	loop:true,
	    autoplayTimeout:2000,
	    autoplayHoverPause:true,
        navigation : true, // Show next and prev buttons
        slideSpeed : 300,
        paginationSpeed : 400,
        singleItem:true,
        // Navigation
        navigationText : ["Anterior","Siguiente"],
        rewindNav : true,
        scrollPerPage : true,
        //Pagination
        pagination : true,
        paginationNumbers: false,
        responsive:{
	        0:{
	            items:1,
	            nav:true,
	            loop:true
	        },
	        600:{
	            items:1,
	            nav:false,
	            loop:true
	        },
	        1000:{
	            items:3,
	            nav:false,
	            loop:true
	        }
	    }
    });

   	$(".owl-stage-outer > div > div:nth-child(1) .item").addClass("activo");
   	$(document).on("click", "#itemcliente", activaCliente);
   	function activaCliente (e) {
	   	e.preventDefault();
	   	$(".owl-stage-outer > div > div:nth-child(n) .item").removeClass("activo");
	   	$(".item", this).addClass("activo");

	   	var id_cliente = $(this).attr('id-data-cliente');
	   	var data_json = {
	        "accion":"activaCliente",
	        "datos":{
	            'id_cliente' : id_cliente
	        }
	    }

	   	ajaxSetup();
        $.ajax({
	        data:  data_json,
	        url:   '{{ route("ajax_utilidades_landing") }}',
	        type:  'post',
	        dataType:'html',
	        beforeSend: function () {
	        },
	        success:  function (result) {
	        	$('html, body').animate({
				 scrollTop: $("#result_info_cliente").offset().top
				 }, 500);
	            $("#result_info_cliente").html(result);
	            $("#galeria").owlCarousel({
	            	autoplay:true,
			    	loop:true,
				    autoplayTimeout:2000,
				    autoplayHoverPause:true,
			        navigation : true, // Show next and prev buttons
			        slideSpeed : 300,
			        paginationSpeed : 400,
			        singleItem:true,
			        // Navigation
			        navigationText : ["Anterior","Siguiente"],
			        rewindNav : true,
			        scrollPerPage : true,
			        //Pagination
			        pagination : true,
			        paginationNumbers: false
			    });
			    var cordenadas = $('#mapa').data('coordenadas');
			    //alert(locations);
			    cargarmapa(cordenadas);
			    $('.galeriaItem').html5lightbox();

	        },
	        error: function(error){
	            console.log(error);
	        }
	    });
   	}
   	
});
</script>
@stop