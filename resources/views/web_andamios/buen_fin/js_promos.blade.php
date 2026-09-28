<script src="https://sdk.mercadopago.com/js/v2"></script>
<script>
   
    $(document).on("click", "#btn-accion-mp", btnAccionMp);
    $(document).on("click", "#cerrar-pago", btnCerrarMp);
    $(document).on("click", "#confirma_pedido", validaCampos);
    $(document).on("click", "#edita_pedido", editaPedido);
    
    $(document).on('click', '.quantity .plus', function() { 
        var $qty = $(this).parents('.quantity').find('.qty'); 
        var currentVal = parseInt($qty.val()); 
        if (!isNaN(currentVal)) { 
            $qty.val(currentVal + 1); 
            actualizaPrecio(currentVal + 1);
        } 
    });
    $(document).on('click', '.quantity .minus', function() { 
        var $qty = $(this).parents('.quantity').find('.qty'); 
        var currentVal = parseInt($qty.val()); 
        if (!isNaN(currentVal) && currentVal > 1) { 
            $qty.val(currentVal - 1); 
            actualizaPrecio(currentVal - 1);
        } });
    
    function actualizaPrecio(qty) {
        var cantidad = qty;
        var cant_min = $("#cant_min").val();
        var costo_articulo = $("#costo_articulo").val();
        var costo_desc = $("#costo_desc").val();
        var envio = $("#costo_envio").val();
        if (cantidad != 0) {
            var subtenvio = cantidad * envio;
            var subtotal;

            if (cantidad >= cant_min && (cant_min != "" && cant_min != 0)) {
                subtotal = cantidad * costo_desc;
                $('#costo_activo').val(costo_desc);
            } else {
                subtotal = cantidad * costo_articulo;
                $('#costo_activo').val(costo_articulo);
            }

            const options2 = { style: 'currency', currency: 'USD' };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);

            $('.subtotal').html(numberFormat2.format(subtotal));
            $('#subtotal').val(subtotal);
            $('.envio').html(numberFormat2.format(subtenvio));
            $('#envio').val(subtenvio);

            if ($('#activa_iva').is(":checked")) {
                var iva = subtotal * 0.16;
                var total_con_iva = parseFloat(subtotal) + parseFloat(iva);
                $('.iva').html(numberFormat2.format(iva));
                $('.total').html(numberFormat2.format(total_con_iva + subtenvio));
                $('#total').val(total_con_iva + subtenvio);
            } else {
                $('.total').html(numberFormat2.format(subtotal + subtenvio));
                $('#total').val(subtotal + subtenvio);
            }
        }
    }

    /*
    function actualizaPrecio($qty) {
        var cantidad = $qty;
        var costo_articulo = $("#costo_articulo").val();
        var envio = $("#costo_envio").val();
        if (cantidad != 0) {
            var subtenvio = cantidad * envio;
            var subtotal = cantidad * costo_articulo;            
            const options2 = { style: 'currency', currency: 'USD' };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);

            $('.subtotal').html(numberFormat2.format(subtotal))
            $('#subtotal').val(subtotal)
            $('.envio').html(numberFormat2.format(subtenvio))
            $('#envio').val(subtenvio)
            if($('#activa_iva').is(":checked")){
                var iva = subtotal * 0.16;
                var total_con_iva = parseFloat(subtotal) + parseFloat(iva);
                
                $('.iva').html(numberFormat2.format(iva))
                $('.total').html(numberFormat2.format(total_con_iva + subtenvio))
                $('#total').val(total_con_iva + subtenvio)
            }
            else {
                $('.total').html(numberFormat2.format(subtotal + subtenvio))
                $('#total').val(subtotal + subtenvio)
            }
            
        }
    }
    
    $('#cantidad').on('change', function () { 
        
    });
    */

    function validaCampos() {
        var nombre_c = $('#nombre_c').val()
        var numero_c = $('#numero_c').val()
        var email_c = $('#email_c').val()
        var direccion_c = $('#direccion_c').val()
        if (nombre_c == '') {
            return alert("Necesitamos tu nombre");
        }
        if (numero_c == '') {
            return alert("Necesitamos tu número");
        }
        if (email_c == '') {
            return alert("Necesitamos tu correo");
        }
        if (direccion_c == '') {
            return alert("Necesitamos tu dirección");
        }

        confirmaPedido()
        
    }

    function confirmaPedido() {
        $("#confirma_pedido").addClass('disabled')
        $('#cantidad').addClass('disabled')
        $("#confirma_pedido").attr('disabled', 'disabled')
        $('#cantidad').attr('disabled', 'disabled')
        $('#activa_iva').attr('disabled', 'disabled')
        $('#activa_iva').addClass('disabled')
        
        if($('#activa_iva').is(":checked")){
            var iva = "si"
        }
        else {
            var iva = "no"
        }

        var cantidad = $("#cantidad").val();
        var envio = $("#costo_envio").val();
        var nombre_product = $("#nombre_product").val();
        var costo_articulo = $("#costo_activo").val();
        var razon_social = $("#razon_social").val();
        var rfc = $("#rfc").val();
        var direccion_fiscal = $("#direccion_fiscal").val();
        var nombre_c = $('#nombre_c').val();
        var numero_c = $('#numero_c').val();
        var email_c = $('#email_c').val();
        var direccion_c = $('#direccion_c').val();
        var data_json = {
            "accion":"activaMercadoPago",
            "datos":{
                "nombre_c":nombre_c,
                "numero_c":numero_c,
                "email_c":email_c,
                "direccion_c":direccion_c,
                "cantidad":cantidad,
                "envio":envio,
                "nombre_product":nombre_product,
                "costo_articulo":costo_articulo,
                "iva": iva,
                "datos_factura":{
                    "razon_social": razon_social,
                    "rfc": rfc,
                    "direccion_fiscal": direccion_fiscal
                }
            }
        }
        ajaxSetup();
        $.ajax({
            data:  data_json,
            url:   '{{ route("path_ajax_web") }}',
            type:  'post',
            datatype:'html',
            beforeSend: function () {
                $('.info_mp').html('<i class="fa fa-spinner fa-pulse fa-3x fa-fw margin-bottom"></i>');
            },
            success:  function (result) {
                $('#edita_pedido').removeClass('display-none')
                $('.info_mp').html(result);
            },
            error: function(error){
            }
        });
    }

    $(document).ready(function() {
      
        $('#activa_iva').click(function() {
            
 
            if ($(this).is(':checked')) {
                return activaIva();
            }else{
                $('#fila-iva').addClass('display-none');
                $('#confirma_pedido').removeClass('disabled')
                $('#cantidad').removeClass('disabled')
                $('#confirma_pedido').removeAttr('disabled', 'disabled')
                $('#cantidad').removeAttr('disabled', 'disabled')
                $('#edita_pedido').addClass('display-none')
                const options2 = { style: 'currency', currency: 'USD' };
                const numberFormat2 = new Intl.NumberFormat('en-US', options2);
                $('.info_mp').html('');
                $('.total').html(numberFormat2.format(subtotal))
            }
        });
    });
    function activaIva() {
        $('#modal-info-fact').removeClass('cerrado2');
        
    }

    $(document).on("click", "#cancelar", cerrarFicha);
    $(document).on("click", "#guarda_datos", guardaDatos);
    
    function cerrarFicha (e) {
        e.preventDefault();
        $("#activa_iva").removeAttr('checked');
        var razon_social = $('#razon_social').val('')
        var rfc = $('#rfc').val('')
        var direccion_fiscal = $('#direccion_fiscal').val('')
        $('#modal-info-fact').addClass('cerrado2');
    }
    function guardaDatos() {
        var razon_social = $('#razon_social').val()
        var rfc = $('#rfc').val()
        var direccion_fiscal = $('#direccion_fiscal').val()
        if (razon_social == "" && rfc == "" && direccion_fiscal == "") {
            return alert("Llena los campos requeridos")
        }else{
            var subtotal = $('#subtotal').val()
            var envio = $("#costo_envio").val();
            var cantidad = $("#cantidad").val();
            var iva = subtotal * 0.16;
            var total_con_iva = parseFloat(subtotal) + parseFloat(iva);
            var subtenvio = cantidad * envio;
            const options2 = { style: 'currency', currency: 'USD' };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);

            $('.iva').html(numberFormat2.format(iva))
            $('.total').html(numberFormat2.format(total_con_iva + subtenvio))
            
            $('#fila-iva').removeClass('display-none');
            $('#modal-info-fact').addClass('cerrado2');
        }
        
    }

    function editaPedido() {
        $('#confirma_pedido').removeClass('disabled')
        $('#cantidad').removeClass('disabled')
        $('#confirma_pedido').removeAttr('disabled', 'disabled')
        $('#cantidad').removeAttr('disabled', 'disabled')
        $('.info_mp').html('');
        $('#edita_pedido').addClass('display-none')
        $('#activa_iva').removeClass('disabled')
        $('#activa_iva').removeAttr('disabled', 'disabled')
    }
    
    function btnAccionMp(e) {
        $('footer').addClass('display-none')
        e.preventDefault();
        var accion = $(this).attr('data-accion')
        if (accion == "open") {
            $('.cont-pago').addClass('muestra-p')
            $('.cont-pago').removeClass('display-none')
            $(this).attr('data-accion', 'close')
        }
        if (accion == "close") {
            $('.cont-pago').removeClass('muestra-p')
            $(this).attr('data-accion', 'open')
            $('.cont-pago').addClass('display-none')
        }
    }
    function btnCerrarMp(e) {
        e.preventDefault();
        $('.cont-pago').removeClass('muestra-p')
        $('#btn-accion-mp').attr('data-accion', 'open')
        $('.cont-pago').addClass('display-none')
        $('footer').removeClass('display-none')
    }
</script>