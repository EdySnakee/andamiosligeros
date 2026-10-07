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

        // ==========================================
        // INTEGRACIÓN OPENPAY.JS (CHECKOUT DIRECTO)
        // ==========================================
        $(document).ready(function() {
            try {
                // 1. Configuración de credenciales públicas
                OpenPay.setId("{{ config('services.openpay.merchant_id') }}");
                OpenPay.setApiKey("{{ config('services.openpay.public_key') }}");
                OpenPay.setSandboxMode({{ config('services.openpay.sandbox') ? 'true' : 'false' }});

                // 2. Generar identificador de dispositivo para antifraude
                window.cartDeviceSessionId = OpenPay.deviceData.setup("checkout-form", "device_session_id");
            } catch (err) {
                console.warn("OpenPay JS Setup Warning:", err);
            }

            // Sincronizar automáticamente el nombre del cliente con el titular si no ha sido editado
            $('#nombre_c').on('input', function() {
                var $holder = $('#openpay_holder_name');
                if (!$holder.data('edited') || $holder.val() === '') {
                    $holder.val($(this).val().toUpperCase());
                }
            });
            $('#openpay_holder_name').on('input', function() {
                $(this).data('edited', true);
            });

            // Formato de tarjeta y detección dinámica de marca (Visa, Mastercard, AMEX, Carnet)
            $('#openpay_card_number').on('input', function() {
                var raw = $(this).val().replace(/\D/g, '');
                if (raw.length > 16) raw = raw.substring(0, 16);
                var formatted = raw.match(/.{1,4}/g)?.join(' ') || raw;
                $(this).val(formatted);

                try {
                    var cardType = OpenPay.card.cardType(raw);
                    if (cardType) {
                        $('#openpay_card_type').text(cardType.toUpperCase()).fadeIn();
                    } else {
                        $('#openpay_card_type').text('').hide();
                    }
                } catch(e) {}
            });

            // Formateo automático de Vigencia (MM / AA)
            $('#openpay_expiry').on('input', function() {
                var val = $(this).val().replace(/\D/g, '');
                if (val.length > 4) val = val.substring(0, 4);
                if (val.length >= 3) {
                    $(this).val(val.substring(0, 2) + ' / ' + val.substring(2));
                } else if (val.length === 2 && !$(this).data('deleting')) {
                    $(this).val(val + ' / ');
                } else {
                    $(this).val(val);
                }

                var m = val.substring(0, 2);
                var y = val.substring(2);
                $('#openpay_exp_month').val(m);
                $('#openpay_exp_year').val(y);
            });

            $('#openpay_expiry').on('keydown', function(e) {
                if (e.key === 'Backspace') {
                    $(this).data('deleting', true);
                    var val = $(this).val();
                    if (val.endsWith(' / ') || val.endsWith('/ ') || val.endsWith('/')) {
                        e.preventDefault();
                        var digits = val.replace(/\D/g, '');
                        digits = digits.substring(0, digits.length - 1);
                        $(this).val(digits);
                        $('#openpay_exp_month').val(digits.substring(0, 2));
                        $('#openpay_exp_year').val(digits.substring(2));
                    }
                } else {
                    $(this).data('deleting', false);
                }
            });

            // Restricción numérica para CVV
            $('#openpay_cvv').on('input', function() {
                $(this).val($(this).val().replace(/\D/g, ''));
            });

            // Manejo de cambio visual de método de pago
            $(document).on('change', 'input[name="metodo_pago"]', function() {
                if ($(this).val() === 'mercadopago') {
                    $('#card-mercadopago').css({'border-color': '#009ee3', 'background-color': '#f7fbff'});
                    $('#card-openpay').css({'border-color': '#dcdcdc', 'border-bottom': '1.5px solid #dcdcdc', 'border-radius': '8px', 'background-color': '#ffffff'});
                    $('#openpay-card-form').slideUp(200);
                    $('.cart-confirmar').text('CONFIRMAR PEDIDO');
                } else {
                    $('#card-openpay').css({'border-color': '#002f6c', 'border-bottom': 'none', 'border-radius': '8px 8px 0 0', 'background-color': '#f8faff'});
                    $('#card-mercadopago').css({'border-color': '#dcdcdc', 'background-color': '#ffffff'});
                    $('#openpay-card-form').slideDown(250);

                    // Si no tiene nombre el titular, heredar del nombre de cliente
                    if (!$('#openpay_holder_name').val() && $('#nombre_c').val()) {
                        $('#openpay_holder_name').val($('#nombre_c').val().toUpperCase());
                    }
                    $('.cart-confirmar').text('PAGAR CON TARJETA');
                }
            });

            // Intercepción del formulario de checkout
            $('#checkout-form').on('submit', function(e) {
                var metodo = $('input[name="metodo_pago"]:checked').val();

                // Si seleccionó Openpay y aún no se ha generado el token
                if (metodo === 'openpay') {
                    if ($('#token_id').val()) {
                        return true; // Ya tiene token, permitir envío
                    }

                    e.preventDefault();
                    $('#openpay-error-alert').hide().text('');

                    if ($('.cart-producto').length === 0) {
                        mostrarErrorOpenpay('Tu carrito de compras está vacío. Agrega un producto a la tienda antes de proceder al pago.');
                        return false;
                    }

                    var holderName = $.trim($('#openpay_holder_name').val());
                    var rawCard = $('#openpay_card_number').val().replace(/\s+/g, '');
                    
                    var expVal = $('#openpay_expiry').val() || '';
                    var expDigits = expVal.replace(/\D/g, '');
                    var expMonth = expDigits.substring(0, 2);
                    var expYear = expDigits.substring(2);
                    var cvv = $.trim($('#openpay_cvv').val());

                    // Validaciones básicas de campos
                    if (!holderName) {
                        mostrarErrorOpenpay('Por favor ingresa el nombre del titular de la tarjeta.');
                        $('#openpay_holder_name').focus();
                        return false;
                    }

                    if (!rawCard || !OpenPay.card.validateCardNumber(rawCard)) {
                        mostrarErrorOpenpay('El número de tarjeta no es válido. Verifica los dígitos.');
                        $('#openpay_card_number').focus();
                        return false;
                    }

                    if (!expMonth || !expYear || expMonth.length < 2 || expYear.length < 2 || !OpenPay.card.validateExpiry(expMonth, expYear)) {
                        mostrarErrorOpenpay('La fecha de vencimiento es inválida (MM / AA).');
                        $('#openpay_expiry').focus();
                        return false;
                    }

                    if (!cvv || !OpenPay.card.validateCVC(cvv, rawCard)) {
                        mostrarErrorOpenpay('El código de seguridad (CVV) es inválido.');
                        $('#openpay_cvv').focus();
                        return false;
                    }

                    // Botón en estado de carga
                    var $btn = $('.cart-confirmar');
                    var originalText = $btn.text();
                    $btn.prop('disabled', true).text('PROCESANDO PAGO SEGURO...');

                    // Normalizar año a 2 dígitos
                    var yearNormal = expYear.length === 4 ? expYear.substring(2) : expYear;

                    // Tokenizar tarjeta con OpenPay
                    OpenPay.token.create({
                        "holder_name": holderName,
                        "card_number": rawCard,
                        "cvv2": cvv,
                        "expiration_month": expMonth,
                        "expiration_year": yearNormal
                    }, function(response) {
                        // Éxito: asignar token
                        $('#token_id').val(response.data.id);
                        if (window.cartDeviceSessionId && !$('#device_session_id').val()) {
                            $('#device_session_id').val(window.cartDeviceSessionId);
                        }

                        // REDIRECCIÓN PAUSADA TEMPORALMENTE PARA DEMO DE OPENPAY
                        var formData = $('#checkout-form').serialize();
                        $.ajax({
                            url: $('#checkout-form').attr('action'),
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            headers: {
                                'X-Requested-With': 'XMLHttpRequest',
                                'Accept': 'application/json'
                            },
                            success: function(res) {
                                if (res && res.success) {
                                    console.log("¡Pago exitoso con Openpay en Tienda!", res);
                                    $btn.prop('disabled', false)
                                        .css({'background': '#28a745', 'color': '#fff', 'box-shadow': '0 4px 10px rgba(40,167,69,0.3)'})
                                        .text('PAGO EXITOSO (REDIRECCIÓN PAUSADA)');

                                    if (!$('#btn-continuar-thankyou').length && res.redirect_url) {
                                        $btn.after('<div id="btn-continuar-thankyou" style="margin-top: 12px; text-align: center;"><a href="' + res.redirect_url + '" class="btn btn-sm btn-outline-success" style="font-weight: 600;">Continuar a Thank You Page &rarr;</a></div>');
                                    }
                                } else {
                                    $btn.prop('disabled', false).text(originalText);
                                    mostrarErrorOpenpay((res && res.message) ? res.message : 'No fue posible completar el pago.');
                                }
                            },
                            error: function(xhr) {
                                $btn.prop('disabled', false).text(originalText);
                                var errorJson = xhr.responseJSON;
                                var errMsg = (errorJson && errorJson.message) ? errorJson.message : 'No fue posible procesar el pago. Verifica los datos o intenta nuevamente.';
                                mostrarErrorOpenpay(errMsg);
                            }
                        });
                    }, function(response) {
                        $btn.prop('disabled', false).text(originalText);
                        var msg = obtenerMensajeError(response);
                        mostrarErrorOpenpay(msg);
                    });

                    return false;
                }
            });

            function mostrarErrorOpenpay(mensaje) {
                $('#openpay-error-alert').text(mensaje).slideDown(150);
            }

            function obtenerMensajeError(response) {
                var code = (response.data && response.data.error_code) ? response.data.error_code : response.error_code;
                var mensajes = {
                    1001: 'Tarjeta rechazada. Por favor verifica los datos o intenta con otra tarjeta.',
                    1002: 'El código de seguridad (CVV) es inválido.',
                    1003: 'La fecha de expiración es inválida.',
                    1004: 'Por favor ingresa el nombre del titular.',
                    1005: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.',
                    2004: 'El número de tarjeta no es válido.',
                    2007: 'El número de tarjeta es de prueba y solo es válido en Sandbox.',
                    3001: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.',
                    3002: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.',
                    3003: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.',
                    3004: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.',
                    3005: 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.'
                };
                if (mensajes[code]) return mensajes[code];
                return 'Tarjeta rechazada. Por favor intenta con otra tarjeta o método de pago.';
            }
        });
    </script>

    <!-- Librerías oficiales openpay.js para tokenización y antifraude -->
    <script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
    <script type="text/javascript" src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
@stop


