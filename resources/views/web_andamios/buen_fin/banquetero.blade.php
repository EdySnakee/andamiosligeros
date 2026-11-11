
@extends('layouts.web_andamios')
@section('css')
    <title>🌟🤑🤙 Andamio Ligero Banquetero SBT4 | Andamios Ligeros Galvanizados</title>
    <meta name="description" content="Andamio Banquetero SBT-4 de cuatro peldaños, el más pequeño en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior." />
    <meta name="keywords" content="Andamios, andamios ligeros, andamios Banquetero SBT4s, andamios seguros, andamios galvanizados" />
    
    
    <meta property="og:image" content="{{url('web/prom/2023/enero/post-sbt4.webp')}}" />
    <meta property="og:image:secure_url" content="{{url('web/prom/2023/enero/post-sbt4.webp')}}" />
    
    <meta property="og:title" content="🌟🤑🤙 Andamio Ligero Banquetero SBT4 | Andamios Ligeros Galvanizados" />
    <meta property="og:site_name" content="🌟🤑🤙 Andamio Ligero Banquetero SBT4 | Andamios Ligeros Galvanizados" />
    <meta property="og:description" content="Andamio Ligero Banquetero SBT-4 de cuatro peldaños, el más pequeño en su tipo, fácil de transportar, ideal para espacios reducidos y trabajos en interior." />

    <link rel="canonical" href="{{url('/apromocion-andamio-ligero-banquetero-sbt4')}}">
    <meta property="og:url" content="{{url('/apromocion-andamio-ligero-banquetero-sbt4')}}" />
    @include('web_andamios.buen_fin.css_promos')
@stop
@section('content')
    <input type="hidden" name="costo_articulo" id="costo_articulo" value="{{$costo_item}}">
    <input type="hidden" name="nombre_product" id="nombre_product" value="{{$nombre_product}}">
    <div class="nav-top text-center flex-content">
        <div class="txt-top"><p class="text-white">HASTA 3 MESES SIN INTERES PAGANDO CON TARJETA DE CRÉDITO.</p> </div>
        <div class="badgespan-seguro bg-white"><p class="andes-badge__content">Pago Seguro <svg width="10" height="11" viewBox="0 0 10 11" fill="none" xmlns="http://www.w3.org/2000/svg"><path d="M0.640015 3.0649C0.640015 6.71094 1.94452 9.03851 4.54271 9.96529L4.64001 10L4.73732 9.96529C7.33551 9.03851 8.64001 6.71094 8.64001 3.0649V2.73563H8.33232C7.17893 2.73563 6.01526 2.21963 4.83635 1.17412L4.64001 1L4.44368 1.17412C3.26477 2.21963 2.1011 2.73563 0.947707 2.73563H0.640015V3.0649Z" stroke="#00A650"></path><path d="M3.118 5.2201L2.64001 5.6522L4.14767 7L6.64001 4.39759L6.12631 4L4.10919 6.1062L3.118 5.2201Z" fill="#00A650"></path></svg></p></div>
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
                            <img class="img-promo" src="{{url('web/prom/2023/enero/post-sbt4-trans.webp')}}" alt="">
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="present-sbt4">
            <style>
                .present-sbt4 .border-title-secc {
                    text-align: center !important;
                }
            </style>
            <div class="text-center">
                <h3 class="text-yellow">TE PRESENTAMOS ANDAMIOS LIGEROS </h3>
                <h2 class="border-title-secc">
                    BANQUETEROS SBT4
                </h2>
            </div>
        </section>
        @include('web_andamios.productos.banqueteros.sbt4.detalle_sbt4')
        
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
        
        
        
    </main>
    
@stop
@section('js')
    @include('web_andamios.buen_fin.js_promos')
    @include('web_andamios.includes.scripts_funciones')
    @include('web_andamios.includes.scripts_seleccion_medidas')
@stop
