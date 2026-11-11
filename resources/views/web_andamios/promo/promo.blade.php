@extends('layouts.web_andamios')
@section('css')
<title>{{ $meta_titulo }}</title>
<meta name="description" content="{{ $descripcion }}" />
<meta name="keywords" content="Andamios, andamios ligeros, andamios Plegables, andamios seguros, andamios galvanizados" />


<meta property="og:image" content="{{ url('web/prom') }}/{{ $img_banner }}" />
<meta property="og:image:secure_url" content="{{ url('web/prom') }}/{{ $img_banner }}" />

<meta property="og:title" content="{{ $meta_titulo }}" />
<meta property="og:site_name" content="{{ $meta_titulo }}" />
<meta property="og:description" content="{{ $descripcion }}" />

@include('web_andamios.includes.css_extra_loco')
@include('web_andamios.promo.css_promos')
@include('web_andamios.includes.scripts_seleccion_medidas')
<link rel="stylesheet" href="{{ url('web/owl/owlcarousel/assets/owl.carousel.min.css') }}">
<link rel="stylesheet" href="{{ url('loco/css/bootstrap.css') }}">
@stop

@section('content')
<input type="hidden" name="costo_articulo" id="costo_articulo" value="{{ $costo_item }}">
<input type="hidden" name="costo_activo" id="costo_activo" value="{{ $costo_item }}">
<input type="hidden" name="costo_desc" id="costo_desc" value="{{ $costo_desc }}">
<input type="hidden" name="cant_min" id="cant_min" value="{{ $cant_min }}">
<input type="hidden" name="nombre_product" id="nombre_product" value="{{ $nombre_product }}">


<main class="page-normal">
    <div class="nav-top text-center flex-content">
        <div class="txt-top">
            <p class="text-white">COMPRA FACIL Y SEGURO CON TU TARJETA DE DEBITO O CREDITO.</p>
        </div>
        <div class="badgespan-seguro bg-white">
            <p class="andes-badge__content">Pago Seguro <svg width="10" height="11" viewBox="0 0 10 11"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.640015 3.0649C0.640015 6.71094 1.94452 9.03851 4.54271 9.96529L4.64001 10L4.73732 9.96529C7.33551 9.03851 8.64001 6.71094 8.64001 3.0649V2.73563H8.33232C7.17893 2.73563 6.01526 2.21963 4.83635 1.17412L4.64001 1L4.44368 1.17412C3.26477 2.21963 2.1011 2.73563 0.947707 2.73563H0.640015V3.0649Z"
                        stroke="#00A650"></path>
                    <path
                        d="M3.118 5.2201L2.64001 5.6522L4.14767 7L6.64001 4.39759L6.12631 4L4.10919 6.1062L3.118 5.2201Z"
                        fill="#00A650"></path>
                </svg></p>
        </div>
        <div class="logo-mp" style="display: inline-flex; align-items: center; margin-left: 8px;">
            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 20px; max-width: 90px; object-fit: contain; filter: brightness(0) invert(1);">
        </div>
    </div>
    {{-- @include('web_andamios.buen_fin.count_down') --}}
    <section class="seccion-promo {{ !empty($fondo_promo) ? $fondo_promo : '' }}">
        <div class="flex-promo">
            <div class="col-int-prom">
                @if ($item_promo->status == 2)
                <div class="eti-vencida">
                    <h2>PROMO VENCIDA 😞</h2>
                </div>
                <div class="text-vencido">
                    <div class="cont-txt-pinfo">
                        <h2>¡LO SENTIMOS! <br> POR EL MOMENTO ESTA PROMOCION SE ENCUENTRA VENCIDA. <br> CONTACTANOS
                            PARA BRINDARTE LA MEJOR OPCION </h2>
                        <ul class="list-botonera">
                            <li>
                                <div class="cont-btn">
                                    <a href="{{ url('/promociones') }}"
                                        class="btn-open-modal-financial btn-financial"><span>Regresar a
                                            promociones</span></a>

                                </div>
                            </li>
                            <li>
                                <a onclick="return gtag_report_conversion('https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros');"
                                    href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros"
                                    id="whatsapp_asesor" class="whatsapp_asesor" target="_blank">
                                    CONTACTAR CON UN ASESOR
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @elseif ($item_promo->status == 3)
                <div class="text-vencido">
                    <div class="cont-txt-pinfo">
                        <h2>¡YA CASI! <br> REGRESA PRONTO, ESTA PROMOCION ESTARA ACTIVA EN EL BUEN FIN DEL 17 AL 19
                            DE NOVIEMBRE. <br> CONTACTANOS PARA BRINDARTE LA MEJOR OPCION </h2>
                        <ul class="list-botonera">
                            <li>
                                <div class="cont-btn">
                                    <a href="{{ url('/promociones-buen-fin-2023') }}"
                                        class="btn-open-modal-financial btn-financial"><span>Regresar a promociones
                                            de buen fin</span></a>

                                </div>
                            </li>
                            <li>
                                <a onclick="return gtag_report_conversion('https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros');"
                                    href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros"
                                    id="whatsapp_asesor" class="whatsapp_asesor" target="_blank">
                                    CONTACTAR CON UN ASESOR
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
                <div
                    class="texto {{ ($item_promo->status == 2 or $item_promo->status == 3) ? 'promo-inactiva' : '' }} text-justify">
                    <div class="detallepago_prom">

                        <div class="txt-pago text-center">

                            <div class="cont-f-pasarela">
                                @if (!empty($img_barra_pago))
                                <div class="col-md">
                                    <img class="img-pasarela" src="{{ url('web/prom/') }}/{{ $img_barra_pago }}"
                                        alt="">
                                </div>
                                @endif

                                <div class="cont-contacto col-md">
                                    <h3 class="txt-nomb-prod">{{ $nombre_product }}
                                    </h3>
                                    <p class="text-left">DATOS DE CONTACTO Y ENVIO</p>
                                    <div class="form-contacto">
                                        <div class="cont-flex">
                                            <div class="col6">
                                                <input type="text" placeholder="Nombre Completo *" class="form-c"
                                                    id="nombre_c">
                                            </div>
                                            <div class="col6">
                                                <input type="tel" placeholder="Telefono de Contacto *"
                                                    class="form-c" id="numero_c">
                                            </div>
                                        </div>
                                        <div class="cont-flex">
                                            <div class="col12">
                                                <input type="email" placeholder="Correo electronico *"
                                                    class="form-c" id="email_c">
                                            </div>
                                        </div>
                                        <div class="cont-flex">
                                            <div class="col12">
                                                <input type="text" placeholder="Direccion de entrega *"
                                                    class="form-c" id="direccion_c">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-left"> RESUMEN DE COMPRA</p>
                                    <div class="tabla-resumen">
                                        <table class="table text-center" style="width:100%">
                                            <tbody>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">

                                                        {{-- <input class="form-promo" min="1" pattern="^[0-9]+" type="number" id="cantidad" value="{{$cantidad}}"> --}}
                                                        <div class="quantity quantity-lg">
                                                            <input type="button"
                                                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                                value="-">
                                                            <input readonly type="text" class="input-text qty text"
                                                                title="Qty" value="{{ $cantidad }}"
                                                                id="cantidad" name="cantidad" min="1"
                                                                step="1">
                                                            <input type="button"
                                                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                                value="+">
                                                        </div>
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <span class="br-info info-preciounit">Precio unit.</span>
                                                        <p><small class="punitact"> <?php echo "$" . number_format($costo_item, 2, '.', ','); ?></small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <span class="br-info">Total</span>
                                                        <p><small class="costopluscant"> <?php echo "$" . number_format($costo_item, 2, '.', ','); ?></small>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>ENVIO</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="envio"><?php echo "$" . number_format($costo_envio, 2, '.', ','); ?></small></p>
                                                        <input type="hidden" name="envio" id="envio"
                                                            value="{{ $costo_envio }}">
                                                        <input type="hidden" name="envio" id="costo_envio"
                                                            value="{{ $costo_envio }}">
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>SUBTOTAL</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="subtotal sb-total"><?php echo "$" . number_format($costo_item + $costo_envio, 2, '.', ','); ?></small>
                                                        </p>
                                                        <input type="hidden" name="subtotal" id="subtotal"
                                                            value="{{ $costo_item + $costo_envio }}">
                                                    </td>
                                                </tr>

                                                <tr id="fila-iva" class="fila-sin-bordes display-none">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>IVA 16%</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="iva"><?php echo "$" . number_format(500, 2, '.', ','); ?></small></p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><b>TOTAL</b></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><b class="total"><?php echo "$" . number_format($costo_item + $costo_envio, 2, '.', ','); ?></b></p>
                                                        <input type="hidden" name="total" id="total"
                                                            value="{{ $costo_item + $costo_envio }}">
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td colspan="3" class="text-right">
                                                        <p><small><input type="checkbox" name="activa_iva"
                                                                    id="activa_iva"> <label for="activa_iva">Solicitar
                                                                    Factura</label></small></p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td colspan="3" class="text-right">
                                                        <button type="button float-right" class="btn-confirma"
                                                            id="confirma_pedido"> Confirmar pedido</button> <button
                                                            type="button" class="btn display-none"
                                                            id="edita_pedido"> Editar pedido</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="info_mp">
                                    </div>
                                </div>
                                {{--
                                        <div class="info-resumen col-md">
                                            <p>
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    width="15px" viewBox="0 0 335.966 239.95" enable-background="new 0 0 335.966 239.95"
                                                    xml:space="preserve">
                                                <g>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M167.984,239.945c-43.237,0-86.475,0.005-129.711-0.002
                                                        c-22.884-0.004-38.259-15.401-38.264-38.344C-0.002,147.115-0.003,92.631,0.01,38.147C0.015,15.386,15.365,0.005,38.055,0.004
                                                        c86.599-0.006,173.199-0.006,259.797,0c22.674,0.001,38.094,15.414,38.101,38.111c0.015,54.609,0.019,109.218-0.002,163.827
                                                        c-0.009,22.422-15.54,37.989-37.881,37.998C254.708,239.958,211.347,239.945,167.984,239.945z M24.002,96.12
                                                        c0,1.549,0,2.892,0,4.234c0,33.731-0.003,67.462,0.001,101.193c0.001,10.124,4.239,14.398,14.301,14.398
                                                        c86.452,0.006,172.903,0.006,259.354,0c10.003,0,14.299-4.348,14.3-14.438c0.005-33.731,0.002-67.463,0.002-101.194
                                                        c0-1.339,0-2.678,0-4.194C215.928,96.12,120.27,96.12,24.002,96.12z M311.961,71.751c0-1.271,0-2.36,0-3.449
                                                        c0-10.244,0.016-20.488-0.005-30.732c-0.019-9.095-4.515-13.621-13.547-13.621c-86.949-0.006-173.898-0.004-260.847-0.003
                                                        c-0.625,0-1.25-0.012-1.874,0.009c-6.517,0.22-11.509,4.821-11.608,11.331c-0.181,11.864-0.03,23.732,0.008,35.599
                                                        c0.001,0.317,0.304,0.634,0.423,0.867C120.276,71.751,215.929,71.751,311.961,71.751z"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M251.67,179.976c-7.732-0.002-15.466,0.046-23.198-0.015
                                                        c-7.578-0.06-12.938-5.155-12.875-12.109c0.064-6.93,5.473-11.855,13.098-11.864c15.467-0.018,30.933-0.022,46.398,0.002
                                                        c7.687,0.012,12.96,4.884,12.994,11.911c0.033,7.05-5.192,12.009-12.843,12.063C267.386,180.021,259.528,179.977,251.67,179.976z"
                                                        />
                                                </g>
                                                </svg>
                                                Paga con tu Tarjeta de Credito</p> 
                                            <br>
                                        </div>
                                        --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($item_promo->status == 1)
    {{--
            <div class="seccion-promocion">
                <div class="botonera-mp animate__animated animate__heartBeat animate__infinite">
                    <div class="cont-botones">
                        <ul>
                            <li>
                                <a id="btn-accion-mp" class=""  data-accion="close" href="#">🌟 SOLICITAR PROMO 🤑🤙</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cont-pago muestra-p">
                    @include('web_andamios.barra_pago.barra_pago')
                </div>
            </div>
            --}}
    @endif
</main>

@include('web_andamios.promo.modal_factura')


{{-- IMG-COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.img-complementos.img_complementos')

{{-- COMPONENTES --}}
@include('web_andamios.productos.banqueteros.sbt6.components.componentes_producto.componentes')

{{-- PREGUNTAS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.preguntas_producto.preguntas')


{{-- CAROUSEL TESTIMONNIOS --}}
{{-- @include('web_andamios.productos.banqueteros.sbt6.components.carousel_testimonios.carousel_testimonios') --}}


{{-- SEPARADOR 2 --}}
@include('web_andamios.productos.banqueteros.sbt6.components.separador_producto.separador')



{{-- IMG INTERACTIVA --}}
@include('web_andamios.productos.banqueteros.sbt6.components.imagen_interactiva.sbt6-explainer')


{{-- VIDEOS --}}
@include('web_andamios.productos.banqueteros.sbt6.components.videos_producto.videos_producto')


<main class="page-normal">
    <div class="nav-top text-center flex-content">
        <div class="txt-top">
            <p class="text-white">COMPRA FACIL Y SEGURO CON TU TARJETA DE DEBITO O CREDITO.</p>
        </div>
        <div class="badgespan-seguro bg-white">
            <p class="andes-badge__content">Pago Seguro <svg width="10" height="11" viewBox="0 0 10 11"
                    fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path
                        d="M0.640015 3.0649C0.640015 6.71094 1.94452 9.03851 4.54271 9.96529L4.64001 10L4.73732 9.96529C7.33551 9.03851 8.64001 6.71094 8.64001 3.0649V2.73563H8.33232C7.17893 2.73563 6.01526 2.21963 4.83635 1.17412L4.64001 1L4.44368 1.17412C3.26477 2.21963 2.1011 2.73563 0.947707 2.73563H0.640015V3.0649Z"
                        stroke="#00A650"></path>
                    <path
                        d="M3.118 5.2201L2.64001 5.6522L4.14767 7L6.64001 4.39759L6.12631 4L4.10919 6.1062L3.118 5.2201Z"
                        fill="#00A650"></path>
                </svg></p>
        </div>
        <div class="logo-mp" style="display: inline-flex; align-items: center; margin-left: 8px;">
            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 20px; max-width: 90px; object-fit: contain; filter: brightness(0) invert(1);">
        </div>
    </div>
    {{-- @include('web_andamios.buen_fin.count_down') --}}
    <section class="seccion-promo {{ !empty($fondo_promo) ? $fondo_promo : '' }}">
        <div class="flex-promo">
            <div class="col-int-prom">
                @if ($item_promo->status == 2)
                <div class="eti-vencida">
                    <h2>PROMO VENCIDA 😞</h2>
                </div>
                <div class="text-vencido">
                    <div class="cont-txt-pinfo">
                        <h2>¡LO SENTIMOS! <br> POR EL MOMENTO ESTA PROMOCION SE ENCUENTRA VENCIDA. <br> CONTACTANOS
                            PARA BRINDARTE LA MEJOR OPCION </h2>
                        <ul class="list-botonera">
                            <li>
                                <div class="cont-btn">
                                    <a href="{{ url('/promociones') }}"
                                        class="btn-open-modal-financial btn-financial"><span>Regresar a
                                            promociones</span></a>

                                </div>
                            </li>
                            <li>
                                <a onclick="return gtag_report_conversion('https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros');"
                                    href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros"
                                    id="whatsapp_asesor" class="whatsapp_asesor" target="_blank">
                                    CONTACTAR CON UN ASESOR
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @elseif ($item_promo->status == 3)
                <div class="text-vencido">
                    <div class="cont-txt-pinfo">
                        <h2>¡YA CASI! <br> REGRESA PRONTO, ESTA PROMOCION ESTARA ACTIVA EN EL BUEN FIN DEL 17 AL 19
                            DE NOVIEMBRE. <br> CONTACTANOS PARA BRINDARTE LA MEJOR OPCION </h2>
                        <ul class="list-botonera">
                            <li>
                                <div class="cont-btn">
                                    <a href="{{ url('/promociones-buen-fin-2023') }}"
                                        class="btn-open-modal-financial btn-financial"><span>Regresar a promociones
                                            de buen fin</span></a>

                                </div>
                            </li>
                            <li>
                                <a onclick="return gtag_report_conversion('https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros');"
                                    href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros"
                                    id="whatsapp_asesor" class="whatsapp_asesor" target="_blank">
                                    CONTACTAR CON UN ASESOR
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                @endif
                <div
                    class="texto {{ ($item_promo->status == 2 or $item_promo->status == 3) ? 'promo-inactiva' : '' }} text-justify">
                    <div class="detallepago_prom">

                        <div class="txt-pago text-center">

                            <div class="cont-f-pasarela">
                                @if (!empty($img_barra_pago))
                                <div class="col-md">
                                    <img class="img-pasarela" src="{{ url('web/prom/') }}/{{ $img_barra_pago }}"
                                        alt="">
                                </div>
                                @endif

                                <div class="cont-contacto col-md">
                                    <h3 class="txt-nomb-prod">{{ $nombre_product }}
                                    </h3>
                                    <p class="text-left">DATOS DE CONTACTO Y ENVIO</p>
                                    <div class="form-contacto">
                                        <div class="cont-flex">
                                            <div class="col6">
                                                <input type="text" placeholder="Nombre Completo *" class="form-c"
                                                    id="nombre_c">
                                            </div>
                                            <div class="col6">
                                                <input type="tel" placeholder="Telefono de Contacto *"
                                                    class="form-c" id="numero_c">
                                            </div>
                                        </div>
                                        <div class="cont-flex">
                                            <div class="col12">
                                                <input type="email" placeholder="Correo electronico *"
                                                    class="form-c" id="email_c">
                                            </div>
                                        </div>
                                        <div class="cont-flex">
                                            <div class="col12">
                                                <input type="text" placeholder="Direccion de entrega *"
                                                    class="form-c" id="direccion_c">
                                            </div>
                                        </div>
                                    </div>
                                    <p class="text-left"> RESUMEN DE COMPRA</p>
                                    <div class="tabla-resumen">
                                        <table class="table text-center" style="width:100%">
                                            <tbody>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">

                                                        {{-- <input class="form-promo" min="1" pattern="^[0-9]+" type="number" id="cantidad" value="{{$cantidad}}"> --}}
                                                        <div class="quantity quantity-lg">
                                                            <input type="button"
                                                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                                value="-">
                                                            <input readonly type="text" class="input-text qty text"
                                                                title="Qty" value="{{ $cantidad }}"
                                                                id="cantidad" name="cantidad" min="1"
                                                                step="1">
                                                            <input type="button"
                                                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                                                value="+">
                                                        </div>
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <span class="br-info info-preciounit">Precio unit.</span>
                                                        <p><small class="punitact"> <?php echo "$" . number_format($costo_item, 2, '.', ','); ?></small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <span class="br-info">Total</span>
                                                        <p><small class="costopluscant"> <?php echo "$" . number_format($costo_item, 2, '.', ','); ?></small>
                                                        </p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>ENVIO</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="envio"><?php echo "$" . number_format($costo_envio, 2, '.', ','); ?></small></p>
                                                        <input type="hidden" name="envio" id="envio"
                                                            value="{{ $costo_envio }}">
                                                        <input type="hidden" name="envio" id="costo_envio"
                                                            value="{{ $costo_envio }}">
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>SUBTOTAL</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="subtotal sb-total"><?php echo "$" . number_format($costo_item + $costo_envio, 2, '.', ','); ?></small>
                                                        </p>
                                                        <input type="hidden" name="subtotal" id="subtotal"
                                                            value="{{ $costo_item + $costo_envio }}">
                                                    </td>
                                                </tr>

                                                <tr id="fila-iva" class="fila-sin-bordes display-none">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><small>IVA 16%</small></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><small class="iva"><?php echo "$" . number_format(500, 2, '.', ','); ?></small></p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td class="text-left flex-td">
                                                    </td>
                                                    <td class="text-center flex-td">
                                                        <p><b>TOTAL</b></p>
                                                    </td>
                                                    <td class="text-right flex-td">
                                                        <p><b class="total"><?php echo "$" . number_format($costo_item + $costo_envio, 2, '.', ','); ?></b></p>
                                                        <input type="hidden" name="total" id="total"
                                                            value="{{ $costo_item + $costo_envio }}">
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td colspan="3" class="text-right">
                                                        <p><small><input type="checkbox" name="activa_iva"
                                                                    id="activa_iva"> <label for="activa_iva">Solicitar
                                                                    Factura</label></small></p>
                                                    </td>
                                                </tr>
                                                <tr class="fila-sin-bordes">
                                                    <td colspan="3" class="text-right">
                                                        <button type="button float-right" class="btn-confirma"
                                                            id="confirma_pedido"> Confirmar pedido</button> <button
                                                            type="button" class="btn display-none"
                                                            id="edita_pedido"> Editar pedido</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="info_mp">
                                    </div>
                                </div>
                                {{--
                                        <div class="info-resumen col-md">
                                            <p>
                                                <svg version="1.1" id="Capa_1" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" x="0px" y="0px"
                                                    width="15px" viewBox="0 0 335.966 239.95" enable-background="new 0 0 335.966 239.95"
                                                    xml:space="preserve">
                                                <g>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M167.984,239.945c-43.237,0-86.475,0.005-129.711-0.002
                                                        c-22.884-0.004-38.259-15.401-38.264-38.344C-0.002,147.115-0.003,92.631,0.01,38.147C0.015,15.386,15.365,0.005,38.055,0.004
                                                        c86.599-0.006,173.199-0.006,259.797,0c22.674,0.001,38.094,15.414,38.101,38.111c0.015,54.609,0.019,109.218-0.002,163.827
                                                        c-0.009,22.422-15.54,37.989-37.881,37.998C254.708,239.958,211.347,239.945,167.984,239.945z M24.002,96.12
                                                        c0,1.549,0,2.892,0,4.234c0,33.731-0.003,67.462,0.001,101.193c0.001,10.124,4.239,14.398,14.301,14.398
                                                        c86.452,0.006,172.903,0.006,259.354,0c10.003,0,14.299-4.348,14.3-14.438c0.005-33.731,0.002-67.463,0.002-101.194
                                                        c0-1.339,0-2.678,0-4.194C215.928,96.12,120.27,96.12,24.002,96.12z M311.961,71.751c0-1.271,0-2.36,0-3.449
                                                        c0-10.244,0.016-20.488-0.005-30.732c-0.019-9.095-4.515-13.621-13.547-13.621c-86.949-0.006-173.898-0.004-260.847-0.003
                                                        c-0.625,0-1.25-0.012-1.874,0.009c-6.517,0.22-11.509,4.821-11.608,11.331c-0.181,11.864-0.03,23.732,0.008,35.599
                                                        c0.001,0.317,0.304,0.634,0.423,0.867C120.276,71.751,215.929,71.751,311.961,71.751z"/>
                                                    <path fill-rule="evenodd" clip-rule="evenodd" fill="#3F3F3F" d="M251.67,179.976c-7.732-0.002-15.466,0.046-23.198-0.015
                                                        c-7.578-0.06-12.938-5.155-12.875-12.109c0.064-6.93,5.473-11.855,13.098-11.864c15.467-0.018,30.933-0.022,46.398,0.002
                                                        c7.687,0.012,12.96,4.884,12.994,11.911c0.033,7.05-5.192,12.009-12.843,12.063C267.386,180.021,259.528,179.977,251.67,179.976z"
                                                        />
                                                </g>
                                                </svg>
                                                Paga con tu Tarjeta de Credito</p> 
                                            <br>
                                        </div>
                                        --}}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    @if ($item_promo->status == 1)
    {{--
            <div class="seccion-promocion">
                <div class="botonera-mp animate__animated animate__heartBeat animate__infinite">
                    <div class="cont-botones">
                        <ul>
                            <li>
                                <a id="btn-accion-mp" class=""  data-accion="close" href="#">🌟 SOLICITAR PROMO 🤑🤙</a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="cont-pago muestra-p">
                    @include('web_andamios.barra_pago.barra_pago')
                </div>
            </div>
            --}}
    @endif
</main>


@stop
@section('js')
<link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js"
    integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"> </script>
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
    AOS.init();
</script>
@include('web_andamios.promo.js_promos')
@include('web_andamios.includes.scripts_funciones')
@stop