
@extends('layouts.web_andamios')
@section('css')
    <title>🌟🤑🤙 Promoción Buen fin | Andamio Plegable | Andamios Ligeros</title>
    <meta name="description" content="Promoción Buen fin en Andamio Plegable válida todo el mes de noviembre del 2022" />
    <meta name="keywords" content="Andamios, andamios ligeros, andamios plegables, andamios seguros, andamios galvanizados" />
    
    
    <meta property="og:image" content="{{url('web/prom/BUEN-FIN-POST-FB-ANDAMIOS.jpg')}}" />
    <meta property="og:image:secure_url" content="{{url('web/prom/BUEN-FIN-POST-FB-ANDAMIOS.jpg')}}" />
    
    <meta property="og:title" content="🌟🤑🤙 Promoción Buen fin | Andamio Plegable | Andamios Ligeros" />
    <meta property="og:site_name" content="🌟🤑🤙 Promoción Buen fin | Andamio Plegable | Andamios Ligeros" />
    <meta property="og:description" content="Promoción Buen fin en Andamio Plegable válida todo el mes de noviembre del 2022" />

    <link rel="canonical" href="{{url('/promocion-buen-fin-andamio-plegable-noviembre-2022')}}">
    <meta property="og:url" content="{{url('/promocion-buen-fin-andamio-plegable-noviembre-2022')}}" />
    @include('web_andamios.buen_fin.css_promos')
@stop
@section('content')
    <input type="hidden" name="costo_articulo" id="costo_articulo" value="{{$costo_item}}">
    <div class="nav-top text-center flex-content">
        <div class="txt-top"><p class="text-white">HASTA 3 MESES SIN INTERES PAGANDO CON TARJETA DE CRÉDITO.</p> </div>
        <div class="badgespan-seguro bg-white"><p class="andes-badge__content">Compra Protegida <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.640015 3.0649C0.640015 6.71094 1.94452 9.03851 4.54271 9.96529L4.64001 10L4.73732 9.96529C7.33551 9.03851 8.64001 6.71094 8.64001 3.0649V2.73563H8.33232C7.17893 2.73563 6.01526 2.21963 4.83635 1.17412L4.64001 1L4.44368 1.17412C3.26477 2.21963 2.1011 2.73563 0.947707 2.73563H0.640015V3.0649Z" stroke="#00A650"></path><path d="M3.118 5.2201L2.64001 5.6522L4.14767 7L6.64001 4.39759L6.12631 4L4.10919 6.1062L3.118 5.2201Z" fill="#00A650"></path></svg></p></div>
        <div class="logo-mp" style="display: inline-flex; align-items: center; margin-left: 8px;">
            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 20px; max-width: 90px; object-fit: contain; filter: brightness(0) invert(1);">
        </div>
    </div>
    <main class="page-normal">
        {{--@include('web_andamios.buen_fin.count_down')--}}
        <section class="seccion-normal promo">
            <div class="contenido">
                <div class="grid-flex wrapper">
                    <div class="col-12">
                        <div class="texto text-justify">
                            <img class="img-promo" src="{{url('web/prom/para-landing-buen-fin.webp')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        {{--
        
        <div class="seccion-promocion">
            <div class="botonera-mp animate__animated animate__heartBeat animate__infinite">
                <div class="cont-botones">
                    <ul>
                        <li>
                            <a id="btn-accion-mp" class=""  data-accion="open" href="#">🌟 SOLICITAR PROMO 🤑🤙</a>
                        </li>
                    </ul>
                </div>
            </div>
            <div class="cont-pago display-none">
                @include('web_andamios.barra_pago.barra_pago')
            </div>
        </div>
        --}}
        
    </main>
    
@stop
@section('js')
<script type="text/javascript" src="https://js.openpay.mx/openpay.v1.min.js"></script>
<script type="text/javascript" src="https://js.openpay.mx/openpay-data.v1.min.js"></script>
<script>
    $(document).on("click", "#btn-accion-mp", btnAccionMp);
    $(document).on("click", "#cerrar-pago", btnCerrarMp);
    $(document).on("click", "#confirma_pedido", validaCampos);
    $(document).on("click", "#edita_pedido", editaPedido);
    
    
    $('#cantidad').on('input', function () { 
        this.value = this.value.replace(/[^0-9]/g,'');
        var cantidad = $(this).val();
        var costo_articulo = $("#costo_articulo").val();
        if (cantidad != 0) {
            var subtotal = cantidad * costo_articulo;            
            const options2 = { style: 'currency', currency: 'USD' };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);

            $('.subtotal').html(numberFormat2.format(subtotal))
            $('#subtotal').val(subtotal)
            if($('#activa_iva').is(":checked")){
                var iva = subtotal * 0.16;
                var total_con_iva = parseFloat(subtotal) + parseFloat(iva);
                
                $('.iva').html(numberFormat2.format(iva))
                $('.total').html(numberFormat2.format(total_con_iva))
                $('#total').val(total_con_iva)
            }
            else {
                $('.total').html(numberFormat2.format(subtotal))
                $('#total').val(subtotal)
            }
            
        }
    });

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
        var costo_articulo = $("#costo_articulo").val();
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
            var subtotal = $('#subtotal').val()
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
            var iva = subtotal * 0.16;
            var total_con_iva = parseFloat(subtotal) + parseFloat(iva);
            const options2 = { style: 'currency', currency: 'USD' };
            const numberFormat2 = new Intl.NumberFormat('en-US', options2);

            $('.iva').html(numberFormat2.format(iva))
            $('.total').html(numberFormat2.format(total_con_iva))
            
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
    }
</script>
@stop
