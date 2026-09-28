<script>
    /*OPEN FICHA TECNICA*/

    $(document).on("click", "#open_ficha", openFicha);
    $(document).on("click", "#cerrar2", cerrarFicha);

    function openFicha(e) {
        e.preventDefault();
        var ficha_andamio = $(this).attr("attr-ficha");
        $('#modal-andamios2').removeClass('cerrado2');
        $("#ficha_andamio").val(ficha_andamio)
    }

    function cerrarFicha(e) {
        e.preventDefault();
        $('#modal-andamios2').addClass('cerrado2');
        $("#ficha_andamio").val();
    }

    /*ABRE MENU*/
    $(document).on("click", "#menu_movil", accionMenu);

    function accionMenu(e) {
        e.preventDefault();
        var accion_menu = $(this).attr('accion-menu');
        if (accion_menu == "abrir") {
            $(".ul-nav").addClass("open-menu");
            $("#tipo_m").html('<i class="fa fa-times" aria-hidden="true"></i> Cerrar');
            $(this).attr('accion-menu', 'cerrar');
        }
        if (accion_menu == "cerrar") {
            $(".ul-nav").removeClass("open-menu");
            $("#tipo_m").html('<i class="fa fa-bars" aria-hidden="true"></i> Menú');
            $(this).attr('accion-menu', 'abrir');
        }

    }
    /*CIERRA MENU*/

    // CLICK EN BOTÓN QUE ACCIONA EL MODAL DE COTIZACIÓN
    $(document).on("click", "#cotizar", openCotizar);
    $(document).on("click", "#cerrar", cerrarCotizar);

    // CLICK EN BOTÓN QUE ACCIONA EL CARRITO
    $(document).on("click", "#miniCarrito", renderMiniCart);
    $(document).on("click", "#cerrar", cerrarMiniCart);

    // FUNCIONES PARA ABRIR Y CERRAR EL MODAL DE COTIZACIÓN
    function openCotizar(e) {
        e.preventDefault();
        var andamio_interes = $(this).attr("data-product");
        $('#modal-andamios').removeClass('cerrado');
        $("#andamio_interes").val(andamio_interes);
    }

    function cerrarCotizar(e) {
        e.preventDefault();
        $('#modal-andamios').addClass('cerrado');
        $("#andamio_interes").val();
    }

    // FUNCIONES CARRITO
    function controlarCantidadProducto(idProducto, button, accion) {
        $.ajax({
            type: 'GET',
            url: '/aumentar_cantidad_producto',
            data: {
                id_producto: idProducto,
                accion: accion,
            },
            success: function(response) {
                if (response.success) {
                    // Actualizar cantidad del producto
                    $(button).siblings('.cantidad-valor').text(response.cart_item.cantidad);

                    // Actualizar el subtotal, envío y total
                    $('#subthtml').text('$' + response.total);
                    $('#enviohtml').text('$' + response.envio);
                    $('#totalhtml').text('$' + response.gran_total);
                    $('#subtotal').val(response.total);
                    $('#total_compra').val(response.gran_total);
                } else {
                    alert('Error al actualizar la cantidad.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
            }
        });
    }

    document.querySelectorAll('.cantidad-disminuir').forEach(button => {
        button.addEventListener('click', () => {
            const idProducto = button.getAttribute('data-id');
            controlarCantidadProducto(idProducto, button, "disminuir")
        })
    })

    document.querySelectorAll('.cantidad-aumentar').forEach(button => {
        button.addEventListener('click', () => {
            const idProducto = button.getAttribute('data-id');
            controlarCantidadProducto(idProducto, button, "aumentar")
        })
    })

    // FUNCIONES RELACIONADAS AL MINICART
    /*----/ Se encarga de renderizar el carrito actualizado /----*/
    function renderMiniCart() {
        $.ajax({
            url: '/minicart',
            type: 'GET',
            success: function(data) {
                abrirMiniCart()
                $('#modal-mini-cart').html(data);
            },
            error: function(xhr, status, error) {
                console.error('Error al cargar el minicart:', error);
            }
        });
    }

    /*----/ Se encargan de la visibilidad del minicart /----*/
    function abrirMiniCart() {
        setTimeout(function() {
            $('#modal-mini-cart').removeClass('cerrado');
            $('.minicart-overlay').removeClass('d-none');
        }, 20);
    }

    function cerrarMiniCart() {
        $('#modal-mini-cart').addClass('cerrado');
        $('.minicart-overlay').addClass('d-none');
    }

    /*----/ Se encarga de agregar productos al carrito/----*/
    function addToCart(form) {
        $.ajax({
            type: 'GET',
            url: $(form).attr('action'),
            data: $(form).serialize(),
            success: function(response) {
                if (response) {
                    // Actualiza el contador del carrito
                    updateCartCount(response.cart_count);
                    renderMiniCart();
                } else {
                    alert('Error al añadir el producto al carrito.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
            }
        });
    }

    function removeFromCart(form) {
        $.ajax({
            type: 'GET',
            url: $(form).attr('action'),
            data: $(form).serialize(),
            success: function(response) {
                if (response.success) {
                    if (response.cart_count == 0) {
                        cerrarMiniCart();
                        setTimeout(() => renderMiniCart(), 150)
                    } else {
                        renderMiniCart();
                    }
                    updateCartCount(response.cart_count)
                } else {
                    alert('Error al eliminar el producto.');
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                alert('Error al procesar la solicitud.');
            }
        });
    }

    /*----/ Se encarga de actualizar el contador de productos únicos del carrito /----*/
    function updateCartCount(count) {
        $('#miniCarrito .font-cart').text(count);
        if (count > 0) {
            $('#miniCarrito .cont-carrito').removeClass('d-none');
        } else {
            $('#miniCarrito .cont-carrito').addClass('d-none');
        }
    }
    // FIN DE FUNCIONES RELACIONADAS AL MINICART

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
                    "accion": "enviaFormulario",
                    "datos": {
                        'url_contacto': url_contacto,
                        'name': name,
                        'email': email,
                        'telefono': telefono,
                        'celular': celular,
                        'message': message
                    }
                }
                $this = $("#sendMessageButtonContacto");
                $this.prop("disabled",
                    true
                ); // Disable submit button until AJAX call is complete to prevent duplicate messages
                ajaxSetup();
                $.ajax({
                    url: "{{ route('path_ajax_web') }}",
                    type: "POST",
                    data: data_json,
                    cache: false,
                    beforeSend: function() {
                        $("#sendMessageButtonContacto").attr("disabled", "disabled");
                        $("#sendMessageButtonContacto").html("Enviando...");
                    },
                    success: function() {
                        // Success message
                        window.location.href = "{{ url('/thank-you') }}";
                    },
                    error: function() {
                        // Fail message
                        $('#success').html("<div class='alert alert-danger'>");
                        $('#success > .alert-danger').html(
                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;"
                            )
                            .append("</button>");
                        $('#success > .alert-danger').append($("<strong>").text("Ups " +
                            firstName +
                            ", tenemos problemas con el servidor de correos!"));
                        $('#success > .alert-danger').append('</div>');
                        //clear all fields
                        $('#contactForm').trigger("reset");
                    },
                    complete: function() {
                        setTimeout(function() {
                            $this.prop("disabled",
                                false
                            ); // Re-enable submit button when AJAX call is complete
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
                    "accion": "enviaCotizacion",
                    "datos": {
                        'url_contacto': url_contacto,
                        'name': name,
                        'email': email,
                        'andamio_interes': andamio_interes,
                        'celular': celular,
                        'message': message
                    }
                }
                $this = $("#sendMessageButtonCotiza");
                $this.prop("disabled",
                    true
                ); // Disable submit button until AJAX call is complete to prevent duplicate messages
                ajaxSetup();
                $.ajax({
                    url: "{{ route('path_ajax_web') }}",
                    type: "POST",
                    data: data_json,
                    cache: false,
                    beforeSend: function() {
                        $("#sendMessageButtonCotiza").attr("disabled", "disabled");
                        $("#sendMessageButtonCotiza").html("Solicitando...");
                    },
                    success: function() {
                        // Success message
                        window.location.href = "{{ url('/thank-you') }}";
                    },
                    error: function() {
                        // Fail message
                        $('#success_cli').html("<div class='alert alert-danger'>");
                        $('#success_cli > .alert-danger').html(
                                "<button type='button' class='close' data-dismiss='alert' aria-hidden='true'>&times;"
                            )
                            .append("</button>");
                        $('#success_cli > .alert-danger').append($("<strong>").text(
                            "Ups " + firstName +
                            ", tenemos problemas con el servidor de correos!"));
                        $('#success_cli > .alert-danger').append('</div>');
                        //clear all fields
                        $('#cotizaForm').trigger("reset");
                    },
                    complete: function() {
                        setTimeout(function() {
                            $this.prop("disabled",
                                false
                            ); // Re-enable submit button when AJAX call is complete
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

    /*INICIA FORMULARIO FICHA*/
    $(function() {
        $("#enviaFicha input,#enviaFicha textarea").jqBootstrapValidation({
            preventSubmit: true,
            submitError: function($form, event, errors) {
                // additional error messages or events
            },
            submitSuccess: function($form, event) {
                event.preventDefault(); // prevent default submit behaviour
                // get values from FORM
                var name = $("input#nombre_descarga").val();
                var email = $("input#correo_descarga").val();
                var celular = $("input#celular_cli_descarga").val();
                var ficha_andamio = $("input#ficha_andamio").val();
                var url_contacto = window.location.href;

                var data_json = {
                    "accion": "enviaFicha",
                    "datos": {
                        'url_contacto': url_contacto,
                        'name': name,
                        'email': email,
                        'ficha_andamio': ficha_andamio,
                        'celular': celular
                    }
                }
                $this = $("#sendMessageButtonDescarga");
                $this.prop("disabled",
                    true
                ); // Disable submit button until AJAX call is complete to prevent duplicate messages
                ajaxSetup();
                $.ajax({
                    url: "{{ route('path_ajax_web') }}",
                    type: "POST",
                    data: data_json,
                    cache: false,
                    beforeSend: function() {
                        $("#sendMessageButtonDescarga").attr("disabled", "disabled");
                        $("#sendMessageButtonDescarga").html("Descargando...");
                    },
                    success: function() {
                        // Success message
                        window.location.href = "{{ url('/thank-you-descarga') }}";
                    },
                    error: function() {
                        // Fail message
                    },
                    complete: function() {
                        setTimeout(function() {
                            $this.prop("disabled",
                                false
                            ); // Re-enable submit button when AJAX call is complete
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
    /*FIN FORMULARIO FICHA*/

    /*INICIA FUNCIONES*/
    $(document).ready(function() {
        var ticking = false;
        $(window).scroll(function() {
            if (!ticking) {
                window.requestAnimationFrame(function() {
                    EasyPeasyParallax();
                    ticking = false;
                });
                ticking = true;
            }
        });
    });

    window.onhashchange = function() {
        window.history.pushState('', document.title, window.location.pathname)
    }

    function EasyPeasyParallax() {
        scrollPos = $(this).scrollTop();
        navbar = document.getElementById("navbar");
        navPos = navbar.getBoundingClientRect().top;
        $('.bg-figuras').css({
            'background-position': '50% ' + (-scrollPos / 4) + "px"
        });
        $('.bg-items').css({
            'background-position': '50% ' + (-scrollPos / 4) + "px"
        });
        $('.banner02').css({
            'background-position': '50% ' + (-scrollPos / 4) + "px"
        });
        $('.intro').css({
            'margin-top': (scrollPos / 4) + "px",
            'opacity': 1 - (scrollPos / 250)
        });

        if (scrollPos > navPos) {
            navbar.classList.add('sticky');
            navbar.classList.add('scrolled');
        } else {
            navbar.classList.remove('sticky');
            navbar.classList.remove('scrolled');
        }
    }
</script>
