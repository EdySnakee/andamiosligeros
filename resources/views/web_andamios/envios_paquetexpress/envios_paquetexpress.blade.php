@extends('layouts.web_andamios')
@section('css')
    <title>Andamios ligeros | Envios Paquetexpress</title>
    <meta name="description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes." />
    <meta name="keywords" content="construccion, Andamios, galvanizados, ligeros, resistentes, constructor, proteccion" />
    <meta property="og:image" content="{{ url('web/img/Envio_Paquetexpress/Paquetexpress-logo-azul.webp') }}" />
    <meta property="og:image:secure_url" content="{{ url('web/img/Envio_Paquetexpress/Paquetexpress-logo-azul.webp') }}" />
    <meta property="og:title" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:site_name" content="Andamios ligeros| Andamios Galvanizados | Andamios" />
    <meta property="og:description"
        content="En Andamios Ligeros, nos enfocamos para que nuestros andamios sean cada vez más, ligeros, seguros y resistentes" />
    <link rel="canonical" href="{{ url('/envios-paquetexpress') }}">
    <meta property="og:url" content="{{ url('/envios-paquetexpress') }}" />
@stop
@section('content')
    <main class="page-normal">
        <section class="panel">
            <img class="panel-paquetexpress mobile" src="{{ url('/web/img/Envio_Paquetexpress/PanelPXM1.png') }}"
                alt="panel-paquetexpress-movil">
            <img class="panel-paquetexpress mobile" src="{{ url('/web/img/Envio_Paquetexpress/PanelPXM2.png') }}"
                alt="panel-paquetexpress-movil">
            <img class="panel-paquetexpress mobile" src="{{ url('/web/img/Envio_Paquetexpress/PanelPXM3.png') }}"
                alt="panel-paquetexpress-movil">
            <img class="panel-paquetexpress desktop" src="{{ url('/web/img/Envio_Paquetexpress/PanelPX.png') }}"
                alt="panel-paquetexpress">
        </section>
        <form class="rastreo-paquetexpress" onsubmit="return rastrearPaquete(event)">
            <input class="rastreo-input" type="text" placeholder="Ingresa un número de rastreo">
            <button type="submit" class="rastreo-btn" target="_blank">RASTREA TU ENVÍO</button>
            <p class="rastreo-texto">También puedes comprobar envios que hemos realizado colocando alguno de los siguientes números de rastreo:</p>
        </form>
        <section class="reporte-guias">
            <img class="reporte-guias-header mobile" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuiasM.png') }}"
                alt="reporte-guias">
            <img class="reporte-guias-header desktop" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias.png') }}"
                alt="reporte-guias">
            <div class="reporte-guias-tabla">
                <img class="reporte-tabla-header" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-header.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla7.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla6.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla5.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla4.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla3.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla.png') }}"
                    alt="reporte-guias">
                <img class="reporte-tabla-img" src="{{ url('/web/img/Envio_Paquetexpress/ReporteGuias-tabla2.png') }}"
                    alt="reporte-guias">
            </div>
        </section>
        <section class="cobertura-paqexpress">
            <a class="cobertura-img" href="https://www.paquetexpress.com.mx/destinos/" target="_blank">
                <img src="{{ url('web/img/Envio_Paquetexpress/cobertura.png') }}" alt="">
            </a>
        </section>
    </main>

@stop
@section('js')
    @include('web_andamios.includes.scripts_funciones');
    @include('web_andamios.envios_paquetexpress.envios_paquetexpress_js');
    @include('web_andamios.envios_paquetexpress.envios_paquetexpress_css_loco');
@stop
