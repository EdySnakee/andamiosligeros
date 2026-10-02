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
            @if (session('error'))
                <div class="alert alert-danger" style="background-color: #fff1f0; border: 1.5px solid #ffa39e; color: #cf1322; padding: 12px 16px; border-radius: 8px; margin-bottom: 18px; font-size: 14px; font-weight: 500;">
                    <i class="fa fa-exclamation-circle fa-lg" aria-hidden="true" style="margin-right: 6px;"></i>
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ url('/checkout') }}" method="post" id="checkout-form">
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input class="form-control-cart" type="text" id="nombre_c" name="nombre_c" required
                    placeholder="Nombre Completo *" value="{{ old('nombre_c') }}">
                <input class="form-control-cart" type="text" id="email" name="email" required
                    placeholder="Email *" value="{{ old('email') }}">
                <input class="form-control-cart" type="number" id="telefono" name="telefono" required
                    placeholder="Telefono *" value="{{ old('telefono') }}">
                <div class="row">
                    <div class="col-md-6">
                        <input class="form-control-cart" type="text" id="estado" name="estado" required
                            placeholder="Estado *" value="{{ old('estado') }}">
                    </div>
                    <div class="col-md-6">
                        <input class="form-control-cart" type="text" id="municipio" name="municipio" required
                            placeholder="Municipio *" value="{{ old('municipio') }}">
                    </div>
                </div>
                <input class="form-control-cart" type="text" id="direccion" name="direccion" required
                    placeholder="Dirección *" value="{{ old('direccion') }}">
                <input class="form-control-cart" type="text" id="cp" name="cp" required
                    placeholder="Código Postal *" value="{{ old('cp') }}">
                <textarea class="form-control-cart" name="comentarios_adicionales" rows="5"
                    placeholder="Notas sobre su pedido, p. notas especiales para la entrega">{{ old('comentarios_adicionales') }}</textarea>

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

                <!-- Selector de Método de Pago -->
                <div class="metodos-pago-wrapper" style="margin: 20px 0 15px 0;">
                    <label style="font-weight: 700; font-size: 14px; margin-bottom: 10px; display: block; color: #333;">
                        Selecciona tu método de pago:
                    </label>

                    <!-- Opción Mercado Pago -->
                    <label class="metodo-pago-card active" id="card-mercadopago" style="display: flex; align-items: center; justify-content: space-between; border: 2px solid #009ee3; background-color: #f7fbff; border-radius: 8px; padding: 12px 14px; margin-bottom: 10px; cursor: pointer; transition: all 0.25s ease;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="radio" name="metodo_pago" value="mercadopago" checked style="cursor: pointer; transform: scale(1.15);">
                            <div>
                                <span style="display: block; font-weight: 700; font-size: 14px; color: #009ee3;">Mercado Pago</span>
                                <small style="display: block; color: #666; font-size: 11px;">Tarjetas, Dinero en cuenta, SPEI, Efectivo</small>
                            </div>
                        </div>
                        <img src="https://http2.mlstatic.com/frontend-assets/ui-navigation/5.18.9/mercadopago/logo__small@2x.png" alt="Mercado Pago" style="height: 22px; max-width: 90px; object-fit: contain;">
                    </label>

                    <!-- Opción Openpay (BBVA) -->
                    <label class="metodo-pago-card" id="card-openpay" style="display: flex; align-items: center; justify-content: space-between; border: 1.5px solid #dcdcdc; background-color: #ffffff; border-radius: 8px; padding: 12px 14px; margin-bottom: 0px; cursor: pointer; transition: all 0.25s ease;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <input type="radio" name="metodo_pago" value="openpay" style="cursor: pointer; transform: scale(1.15);">
                            <div>
                                <span style="display: block; font-weight: 700; font-size: 14px; color: #002f6c;">Tarjeta de Crédito / Débito <span style="font-size: 11px; font-weight: 600; color: #004481; background: #e8f0fe; padding: 2px 6px; border-radius: 4px; margin-left: 4px;">Openpay BBVA</span></span>
                                <small style="display: block; color: #666; font-size: 11px;">Pago directo y seguro sin salir de la tienda</small>
                            </div>
                        </div>
                        <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 25px; max-width: 105px; object-fit: contain;">
                    </label>

                    <!-- Formulario de Tarjeta Incrustado (openpay.js) -->
                    <div id="openpay-card-form" style="display: none; border: 1.5px solid #002f6c; border-top: none; background: #fdfefe; border-radius: 0 0 8px 8px; padding: 16px; margin-top: -1px; margin-bottom: 12px; box-shadow: 0 4px 12px rgba(0,47,108,0.06);">
                        <div style="margin-bottom: 12px;">
                            <label for="openpay_holder_name" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">Nombre del titular como aparece en la tarjeta *</label>
                            <input class="form-control-cart" type="text" id="openpay_holder_name" placeholder="Como aparece en la tarjeta" style="margin-bottom: 0; background: #fff;">
                        </div>

                        <div style="margin-bottom: 12px;">
                            <label for="openpay_card_number" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: flex; justify-content: space-between; align-items: center;">
                                <span>Número de tarjeta *</span>
                                <span id="openpay_card_type" style="font-size: 11px; font-weight: 700; color: #004481;"></span>
                            </label>
                            <input class="form-control-cart" type="text" id="openpay_card_number" placeholder="0000 0000 0000 0000" maxlength="19" style="margin-bottom: 0; font-family: monospace; font-size: 14px; letter-spacing: 1px; background: #fff;">
                        </div>

                        <div style="display: flex; gap: 12px; margin-bottom: 12px;">
                            <div style="flex: 1; min-width: 0;">
                                <label for="openpay_expiry" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">Vigencia (MM / AA) *</label>
                                <input class="form-control-cart" type="text" id="openpay_expiry" placeholder="MM / AA" maxlength="7" style="margin-bottom: 0; text-align: center; font-family: monospace; font-size: 14px; letter-spacing: 1px; background: #fff;">
                                <input type="hidden" id="openpay_exp_month">
                                <input type="hidden" id="openpay_exp_year">
                            </div>
                            <div style="flex: 1; min-width: 0;">
                                <label for="openpay_cvv" style="font-size: 12px; font-weight: 600; color: #333; margin-bottom: 5px; display: block;">CVV *</label>
                                <input class="form-control-cart" type="password" id="openpay_cvv" placeholder="123" maxlength="4" style="margin-bottom: 0; text-align: center; font-family: monospace; font-size: 14px; letter-spacing: 1px; background: #fff;">
                            </div>
                        </div>

                        <div id="openpay-error-alert" style="display: none; background: #fff1f0; border: 1px solid #ffa39e; color: #cf1322; padding: 8px 12px; border-radius: 6px; font-size: 12px; margin-top: 10px; line-height: 1.4;">
                        </div>

                        <div style="display: flex; align-items: center; justify-content: space-between; margin-top: 12px; padding-top: 10px; border-top: 1px solid #eef2f7;">
                            <small style="color: #666; font-size: 11px;">🔒 Tus datos viajan encriptados directo a Openpay by BBVA (PCI-DSS)</small>
                            <img src="{{ url('web/img/logo-openpay.svg') }}" alt="Openpay by BBVA" style="height: 18px; max-width: 90px; object-fit: contain; opacity: 0.9;">
                        </div>
                    </div>

                    <!-- Campos ocultos de tokenización -->
                    <input type="hidden" name="token_id" id="token_id">
                    <input type="hidden" name="device_session_id" id="device_session_id">
                </div>


                <div class="cart-buttons">
                    <button class="cart-confirmar">CONFIRMAR PEDIDO</button>
                    <a href="{{ url('/tienda-de-andamios-ligeros-galvanizados') }}"
                        class="continuar-compra">CONTINUAR COMPRANDO</a>
                </div>

            </form>
        </div>
    </div>
</div>
