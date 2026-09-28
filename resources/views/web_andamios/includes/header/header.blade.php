@php
    use App\ProductosTienda;
@endphp
@include('web_andamios.includes.header.css_header_loco')
@include('web_andamios.includes.header.js_header')
<header class="andamios-header" id="navbar">
    {{-- NAVBAR --}}
    <nav class="andamios-nav">
        {{-- LOGO --}}
        <div class="nav-logo">
            <a href="{{ url('/') }}">
                <img src="{{ url('web/img/logo-andamios-merida.webp') }}" alt="">
            </a>
        </div>

        {{-- OPCIÓN ESPECIAL (PROMOCIONES) --}}
        <div class="nav-promociones">
            <a href="{{ url('/promociones') }}" class="cta">
                <span class="span">PROMOCIONES</span>
                <span class="second">
                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1"
                        viewBox="0 0 66 43" height="20px" width="50px">
                        <g fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="arrow">
                            <path fill="#fff"
                                d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                class="one"></path>
                            <path fill="#fff"
                                d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                class="two"></path>
                            <path fill="#fff"
                                d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                class="three"></path>
                        </g>
                    </svg>
                </span>
            </a>
        </div>

        {{-- ICONO MENÚ HAMBURGUESA (para móviles) --}}
        <button class="nav-hamburger" id="nav-hamburger">
            &#9776; <!-- Este es el símbolo de hamburguesa -->
        </button>

        {{-- OPCIONES DE LA NAVBAR --}}
        <div id="nav-opciones" class="nav-opciones">
            <img class="mobile-menu-logo" src="{{ url('web/img/logo-andamios-merida.webp') }}" alt="">
            <a href="{{ url('/promociones') }}" class="cta mobile">
                <span class="span">PROMOCIONES</span>
                <span class="second">
                    <svg xmlns:xlink="http://www.w3.org/1999/xlink" xmlns="http://www.w3.org/2000/svg" version="1.1"
                        viewBox="0 0 66 43" height="20px" width="50px">
                        <g fill-rule="evenodd" fill="none" stroke-width="1" stroke="none" id="arrow">
                            <path fill="#fff"
                                d="M40.1543933,3.89485454 L43.9763149,0.139296592 C44.1708311,-0.0518420739 44.4826329,-0.0518571125 44.6771675,0.139262789 L65.6916134,20.7848311 C66.0855801,21.1718824 66.0911863,21.8050225 65.704135,22.1989893 C65.7000188,22.2031791 65.6958657,22.2073326 65.6916762,22.2114492 L44.677098,42.8607841 C44.4825957,43.0519059 44.1708242,43.0519358 43.9762853,42.8608513 L40.1545186,39.1069479 C39.9575152,38.9134427 39.9546793,38.5968729 40.1481845,38.3998695 C40.1502893,38.3977268 40.1524132,38.395603 40.1545562,38.3934985 L56.9937789,21.8567812 C57.1908028,21.6632968 57.193672,21.3467273 57.0001876,21.1497035 C56.9980647,21.1475418 56.9959223,21.1453995 56.9937605,21.1432767 L40.1545208,4.60825197 C39.9574869,4.41477773 39.9546013,4.09820839 40.1480756,3.90117456 C40.1501626,3.89904911 40.1522686,3.89694235 40.1543933,3.89485454 Z"
                                class="one"></path>
                            <path fill="#fff"
                                d="M20.1543933,3.89485454 L23.9763149,0.139296592 C24.1708311,-0.0518420739 24.4826329,-0.0518571125 24.6771675,0.139262789 L45.6916134,20.7848311 C46.0855801,21.1718824 46.0911863,21.8050225 45.704135,22.1989893 C45.7000188,22.2031791 45.6958657,22.2073326 45.6916762,22.2114492 L24.677098,42.8607841 C24.4825957,43.0519059 24.1708242,43.0519358 23.9762853,42.8608513 L20.1545186,39.1069479 C19.9575152,38.9134427 19.9546793,38.5968729 20.1481845,38.3998695 C20.1502893,38.3977268 20.1524132,38.395603 20.1545562,38.3934985 L36.9937789,21.8567812 C37.1908028,21.6632968 37.193672,21.3467273 37.0001876,21.1497035 C36.9980647,21.1475418 36.9959223,21.1453995 36.9937605,21.1432767 L20.1545208,4.60825197 C19.9574869,4.41477773 19.9546013,4.09820839 20.1480756,3.90117456 C20.1501626,3.89904911 20.1522686,3.89694235 20.1543933,3.89485454 Z"
                                class="two"></path>
                            <path fill="#fff"
                                d="M0.154393339,3.89485454 L3.97631488,0.139296592 C4.17083111,-0.0518420739 4.48263286,-0.0518571125 4.67716753,0.139262789 L25.6916134,20.7848311 C26.0855801,21.1718824 26.0911863,21.8050225 25.704135,22.1989893 C25.7000188,22.2031791 25.6958657,22.2073326 25.6916762,22.2114492 L4.67709797,42.8607841 C4.48259567,43.0519059 4.17082418,43.0519358 3.97628526,42.8608513 L0.154518591,39.1069479 C-0.0424848215,38.9134427 -0.0453206733,38.5968729 0.148184538,38.3998695 C0.150289256,38.3977268 0.152413239,38.395603 0.154556228,38.3934985 L16.9937789,21.8567812 C17.1908028,21.6632968 17.193672,21.3467273 17.0001876,21.1497035 C16.9980647,21.1475418 16.9959223,21.1453995 16.9937605,21.1432767 L0.15452076,4.60825197 C-0.0425130651,4.41477773 -0.0453986756,4.09820839 0.148075568,3.90117456 C0.150162624,3.89904911 0.152268631,3.89694235 0.154393339,3.89485454 Z"
                                class="three"></path>
                        </g>
                    </svg>
                </span>
            </a>
            <div class="nav-opciones-contenedor">
                <a href="{{ url('/') }}" class="nav-opcion">Inicio</a>
                <a href="#" class="nav-opcion nav-opcion-supermenu">Productos</a>
                <a href="{{ url('/blog') }}" class="nav-opcion">Blog</a>
                <a href="{{ url('/tienda') }}" class="nav-opcion">Tienda</a>
                <a href="#contacto" class="nav-opcion">Contacto</a>
            </div>

            {{-- boton de catalogo --}}
            <button class="nav-minicart-btn" id="miniCarrito"
                onclick="window.open('{{ url('https://andamiosligeros.com/catalogo-virtual-andamios-ligeros') }}', '_blank')">
                <img src="{{ url('web/img/catalog.png') }}" width="30" alt="catalogo">
            </button>

            <button class="nav-minicart-btn" id="miniCarrito">
                <img src="{{ url('web/img/carrito.png') }}" width="30" alt="shopping cart">
                <span class="cont-carrito {{ empty(session()->get('cart')) ? 'd-none' : '' }}">
                    <span class="font-cart">
                        {{ is_countable(session()->get('cart')) ? count(session()->get('cart')) : 0 }}
                    </span>
                </span>
            </button>

        </div>

        {{-- OPCIONES DE LA NAVBAR (SUPERMENÚ) --}}
        <div class="nav-opciones-supermenu">
            <button class="supermenu-regresar mobile">
                <span><i class="fa-solid fa-arrow-left"></i>Regresar</span>
            </button>
            <img class="mobile-menu-logo" src="{{ url('web/img/logo-andamios-merida.webp') }}" alt="">
            <h2 class="supermenu-titulo">PRODUCTOS</h2>
            <div class="supermenu-categorias-contenedor">
                <section class="supermenu-categoria">
                    <a href="{{ route('web_tradicionales') }}" style="padding: 0"><h3>Tradicionales</h3></a>
                    <a href="{{ route('web_stp1') }}">Andamio STP-1</a>
                    <a href="{{ route('web_stp2') }}">Andamio STP-2</a>
                    <a href="{{ route('web_stp4') }}">Andamio STP-4 <i class="fa fa-certificate"
                            aria-hidden="true"></i></a>
                    <a href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-stp-5') }}">Andamio STP-5 </a>
                     <a href="{{ route('web_banqueteros') }}"><h3>Banqueteros</h3></a>
                    <a href="{{ url('/andamios-ligeros-galvanizados-baqueteros-5-peldanos-SBT1') }}">Andamio
                        SBT-1</a>
                    <a href="{{ url('/andamios-ligeros-galvanizados-baqueteros-4-peldanos-SBT2') }}">Andamio
                        SBT-2</a>
                    <a href="{{ url('/andamios-ligeros-galvanizados-baqueteros-SBT4') }}">
                        Andamio SBT-4 <i class="fa fa-certificate" aria-hidden="true"></i></a>
                    <a href="{{ url('/andamios-plegables-multiusos-galvanizados') }}">Andamio SBT-6 <i
                            class="fa fa-certificate" aria-hidden="true"></i></a>
                </section>
                <section class="supermenu-categoria">
                    <a href="{{ route('web_vallas') }}" style="padding: 0"><h3>Vallas</h3></a>
                    <a href="{{ url('tienda/valla-galvanizada-deportiva-vrs-2-carrera') }}">Valla Metálica VRS-2</a>
                    <a href="{{ url('tienda/valla-metalica-galvanizada-vrt-5-de-2.00m-de-largo-con-senalamiento') }}">Valla Metálica VRT-5</a>
                    <a href="{{ url('tienda/valla-metalica-galvanizada-vrt-6-de-2.00m-de-largo-con-senalamiento') }}">Valla Metálica VRT-6 <i class="fa fa-certificate" aria-hidden="true"></i></a>
                    <a href="{{ url('tienda/valla-metalica-de-seguridad-ligera-portatil-con-barrera-de-seguridad-de-1.50-metros') }}">Valla Metálica 1.50m</a>
                    <a href="{{ url('tienda/valla-metalica-de-seguridad-ligera-portatil-con-barrera-de-seguridad-de-2-metros') }}">Valla Metálica de 2m</a>
                </section>
                <section class="supermenu-categoria">
                    <a href="{{ route('web_escenarios') }}" style="padding: 0"><h3>Escenarios</h3></a>
                    <a href="{{ url('/tienda/tarima-para-escenario') }}">Tarima Para Escenario <i class="fa fa-certificate" aria-hidden="true"></i></a>
                    <a href="{{ url('tienda/andamio-para-tarima-tipo-c-de-60cm') }}">Andamio para tarima TIPO-C</a>
                    <a href="{{ url('tienda/andamio-tijera-tipo-c-para-escenario-de-1m-de-alto') }}">Andamio Tijera TIPO-C</a>
                    <a href="{{ url('tienda/corona-de-union-para-tarimas') }}">Corona de Unión</a>
                
                </section>

                <section class="supermenu-categoria supermenu-categoria-chingones">
                    <h3>
                        <a class="categoria-ac" href="https://andamioschingones.com/" target="_blank">
                            <img src="{{ url('/web/img/logo-chingones.png') }}" alt="andamios chingones">
                        </a>
                    </h3>
                    <a href="{{ url('/tienda/barandal-plegable-para-andamios-spl-5') }}">Modelo
                        SPL-5</a>
                    <a href="{{ url('/tienda/andamio-plegable-galvanizado-multiusos-stp-5') }}">Modelo
                        STP-5 </a>
                    <a href="{{ url('/tienda/andamio-tradicional-plegable-galvanizado-multiusos-stp-6') }}">Modelo
                        STP-6 </a>
                    <a href="{{ url('/andamios-plegables-multiusos-galvanizados') }}">Modelo
                        SBT-6 <i class="fa fa-certificate" aria-hidden="true"></i></a>
                    <a href="{{ url('/tienda/andamio-ligero-plegable-multiusos-sbt-7-sin-plataform') }}">Modelo
                        SBT-7 </i></a>
                    <a href="{{ url('/andamios-ligeros-plegables-multiusos-galvanizados-sbt-8') }}">Modelo SBT-8</a>
                    <a href="{{ url('/tienda/andamio-ligero-plegable-multiusos-sbt-9---plataforma') }}">Modelo
                        SBT-9 </i></a>
                    <a href="{{ url('/tienda/andamio-plegable-sbt-10---plataforma') }}">Modelo
                        SBT-10 </i></a>
                </section>
                <section class="supermenu-categoria">
                    <h3>Otros modelos</h3>
                    <a href="{{ route('web_pasilleros') }}">Pasillero</a>
                    <a href="{{ route('web_pasarela') }}">Pasarela</a>
                    <a href="{{ route('web_dobles') }}">Dobles</a>
                    <a href="{{ route('web_sbt5') }}">Altos</a>
                    <a href="{{ route('web_longitudinal') }}">Longitudinal</a>
                </section>
                <section class="supermenu-categoria">
                    <a href="{{ route('web_accesorios') }}" style="padding: 0"><h3>Accesorios</h3></a>
                    @php
                        $objAccesorios = ProductosTienda::where('categoria', 'accesorio')
                            ->where('post_estatus', 1)
                            ->get();
                    @endphp
                    @if (!$objAccesorios->isEmpty())
                        @foreach ($objAccesorios as $item_product)
                            <a
                                href="{{ url('/') }}/tienda/{{ $item_product->post_url }}">{{ $item_product->post_titulo }}</a>
                        @endforeach
                    @endif
                </section>

            </div>
        </div>

        <div class="nav-overlay-mobile"></div>
    </nav>

    {{-- CONTENEDOR PARA EL MINICART --}}
    <div id="contenedor-minicart" class="contenedor-mini-cart">
        <div id="modal-mini-cart" class="mini-cart cerrado">
        </div>
    </div>
</header>
