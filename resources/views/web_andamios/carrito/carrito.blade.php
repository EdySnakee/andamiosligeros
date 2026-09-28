@extends('layouts.web_andamios')
@section('css')
    <title>Carrito de Compras | Venta de Andamios en México</title>
    <meta name="description"
        content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />
    <meta name="keywords"
        content="andamios ligeros, andamios galvanizados, andamios en mexico, andamios, material de construccion, mexico" />
    <meta property="og:image" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />

    <meta property="og:image:secure_url" content="{{ url('web/imgfacebook/redes-anticaidas-facebook-index-1.jpg') }}" />

    <meta property="og:title" content="Carrito de Compras | Venta de Andamios en México" />
    <meta property="og:site_name" content="Carrito de Compras | Venta de Andamios en México" />
    <meta property="og:description"
        content="En Andamios Ligeros, nuestra meta es que puedas adquirir andamios seguros, resistentes y 50% más ligeros que cualquier otro. ¡Compra andamios galvanizados fácilmente con nosotros!" />

    <link rel="canonical" href="{{ url('/carrito') }}">
    <meta property="og:url" content="{{ url('/carrito') }}" />
    @include('web_andamios.includes.css_extra_loco')
    <link rel="stylesheet" href="{{ url('loco/css/bootstrap.css') }}">

    <script>
        let landing = localStorage.getItem('landing');

        if (landing) {
            document.addEventListener('DOMContentLoaded', function() {
                document.querySelector('#navbar').remove();
                document.querySelector('footer').remove();
                document.querySelector('.remove-from-cart').remove();
                document.querySelector('.clear-cart').remove();
                document.querySelector('.continuar-compra').remove();
            });
            console.log('landing obtenido', landing);
        } else {
            // ->
            console.log('nada de nada', landing);
        }

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
        fbq('track', 'AddToCart');
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
    </script>

    <style>

    </style>
@stop

@section('content')
    <main class="page-normal">
        @include('web_andamios.carrito.contenido_carrito')
    </main>
@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones')
    <script>
        // IVA
        $(document).on("change", "#activa_iva", agregaImpuesto);

        let activa_factura = false;

        function agregaImpuesto() {
            activa_factura = $(this).is(":checked");
            var envio = $("#envio").val();
            var subtotal = $('#subtotal').val()
            var data_json = {
                "accion": "agregaImpuesto",
                "datos": {
                    'activa_factura': activa_factura,
                    'subtotal': subtotal,
                    'envio': envio
                }
            }

            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_tienda_web') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {},
                success: function(result) {
                    const options2 = {
                        style: 'currency',
                        currency: 'USD'
                    };
                    const numberFormat2 = new Intl.NumberFormat('en-US', options2);
                    $("#detalle_factura").html(result.vista);
                    $('#totalhtml').html(numberFormat2.format(result.total))
                    if (activa_factura == false) {
                        $('.iva').addClass("d-none")
                    } else {
                        $('.iva').removeClass("d-none")
                    }
                    $('#ivahtml').html(numberFormat2.format(result.iva))
                    $('#total_compra').val(result.total)
                },
                error: function(error) {}
            });
        }

        // CUPONERA
        $(document).on("change", "#activa_cupon", function() {
            if ($(this).is(":checked")) {
                $('#cupon').removeClass("d-none");
            } else {
                $('#cupon').find('input').val('');
                $('#cupon').addClass("d-none");
                agregaCupon();
            }
        });


        let campoCupon = $('#campo_cupon');
        let botonCupon = $('.btn-aplicar');
        $(document).on("input", "#campo_cupon", function() {
            if (campoCupon.val().length > 0) {
                botonCupon.removeClass("disabled");
                botonCupon.removeAttr("disabled", "disabled");
                // console.log("hola habilitado")
            } else {
                botonCupon.addClass("disabled");
                botonCupon.attr("disabled", "disabled");
                // console.log("hola deshabilitado")
            }
        });

        let subtotal_original;
        let cupon_usado;

        window.addEventListener('load', function() {
            subtotal_original = $('#subtotal').val()
        });

        $(document).on("click", ".btn-aplicar", function() {
            if (cupon_usado && $('#campo_cupon').val() == '500OFF') {
                // console.log("cupon usado")
            } else {
                agregaCupon();
            }
        });

        function agregaCupon() {
            var activa_cupon = $('#activa_cupon').is(":checked");
            var cuponCheck = $('#activa_cupon');
            var cuponInput = $('#cupon');
            var campoCupon = $('#campo_cupon').val()
            var subtotal = $('#subtotal').val()
            var envio = $("#envio").val();
            var checked = activa_cupon ? true : false;
            const options2 = {
                style: 'currency',
                currency: 'USD'
            };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);
            var data_json = {
                "accion": "agregaCupon",
                "datos": {
                    'checked': checked,
                    'campo_cupon': campoCupon,
                    'subtotal': subtotal,
                    'subtotal_original': subtotal_original,
                    'envio': envio,
                    'activa_factura': activa_factura,
                }
            }


            ajaxSetup();
            $.ajax({
                data: data_json,
                url: '{{ route('path_ajax_tienda_web') }}',
                type: 'post',
                datatype: 'html',
                beforeSend: function() {
                    // Puedes mostrar un loader aquí si quieres
                },
                success: function(result) {

                    $('.cupon').removeClass("d-none")
                    $('#cuponhtml').html(numberFormat2.format(result.cupon))
                    $('#totalhtml').html(numberFormat2.format(result.total))
                    $('#total_compra').val(result.total)
                    $('#subtotal').val(result.subtotal)


                    // CUPON ACTIVO
                    if (result.activo == 0) {
                        $('.cupon').addClass("d-none")
                        // Muestra una alerta de error
                        $('#campo_cupon').addClass("is-invalid");
                        $(' .invalid-feedback').show();

                        botonCupon.addClass("disabled");
                        botonCupon.attr("disabled", "disabled");
                        cupon_usado = false;
                    }

                    // CUPON IN ACTIVO
                    if (result.activo == 1) {
                        $('.cupon').removeClass("d-none")
                        // Limpiar clases de error
                        $('#campo_cupon').removeClass("is-invalid");
                        $('.invalid-feedback').hide();
                        cupon_usado = true;
                        console.log(cupon_usado);
                    }

                    if (activa_factura) {
                        $('#activa_iva').click();
                        $('#activa_iva').click();
                        console.log("factura activa")
                    }

                },
                error: function(error) {

                }
            });
        }
    </script>
@stop
