<div class="container-md cont-princ-product shadow">
    {{-- SCRIPT PARA TIKTOK --}}
    @if ($info_producto->id_product == 1)
        <script>
            ttq.track('ViewContent', {
                "contents": [{
                    "content_id": "{{ $info_producto->id_product }}", // string. ID of the product. Example: "1077218".
                    "content_type": "product", // string. Either product or product_group.
                    "content_name": "{{ $info_producto->post_titulo }}" // string. The name of the page or product. Example: "shirt".
                }],
                "value": 0, // number. Value of the order or items sold. Example: 100.
                "currency": "MXN" // string. The 4217 currency code. Example: "USD".
            });
        </script>
    @endif
    {{-- TERMINA SCRIPT PARA TIKTOK --}}
    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
        <script>
            ! function(f, b, e, v, n, t, s) {
                if (f.fbq) return;
                n = f.fbq = function() {
                    n.callMethod ?
                        n.callMethod.apply(n, arguments) : n.queue.push(arguments)
                };
                if (!f._fbq) f._fbq = n;
                n.push = n;
                n.loaded = !0;
                n.version = '2.0';
                n.queue = [];
                t = b.createElement(e);
                t.async = !0;
                t.src = v;
                s = b.getElementsByTagName(e)[0];
                s.parentNode.insertBefore(t, s)
            }(window, document, 'script',
                'https://connect.facebook.net/en_US/fbevents.js');
            fbq('init', '5243995428995951');
            fbq('track', 'AddToCart', {
                content_name: "{{ $info_producto->post_titulo }}",
                currency: 'MXN',
                value: '{{ $value }}'
            });
        </script>

        @if ($info_producto->id_product == 1)
            <script>
                ttq.track('AddToCart', {
                    "contents": [{
                        "content_id": "{{ $info_producto->id_product }}", // string. ID of the product. Example: "1077218".
                        "content_type": "product", // string. Either product or product_group.
                        "content_name": "{{ $info_producto->post_titulo }}" // string. The name of the page or product. Example: "shirt".
                    }],
                    "value": 0, // number. Value of the order or items sold. Example: 100.
                    "currency": "MXN" // string. The 4217 currency code. Example: "USD".
                });
            </script>
        @endif
    @endif

    <div class="row">
        {{-- titulo --}}
        <div class="col-md-12">
            <h1 class="mb-0 font-weight-bold text-7">{{ $info_producto->post_titulo }}</h1>
        </div>

        {{-- galeria --}}
        <div class="col-md-6 mb-md-0">
            <div class="thumb-gallery-wrapper">

                <div class="thumb-gallery-detail owl-carousel owl-theme manual nav-inside nav-style-1 nav-dark mb-3">
                    <div>
                        <img alt="" class="img-fluid img-gal-product" src="{{ $info_producto->imagen_portada }}"
                            data-zoom-image="{{ $info_producto->imagen_portada }}">
                    </div>
                    @if (!$galeria_productos->isEmpty())
                        @foreach ($galeria_productos as $item_gal)
                            <div>
                                <img alt="{{ $item_gal->file_alt }}" class="img-fluid img-gal-product"
                                    src="{{ $item_gal->file_url }}" data-zoom-image="{{ $item_gal->file_url }}">
                            </div>
                        @endforeach
                    @endif
                </div>
                <div class="thumb-gallery-thumbs owl-carousel owl-theme manual thumb-gallery-thumbs">
                    <div class="cur-pointer">
                        <img alt="" class="img-fluid shadow-sm bg-white rounded"
                            src="{{ $info_producto->imagen_portada }}">
                    </div>
                    @if (!$galeria_productos->isEmpty())
                        @foreach ($galeria_productos as $item_gal)
                            <div class="cur-pointer">
                                <img alt="{{ $item_gal->file_alt }}" class="img-fluid shadow-sm bg-white rounded"
                                    src="{{ $item_gal->file_url }}">
                            </div>
                        @endforeach
                    @endif
                </div>
                @if ($info_producto->id_product == 44)
                    <div>
                        <video autoplay loop controls class="w-100 pt-3">
                            <source src="{{ url('/web/videos-productos/Andamio_Para_Tarima.mp4') }}" type="video/mp4">
                        </video>
                    </div>
                @endif
            </div>
        </div>

        @if ($info_producto->id_product == 42)
            <!-- Video 1 -->
            <div class="col-md-6">
                <script>
                    console.log('si ->'
                        '$info_producto')
                </script>
                <div class="entry-summary position-relative">
                    <div class="video-card">
                        <div class="video-vertical">
                            <video class="video-vertical__media" controls preload="metadata"
                                poster="{{ url('/web/videos-productos/portadas/portada001.png') }}">
                                <source src="{{ url('/web/videos-productos/Video-Tarimas-Andamio-Ligeros.mp4') }}"
                                    type="video/mp4">
                                Tu navegador no soporta el video.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        @endif
        <!-- Video 2 -->
        @if ($info_producto->id_product == 70)
            <div class="col-md-6">
                <div class="entry-summary position-relative">
                    <div class="video-card">
                        <div class="video-vertical">
                            <video class="video-vertical__media" controls preload="metadata"
                                poster="{{ url('/web/videos-productos/portadas/portada-video-de-promo-3-andamios-2-plataformas-1-juego-de-ruedas-standard-a-9999.png') }}">
                                <source
                                    src="{{ url('/web/videos-productos/Video-pROMO-3-ANDAMIOS-SBT-6-JUEGO-DE-RUEDAS-PLATAFROMAS.mp4') }}"
                                    type="video/mp4">
                                Tu navegador no soporta el video.
                            </video>
                        </div>
                    </div>
                </div>
            </div>
        @endif


        {{-- realidad virtual --}}
        @if (!empty($info_producto->ar_enlace))
            <a class="boton-amarillo ar-button" href="{{ $info_producto->ar_enlace }}" target="_blank">
                VER EN REALIDAD AUMENTADA
            </a>
        @endif

        {{-- Informacion --}}
        <div class="{{ isset($info_producto) && in_array($info_producto->id_product, [42, 70]) ? 'col-md-12' : 'col-md-6' }}">

            <div class="entry-summary position-relative">

                <div class="divider divider-small">
                    <hr class="bg-color-grey-scale-4">
                </div>
                <p class="price mb-3">
                    @if (!empty($info_producto->precio2) and $info_producto->precio2 != 0.0)
                        <span
                            class="sale text-color-dark">{{ "$ " . number_format($info_producto->precio2, 2, '.', ',') }}</span>
                        <span class="amount">{{ "$ " . number_format($info_producto->precio, 2, '.', ',') }}</span>
                    @else
                        <span
                            class="sale text-color-dark">{{ "$ " . number_format($info_producto->precio, 2, '.', ',') }}</span>
                    @endif

                </p>
                <p class="text-3-5 mb-3">{{ $info_producto->descripcion_corta }}</p>
                <ul class="list list-unstyled text-2">
                    <li class="mb-0">DISPONIBILIDAD:
                        <strong class="text-color-dark">
                            @if ($info_producto->post_estatus == 3)
                                VENCIDO
                            @else
                                DISPONIBLE
                            @endif

                        </strong>
                    </li>
                    <li class="mb-0">TAGS: <strong class="text-color-dark"
                            style="word-wrap:break-word;">{{ $info_producto->meta_keywords }}</strong></li>
                </ul>
                <br>
                @if (
                    !empty($info_producto->modelo) or
                        $info_producto->alto != '0.00' or
                        $info_producto->ancho != '0.00' or
                        $info_producto->profundidad != '0.00')
                    <h3>Características principales</h3>
                @endif
                <table class="table table-striped">
                    <tbody>
                        @if (!empty($info_producto->modelo))
                            <tr>
                                <th scope="row">Modelo del {{ $info_producto->categoria }}</th>
                                <td>{{ $info_producto->modelo }} {{ $info_producto->modelo_ref }}</td>
                            </tr>
                        @endif
                        @if (!empty($info_producto->alto) and $info_producto->alto != '0.00')
                            <tr>
                                <th scope="row">Alto del {{ $info_producto->categoria }}</th>
                                <td>{{ $info_producto->alto }} m</td>
                            </tr>
                        @endif
                        @if (!empty($info_producto->ancho) and $info_producto->ancho != '0.00')
                            <tr>
                                <th scope="row">Ancho del {{ $info_producto->categoria }}</th>
                                <td>{{ $info_producto->ancho }} m</td>
                            </tr>
                        @endif
                        @if (!empty($info_producto->profundidad) and $info_producto->profundidad != '0.00')
                            <tr>
                                <th scope="row">Profundidad del {{ $info_producto->categoria }}</th>
                                <td>{{ $info_producto->profundidad }} m</td>
                            </tr>
                        @endif
                    </tbody>
                </table>
                <br>
                @if (!empty($info_producto->multiuso) or $info_producto->diametro != '0.00' or $info_producto->peso_soportado != '0.00')
                    <h5>Otras características</h5>
                @endif
                <div class="row">
                    <div class="col-md-6">
                        @if (!empty($info_producto->diametro) and $info_producto->diametro != '0.00')
                            <p><small><b>Diámetro del caño:</b> {{ $info_producto->diametro }} mm</small></p>
                        @endif
                        @if (!empty($info_producto->multiuso))
                            <p><small><b>Multiuso:</b> {{ $info_producto->multiuso }}</small></p>
                        @endif
                    </div>
                    <div class="col-md-6">
                        @if (!empty($info_producto->peso_soportado) and $info_producto->peso_soportado != '0.00')
                            <p><small><b>Peso máximo soportado:</b> {{ $info_producto->peso_soportado }} kg</small></p>
                        @endif
                    </div>
                </div>
                <br>
                <hr>

                @if ($info_producto->post_estatus == 3)
                    <p>¡Disculpe las molestias!</p>
                    <p>Este producto/promoción ya no se encuentra disponible, pero puede contactarse con un asesor para
                        brindarle una opción para ti</p>
                    <a href="https://api.whatsapp.com/send?phone=+525519484708&amp;text=Hola,%20me%20interesa%20saber%20promociones%20vigentes%20de%20Andamios%20Ligeros"
                        class="btn btn-info btn-modern text-uppercase bg-color-hover-primary border-color-hover-primary"><i
                            class="fa fa-whatsapp" aria-hidden="true"></i> CONTACTAR CON ASESOR</a>
                @else
                    <form enctype="multipart/form-data" method="get" class="cart"
                        action="{{ route('post_carrito') }}">
                        <div class="quantity quantity-lg">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
                            <input type="button"
                                class="minus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                value="-">
                            <input type="text" class="input-text qty text" title="Qty" value="1"
                                id="cantidad" name="cantidad" min="1" step="1">
                            <input type="button"
                                class="plus text-color-hover-light bg-color-hover-primary border-color-hover-primary"
                                value="+">
                            <input type="hidden" name="id_producto" value="{{ $info_producto->id_product }}">
                            <input type="hidden" name="imagen" value="{{ $info_producto->imagen_portada }}">
                            <input type="hidden" name="envio" value="{{ $info_producto->envio }}">
                            <input type="hidden" name="post_titulo" value="{{ $info_producto->post_titulo }}">
                            @if ($info_producto->precio2 and $info_producto->precio2 != 0.0)
                                <input type="hidden" name="precio_prodcuto" value="{{ $info_producto->precio2 }}">
                            @else
                                <input type="hidden" name="precio_prodcuto" value="{{ $info_producto->precio }}">
                            @endif
                        </div>
                        <button type="submit" class="boton-amarillo producto-atc">Agregar al carrito</button>
                    </form>
                @endif
                <hr>




            </div>
        </div>
    </div>

    {{-- descripcion --}}
    <div class="row mb-4 mt-3em">
        <div class="col">
            <div id="description" class="tabs tabs-simple tabs-simple-full-width-line tabs-product tabs-dark mb-2">
                <ul class="nav nav-tabs justify-content-start">
                    <li class="nav-item active"><a
                            class="nav-link active font-weight-bold text-3 text-uppercase py-2 px-3"
                            href="#productDescription" data-toggle="tab">Descripción</a></li>
                    <li class="nav-item"><a class="nav-link font-weight-bold text-3 text-uppercase py-2 px-3"
                            href="#productInfo" data-toggle="tab">Características</a></li>
                    <li class="nav-item"><a
                            class="nav-link nav-link-reviews font-weight-bold text-3 text-uppercase py-2 px-3"
                            href="#productReviews" data-toggle="tab">Información adicional</a></li>
                </ul>
                <div class="tab-content p-0">
                    <div class="tab-pane px-0 py-3 active" id="productDescription">
                        @php
                            echo $info_producto->descripcion_producto;
                        @endphp
                    </div>
                    <div class="tab-pane px-0 py-3" id="productInfo">
                        @php
                            echo $info_producto->caracteristicas_producto;
                        @endphp
                    </div>
                    <div class="tab-pane px-0 py-3" id="productReviews">
                        @php
                            echo $info_producto->extra_info_producto;
                        @endphp
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
