@php
    use App\DetalleProducto;
    $info_det_producto = DetalleProducto::where('id_producto', $idsproducts_unicos[0])->first();

    if ($cotizacionesRedes->giro_empresa == 'ra') {
        $bg_color = '#d4b2d3';
        $ruta_logo = url('cotizaciones/img/logo-redes.png');
    }
    if ($cotizacionesRedes->giro_empresa == 'rp') {
        $bg_color = '#ddd';
        $ruta_logo = url('cotizaciones/img/redes-perimetrales-logotipo-cotizaion.jpeg');
    }
    if ($cotizacionesRedes->giro_empresa == 'sg') {
        $bg_color = '#7ec25c';
        $ruta_logo = url('cotizaciones/img/logo-scoregol-largo.svg');
    }
    if ($cotizacionesRedes->giro_empresa == 'al') {
        $bg_color = '#7ea7ff !important';
        $ruta_logo = url('cotizaciones/img/andamios.png');
    }
@endphp
@extends('layouts.vista_cotizador')
@section('css')
    <title>📋✅ Cotización {{ !empty($cotizacionesRedes->tipo_cotizacion) ? $cotizacionesRedes->tipo_cotizacion : '' }} -
        {{ !empty($cotizacionesRedes->cod_cotizacion) ? $cotizacionesRedes->cod_cotizacion : '' }} | ANDAMIOS LIGEROS
    </title>
    <meta property="og:image"
        content="{{ url('storage/productos') }}/{{ $info_det_producto->id_producto }}/{{ $info_det_producto->imagen }}" />
    <meta property="og:image:secure_url"
        content="{{ url('storage/productos') }}/{{ $info_det_producto->id_producto }}/{{ $info_det_producto->imagen }}" />
    <meta property="og:title"
        content="📋✅ Cotización {{ !empty($cotizacionesRedes->tipo_cotizacion) ? $cotizacionesRedes->tipo_cotizacion : '' }} - {{ !empty($cotizacionesRedes->cod_cotizacion) ? $cotizacionesRedes->cod_cotizacion : '' }} | ANDAMIOS LIGEROS" />
    <style>
        .cont-secciones-cotizaciones::after,
        .cont-secciones-cotizaciones::before {
            background: {{ $bg_color }};
        }

        p {
            margin: 0 0 2px !important;
        }

        .condiciones-cotizacion {
            font-size: 14px;
        }
    </style>
@stop

@section('content')
    <div class="row-flex">
        <div class="cont-cotizacion">
            <div class="container-infocoti">
                <div class="row">
                    <div class="col-md-12 cont-secciones-cotizaciones">
                        <div class="row">
                            <div class="col-md-6">
                                <h2><b>COTIZACIÓN
                                        {{ !empty($cotizacionesRedes->cod_cotizacion) ? $cotizacionesRedes->cod_cotizacion : '' }}</b>
                                </h2>
                                <p>{{ !empty($cotizacionesRedes->fecha_formato) ? $cotizacionesRedes->fecha_formato : '' }}
                                </p>
                                <div class="row">
                                    <div class="col-md-3">
                                        <b>EN ATENCIÓN:</b>
                                    </div>
                                    <div class="col-md-9">
                                        <p>{{ !empty($infoCliente->nombrecl) ? $infoCliente->nombrecl : '' }}</p>
                                        <p>{{ !empty($infoCliente->rfccl) ? $infoCliente->rfccl : '' }}</p>
                                        <p>{{ !empty($infoCliente->direccioncl) ? $infoCliente->direccioncl : '' }}</p>
                                        <p>{{ !empty($infoCliente->lugarcl) ? $infoCliente->lugarcl : '' }}
                                            {{ !empty($infoCliente->cpcl) ? $infoCliente->cpcl : '' }}</p>
                                        <p>{{ !empty($infoCliente->celularcl) ? $infoCliente->celularcl : '' }}</p>
                                        <p>{{ !empty($infoCliente->emailcl) ? $infoCliente->emailcl : '' }}</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6 text-center">
                                <img width="200px" src="{{ $ruta_logo }}" alt="">
                                <p class="text-img">50% mas ligero, misma resistencia.</p>
                            </div>
                        </div>

                        <div class="row tabla-precios">
                            <div class="col-md-12 tit-tabla">
                                <h4><b><span class="separado">INCLUYE</span>: </b></h4>
                            </div>
                            <div class="col-md-12" style="background: white;">
                                <table class="table-responsive table text-center">
                                    <thead class="text-center">
                                        <tr>
                                            <td scope="col">CANTIDAD</td>
                                            <td scope="col">PRODUCTO</td>
                                            <td scope="col">DESCRIPCIÓN</td>
                                            <td scope="col">
                                                @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                                                    PRECIO UNITARIO <br>
                                                    Por/cuerpo/día
                                                @else
                                                    PRECIO UNITARIO
                                                @endif

                                            </td>
                                            @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                                                <td scope="col">
                                                    SUBTOTAL
                                                </td>
                                            @endif
                                            <td scope="col">TOTAL</td>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (!$DetalleCotizaciones->isEmpty())
                                            @foreach ($DetalleCotizaciones as $result_det_coti)
                                                <tr class="fila-con-bordes">
                                                    <td>{{ $result_det_coti->cantidad }}</td>
                                                    <td>
                                                        {{ $result_det_coti->nombre_p }}
                                                        @if ($result_det_coti->tipo_cobro == 'm2')
                                                            {{ $result_det_coti->alto }} x {{ $result_det_coti->largo }}
                                                        @endif
                                                    </td>
                                                    <td><a
                                                            href="#{{ $result_det_coti->SKU }}">{{ $result_det_coti->titulo_descripcion }}</a>
                                                    </td>
                                                    <td>
                                                        @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                                                            <?php
                                                            if (!empty($result_det_coti->precio_comercial)) {
                                                                $costo_dia = $result_det_coti->precio_comercial * 0.01;
                                                                echo "$" . number_format($costo_dia, 2, '.', ',');
                                                            } else {
                                                                echo "$" . number_format($result_det_coti->precio_unit, 2, '.', ',');
                                                            }
                                                            
                                                            ?>
                                                        @else
                                                            <?php echo "$" . number_format($result_det_coti->precio_unit, 2, '.', ','); ?>
                                                        @endif

                                                    </td>
                                                    @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                                                        <td scope="col">
                                                            <?php echo "$" . number_format($result_det_coti->precio_unit, 2, '.', ','); ?>
                                                        </td>
                                                    @endif
                                                    <td><?php echo "$" . number_format($result_det_coti->total_ind, 2, '.', ','); ?></td>
                                                </tr>
                                            @endforeach
                                        @else
                                            <tr>
                                                <td colspan="5" class="text-center">
                                                    <h2>Lo sentimos pero no existen cotizaciones</h2>
                                                </td>
                                            </tr>
                                        @endif

                                        <tr class="fila-sin-bordes">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="fila-sin-bordes">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="fila-sin-bordes">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="fila-sin-bordes">
                                            <td colspan="5"></td>
                                        </tr>
                                        <tr class="fila-sin-bordes">
                                            <td colspan="3" class="text-left fila-informacion">
                                                <h5>CONDICIONES</h5>
                                                {{--
												@if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
												<p><small> El precio de la Renta se calcula con base <br> al 1% del precio del producto al día.</small></p>
												<p><small> La renta mínima es de un plazo de 7 días. <br> Los fines de semana también se consideran en el precio de renta.</small></p>
												@else
													@if ($cotizacionesRedes->id_cotizacion == 2053)
													<p><small> Pago de contado</small></p>
													@else
													<p><small> Pago en una sola exhibición</small></p>
													@endif
													<p><small> Saldo para su liberación y/o envío</small></p>
													<p><small> Tiempo de entrega a convenir</small></p>
													<p><small> Precios vigentes para el mes en curso</small></p>
													<p><small> Costo de envío a consultar*</small></p>
													<p><small>* <a href="https://andamiosligeros.com/docs/TRESGUERRAS-cobertura-nacional.pdf" target="_blank">Verifica cobertura</a></small></p>
													<p><small>* Aplican restricciones</a></small></p>
												@endif 
												--}}
                                                <div class="condiciones-cotizacion">
                                                    @if (!empty($cotizacionesRedes->configuracion))
                                                        <?php echo $cotizacionesRedes->configuracion; ?>
                                                    @else
                                                        <p> Pago en una sola exhibiciónmnnn</p>
                                                        <p> Saldo para su liberación y/o envío</p>
                                                        <p> Tiempo de entrega a convenir</p>
                                                        <p> Precios vigentes para el mes en curso</p>
                                                        <p> Costo de envío por módulo: $300.00*</p>
                                                        <p> * Verifica cobertura</p>
                                                        <p> * Aplicaoooon restricciones</p>
                                                    @endif
                                                </div>
                                            </td>
                                            <td class="contenedor-totales" colspan="2">
                                                <table class="table">
                                                    @if ($cotizacionesRedes->descuento_aplicado != 0)
                                                        <tr>
                                                            <td class="text-center con-bordes">DESCUENTO</td>
                                                            <td class="text-center con-bordes"><?php echo "-$" . number_format($cotizacionesRedes->descuento_aplicado, 2, '.', ','); ?></td>
                                                        </tr>
                                                    @endif
                                                    @if ($cotizacionesRedes->envio != 0)
                                                        <tr>
                                                            <td class="text-center con-bordes">ENVÍO</td>
                                                            <td class="text-center con-bordes"><?php echo "$" . number_format($cotizacionesRedes->envio, 2, '.', ','); ?></td>
                                                        </tr>
                                                    @endif
                                                    <tr class="fila-sin-bordes">
                                                        <td class="text-center con-bordes">SUBTOTAL</td>
                                                        <td class="text-center con-bordes"><?php echo "$" . number_format($cotizacionesRedes->subtotal, 2, '.', ','); ?></td>
                                                    </tr>
                                                    @if ($cotizacionesRedes->iva != 0)
                                                        <tr class="fila-sin-bordes">
                                                            <td class="text-center con-bordes">IMPUESTOS</td>
                                                            <td class="text-center con-bordes"><?php echo "$" . number_format($cotizacionesRedes->iva, 2, '.', ','); ?></td>
                                                        </tr>
                                                    @else
                                                    @endif
                                                    <tr class="fila-sin-bordes">
                                                        <td class="text-center con-bordes">GRAN TOTAL</td>
                                                        <td class="text-center con-bordes"><?php echo "$" . number_format($cotizacionesRedes->total, 2, '.', ','); ?></td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>


                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row footer-content">
                            <div class="col-md-6 footer-info">

                            </div>
                            <div class="col-md-6 text-center footer-info">
                                <img width="150px" src="{{ url('cotizaciones/img/logo-bbva.png') }}" alt="">
								<p>LUIS ÁNGEL CORAL LÓPEZ</p>
								<p>CUENTA: 2943604209</p>
								<p>CLABE: 012910029436042092</p>
                                {{--
                                <p>REDES ANTICAIDAS SA DE CV</p>
                                <p>CUENTA: 012 059 1289</p>
                                <p>CLABE: 012910001205912892</p>
								--}}
                            </div>
                        </div>
                    </div>
                </div>
                @if (!empty($cotizacionesRedes->tipo_cotizacion) and $cotizacionesRedes->tipo_cotizacion == 'Renta')
                    @include('app_redes.modulos.cotizador.ver_cotizacion.detalle_renta')
                @else
                    @include('app_redes.modulos.cotizador.ver_cotizacion.detalle_productos')
                @endif

            </div>
        </div>
        @if ($cotizacionesRedes->mp_status == 'si' and $cotizacionesRedes->status == 1)
            <div class="cont-pago ">
                @include('app_redes.modulos.cotizador.ver_cotizacion.barra_pago')
            </div>
        @endif

    </div>
    @if ($tipo_vista == 'Cotizaciones')
        <div class="cont-btn-descarga">
            @if ($cotizacionesRedes->status == 1)
                @if ($cotizacionesRedes->giro_empresa == 'ra')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'rp')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'sg')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @elseif($cotizacionesRedes->giro_empresa == 'al')
                    <a href="{{ url('pdf/redes-anticaidas') }}/{{ $cotizacionesRedes->ruta_encrypt }}" class="btn-pdf"><i
                            class="fa fa-file-pdf-o" aria-hidden="true"></i> Descargar PDF</a>
                @endif
            @endif


        </div>
    @endif
@stop

@if ($cotizacionesRedes->status == 5)
    <style>
        a:focus,
        a:hover {
            text-decoration: none !important;
        }

        @-webkit-keyframes zcwmini2 {
            0% {
                box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 0 rgba(0, 0, 0, 0), 0 0 0 0 rgba(207, 8, 8, 0);
            }

            10% {
                box-shadow: 0 0 8px 6px, 0 0 12px 10px rgba(0, 0, 0, 0), 0 0 12px 14px;
            }

            100% {
                box-shadow: 0 0 8px 6px rgba(207, 8, 8, 0), 0 0 0 40px rgba(0, 0, 0, 0), 0 0 0 40px rgba(207, 8, 8, 0);
            }
        }

        .social-whats-footer {
            position: fixed;
            z-index: 8;
            left: 30px;
            bottom: 30px;
        }

        #whatsapp_widget {
            border: 2px #fff solid;
            border-radius: 50%;
            background-color: #00bc5c;
            padding: 7px;
            color: rgba(31, 173, 83, 0.3);
            box-shadow: 2px 2px 3px rgb(0 0 0 / 66%);
            -webkit-animation: zcwmini2 1.5s 0s ease-out infinite;
            -moz-animation: zcwmini2 1.5s 0s ease-out infinite;
            animation: zcwmini2 1.5s 0s ease-out infinite;
        }

        #whatsapp_widget img {
            margin-left: 2px;
            margin-top: -1px;
        }

        #icon_whatsapp_widget {
            width: 80%;
        }

        .social-whats-footer a {
            display: inline-block !important;
        }

        .text-whats {
            background: #f5791f;
            color: white;
            padding: 5px 10px;
            border-radius: 15px;
            border: 0 !important;
        }
    </style>
    <div class="social-whats-footer">
        <a href="https://api.whatsapp.com/send?phone=+529996461314&amp;text=Hola,%20me%20interesa%20actualizar%20los%20precios%20de%20mi%20cotización%20{{ $cotizacionesRedes->cod_cotizacion }}"
            id="whatsapp_widget" class="whatsapp_widget_big" style="width:43px; height:43px; " target="_blank">
            <img src="{{ url('web/img/icon_whatsApp.png') }}" alt="whatsapp icon" id="icon_whatsapp_widget">
        </a>
        <a href="https://api.whatsapp.com/send?phone=+529996461314&amp;text=Hola,%20me%20interesa%20actualizar%20los%20precios%20de%20mi%20cotización%20{{ $cotizacionesRedes->cod_cotizacion }}"
            target="_blank">
            <span class="text-whats">Solicitar nueva Cotización</span>
        </a>
    </div>
@endif
