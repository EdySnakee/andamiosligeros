<div class="container-md cont-princ-product">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="cont-confirm-pedido">
                <div class="head-top text-center">
                    <h2>RESUMEN DE COMPRA</h2>
                </div>
                <div class="cont-client">
                    <h6>DATOS DE CLIENTE:</h6>
                    <p><b>Nombre de cliente:</b> {{$info_cliente['nombre_c']}}</p>
                    <p><b>Email:</b> {{$info_cliente['email']}}</p>
                    <p><b>Teléfono:</b> {{$info_cliente['telefono']}}</p>
                    <p><b>Dirección de envío:</b> {{$info_cliente['direccion']}} {{$info_cliente['cp']}}. {{$info_cliente['municipio']}}, {{$info_cliente['estado']}}</p>
                    @if (!empty($info_cliente['comentarios_adicionales']))
                    <p><b>Comentarios:</b> {{$info_cliente['comentarios_adicionales']}}</p>
                    @endif
                    @if (!empty($info_cliente['iva']))
                    <h6>DATOS DE EMPRESA:</h6>
                    <p><b>Razón Social:</b> {{$info_cliente['razon_social']}}</p>
                    <p><b>RFC:</b> {{$info_cliente['rfc']}}</p>
                    <p><b>Dirección Fiscal:</b> {{$info_cliente['direccion_fiscal']}}</p>
                    @endif
                </div>
                <hr>
                <div class="cont-pedido">
                    <h6>Información de pedido:</h6>
                    <div class="tabla-resumen">
                        <table class=" table text-center" style="width:100%">
                            <tbody>
                                @if(!empty($cart))
                                @foreach($cart as $items_cart)
                                <tr class="fila-sin-bordes">
                                    <td>
                                        <div class="cont-img-res">
                                            <img src="{{ $items_cart['imagen'] }}" alt="">
                                        </div>
                                    </td>
                                    <td class="text-left">
                                        <small>
                                            {{$items_cart['cantidad']}} x {{$items_cart['titulo']}}

                                        </small>
                                    </td>
                                    <td class="text-right"><small><?php echo "$" . number_format($items_cart['precio'] * $items_cart['cantidad'], 2, '.', ',') ?></small></td>
                                </tr>
                                @endforeach
                                @php
                                $total = 0;
                                $envio = 0;
                                if (!empty($cart)) {
                                foreach ($cart as $item) {
                                $total += $item['precio'] * $item['cantidad'];
                                $envio += $item['envio'] * $item['cantidad'];
                                //$gran_total = $total + $envio;
                                }
                                }
                                if (!empty($info_cliente['iva'])) {
                                $iva = $total * 0.16;
                                $gran_total = $total + $iva + $envio;
                                }else {
                                $gran_total = $total + $envio;
                                }
                                @endphp
                                @if (!empty($info_cliente['iva']))
                                <tr>
                                    <td colspan="2" class="text-right">Subtotal</td>
                                    <td>${{number_format($total, 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right">IVA</td>
                                    <td>${{number_format($iva, 2, '.', ',')}}</td>
                                </tr>
                                @endif
                                <tr>
                                    <td colspan="2" class="text-right">ENVIO</td>
                                    <td>${{number_format($envio, 2, '.', ',')}}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-right"><b>TOTAL</b></td>
                                    <td>${{number_format($gran_total, 2, '.', ',')}}</td>
                                </tr>
                                @else
                                <tr>
                                    <td colspan="5" class="text-center">
                                        <h2>Lo sentimos pero no existen artículos</h2>
                                    </td>
                                </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="cont-pie-pedido">
                    <a href="{{route('ver_carrito')}}" class="btn btn-danger">Cancelar</a>
                    <div class="info_mp"></div>
                </div>
            </div>
        </div>
    </div>
</div>