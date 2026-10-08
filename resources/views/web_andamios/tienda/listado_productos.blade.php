<div id="loaded_products_count" data-count="{{ $productosTienda->count() }}" style="display:none;"></div>

@if (!$productosTienda->isEmpty())
    @foreach ($productosTienda as $item_product)
        <div class="col-lg-4 col-md-6 col-12 mb-4 d-flex align-items-stretch">
            <div class="product-modern-card {{ $item_product->post_estatus == 3 ? 'is-expired' : '' }}">
                
                {{-- BADGES FLOTANTES --}}
                <div class="product-card-badges">
                    @if ($item_product->estrella == 1)
                        <span class="p-badge badge-bestseller">
                            <i class="fa fa-star"></i> MÁS VENDIDO
                        </span>
                    @endif

                    @if (!empty($item_product->precio2) && $item_product->precio2 != 0.0)
                        @php
                            $p_desc = (($item_product->precio - $item_product->precio2) * 100) / $item_product->precio;
                            $p_desc = round($p_desc, 0, PHP_ROUND_HALF_UP);
                        @endphp
                        <span class="p-badge badge-discount">
                            -{{ number_format($p_desc) }}% OFF
                        </span>
                    @endif

                    @if ($item_product->post_estatus == 3)
                        <span class="p-badge badge-expired">
                            <i class="fa fa-clock-o"></i> OFERTA VENCIDA
                        </span>
                    @endif
                </div>

                {{-- IMAGEN CON ENLACE DIRECTO AL DETALLE --}}
                <a href="{{ url('/') }}/tienda/{{ $item_product->post_url }}" class="product-card-image-wrap" title="{{ $item_product->post_titulo }}">
                    <img src="{{ $item_product->imagen_portada }}" alt="{{ $item_product->imagen_alt ?: $item_product->post_titulo }}" loading="lazy" class="product-card-img">
                </a>

                {{-- INFORMACIÓN Y DETALLES DEL PRODUCTO --}}
                <div class="product-card-body">
                    <div class="product-card-meta">
                        <span class="meta-cat">{{ strtoupper($item_product->categoria ?: 'ANDAMIO') }}</span>
                        @if (!empty($item_product->modelo))
                            <span class="meta-mod"><i class="fa fa-tag"></i> Mod. {{ $item_product->modelo }} {{ $item_product->modelo_ref }}</span>
                        @endif
                    </div>

                    <h2 class="product-card-heading">
                        <a href="{{ url('/') }}/tienda/{{ $item_product->post_url }}" title="{{ $item_product->post_titulo }}">
                            {{ $item_product->post_titulo }}
                        </a>
                    </h2>

                    {{-- PRECIOS --}}
                    <div class="product-card-pricing">
                        @if (!empty($item_product->precio2) && $item_product->precio2 != 0.0)
                            <div class="price-current">
                                <span class="price-currency">$</span>{{ number_format($item_product->precio2, 2, '.', ',') }}
                                <span class="price-tax-note">MXN</span>
                            </div>
                            <div class="price-original">
                                ${{ number_format($item_product->precio, 2, '.', ',') }}
                            </div>
                        @else
                            <div class="price-current">
                                <span class="price-currency">$</span>{{ number_format($item_product->precio, 2, '.', ',') }}
                                <span class="price-tax-note">MXN</span>
                            </div>
                        @endif
                    </div>

                    {{-- BENEFICIO RÁPIDO --}}
                    <div class="product-card-trust-feature">
                        <i class="fa fa-check-circle"></i> 100% Acero galvanizado ligero
                    </div>

                    {{-- FORMULARIO DE COMPRA Y CANTIDAD (SEPARADO DEL ENLACE DE NAVEGACIÓN) --}}
                    <form method="get" class="product-card-form" action="{{ route('post_carrito') }}" onsubmit="event.preventDefault(); addToCart(this);">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="id_producto" value="{{ $item_product->id_product }}">
                        <input type="hidden" name="imagen" value="{{ $item_product->imagen_portada }}">
                        <input type="hidden" name="envio" value="{{ $item_product->envio }}">
                        <input type="hidden" name="post_titulo" value="{{ $item_product->post_titulo }}">
                        @if (!empty($item_product->precio2) && $item_product->precio2 != 0.0)
                            <input type="hidden" name="precio_prodcuto" value="{{ $item_product->precio2 }}">
                        @else
                            <input type="hidden" name="precio_prodcuto" value="{{ $item_product->precio }}">
                        @endif

                        <div class="product-card-actions">
                            <div class="product-stepper">
                                <button type="button" class="btn-stepper-decrement" aria-label="Disminuir cantidad">-</button>
                                <input type="number" class="stepper-count-input" name="cantidad" value="1" min="1" max="99" readonly>
                                <button type="button" class="btn-stepper-increment" aria-label="Aumentar cantidad">+</button>
                            </div>

                            <button type="submit" class="btn-card-add-to-cart">
                                <i class="fa fa-shopping-cart"></i>
                                <span>Comprar</span>
                            </button>
                        </div>
                    </form>

                    {{-- ENLACE SECUNDARIO A FICHA TÉCNICA --}}
                    <div class="product-card-specs-link">
                        <a href="{{ url('/') }}/tienda/{{ $item_product->post_url }}">
                            Ver ficha técnica y detalles <i class="fa fa-angle-right"></i>
                        </a>
                    </div>
                </div>

            </div>
        </div>
    @endforeach
@else
    <div class="col-12 text-center py-5">
        <div class="tienda-empty-state-box">
            <div class="empty-state-icon">
                <i class="fa fa-search"></i>
            </div>
            <h3 class="empty-state-title">No se encontraron productos</h3>
            <p class="empty-state-subtitle">No hay productos que coincidan con los criterios de búsqueda o filtros seleccionados.</p>
            <button type="button" class="btn-empty-state-reset" onclick="resetAllFilters()">
                <i class="fa fa-refresh"></i> Restablecer filtros y ver todos
            </button>
        </div>
    </div>
@endif