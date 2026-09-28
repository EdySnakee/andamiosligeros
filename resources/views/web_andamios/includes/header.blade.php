@php
    use App\ProductosTienda;
@endphp
<header class="menu-top" id="navbar">
    <nav class="menu item-header">
        <div class="logo">
            <a href="{{ url('/') }}">
                <img src="{{ url('web/img/logo-andamios-merida.webp') }}" alt="">
            </a>
            <a href="{{ route('web_promos') }}" style="padding-left: 5vw;">Promociones</a>
        </div>
        <ul class="ul-nav">
            <div class="cont-movil">
                <li><a href="{{ url('/') }}">Inicio</a></li>
                <li class="padre"><a href="#">Productos</a>
                    <ul class="submenu">
                        <li class="hijo">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="{{ route('web_tradicionales') }}">Tradicionales</a>
                                <ul class="sub_submenu">
                                    <li><a href="{{ route('web_stp1') }}">Andamio Tradicional STP-1</a></li>
                                    <li><a href="{{ route('web_stp2') }}">Andamio Tradicional STP-2</a></li>
                                    <li><a href="{{ route('web_stp4') }}">Andamio Tradicional STP-4 <i
                                                class="fa fa-certificate" aria-hidden="true"></i></a></li>
                                    <li><a href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-stp-5') }}">Andamio
                                            Tradicional STP-5 </a></li>

                                    {{-- <li><a href="{{route('web_stp2')}}">Andamio Tradicional STP-5 <i class="fa fa-certificate" aria-hidden="true"></i></a></li> --}}
                                </ul>
                            </div>
                        </li>
                        <li class="hijo">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="{{ route('web_banqueteros') }}">Banqueteros</a>
                                <ul class="sub_submenu">
                                    <li><a href="{{ route('web_sbt1') }}">Andamio Banquetero SBT-1</a></li>
                                    <li><a href="{{ route('web_sbt2') }}">Andamio Banquetero SBT-2</a></li>
                                    <li><a href="{{ url('/andamios-ligeros-galvanizados-baqueteros-SBT4') }}">Andamio
                                            Banquetero SBT-4 <i class="fa fa-certificate" aria-hidden="true"></i></a>
                                    </li>
                                    <li><a href="{{ route('web_sbt6') }}">Andamio Banquetero SBT-6 <i
                                                class="fa fa-certificate" aria-hidden="true"></i></a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="hijo">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="{{ route('web_plafoneros') }}">
                                    <img width="150px" src="{{ url('web/img/logo-white.png') }}" alt="">
                                </a>
                                <ul class="sub_submenu">
                                    <li><a href="{{ url('/tienda/barandal-plegable-para-andamios-spl-5') }}">Modelo
                                            SPL-5</a></li>
                                    <li><a href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-stp-5') }}">Modelo
                                            STP-5 </a></li>
                                    <li><a
                                            href="{{ url('/tienda/andamio-tradicional-plegable-galvanizado-multiusos-stp-6') }}">Modelo
                                            STP-6 </a></li>
                                    <li><a href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-sbt-6') }}">Modelo
                                            SBT-6 <i class="fa fa-certificate" aria-hidden="true"></i></a></li>
                                    <li><a href="{{ url('/tienda/andamio-ligero-plegable-multiusos-sbt-7') }}">Modelo
                                            SBT-7</a></li>
                                    <li><a href="{{ route('web_sbt8') }}">Modelo SBT-8</a></li>
                                    <li><a href="{{ url('/tienda/andamio-ligero-plegable-multiusos-sbt-9---plataforma') }}">Modelo
                                            SBT-9</a></li>
                                    <li><a href="{{ url('/tienda/andamio-plegable-sbt-10---plataforma') }}">Modelo
                                            SBT-10</a></li>
                                    {{-- 
                                    <li><a href="{{route('web_spl2')}}">Modelo SBT-7</a></li>
                                    <li><a href="{{route('web_spl2')}}">Modelo SBT-8</a></li>
                                    <li><a href="{{route('web_spl2')}}">Modelo SBT-9 * Próximamente</a></li>
                                     --}}
                                </ul>
                            </div>
                        </li>
                        <li class="hijo menu-m">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="{{ route('web_plafoneros') }}">Plafoneros</a>
                                <ul class="sub_submenu">
                                    <li><a href="{{ route('web_spl1') }}">Andamio Plafonero SPL-1</a></li>
                                    <li><a href="{{ route('web_spl2') }}">Andamio Plafonero SPL-2</a></li>
                                    <li><a href="{{ route('web_spl3') }}">Andamio Plafonero SPL-3</a></li>
                                    <li><a href="{{ route('web_spl4') }}">Andamio Plafonero SPL-4</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="hijo">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="#">Otros modelos</a>
                                <ul class="sub_submenu">
                                    <li><a href="{{ route('web_pasilleros') }}">Pasillero</a></li>
                                    <li><a href="{{ route('web_pasarela') }}">Pasarela</a></li>
                                    <li><a href="{{ route('web_dobles') }}">Dobles</a></li>
                                    <li><a href="{{ route('web_sbt5') }}">Altos</a></li>
                                    <li><a href="{{ route('web_longitudinal') }}">Longitudinal</a></li>
                                </ul>
                            </div>
                        </li>
                        <li class="hijo">
                            <div class="cont-submenu">
                                <a class="titulo-sub-menu" href="{{ route('web_accesorios') }}">Accesorios</a>
                                <ul class="sub_submenu">
                                    @php
                                        $objAccesorios = ProductosTienda::where('categoria', 'accesorio')
                                            ->where('post_estatus', 1)
                                            ->get();
                                    @endphp
                                    @if (!$objAccesorios->isEmpty())
                                        @foreach ($objAccesorios as $item_product)
                                            <li><a
                                                    href="{{ url('/') }}/tienda/{{ $item_product->post_url }}">{{ $item_product->post_titulo }}</a>
                                            </li>
                                        @endforeach
                                    @endif


                                </ul>
                            </div>
                        </li>
                    </ul>
                </li>
                {{--
                <li class="padre"><a href="{{route('web_tradicionales')}}">Tradicional</a>
                    <ul class="submenu">
                        <li><a href="{{route('web_stp1')}}">Andamio Tradicional STP-1</a></li>
                        <li><a href="{{route('web_stp2')}}">Andamio Tradicional STP-2</a></li>
                        <li><a href="{{route('web_stp3')}}">Andamio Tradicional STP-3</a></li>
                    </ul>
                </li>
                <li class="padre"><a href="{{route('web_banqueteros')}}">Banquetero</a>
                    <ul class="submenu">
                        <li><a href="{{route('web_sbt1')}}">Andamio Banquetero SBT-1</a></li>
                        <li><a href="{{route('web_sbt2')}}">Andamio Banquetero SBT-2</a></li>
                        <li><a href="{{url('/andamios-ligeros-galvanizados-baqueteros-SBT4')}}">Andamio Banquetero SBT-4</a></li>
                        <li><a href="{{route('web_sbt5')}}">Andamio Banquetero SBT-5</a></li>
                        <li><a href="{{route('web_sbt6')}}">Andamio Banquetero SBT-6</a></li>
                    </ul>
                </li>
                <li class="padre"><a href="{{route('web_plafoneros')}}">Plafonero</a>
                    <ul class="submenu">
                        <li><a href="{{route('web_spl1')}}">Andamio Plafonero SPL-1</a></li>
                        <li><a href="{{route('web_spl2')}}">Andamio Plafonero SPL-2</a></li>
                    </ul>
                </li>
                --}}

                <li><a href="{{ url('/blog') }}">Blog</a></li>
                <li><a href="{{ url('/tienda') }}">Tienda</a></li>

                <li class="carrito_box">
                    <a href="#" id="miniCarrito">
                        <img src="{{ url('web/img/carrito.png') }}" width="30" alt="">
                        <span class="cont-carrito {{ empty(session()->get('cart')) ? 'd-none' : '' }}">
                            <span class="font-cart">
                                {{ is_countable(session()->get('cart')) ? count(session()->get('cart')) : 0 }}
                            </span>
                        </span>
                    </a>
                </li>
                <li class="contact_box"><a class="item-subm" href="#contacto">Contacto</a></li>
            </div>
        </ul>
        <div class="cont-menu-movil">
            <a href="#" id="menu_movil" accion-menu="abrir"><span id="tipo_m"><i class="fa fa-bars"
                        aria-hidden="true"></i> Menú</span></a>
        </div>
    </nav>
    <div id="contenedor-minicart" class="contenedor-mini-cart">
        <div id="modal-mini-cart" class="mini-cart cerrado">
        </div>
    </div>
    {{-- @include('web_andamios.includes.banner_buen_fin') --}}
</header>