@if (!$productosTienda->isEmpty())
    @foreach ($productosTienda as $item_product)
        <div class="col-md-4" style="margin-bottom: 2em;">
            <a class="" href=" {{ url('/') }}/tienda/{{ $item_product->post_url }} ">
                @if ($item_product->post_estatus == 3)
                    <div class="eti-vencida">
                        VENCIDA 😞
                    </div>
                @endif

                <div
                    class="cont-item-product {{ $item_product->post_estatus == 3 ? 'prod-vencido' : '' }} card-product border rounded-5">
                    <div class="img-item-product">
                        @if ($item_product->estrella == 1)
                            <span class="badge badge-success">MAS VENDIDO</span>
                        @endif
                        @if (!empty($item_product->precio2) and $item_product->precio2 != 0.0)
                            @php
                                $p_desc =
                                    (($item_product->precio - $item_product->precio2) * 100) / $item_product->precio;
                                $p_desc = round($p_desc, 0, PHP_ROUND_HALF_UP);
                            @endphp
                            {{-- <span class="badge pulse badge-danger p-right">- {{ number_format($p_desc) }}%</span> --}}
                            @if ($p_desc >= 20)
                                <span class="badge pulse badge-danger p-right">- {{ number_format($p_desc) }}%</span>
                            @else
                                <span class="badge badge-danger p-right">- {{ number_format($p_desc) }}%</span>
                            @endif
                        @endif
                        <img class="img-fluid" src="{{ $item_product->imagen_portada }}"
                            alt="{{ $item_product->imagen_alt }}">
                    </div>
                    <div class="info-item-product">
                        <h2>{{ $item_product->post_titulo }}</h2>
                        <div class="modelo"><small><b>Modelo:  {{ $item_product->modelo }}</b> 
                                {{ $item_product->modelo_ref }}</small></div>
                        <p class="price mb-3">
                            @if (!empty($item_product->precio2) and $item_product->precio2 != 0.0)
                                <span
                                    class="sale text-color-dark">{{ "$ " . number_format($item_product->precio2, 2, '.', ',') }}</span>
                                <span
                                    class="amount">{{ "$ " . number_format($item_product->precio, 2, '.', ',') }}</span>
                            @else
                                <span
                                    class="sale text-color-dark">{{ "$ " . number_format($item_product->precio, 2, '.', ',') }}</span>
                            @endif
                        </p>
                        <form enctype="multipart/form-data" method="get" class="cart cart-tienda"
                            action="{{ route('post_carrito') }}" onsubmit="event.preventDefault(); addToCart(this);">
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
                                <input type="hidden" name="id_producto" value="{{ $item_product->id_product }}">
                                <input type="hidden" name="imagen" value="{{ $item_product->imagen_portada }}">
                                <input type="hidden" name="envio" value="{{ $item_product->envio }}">
                                <input type="hidden" name="post_titulo" value="{{ $item_product->post_titulo }}">
                                @if ($item_product->precio2 and $item_product->precio2 != 0.0)
                                    <input type="hidden" name="precio_prodcuto" value="{{ $item_product->precio2 }}">
                                @else
                                    <input type="hidden" name="precio_prodcuto" value="{{ $item_product->precio }}">
                                @endif
                            </div>
                            <button type="submit" class="btn-atc">
                                <i class="fa fa-shopping-cart"></i>
                                Comprar</button>
                        </form>
                    </div>
                </div>
            </a>
        </div>
    @endforeach
@else
    <div class="col-md-12 text-center">
        <div class="noresult">
            <img width="100px" src="{{ url('/script/out-of-stock.png') }}" alt="">
            <br>
            <br>
            <p>NO SE ENCONTRARON RESULTADOS</p>
        </div>
    </div>
@endif