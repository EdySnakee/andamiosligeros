@extends('layouts.web_andamios')

    <title>{{(!empty($info_producto->meta_title))?$info_producto->meta_title:''}} | Venta de Andamios Galvanizados Ligeros</title>

    <meta name="description" content="{{(!empty($info_producto->meta_descripcion))?$info_producto->meta_descripcion:''}}">
    <meta name="keywords" content="{{(!empty($info_producto->meta_keywords))?$info_producto->meta_keywords:''}}">
    <meta property="og:description" content="{{(!empty($info_producto->meta_descripcion))?$info_producto->meta_descripcion:''}}">
    <meta property="og:keywords" content="{{(!empty($info_producto->meta_keywords))?$info_producto->meta_keywords:''}}">
    <meta property="og:title" content="{{(!empty($info_producto->meta_title))?$info_producto->meta_title:''}}">
    
    <meta property="og:url" content="{{(!empty($info_producto->meta_url))?$info_producto->meta_url:''}}">
    <link rel="canonical" href="{{(!empty($info_producto->meta_canonical))?$info_producto->meta_canonical:''}}">
    
    <meta property="og:image" content="{{(!empty($img_social->file_url))?$img_social->file_url:''}}">
    <meta property="og:image:secure_url" content="{{(!empty($img_social->file_url))?$img_social->file_url:''}}" />

    @if($info_producto->post_estatus == 2)
        <meta name="robots" content="noindex">
        <meta name="googlebot" content="noindex">
    @endif
    @php
    if (!empty($info_producto->precio2)){
        $value = $info_producto->precio2;
    }else{
        $value = $info_producto->precio;
    } 
    @endphp
    
    <link rel="stylesheet" href="{{url('web/owl/owlcarousel/assets/owl.carousel.min.css')}}">
    <script>
        !function(f,b,e,v,n,t,s)
        {if(f.fbq)return;n=f.fbq=function(){n.callMethod?
        n.callMethod.apply(n,arguments):n.queue.push(arguments)};
        if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
        n.queue=[];t=b.createElement(e);t.async=!0;
        t.src=v;s=b.getElementsByTagName(e)[0];
        s.parentNode.insertBefore(t,s)}(window, document,'script',
        'https://connect.facebook.net/en_US/fbevents.js');
        fbq('init', '5243995428995951');
        fbq('track', 'ViewContent', {content_name: "{{$info_producto->post_titulo}}", currency: 'MXN', value: '{{$value}}'});
      </script>
@section('css')
    @if($info_producto->post_estatus == 2)
        <style>
            .demo p {
            color: white;
            margin: 5px 0px;
            }
            .demo {
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                z-index: 9999;
                text-align: center;
                background: black;
            }
            .es_demo{
                margin-top: 2em;
            }
            .btn-editar {
                padding: 5px !important;
                margin: 0 !important;
                cursor: pointer;
                background: #ff9800 !important;
            }
            .demo > p, .demo > form {
                display: inline-block;
            }
            .menu-top{
                margin-top: 3em;
            }
        </style>
    @endif
    
    @include('web_andamios.includes.css_extra_loco')
    <link rel="stylesheet" href="{{url('loco/css/bootstrap.css')}}">
@stop
@section('content')
    @if($info_producto->post_estatus == 2)
        <div class="demo">
            <p>Esta es una página borrador, no se indexará hasta que se publique </p>
        </div>
    @endif
    @include('web_andamios.tienda.detalle_productos.contenido_producto')
@stop

@section('js')
<script src='https://code.jquery.com/jquery-3.3.1.js'></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>
<script src="{{url('web/js/theme.js')}}"></script>
{{--<script src="{{url('web/js/zoom.js')}}"></script>--}}
<script src="{{url('web/owl/owlcarousel/owl.carousel.min.js')}}"></script>
@include('web_andamios.includes.scripts_funciones')


    @if($info_producto->post_estatus == 2)
    <script>
    $( document ).ready(function() {
        $("body").addClass("es_demo");
        $(".menu-top").addClass('bg-header-color');
    });
    
    </script>
    @else
    <script>
    $( document ).ready(function() {
        $("body").addClass("es_demo");
        
    });
    </script>
    @endif
    <script>
        (function($) {
            'use strict';
            $(document).on('click', '.quantity .plus', function() { var $qty = $(this).parents('.quantity').find('.qty'); var currentVal = parseInt($qty.val()); if (!isNaN(currentVal)) { $qty.val(currentVal + 1); } });
            $(document).on('click', '.quantity .minus', function() { var $qty = $(this).parents('.quantity').find('.qty'); var currentVal = parseInt($qty.val()); if (!isNaN(currentVal) && currentVal > 1) { $qty.val(currentVal - 1); } });
            
            theme.fn.intObs('.thumb-gallery-wrapper', function() {
                var $thumbGalleryDetail = $(this).find('.thumb-gallery-detail'),
                    $thumbGalleryThumbs = $(this).find('.thumb-gallery-thumbs'),
                    flag = false,
                    duration = 300;
                $thumbGalleryDetail.owlCarousel({ 
                    items: 1, 
                    margin: 10,
                    nav: true, 
                    dots: false, 
                    loop: false, 
                    autoHeight: true, 
                    navText: [], 
                    rtl: ($('html').attr('dir') == 'rtl') ? true : false }).on('changed.owl.carousel', function(e) {
                        if (!flag) {
                            flag = true;
                            $thumbGalleryThumbs.trigger('to.owl.carousel', [e.item.index - 1, duration, true]);
                            $thumbGalleryThumbs.find('.owl-item').removeClass('selected');
                            $thumbGalleryThumbs.find('.owl-item').eq(e.item.index).addClass('selected');
                            flag = false;
                        }
                    });
                $thumbGalleryThumbs.owlCarousel({ 
                    margin: 15, 
                    items: $(this).data('thumbs-items') ? $(this).data('thumbs-items') : 4, 
                    nav: false, center: $(this).data('thumbs-center') ? true : false, 
                    dots: false, rtl: ($('html').attr('dir') == 'rtl') ? true : false }).on('click', '.owl-item', function() { $thumbGalleryDetail.trigger('to.owl.carousel', [$(this).index(), duration, true]); }).on('changed.owl.carousel', function(e) {
                    if (!flag) {
                        flag = true;
                        $thumbGalleryDetail.trigger('to.owl.carousel', [e.item.index, duration, true]);
                        flag = false;
                    }
                });
                $thumbGalleryThumbs.find('.owl-item').eq(0).addClass('selected');
            }, {});
        }).apply(this, [jQuery]);
    </script>
@stop
