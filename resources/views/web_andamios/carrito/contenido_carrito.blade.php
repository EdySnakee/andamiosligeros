@if (session('landing_venta'))
    @php
        $landing_venta = session('landing_venta');
    @endphp
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#navbar').remove();
            document.querySelector('footer').remove();
            document.querySelector('.remove-from-cart').remove();
            document.querySelector('.clear-cart').remove();
            document.querySelector('.continuar-compra').remove();
        });
        localStorage.setItem('landing', true);
    </script>
@endif
@if (!empty($cart))
    @foreach ($cart as $items_cart)
        @if ($items_cart['id_producto'] == 1)
            <script>
                ttq.track('InitiateCheckout', {
                    "contents": [{
                        "content_id": "{{ $items_cart['id_producto'] }}", // string. ID of the product. Example: "1077218".
                        "content_type": "product", // string. Either product or product_group.
                        "content_name": "{{ $items_cart['titulo'] }}" // string. The name of the page or product. Example: "shirt".
                    }],
                    "quantity": {{$items_cart['cantidad']}},
                    "value": 0, // number. Value of the order or items sold. Example: 100.
                    "currency": "MXN" // string. The 4217 currency code. Example: "USD".
                });
            </script>
        @endif
    @endforeach
@endif
<div class="cont-princ-product carrito-padre">
    <div class="cart-container">
        <div class="cart-left-side cart">
            <h3 class="cart-contador">{{ $message }}</h3>
            @if (!empty($cart))
                @foreach ($cart as $items_cart)
                    <div class="cart-producto">
                        <div class="cart-producto-container">
                            <div class="cart-producto-img-container">
                                <img src="{{ $items_cart['imagen'] }}" class="cart-producto-img" width="200"
                                    height="200">
                            </div>
                            <div class="cart-producto-info">
                                <h3 class="cart-producto-titulo">{{ $items_cart['titulo'] }}</h3>
                                <small class="cart-producto-tooltip">{{ $items_cart['titulo'] }}</small>
                                <div class="cart-cantidad">
                                    <p>Cantidad: {{ $items_cart['cantidad'] }}</p>
                                    {{-- <div class="cantidad-container">
                                        <button class="cantidad-disminuir cantidad-control"
                                            data-id="{{ $items_cart['id_producto'] }}">-</button>
                                        <span class="cantidad-valor">{{ $items_cart['cantidad'] }}</span>
                                        <button class="cantidad-aumentar cantidad-control"
                                            data-id="{{ $items_cart['id_producto'] }}">+</button>
                                    </div> --}}
                                </div>
                                <p>Costo: </b>${{ number_format($items_cart['precio'], 2, '.', ',') }}</p>
                            </div>
                            <div class="cart-producto-remove remove-from-cart">
                                <form action="{{ url('/remove') }}" method="get">
                                    <input type="hidden" value="{{ $items_cart['id_producto'] }}" id="id_producto"
                                        name="id_producto">
                                    <button><i class="fa fa-trash fa-2x" aria-hidden="true"></i></button>
                                </form>
                            </div>
                        </div>
                    </div>
                @endforeach

                <form action="{{ url('/clear') }}" method="POST" class="clear-cart">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <button class="cart-vaciar-btn">Vaciar carrito</button>
                </form>
            @endif
        </div>
        <div class="cart-right-side">
            <h4 class="cart-datos-titulo">Confirma tus datos:</h4>
            <form action="{{ url('/checkout') }}" method="post">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control-cart" type="text" id="nombre_c" name="nombre_c" required
                    placeholder="Nombre Completo *">
                <input class="form-control-cart" type="text" id="email" name="email" required
                    placeholder="Email *">
                <input class="form-control-cart" type="number" id="telefono" name="telefono" required
                    placeholder="Telefono *">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control-cart" type="text" id="estado" name="estado" required
                            placeholder="Estado *">
                    </div>
                    <div class="col-md-6">
                        <input class="form-control-cart" type="text" id="municipio" name="municipio" required
                            placeholder="Municipio *">
                    </div>
                </div>
                <input class="form-control-cart" type="text" id="direccion" name="direccion" required
                    placeholder="Dirección *">
                <input class="form-control-cart" type="text" id="cp" name="cp" required
                    placeholder="Código Postal *">
                <textarea class="form-control-cart" name="comentarios_adicionales" rows="5"
                    placeholder="Notas sobre su pedido, p. notas especiales para la entrega"></textarea>
                <label class="" for="iva">
                    Necesito factura
                    <input type="checkbox" class="mr-2" name="iva" id="activa_iva">
                </label>
                <div id="detalle_factura"></div>
                <div class="l-small">
                    <small>* El envío aplica para algunos de nuestros productos</small><br>
                    <small>* El costo de envío es de $100.00 MXN por producto</small>
                </div>
                <br>
                <label for="cupon">
                    Tengo un cupón
                    <input type="checkbox" class="mr-2" name="cupon" id="activa_cupon">
                </label>
                <div class="input-group mt-1 d-none" id="cupon">
                    <input class="border" type="text" id="campo_cupon" name="campo_cupon"
                        placeholder="Ingresa tu cupón">
                    <div class="input-group-append">
                        <button class="btn btn-warning btn-aplicar disabled"
                            style="border-radius: 0px 7px 7px 0px;"disabled><b>APLICAR</b></button>
                    </div>
                    <div class="invalid-feedback">
                        Cupón no válido.
                    </div>
                </div>
                <br>
                <ul class="cart-resumen">
                    @php
                        $total = 0;
                        $envio = 0;
                        $gran_total = 0;
                        if (!empty($cart)) {
                            foreach ($cart as $item) {
                                $total += $item['precio'] * $item['cantidad'];
                                $envio += $item['envio'] * $item['cantidad'];
                                $gran_total = $total + $envio;
                            }
                        }
                    @endphp
                    <li class="list-group-item"><b>Subtotal: </b><span
                            id="subthtml">${{ number_format($total, 2, '.', ',') }}</span></li>
                    <li class="list-group-item d-none cupon"><b>Descuento: - </b><span id="cuponhtml"></span>
                    </li>

                    <li class="list-group-item d-none iva"><b>IVA: </b><span id="ivahtml"></span></li>
                    <li class="list-group-item"><b>Envío: </b><span
                            id="enviohtml">${{ number_format($envio, 2, '.', ',') }}</span></li>
                    <li class="list-group-item"><b>Total: </b><span
                            id="totalhtml">${{ number_format($gran_total, 2, '.', ',') }}</span></li>
                    <input type="hidden" value="{{ $total }}" id="subtotal" name="subtotal">
                    <input type="hidden" value="{{ $envio }}" id="envio" name="envio">
                    <input type="hidden" value="{{ $gran_total }}" id="total_compra" name="total_compra">
                </ul>
                <div class="cart-buttons">
                    <button class="cart-confirmar">CONFIRMAR PEDIDO</button>
                    <a href="{{ url('/tienda-de-andamios-ligeros-galvanizados') }}"
                        class="continuar-compra">CONTINUAR COMPRANDO</a>
                </div>
            </form>
        </div>
    </div>
</div>
