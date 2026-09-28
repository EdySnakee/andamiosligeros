    <a class="cerrar-carrito" href="#" id="cerrar"><i class="fa fa-close"></i></a>
    <div class="mini-cart-container">
        <div class="mini-cart-titulo">
            <h2>CARRITO</h2>
        </div>
        @if (!empty($miniCart))
            <div class="mini-cart-productos">
                @foreach ($miniCart as $items_cart)
                    <div class="mini-cart-producto">
                        <div class="producto-imagen-container">
                            <img src="{{ $items_cart['imagen'] }}">
                        </div>
                        <div class="producto-info-container">
                            <p class="producto-info-titulo">
                                <b> {{ $items_cart['titulo'] }}</b><br>
                                Cantidad: {{ $items_cart['cantidad'] }}
                            </p>
                        </div>
                        <div class="producto-costo-container">
                            <form action="{{ url('/remove') }}" method="get"
                                onsubmit="event.preventDefault(); removeFromCart(this);">
                                <input type="hidden" value="{{ $items_cart['id_producto'] }}" id="id_producto"
                                    name="id_producto">
                                <button class="producto-borrar" type="submit">
                                    <i class="fa fa-trash fa-2x" aria-hidden="true"></i>
                                </button>
                            </form>
                            <b>{{ number_format($items_cart['precio'], 2, '.', ',') }}</b>
                        </div>
                    </div>
                @endforeach
            </div>
            <div class="mini-cart-finalizar">
                <p class="mini-cart-subtotal">SUBTOTAL:
                    @php
                        $total = 0;
                        if (!empty($miniCart)) {
                            foreach ($miniCart as $item) {
                                $total += $item['precio'] * $item['cantidad'];
                            }
                        }
                    @endphp
                    <span>${{ number_format($total, 2, '.', ',') }}</span>
                </p>
                <a href="{{ route('ver_carrito') }}">
                    <button class="boton-amarillo">FINALIZAR COMPRA</button>
                </a>
            </div>
        @endif
        @if (empty($miniCart))
            <div class="mini-cart-vacio">
                <h2>Tu carrito está vacío</h2>
                <img src="{{ url('web/img/carrito_triste.jpeg') }}">
                <a href="{{ url('tienda') }}">
                    <button class="boton-amarillo">AGREGAR PRODUCTOS</button>
                </a>
            </div>
        @endif
    </div>
    <div class="minicart-overlay" id="cerrar"></div>
